angular.module('app').config(['$stateProvider',"$urlRouterProvider", function($stateProvider, $urlRouterProvider){
	$urlRouterProvider.otherwise('app/index');
	$stateProvider
		//generator begin
        .state('app', {
            abstract: true,
            url: '/app',
            templateUrl: '/static/pages/app/app.html'
        })
        //generator end
        .state('app.index', {
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
