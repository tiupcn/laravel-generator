//service.js

angular.module('app')
    .factory('R', ["$http", "$q", "$resource", function($http, $q, $resource){
        var _trans = function(method, url, data){
            var deferred = $q.defer();
            $http({
                method: method,
                url: url,
                data: data
            }).success(function(data){
                deferred.resolve(data);
            }).error(function(){
                alert("网络出问题啦，刷新试试~ ");
            });
            return deferred.promise;
        }
    }])
    .factory('Resource', ['$resource', function($resource) {
        return function(url, params) {
            var methods = {
                'update': {
                    method: 'PATCH',
                },
            }
            var resource = $resource( url, params, methods );
            return resource;
        };
    }])
    .factory('Rest', ['Resource', function($resource){
        return {
            create: function(url, data){
                return $resource('/api/'+ url, data);
            } 
        }
    }])