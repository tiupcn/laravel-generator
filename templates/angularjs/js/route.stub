angular.module('app').config(['$stateProvider',"$urlRouterProvider", function($stateProvider, $urlRouterProvider){
	$urlRouterProvider.otherwise('index');
	$stateProvider
		//generator begin
        .state('show', {
            url: '/show',
            templateUrl: '/static/pages/show/index.html',
            resolve: load(['/static/pages/show/index.js'])
        })
        //generator end
        .state('index', {
            url: '/index',
            templateUrl: '/static/pages/index/index.html',
            resolve: load(['/static/pages/index/index.js'])
        });
    function load(srcs, callback){
        return {
            deps: ['$ocLazyLoad', '$q', function( $ocLazyLoad, $q ){
                var deferred = $q.defer();
                var promise = deferred.promise;
                angular.forEach(srcs, function(src) {
                    console.info(src);
                    promise = promise.then(function(){
                        return $ocLazyLoad.load(src);
                    })
                    
                });
                deferred.resolve();
                return callback ? promise.then(function(){ return callback(); }) : promise;
            }]
        }
    }
}]);
