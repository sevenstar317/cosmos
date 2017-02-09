module.exports = [
  '$stateProvider',
  function($stateProvider) {

    $stateProvider.state('customers', {
      url: '/customers/:room/:agent_id/:client_id',
      controller: 'CustomersIndexCtrl',
      controllerAs: 'vm',
      templateUrl: '/dashboard/test-chat',

    })

    $stateProvider.state('customers-rooms', {
      url: '/customers/:client_id',
      controller: 'CustomersRoomsIndexCtrl',
      controllerAs: 'vm',
      templateUrl: '/dashboard/client-rooms',
    })


  }
]
