angular.isUndefinedOrNull = function(val) {
    return angular.isUndefined(val) || val === null || val === '';
}

var newEjercicio = angular.module('AppModule', ['chieffancypants.loadingBar']);

newEjercicio.directive('ckEditor', function() {
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

newEjercicio.config(function($interpolateProvider){
                $interpolateProvider.startSymbol('[[').endSymbol(']]');
});

newEjercicio.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeBar = true;
    cfpLoadingBarProvider.latencyThreshold = 500;
  });

newEjercicio.controller('LoadCtrl', function ($scope, $http, $timeout, cfpLoadingBar) {
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
      angular.bootstrap(document, ['newEjercicioModule']);
});*/
newEjercicio.controller('newEjercicioController', function ($scope) {
    $scope.isNew = true;
    $scope.invalidSolucion = true;

    $scope.formData = {};
    //indice que apunta a la solucion a editar o crear
    $scope.indexPointer = 0;
    //$scope.solucionExpresion = "";
    //$scope.formData.tema_soluciones = [];
    $scope.soluciones = [];

    $scope.invalidSolucionFunc = function () {
        $scope.invalidSolucion = (angular.isUndefinedOrNull($scope.solucionExpresion));
    }
    $scope.$watch($scope.invalidSolucionFunc);
    $scope.addSolucion = function (expresion) {
        var newItemNo = $scope.soluciones.length+1;
        $scope.soluciones.push({'id':newItemNo, 'expresion':expresion});        
    }
    $scope.addNewSolucion = function(){
        $scope.solucionExpresion = "";
    }
    $scope.saveSolucion = function() {
        if($scope.isNew){
            var newItemNo = $scope.soluciones.length+1;
            $scope.soluciones.push({'id':newItemNo, 'expresion':$scope.solucionExpresion});
        }
        else
        {
            $scope.soluciones[$scope.indexPointer].expresion = $scope.solucionExpresion;
            $scope.isNew = true
            $scope.indexPointer = 0;
        }
        console.log($scope.soluciones);
    };
    $scope.editAction = function (item) {
        $scope.isNew = false;
        $scope.solucionExpresion = $scope.soluciones[item].expresion;
        $scope.indexPointer = item;
    }
    $scope.removeAction = function (item) {
        $scope.soluciones.splice(item, 1);
    }
   
});/*Fin de newEjercicioController*/
