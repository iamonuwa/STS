var app = angular.module('app', []);

/*
app.config(['$routeProvider','$httpProvider', function($routeProvider, $httpProvider) {
	$routeProvider.
		  $routeProvider.when('#about', {
        controller: 'about',
        templateUrl: 'views/pages/about'
    });
}]);
*/
app.config(['loginController',function($scope, $http) {

	/*
	$scope.submitForm =  function() { 		
	 		$http({
	 			method: 'POST',
	 			url: '/project/index.php/home/loginn',
	 			headers: {
	 				"Content-Type" :  "application/json"
	 			},
	 			data: JSON.stringify({email: $scope.email, password: $scope.passsword})
	 		}).success(function(data);

	 			alertify.notify(data.message, data.status, 5, function() { console.log(data.message); });
	 		});
	 	}*/
	
}]);
