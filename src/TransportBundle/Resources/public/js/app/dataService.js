function dataservice($http, $location, $q) {
    var isPrimed = false;
    var primePromise;

    var service = {
        getMontlyData: getMontlyData,
        saveData: saveData,
        bulkOperation: bulkOperation
    };
    return service;
	
	function getMontlyData(month, year) {
	 	return $http.get(siteUrl + 'monthly/data/'+ month +'/' + year)
            .then(function(response){
				return response.data;
			})
            .catch(function(){
				console.log('XHR Failed for getAvengers.' + error.data);
			});
    }
	function saveData(data){
		return $http.post( siteUrl + 'save/', data)
            .then(function(response){
				return response.data;
			})
            .catch(function(){
				console.log('XHR Failed for getAvengers.' + error.data);
		});
	}
	function bulkOperation(data){
		return $http.post(siteUrl + 'bulk/operation/', data)
            .then(function(response){
				return response.data;
			})
            .catch(function(){
				console.log('XHR Failed for getAvengers.' + error.data);
		});
	}
}