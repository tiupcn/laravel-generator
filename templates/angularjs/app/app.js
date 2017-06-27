var app = angular.module('app',[
    require('angular-ui-router'),
    require('oclazyload'),
    require('restangular'),
    require('angularjs-toaster'),
    require('angular-ui-bootstrap')
  ]);
require('./config.lazyload.js');
require('./config.route.js');
require('./services/service.js');
import 'angularjs-toaster/toaster.min.css';

app.controller('AppCtrl',['$scope','$ocLazyLoad', function($scope, $ocLazyLoad){
  $scope.app = {
    name: 'TiUP',
    version: '1.0.0',
    settings: {
      themeID: 1,
      navbarHeaderColor: 'bg-white-only',
      navbarCollapseColor: 'bg-white-only',
      asideColor: 'bg-black',
      headerFixed: true,
      asideFixed: true,
      asideFolded: false,
      asideDock: false,
      container: false
    }
  }
  $scope.user = window.user;
  $scope.copyright = new Date().getFullYear();
}]);
