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
