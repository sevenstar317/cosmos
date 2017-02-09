const angular = require('angular');

var age = angular.module('app.agents', [])
  .config(require('./agents-routes'))
  .factory('AgentsChat', require('./agents-chat'))
  .controller('AgentsIndexCtrl', require('./agents-index-ctrl'))
//.controller('AgentsRoomsIndexCtrl', require('./agents-rooms-ctrl'))


module.exports = 'app.agents';
