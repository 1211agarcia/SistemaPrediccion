angular.isUndefinedOrNull = function(val) {
    return angular.isUndefined(val) || val === null || val === '';
}

var newTema = angular.module('AppModule', ['chieffancypants.loadingBar']);

newTema.directive('ckEditor', function() {
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

newTema.config(function($interpolateProvider){
                $interpolateProvider.startSymbol('[[').endSymbol(']]');
});

newTema.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeBar = true;
    cfpLoadingBarProvider.latencyThreshold = 500;
  });

newTema.controller('LoadCtrl', function ($scope, $http, $timeout, cfpLoadingBar) {
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
      angular.bootstrap(document, ['newTemaModule']);
});*/
newTema.controller('newTemaController', function ($scope) {
    $scope.isNew = true;
    $scope.invalidCategoria = true;

    $scope.formData = {};
    //indice que apunta a la categoria a editar o crear
    $scope.indexPointer = 0;
    $scope.categoria = {};
    //$scope.formData.tema_categorias = [];
    $scope.categorias = [];

    $scope.invalidCategoriaFunc = function () {
        $scope.invalidCategoria = (angular.isUndefinedOrNull($scope.categoria.nombre) || angular.isUndefinedOrNull($scope.categoria.procedimiento));
    }
    $scope.$watch($scope.invalidCategoriaFunc);
    $scope.addCategoria = function (nombre, procedimiento) {
        var newItemNo = $scope.categorias.length+1;
        $scope.categorias.push({'id':newItemNo, 'nombre':nombre, 'procedimiento':procedimiento});        
    }
    $scope.addNewCategoria = function(){
        $scope.categoria.nombre = "";
        $scope.categoria.procedimiento = "";
    }
    $scope.saveCategoria = function() {
        if($scope.isNew){
            var newItemNo = $scope.categorias.length+1;
            $scope.categorias.push({'id':newItemNo, 'nombre':$scope.categoria.nombre, 'procedimiento':$scope.categoria.procedimiento});
        }
        else
        {
            $scope.categorias[$scope.indexPointer].nombre = $scope.categoria.nombre;
            $scope.categorias[$scope.indexPointer].procedimiento = $scope.categoria.procedimiento;
            $scope.isNew = true
            $scope.indexPointer = 0;
        }
        console.log($scope.categorias);
    };
    $scope.editAction = function (item) {
        $scope.isNew = false;
        $scope.categoria.nombre = $scope.categorias[item].nombre;
        $scope.categoria.procedimiento = $scope.categorias[item].procedimiento;
        $scope.indexPointer = item;
    }
    $scope.removeAction = function (item) {
        $scope.categorias.splice(item, 1);
    }
   
});/*Fin de newTemaController*/
