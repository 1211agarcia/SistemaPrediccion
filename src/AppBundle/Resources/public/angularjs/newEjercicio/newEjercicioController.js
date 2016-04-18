newEjercicio.controller('newEjercicioController', function ($scope) {
    $scope.isNew = true;
    $scope.invalidSolucion = true;

    $scope.formData = {};
    //indice que apunta a la solucion a editar o crear
    $scope.indexPointer = 0;
    $scope.solucion = {};
    //$scope.formData.tema_soluciones = [];
    $scope.soluciones = [];

    $scope.invalidSolucionFunc = function () {
        $scope.invalidsolucion = (angular.isUndefinedOrNull($scope.solucion.tema) || angular.isUndefinedOrNull($scope.solucion.expresion));
    }
    $scope.$watch($scope.invalidSolucionFunc);
    $scope.addSolucion = function (tema, expresion) {
        var newItemNo = $scope.soluciones.length+1;
        $scope.soluciones.push({'id':newItemNo, 'tema':tema, 'expresion':expresion});        
    }
    $scope.addNewSolucion = function(){
        $scope.solucion.tema = "";
        $scope.solucion.expresion = "";
    }
    $scope.saveSolucion = function() {
        if($scope.isNew){
            var newItemNo = $scope.soluciones.length+1;
            $scope.soluciones.push({'id':newItemNo, 'tema':$scope.solucion.tema, 'expresion':$scope.solucion.expresion});
        }
        else
        {
            $scope.soluciones[$scope.indexPointer].tema = $scope.solucion.tema;
            $scope.soluciones[$scope.indexPointer].expresion = $scope.solucion.expresion;
            $scope.isNew = true
            $scope.indexPointer = 0;
        }
        console.log($scope.soluciones);
    };
    $scope.editAction = function (item) {
        $scope.isNew = false;
        $scope.solucion.tema = $scope.soluciones[item].tema;
        $scope.solucion.expresion = $scope.soluciones[item].expresion;
        $scope.indexPointer = item;
    }
    $scope.removeAction = function (item) {
        $scope.soluciones.splice(item, 1);
    }
   
});/*Fin de newEjercicioController*/
