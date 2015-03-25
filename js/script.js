
soundManager.setup({
	url: '/voicelines/swf',
	flashVersion: 9,
	preferFlash: false
});

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

		if(!$scope.query.person && (!$scope.query.quote || $scope.query.quote == "")) {
			$scope.searchUsed = false;
			$scope.voicelines = {};
			return;
		}

		$scope.searchUsed = true;
		$scope.loading = true;

		$http.get("api.php", {params: $scope.query}).success(function(data) {
			$scope.voicelines = data;
			$scope.loading = false;
		}).error(function(data, status) {
			alert("Error: " + status);
			$scope.voicelines = {};
			$scope.searchUsed = false;
			$scope.loading = false;
		});

	};

	$scope.previewVoiceline = function(voiceline) {

		soundManager.createSound({
			url: voiceline.link,
			autoPlay: true
		});

	}

});