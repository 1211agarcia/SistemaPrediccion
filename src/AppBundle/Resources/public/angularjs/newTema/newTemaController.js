newTema.controller('newTemaController', function ($scope) {
    $scope.formData = {};
    //indice que apunta a la categoria a editar o crear
    $scope.indexPoint = 0;
    $scope.categoria = {};
    //$scope.formData.tema_categorias = [];
    $scope.categorias = [];
    $scope.aceptarCategoria = function () {

        // body...
    }
    $scope.addNewCategoria = function() {
        var newItemNo = $scope.categorias.length+1;
        $scope.categorias.push({'id':newItemNo, 'nombre':$scope.categoria.nombre, 'procedimiento':$scope.categoria.procedimiento});
        $scope.categoria.nombre = "";
        $scope.categoria.procedimiento = "";
    };
    $scope.add = function(item) {
        console.log($scope.formData.tema_categorias);
        if(item != ""){
            $scope.formData.tema_categorias.push({'word':item});
        }
    };

   
});/*Fin de newTemaController*/
