showEstudiante.controller('showEstudianteController', function ($scope) {
	$scope.labels = [];
  	$scope.series = ['Series A'];
  	$scope.data = [[]];
  	for (var i = 0; i < practicas.length; i++) {
  		$scope.data[0].push(practicas[i].calificacion);
		console.log((new Date(practicas[i].fecha.date)).getDate());
		console.log((new Date(practicas[i].fecha.date)).getDate()+"/"+(new Date(practicas[i].fecha.date)).getMonth() +"-"+ (new Date(practicas[i].fecha.date)).getHours() +":"+ (new Date(practicas[i].fecha.date)).getMinutes());
  		$scope.labels.push((new Date(practicas[i].fecha.date)).getDate()+"/"+(new Date(practicas[i].fecha.date)).getMonth() +"-"+ (new Date(practicas[i].fecha.date)).getHours() +":"+ (new Date(practicas[i].fecha.date)).getMinutes());
  	};
  	$scope.onClick = function (points, evt) {
  		$scope.practicaSelect = points.length > 0;
  		if ($scope.practicaSelect){
  			var i = $scope.labels.indexOf(points[0].label);
  			if(i > -1){
	  		console.log(practicas[i]);
  				$scope.urlPractica = Routing.generate('practica_show', { 'id': practicas[i].id });
  				$scope.fechaPractica = (new Date(practicas[i].fecha.date)).getDate()+"/"+(new Date(practicas[i].fecha.date)).getMonth() +"-"+ (new Date(practicas[i].fecha.date)).getHours() +":"+ (new Date(practicas[i].fecha.date)).getMinutes()+":"+ (new Date(practicas[i].fecha.date)).getSeconds();
  				$scope.dificultadPractica = practicas[i].dificultad;
  				$scope.temaPractica = practicas[i].tema;
  				$scope.calificacionPractica = practicas[i].calificacion;

  				console.log(practicas[i].id);//id de practica seleccionada
	  		}
  		}
    	//console.log(points, evt);
  	};
  	$scope.datasetOverride = [{ yAxisID: 'y-axis-1' }, { yAxisID: 'y-axis-2' }];
  	$scope.options = {
    	scales: {
      		yAxes: [
	        	{
    	      	id: 'y-axis-1',
        	  	type: 'linear',
          		display: true,
          		position: 'left'
        		},
        		{
          		id: 'y-axis-2',
          		type: 'linear',
          		display: true,
          		position: 'right'
        		}
      		]
    	}
  	};
});/*Fin de showEstudianteController*/
