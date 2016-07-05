startPractica.controller('startPracticaController', function ($scope) {

    $scope.formData = {};
    //indice que apunta a la respuesta a editar o crear
    $scope.indexPointer = 0;
    //indice que apunta a la respuesta seleccionada como correcta
    $scope.indexSelected = -1;

    $scope.respuestas = [];

    $scope.isValid = function () {
        return ($scope.indexSelected == -1);
    }
    $scope.$watch($scope.isValid);
    $scope.addRespuesta = function (expresion) {
        var newItemNo = $scope.respuestas.length+1;
        $scope.respuestas.push({'id':newItemNo, 'expresion':expresion});        
    }
    $scope.selectAction = function (item) {
        $scope.indexSelected = item;
        console.log($scope.indexSelected);
        console.log(item);
    }
    $scope.isSelected = function (item) {
        console.log($scope.indexSelected == item);
        return $scope.indexSelected == item;
    }
   
});/*Fin de startPracticaController*/
