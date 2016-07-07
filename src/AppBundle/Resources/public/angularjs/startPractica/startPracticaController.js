startPractica.controller('startPracticaController', function ($scope, $http, $window) {
$scope.indexxx = -1;
$scope.opciones = [{
      checked: false
    }, {
      checked: false
    }, {
      checked: false
    }, {
      checked: false
    }
  ];

    $scope.updateSelection = function(position) {
        $scope.evaluacion.seleccion = position;
        angular.forEach($scope.opciones,
            function(subscription, index) {
                if (position != index) 
                    subscription.checked = false;
            }
        );
    }


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
        id: response.id,
        id_practica: $scope.ejercicio.id_practica,
        seleccion: -1//indice que apunta a la respuesta seleccionada como correcta
    };console.log("evaluacion",$scope.evaluacion);
    $scope.isValid = function () {
        MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
        return (!($scope.opciones[0].checked ||
                $scope.opciones[1].checked ||
                $scope.opciones[2].checked ||
                $scope.opciones[3].checked) ||
                $scope.evaluando);
    }
    $scope.$watch($scope.isValid);
    
    $scope.selectAction = function (item) {
        console.log("seleccionado",(item));
        $scope.evaluacion.seleccion = parseInt(item);
        console.log("seleccionado",parseInt(item));
        console.log($scope.evaluacion.seleccion);
    }
    $scope.siguiente = function () {
        $scope.opciones = [{checked: false}, {checked: false}, {checked: false}, {checked: false}];
        $scope.ejercicio = null;
        $scope.evaluando = false;
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
        $scope.correcto = false;
        $scope.incorrecto = false;
    };

    $scope.isSelected = function (item) {
        console.log("item",item);
        console.log("$scope.evaluacion.seleccion",$scope.evaluacion.seleccion);
        console.log($scope.ejercicio.respuestas);
        console.log($scope.evaluacion.seleccion == item);
        return $scope.evaluacion.seleccion == parseInt(item);
    }
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
            case 3:
                $scope.titulo_boton2 = "Finalizar";
                $scope.finalizado = true;
            break;
        }
        console.log("finalizado",$scope.finalizado);
        console.log("correcto",$scope.correcto);
        console.log("incorrecto",$scope.incorrecto);
    }
   
});/*Fin de startPracticaController*/
