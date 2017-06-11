'use strict';
var app = angular.module('colonydemo', []);

app.constant('appConfig', {
	appversion: '0.0.1',
	appproducer: 'Mr. Python',
	api: 'http://colonydemo.local/api/'
});

app.controller('QuestionsCtrl', function ($scope, $http, appConfig) {

	var qCount = 0;
	var token = null;
	var questions = null;

	$scope.currentQ = 0;
	$scope.message = null;
	$scope.loginShow = true;
	$scope.questionsShow = false;
	$scope.finishShow = false;

	$scope.start = function (name) {
		if (typeof name != 'undefined') {
			if (name.length != 0) {
				$http({
					url: appConfig.api + 'register/' + name,
					method: 'GET'
				}).then(function (response) {
					if (response.status == 200) $scope.login(name);
				}, function (err) {
					if (err.status == 409) $scope.message = 'This name is already registered.';
				});
			}
		}
	};

	$scope.login = function (name) {
		$http({
			url: appConfig.api + 'login/' + name,
			method: 'GET'
		}).then(function (response) {
			if (response.status == 200) {
				token = response.data.token;

				if (token.length != 0) {
					$scope.loginShow = false;
					$scope.questionsShow = true;

					$scope.getQuestions();
				}
			}
		}, function (err) {
			console.log(err);
		});
	};

	$scope.showQuestion = function (qId) {
		if (qId < qCount) {
			if (questions[qId].is_active) {
				$scope.option1 = questions[qId].option1;
				$scope.option2 = questions[qId].option2;
			}
		}
		else $scope.finish();
	};

	$scope.getQuestions = function () {
		$http({
			url: appConfig.api + 'getq',
			method: 'GET'
		}).then(function (response) {
			if (response.status == 200) {
				questions = response.data;
				qCount = questions.length;

				$scope.showQuestion($scope.currentQ);
			}
		}, function (err) {
			console.log(err);
		});
	};

	$scope.answer = function (answer) {
		$http({
			url: appConfig.api + 'setanswer/' + questions[$scope.currentQ].id + '/' + answer,
			method: 'GET',
			headers: { 'Authorization': token }
		}).then(function (response) {
			if (response.status == 200) {
				$scope.currentQ = $scope.currentQ + 1;

				$scope.showQuestion($scope.currentQ);
			}
		}, function (err) {
			console.log(err);
		});
	};

	$scope.finish = function () {
		$scope.message = 'Thank you for your participation!';
		$scope.questionsShow = false;
		$scope.finishShow = true;
	}

	$scope.hideMessage = function () {
		$scope.message = null;
	}
});

app.controller('ReportCtrl', function ($scope, $http, appConfig) {
	var qCount = 0;

	$scope.questions = null;
	$scope.data = null;

	$scope.getQuestions = function () {
		$http({
			url: appConfig.api + 'getq',
			method: 'GET'
		}).then(function (response) {
			if (response.status == 200) {
				$scope.questions = response.data;
				qCount = $scope.questions.length;
			}
		}, function (err) {
			console.log(err);
		});
	};

	$scope.getData = function () {
		$http({
			url: appConfig.api + 'getdata',
			method: 'GET'
		}).then(function (response) {
			if (response.status == 200) {
				$scope.data = response.data;
			}
		}, function (err) {
			console.log(err);
		});
	};

	$scope.getQuestions();
	$scope.getData();
});