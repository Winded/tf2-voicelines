
function urlSerialize(obj) {
	var str = [];
	for(var p in obj) {
		if (obj.hasOwnProperty(p)) {
			str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
		}
	}
	return str.join("&");
}

var app = angular.module("voicelinesApp", []);

app.controller("VoicelinesCtrl", function($scope, $http) {

	$scope.query = {};
	$scope.voicelines = {};

	$scope.classes = [
		"Scout",
		"Soldier",
		"Pyro",
		"Demoman",
		"Heavy",
		"Engineer",
		"Medic",
		"Sniper",
		"Spy",
	];

	$scope.submitQuery = function() {

		var query = angular.copy($scope.query);
		for(var key in query) {
			var value = query[key];
			if(!value || value == "") {
				delete query[key];
			}
		}
		var url = "api.php?" + urlSerialize(query);

		$http.get(url).success(function(data) {
			$scope.voicelines = data;
		}).error(function(data, status) {
			alert("Error: " + status);
		});

	};

});