var config = require('../config');
const socket = require('socket.io-client')(config.SOCKET_URI);


module.exports = [
  '$q',
  '$scope',
  'AgentsChat',
  AgentsRoomIndexCtrl
]

function AgentsRoomIndexCtrl($q, $scope, AgentsChat) {

  const vm = this;

  vm.rooms = [];

  getRooms();

  ////////////////


  function getRooms(){
    AgentsChat
        .getRooms()
        .then(rooms => {
          vm.rooms = rooms
        })
  }

  function activate() {


  }

}
