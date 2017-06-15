angular.module('app')
  .factory('R', function(Restangular) {
    return Restangular.withConfig(function(RestangularConfigurer) {
      RestangularConfigurer.setBaseUrl('/api/');
    }).addResponseInterceptor(function(data, operation, what, url, response, deferred){
    	var extractedData;
    		// .. to look for getList operations
    	if(operation === "getList") {
    		// .. and handle the data and meta data
      	extractedData = data.data;
      	extractedData.total = data.total;
    	}else {
        extractedData = data;
      }
      return extractedData;
    });
  });