/* global angular, BASE_URL */

var app = angular.module('app');
app.controller('lorem', function($scope, $http){
    $scope.get = function(){
        $http.get(BASE_URL + "/lorem/get_lorems").then(function(response){
            $scope.lorems = response.data.lorems;
            var h = $(document).height() - 220;
            $('#block_1').slimScroll({
                height: h + "px"
            });
        });
    };
    
    $scope.get();
});