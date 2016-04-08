showTema.controller('showTemaController', function ($scope) {

    $scope.categorias = [];

    $scope.addCategoria = function (nombre, procedimiento) {
        var showItemNo = $scope.categorias.length+1;
        $scope.categorias.push({'id':showItemNo, 'nombre':nombre, 'procedimiento':procedimiento});        
    }

    $scope.openAction = function (item) {
        $scope.categoria.nombre = $scope.categorias[item].nombre;
        $scope.categoria.procedimiento = $scope.categorias[item].procedimiento;
    }
});/*Fin de showTemaController*/
