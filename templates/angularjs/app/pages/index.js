 angular.module('app').controller('IndexCtrl',['$scope', function($scope){
    $scope.name = "Li Zhangwei";
    console.info($scope.name);
}]);