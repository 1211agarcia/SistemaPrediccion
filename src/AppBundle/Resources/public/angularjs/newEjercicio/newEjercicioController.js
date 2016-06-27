newEjercicio.controller('newEjercicioController', function ($scope) {
    $scope.isNew = true;
    $scope.invalidRespuesta = true;

    $scope.formData = {};
    //indice que apunta a la respuesta a editar o crear
    $scope.indexPointer = 0;
    //$scope.respuestaExpresion = "";
    //$scope.formData.tema_respuestas = [];
    $scope.respuestas = [];

    $scope.invalidRespuestaFunc = function () {
        $scope.invalidRespuesta = (angular.isUndefinedOrNull($scope.respuestaExpresion));
    }
    $scope.$watch($scope.invalidRespuestaFunc);
    $scope.addRespuesta = function (expresion) {
        var newItemNo = $scope.respuestas.length+1;
        $scope.respuestas.push({'id':newItemNo, 'expresion':expresion});        
    }
    $scope.addNewRespuesta = function(){
        $scope.respuestaExpresion = "";
    }
    $scope.saveRespuesta = function() {
        if($scope.isNew){
            var newItemNo = $scope.respuestas.length+1;
            $scope.respuestas.push({'id':newItemNo, 'expresion':$scope.respuestaExpresion});
        }
        else
        {
            $scope.respuestas[$scope.indexPointer].expresion = $scope.respuestaExpresion;
            $scope.isNew = true
            $scope.indexPointer = 0;
        }
        console.log($scope.respuestas);
    };
    $scope.editAction = function (item) {
        $scope.isNew = false;
        $scope.respuestaExpresion = $scope.respuestas[item].expresion;
        $scope.indexPointer = item;
    }
    $scope.removeAction = function (item) {
        if($scope.respuestas.length > 2){
            $scope.respuestas.splice(item, 1);
        }else{
            alert("Debe tener al menos 2 respuestas.");
        }
    }
   
});/*Fin de newEjercicioController*/
