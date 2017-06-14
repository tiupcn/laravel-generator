//service.js

angular.module('app')
    .factory('R', function(Restangular) {
      return Restangular.withConfig(function(RestangularConfigurer) {
        RestangularConfigurer.setBaseUrl('/api/');
      });
    });