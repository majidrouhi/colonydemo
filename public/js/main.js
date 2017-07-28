'use strict';
var app = angular.module('colonydemo', []);

app.constant('appConfig', {
	appversion: '0.0.1',
	appproducer: 'Mr. Python',
	api: 'http://colony.localhost/api/'
});

app.controller('QuestionsCtrl', function ($scope, $http, appConfig) {
	var qCount = 0;
	var totalQuestions = 0;
	var token = null;
	var questions = null;

	$scope.currentQ = 0;
	$scope.answeredCount = 0;
	$scope.loginShow = true;
	$scope.dashboardShow = false;
	$scope.questionsShow = false;
	$scope.reportShow = false;

	$scope.start = function (name) {
		if (typeof name != 'undefined') {
			if (name.length != 0) {
				$http({
					url: appConfig.api + 'register/' + name,
					method: 'GET'
				}).then(function (response) {
					$scope.login(name, null);
				}, function (err) {
					$scope.login(name, null);
				});
			}
		}
	};

	$scope.login = function (name, action) {
		$http({
			url: appConfig.api + 'login/' + name,
			method: 'GET'
		}).then(function (response) {
			if (response.status == 200) {
				token = response.data.token;

				if (token.length != 0) {
					$scope.loginShow = false;

					$scope.getQuestions();
				}
			}
		}, function (err) {
			console.log(err);
		});
	};

	$scope.redirectTo = function (action) {
		$scope.dashboardShow = false;

		if ((qCount == totalQuestions && totalQuestions > 0) || action == 'question') {
			$scope.questionsShow = true;

			$scope.showQuestion($scope.currentQ);
		}
		else if (qCount == 0 || action == 'report') {
			$scope.reportShow = true;

			$scope.report();
		}
		else $scope.dashboardShow = true;
	}

	$scope.getQuestions = function () {
		$http({
			url: appConfig.api + 'getq',
			method: 'GET',
			headers: { 'Authorization': token }
		}).then(function (response) {
			if (response.status == 200) {
				questions = response.data.questions;
				totalQuestions = response.data.totalCount;
				qCount = questions.length;

				$scope.answeredCount = totalQuestions - qCount;

				$scope.redirectTo(null);
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

			$scope.checkFinish();
		}
		else $scope.report();
	};

	$scope.report = function () {
		$scope.questionsShow = false;
		$scope.menuShow = false;
		$scope.reportShow = true;

		$http({
			url: appConfig.api + 'getreport',
			method: 'GET',
			headers: { 'Authorization': token }
		}).then(function (response) {
			if (response.status == 200) {
				$scope.userReport = response.data;
			}
		}, function (err) {
			console.log(err);
		});
	}

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

	$scope.checkFinish = function () {
		if ($scope.currentQ + $scope.answeredCount >= 5) {
			var finishBtn = angular.element(document.querySelector('.finish'));

			finishBtn.addClass('active');
		}
	};
});