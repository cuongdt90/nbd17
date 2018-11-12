window._ = require('lodash');
window.angular = require('angular');
require('fabric');
window.$ = window.jQuery = require('jquery');
require('jquery-touchswipe');


var appConfig = {
    ready: false,
};
var nbdpbApp = angular.module('nbdpb-app', []);
nbdpbApp.controller('designCtrl', ['$scope', 'FabricWindow', 'NBDDataFactory', '$window', '$timeout', '$http', '$document', '$interval',
    function ($scope, FabricWindow, NBDDataFactory, $window, $timeout, $http, $document, $interval) {

        console.log(NBDESIGNCONFIG);
        // debugger;

        // init
        $scope.isStartDesign = false;
        $scope.showAdminTool = false;
        $scope.onloadTemplate = false;
        $scope.side = [0, 1];
        $scope.init = function () {
            $scope.initSettings();
        };
        $scope.defaultStageStates = {};
        $scope.initSettings = function () {
            $scope.settings = {};
            $scope.stages = [];
            $scope.side = [0,1];
            $scope.resource = {
                proAttrs: [],
                showValue: false,
                proAttrActive: 0,
                jsonDesign: {},
                config: {}
            };
            angular.copy(NBDESIGNCONFIG, $scope.settings);
            angular.extend($scope.settings, {
                showRuler: false,
                showGrid: false,
                bleedLine: false,
                snapMode: {status: false, type: 'layer'},
                showWarning: {oos: false, ilr: false}
            });
            $scope.rateConvertCm2Px96dpi = 37.795275591;
            $scope.currentStage = 0;
            $scope.tempStageDesign = null;
            $scope.includeExport = ['itemId', 'opIndex', 'selectable', 'lockMovementX', 'lockMovementY','lockScalingX', 'lockScalingY', 'evented'];
            $scope.processProductSettings();
        };
        $scope.processProductSettings = function(){
            if ($scope.settings.product_data.design !== null) {
                var indexSide = 0;
                _.each($scope.settings.product_data.design, function(side, index){
                    $scope.stages[indexSide] = {
                        config: {
                        },
                        states: {},
                        undos: [],
                        redos: [],
                        layers: [],
                        canvas: {}
                    };
                    var _state = $scope.stages[indexSide].states;
                    angular.copy($scope.defaultStageStates, _state);
                    indexSide++;
                });
                $scope.resource.proAttrs = $scope.settings.product_data.config.proAttrs;
            }else{
                // TODO init stage with slide
                _.each($scope.side, function(side, index){
                    // _.each($scope.side, function(side, index){
                    $scope.stages[index] = {
                        config: {
                        },
                        states: {},
                        undos: [],
                        redos: [],
                        layers: [],
                        canvas: {}
                    };
                    var _state = $scope.stages[index].states;
                    angular.copy($scope.defaultStageStates, _state);
                });
                $scope.resource.proAttrs = [
                    {
                        // id: 'f1',
                        name: 'Base',
                        alias: 'base',
                        img: 'assets/images/shoes.png',
                        proValue: [
                            {
                                name: 'Black Suede',
                                alias: 'black-suede',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    '//dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/hoodie-with-zipper-2-324x324.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Summit White Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    '//dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/hoodie-with-zipper-2-324x324.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Pale Grey Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Trooper Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    '//dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/hoodie-with-zipper-2-324x324.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Light Armor blue suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'plum fog suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },

                        ]
                    },
                    {
                        name: 'quarter',
                        // id: 'f2',
                        alias: 'quarter',
                        img: 'assets/images/shoes.png',
                        proValue: [
                            {
                                name: 'Black Suede',
                                alias: 'black-suede',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Summit White Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Pale Grey Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Trooper Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Light Armor blue suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'plum fog suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },

                        ]
                    },
                    {
                        name: 'Swoosh',
                        alias: 'swoosh',
                        img: 'assets/images/shoes.png',
                        proValue: [
                            {
                                name: 'Black Suede',
                                alias: 'black-suede',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Summit White Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Pale Grey Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Trooper Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Light Armor blue suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'plum fog suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },

                        ]
                    },
                    {
                        name: 'Tongue Style',
                        alias: 'tongue-style',
                        img: 'assets/images/shoes.png',
                        proValue: [
                            {
                                name: 'Black Suede',
                                alias: 'black-suede',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Summit White Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Pale Grey Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Trooper Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Light Armor blue suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'plum fog suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },

                        ]
                    },
                    {
                        name: 'laces',
                        alias: 'laces',
                        img: 'assets/images/shoes.png',
                        proValue: [
                            {
                                name: 'Black Suede',
                                alias: 'black-suede',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Summit White Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Pale Grey Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Trooper Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Light Armor blue suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'plum fog suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },

                        ]
                    },
                    {
                        name: 'additional laces',
                        alias: 'additional-laces',
                        img: 'assets/images/shoes.png',
                        proValue: [
                            {
                                name: 'Black Suede',
                                alias: 'black-suede',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Summit White Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Pale Grey Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Trooper Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Light Armor blue suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'plum fog suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },

                        ]
                    },
                    {
                        name: 'Sidewall',
                        alias: 'sidewall',
                        img: 'assets/images/shoes.png',
                        proValue: [
                            {
                                name: 'Black Suede',
                                alias: 'black-suede',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Summit White Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Pale Grey Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Trooper Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Light Armor blue suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'plum fog suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },

                        ]
                    },
                    {
                        name: 'toe cap',
                        alias: 'toe-cap',
                        img: 'assets/images/shoes.png',
                        proValue: [
                            {
                                name: 'Black Suede',
                                alias: 'black-suede',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Summit White Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Pale Grey Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Trooper Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'Light Armor blue suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'plum fog suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'black canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },
                            {
                                name: 'white canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                                color: '#000',
                                src: [
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                    'http://dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/beanie-2.jpg',
                                ]
                            },

                        ]
                    },
                    {
                        name: 'outsole',
                        alias: 'outsole',
                        img: 'assets/images/shoes.png',
                        proValue: [
                            {
                                name: 'Black Suede',
                                alias: 'black-suede',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png'
                            },
                            {
                                name: 'Summit White Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png'
                            },
                            {
                                name: 'Pale Grey Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png'
                            },
                            {
                                name: 'Trooper Suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png'
                            },
                            {
                                name: 'Light Armor blue suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png'
                            },
                            {
                                name: 'plum fog suede',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png'
                            },
                            {
                                name: 'black perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png'
                            },
                            {
                                name: 'white perforated leather',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png'
                            },
                            {
                                name: 'black canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png'
                            },
                            {
                                name: 'white canvas',
                                alias: '',
                                img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png'
                            },

                        ]
                    },

                ];
            }

            console.log($scope.stages);
        };
        $scope.initStageSetting = function( id ){
            $scope.setStageDimension(id);
            $scope.renderStage(id);
            $scope.updateApp();
        };
        $scope.setStageDimension = function(id){
            id = angular.isDefined(id) ? id : $scope.currentStage;
            var _stage = $scope.stages[id];
            var currentWidth = $('#stage-' + id + ' .stage-main').outerWidth(),
                currentHeight = $('#stage-' + id + ' .stage-main').outerHeight();
            $scope.stages[id]['canvas'].setDimensions({'width' : currentWidth, 'height' : currentHeight});
        };

        $scope.showValue = function (index) {
            $scope.resource.showValue = !$scope.resource.showValue;
            if (index) $scope.resource.proAttrActive = index;
        };
        $scope.addProValue = function (index) {
            var proAttrActive = $scope.resource.proAttrs[$scope.resource.proAttrActive];
            if (!angular.isUndefined(proAttrActive.itemId)) {
                _.each(proAttrActive.proValue[index].src, function (url, stage) {
                    var _item = $scope.getLayerById(proAttrActive.itemId, stage), element = _item.getElement();
                    element.setAttribute("src", url);
                    _item.set({
                        dirty: true,
                        width: _item.width,
                        height: _item.height,
                        scaleX: _item.scaleX,
                        scaleY: _item.scaleY
                    });
                    $scope.deactiveAllLayer(stage);
                    $scope.renderStage();
                });
            }else{
                var newItemId = '';
                _.each(proAttrActive.proValue[index].src, function (url, stage) {
                    fabric.Image.fromURL(url, function (obj) {
                        var _stage = $scope.stages[stage], _canvas = _stage.canvas;
                        var max_width = _canvas.width * .9,
                            max_height = _canvas.height * .9,
                            new_width = max_width;
                        if (obj.width < max_width) new_width = obj.width;
                        var width_ratio = new_width / obj.width,
                            new_height = obj.height * width_ratio;
                        if (new_height > max_height) {
                            new_height = max_height;
                            var height_ratio = new_height / obj.height;
                            new_width = obj.width * height_ratio;
                        }

                        obj.set({
                            fill: '#ff0000',
                            scaleX: new_width / obj.width,
                            scaleY: new_height / obj.height
                        });
                        _canvas.add(obj);
                        if (newItemId == '') {
                            newItemId = obj.get('itemId');

                        }else{
                            obj.set({'itemId': newItemId});
                        }
                        proAttrActive.itemId = newItemId;
                        $scope.deactiveAllLayer(stage);
                        $scope.renderStage();
                    });
                });
            }

        };
        $scope.getLayerById = function(itemId, stage=null){
            var _canvas = null;
            if (!angular.isUndefined(stage)) {
                _canvas = $scope.stages[stage].canvas;
            }else {
                _canvas = $scope.stages[$scope.currentStage].canvas;
            }
            var _object = null;
            _canvas.forEachObject(function(obj, index) {
                if(obj.get('itemId') == itemId) _object = obj;
            });
            return _object;
        };

        $scope.deactiveAllLayer = function(stage_id){
            stage_id = stage_id ? stage_id :  $scope.currentStage;
            $scope.stages[stage_id]['canvas'].discardActiveObject();
            $scope.renderStage();
            $scope.updateApp();
        };
        $scope.renderStage = function( stage_id ){
            stage_id = stage_id ? stage_id :  $scope.currentStage;
            $scope.stages[stage_id]['canvas'].calcOffset();
            $scope.stages[stage_id]['canvas'].requestRenderAll();
        };
        $scope.updateApp = function(){
            if ($scope.$root.$$phase !== "$apply" && $scope.$root.$$phase !== "$digest") $scope.$apply();
        };
        $scope.setStackPosition = function(command, _item){
            var item = _item ? _item : $scope.stages[$scope.currentStage]['canvas'].getActiveObject();
            switch(command){
                case 'bring-front':
                    item.bringToFront();
                    $scope.setStackLayerAlwaysOnTop();
                    break;
                case 'bring-forward':
                    item.bringForward();
                    break;
                case 'send-backward':
                    item.sendBackwards();
                    break;
                case 'send-back':
                    item.sendToBack();
                    break;
                default:
                    var index = parseInt(command);
                    item.moveTo(index);
            }
            $scope.renderStage();
        };
        $scope.calcViewport = function(){
            var _offsetWidth = checkMobileDevice() ? 20 : 100,
                _offsetHeight = checkMobileDevice() ? 70 : 100,
                _width = $('.design-stages').width() - _offsetWidth,
                _height = $('.design-stages').height() - _offsetHeight;

            if(navigator.userAgent.indexOf("Safari")!=-1 && navigator.userAgent.indexOf("CriOS") ==-1 && $scope.theFirstCalcViewport){
                if( checkMobileDevice() ) _height -= 50;
            }
            return {width: _width, height: _height};
        };
        $scope.makeblob = function (dataURL) {
            var BASE64_MARKER = ';base64,';
            if (dataURL.indexOf(BASE64_MARKER) == -1) {
                var parts = dataURL.split(',');
                var contentType = parts[0].split(':')[1];
                var raw = decodeURIComponent(parts[1]);
                return new Blob([raw], { type: contentType });
            }
            var parts = dataURL.split(BASE64_MARKER);
            var contentType = parts[0].split(':')[1];
            var raw = window.atob(parts[1]);
            var rawLength = raw.length;
            var uInt8Array = new Uint8Array(rawLength);
            for (var i = 0; i < rawLength; ++i) {
                uInt8Array[i] = raw.charCodeAt(i);
            }
            return new Blob([uInt8Array], { type: contentType });
        };
        $scope.saveData = function () {
            // show loading

            $('.nbdpb-load-page').addClass('nbdpb-show');
            $('.nbdpb-custom-design').empty().hide();

            $('body').addClass('nbdpb-no-overflow');
            $scope.saveDesign();
            $scope.resource.config.viewport = $scope.calcViewport();
            $scope.resource.config.product = $scope.settings.product_data.product;
            $scope.resource.config.proAttrs = $scope.resource.proAttrs;
            var dataObj = {};
            dataObj.design = new Blob([JSON.stringify($scope.resource.jsonDesign)], {type: "application/json"});
            _.each($scope.stages, function(stage, index){
                var key = 'frame_' + index,
                    svg_key = 'frame_' + index + '_svg';
                dataObj[key] = $scope.makeblob(stage.design);
            });
            ['product_id', 'variation_id', 'task', 'nbd_item_key', 'cart_item_key', 'order_id', 'auto_add_to_cart'].forEach(function(key){
                dataObj[key] = NBDESIGNCONFIG[key];
            });

            dataObj.config = new Blob([JSON.stringify($scope.resource.config)], {type: "application/json"});
            var action = 'nbd_save_product_builder_design';
            NBDDataFactory.get(action, dataObj, function(data){
                $('.nbdpb-load-page').removeClass('nbdpb-show');
                console.log(data);
                // debugger;
                data = JSON.parse(data);
                if(data.flag == 'success'){
                    $('.nbdpb-custom-design').show();
                    // debugger;
                    _.each(data.image, function (image, frame) {
                        image += '?t=' + Math.random();
                        var item = '<div class="item">' +
                                '<img src="' + image + '" alt="Custom Design"/>' +
                            '</div>';
                        $('.nbdpb-custom-design').append(item);
                    });
                    $('.close-popup').triggerHandler('click');
                }else{
                    alert('Oops! Design has not been saved!');
                    console.log('Oops! Design has not been saved!');
                    // $scope.toggleStageLoading();
                }
            });
        };

        $scope.saveDesign = function () {
            _.each($scope.stages, function (stage, index) {
                $scope.deactiveAllLayer(index);
                var _canvas = stage.canvas,
                    key = 'frame_' + index;
                $scope.renderStage(index);
                $scope.resource.jsonDesign[key] = _canvas.toJSON($scope.includeExport);
                stage.svg = _canvas.toSVG();
                stage.design = _canvas.toDataURL();
            });
        };

        $scope.onObjectAdded = function (id, options) {
            var _stage = $scope.stages[$scope.currentStage],
                _canvas = _stage['canvas'],
                item = options.target,
                d = new Date(),
                itemId = d.getTime() + Math.floor(Math.random() * 1000);

            item.set({"itemId" : itemId});
            _canvas.viewportCenterObject(item);

            var top = item.get('top'), left = item.get('left');
            item.set({top: top - 50});

            item.animate('top', top, {
                duration: 400,
                onChange: function(){
                    $scope.renderStage();
                },
                onComplete: function(){
                    $scope.renderStage();
                },
                easing: FabricWindow.util.ease['easeInQuad']
            });
        };
        $scope.onMouseOver = function (id, options) {
            var _stage = $scope.stages[$scope.currentStage],
                _canvas = _stage['canvas'],
                item = options.target;
            if (item) {
                item.set('opacity', '0.5');
            }
            _canvas.renderAll();
        };
        $scope.onMouseOut = function (id, options) {
            var _stage = $scope.stages[$scope.currentStage],
                _canvas = _stage['canvas'],
                item = options.target, itemId = '', proAttr = null;
            if (item) {
                item.set('opacity', '1');
            }
            _canvas.renderAll();
        };
        $scope.onMouseDown = function (id, options) {
            var _stage = $scope.stages[$scope.currentStage],
                _canvas = _stage['canvas'],
                item = options.target, itemId = '', proAttr = null;
            if (item) {
                if (!angular.isUndefined(item.get('itemId'))) itemId = item.get('itemId');
                // get product attribute match with key
                proAttr = _.pickBy($scope.resource.proAttrs, function (value, key) {
                    return value.itemId == itemId;
                });

                if (!angular.isUndefined(_.keys(proAttr)[0])) {
                    $scope.resource.showValue = true;
                    $scope.resource.proAttrActive = _.keys(proAttr)[0];
                    $scope.updateApp();
                }
            }
        };

        $scope.onSelectionCreated = function (id, options) {
            if (options.target) {
                $scope.showAdminTool = true;
                $scope.updateApp();
            }

        };

        $scope.onSelectionCleared = function (id, options) {
            $scope.showAdminTool = false;
            $scope.updateApp();
        };



        /*
         * Deactive all layer if click outer canvas
         * Hide context menu
         * Store stages
         */
        $scope.$on('canvas:created', function(event, id, last){
            /* init canvas parameters */
            $scope.initStageSetting(id);
            var _canvas = $scope.stages[id].canvas;

            /* Listen canvas events */
            _canvas.on('mouse:over', function (options) {
                $scope.onMouseOver(id, options);
            });
            _canvas.on('mouse:out', function (options) {
                $scope.onMouseOut(id, options);
            });
            _canvas.on('mouse:down', function (options) {
                $scope.onMouseDown(id, options);
            });

            _canvas.on('object:added', function (options) {
                if (!$scope.onloadTemplate) $scope.onObjectAdded(id, options);
            });
            _canvas.on('selection:created', function(options){
                $scope.onSelectionCreated(id, options);
            });
            _canvas.on('selection:cleared', function (options) {
                $scope.onSelectionCleared(id, options);
            });
            /* Load template after render canvas */
            if (last == '1') {
                appConfig.ready = true;
                $scope.loadTemplateAfterRenderCanvas();
            }

        });
        $scope.loadTemplateAfterRenderCanvas = function () {
            $timeout(function () {
                function loadTemplate() {
                    if( angular.isDefined($scope.settings.product_data.design) && $scope.settings.product_data.design !== null){
                        var config = $scope.settings.product_data.config;
                        var viewport = config.viewport;
                        if( angular.isUndefined( config.viewport ) && angular.isDefined( config.scale ) ){
                            viewport = {width: config.scale * 500, height: config.scale * 500};
                        }
                        $scope.insertTemplate(true, {design: $scope.settings.product_data.design, viewport: viewport});
                    }else {
                    }
                }
                loadTemplate();
            });
        };

        $scope.insertTemplate = function(local, temp){
            $scope.onloadTemplate = true;
            if( angular.isUndefined( temp.doNotShowLoading ) ){
                // $scope.toggleStageLoading();
                // $scope.showDesignTab();
            }
            function loadDesign( design, viewport){
                var stageIndex = 0;
                function loadStage(stageIndex){
                    var _index = 'frame_' + stageIndex,
                        stage = $scope.stages[stageIndex],
                        _canvas = stage['canvas'],
                        layerIndex = 0;
                    _canvas.clear();
                    if( angular.isUndefined(design[_index]) ){
                        design[_index] = {version:"2.3.3",objects:[]};
                    };
                    if( angular.isDefined(design[_index].background) ){
                        _canvas.backgroundColor = design[_index].background;
                    };
                    var objects = design[_index].objects;
                    function loadLayer(layerIndex){
                        function continueLoadLayer(){
                            layerIndex++;
                            if( objects.length != 0 && layerIndex < objects.length ){
                                loadLayer(layerIndex);
                            }else{
                                stageIndex++;
                                if( stageIndex < $scope.stages.length ){
                                    loadStage(stageIndex);
                                }else{
                                    _.each($scope.stages, function(_stage, index){
                                        $scope.renderStage(index);
                                        $scope.onloadTemplate = false;
                                        // var layers = _stage.canvas.getObjects();
                                        // $scope.renderTextAfterLoadFont(layers, function(){
                                        //     $scope.deactiveAllLayer();
                                        //     $scope.renderStage(index);
                                        //     $timeout(function(){
                                        //         $scope.deactiveAllLayer();
                                        //         $scope.renderStage(index);
                                        //         if( index == $scope.stages.length - 1 ){
                                        //             $scope.onloadTemplate = false;
                                        //             $scope.contextAddLayers = 'normal';
                                        //             if( angular.isDefined(viewport) ){
                                        //                 $scope.resizeStages(viewport);
                                        //             }else{
                                        //                 $scope.toggleStageLoading();
                                        //             }
                                        //         }
                                        //     }, 500);
                                        // });
                                    });
                                }
                            }
                        }
                        if( objects.length > 0 ){
                            var item = objects[layerIndex],
                                type = item.type;
                            if( type == 'image' || type == 'custom-image' ){
                                fabric.Image.fromObject(item, function(_image){
                                    _canvas.add(_image);
                                    continueLoadLayer();
                                });
                            }
                        }else{
                            continueLoadLayer();
                        }
                    };
                    loadLayer(layerIndex);
                };
                loadStage(stageIndex);
            }
            if( local ){
                loadDesign(temp.design, temp.viewport);
            }
        };

        $scope.toggleStageLoading = function () {
            alert('toogleStageLoading');
        };

        $scope.$watch('isStartDesign', function () {
            var _stages = $scope.stages;
            if ($scope.isStartDesign) {
                _.each(_stages, function (stage, id) {
                    $scope.initStageSetting(id);
                });
            }
        });
        $scope.init();
    }
]);

nbdpbApp.factory('FabricWindow', ['$window', function($window) {
    /* Fabric configuration */
    $window.fabric.Object.prototype.set({
//        centeredScaling: true,
        transparentCorners: false,
        borderColor: 'rgba(79, 84, 103,0.7)',
        cornerStyle: 'circle',
        cornerColor: 'rgba(255,255,255,1)',
        borderDashArray:[2,2],
        cornerStrokeColor: 'rgba(63, 70, 82,1)',
        fill : NBDESIGNCONFIG.nbdesigner_default_color,
        hoverCursor: 'pointer',
        borderOpacityWhenMoving: 0
    });
    if( checkMobileDevice() ) $window.fabric.Object.prototype.set({cornerSize: 17});
    $window.fabric.IText.prototype.set({
        cursorWidth: 1,
        cursorColor: '#000',
        selectionColor: "rgba(19, 147, 255, 0.3)",
        cursorDuration: 500
    });
    if( NBDESIGNCONFIG.nbdesigner_enable_text_free_transform == 'no' ){
        $window.fabric.IText.prototype.set({
            _controlsVisibility: {
                tl: true,
                tr: true,
                br: true,
                bl: true,
                ml: false,
                mt: false,
                mr: false,
                mb: false,
                mtr: true
            }
        });
    }
    $window.fabric.Canvas.prototype.set({
        preserveObjectStacking : true,
        controlsAboveOverlay: true,
        selectionColor: 'rgba(1, 196, 204, 0.3)',
        selectionBorderColor: '#01c4cc',
        selectionLineWidth: 0.5,
        centeredKey: "shiftKey",
        uniScaleKey: "altKey"
    });
    $window.fabric.Textbox.prototype.set({
        _controlsVisibility: {
            tl: false,
            tr: false,
            br: false,
            bl: false,
            ml: true,
            mt: false,
            mr: true,
            mb: false,
            mtr: true
        }
    });
    return $window.fabric;
}]);
nbdpbApp.directive('nbdCanvas', ['FabricWindow', '$timeout', '$rootScope', function(FabricWindow, $timeout, $rootScope){
    return {
        restrict: "AE",
        scope: {
            stage: '=stage',
            index: '@',
            last: '@'
        },
        link: function( scope, element, attrs ) {
            $timeout(function() {
                scope.stage.canvas = new FabricWindow.Canvas('canvas-' + scope.index);
                scope.$emit('canvas:created', scope.index, scope.last);
            });
        }
    }
}]);

nbdpbApp.factory('NBDDataFactory', function($http){
    return {
        get : function(action, data, callback) {
            var formData = new FormData();
            formData.append("action", action);
            var nonce = action == 'nbd_get_resource' ? NBDESIGNCONFIG['nonce_get'] : NBDESIGNCONFIG['nonce'];
            formData.append("nonce", nonce);
            angular.forEach(data, function (value, key) {
                var keepDefault = ['file', 'design', 'config', 'product', 'upload', 'used_font', 'option'];
                if( typeof value != 'object' || _.includes(keepDefault, key) || key.indexOf("frame") > -1 ){
                    formData.append(key, value);
                }else{
                    var keyName;
                    for (var k in value) {
                        if (value.hasOwnProperty(k)) {
                            keyName = [key, '[', k, ']'].join('');
                            formData.append(keyName, value[k]);
                        }
                    }
                }
            });
            var config = {
                transformRequest: angular.identity,
                transformResponse: angular.identity,
                headers: {
                    'Content-Type': undefined
                }
            };
            var url = NBDESIGNCONFIG['ajax_url'];
            $http.post(url, formData, config).then(
                function(response) {
                    callback(response.data);
                },
                function(response) {
                    console.log(response);
                }
            );
        }
    }
});

function checkMobileDevice(){
    var isMobile = false;
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;
    return isMobile;
};
$.fn.nbShowPopup = function () {
    return this.each(function () {
        var sefl = this;
        var $close = $(this).find('.overlay-popup, .close-popup');
        if (!$(this).hasClass('nbdpb-show')) {
            $(this).addClass('nbdpb-show');
        }
        $close.on('click', function () {
            $(sefl).removeClass('nbdpb-show');
            $('body').removeClass('nbdpb-no-overflow');
            var $scope = angular.element(document.getElementById("design-container")).scope();
            $scope.isStartDesign = false;
            $scope.updateApp();
        });
    });
};
$.fn.nbdpbCarousel = function () {
    var seflC = this;
    this.itemActive = function ($carousel) {
        var $items = $carousel.find('.nbdpb-carousel-item'), $itemA = $items.filter('.nbdpb-active'),
            $nav = $carousel.closest('.nbdpb-carousel-outer').find('.js-nav-item'),
            $dots = $carousel.closest('.nbdpb-carousel-outer').find('.nbdpb-owl-dots');
        var curT = ($carousel.offset().left - $itemA.offset().left);

        $nav.removeClass('nbdpb-disabled');
        // dot
        $dots.find('.nbdpb-owl-dot').removeClass('nbdpb-active');
        $dots.find('.nbdpb-owl-dot').filter(function (i) {
            return i === $itemA.index();
        }).addClass('nbdpb-active');

        $carousel.css({
            transform: 'translate3d(' + curT + 'px, 0, 0)'
        });

        var $scope = angular.element(document.getElementById("design-container")).scope(),
            stage = $itemA.find('.stage').data('stage');
        $scope.currentStage = stage;
        $scope.updateApp();

    };
    return this.each(function () {
        var $sefl = $(this), $items = $(this).find('.nbdpb-carousel-item'),
            $outerCarousel = $(this).closest('.nbdpb-carousel-outer');
            // $nav = $outerCarousel.find('.js-nav-item');
        var cWith = 0, total = $items.length, dots = '<div class="nbdpb-owl-dots"></div>';
        var nav = '<div class="nbdpb-owl-nav"></div>',
            navPrev = '<button type="button" role="presentation" class="nbdpb-owl-prev js-nav-item">' +
                '<i aria-label="Previous" class="icon-nbd icon-nbd-chevron-right rotate180"></i>' +
                '</button>',
            navNext = '<button type="button" role="presentation" class="nbdpb-owl-next js-nav-item">' +
                '<i aria-label="Next" class="icon-nbd icon-nbd-chevron-right"></i>' +
                '</button>';

        var $dots = $(dots), $nav = $(nav), $navPrev = $(navPrev), $navNext = $(navNext);

        // init with carousel
        $outerCarousel.append($dots);
        $outerCarousel.append($nav);
        $nav.append($navPrev);
        $nav.append($navNext);


        $items.each(function (i) {
            var dot = '<button role="button" class="nbdpb-owl-dot"><span></span></button>';
            cWith += $(this).outerWidth();
            $(this).css({
                width: $(this).outerWidth()
            });
            $dots.append(dot);
        });
        $dots.find('.nbdpb-owl-dot').first().addClass('nbdpb-active');
        $(this).css({
            width: cWith + 'px'
        });

        // dot carousel
        $dots.find('.nbdpb-owl-dot').on('click', function () {
            var index = $(this).index();

            $dots.find('.nbdpb-owl-dot').removeClass('nbdpb-active');
            $(this).addClass('nbdpb-active');

            $items.removeClass('nbdpb-active');
            $items.filter(function (i) {
                return i === index;
            }).addClass('nbdpb-active');

            seflC.itemActive($sefl);
        });

        // nav carousel
        $navPrev.on('click', function () {
            var $itemA = $items.filter('.nbdpb-active');
            $itemA.removeClass('nbdpb-active');
            if ($itemA.index() == 0) {
                $items.last().addClass('nbdpb-active');
            }else {
                $itemA.prev().addClass('nbdpb-active');
            }
            seflC.itemActive($sefl);
        });
        $navNext.on('click', function () {
            var $itemA = $items.filter('.nbdpb-active');
            $itemA.removeClass('nbdpb-active');
            if ($itemA.index() == ($items.length - 1)) {
                $items.first().addClass('nbdpb-active');
            }else {
                $itemA.next().addClass('nbdpb-active');
            }
            seflC.itemActive($sefl);
        });
    });
};
function getTransform(el) {
    var results = $(el).css('transform').match(/matrix(?:(3d)\(\d+(?:, \d+)*(?:, (\d+))(?:, (\d+))(?:, (\d+)), \d+\)|\(\d+(?:, \d+)*(?:, (\d+))(?:, (\d+))\))/)
    if(!results) return [0, 0, 0];
    if(results[1] == '3d') return results.slice(2,5);
    results.push(0);
    return results.slice(5, 8);
}
$(document).ready(function ($) {
    $('#nbdpb-start-design').on('click', function () {
        $('body').addClass('nbdpb-no-overflow');
        $('.nbdpb-popup.popup-design').nbShowPopup().addClass('nbdpb-no-overflow');
        $('.nbdpb-carousel').nbdpbCarousel();

        // console.log(angular);
        var $scope = angular.element(document.getElementById("design-container")).scope();
        $scope.isStartDesign = true;
        $scope.updateApp();
    });

    // swipe
    if (checkMobileDevice()) {
        $("#nbdpb-app .stage").swipe( {
            //Generic swipe handler for all directions
            swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
                if (direction == 'left') $('.nbdpb-carousel-outer .nbdpb-owl-prev').triggerHandler('click');
                if (direction == 'right') $('.nbdpb-carousel-outer .nbdpb-owl-next').triggerHandler('click');
            },
            // Default is 75px, set to 0 for demo so any distance triggers swipe
            threshold: 0
        });
    }
});
