newEjercicio.controller('newEjercicioController', function ($scope) {
    $scope.isNew = true;
    $scope.invalidRespuesta = true;

    $scope.formData = {};
    //indice que apunta a la respuesta a editar o crear
    $scope.indexPointer = 0;
    //indice que apunta a la respuesta seleccionada como correcta
    $scope.indexSelected = -1;
    //$scope.respuestaExpresion = "";
    //$scope.formData.tema_respuestas = [];
    $scope.respuestas = response;
    for (var i = 0; i < $scope.respuestas.length; i++) {
        $scope.respuestas[i] = $scope.respuestas[i].replace(/__X__/g, "\\");
        $scope.respuestas[i] = $scope.respuestas[i].replace(/&quot;/g, "\"");
        $scope.respuestas[i] = $scope.respuestas[i].replace(/__S__/g, "\'");
    };
    $scope.invalidRespuestaFunc = function () {
        MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
        $scope.invalidRespuesta = (angular.isUndefinedOrNull($scope.respuestaExpresion));
    }
    $scope.$watch($scope.invalidRespuestaFunc);
    $scope.addRespuesta = function (expresion, correcta) {
        var newItemNo = $scope.respuestas.length+1;
        $scope.respuestas.push({'id':newItemNo, 'expresion':expresion, 'correcta':correcta});        
        console.log("es correcta?: "+correcta);
        if(correcta){
            $scope.indexSelected = newItemNo - 1;
        }
                MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
    }
    $scope.addNewRespuesta = function(){
        $scope.respuestaExpresion = "";
    }
    $scope.saveRespuesta = function() {
        if($scope.isNew){
            var newItemNo = $scope.respuestas.length+1;
            $scope.respuestas.push({'id':newItemNo, 'expresion':$scope.respuestaExpresion, 'correcta':false});
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
    $scope.selectAction = function (item) {
        $scope.indexSelected = item;
        console.log($scope.indexSelected);
        console.log(item);
    }
    $scope.isSelected = function (item) {
        console.log($scope.indexSelected == item);
        return $scope.indexSelected == item;
    }
    $scope.removeAction = function (item) {
        if($scope.respuestas.length > 4){
            $scope.respuestas.splice(item, 1);
        }else{
            alert("Debe tener al menos 4 respuestas.");
        }
    }
   
});/*Fin de newEjercicioController*/
