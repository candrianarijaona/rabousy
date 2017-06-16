/* global angular, BASE_URL */

var app = angular.module('app');
app.controller('table', function ($scope, $http, $routeParams) {
    $scope.database = $routeParams.database;
    $scope.table = $routeParams.table;
    $scope.get = function () {
        $http.get(BASE_URL + "databases/get_columns/" + $scope.database + "/" + $scope.table).then(function (response) {
            $scope.columns = response.data.columns;
            $scope.current_rows = response.data.nb_rows;
            var h = $(document).height() - 220;
            $('#block_1').slimScroll({
                height: h + "px"
            });

            $('.datepicker').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD',
                clearButton: true,
                weekStart: 1,
                time: false
            });
        });

        $http.get(BASE_URL + "dico/get_lists").then(function (response) {
            $scope.lists = response.data.lists;
        });
        
        $http.get(BASE_URL + "lorem/get_lorems").then(function(response){
            $scope.lorems = response.data.lorems;
        });
    };

    $scope.editLists = function () {
        $("#basicExample").modal('show');
    };
    
    $scope.generate = function() {
        var data = {columns: $scope.columns, nb_rows: $scope.nb_rows, database: $scope.database, table: $scope.table};
        $http.post(BASE_URL + "generator/generate", data).then(function(){
            
        });
    };
    
    $scope.advanced = function(row) {
        $scope.current_column = row;
        $("#basicExample").modal("show");
    };

    $scope.get();
});