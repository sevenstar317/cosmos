var config = require('../config');
const socket = require('socket.io-client')(config.SOCKET_URI);

module.exports = [
    '$q',
    '$stateParams',
    '$scope',
    '$rootScope',
    '$timeout',
    '$state',
    '$window',
    '$location',
    'AgentsChat',
    AgentsIndexCtrl
]


function AgentsIndexCtrl($q, $stateParams, $scope, $rootScope,  $timeout, $state, $window, $location, AgentsChat) {

    /**
     * Public properties
     */
    const vm = this;
    vm.connectAgent = connectAgent;
    vm.sendMessage = sendMessage;
    vm.currentPageNumber = currentPageNumber;
    vm.agent = {};
    vm.messages = [];
    vm.currentRoom = [];
    vm.agentConnected = false;
    vm.rooms = [];
    vm.room = [];
    vm.typing = '';
    $scope.pagedItems = [];
    $scope.itemsPerPage = 3;
    
      if (typeof $rootScope.current == 'undefined'){
            $rootScope.current = 0;
        }
      if (typeof $rootScope.activeRooms == 'undefined'){
            $rootScope.activeRooms = [];
        }
    $scope.currentPage = $rootScope.current;

    /**
     * Private properties
     */
    const { room, agent_id, client_id } = $stateParams;

    // Default actions...
    activate();


    ////////////////////

    function getRooms() {
        AgentsChat
            .getRooms(agent_id)
            .then(
                rooms => {
                    if(typeof room !== 'undefined'){
                         for (var i = 0; i < rooms.length; i++) { 
                             if(room == rooms[i].id && rooms[i].chat_status == 'Archived'){
                                  $state.go('agents-rooms', {agent_id: agent_id} ); 
                                  break;
                             }
                         }
                    }
            
                vm.rooms = rooms;
                connectAgent();
            }).then(() => waitingCustemer())
    }
    
    function waitingCustemer(){
                AgentsChat.addUserDisconnectListener((user_id, room_id) => {
                    
            $timeout().then(() => {
                for (var i = 0; i < vm.rooms.length; i++) {
                    if (vm.rooms[i].id == room_id) {
                        vm.rooms[i].chat_status = "Archived";
                        vm.rooms[i].customer_status = "Disconnected";
                        console.log('room id completed', room_id);
                        break;
                    }
                }

            })
        });
    }
    
    
    /**
     * Default actions
     * @return {Void}
     */
    function activate() {
        var deferred = $q.defer();
        /**
         * New agent
         * @type {Object}
         */
        vm.agent = {
            name: '',
            id: ''
        };
        
        getRooms();
        
        socket.emit('chat.getMessagesInit', room, messages => {
          //  console.log('messages',messages);
            vm.messages = messages;
            /**
             *if (vm.messages != null && vm.messages.length <= 0) {
             *   vm.message = "Hi and welcome :heart: My name is " + vm.agent.name + " I am Happy to meet you and talk to you about your personal astrology map which has been generated specifically for you! We can also discuss any questions you have about your life!";
             *   sendMessage();
             * }
             */
        });

    }

    /**
     * Connect agent
     * @return {Void}
     */
    function connectAgent() {
        vm.agent.id = agent_id;

        if(typeof room !== 'undefined') {
            AgentsChat.connectAgent(vm.agent, room)
                .then(function ({ agent, rooms, room }) {
                    vm.agent = agent;
                    vm.rooms = rooms;
                    vm.room = room;
                    for (var i = 0; i < vm.rooms.length; i++) {
                            if (i % $scope.itemsPerPage === 0) {
                                $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)] = [vm.rooms[i] ];
                            } else {
                                $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)].push(vm.rooms[i]);
                            }
                        }

                    for (var i = 0; i < vm.rooms.length; i++) {
                        vm.rooms[i].new_mess_count = "";
                        $rootScope.activeRooms[i] = vm.rooms[i].id;
                    }

                    if (vm.room.ended_chat_on !== null) {
                        vm.room.started_chat_on = Date.now();
                    }
                    else {
                        if (vm.room.started_chat_on !== null) {
                            vm.room.started_chat_on = parseInt(vm.room.started_chat_on);
                        } else {
                            if (vm.room.started_chat_on === null && (vm.room.ended_chat_on === null)) {
                                vm.room.started_chat_on = Date.now();
                            }
                        }
                    }

                    if (typeof room.chat_status != 'undefined' && room.chat_status != null && 'Completed' != room.chat_status) {
                        $scope.startTimer();
                    }

                    vm.agentConnected = true;

                })
                .then(()=>sendMessage())
                // .then(()=>getRooms())
                .then(() => onConnected());
        }

        // Updates UI when we receive new room
        AgentsChat.addRoomListener(agent_id,
            room => {
                $timeout().then(() => {
                    if (room.agent_id == agent_id) {
                        var flag = false;
                        for (var i = 0; i < vm.rooms.length; i++) {
                            if (room.id == vm.rooms[i].id) {
                                vm.rooms[i] = room;
                                flag = true;
                             }
                            if (vm.room.id == room.id) {
                                AgentsChat.connectAgent(vm.agent, room)
                                    .then(function ({ agent, rooms, room }) {

                                        vm.agent = agent;
                                        vm.rooms = rooms;
                                        vm.room = room;
                                        
                                        for (var i = 0; i < vm.rooms.length; i++) {
                                                if (i % $scope.itemsPerPage === 0) {
                                                    $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)] = [vm.rooms[i] ];
                                                } else {
                                                    $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)].push(vm.rooms[i]);
                                                }
                                            }
                                            
                                        for (var i = 0; i < vm.rooms.length; i++) {
                                            vm.rooms[i].new_mess_count = "";
                                            $rootScope.activeRooms[i] = vm.rooms[i].id;
                                            
                                        }

                                        if (vm.room.ended_chat_on !== null) {
                                            vm.room.started_chat_on = Date.now();
                                        }
                                        else {
                                            if (vm.room.started_chat_on !== null) {
                                                vm.room.started_chat_on = parseInt(vm.room.started_chat_on);
                                            } else {
                                                if (vm.room.started_chat_on === null && (vm.room.ended_chat_on === null)) {
                                                    vm.room.started_chat_on = Date.now();
                                                }
                                            }
                                        }

                                        if (typeof room.chat_status != 'undefined' && room.chat_status != null && 'Completed' != room.chat_status) {
                                            $scope.startTimer();
                                        }

                                        vm.agentConnected = true;

                                    })
                            }
                        }
                        if(flag === false){
                            vm.rooms.push(room);
                        }
                    }
                })
            });
    }


    /**
     * Sends individual message
     * @return {Void}
     */
    function sendMessage() {
        if (typeof vm.message !== 'undefined' && vm.message !== '') {
            AgentsChat.sendMessage(vm.agent, vm.message)
                .then(function (message) {
                    vm.messages.push(message);
                    vm.message = '';
                    var myEl = angular.element(document.querySelector('.emoji-wysiwyg-editor'));
                    myEl.html('').text('');
                });
        }
    }

    /**
     * When its connected
     * @return {Void}
     */
    function onConnected() {

        // Gets list of messages
        /*
        AgentsChat
            .getMessages()
            .then(messages => {

                vm.messages = messages;
            });
            */

        // Updates UI when we receive new message
        AgentsChat.addMessageListener(message => {
            $timeout().then(() => {
                if (message.room_id == vm.room.id) {
                    vm.messages.push(message);
                }
            })
        });


        // Updates UI when we receive new message at any room
        AgentsChat.addAnyMessageListener(vm.agent.id, info => {
            $timeout().then(() => {
                for (var i = 0; i < vm.rooms.length; i++) {
                    if (vm.rooms[i].id == info.id) {
                        vm.rooms[i].new_mess_count = "!";
                        break;
                    }
                }
                console.log('agent index mes ', info);
            })
        });

        AgentsChat.addUserTypingListener(vm.room.id,  function(data,room){
            $timeout().then(() => {
                if(vm.room.id == room) {
                    if (data) {
                        $timeout(function () {
                            vm.typing = 'User is typing...';
                        }, 1000);

                    } else {
                        $timeout(function () {
                            vm.typing = '';
                        }, 1000);

                    }
                }
            })
        });

        AgentsChat.addUserOnlineListener((user_id,room_id) => {
            $timeout().then(() => {
                console.log('user.online', user_id);
                if(vm.room.id == room_id) {
                    console.log('user online',user_id);
                    vm.room.customer_status = 'Connected';
                    vm.room.chat_status = "Active";
                }
                for (var i = 0; i < vm.rooms.length; i++) {
                    if (vm.rooms[i].id == room_id) {
                        vm.rooms[i].chat_status = "Active";
                        vm.rooms[i].customer_status = "Connected";
                        break;
                    }
                }

            })
        });
        AgentsChat.addUserOfflineListener((user_id, room_id) => {
             console.log('user ofline',user_id);
            $timeout().then(() => {
                console.log('user.offline', user_id);
                if(vm.room.id == room_id) {
                    vm.room.customer_status = 'Disconnected';
                    $rootScope.activeRooms = $rootScope.activeRooms.filter(function(activeRooms) {
                                 return activeRooms != room_id;
                        });
                }
                  $timeout(function () {
                           socket.emit('customer.archive', user_id, room_id);
                           if($rootScope.activeRooms.length >= 1){
                               if($rootScope.activeRooms.length == 1){
                                    $state.go('agents', {room: $rootScope.activeRooms[0], agent_id: vm.agent.id, client_id: ''} ); 
                               }else{
                                    $state.go('agents', {room: room, agent_id: agent_id, client_id: client_id} ); 
                               }
                           } else{
                               $state.go('agents-rooms', {agent_id: vm.agent.id} ); 
                           }
                        }, 30000);
                $scope.stopTimer();
                for (var i = 0; i < vm.rooms.length; i++) {
                    if (vm.rooms[i].id == room_id) {
                        vm.rooms[i].chat_status = "Completed";
                        vm.rooms[i].customer_status = "Disconnected";
                        console.log('room id completed', room_id);
                        break;
                    }
                }

            })
        });
        
        // Disconnects when scope is destroyed
        $scope.$on('$destroy', () => function(){ AgentsChat.disconnectAgent(vm.agent, vm.room.id);})

    }

    // timers
    $scope.startTimer = function () {
        $scope.$broadcast('timer-start');
        $scope.timerRunning = true;
    };

    $scope.stopTimer = function () {
        $scope.$broadcast('timer-stop');
        $scope.timerRunning = false;
    };
    //// end timers
    
    //// popups
    $scope.popupWindow1 = function(itemId) {
        $window.open('https://connect.livecosmos.com/chat-advisor/sign1/' + itemId,'_blank');
    }

    $scope.popupWindow2 = function(itemId) {
        $window.open('https://connect.livecosmos.com/chat-advisor/sign2/' + itemId,'_blank');
    }

    //// end popups


    //logout agent event
    $scope.logoutAgent = function () {
        AgentsChat.disconnectAgent(vm.agent, room);
        $window.location.href = $location.protocol() + '://' + $location.host() + '/chat-advisor/logout';

    };

    // filter
    $scope.chatActiveOrCompleted = function (room) {
        return room.chat_status == 'Completed' || room.chat_status == 'Active';
    };

    var typing = false;
    var timeout = undefined;

    function timeoutFunction(){
        typing = false;
        socket.emit("agentisTyping", typing, room);
    }

    $scope.typingAgent = function () {
        if(typing == false) {
            typing = true;
            socket.emit("agentisTyping", typing, room);
            timeout = setTimeout(timeoutFunction, 1000);
        } else {
            clearTimeout(timeout);
            timeout = setTimeout(timeoutFunction, 1000);
        }

    }
    
       $scope.prevPage = function () {
        if ($scope.currentPage > 0) {
            $scope.currentPage--;
        }
    };
    
    $scope.nextPage = function () {
        if ($scope.currentPage < $scope.pagedItems.length - 1) {
            $scope.currentPage++;
        }
    };
    
  
    function currentPageNumber (currentPage) {
            $rootScope.current = currentPage;
     };

}
