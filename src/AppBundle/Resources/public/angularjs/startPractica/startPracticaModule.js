angular.isUndefinedOrNull = function(val) {
    return angular.isUndefined(val) || val === null || val === '';
}

var startPractica = angular.module('AppModule', ['chieffancypants.loadingBar', 'ngSanitize']);

startPractica.config(function($interpolateProvider){
                $interpolateProvider.startSymbol('[[').endSymbol(']]');
});

startPractica.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeBar = true;
    cfpLoadingBarProvider.latencyThreshold = 500;
});

startPractica.controller('LoadCtrl', function ($scope, $http, $timeout, cfpLoadingBar) {
    $scope.posts = [];
    $scope.section = null;
    $scope.subreddit = null;
    
    $scope.start = function() {
      cfpLoadingBar.start();
    };

    $scope.complete = function () {
      cfpLoadingBar.complete();
    }

    // fake the initial load so first time users can see it right away:
    $scope.start();
    $scope.fakeIntro = true;
    $timeout(function() {
      $scope.complete();
      $scope.fakeIntro = false;
    }, 750);
});

/*angular.element(document).ready(function() {
      angular.bootstrap(document, ['startPracticaModule']);
});*/