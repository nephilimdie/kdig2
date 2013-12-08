'use strict';

var globalTemplate = '<div compile-html="data"></div>';
// Declare app level module which depends on filters, and services
var kdig = angular.module('KdigApp', [
        'ui.compat', 
        'KdigApp.filters', 
        'KdigApp.services', 
        'KdigApp.directives', 
        'KdigApp.controllers', 
        'http-auth-interceptor'
            ])
            .constant('prefix', '/app_dev.php')
            .config([
                '$stateProvider', 
                '$routeProvider', 
                '$urlRouterProvider', 
                '$locationProvider', 
                '$httpProvider', 
                'prefix', 
                function($stateProvider, $routeProvider, $urlRouterProvider, $locationProvider, $httpProvider, prefix) {
                    fos.Router.getInstance().setBaseUrl(prefix);
                    $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
                    $locationProvider.html5Mode(true).hashPrefix('!');

                    $stateProvider  
                        .state('example', {
                            url: '/example',
                            template: globalTemplate,
//                            templateUrl: function(params) { return Routing.generate('index') },
                            controller: 'KdigApp.example',
//                            resolve: Resolver
                        });
                }
            ])
            ;
    /*
    config([
        '$stateProvider', 
        '$routeProvider', 
        '$urlRouterProvider', 
        '$locationProvider', 
        '$httpProvider', 
        'prefix', 
        function($stateProvider, $routeProvider, $urlRouterProvider, $locationProvider, $httpProvider, prefix) {

            fos.Router.getInstance().setBaseUrl(prefix);
            $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
            $locationProvider.html5Mode(true).hashPrefix('!');

            $stateProvider  
            
                .state('home', {
                    url: '/',
                    template: globalTemplate,
                    templateUrl: function(params) { return Routing.generate('index') },
//                    controller: LogoutCtrl,
                    resolve: Resolver
                })
                .state('us', {
                    url: '/us',
                    abstract: true, 
                    template: globalTemplate,
                    templateUrl: function(params) { return Routing.generate('us') },
//                    controller: LogoutCtrl,
                    resolve: Resolver
                })
                .state('us', {
                    url: '/home',
                    templateUrl: function(params) { return Routing.generate('us') },
//                    controller: LogoutCtrl,
                    resolve: Resolver
                })
                .state('us.show', {
                    url: '/show/:id',
                    templateUrl: function(params) { return Routing.generate('us_show', params) },
//                    controller: LogoutCtrl,
                    resolve: Resolver
                })
                .state('us.list', {
                    url: '/list',
                    templateUrl: function(params) { return Routing.generate('us_list') },
//                    controller: LogoutCtrl,
                    resolve: Resolver
                })
                .state('us.new', {
                    url: '/new',
                    templateUrl: function(params) { return Routing.generate('us_new', params) },
//                    controller: LogoutCtrl,
                    resolve: Resolver
                })
                .state('us.edit', {
                    url: '/edit/:id',
                    templateUrl: function(params) { return Routing.generate('us_edit', params) },
//                    controller: LogoutCtrl,
                    resolve: Resolver
                })
                .state('us.delete', {
                    url: '/delete/:id',
                    templateUrl: function(params) { return Routing.generate('us_delete', params) },
//                    controller: LogoutCtrl,
                    resolve: Resolver
                });
        }
    ]);*/
            /*.
    run(function($rootScope, $state) {
        $rootScope.$on('event:auth-loginRequired', function() {
            $state.transitionTo('demologin');
        });
    });
    /*
var kdigApp = angular.module('KdigApp', []).config(function($interpolateProvider){
        $interpolateProvider.startSymbol('[[').endSymbol(']]');
    }
);

kdigApp.controller('mainCtrl', ['$scope', function ($scope) {
        
}]);
kdigApp.controller('navCtrl', ['$scope', function ($scope) {
        
}]);
kdigApp.controller('userCtrl', ['$scope', function ($scope) {
        
}]);
*/