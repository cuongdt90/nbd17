window._ = require('lodash');
window.angular = require('angular');
require('fabric');
window.$ = window.jQuery = require('jquery');
require('jquery-touchswipe');

var nbdpbApp = angular.module('nbdpb-app', []);
nbdpbApp.controller('designCtrl', ['$scope', 'FabricWindow', '$window', '$timeout', '$http', '$document', '$interval',
    function ($scope, FabricWindow, $window, $timeout, $http, $document, $interval) {
        // init
        $scope.settings = {};
        $scope.stages = [];
        $scope.resource = {
            proAttrs: [
                {
                    name: 'Base',
                    alias: 'base',
                    img:'assets/images/shoes.png',
                    stage: [],
                    proValue: [
                        {
                            name: 'Black Suede',
                            alias: 'black-suede',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'Summit White Suede',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'Pale Grey Suede',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'Trooper Suede',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'Light Armor blue suede',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'plum fog suede',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'black perforated leather',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'white perforated leather',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'black canvas',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'white canvas',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },

                    ]
                },
                {
                    name: 'quarter',
                    alias: 'quarter',
                    stage: [],
                    img:'assets/images/shoes.png',
                    proValue: [
                        {
                            name: 'Black Suede',
                            alias: 'black-suede',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'Summit White Suede',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'Pale Grey Suede',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'Trooper Suede',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'Light Armor blue suede',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'plum fog suede',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'black perforated leather',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'white perforated leather',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'black canvas',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },
                        {
                            name: 'white canvas',
                            alias: '',
                            img: 'http://www.italiaveloce.it/png/telaio_magnifica/01.png',
                            color: '#000'
                        },

                    ]
                },
                {
                    name: 'Swoosh',
                    alias: 'swoosh',
                    stage: [],
                    img:'assets/images/shoes.png',
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
                {
                    name: 'Tongue Style',
                    alias: 'tongue-style',
                    stage: [],
                    img:'assets/images/shoes.png',
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
                {
                    name: 'laces',
                    alias: 'laces',
                    stage: [],
                    img:'assets/images/shoes.png',
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
                {
                    name: 'additional laces',
                    alias: 'additional-laces',
                    stage: [],
                    img:'assets/images/shoes.png',
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
                {
                    name: 'Sidewall',
                    alias: 'sidewall',
                    stage: [],
                    img:'assets/images/shoes.png',
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
                {
                    name: 'toe cap',
                    alias: 'toe-cap',
                    stage: [],
                    img:'assets/images/shoes.png',
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
                {
                    name: 'outsole',
                    alias: 'outsole',
                    stage: [],
                    img:'assets/images/shoes.png',
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

            ],
            showValue: false,
            proAttrActive: 0

        };
        $scope.isStartDesign = false;
        $scope.init = function () {
            $scope.initSettings();
        };
        $scope.defaultStageStates = {};
        $scope.initSettings = function () {
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
            $scope.processProductSettings();
        };
        $scope.processProductSettings = function(){
            var unitRatio = $scope.settings.nbdesigner_dimensions_unit == 'mm' ? 0.1 : ($scope.settings.nbdesigner_dimensions_unit == 'in' ? 2.54 : 1);
            $scope.rateConvert2Px = $scope.rateConvertCm2Px96dpi * unitRatio * parseFloat($scope.settings.product_data.option.dpi) / 96;
            _.each($scope.settings.product_data.product, function(side, index){
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
        $scope.saveDesign = function () {
            $scope.showValue.showValue = false;
        };
        $scope.addProValue = function (index) {
            var stage = $scope.stages[$scope.currentStage], _canvas = stage.canvas;
            fabric.Image.fromURL('//dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/hoodie-2-324x324.jpg', function (obj) {
                // check exits Attribute
                var proAttrActive = $scope.resource.proAttrs[$scope.resource.proAttrActive];
                if (proAttrActive.stage[$scope.currentStage]) {
                    var _item = $scope.getLayerById(proAttrActive.stage[$scope.currentStage]),
                        url = '//dev.cmsmart.net:3001/online-design/wp-content/uploads/2018/04/belt-2-324x324.jpg',
                        element = _item.getElement();
                    element.setAttribute("src", url);
                    _item.set({
                        dirty: true,
                        width: _item.width,
                        height: _item.height,
                        scaleX: _item.scaleX,
                        scaleY: _item.scaleY
                    });
                    _item.setCoords();
                    $scope.deactiveAllLayer();
                    $scope.renderStage();
                }else {
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
                    proAttrActive.stage[$scope.currentStage] = obj.get('itemId');
                }
                $scope.renderStage();
            });
        };
        $scope.getLayerById = function(itemId){
            var _canvas = $scope.stages[$scope.currentStage].canvas;
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

        $scope.onObjectAdded = function (id, options) {
            var _stage = $scope.stages[$scope.currentStage],
                _canvas = _stage['canvas'],
                item = options.target,
                d = new Date(),
                itemId = d.getTime() + Math.floor(Math.random() * 1000);

            item.set({"itemId" : itemId});
            item.setCoords();
            _canvas.viewportCenterObject(item);

            var top = item.get('top'), left = item.get('left');
            item.set({top: top - 50});

            item.animate('top', top, {
                duration: 400,
                onChange: function(){
                    $scope.renderStage();
                },
                onComplete: function(){
                    _canvas.setActiveObject(item);
                    $scope.renderStage();
                },
                easing: FabricWindow.util.ease['easeInQuad']
            });
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
            _canvas.on('object:added', function (options) {
                $scope.onObjectAdded(id, options);
            });
        });
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
        // if (!$itemA.prev().length) $nav.filter('.nbdpb-owl-prev').addClass('nbdpb-disabled');
        // if (!$itemA.next().length) $nav.filter('.nbdpb-owl-next').addClass('nbdpb-disabled');

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
            $outerCarousel = $(this).closest('.nbdpb-carousel-outer'),
            $nav = $outerCarousel.find('.js-nav-item');
        var cWith = 0, total = $items.length, dots = '<div class="nbdpb-owl-dots"></div>';

        var $dots = $(dots);
        // init with carousel
        $outerCarousel.append($dots);
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
        $nav.filter('.nbdpb-owl-prev').on('click', function () {
            var $itemA = $items.filter('.nbdpb-active');
            $itemA.removeClass('nbdpb-active');
            if ($itemA.index() == 0) {
                $items.last().addClass('nbdpb-active');
            }else {
                $itemA.prev().addClass('nbdpb-active');
            }
            seflC.itemActive($sefl);
        });
        $nav.filter('.nbdpb-owl-next').on('click', function () {
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
    $('#start-design').on('click', function () {
        $('body').addClass('nbdpb-no-overflow');
        $('.nbdpb-popup.popup-design').nbShowPopup().addClass('nbdpb-no-overflow');
        $('.nbdpb-carousel').nbdpbCarousel();

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
            //Default is 75px, set to 0 for demo so any distance triggers swipe
            threshold: 0
        });
    }
});
