var app = angular.module('app',[
		require('angular-ui-router'),
		require('oclazyload'),
		require('angular-resource')
	]);
require('./config.lazyload.js');
require('./config.route.js');

app.controller('AppCtrl',['$scope','$ocLazyLoad', function($scope, $ocLazyLoad){
	$scope.app = {
    name: 'TiUP',
    version: '1.0.0',
    settings: {
      themeID: 1,
      navbarHeaderColor: 'bg-black',
      navbarCollapseColor: 'bg-white-only',
      asideColor: 'bg-black',
      headerFixed: true,
      asideFixed: true,
      asideFolded: false,
      asideDock: false,
      container: false
    }
  }
}]);
