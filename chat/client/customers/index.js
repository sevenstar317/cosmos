const angular = require('angular');

var cust = angular.module('app.customers', [])
  .config(require('./customers-routes'))
  .factory('CustomersChat', require('./customers-chat'))
  .controller('CustomersIndexCtrl', require('./customers-index-ctrl'))
  .controller('CustomersRoomsIndexCtrl', require('./customers-rooms-ctrl'))

module.exports = 'app.customers';
