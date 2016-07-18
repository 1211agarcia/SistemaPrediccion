startPractica.controller('startPracticaController', function ($scope, $http, $window) {
    $scope.opciones = [{checked: false}, {checked: false}, {checked: false}, {checked: false}];
    $scope.aciertos = 0;
    $scope.titulo_boton = "Evaluar";
    $scope.titulo_boton2 = "Siguiente";
    $scope.correcto = false;
    $scope.incorrecto = false;
    $scope.finalizado = false;
    $scope.evaluando = false;
    $scope.ejercicio = response;
    console.log("ejercicio",$scope.ejercicio);
    $scope.data_siguiente = {};
    $scope.ejercicio.enunciado = $scope.ejercicio.enunciado.replace(/__X__/g, "\\");
    $scope.ejercicio.enunciado = $scope.ejercicio.enunciado.replace(/&quot;/g, "\"");
    $scope.ejercicio.enunciado = $scope.ejercicio.enunciado.replace(/__S__/g, "\'");
    for (var i = 0; i < $scope.ejercicio.respuestas.length; i++) {
        $scope.ejercicio.respuestas[i] = $scope.ejercicio.respuestas[i].replace(/__X__/g, "\\");
        $scope.ejercicio.respuestas[i] = $scope.ejercicio.respuestas[i].replace(/&quot;/g, "\"");
        $scope.ejercicio.respuestas[i] = $scope.ejercicio.respuestas[i].replace(/__S__/g, "\'");
    };
    console.log("ejercicio",$scope.ejercicio);
    $scope.evaluacion ={
        id: $scope.ejercicio.id,
        id_practica: $scope.ejercicio.id_practica,
        seleccion: -1//indice que apunta a la respuesta seleccionada como correcta
    };console.log("evaluacion",$scope.evaluacion);
    $scope.selectAction = function(position) {
        $scope.opciones[position].checked = true;
        $scope.updateSelection(position);
    }
    $scope.updateSelection = function(position) {
        $scope.evaluacion.seleccion = parseInt(position);
        angular.forEach($scope.opciones,
            function(subscription, index) {
                if (position != index) 
                    subscription.checked = false;
            }
        );
    }

    $scope.isValid = function () {
        MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
        return (!($scope.opciones[0].checked ||
                $scope.opciones[1].checked ||
                $scope.opciones[2].checked ||
                $scope.opciones[3].checked) ||
                $scope.evaluando);
    }
    $scope.$watch($scope.isValid);
    
    $scope.siguiente = function () {
        $scope.finalizado = ($scope.data_siguiente.id >= 4 );
        $scope.ejercicio = null;
        $scope.evaluando = false;
        $scope.correcto = false;
        $scope.incorrecto = false;
        if (!$scope.finalizado) {//si no se ha finalizado
            $scope.opciones = [{checked: false}, {checked: false}, {checked: false}, {checked: false}];
            $scope.titulo_boton = "Evaluar";
            $scope.ejercicio = $scope.data_siguiente;
            $scope.ejercicio.enunciado = $scope.ejercicio.enunciado.replace(/__X__/g, "\\");
            $scope.ejercicio.enunciado = $scope.ejercicio.enunciado.replace(/&quot;/g, "\"");
            $scope.ejercicio.enunciado = $scope.ejercicio.enunciado.replace(/__S__/g, "\'");
            for (var i = 0; i < $scope.ejercicio.respuestas.length; i++) {
                $scope.ejercicio.respuestas[i] = $scope.ejercicio.respuestas[i].replace(/__X__/g, "\\");
                $scope.ejercicio.respuestas[i] = $scope.ejercicio.respuestas[i].replace(/&quot;/g, "\"");
                $scope.ejercicio.respuestas[i] = $scope.ejercicio.respuestas[i].replace(/__S__/g, "\'");
            };
            $scope.evaluacion ={
                id: $scope.ejercicio.id,
                id_practica: $scope.ejercicio.id_practica,
                seleccion: -1//indice que apunta a la respuesta seleccionada como correcta
            };
        }
    };

    /***  ***/

    $scope.evaluar = function() {
        //cambiar valor de boton a "evaluando..."
        $scope.titulo_boton = "evaluando...";
        $scope.evaluando = true;
        console.log("evaluacion",$scope.evaluacion);
        
        var json = {};
        json = $scope.evaluacion;
        json = angular.toJson(json);
        var url= Routing.generate('practica_evaluar');
        $.ajax({
            method: 'POST',
            data: json,
            url: url,
            success: function(data) {
                console.log("respuesta",data);
                $scope.data_siguiente = data;
                console.log("data siguiente",$scope.data_siguiente);
                $scope.resultado(data.resultado);
                $scope.$apply();
            },
            error: function(e) {
                console.log(e);
            }
        })
    }
    $scope.resultado = function(estado){
        switch(estado){
            case 1:
                $scope.correcto = true;
                $scope.aciertos ++;
            break;
            case 2:
                $scope.incorrecto = true;
            break;
        }
        if($scope.data_siguiente.id > 3) {
            $scope.titulo_boton2 = "Finalizar";
        }
        console.log("finalizado",$scope.finalizado);
        console.log("correcto",$scope.correcto);
        console.log("incorrecto",$scope.incorrecto);
    }
   
});/*Fin de startPracticaController*/
