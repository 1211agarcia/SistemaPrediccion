newTema.controller('newTemaController', function ($scope) {
    $scope.isNew = true;

    $scope.formData = {};
    //indice que apunta a la categoria a editar o crear
    $scope.indexPointer = 0;
    $scope.categoria = {};
    //$scope.formData.tema_categorias = [];
    $scope.categorias = [];

    $scope.addNewCategoria = function(){
        $scope.categoria.nombre = "";
        $scope.categoria.procedimiento = "";
    }
    $scope.saveCategoria = function() {
        if($scope.isNew){
            var newItemNo = $scope.categorias.length+1;
            $scope.categorias.push({'id':newItemNo, 'nombre':$scope.categoria.nombre, 'procedimiento':$scope.categoria.procedimiento});
        }
        else
        {
            $scope.categorias[$scope.indexPointer].nombre = $scope.categoria.nombre;
            $scope.categorias[$scope.indexPointer].procedimiento = $scope.categoria.procedimiento;
            $scope.isNew = true
            $scope.indexPointer = 0;
        }
        $scope.categoria.nombre = "";
        $scope.categoria.procedimiento = "";
        console.log($scope.categorias);

    };
    $scope.editAction = function (item) {
        $scope.isNew = false;
        $scope.categoria.nombre = $scope.categorias[item].nombre;
        $scope.categoria.procedimiento = $scope.categorias[item].procedimiento;
        $scope.indexPointer = item;
    }
   
});/*Fin de newTemaController*/
