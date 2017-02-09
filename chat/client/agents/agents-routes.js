module.exports = [
  '$stateProvider',
  function($stateProvider) {

    $stateProvider.state('agents', {
      url: '/agents/:room/:agent_id/:client_id',
      controller: 'AgentsIndexCtrl',
      controllerAs: 'vm',
      templateUrl: '/chat-advisor/test-chat'
    });

    $stateProvider.state('agents-rooms', {
      url: '/agents/:agent_id',
      controller: 'AgentsIndexCtrl',
      controllerAs: 'vm',
      templateUrl: '/chat-advisor/test-chat-room'
    })

  }
];
