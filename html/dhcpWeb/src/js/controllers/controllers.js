angular.module('starter.controllers', [])

    .controller('HeaderCtrl', function($scope, $rootScope, $location, apiFactory, alertService, toastr) {

        $rootScope.closeAlert = alertService.closeAlert;

    })

    .controller('DashCtrl', function($scope, $rootScope, $http, $stateParams, $filter, $location, apiFactory, toastr, usSpinnerService) {

        $scope.dhcpd = "";
        $scope.qtdTipo = [];
        $scope.dash = "";

        $scope.statusServerDHCP = function(op) {
            usSpinnerService.spin('spinner-1');
            apiFactory.getDHCPD(op).then(function(succ) {
                $scope.dhcpd = succ;
                usSpinnerService.stop('spinner-1');
            }, function error(err) {
                console.log('Errror: ', err);
                usSpinnerService.stop('spinner-1');
                return err;
            }).finally(function() {});
        }

        $scope.gerarDhcp = function() {
            usSpinnerService.spin('spinner-1');
            apiFactory.gerarArquivoDHCP().then(function(succ) {
                console.log('Sucesso: ', succ);
                toastr.success('Salvo com Sucesso!!');
                usSpinnerService.stop('spinner-1');
            }, function error(err) {
                toastr.danger('I don\'t need a title to live');
                console.log('Errror: ', err);
                usSpinnerService.stop('spinner-1');
            }).finally(function() {});
            $scope.statusServerDHCP('restart');
        };

        $scope.getQtdTipo = function() {
            apiFactory.getQtdTipo().then(function(succ) {
                $scope.qtdTipo = succ;
            }, function error(err) {
                console.log('Errror: ', err);
            }).finally(function() {});
        };

        $scope.getDashboard = function() {
            apiFactory.getDash().then(function(succ) {
                $scope.dash = succ;
            }, function error(err) {
                console.log('Errror: ', err);
            }).finally(function() {});
        };

        $scope.statusServerDHCP('service');
        $scope.getQtdTipo();
        $scope.getDashboard();
    })

    .controller('CtrlCadHosts', function($scope, $http, $stateParams, $timeout, $filter, $location, uibDateParser, apiFactory, toastr) {


        $scope.cadHost = [];

        $scope.setTipo = function(value) {
            $scope.selected = value;
            $scope.cadHost.tipo = value;
        };

        $scope.cadHost.status_dhcp = false;
        $scope.getTextDHCP = function() {
            return $scope.cadHost.status_dhcp ? "Sim" : "Não";
        };

        $scope.cadHost.liberado_firewall = false;
        $scope.getTextFW = function() {
            return $scope.cadHost.liberado_firewall ? "Sim" : "Não";
        };

        $scope.saveHosts = function(newHost) {
            var host = {
                //id: "", auto-increment
                ip_address: newHost.ip_address.split(" ").join(""),
                mac_address: newHost.mac_address,
                descricao: newHost.descricao,
                status_dhcp: newHost.status_dhcp,
                tipo: newHost.tipo,
                local: newHost.local,
                equipamento: newHost.equipamento,
                user: '',
                pass: '',
                usuario: newHost.usuario,
                cel_usuario: newHost.cel_usuario,
                obs: newHost.obs,
                ip_adc1: newHost.ip_adc1,
                ip_adc2: newHost.ip_adc2,
                ip_adc3: newHost.ip_adc3,
                user_proxy: newHost.user_proxy,
                liberado_firewall: newHost.liberado_firewall
            }
            apiFactory.saveHosts(host).then(function(succ) {
                console.log(succ);
                toastr.success('Salvo com Sucesso!!');
                $location.path('/listaHosts');
            }, function error(err) {
                toastr.warning('ERRO - IP OU MAC DUPLICADO');
                console.log('Errror: ', err);
            }).finally(function() {});
        };

        $scope.cancel = function() {
            toastr.warning('Operação Cancelada!');
            $location.path('/listaHosts');
        };

        $scope.items = [
            'Celular',
            'Computador',
            'Notebook',
            'Servidor',
            'Impressora',
            'ThinClient',
            'Telefone Voip',
            'PrintServer',
            'Roteador',
            'Switch',
            'Rel Ponto',
            'Outros'
        ];

        $scope.status = {
            isopen: false
        };

        $scope.toggleDropdown = function($event) {
            $event.preventDefault();
            $event.stopPropagation();
            $scope.status.isopen = !$scope.status.isopen;
        };

    })

    .controller('CtrlListaHosts', function($scope, $http, $stateParams, apiFactory, NgTableParams, usSpinnerService) {

        $scope.items = [];

        $scope.getHosts = function() {
            apiFactory.getHosts().then(function(succ) {
                $scope.dados = succ;
            }, function error(err) {
                console.log('Errror: ', err);
                usSpinnerService.stop('spinner-2');
            }).finally(function() {});
        };

        $scope.getFaixaIP = function() {
            apiFactory.getFaixaIP().then(function(succ) {
                $scope.items = succ;
            }, function error(err) {
                console.log('Errror: ', err);
            }).finally(function() {});
        };

        $scope.getFiltro = function(faixa) {
            usSpinnerService.spin('spinner-2');
            apiFactory.getFiltro(faixa).then(function(succ) {
                $scope.dados = succ;
                usSpinnerService.stop('spinner-2');
            }, function error(err) {
                console.log('Errror: ', err);
                usSpinnerService.stop('spinner-2');
            }).finally(function() {});
        };


        $scope.getHosts();
        $scope.getFaixaIP();

        var tp = new NgTableParams({}, {
            dataset: $scope.dados
        });

        $scope.setFaixa = function(value) {
            $scope.selected = value;
            $scope.faixaIP = value;
            $scope.getFiltro(value);
        };

        $scope.status = {
            isopen: false
        };

        $scope.toggleDropdown = function($event) {
            $event.preventDefault();
            $event.stopPropagation();
            $scope.status.isopen = !$scope.status.isopen;
        };

    })

    .controller('CtrlEdtHosts', function($scope, $http, $stateParams, $location, apiFactory, toastr) {

        $scope.items = [
            'Celular',
            'Computador',
            'Notebook',
            'Servidor',
            'Impressora',
            'ThinClient',
            'Telefone Voip',
            'PrintServer',
            'Roteador',
            'Switch',
            'Rel Ponto',
            'Outros'
        ];

        $scope.status = {
            isopen: false
        };

        $scope.setTipo = function(value) {
            $scope.selected = value;
            $scope.edtHost.tipo = value;
        }

        $scope.toggleDropdown = function($event) {
            $event.preventDefault();
            $event.stopPropagation();
            $scope.status.isopen = !$scope.status.isopen;
        };

        $scope.getForId = function(id) {
            apiFactory.getForId(id).then(function(succ) {
                console.log(succ);
                $scope.edtHost = succ;
            }, function error(err) {
                console.log('Errror: ', err);
            }).finally(function() {});
        };

        $scope.getForId($stateParams.id);

        $scope.updateHosts = function(updateHost) {
            var host = {
                ip_address: updateHost.ip_address.split(" ").join(""),
                mac_address: updateHost.mac_address,
                descricao: updateHost.descricao,
                status_dhcp: updateHost.status_dhcp,
                tipo: updateHost.tipo,
                local: updateHost.local,
                equipamento: updateHost.equipamento,
                user: '',
                pass: '',
                usuario: updateHost.usuario,
                cel_usuario: updateHost.cel_usuario,
                obs: updateHost.obs,
                ip_adc1: updateHost.ip_adc1,
                ip_adc2: updateHost.ip_adc2,
                ip_adc3: updateHost.ip_adc3,
                user_proxy: updateHost.user_proxy,
                liberado_firewall: updateHost.liberado_firewall
            }
            apiFactory.updateHosts($stateParams.id, host).then(function(succ) {
                console.log(succ);
                toastr.success('Salvo com Sucesso!!');
                $location.path('/listaHosts');
            }, function error(err) {
                toastr.warning('ERRO! - IP OU MAC DUPLICADO');
                console.log('Errror: ', err);
            }).finally(function() {});
        };

        $scope.cancel = function() {
            toastr.warning('Operação Cancelada!');
            $location.path('/listaHosts');
        };

    });