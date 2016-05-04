angular.isUndefinedOrNull = function(val) {
    return angular.isUndefined(val) || val === null || val === '';
}

var newExpresion = angular.module('AppModule', ['chieffancypants.loadingBar']);

newExpresion.directive('ckEditor', function() {
  console.log(urlMath);
  return {
    require: '?ngModel',
    link: function(scope, elm, attr, ngModel) {
      var ck = CKEDITOR.replace(elm[0], {
            extraPlugins: 'mathjax',
            mathJaxLib: urlMath,
            height: 200
        } );

      if (!ngModel) return;

      ck.on('pasteState', function() {
        scope.$apply(function() {
          ngModel.$setViewValue(ck.getData());
        });
      });

      ngModel.$render = function(value) {
        ck.setData(ngModel.$viewValue);
      };
    }
  };
});

newExpresion.config(function($interpolateProvider){
                $interpolateProvider.startSymbol('[[').endSymbol(']]');
});

newExpresion.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeBar = true;
    cfpLoadingBarProvider.latencyThreshold = 500;
  });

newExpresion.controller('LoadCtrl', function ($scope, $http, $timeout, cfpLoadingBar) {
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
      angular.bootstrap(document, ['newExpresionModule']);
});*/