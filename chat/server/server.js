var express = require('express')
    , cors = require('cors')
    , app = express();


var Sequelize = require('sequelize/index.js');

app.use(cors());

var fs = require('fs');
var port = 4300;
var request = require('request');

var options = {
    key: fs.readFileSync('server.key'),
    cert: fs.readFileSync('server.cert')
};

if (process.env.APP_ENV === 'local') {
    var server = require('http').createServer(app);
} else {
    var server = require('https').createServer(options, app);
}
var io = require('socket.io')(server);

//var redis = require('socket.io-redis');

//io.adapter(redis({host: '127.0.0.1', port: 6379}));

if (process.env.APP_ENV === 'local') {
    server.listen(port, function () {
        console.log('Server listening at port %d', port);
    });
} else {
    server.listen(port, function () {
        console.log('Https Server listening at port %d', port);
    });
}

app.get('/', function (req, res) {
    res.send('hello world')
})

// Routing
//app.use(express.static(__dirname + '/public_chat'));

var whoami = null;
var whoamiType = null;

var agents = [];
var rooms = [];
var customers = [];
var currentChats = [];
var user = [];

var isCLient = 0;

//var mysql = require('mysql'),
//   mysqlUtilities = require('mysql-utilities');
//
//var db_config = {
//    host: process.env.DB_HOST,
//   user: process.env.DB_USERNAME,
//    password: process.env.DB_PASSWORD,
//    database: process.env.DB_DATABASE,
//};

var sequelize = new Sequelize(process.env.DB_DATABASE, process.env.DB_USERNAME, process.env.DB_PASSWORD, {
    host: process.env.DB_HOST,
    dialect: 'mysql',
    logging: false,
    pool: {
        max: 5,
        min: 0,
        idle: 10000
    },

});

//var database = mysql.createPool(db_config);

io.on('connection', function (socket) {

    var agentRoom;

    var Rooms = sequelize.define('agent_user',
        {
            agent_id: {type: Sequelize.INTEGER},
            user_id: {type: Sequelize.INTEGER},
            chat_status: {type: Sequelize.INTEGER},
            started_chat_on: {type: Sequelize.STRING},
            ended_chat_on: {type: Sequelize.STRING},
            started_chat: {type: Sequelize.STRING},
            ended_chat: {type: Sequelize.STRING},
            paid_for_email: {type: Sequelize.STRING},
            customer_status: {type: Sequelize.STRING},
        },
        {
            freezeTableName: true, timestamps: false, underscored: true

        });

    var Messages = sequelize.define('chat_messages',
        {
            chat_id: {type: Sequelize.INTEGER},
            sender_id: {type: Sequelize.INTEGER},
            message: {type: Sequelize.TEXT},
            sender_type: {type: Sequelize.STRING},
            status: {type: Sequelize.STRING},
        },
        {
            freezeTableName: true, timestamps: true, underscored: true,
            createdAt: 'created_at',
            updatedAt: 'updated_at'
        });

    var Agent = sequelize.define('agents',
        {
            name: {type: Sequelize.STRING},
            email: {type: Sequelize.STRING},
            first_name: {type: Sequelize.STRING},
            status: {type: Sequelize.STRING},
            image: {type: Sequelize.STRING},
            speciality_1: {type: Sequelize.STRING},
            speciality_2: {type: Sequelize.STRING},
            speciality_3: {type: Sequelize.STRING},
            speciality_4: {type: Sequelize.STRING},
            speciality_5: {type: Sequelize.STRING},
            last_name: {type: Sequelize.STRING}
        },
        {
            freezeTableName: true, timestamps: true, underscored: true,
            createdAt: 'created_at',
            updatedAt: 'updated_at'
        });

    var User = sequelize.define('users',
        {
            name: {type: Sequelize.STRING},
            email: {type: Sequelize.STRING},
            first_name: {type: Sequelize.STRING},
            last_name: {type: Sequelize.STRING},
            sign: {type: Sequelize.STRING},
            state: {type: Sequelize.STRING},
            city: {type: Sequelize.STRING},
            member_id: {type: Sequelize.STRING},
            minutes_balance: {type: Sequelize.STRING},
            birth_time: {type: Sequelize.STRING},
            birth_day: {type: Sequelize.STRING},
            birth_month: {type: Sequelize.STRING},
            birth_year: {type: Sequelize.STRING},
            sex: {type: Sequelize.STRING},
            lat: {type: Sequelize.STRING},
            lan: {type: Sequelize.STRING},
        },
        {
            freezeTableName: true, timestamps: true, underscored: true,
            createdAt: 'created_at',
            updatedAt: 'updated_at'
        });

    Rooms.belongsTo(Agent);
    Rooms.belongsTo(User);

    socket.on('both.getRooms', function (user_id, id_field, cb) {

        if (id_field === 'user_id') {
            var where = {user_id: user_id};
            isCLient = 1;
        } else {
            var where = {agent_id: user_id};
        }
        //  console.time('test');

        Rooms.findAll({
            where: where,
            include: [{
                model: Agent,
                required: true,
                underscored: true,
                foreignKey: 'id', targetKey: 'agent_id'
            },
            {
                model: User,
                required: true,
                underscored: true,
                foreignKey: 'id', targetKey: 'user_id'
            }]
        }).then(function (rooms2) {
            rooms = rooms2;

            if (id_field === 'user_id') {
                User.findOne({where: {id: user_id}}).then(function (user2) {
                    user = user2;
                    console.log('----get rooms from deffered: ', rooms.length, 'user id',user_id);
                    cb(rooms, user);
                });
            } else {
                Agent.findOne({where: {id: user_id}}).then(function (agent2) {
                    user = agent2;
                    console.log('----get rooms from deffered: ', rooms.length, 'agent id', user_id);
                    socket.broadcast.emit('agent.online', user);
                    cb(rooms, user);
                });
            }
        });
        //  console.timeEnd('test'); //Prints something like that-> test: 11374.004ms

    });

    socket.on('agent.connect', function (agent, room, cb) {

        // Joins room
        agentRoom = room;
        socket.join(agentRoom);

        // Create chat room
        if (!currentChats[agentRoom]) {
            currentChats[agentRoom] = [];
        }

        Rooms.findAll({
            where: {
                agent_id: agent.id,
                //!== Active
                chat_status: {
                    $notIn: ['Completed', 'Draft', 'Archived']
                }
            },
            include: [{
                model: Agent,
                required: true,
                underscored: true,
                foreignKey: 'id', targetKey: 'agent_id'
            },
            {
                model: User,
                required: true,
                underscored: true,
                foreignKey: 'id', targetKey: 'user_id'
            }]
        }).then(function (rooms2) {

            rooms = rooms2;

            var flag = false;
            var new_room = [];
            for (var i = 0; i < rooms.length; i++) {
                if (rooms[i].id == room) {
                    new_room = rooms[i];
                    if (rooms[i].chat_status !== 'Active') {
                        rooms[i].chat_status = 'Active';
                        rooms[i].new_mess_count = "";
                        flag = true;
                    }
                }
            }

            if (flag === true) {

                Rooms.update(
                    {
                        chat_status: 'Active',
                        started_chat_on: Date.now(),
                        ended_chat_on: null,
                        started_chat: (new Date()).toISOString().substring(0, 19).replace('T', ' ')
                    },
                    {
                        where: {id: room}
                    })
                    .then(function (result) {

                        var agent_id = agent.id;

                        // getting current agent info
                        Agent.findOne({where: {id: agent_id}}).then(function (agent2) {

                            agent.email = agent2.email;
                            agent.full_name = agent2.first_name + ' ' + agent2.last_name;
                            agent.name = agent2.name;
                            agent.status = agent2.status;

                            if (room !== null && typeof room !== 'undefined') {
                                socket.broadcast.to(room).emit('agent.connected.to.chat', agent);
                            }

                            cb(agent, rooms, new_room);

                            console.log('agent to room', room, agentRoom, rooms.length);

                        });
                    }, function (rejectedPromiseError) {
                        console.log('rejectedPromiseError', rejectedPromiseError);
                    });

            } else {
                var agent_id = agent.id;

                // getting current agent info
                Agent.findOne({where: {id: agent_id}}).then(function (agent2) {

                    agent.email = agent2.email;
                    agent.full_name = agent2.first_name + ' ' + agent2.last_name;
                    agent.name = agent2.name;
                    agent.status = agent2.status;

                    cb(agent, rooms, new_room);

                    console.log('agent to room', room, agentRoom, rooms.length, agents.length);

                    if (room !== null && typeof room !== 'undefined') {
                        socket.broadcast.to(room).emit('agent.connected.to.chat', agent);
                        //  } else {
                        //    socket.broadcast.emit('agent.online', agent);
                    }
                });
            }
        });

    });

    socket.on('agent.disconnect', function (agent, room, cb) {

        socket.broadcast.emit('agent.offline', agent);
        // Leaves room
        socket.leave(room);

        console.log('agent left the room',agent, room);
        if (cb) {
            cb();
        }
    });
    
    socket.on('customer.left', function (client_id, room, cb) {

        socket.broadcast.emit('user.disconnected', client_id, room);
        // Leaves room
        socket.leave(room);

        
        if (cb) {
            cb();
        }
    });

    socket.on('customer.disconnect', function (client_id,  room, end_chat_url, cb) {
        // Leaves room
        
       
        socket.leave(room);

        console.log(client_id, room, end_chat_url);
        var room_id = room;

        var sender_type = 'customer';
        whoamiType = sender_type;

        var sender = [];
        // getting current agent info
        for (var i = 0; i < customers.length; i++) {
            if (customers[i].id == client_id) {
                sender = customers[i];
                break;
            }
        }


        Rooms.update(
            {
                customer_status: 'Disconnected'
            },
            {
                where: {id: room_id}
            })
            .then(function (result) {


                var curr_room;
                for (var i = 0; i < rooms.length; i++) {
                    if (rooms[i].id == room_id) {
                        curr_room = rooms[i];
                        rooms[i].new_mess_count = "!";
                        break;
                    }
                }

                if (end_chat_url != null && typeof end_chat_url != 'undefined') {
                    request({
                        url: end_chat_url,
                        method: "GET",
                        json: true,
                        headers: {
                            "content-type": "application/json",
                        }
                    }, function (error, response, body) {
                        if (!error && response.statusCode == 200) {
                            console.log(body) // Show the HTML for the Google homepage.
                        } else {
                            console.log(error, response);
                        }
                    })
                }


                if (typeof currentChats === 'undefined') {
                    currentChats = [];
                }
                if (!currentChats[room_id]) {
                    currentChats[room_id] = [];
                }


                socket.broadcast.to(room_id).emit('user.offline', client_id, room_id);

                console.log('customer left the room', room);
                if (cb) {
                    cb();
                }

            }, function (rejectedPromiseError) {
                console.log('rejectedPromiseError', rejectedPromiseError);
            });


    });
    
        socket.on('customer.archive', function (client_id,  room,  cb) {
     
        var room_id = room;

        var sender_type = 'customer';
        whoamiType = sender_type;



        Rooms.update(
            {
                chat_status: 'Archived',
                customer_status: 'Disconnected',
            },
            {
                where: {id: room_id}
            })
            .then(function (result) {
              
                if (cb) {
                    cb();
                }

            }, function (rejectedPromiseError) {
                console.log('rejectedPromiseError', rejectedPromiseError);
            });


    });

    socket.on('customer.connect', function (customer, room, cb) {
        whoami = customer;
        whoamiType = 'customer';

        agentRoom = room;
        socket.join(agentRoom);

        User.findOne({where: {id: customer.id}}).then(function (user2) {
            user = user2;

            // Create chat room
            if (typeof currentChats !== 'undefined' && !currentChats[agentRoom]) {
                currentChats[agentRoom] = [];
            }

            console.log('customer to room', room);

            var customer_id = customer.id;

            // getting currect customer info

            customer.email = user.email;
            customer.full_name = user.first_name + ' ' + user.last_name;
            customer.name = user.name;
            customer.member_id = user.member_id;
            customer.minutes_balance = user.minutes_balance;
            var millis_balance = 0;
            var arraya = user.minutes_balance.split(':');
            millis_balance += parseInt(arraya[0]) * 3600;
            millis_balance += parseInt(arraya[1]) * 60;
            millis_balance += parseInt(arraya[2]);
            millis_balance = millis_balance * 1000;

            customer.minutes_balance_millis = millis_balance;


            var new_room = [];
            var agent_id = '';

            Rooms.findOne({
                where: {id: room},
                include: [{
                    model: Agent,
                    required: true,
                    underscored: true,
                    foreignKey: 'id', targetKey: 'agent_id'
                },
                {
                    model: User,
                    required: true,
                    underscored: true,
                    foreignKey: 'id', targetKey: 'user_id'
                }]
            }).then(function (room3) {
                new_room = room3;
                agent_id = room3.agent_id;
                customer.agent = room3.agent;

                socket.broadcast.to(room3.id).emit('user.online', user.id, room3.id);

//&& new_room.chat_status !== 'Completed'
                if (new_room.chat_status !== 'Active') {

                    Rooms.update(
                        {
                            chat_status: 'Pending',
                            customer_status: 'Connected',
                            updated_at:Date.now()
                        },
                        {
                            where: {id: room}
                        })
                        .then(function (result) {
                            new_room.chat_status = 'Pending';
                            new_room.customer_status = 'Connected';
                            // Sends to other users
                            socket.broadcast.emit('chat.newRoom', new_room, agent_id);

                            cb(customer, new_room);
                        }, function (rejectedPromiseError) {
                            console.log('rejectedPromiseError', rejectedPromiseError);
                        });

                }

            });

        });

    });

    socket.on('customer.requestAgents', function () {
        socket.broadcast.emit('customer.getAgents', agents);
    });

    socket.on('agent.requestCustomers', function () {
        socket.broadcast.emit('agent.getCustomers', customers);
    });


    socket.on('chat.init', function (customer) {
        var currentChat = {
            id: (chats.length + 1),
            customer: customer,
            agent: agents[0]
        };

        chats.push(currentChat);
        socket.broadcast.emit(currentChat);
    });

    socket.on('chat.getMessages', function (cb) {
        cb(currentChats[agentRoom])

    });


    socket.on('chat.getMessagesInit', function (room, cb) {
        agentRoom = room;
        /*if (typeof currentChats === 'undefined') {
         currentChats = [];
         currentChats[agentRoom] = [];
         } else if (!currentChats[agentRoom]) {
         currentChats[agentRoom] = [];
         }
         cb(currentChats[agentRoom])
         */
        Messages
            .findAll({
                where: {
                    chat_id: agentRoom
                }
            }).then(function (messages) {
            cb(messages);
        });
    });

    socket.on('chat.message', function (sender, message, sender_type, room, cb) {

        console.log('sender', sender.id);
        console.log('sender_type', sender_type);
        whoamiType = sender_type;
        //  console.log('message', message)


        if (typeof agentRoom == 'undefined' || agentRoom == null) {
            agentRoom = room;
        }

        var msg = {
            when: new Date(),
            sender: sender,
            sender_type: sender_type,
            message: message,
            room_id: agentRoom
        };


        Messages
            .create({
                created_at: (new Date()).toISOString().substring(0, 19).replace('T', ' '),
                chat_id: agentRoom,
                sender_id: sender.id,
                message: message,
                sender_type: sender_type,
                status: 'Sent'
            })
            .then(function () {

            }, function (rejectedPromiseError) {
                console.log('rejectedPromiseError', rejectedPromiseError);
            });


        var curr_room;
        for (var i = 0; i < rooms.length; i++) {
            if (rooms[i].id == agentRoom) {
                msg.recever_id = rooms[i].agent_id;
                curr_room = rooms[i];
                rooms[i].new_mess_count = "!";
                break;
            }
        }

        if (typeof currentChats === 'undefined') {
            currentChats = [];
        }
        if (!currentChats[agentRoom]) {
            currentChats[agentRoom] = [];
        }

        // Adds to current list of chats
        currentChats[agentRoom].push(msg);
        //  console.log(currentChats);
        //  console.log('we now have', currentChats[agentRoom].length, 'messages');

        // Lets sender know we received it
        cb(msg);

        console.log('agentRoom ', agentRoom);
        // Sends to other users
        socket.broadcast.to(agentRoom).emit('chat.message', msg);

        socket.broadcast.to(agentRoom).emit('chat.newMessage', curr_room);
    });

    socket.on("isTyping", function (isTyping, room, cb) {
        socket.broadcast.to(room).emit('user.isTyping', isTyping, room);
    });
    socket.on("agentisTyping", function (isTyping, room, cb) {
        socket.broadcast.to(room).emit('agent.isTyping', isTyping, room);
    });


    /*
    socket.on('chat.message.short.customer', function (client_id, message, room_id, end_chat_url, cb) {

        var sender_type = 'customer';
        //  console.log('sender', client_id);
        //  console.log('sender_type', sender_type);
        whoamiType = sender_type;
        //  console.log('message', message)

        var sender = [];
        // getting current agent info
        for (var i = 0; i < customers.length; i++) {
            if (customers[i].id == client_id) {
                sender = customers[i];
                break;
            }
        }

        var msg = {
            when: new Date(),
            sender: sender,
            sender_type: sender_type,
            message: message,
            room_id: room_id
        };

        Messages
            .create({
                created_at: (new Date()).toISOString().substring(0, 19).replace('T', ' '),
                chat_id: room_id,
                sender_id: client_id,
                message: message,
                sender_type: sender_type,
                status: 'Sent'
            })
            .then(function () {

            }, function (rejectedPromiseError) {
                console.log('rejectedPromiseError', rejectedPromiseError);
            });


        var curr_room;
        for (var i = 0; i < rooms.length; i++) {
            if (rooms[i].id == room_id) {
                msg.recever_id = rooms[i].agent_id;
                curr_room = rooms[i];
                rooms[i].new_mess_count = "!";
                break;
            }
        }

        if (end_chat_url != null && typeof end_chat_url != 'undefined') {
            request({
                url: end_chat_url,
                method: "GET",
                json: true,
                headers: {
                    "content-type": "application/json",
                }
            }, function (error, response, body) {
                if (!error && response.statusCode == 200) {
                    console.log(body) // Show the HTML for the Google homepage.
                } else {
                    console.log(error, response);
                }
            })
        }


        if (typeof currentChats === 'undefined') {
            currentChats = [];
        }
        if (!currentChats[room_id]) {
            currentChats[room_id] = [];
        }

        currentChats[room_id].push(msg);
        //  console.log('we now have', currentChats[room_id].length, 'messages');
        //  console.log('agentRoom ',room_id);

        // Sends to other users
        socket.broadcast.to(room_id).emit('chat.message', msg);

        socket.broadcast.to(room_id).emit('chat.newMessage', curr_room);
    });
*/
});
