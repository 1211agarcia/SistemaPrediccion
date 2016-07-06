startPractica.controller('startPracticaController', function ($scope, $http, $window) {

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
        $scope.evaluacion.seleccion = item;
    }
    $scope.isSelected = function (item) {
        console.log($scope.indexSelected == item);
        return $scope.indexSelected == item;
    }
    /***  ***/
    $scope.response = response;
    $scope.evaluacion ={
        id: response.id,
        practica_id: response.practica_id,
        seleccion: -1
    };

    $scope.evaluar = function() {
        console.log($scope.response);
        // if($scope.filtros.hasOwnProperty('fecha'))
        // $scope.filtros.fecha = $scope.filtros.fecha.toLocaleDateString();

        var json = {};
        json = $scope.evaluacion;
        json = angular.toJson(json);
        var url= Routing.generate('practica_evaluar');
        //console.log(url);
        $.ajax({
            method: 'POST',
            data: json,
            url: url,
            success: function(data) {
                console.log(data);
                $scope.response = data;
                $scope.$apply();
            },
            error: function(e) {
                console.log(e);
            }
        })
    }
    $scope.limpiar = function(){
        $scope.response = response;
        $scope.filtros = {};
    }
   
});/*Fin de startPracticaController*/
