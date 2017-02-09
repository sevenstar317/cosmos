var config = require('../config');
const socket = require('socket.io-client')(config.SOCKET_URI);

// var socket = io.connect('http://localhost:4000')

module.exports = [
  '$q',
  CustomersChat
]

function CustomersChat($q) {

  var connected = $q.defer();

  socket.on('connect', function() {
    connected.resolve(true);
  });

  /**
   * Connects customer to socket
   * @param  {Object} customer
   * @param  {String} room
   * @return {Promise}
   */
  function connectCustomer(customer, room) {
    var deferred = $q.defer();

    socket.emit('customer.connect', customer, room, function(customer, room) {
    //  console.log('resolving with', customer);
      deferred.resolve({ customer, room });
    });

    return deferred.promise;
  }

  /**
   * Disconnects customer from socket
   * @param  {Object} customer
   * @param  {String} room
   *
   * @return {Promise}
   */
  function disconnectCustomer(client_id, room, end_chat_url) {
    var deferred = $q.defer();

    socket.emit('customer.disconnect', client_id, room, end_chat_url , function(room) {
      deferred.resolve({ room });
    });

    return deferred.promise;
  }
  
  function CustomerLeft(client_id, room) {
    var deferred = $q.defer();

    socket.emit('customer.left', client_id, room , function(room) {
      deferred.resolve({ room });
    });

    return deferred.promise;
  }

  /**
   * Gets list of rooms (agent+user)
   * @return {Promse}
   */
  function getRooms(client_id){

    var deferred = $q.defer();

    socket.emit('both.getRooms', client_id, 'user_id', function (rooms, user) {
      console.log('rooms',rooms.length, client_id);
      deferred.resolve(rooms, user);
    });

    return deferred.promise;

  }

  /**
   * Sends message to chat
   * @param  {Object} customer
   * @param  {String} message
   * @return {Promise}
   */
  function sendMessage(customer, message, room) {

    var deferred = $q.defer();

 //   console.log('sending message', customer, message, room);

    socket.emit('chat.message', customer, message, 'customer', room, function(messages) {
      deferred.resolve(messages);
    });

    return deferred.promise;
  }

  /**
   * Gets list of messages
   * @return {Promise}
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
      cb(msg);
    })
  }

  /**
   * Adds agent listener to chat
   * @param {Function} cb
   */
  function addAgentConnectedListener(cb) {
    socket.on('agent.connected.to.chat', function(agent) {
      cb(agent);
    })
  }


  /**
   * Adds agent online listener
   * @param {Function} cb
   */
  function addAgentOnlineListener(cb) {
    socket.on('agent.online', function(agent) {
      cb(agent);
    })
  }

  /**
   * Adds agent offline listener
   * @param {Function} cb
   */
  function addAgentOfflineListener(cb) {
    socket.on('agent.offline', function(agent) {
      cb(agent);
    })
  }
  
  function addAgentTypingListener(room_id, cb) {
    socket.on("agent.isTyping", function (data, room) {

      cb(data, room);
    });
  }

  return {
    connectCustomer,
    disconnectCustomer,
    sendMessage,
    getMessages,
    getRooms,
    addMessageListener,
    addAgentConnectedListener,
    addAgentOnlineListener,
    addAgentOfflineListener,
    addAgentTypingListener,
    CustomerLeft
  }

}
