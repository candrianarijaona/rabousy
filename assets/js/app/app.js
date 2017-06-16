/* global angular, BASE_URL, BASE_URL_NO_INDEX */

var app = angular.module('app', ['ngRoute']);

app.config(['$routeProvider', '$locationProvider',
    function ($routeProvider) {
        $routeProvider
                .when('/db/:database/:table', {
                    templateUrl: BASE_URL_NO_INDEX + '/assets/views/table.html',
                    controller: 'table'
                })
                .when('/dico', {
                    templateUrl: BASE_URL_NO_INDEX + '/assets/views/dico.html',
                    controller: 'dico'
                })
                .when('/lorem', {
                    templateUrl: BASE_URL_NO_INDEX + '/assets/views/lorem.html',
                    controller: 'lorem'
                });
    }]);

app.directive('myinterval', function () {
    return {
        template: '<div ng-include="getContentUrl"></div>',
        link: function (scope, element, attrs) {
            attrs.$observe("type", function (v) {
                var type = v.replace(/\([0-9]+\)/, "");
                if (type === 'smallint')
                    type = 'int';
                if (type === 'datetime')
                    type = 'date';
                scope.getContentUrl = BASE_URL_NO_INDEX + '/assets/views/partials/interval-' + type + '.html';
            });
        }
    };
});

app.controller('main', function ($scope, $http) {
    $scope.getDb = function () {
        $http.get(BASE_URL + "databases/get_dbs").then(function (response) {
            $scope.databases = response.data.databases;
        });
    };

    $scope.getTables = function (row) {
        if (row.expanded) {
            row.expanded = false;
            row.tables = [];
            return;
        }
        $http.get(BASE_URL + "databases/get_tables/" + row.Database).then(function (response) {
            row.tables = response.data.tables;
            row.expanded = true;
        });
    };

    $scope.getDb();
});