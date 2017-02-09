var config = require('../config');
const socket = require('socket.io-client')(config.SOCKET_URI);


module.exports = [
    '$q',
    '$stateParams',
    '$scope',
    '$rootScope',
    '$state',
    '$timeout',
    'CustomersChat',
    CustomersIndexCtrl
]

function CustomersIndexCtrl($q, $stateParams, $scope, $rootScope, $state, $timeout, CustomersChat) {

    const vm = this;

    vm.rooms = [];
    vm.user = [];

    const { client_id } = $stateParams;

    $scope.agentOnline = function (room) {
        return room.agent.status == 'Online' ;
    };

    getRooms();


    ////////////////

    function getRooms() {
        CustomersChat
            .getRooms(client_id)
            .then((rooms, user) => {
                vm.rooms = rooms;
                vm.user = user;
            }).then(() => waitingAgents())
    }

    // Updates UI when agent is online
    function waitingAgents() {
        CustomersChat.addAgentOnlineListener(agent => {
            $timeout().then(() => {
                for (var i = 0; i < vm.rooms.length; i++) {
                    if (vm.rooms[i].agent.id == agent.id) {
                        vm.rooms[i].agent.status = "Online";
                        break;
                    }
                }

            })
        });
        
        CustomersChat.addAgentOfflineListener(agent => {
            $timeout().then(() => {
                for (var i = 0; i < vm.rooms.length; i++) {
                    console.log('$rootScope.stateAgent', $rootScope.stateAgent);
                    if ( typeof $rootScope.stateAgent !== 'undefined') {
                        if(agent.id == $rootScope.stateAgent.agent_id){
                           socket.emit('customer.archive', client_id, vm.rooms[i].id);
                           $state.go('customers-rooms', {client_id: client_id} );
                        }
                    }else{
                       if (vm.rooms[i].agent.id == agent.id) {
                        vm.rooms[i].agent.status = "Offline";
                        break;
                    }
                    }
                }

            })
        });
    }
}
