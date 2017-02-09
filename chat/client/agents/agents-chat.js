var config = require('../config');
const socket = require('socket.io-client')(config.SOCKET_URI);


// var socket = io.connect('http://localhost:4000')

module.exports = [
  '$q',
  AgentsChat
]

function AgentsChat($q) {

  var connected = $q.defer();

  socket.on('connect', function() {
    connected.resolve(true);
  });

  /**
   *
   * Connects agent to socket
   * @param  {Object} agent
   * @param  {String} room
   * @return {Promise}
   */
  function connectAgent(agent, room) {
    var deferred = $q.defer();

    socket.emit('agent.connect', agent, room, function(agent, rooms, room) {
      console.log('resolving with', agent);
      deferred.resolve({ agent, rooms, room });
    });

    return deferred.promise;
  }

  /**
   * Disconnects agent from socket
   * @param  {Object} agent
   * @param  {String} room
   * @return {Promise}
   */
  function disconnectAgent(agent, room) {
    var deferred = $q.defer();

    socket.emit('agent.disconnect', agent, room, function(agent, room) {
      deferred.resolve({agent,  room });
    });

    return deferred.promise;
  }

  /**
   *
   * Sends message to chat
   * @param  {Object} agent
   * @param  {String} message
   * @return {Promise}
   */
  function sendMessage(agent, message) {

    var deferred = $q.defer();

    console.log('sending message', agent, message);

    socket.emit('chat.message', agent, message, 'agent' , null ,function(messages) {
      deferred.resolve(messages);
    });

    return deferred.promise;
  }

  /**
   * Gets list of rooms (agent+user)
   * @return {Promse}
   */
  function getRooms(agent_id){

    var deferred = $q.defer();

    socket.emit('both.getRooms',agent_id, 'agent_id', function (rooms) {
      deferred.resolve(rooms);
    });

    return deferred.promise;

  }

  /**
   * Gets list of messages
   * @return {Promse}
   */
  function getMessages() {
    console.log('getting messages!');
    return connected
      .promise
        .then(function() {

          console.log('connected')

          var deferred = $q.defer();

          socket.emit('chat.getMessages', messages => {
            deferred.resolve(messages);
          })

          return deferred.promise;
        })
  }

  /**
   * Adds message listener
   * @param {Function} cb
   */
  function addMessageListener(cb) {
    socket.on('chat.message', function(msg) {
      //was refresh

      cb(msg);
    })
  }


  /**
   * Adds User online listener
   * @param {Function} cb
   */
  function addUserOnlineListener(cb) {
    socket.on('user.online', function(user,room) {
      cb(user,room);
    })
  }
  
  function addUserDisconnectListener(cb) {
    socket.on('user.disconnected', function(user,room) {
      cb(user,room);
    })
  }

  /**
   * Adds User offline listener
   * @param {Function} cb
   */
  function addUserOfflineListener(cb) {
    socket.on('user.offline', function(user,room) {
      cb(user,room);
    })
  }
  
  /**
   * Adds new room (user) listener
   * @param {Function} cb
   */

  function addRoomListener(agent_id, cb) {
    socket.on('chat.newRoom', function(room) {
      console.log('not got new room', room, room.agent_id, agent_id, room.chat_status);
      if(agent_id == room.agent_id && room.chat_status == 'Pending'){
        console.log('got new room', room.chat_status);
       // window.location.reload();
        cb(room);
      }
    })
  }

  /**
   * Adds new room (user) listener
   * @param {Function} cb
   */

  function addUserTypingListener(room_id, cb) {
    socket.on("user.isTyping", function (data, room) {
      cb(data,room);
    });
  }

  /**
   * Adds new room (user) listener
   * @param {Function} cb
   */

  function addAnyMessageListener(agent_id, cb) {
    socket.on('chat.newMessage', function(room) {
    //  console.log('not got new any mess', room, room.agent_id, agent_id, room.chat_status);
      if(agent_id == room.agent_id ){
     //   console.log('got new any mess', room);
        cb(room);
      }
    })
  }

  return {
    connectAgent,
    disconnectAgent,
    sendMessage,
    getMessages,
    getRooms,
    addMessageListener,
    addRoomListener,
    addAnyMessageListener,
    addUserTypingListener,
    addUserOnlineListener,
    addUserOfflineListener,
    addUserDisconnectListener
  }

}
