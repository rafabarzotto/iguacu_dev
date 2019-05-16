'use strict';

/**
 * Route configuration for the RDash module.
 */
angular.module('RDash').config(function($stateProvider, $urlRouterProvider, $httpProvider) {

        var viewsPrefix = 'templates/';

        // Application routes
        $stateProvider
            .state('index', {
                url: '',
                abstract: true,
                views: {
                    '': {
                        templateUrl: viewsPrefix + 'layout/layout.html',
                        controller: 'MasterCtrl'
                    }
                }
            })
            .state('index.home', {
                url: '/home',
                views: {
                    'content': {
                        templateUrl: viewsPrefix + 'dashboard.html',
                        controller: 'DashCtrl'
                    }
                }
            })
            .state('index.listaHosts', {
                url: '/listaHosts',
                views: {
                    'content': {
                        templateUrl: viewsPrefix + 'listaHosts.html',
                        controller: 'CtrlListaHosts'
                    }
                }
            })
            .state('index.cadHosts', {
                url: '/cadHosts',
                views: {
                    'content': {
                        templateUrl: viewsPrefix + 'cadHosts.html',
                        controller: 'CtrlCadHosts'
                    }
                }
            })
            .state('index.edtHosts/:id', {
                url: '/edtHosts/:id',
                views: {
                    'content': {
                        templateUrl: viewsPrefix + 'edtHosts.html',
                        controller: 'CtrlEdtHosts'
                    }
                }
            })
            .state('login', {
                url: "/login",
                templateUrl: viewsPrefix + "login.html",
                data: {
                    pageTitle: 'Login'
                },
                controller: 'LoginCtrl',
            })

        // For unmatched routes
        $urlRouterProvider.otherwise('/login');
        
    })

    .run(['$rootScope', '$location', '$cookieStore', '$http',
        function($rootScope, $location, $cookieStore, $http) {
            // keep user logged in after page refresh
            $rootScope.globals = $cookieStore.get('globals') || {};
            if ($rootScope.globals.currentUser) {
                $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata; // jshint ignore:line
            }

            $rootScope.$on('$locationChangeStart', function(event, next, current) {
                // redirect to login page if not logged in
                if ($location.path() !== '/login' && !$rootScope.globals.currentUser) {
                    $location.path('/login');
                }
            });
        }
    ]);