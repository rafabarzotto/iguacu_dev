'use strict';

angular.module('starter.authController', [])

.controller('LoginCtrl',function ($scope, $rootScope, $location, AuthenticationService, toastr) {
        // reset login status
        AuthenticationService.ClearCredentials();

        $scope.login = function () {
            $scope.dataLoading = true;
            AuthenticationService.Login($scope.username, $scope.password, function (response) {
                if (response.success) {
                    AuthenticationService.SetCredentials($scope.username, $scope.password);
                    toastr.success('Logado com Sucesso!');
                    $location.path('/home');
                } else {
                    $scope.dataLoading = false;
                    toastr.warning('Usuário ou Senha Incorreto');
                }
            });
        };
    });