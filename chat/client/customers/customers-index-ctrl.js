var config = require('../config');
const socket = require('socket.io-client')(config.SOCKET_URI);

module.exports = [
    '$q',
    '$stateParams',
    '$scope',
    '$rootScope',
    '$timeout',
    '$window',
    '$location',
    '$state',
    'CustomersChat',
    'ModalService',
    CustomersIndexCtrl
]

function CustomersIndexCtrl($q, $stateParams, $scope, $rootScope, $timeout, $window, $location, $state, CustomersChat, ModalService) {

    /**
     * Public properties
     */
    const vm = this;
    vm.connectCustomer = connectCustomer;
    vm.sendMessage = sendMessage;
    vm.ClickFunction = ClickFunction;
    vm.customer = {};
    vm.messages = [];
    vm.customerConnected = false;
    vm.currentRoom = [];
    vm.rooms = [];
    $scope.timePassed = [];
    $scope.timerRunning = false;
    $scope.timerResumed1Minute = false;
    $scope.timerResumed20Seconds = false;
    vm.typing = false;
    var timeStarted = false;
    $scope.typingInteval = 0;

    /**
     * Private properties
     */
    const { room, agent_id, client_id } = $stateParams;
    $rootScope.stateAgent = $stateParams;

    // Default actions...
    activate();



    ////////////////////

    function getRooms() {
        CustomersChat
            .getRooms(client_id)
            .then(rooms => {
                vm.rooms = rooms
            })
    }

    /**
     * Default actions
     * @return {Void}
     */
    function activate() {
        var deferred = $q.defer();
        /**
         * New customer
         * @type {Object}
         */
        vm.customer = {
            name: '',
            id: ''
        };

        connectCustomer();

        socket.emit('chat.getMessagesInit', room, messages => {
            vm.messages = messages;
        });

    }

    /**
     * Connect customer
     * @return {Void}
     */
    function connectCustomer() {

        vm.customer.id = client_id;
        CustomersChat.connectCustomer(vm.customer, room)
            .then(function ({ customer, room }) {
       //         console.log('new customer', customer);
                vm.customer = customer;
                vm.currentRoom = room;
                if (vm.currentRoom.started_chat_on !== null && typeof vm.currentRoom.started_chat_on != 'undefined') {
                    if (vm.currentRoom.ended_chat_on !== null) {
                        vm.currentRoom.started_chat_on = Date.now();
                    }
                    else {
                        vm.currentRoom.started_chat_on = parseInt(vm.currentRoom.started_chat_on);
                    }
                    $scope.startTimer();
                } else {
                    $scope.showWaitingModal();
                }

                vm.customerConnected = true;


            })
            .then(() => onConnected())
    }

    /**
     * Sends individual message
     * @return {Void}
     */
    function sendMessage() {
        if (typeof vm.message !== 'undefined' && vm.message !== '') {
            CustomersChat.sendMessage(vm.customer, vm.message, room)
                .then(function (message) {
                        vm.messages.push(message);
                        vm.message = '';
                });
            angular.element('#messag').focus();
        }
    }
    
     /**
     * click anywhere event
     * @return {Void}
     */
    
    function ClickFunction (){
        $scope.typingInteval = 0;
    }

    /**
     * When its connected
     * @return {Void}
     */
    function onConnected() {
    //    console.log('customer on connected room:', room);

        // Gets list of messages
        CustomersChat
            .getMessages(room)
            .then(messages => {
                vm.messages = messages;
            });

        // Updates UI when we receive new message
        CustomersChat.addMessageListener(message => {
            $timeout().then(() => {
                    vm.messages.push(message);
            })
        });

        // Updates agent to chat
        CustomersChat.addAgentConnectedListener(agent => {
            $timeout().then(() => {
         //       console.log('agent.connected', agent);
                angular.element('#conn_mod').modal('hide');
                if (vm.currentRoom.started_chat_on === null) {
                    vm.currentRoom.started_chat_on = Date.now();
                }
                $scope.startTimer();
            })
        });

        CustomersChat.addAgentTypingListener(vm.currentRoom.id, function(data,room){
            $timeout().then(() => {
                console.log('typing',data,room);
                if(vm.currentRoom.id == room) {
                    if (data) {
                        $timeout(function () {
                            vm.typing = true;
                        }, 1000);

                    } else {
                        $timeout(function () {
                            vm.typing = false;
                        }, 1000);

                    }
                }
            })

        });

        // Disconnects when scope is destroyed
        $scope.$on('$destroy', () => function () {
            $scope.onExit();
        });

        $scope.onExit = function() {

            $scope.stopTimer();
            var hours = $scope.timePassed.hours;
            var minutes = $scope.timePassed.minutes;
            var seconds = $scope.timePassed.seconds;

                var end_chat_url = $location.protocol() + '://' + $location.host() + '/dashboard/end-chat/' + agent_id + '/' + client_id + '/' + hours + '/' + minutes + '/' + seconds;
                console.log(end_chat_url);
             //   socket.emit('chat.message.short.customer', vm.customer.id, '---------------- Client left the room, You can close the chat. ------------------', vm.currentRoom.id, end_chat_url);
                CustomersChat.disconnectCustomer(vm.customer.id, vm.currentRoom.id, end_chat_url);

        };

        $window.onbeforeunload = $window.pagehide =  $scope.onExit;

    }

    // waiting agent modal
    $scope.showWaitingModal = function () {
        ModalService.showModal({
            templateUrl: 'modal.html',
            controller: function () {
                this.name = vm.customer.agent.name;
            },
            controllerAs : "futurama"
        }).then(function (modal) {
            modal.element.modal();
            modal.element.find('#close_waiting').click(function(){
                CustomersChat.CustomerLeft(client_id, room);
                $window.location.href = $location.protocol() + '://' + $location.host() + '/dashboard';
            });
            modal.close.then(function (result) {
                //  alert(3);
                //   $window.location.href = $location.protocol() + '://' + $location.host() + '/dashboard';
                //   console.log('closed',result,modal);
                $('.modal-backdrop').remove();
            });
        });
    };

    // 1 minute left modal
    
   /* $scope.show30sLeftModal = function () {
        ModalService.showModal({
            templateUrl: '30sLeftModal.html',
            controller: function () {
                $scope.close = function (result) {
                    close(result, 500); // close, but give 500ms for bootstrap to animate
                };
            },
            controllerAs : "worning"
        }).then(function (modal) {
                modal.element.modal();
                modal.close.then(function (result) {
                      $scope.typingInteval = 0;
                       $('warning-modal-id-30').modal('hide');
                });
                  modal.element.find('.warning-button').click(function(){
                        $scope.typingInteval = 0;
                       $('#warning-modal-id-30').modal('hide');
                    });
                modal.element.on('hidden.bs.modal', function () {
                     $('#warning-modal-id-30').modal('hide');
                });

        });
    };*/

    // 1 minute left modal
    $scope.showOneMinuteLeftModalCheckout = function () {
        if(!$('#add-minutes-checkout-modal-id').hasClass('in') && !$('#add-minutes-modal-id-20').hasClass('in')) {
            ModalService.showModal({
                templateUrl: 'OneMinuteLeftModalCheckout.html',
                controller: function () {
                    $scope.close = function (result) {
                        close(result, 500); // close, but give 500ms for bootstrap to animate
                    };
                },
                controllerAs: "simpons2"
            }).then(function (modal) {

                modal.element.modal();
                modal.close.then(function (result) {
                    console.log('closed2');
                });
                modal.element.on('hidden.bs.modal', function () {
                    $scope.timerResumed1Minute = true;
                    $scope.startTimer();
                    $('#add-minutes-checkout-modal-id').modal('hide');
                });

            });
        }
    };

    // 20 seconds left modal
    $scope.show20SecondsLeftModal = function () {
        if(!$('#add-minutes-checkout-modal-id').hasClass('in') && !$('#add-minutes-modal-id-20').hasClass('in')) {
        ModalService.showModal({
            templateUrl: '20SecondsLeftModal.html',
            controller: function () {
                $scope.close = function (result) {
                    close(result, 500); // close, but give 500ms for bootstrap to animate
                };
            },
            controllerAs : "simpons"
        }).then(function (modal) {
                modal.element.modal();
                modal.close.then(function (result) {
                    console.log('closed2');
                });
                modal.element.on('hidden.bs.modal', function () {
                    console.log('closed23', $scope.timerResumed20Seconds);
                    $scope.timerResumed20Seconds = true;
                    $scope.startTimer();
                    $('#add-minutes-modal-id-20').modal('hide');
                });

        });
        }
    };



    //start / resume
    $scope.startTimer = function() {
        if (!timeStarted) {
            $scope.$broadcast('timer-start');
            $scope.timerRunning = true;
            timeStarted = true
        } else if ((timeStarted) && (!$scope.timerRunning)) {
            $scope.$broadcast('timer-resume');
            $scope.timerRunning = true;
        }

    };

    $scope.stopTimer = function() {
        if ((timeStarted) && ($scope.timerRunning)) {
            $scope.$broadcast('timer-stop');
            $scope.timerRunning = false;
        }

    };

    $scope.$on('timer-stopped', function(event, data) {
        $scope.timePassed = data;
        timeStarted = true;
    });

    $scope.$on('timer-tick', function (event, args) {
         if($scope.typingInteval == 30){
            // $scope.show30sLeftModal();
        }
         if($scope.typingInteval == 60){
              $scope.handleClick();
        }
        $scope.typingInteval ++;
        $scope.timerConsole = 'event.name = '+ event.name + ', timeoutId = ' + args.timeoutId + ', millis = ' + args.millis +'\n';
        var milliseconds = args.millis;

        if(parseInt(vm.customer.minutes_balance_millis) <= parseInt(milliseconds) ){
            $scope.handleClick();
        } else {

            if (parseInt(vm.customer.minutes_balance_millis) - 1000 <= parseInt(milliseconds)) {
                console.log('STOP', $scope.timerResumed1Minute, $scope.timerResumed20Seconds);
                $scope.stopTimer();
                if (typeof vm.customer.member_id == 'undefined' || vm.customer.member_id.length < 2) {
                    $scope.showOneMinuteLeftModalCheckout();
                } else {
                    $scope.show20SecondsLeftModal();
                }
            } else {
                if (parseInt(vm.customer.minutes_balance_millis) - 60000 <= parseInt(milliseconds)) {
                    console.log('STOP', $scope.timerResumed1Minute, $scope.timerResumed20Seconds);
                    if (typeof vm.customer.member_id == 'undefined' || vm.customer.member_id.length < 2) {
                        if ($scope.timerResumed1Minute === false) {
                            console.log('STOP customer', vm.customer);
                            $scope.stopTimer();
                            $scope.showOneMinuteLeftModalCheckout();
                        }
                    }
                    else {
                        if ($scope.timerResumed20Seconds === false) {
                            console.log('STOP customer', vm.customer, $scope.timerResumed1Minute);
                            $scope.stopTimer();
                            $scope.show20SecondsLeftModal();
                        }
                    }
                }
            }
        }

    });

    //// end timers

    //// end chat
    $scope.handleClick = function () {
        $scope.stopTimer();

        var hours = $scope.timePassed.hours;
        var minutes = $scope.timePassed.minutes;
        var seconds = $scope.timePassed.seconds;
        var end_chat_url = $location.protocol() + '://' + $location.host() + '/dashboard/end-chat/' + agent_id + '/' + client_id + '/' + hours + '/' + minutes + '/' + seconds;

        CustomersChat.disconnectCustomer(vm.customer.id, vm.currentRoom.id, end_chat_url);
        $window.location.href = $location.protocol() + '://' + $location.host() + '/dashboard/live-chat/';

    }

    var typing = false;
    var timeout = undefined;

    function timeoutFunction(){
        typing = false;
        socket.emit("isTyping", typing, room);
    }

    $scope.typingUser = function () {
        $scope.typingInteval = 0;
        if(typing == false) {
            typing = true;
            socket.emit("isTyping", typing, room);
            timeout = setTimeout(timeoutFunction, 1000);
        } else {
            clearTimeout(timeout);
            timeout = setTimeout(timeoutFunction, 1000);
        }

    }

}
