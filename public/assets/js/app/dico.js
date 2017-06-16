/* global app, BASE_URL, angular */

var app = angular.module('app');
app.controller('dico', function ($scope, $http) {
    $scope.get = function () {
        $http.get(BASE_URL + "dico/get_lists").then(function (response) {
            $scope.lists = response.data.lists;
        });
    };

    $scope.remove = function (row) {
        $http.post(BASE_URL + "dico/remove", row).then(function () {
            $scope.get();
        });
    };

    $scope.save = function () {
        $http.post(BASE_URL + "dico/save", $scope.newrow).then(function () {
            $scope.newrow = {};
            $scope.get();
        });
    };

    $scope.update = function () {
        $http.post(BASE_URL + "dico/save", $scope.editrow).then(function () {
            $scope.newrow = {};
            $scope.get();
        });
    };

    $scope.edit = function (row) {
        $scope.editrow = {id: row.id, label: row.label};
        $scope.newelement = {label: ""};
        $http.get(BASE_URL + "dico/get_elements/" + row.id).then(function (response) {
            $scope.elements = response.data.elements;

            var h = $(document).height() - 220;
            $('#block_1').slimScroll({
                height: h + "px"
            });
        });
    };

    $scope.saveElement = function () {
        var data = {list_id: $scope.editrow.id, label: $scope.newelement.label, list_label: $scope.editrow.label};
        $http.post(BASE_URL + "dico/save_elements/", data).then(function () {
            $scope.edit($scope.editrow);
        });
    };

    $scope.removeElement = function (element) {
        $http.post(BASE_URL + "dico/remove_element", element).then(function () {
            $scope.edit($scope.editrow);
        });
    };

    $scope.get();
});