angular.module('starter.services', [])

    .config(function($httpProvider) {
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
    })

    .factory('apiFactory', function($http, $q) {


        var url = 'http://192.168.4.1:3000/';

        function getHosts() {
            return $http({
                method: "GET",
                url: url + 'hosts',
                dataType: 'json',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            }).then(handleSuccess, handleError);
        }

        function gerarArquivoDHCP() {
            return $http({
                method: "GET",
                url: 'php/gerarDhcpdphp7.php',
                dataType: 'json',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            }).then(handleSuccess, handleError);
        }

        function getForId(id) {
            return ($http.get(url + 'hosts/' + id, {
                    ignoreLoadingBar: true
                })
                .then(handleSuccess, handleError));
        }

        function saveHosts(data) {
            return $http({
                method: 'POST',
                url: url + 'hosts',
                data: data,
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            }).then(handleSuccess, handleError);
        }

        function updateHosts(id, data) {
            return $http({
                method: 'PUT',
                url: url + 'hosts/' + id,
                data: data,
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            }).then(handleSuccess, handleError);
        }

        function getDHCPD(op) {
            return $http({
                method: "GET",
                url: url + 'dhcpserver/' + op,
                dataType: 'json',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            }).then(handleSuccess, handleError);
        }

        function getDash() {
            return $http({
                method: "GET",
                url: url + 'hosts/dash',
                dataType: 'json',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            }).then(handleSuccess, handleError);
        }

        function getQtdTipo() {
            return $http({
                method: "GET",
                url: url + 'hosts/qtdtipo',
                dataType: 'json',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            }).then(handleSuccess, handleError);
        }

        function getFaixaIP() {
            return $http({
                method: "GET",
                url: url + 'hosts/dropdownfaixaip',
                dataType: 'json',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            }).then(handleSuccess, handleError);
        }

        function getFiltro(faixa) {
            return $http({
                method: "GET",
                url: url + 'hosts/faixa/' + faixa,
                dataType: 'json',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            }).then(handleSuccess, handleError);
        }

        function handleSuccess(response) {
            return response.data;
        }

        function handleError(response) {
            if (!angular.isObject(response.data) || !response.data.message) {
                return ($q.reject("An unknown error occurred."));
            }
            return ($q.reject(response.data.message));
        }

        return ({
            getForId: getForId,
            saveHosts: saveHosts,
            updateHosts: updateHosts,
            getHosts: getHosts,
            gerarArquivoDHCP: gerarArquivoDHCP,
            getDHCPD: getDHCPD,
            getQtdTipo: getQtdTipo,
            getDash: getDash,
            getFaixaIP: getFaixaIP,
            getFiltro: getFiltro
        });
    });
