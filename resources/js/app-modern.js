window.angular = require('angular');
window.angularSpectrumColorpicker = require('angular-spectrum-colorpicker');
window.$ = window.jQuery = require('jquery');
window._ = require('lodash');
window.imagesLoaded = require('imagesloaded');
window.spectrumColorpicker = require('spectrum-colorpicker');
require('fabric');
window.masonry = require('masonry-layout');
window.qrcode = require('qrcode');
window.webcam = require('webcamjs');
window.perfectScrollbar = require('perfect-scrollbar');
window.tooltipster = require('tooltipster');

$('body').perfectScrollbar();
debugger;
$(document).ready(function () {
});

/* nbdesignerjs
 * @author  netbaseteam
 * @link https://cmsmart.net
 * @version 2.0.1
 * @created Jun 2016
 * @modified 23, May 2018
 * */
var appConfig = {
    localMode: false,
    debugMode: true,
    isModern: true,
    ready: false,
    domainChanged: false,
    init: function(){
        this.mediaUrl = this.localMode ? 'http://localhost/nbmedia/v1' : 'https://studio.cmsmart.net/v1';
    }
};
function arrayMin(arr) {
    return arr.reduce(function (p, v) {
        p = parseInt(p);
        v = parseInt(v);
        return (p < v ? p : v);
    });
};
var nbdApp = angular.module('nbd-app', ["angularSpectrumColorpicker"]);
nbdApp.constant("_", window._);
nbdApp.config(function( $controllerProvider, $compileProvider, $filterProvider ){
    nbdApp.controller = function( name, constructor ) {
        $controllerProvider.register( name, constructor );
        return( this );
    };
    nbdApp.directive = function( name, factory ) {
        $compileProvider.directive( name, factory );
        return( this );
    };   
    nbdApp.filter = function( name, filter ) {
        $filterProvider.register( name, filter );
        return( this );
    };
});
nbdApp.controller('designCtrl', ['$scope', 'FabricWindow', '$window', 'NBDDataFactory', 'filterFontFilter', 'filterArtFilter', '$timeout', '$http', '$document', '$interval',
    function($scope, FabricWindow, $window, NBDDataFactory, filterFontFilter, filterArtFilter, $timeout, $http, $document, $interval){
    $scope.stages = [];
    $scope.defaultStageStates = {
        isActiveLayer: false,
        isLayer: false,
        isGroup: false,
        isNativeGroup: false,
        isText: false,
        isImage: false,
        isPath: false,
        isShape: false,
        isEditing: false,
        isRedoable: false,
        isUndoable: false,         
        elementUpload: false,         
        oos: false,         
        ilr: false,         
        boundingObject: {},
        coordinates: {},
        rotate: {},
        uploadZone: {},
        opacity: 100,
        snaplines: {},
        itemId: null,
        tempParameters: null,
        usedFonts: [],
        type: null,
        text: {
            fontFamily: {
                alias: NBDESIGNCONFIG.default_font.alias,
                r: NBDESIGNCONFIG.default_font.file.r,
                b: NBDESIGNCONFIG.default_font.file.b,
                i: NBDESIGNCONFIG.default_font.file.i,
                bi: NBDESIGNCONFIG.default_font.file.bi
            },
            fontSize: 14,
            fontFamily: NBDESIGNCONFIG.default_font.alias,
            textAlign: 'left',
            fontWeight: false,
            textDecoration: false,
            fontStyle: '',
            spacing: 0,
            lineHeight: 1.16,
            is_uppercase: false,
            fill: '#06d79c'
        }, 
        svg: {groupPath: {}, currentPath: null},
        image: {},
        scaleRange: [],
        currentScaleIndex: 0,
        fitScaleIndex: 0,
        fillScaleIndex: 0
    };
    $scope.defaultConfig = {
	name: 'Typography',
	width: 200,
	height: 200,
	cheight: 200,
	cwidth: 200,
        left: 0,
        top: 0,
	bleed_lr: 0,
	bleed_tb: 0,
	margin_lr: 0,
	margin_tb: 0,
	bgType: 'tran',
	bgColor: '#ffffff',
	bgImage: 0,
	showBleed: 0,
	showOverlay: 0,
	showSafeZone: 0        
    };
    $scope.initSettings = function(){
        $('body').perfectScrollbar();
        debugger;
        $scope.debugMode = appConfig.debugMode;
        angular.copy(NBDESIGNCONFIG, $scope.settings);       
        angular.extend($scope.settings, {
            showRuler: false,
            showGrid: NBDESIGNCONFIG.nbdesigner_show_grid == 'yes' ? true : false,
            bleedLine: NBDESIGNCONFIG.nbdesigner_show_bleed == 'yes' ? true : false,
            snapMode: {status: false, type: 'layer'},
            showWarning: {
                oos: NBDESIGNCONFIG.nbdesigner_show_warning_oos == 'yes' ? true : false,
                ilr: NBDESIGNCONFIG.nbdesigner_show_warning_ilr == 'yes' ? true : false
            }
        });
        $scope.rateConvertCm2Px96dpi = 37.795275591;
        $scope.currentStage = 0;
        $scope.showTextColorPicker = false;
        $scope.showBgColorPicker = false;
        $scope.__colorPalette = __colorPalette;
        $scope.currentColor = NBDESIGNCONFIG.nbdesigner_default_color;
        $scope.listAddedColor = [];
        $scope.tempStageDesign = null;
        $scope.listFontSizeInPt = ['6','8','10','12','14','16','18','21','24','28','32','36','42','48','56','64','72','80','88','96','104','120','144'];
        $scope.forceMinSize = true;
        if( angular.isDefined(NBDESIGNCONFIG.product_data.option.listFontSizeInPt) ){
            if( NBDESIGNCONFIG.product_data.option.listFontSizeInPt != '' ){
                NBDESIGNCONFIG.product_data.option.listFontSizeInPt = NBDESIGNCONFIG.product_data.option.listFontSizeInPt.replace(/ /g, '');
                $scope.listFontSizeInPt = NBDESIGNCONFIG.product_data.option.listFontSizeInPt.split(',');
            }
        };
        if( angular.isDefined(NBDESIGNCONFIG.product_data.config ) && angular.isDefined(NBDESIGNCONFIG.product_data.config.dpi) ){
            $scope.settings.product_data.option.dpi = NBDESIGNCONFIG.product_data.config.dpi;
        }
        $scope.changePrintingOptions( true );
        $scope.processProductSettings();
        $scope.resource = {
            defaultPalette: [
                ['#ff5c5c', '#ffbd4a', '#fff952', '#99e265', '#35b729', '#44d9e6', '#2eb2ff', '#5271ff', '#b760e6', '#ff63b1'],
                ['#000000', '#666666', '#a8a8a8', '#d9d9d9', '#ffffff']
            ],
            social: {link: ''},
            config: {},
            jsonDesign: {},
            usedFonts: [],
            imageFromUrl: '',
            svgCode: '',
            qrText: '',
            gapi: {},
            tempData: {template: []},
            templates: [],
            myTemplates: [],
            cartTemplates: [],
            templateCats: [],
            drawMode: {status: false, brushWidth: 1, brushType: 'Pencil', brushColor: NBDESIGNCONFIG.nbdesigner_default_color},
            personal: {status: false, type: ''},
            webcam: {status: false},
            typography: {filter: {perPage: 20, currentPage: 1, total: 0}, data: [], init: true, onload: false},
            clipart: {filter: {perPage: 20, currentPage: 1, total: 0, currentCat: {}}, data: [], onload: false, init: true, filteredArts : []},
            font: {filter: {perPage: 10, currentPage: 1, total: 0}, data: [], filteredFonts : []},
            photo: {filter: {perPage: 20, currentPage: 1, total: 0, totalPage: 1}, data: [], init: true, onload: false, type: '', photoSearch: '', onclick: false},
            dropbox: {filter: {perPage: 10, currentPage: 1, total: 0}, data: [], onload: false, init: true, filteredPhoto : []},
            facebook: {filter: {perPage: 15, currentPage: 1, total: 0}, data: [], onload: false, init: true, nextUrl: '', uid: '', accessToken: ''},
            instagram: {filter: {perPage: 10, currentPage: 1, total: 0}, data: [], onload: false, init: true, token : ''},
            upload: {filter: {perPage: 10, currentPage: 1, total: 0}, data: [], onload: false, init: true, ilr: false},
            element: {onclick: false, onload: false, contentSearch: ''},
            shape: {filter: {perPage: 20, currentPage: 1, totalPage: 0}, data: [], init: true, onload: false},
            icon: {filter: {perPage: 20, currentPage: 1, totalPage: 0}, data: [], init: true, onload: false},         
            line: {filter: {perPage: 20, currentPage: 1, totalPage: 0}, data: [], init: true, onload: false},     
            globalTemplate: {filter: {perPage: 20, currentPage: 1, totalPage: 0}, data: [], init: true, onload: false}     
        };
        $scope.includeExport = ['objectCaching', 'itemId', 'selectable', 'lockMovementX', 'lockMovementY','lockScalingX', 'lockScalingY', 'lockRotation', 'rtl', 'elementUpload', 'forceLock', 'isBg','is_uppercase','available_color','available_color_list','color_link_group','isOverlay', 'isAlwaysOnTop', 'ilr', 'oos', 'evented', 'ptFontSize', 'first_name', 'last_name', 'full_name', 'company', 'address', 'postcode', 'city', 'phone', 'email', 'mobile', 'website', 'vcard', 'title'];
        if( angular.isDefined(NBDESIGNCONFIG.product_data.option.font_cats) ){
            $scope.settings.fonts = $scope.settings.fonts.filter(function(font){
                if (font.cat.length == 0) font.cat = ["0"];
                return !font.cat.some(function(val) { return NBDESIGNCONFIG.product_data.option.font_cats.indexOf(val) === -1 });
            });
        };
        $scope.resource.font.data = $scope.settings.fonts;
        if(!_.filter($scope.resource.font.data, ['alias', $scope.settings.default_font.alias]).length){
            $scope.resource.font.data.push($scope.settings.default_font);
        };
        $scope.resource.templates = $scope.settings.templates;
        if( $scope.resource.templates.length == 0 || NBDESIGNCONFIG.product_data.option.admindesign != "1" ){
            $scope.getResource('typography', '#tab-typography');
        }
        if(NBDESIGNCONFIG.show_nbo_option){
            $timeout(function(){
                $scope.getPrintingOptions();
            }, 100);
        }
        if( $scope.settings.task != 'create_template' && NBDESIGNCONFIG.product_data.option.admindesign == "1" 
                && NBDESIGNCONFIG.product_data.option.global_template == "1"
                    && NBDESIGNCONFIG.product_data.option.global_template_cat != "" ){
            var cid = parseInt( NBDESIGNCONFIG.product_data.option.global_template_cat );  
            $scope.templateCat = cid;
            $scope.loadGlobalTemplate(cid, true);
        }
        $scope.resource.font.filter.total = $scope.resource.font.data.length;
        $scope.$watchCollection('resource.font.filter', function(newVal, oldVal){
            if(newVal.search != oldVal.search){
                $timeout(function() {
                    jQuery("#toolbar-font-familly-dropdown").stop().animate({
                        scrollTop: 0
                    }, 100);                    
                });
            }
            $scope.resource.font.filteredFonts = filterFontFilter($scope.resource.font.data, $scope.resource.font.filter);
        }, true);        
        $scope.$watchCollection('resource.clipart.filter', function(newVal, oldVal){
            $scope.resource.clipart.filteredArts = filterArtFilter($scope.resource.clipart.data.arts, $scope.resource.clipart.filter);
            if(newVal.search != oldVal.search){
                $timeout(function() {
                    jQuery("#tab-svg .tab-scroll").stop().animate({
                        scrollTop: 0
                    }, 100);                    
                });
            }
            $scope.onEndRepeat('clipart');
        }, true);
    };
    $scope.addColor = function(color){
        var _color = angular.isDefined(color) ? color : $scope.currentColor;
        $scope.listAddedColor.push(_color);
        $scope.listAddedColor = _.uniq($scope.listAddedColor);
        jQuery('.nbd-perfect-scroll').perfectScrollbar('update');
    };
    $scope.showTextColorPalette = function(){
        $scope.showTextColorPicker = !$scope.showTextColorPicker;
    };    
    $scope.showBgColorPalette = function(){
        $scope.showBgColorPicker = !$scope.showBgColorPicker;
    };       
    $scope.hasGetUserMedia = function(){
        return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia || navigator.msGetUserMedia);        
    };    
    $scope.settings = {};
    $scope.init = function() {
        appConfig.init();
        $scope.localStore.init();
        if(typeof nbd_window.NBDESIGNERPRODUCT != 'undefined'){
            nbd_window.NBDESIGNERPRODUCT.hide_loading_iframe();
        };
        $scope.isTemplateMode = NBDESIGNCONFIG.task === 'create' || (NBDESIGNCONFIG.task == 'edit' && NBDESIGNCONFIG.design_type == 'template' );
        $scope.initSettings();
        $scope.contextAddLayers = 'normal';
        $scope.workBenchHeight = $window.innerHeight;           
        $scope.workBenchWidth = $window.innerWidth;    
        $timeout(function(){
            jQuery('.nbd-load-page').hide();
        });
        var _window = angular.element($window);
        _window.bind('resize', function(){
            /* to do: resize design */
            $scope.reCalcViewPort();
        });
        $scope.fullScreenMode = false;
        var _document = angular.element($document);
        _document.bind('webkitfullscreenchange mozfullscreenchange fullscreenchange MSFullscreenChange', function(){
            $scope.fullScreenMode = !$scope.fullScreenMode;
            jQuery("body").toggleClass("fullScreenMode");
            $timeout(function(){
                $scope.toggleStageFullScreenMode();
            });
        }); 
        /* real time update printing option */
        var _intervalOptions = $interval(function() {
            if($scope.awaitLoadPrintingOptions){
                $scope.changePrintingOptions();
            }
        }, 100);
        var log = "c"+"o"+"n"+"s"+"o"+"l"+"e.i"+"n"+"f"+"o('%cP"+"o"+"we"+"r"+"e"+"d b"+"y %cN"+"E"+"T%cB"+"A"+"S"+"E%cT"+"E"+"A"+"M', 'color: orange; font-size: 20px;', 'color: red; font-size: 40px;', 'color: green; font-size: 40px;', 'color: #F48024; font-size: 40px;')";
        eval(log);        
    };
    /* Util */
    $scope.localStore = {
        db: null,
        ready: false,
        init: function(){
            var self = this;
            var indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB || window.shimIndexedDB;
            if(indexedDB){
                var open = indexedDB.open("NBDesigner", 1);
                if( open == null ) return;
                open.onsuccess = function (e) {
                    self.db = e.target.result;
                    self.ready = true;
                };
                open.onupgradeneeded = function(event){
                    var db =  event.target.result;
                    var objectStore = db.createObjectStore("designs", { keyPath: "id" });
                };
                open.onerror  = function(event){
                    alert(event);
                };                
            }
        },
        add: function( pid, data, callback ){
            if( this.ready ){
                var request = this.db.transaction(["designs"], "readwrite").objectStore("designs").add({ id: pid, data: data });
                request.onsuccess = function(event) {
                    if(typeof callback == 'function') callback();
                };
            }
        },
        update: function( pid, data, callback ){
            if( this.ready ){
                var objectStore = this.db.transaction(["designs"], "readwrite").objectStore("designs");
                var request = objectStore.get(pid);
                request.onsuccess = function(event) {
                    var _data = event.target.result;
                    if( _data ){
                        _data.data = data;  
                    }else{
                        _data = { id: pid, data: data };
                    }
                    var requestUpdate = objectStore.put(_data);
                    requestUpdate.onsuccess = function(event) {
                        if(typeof callback == 'function') callback();
                    };                      
                };
                request.onerror = function(event) {
                    console.log(event);
                };               
            }
        },
        get: function( pid, callback ){
            if( this.ready ){
                var transaction = this.db.transaction(["designs"]);
                var objectStore = transaction.objectStore("designs");
                var request = objectStore.get(pid);
                request.onsuccess = function(event) {
                    if(typeof callback == 'function'){
                        callback(event.target.result);
                    }
                };
                request.onerror = function(event) {
                    console.log(event);
                };                
            }
        },
        delete: function( pid, callback ){
            if( this.ready ){
                var request = this.db.transaction(["designs"], "readwrite").objectStore("designs").delete(pid);
                request.onsuccess = function(event) {
                   callback();
                };      
            }
        }
    };
    $scope._localStorage = {
        save: function(type, value){
            if( type == 'nbduploaded') {
                if( $scope.resource.upload.data.length > 20 ) $scope.resource.upload.data.shift();
                value = JSON.stringify($scope.resource.upload.data);
            }
            localStorage.setItem(type, value);
        },
        get: function(type){
            var data = localStorage.getItem(type);
            if( data ){
                return JSON.parse(data);
            }else{
                return [];
            }      
        },
        delete: function(type){
            if( type == 'nbduploaded') {
                $scope.resource.upload.data = [];
                $scope.updateApp();
            }
            localStorage.setItem(type, JSON.stringify([]));
        }
    };
    $scope.generateUniqueId = function(){
        return '_' + Math.random().toString(36).substr(2, 9);
    };
    /* Get Data */
    $scope.getResource = function(type, container, callback){
        if( $scope.resource[type].data.length || angular.isUndefined($scope.resource[type].data.length) ) return;
        jQuery(container+' .loading-photo').show();
        NBDDataFactory.get('nbd_get_resource', {type: type, task: $scope.settings.task}, function(data){
            jQuery(container+' .loading-photo').hide();
            var _data = JSON.parse(data);
            $scope.resource[type].data = _data.data; 
            $scope.resource[type].filter.total = $scope.resource[type].data.length;
            if( callback ) $scope.afterGetResource(type);
        });
    };
    $scope.onClickTab = function(type, tab){
        $scope.resource[tab].onclick = !$scope.resource[tab].onclick;
        if(!$scope.resource.photo.onclick) jQuery('#tab-'+tab+' .loading-photo').hide();
        $scope.disableDrawMode();
        switch(type){
            case 'dropbox':
            case 'facebook':
            case 'instagram':
            case 'upload':
            case 'url':
                if( type == 'upload' ){
                    if( $scope.settings.nbdesigner_cache_uploaded_image == 'yes' && $scope.resource.upload.data.length == 0){
                        $scope.resource.upload.data = $scope._localStorage.get('nbduploaded');
                    };            
                };
                $timeout(function(){
                    if(type != 'url' && $scope.resource[tab].onclick){
                        $scope.renderMasonryList(type, '#nbd-'+type+'-wrap .mansory-wrap', '.mansory-item', '#nbd-'+type+'-wrap', $scope.resource[type].init);
                    }
                });
                $scope.resource.personal = {status: true, type: type};
                break; 
            case 'Pixabay':    
            case 'Unsplash':
                $scope.resource.personal.status = false;
                if($scope.resource[tab].onclick && $scope.resource[tab].type != type){
                    $scope.getPhoto(type);
                }
                break;
            case 'shape':
            case 'icon':
            case 'line':
                if($scope.resource[tab].onclick){
                    $scope.renderMasonryList(type, '#nbd-'+type+'-wrap .mansory-wrap', '.mansory-item', '#nbd-'+type+'-wrap', $scope.resource[type].init);
                }
                if( $scope.resource[tab].onclick && $scope.resource[tab].type != type ) $scope.getMedia(type);
                break;
            case 'draw':
                if($scope.resource[tab].onclick){
                    $scope.enableDrawMode();
                }
                $scope.resource.element.type = type;
                break;
            case 'qrcode':    
                $scope.resource.element.type = type;
                break;
            default:
                //todo
                break;
        };        
    };
    $scope.uploadSvgFile = function(){
        var input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/svg+xml|application/svg+xml';
        input.style.display = 'none';
        input.addEventListener('change', onChange.bind(input), false);
        document.body.appendChild(input);
        input.click();
        function onChange(){
            if (this.files.length > 0) {
                var file = this.files[0],
                reader = new FileReader();
                reader.onload = function(event){
                    if (event.target.readyState === 2) {
                        var result = reader.result;
                        $scope.addSvgFromString(result);
                        destroy();
                    }
                };
                reader.readAsText(file);                
            }
        }
        function destroy() {
            input.removeEventListener('change', onChange.bind(input), false);
            document.body.removeChild(input);
        }        
    };
    $scope.templateName = '';
    $scope.loadTemplateCat = function( callback ){
        var dataObj = {
            source: 'media',
            type: 'get_template_cat'
        };
        NBDDataFactory.get('nbd_get_resource', dataObj, function(data){
            data = JSON.parse(data);
            if(data.flag == 1){
                $scope.templateCats = data.data;
                $scope.templateCat = parseInt($scope.templateCats[0].id); 
            };
            jQuery('.nbd-popup.popup-template').find('.overlay-main').removeClass('active');     
            if( typeof callback == 'function' ) callback();
        });        
    };    
    $scope._loadTemplateCat = function(){
        $scope.toggleStageLoading();
        $scope.resource.globalTemplate = {filter: {perPage: 20, currentPage: 1, totalPage: 0}, data: [], init: false, onload: false};
        $scope.loadTemplateCat(function(){
            $scope.loadGlobalTemplate($scope.templateCat);
        });
    };    
    $scope.changeGlobalTemplate = function(){
        $scope.toggleStageLoading();
        $scope.resource.globalTemplate = {filter: {perPage: 20, currentPage: 1, totalPage: 0}, data: [], init: false, onload: false} 
        $scope.loadGlobalTemplate($scope.templateCat);
    };
    $scope.templateSize = {
        width: 200,
        height: 200
    };
    $scope.changeTemplateDimension = function(){
        var width = 200, height = 200;
        $scope.templateSize.width = $scope.templateSize.width != '' ? $scope.templateSize.width : 200;
        $scope.templateSize.height = $scope.templateSize.height != '' ? $scope.templateSize.height : 200;
        if( $scope.templateSize.width > $scope.templateSize.height ){
            height = Math.round( $scope.templateSize.height / $scope.templateSize.width * 200 );
        }else{
            width = Math.round( $scope.templateSize.width / $scope.templateSize.height * 200 );
        }
        $scope.templateSize.width = width;
        $scope.templateSize.height = height;
        _.each($scope.stages, function(stage, index){
            stage.config.width = width;
            stage.config.cwidth = width;
            stage.config.height = height;
            stage.config.cheight = height;
            $scope.setStageDimension(index);
        });
    };
    $scope.globalTemplateLoaded = false;
    $scope.loadGlobalTemplate = function(cid, withoutLoading){
        var search = '';
        $http({
            method: 'GET',
            url: appConfig.mediaUrl + '/template?limit='+ $scope.resource.globalTemplate.filter.perPage +'&category=' + cid + '&search=' + search + '&start=' + ($scope.resource.globalTemplate.filter.currentPage-1) * $scope.resource.globalTemplate.filter.perPage
        }).then(function successCallback(response){
            var data = response.data.templates;
            $scope.globalTemplateLoaded = true;
            _.each(data.items, function(item, key) {
                $scope.resource.globalTemplate.data.push({
                    thumbnail: item.thumbnail,
                    name: item.name,
                    id: item.id
                });
            });
            if( angular.isUndefined(withoutLoading) ) $scope.toggleStageLoading();
            $scope.resource.globalTemplate.filter.totalPage = data.pagesTotal > 10 ? 10 : data.pagesTotal;
            $scope.resource.globalTemplate.onload = false;
        }, function errorCallback(response) {
            console.log('Fail to load: globalTemplate');
        });        
    };
    $scope.getGlobalTemplate = function(id, callback){
        var dataObj = {
            source: 'media',
            type: 'get_template',
            id: id
        };
        NBDDataFactory.get('nbd_get_resource', dataObj, function(data){
            data = JSON.parse(data);
            if(data.flag == 1 && data.data.design){
                if( typeof callback == 'function' ) callback(data.data);
            }else{
                $scope.toggleStageLoading();
                console.log('Error load global template!');
            };
        });
    };
    $scope.insertGlobalTemplate = function(id){
        $scope.showDesignTab();
        $scope.clearHistory();
        $scope.toggleStageLoading();
        $scope.getGlobalTemplate(id, function(data){
            var fonts = JSON.parse(data.used_font);
            var design = JSON.parse(data.design);
            if( angular.isUndefined(design.canvas) ) design.canvas = {width: 200, height: 200};
            if(fonts.length){
                _.each(fonts, function(font, index){
                    if(!_.filter($scope.resource.font.data, ['alias', font.alias]).length){
                        $scope.resource.font.data.push(font);
                    };   
                    var font_id = font.name.replace(/\s/gi, '').toLowerCase();
                    if( !jQuery('#' + font_id).length ){
                        jQuery('head').append('<link id="' + font_id + '" href="https://fonts.googleapis.com/css?family='+ font.name.replace(/\s/gi, '+') +':400,400i,700,700i" rel="stylesheet" type="text/css">');
                    }                     
                });
            }
            $scope.onloadTemplate = true;
            $scope.contextAddLayers = 'template';
            var stageIndex = 0;
            function afterLoadStage(){
                $scope.onloadTemplate = false;
                $scope.contextAddLayers = 'normal';
                $scope.toggleStageLoading();                  
            }
            function loadStage(stageIndex){
                if( angular.isUndefined($scope.stages[stageIndex]) || stageIndex >= $scope.stages.length ){
                    if( stageIndex >= $scope.stages.length ) afterLoadStage();
                    return;
                }
                var _index = 'frame_' + stageIndex,
                stage = $scope.stages[stageIndex],
                _canvas = stage['canvas'],
                layerIndex = 0;
                if( angular.isUndefined(design[_index]) ){
                    stageIndex++;
                    loadStage(stageIndex);
                    return;
                }
                stage.states.usedFonts = [];
                _canvas.clear();
                var objects = design[_index].objects;
                if( objects.length == 0 ) {
                    stageIndex++;
                    loadStage(stageIndex);  
                    return;
                }
                var stageLayers = [];
                function loadLayer(layerIndex){
                    function continueLoadLayer(){
                        layerIndex++;
                        if( layerIndex < objects.length ){
                            loadLayer(layerIndex);
                        }else{
                            fitTemplateWithStage();
                            stageIndex++;
                            if( stageIndex < $scope.stages.length ){
                                loadStage(stageIndex);
                            }else{
                                afterLoadStage();
                            }
                        }
                    }
                    function fitTemplateWithStage(){
                        var rec = $scope.fitRectangle(stage.config.width, stage.config.height, design.canvas.width, design.canvas.height, true),
                        factor = rec.width / design.canvas.width;
                        _.each(stageLayers, function(obj){
                            var scaleX = obj.get('scaleX'),
                            scaleY = obj.get('scaleY'),
                            top = obj.get('top'),
                            left = obj.get('left');
                            obj.set({
                                scaleX: scaleX * factor,
                                scaleY: scaleY * factor,
                                left: left * factor + rec.left,
                                top: top * factor + rec.top                         
                            });
                            obj.setCoords();
                        });
                        $scope.deactiveAllLayer(stageIndex);
                        $scope.renderStage(stageIndex);
                    }
                    function addLayer(_item, callback){
                        _canvas.add(_item);
                        var __item = _canvas.item(_canvas.getObjects().length - 1);
                        if(typeof callback === 'function') callback(__item);
                        stageLayers.push(__item);
                        continueLoadLayer();
                    }
                    var item = objects[layerIndex],
                    type = item.type;
                    if( type === 'image' || type === 'custom-image' ){
                        fabric.Image.fromObject(item, function(_image){
                            addLayer(_image);
                        });
                    }else{
                        var klass = fabric.util.getKlass(type);
                        var is_text = false;
                        if( ['i-text', 'text', 'textbox', 'curvedText'].indexOf( type ) > -1  ){
                            if(!_.filter(stage.states.usedFonts, ['alias', item.fontFamily]).length){
                                var layerFont = $scope.getFontInfo(item.fontFamily);
                                stage.states.usedFonts.push(layerFont);
                            };
                            is_text = true;
                        };
                        klass.fromObject(item, function(item){
                            if(is_text){
                                var fontFamily = item.fontFamily,
                                fontWeight = angular.isDefined(item.fontWeight) ? item.fontWeight : '',
                                fontStyle = angular.isDefined(item.fontStyle) ? item.fontStyle : '',
                                _font = $scope.getFontInfo(fontFamily); 
                                item.set({objectCaching: false});
                                var font = new FontFaceObserver(fontFamily, {weight: fontWeight, style: fontStyle});
                                font.load($scope.settings.subsets[_font.subset]['preview_text']).then(function () {
                                    fabric.util.clearFabricFontCache();
                                    addLayer(item, function(__item){
                                        __item.initDimensions();
                                        __item.setCoords();                                            
                                    });
                                }, function () {
                                    console.log('Error load font: '+fontFamily);
                                    addLayer(item);
                                });                                    
                            }else{
                                addLayer(item);
                            }
                        });
                    }              
                }
                loadLayer(layerIndex);
            }
            loadStage(stageIndex);
        });
    };
    $scope.getMedia = function(type, context){
        jQuery('#tab-element .loading-photo').show();
        $scope.resource.element.type = type;
        if( $scope.resource.element.type != type || context == 'search' ){
            $scope.resource[type].data = [];
            $scope.resource[type].filter.total = 0;
            $scope.resource[type].filter.currentPage = 1;
            //jQuery('#tab-element .content-items').css('height', 0);
//            jQuery("#tab-element .tab-scroll").stop().animate({
//                scrollTop: jQuery('.main-items').height()
//            }, 100);
        };
        $scope.resource.element.type = type;
        var category = type == 'shape' ? 66 : (type == 'line' ? 78 : 73);
        var search = type == 'icon' ? $scope.resource.element.contentSearch : '';
        $http({
            method: 'GET',
            url: appConfig.mediaUrl + '/clipart?limit=20&category=' + category + '&search=' + search + '&start=' + ($scope.resource[type].filter.currentPage-1) * 20
        }).then(function successCallback(response){
            var data = response.data.cliparts;
            _.each(data.items, function(item, key) {
                $scope.resource[type].data.push({
                    url: item.file,
                    name: item.name
                });
            });            
            $scope.resource[type].filter.totalPage = data.pagesTotal > 10 ? 10 : data.pagesTotal;
        }, function errorCallback(response) {
            console.log('Fail to load: ' + type);
        });         
    };
    $scope.getPhoto = function(type, context){ 
        if( $scope.resource.photo.type != type || context == 'search' ){
            $scope.resource.photo.data = [];
            $scope.resource.photo.filter.total = 0;
            $scope.resource.photo.filter.currentPage = 1;
            jQuery("#tab-photo .tab-scroll").stop().animate({
                scrollTop: jQuery('#tab-photo .main-items').height()
            }, 100);
            jQuery('#nbdesigner-gallery').css('height', 0);
        };
        $scope.resource.photo.type = type;
        if( $scope.resource.photo.type == '' ) return;
        jQuery('#tab-photo .loading-photo').show();
        if( $scope.resource.photo.filter.totalPage == 0 || $scope.resource.photo.filter.currentPage <= $scope.resource.photo.filter.totalPage ){       
            switch(type){
                case 'Pixabay':        
                    $http({
                        method: 'GET',
                        url: 'https://pixabay.com/api/?safesearch=true&key='+ NBDESIGNCONFIG['nbdesigner_pixabay_api_key'] +'&response_group=high_resolution&image_type=photo&per_page='+$scope.resource.photo.filter.perPage+'&page='+$scope.resource.photo.filter.currentPage+'&q='+encodeURIComponent($scope.resource.photo.photoSearch)
                    }).then(function successCallback(response) {
                        var data = response.data,
                        totalPage = Math.ceil(data.totalHits/$scope.resource.photo.filter.perPage);
                        $scope.resource.photo.filter.totalPage = totalPage > 10 ? 10 : totalPage;
                        _.each(data.hits, function(val, key) {
                            $scope.resource.photo.data.push({
                                extenal: 1,
                                url: angular.isDefined(val.fullHDURL) ? val.fullHDURL : ( angular.isDefined(val.largeImageURL) ? val.largeImageURL : val.imageURL ),
                                preview: val.previewURL,
                                des: '@ ' +val.user
                            });
                        });
                        $scope.afterGetResource('photo');
                    }, function errorCallback(response) {
                        console.log('Pixabay');
                        jQuery('#tab-photo .loading-photo').hide();
                    });            
                    break;
                case 'Unsplash':
                    var url = $scope.resource.photo.photoSearch != '' ? 'https://api.unsplash.com/search/photos/?client_id='+ NBDESIGNCONFIG['nbdesigner_unsplash_api_key'] +'&per_page='+$scope.resource.photo.filter.perPage+'&page='+$scope.resource.photo.filter.currentPage+'&query='+encodeURIComponent($scope.resource.photo.photoSearch) : 'https://api.unsplash.com/photos/?client_id='+ NBDESIGNCONFIG['nbdesigner_unsplash_api_key'] +'&per_page=20&page='+$scope.resource.photo.filter.currentPage+'&order_by=latest';
                    $http({
                        method: 'GET',
                        url: url
                    }).then(function successCallback(response) {
                        var data = response.data;
                        if( $scope.resource.photo.photoSearch != '' ){
                            $scope.resource.photo.filter.totalPage = data.total_pages > 10 ? 10 : data.total_pages;
                            var results = data.results;
                        }else{
                            $scope.resource.photo.filter.totalPage = 10;
                            var results = data;
                        }
                        _.each(results, function(val, key) {
                            $scope.resource.photo.data.push({
                                extenal: 1,
                                //url: val.urls.raw,
                                url: val.urls.regular,
                                preview: val.urls.thumb,
                                des: '@ '+val.user.name
                            });
                        });
                        $scope.afterGetResource('photo');
                    }, function errorCallback(response) {
                        console.log('Unsplash');
                        jQuery('#tab-photo .loading-photo').hide();
                    }); 
                    break;
            }  
        };    
        $scope.updateApp();
    };
    $scope.getPersonalPhoto = function(type, dataObj){
        jQuery('#tab-photo .loading-photo').show();
        switch(type){
            case 'dropbox':
                _.each(dataObj, function(file, index){
                    $scope.resource.dropbox.data.push({
                        extenal: 1,
                        id :  file.id,
                        preview :  file.link,
                        url :  file.link,
                        des: file.name
                    });
                });    
                $scope.resource.dropbox.data = _.uniqBy($scope.resource.dropbox.data, 'id');
                $scope.resource.dropbox.filter.total = $scope.resource.dropbox.data.length;
                break;
            case 'instagram':
                var endpointUrl = 'https://api.instagram.com/v1/users/self/media/recent?access_token='+$scope.resource.instagram.token;
                $http({method: 'GET', url: endpointUrl}).then(function successCallback(response) {
                    _.each(response.data.data, function(file, index){
                        $scope.resource.instagram.data.push({
                            extenal: 1,
                            id :  file.id,
                            preview :  file.images.thumbnail.url,
                            url :  file.images.standard_resolution.url,
                            des: file.user.full_name
                        });
                    }); 
                    $scope.resource.instagram.data = _.uniqBy($scope.resource.instagram.data, 'id');
                    $scope.resource.instagram.filter.total = $scope.resource.instagram.data.length;
                }, function errorCallback(response) {
                    console.log('loadInstagramPhotos');
                    jQuery('#tab-photo .loading-photo').hide();
                });                
                break;
            case 'facebook':
                $scope.resource.facebook.uid = angular.isDefined(dataObj) ? dataObj[0] : $scope.resource.facebook.uid;
                $scope.resource.facebook.accessToken = angular.isDefined(dataObj) ? dataObj[1] : $scope.resource.facebook.accessToken;
                $scope.resource.facebook.nextUrl = $scope.resource.facebook.nextUrl == '' ? "https://graph.facebook.com/" + $scope.resource.facebook.uid + "/photos/uploaded/?limit="+$scope.resource.facebook.filter.perPage+"&fields=source,images,link&access_token=" + $scope.resource.facebook.accessToken : $scope.resource.facebook.nextUrl;
                $http({method: 'GET', url: $scope.resource.facebook.nextUrl}).then(function successCallback(response) {
                    var data = response.data;
                    _.each(data.data, function(file, index){
                        $scope.resource.facebook.data.push({
                            extenal: 1,
                            id :  file.id,
                            preview :  file.images[file.images.length - 1].source,
                            url :  file.source,
                            des: '@ Facebook'
                        });                         
                    });
                    $scope.resource.facebook.data = _.uniqBy($scope.resource.facebook.data, 'id');
                    $scope.resource.facebook.filter.total = $scope.resource.facebook.data.length;  
                    if (data.paging.next) {
                        $scope.resource.facebook.nextUrl = data.paging.next;
                        $scope.resource.facebook.filter.total += 1;
                    };
                }, function errorCallback(response) {
                    console.log('loadFacebookPhotos');
                    jQuery('#tab-photo .loading-photo').hide();
                });
                break;
        }
    };
    $scope.authenticateInstagram = function(){
        $scope.resource.instagram.token = sessionStorage.getItem('nbd_instagram_token');
        if( $scope.resource.instagram.token  ){
            $scope.getPersonalPhoto('instagram');
        }else{
            var popupLeft = (window.screen.width - 700) / 2,
                    popupTop = (window.screen.height - 500) / 2;  
            var url = 'https://instagram.com/oauth/authorize/?client_id='+NBDESIGNCONFIG['nbdesigner_instagram_app_id']+'&redirect_uri='+NBDESIGNCONFIG['instagram_redirect_uri']+'&response_type=token';
            var popup = window.open(url, '_blank', 'width=700,height=500,left='+popupLeft+',top='+popupTop+'');
            popup.onload = new function() {
                if(window.location.hash.length == 0) {
                    popup.open(url, '_self');
                };
                var interval = setInterval(function () {
                    try {
                        if (popup.location.hash.length) {
                            clearInterval(interval);
                            $scope.resource.instagram.token = popup.location.hash.slice(14);
                            sessionStorage.setItem('nbd_instagram_token', $scope.resource.instagram.token);
                            popup.close();
                            $scope.getPersonalPhoto('instagram');
                        }
                    } catch (evt) {
                        console.log('Instagram');
                        //alert('Try again!');
                    }
                }, 100);            
            }            
        }
    };
    $scope.logoutInstagram = function(){
        sessionStorage.removeItem('nbd_instagram_token');
        $scope.resource.instagram.token = '';
        $scope.resource.instagram.data = [];
        $scope.resource.instagram.filter.currentPage = 1;
        $scope.resource.instagram.filter.total = 0;
        jQuery("#tab-photo .tab-scroll").stop().animate({
            scrollTop: jQuery('.main-items').height()
        }, 100);        
    };
    $scope.afterGetResource = function(type){
        switch(type){
            case 'clipart':
                if( $scope.resource.clipart.data.cat.length == 0 ) $scope.resource.clipart.data.cat = [{id: "0", name: NBDESIGNCONFIG.nbdlangs.cliparts}];
                if( angular.isDefined(NBDESIGNCONFIG.product_data.option.art_cats) ){
                    $scope.resource.clipart.data.cat = $scope.resource.clipart.data.cat.filter(function(cat){
                        var cid = cat.id;
                        return NBDESIGNCONFIG.product_data.option.art_cats.indexOf(cid) > -1;
                    });
                };
                _.each($scope.resource.clipart.data.cat, function(cat, key) {
                    cat.amount = 0;
                    _.each($scope.resource.clipart.data.arts, function(art, k) {
                        art.url = art.url.indexOf("http") > -1 ? art.url : NBDESIGNCONFIG['art_url'] + art.url;
                        if (art.cat.length == 0) art.cat = ["0"];
                        if ( _.includes(art.cat, cat.id) ) cat.amount++
                    });
                });
                $scope.resource.clipart.data.cat = _.sortBy($scope.resource.clipart.data.cat, 'name');
                $scope.resource.clipart.filter.currentCat = $scope.resource.clipart.data.cat[0];
                $scope.resource[type].filter.total = $scope.resource.clipart.filter.currentCat.amount;
                jQuery('#tab-svg').removeClass('nbd-onload');
                break;
            case 'photo':
                if( $scope.resource.photo.data.length == 0 ) jQuery('#tab-photo .loading-photo').hide();
                $scope.resource.photo.filter.total = $scope.resource.photo.filter.totalPage * $scope.resource.photo.filter.perPage;            
                break;
        }
    };
    $scope.changeCat = function(type, cat){
        $scope.resource[type].filter.search = '';
        $scope.resource[type].filter.currentPage = 1;
        $scope.resource[type].filter.currentCat = cat;
        $scope.resource[type].filter.total = cat.amount;
        $scope.updateApp();
        switch(type){
            case 'clipart':
                jQuery("#tab-svg .tab-scroll").stop().animate({
                    scrollTop: 0
                }, 100);
            break;
        };        
    };
    /* Change printing options */
    $scope.onLoadPrintingOptions = false;
    $scope.awaitLoadPrintingOptions = false;
    $scope.printingOptionsAvailable = false;
    $scope.applyOptions = function(){
        jQuery('.nbd-popup.popup-nbo-options .close-popup').triggerHandler('click');
        $scope.changePrintingOptions();
    };
    $scope.changePrintingOptions = function( first ){
        if( $scope.onloadVariation ) return;
        if( angular.isDefined( nbd_window.nbOption ) ){
            if( angular.isUndefined(first) ){
                if( $scope.onLoadPrintingOptions ){
                    $scope.awaitLoadPrintingOptions = true;
                    return;
                }else{
                    $scope.awaitLoadPrintingOptions = false;
                    $scope.onLoadPrintingOptions = true;
                } 
            }
            var data = nbd_window.nbOption.odOption;
            if( angular.isDefined( data.dpi ) ){
                $scope.settings.product_data.option.dpi = data.dpi;
            }
            if( angular.isDefined( data.page ) ){
                $scope.currentStage = 0;
                var number_side = $scope.settings.product_data.product.length;
                if( angular.isUndefined( $scope.stored_product ) ){
                    $scope.stored_product = [];
                    angular.copy($scope.settings.product_data.product, $scope.stored_product);
                }
                if( angular.isDefined( data.page.list_page ) ){
                    $scope.settings.product_data.product = [];
                    angular.forEach(data.page.list_page, function(side, key){
                        if( angular.isDefined( $scope.stored_product[side] ) ){
                            $scope.settings.product_data.product.push( $scope.stored_product[side] )
                        }else if( angular.isDefined( $scope.settings.product_data.product[number_side - 1] ) ){
                            var temp = angular.copy($scope.settings.product_data.product[number_side - 1], temp);
                            $scope.settings.product_data.product.push(temp);
                        }
                    });
                    if( $scope.settings.product_data.product.length == 0 ){
                        angular.copy($scope.stored_product, $scope.settings.product_data.product);
                    }
                }else{
                    angular.copy($scope.stored_product, $scope.settings.product_data.product);
                    if( data.page.number < number_side ){
                        $scope.settings.product_data.product.splice(data.page.number, number_side - data.page.number);
                    }else if( data.page.number > number_side ){
                        var i;
                        for(i = 0; i < data.page.number - number_side; i++){
                            var temp = angular.copy($scope.settings.product_data.product[number_side - 1], temp);
                            $scope.settings.product_data.product.push(temp);
                        }
                    }
                }
            }
            if( angular.isDefined( data.color ) ){
                angular.forEach($scope.settings.product_data.product, function(side, key){
                    if(data.color.bg_type == 'c'){
                        side.bg_type = 'color';
                        side.bg_color_value = data.color.bg_color;
                    }else{
                        side.bg_type = 'image';
                        if( angular.isDefined(data.page) && angular.isDefined( data.page.list_page ) ){
                            if( angular.isDefined( data.page.list_page[key] ) ){
                                var _key = data.page.list_page[key];
                                if( angular.isDefined(data.color.bg_image[_key]) ) side.img_src = data.color.bg_image[_key];
                            }
                        }else{
                            if( angular.isDefined(data.color.bg_image[key]) ) side.img_src = data.color.bg_image[key];
                        }
                    }
                });
            }
            if( angular.isDefined( data.size ) ){
                angular.forEach($scope.settings.product_data.product, function(side, key){
                    side.product_height = data.size.product_height;
                    side.product_width = data.size.product_width;
                    side.real_width = data.size.real_width;
                    side.real_height = data.size.real_height;
                    side.real_left = data.size.real_left;
                    side.real_top = data.size.real_top;
                    var ratio = side.product_width / side.product_height;
                    side.img_src_top = side.img_src_left = side.area_design_top = side.area_design_left = 0;
                    if(ratio > 1){
                        side.img_src_width = 500;
                        side.area_design_width = 500;
                        side.img_src_height = 500 / ratio;
                        side.area_design_height = 500 / ratio;
                    }else{
                        side.img_src_height = 500;
                        side.area_design_height = 500;
                        side.img_src_width = 500 * ratio;
                        side.area_design_width = 500 * ratio;
                    }                    
                });
            }
            if( angular.isDefined( data.dimension ) ){
                angular.forEach($scope.settings.product_data.product, function(side, key){
                    side.product_height = data.dimension.height;
                    side.product_width = data.dimension.width;
                    side.real_width = data.dimension.width;
                    side.real_height = data.dimension.height;
                    side.real_left = side.real_top = side.img_src_top = side.img_src_left = side.area_design_left = side.area_design_top = 0;
                    var ratio = side.product_width / side.product_height;
                    if(ratio > 1){
                        side.img_src_width = 500;
                        side.area_design_width = 500;
                        side.img_src_height = 500 / ratio;
                        side.area_design_height = 500 / ratio;
                    }else{
                        side.img_src_height = 500;
                        side.area_design_height = 500;
                        side.img_src_width = 500 * ratio;
                        side.area_design_width = 500 * ratio;
                    }
                });
            }
            if( angular.isDefined( data.orientation ) ){
                angular.forEach($scope.settings.product_data.product, function(side, key){
                    if( ( data.orientation == 1 && side.real_width < side.real_height ) || ( data.orientation == 0 && side.real_height < side.real_width ) ){
                        var temp = side.real_width;
                        var new_left = side.real_left + ( side.real_width - side.real_height ) / 2;
                        var new_top = side.real_top + ( side.real_height - side.real_width ) / 2;
                        side.area_design_width = side.area_design_width * side.real_height / side.real_width;
                        side.area_design_height = side.area_design_height * side.real_width / side.real_height;
                        //todo something
                        side.real_width = side.real_height;
                        side.real_height = temp;
                        side.real_left = new_left;
                        side.real_top = new_top;
                        
                        if( angular.isDefined( data.dimension ) || angular.isDefined( data.size ) ){
                            var temp = side.product_width;
                            side.product_width = side.product_height;
                            side.product_height = temp;
                            side.real_left = side.real_top = side.img_src_top = side.img_src_left = side.area_design_left = side.area_design_top = 0;
                            var ratio = side.product_width / side.product_height;
                            if(ratio > 1){
                                side.img_src_width = 500;
                                side.area_design_width = 500;
                                side.img_src_height = 500 / ratio;
                                side.area_design_height = 500 / ratio;
                            }else{
                                side.img_src_height = 500;
                                side.area_design_height = 500;
                                side.img_src_width = 500 * ratio;
                                side.area_design_width = 500 * ratio;
                            }
                        }
                    }
                });
            }
            if( angular.isDefined( data.area ) ){
                angular.forEach($scope.settings.product_data.product, function(side, key){
                    side.area_design_type = data.area;
                });
            }
            if( angular.isUndefined(first) ){
                $scope.saveDesign();
                appConfig.ready = false;
                if( (angular.isDefined( data.color ) && data.color.bg_type == 'c') || angular.isDefined( data.area ) ){
                    $scope.forceInitStage = true;
                }else{
                    $scope.settings.product_data.design = $scope.resource.jsonDesign;
                    $scope.settings.product_data.config = {};
                    $scope.settings.product_data.config.viewport = $scope.calcViewport();
                    $scope.settings.product_data.fonts = $scope.resource.usedFonts;
                };
                $scope.processProductSettings();
                $scope.updateApp();
            }
        }
    };
    $scope.onloadVariation = false;
    $scope.changeVariation = function(){
        if( $scope.onloadVariation ) return;
        $scope.onloadVariation = true;
        $scope.toggleStageLoading();
        $scope.saveDesign();
        appConfig.ready = false;
        NBDDataFactory.get('nbdesigner_get_product_info', {product_id: NBDESIGNCONFIG['product_id'], variation_id: NBDESIGNCONFIG['variation_id'], need_templates: 1}, function(data){
            $scope.toggleStageLoading();
            $scope.onloadVariation = false;
            nbd_window.NBDESIGNERPRODUCT.nbdesigner_ready();
            $scope.settings.product_data = JSON.parse(data);
            if( angular.isDefined($scope.settings.product_data.templates) ){
                $scope.resource.templates = $scope.settings.product_data.templates;
            }
            $scope.settings.product_data.design = $scope.resource.jsonDesign;
            $scope.settings.product_data.config = {};
            $scope.settings.product_data.config.viewport = $scope.calcViewport();
            $scope.settings.product_data.fonts = $scope.resource.usedFonts;
            $scope.changePrintingOptions( true );
            $scope.processProductSettings();
        });
    };
    $scope.loadedPrintingOptions = false;
    $scope.widthoutPrintingOptions = false;
    $scope.getPrintingOptions = function(){
        jQuery('.nbd-popup.popup-nbo-options').nbShowPopup();
        if(!$scope.loadedPrintingOptions){
            $http({
                method: 'GET',
                url: $scope.settings.link_get_options
            }).then(function(response){
                $scope.loadedPrintingOptions = true;
                var container = jQuery('#nbo-options-wrap');
                container.append(response.data);
                if( jQuery('.nbo-wrapper').length == 0 ){
                    $scope.widthoutPrintingOptions = true;
                    if( jQuery('input[name="variation_id"]').length > 0 && jQuery('input[name="variation_id"]').val() > 0 ){
                        $scope.printingOptionsAvailable = true;
                    }
                    jQuery('.variations_form').on('woocommerce_variation_has_changed', function(){
                        if( jQuery('input[name="variation_id"]').length > 0 && jQuery('input[name="variation_id"]').val() > 0 ){
                            $scope.printingOptionsAvailable = true;
                        }else{
                            $scope.printingOptionsAvailable = false;
                        }
                    });                    
                }
                if(NBDESIGNCONFIG.show_nbo_option == "1" && NBDESIGNCONFIG.task == 'new'){
                    container.find('form.variations_form').append('<input name="submit_form_mode2" type="hidden" value="1" />');
                    container.find('form.cart').append('<input name="submit_form_mode2" type="hidden" value="1" />');
                    container.find('form.cart').append('<input name="add-to-cart" type="hidden" value="'+NBDESIGNCONFIG.product_id+'" />');
                }
                if( NBDESIGNCONFIG.task2 != '' ){
                    jQuery('.variations_form').addClass('nbd-disabled');
                    jQuery('form.cart').addClass('nbd-disabled');
                }
                jQuery('.nbd-popup.popup-nbo-options .overlay-popup').addClass('nbo-disable');
                jQuery('.single_add_to_cart_button').addClass('nbd-disabled');
                jQuery('.nbd-popup.popup-nbo-options').find('.overlay-main').removeClass('active');
                jQuery('.single_add_to_cart_button').hide();
                var newScope = angular.element(container).scope();
                var compile = angular.element(container).injector().get('$compile');
                compile(jQuery(container).contents())(newScope);
                $timeout(function(){
                    container.perfectScrollbar();
                    jQuery('#nbo-options-wrap .variations_form').wc_variation_form();
                    jQuery('#nbo-options-wrap .variations_form').trigger( 'wc_variation_form' );
                    jQuery('#nbo-options-wrap .variations_form .variations select').change();
                });
            });
        }
    };
    /* Upload Image */
    $scope.uploadFile = function(files, indexFile){
        indexFile = angular.isDefined(indexFile) ? indexFile : 0;
        if( files.length <= 0 || indexFile > (files.length - 1) || indexFile > (parseInt($scope.settings.nbdesigner_max_upload_files_at_once) - 1) ) return;
        var file = files[indexFile],
        max_size = parseInt($scope.settings.nbdesigner_maxsize_upload),     
        min_size = parseInt($scope.settings.nbdesigner_minsize_upload);      
        if( file.type.indexOf("image") === -1 ){
            alert('Only support image');
            return;
        }
        if (file.size > max_size * 1024 * 1024 ) {
            alert('Max file size' + max_size + " MB");
            return;            
        }else if(file.size < min_size * 1024 * 1024){
            alert('Min file size' + max_size + " MB");
            return;          
        };
        if( file.type.indexOf("svg") > -1 ){
            var reader = new FileReader();
            reader.onload = function(event){
                if (event.target.readyState === 2) {
                    var result = reader.result;
                    $scope.addSvgFromString(result);
                    $scope.uploadFile(files, indexFile + 1);
                }
            };
            reader.readAsText(file);
        }else{
            $scope.toggleStageLoading();
            NBDDataFactory.get('nbdesigner_customer_upload', {file: file}, function(data){
                var data = JSON.parse(data);
                if( data.flag == 1 ){
                    if( angular.isDefined(data.ilr) ) $scope.resource.upload.ilr = true;
                    if( $scope.resource.upload.ilr && NBDESIGNCONFIG['nbdesigner_enable_low_resolution_image'] == 'no' ){
                        $scope.toggleStageLoading();
                        alert(data.mes);
                        $scope.uploadFile(files, indexFile + 1);
                        return;
                    };
                    $scope.storeUploadFile(data.src, data.name);
                    $scope.addImage(data.src, false, true );
                    jQuery("#tab-photo .tab-scroll").stop().animate({
                        scrollTop: jQuery("#tab-photo .tab-scroll").prop("scrollHeight")
                    }, 100);
                    localStorage.setItem('uploaded', $scope.resource.upload.data);
                    $scope.onEndRepeat('upload');
                    $scope.uploadFile(files, indexFile + 1);
                }else{
                    $scope.toggleStageLoading();
                    alert(data.mes);
                }
            });
        }
    };
    $scope.storeUploadFile = function(src, name){
        $scope.resource.upload.data.push({
            url: src,
            des: name,
            ilr: $scope.resource.upload.ilr
        });        
        if( $scope.settings.nbdesigner_cache_uploaded_image == 'yes' ){
            $scope._localStorage.save('nbduploaded');
        }
    };
    /* Login */
    $scope.login = function(callback){
        if( $scope.settings.is_logged ){
            if(typeof callback == 'function') callback();
            return;
        }else{
            $scope.toggleStageLoading();
            NBDDataFactory.get('nbd_check_use_logged_in', {type: 'check_login'}, function(data){
                data = JSON.parse(data);
                $scope.toggleStageLoading();
                if( data.is_login == 1 ){
                    NBDESIGNCONFIG['nonce_get'] = data.nonce_get;
                    NBDESIGNCONFIG['nonce'] = data.nonce;
                    if(typeof callback == 'function') callback();
                    return;
                }else{
                    var popupLeft = (window.screen.width - 700) / 2,
                        popupTop = (window.screen.height - 500) / 2,
                        popup = window.open(NBDESIGNCONFIG['login_url'], '', 'width=700,height=500,left='+popupLeft+',top='+popupTop+'');
                    popup.onload = new function() {
                        if(window.location.hash.length == 0) {
                            popup.open(NBDESIGNCONFIG['login_url'], '_self');
                        }; 
                        var interval = setInterval(function () {
                            try {
                                if (popup.location.hash.length) {
                                    var hash = popup.location.hash;
                                    var res = hash.split("___");
                                    if(res.length){
                                        NBDESIGNCONFIG['nonce_get'] = res[0].substr(1);
                                        NBDESIGNCONFIG['nonce'] = res[1];                             
                                    }
                                    clearInterval(interval);
                                    $scope.settings['is_logged'] = 1;
                                    popup.close();
                                    $scope.updateApp();
                                    if(typeof callback == 'function') callback();
                                }
                            } catch (evt) {
                                //permission denied
                            }
                        }, 100);   
                    }                      
                }
            });
        }
    };
    /* Extenal Image */
    $scope.addImageFromUrl = function( url, extenal, ilr ){
        if( url == '' ) return;
        $scope.toggleStageLoading();
        $scope.showDesignTab();
        if(url.match(/\.(svg)$/) != null ){
            var art = {url: url, name: ''};
            $scope.addArt(art, false, true);
            return
        };
        if( angular.isUndefined(extenal) || extenal ){
            NBDDataFactory.get('nbdesigner_copy_image_from_url', {url: url, gapi: $scope.resource.gapi}, function(data){
                data = JSON.parse(data);
                if(data['flag'] == 1){
                    $scope.addImage(data['src'], false, true);
                    $scope.storeUploadFile(data.src, '');
                } else{
                    alert('Try to download image and then upload to our server!');
                }
            });
        }else{
            if( ilr ) $scope.resource.upload.ilr = true;
            $scope.addImage(url, false, true);
        }
    };  
    $scope.stageOnload = false;
    $scope.toggleStageLoading = function( timeout ){
        jQuery('.loading-workflow').toggleClass('nbd-show');
        jQuery('body').toggleClass('nbd-onloading');
        var _timeout = timeout ? timeout : 2E4;
        if( jQuery('.loading-workflow').hasClass('nbd-show') ){
            $scope.stageOnload = true;
            promise = $timeout(function(){
                if( $scope.stageOnload ){
                    jQuery('.loading-workflow').toggleClass('nbd-show');
                    jQuery('body').toggleClass('nbd-onloading');                    
                }
            }, _timeout);
        }else{
            $timeout.cancel(promise);
            $scope.stageOnload = false;
        }
    };
    /* Webcam */
    $scope.initWebcam = function(){
        $scope.resource.webcam.status = true;
        Webcam.set({
            width: 400,
            height: 300,
            dest_width: 1280,
            dest_height: 960,
            image_format: 'jpeg',
            jpeg_quality: 100
        });
        Webcam.set("constraints", {
            optional: [{ minWidth: 600 }]
        });        
        Webcam.attach( '#my_camera' );     
        Webcam.setSWFLocation(NBDESIGNCONFIG['assets_url'] + 'webcam.swf');  
    };    
    $scope.pauseWebcam = function(status){
        status == true  && Webcam.freeze() || Webcam.unfreeze();
    };
    $scope.resetWebcam = function(){
        if($scope.resource.webcam.status){
            Webcam.reset();
            $scope.resource.webcam.status = false;
        }else{
            $scope.initWebcam();
        }        
    };     
    $scope.takeSnapshot = function(){
        Webcam.snap( function(data_uri) {
            $scope.resetWebcam();
            var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
            NBDDataFactory.get('nbdesigner_save_webcam_image', {image: raw_image_data}, function(data){
                data = JSON.parse(data);
                if(data.flag == 'success'){
                    jQuery('.popup-webcam .close-popup').triggerHandler('click');
                    $scope.toggleStageLoading();
                    $scope.addImage(data.url, false, true);
                }else{
                    alert('Oops! Try again!');
                    $scope.initWebcam();                    
                }
            });
        });
    };
    $scope.onEndRepeat = function(type){
        switch(type){
            case 'typography':
                $scope.renderMasonryList(type, '.nbd-sidebar .typography-items', '.typography-item', '#tab-typography', $scope.resource[type].init);
                break;
            case 'font':
                jQuery('#toolbar-font-familly-dropdown').perfectScrollbar('update');
                break;
            case 'clipart':
                $scope.renderMasonryList(type, '#tab-svg .clipart-wrap', '.clipart-item', '#tab-svg', $scope.resource[type].init);
                break; 
            case 'photo':
                $scope.renderMasonryList(type, '#tab-photo .nbdesigner-gallery', '.nbdesigner-item', '#tab-photo', $scope.resource[type].init);
                break;
            case 'dropbox':
            case 'instagram': 
            case 'facebook':  
            case 'upload':    
            case 'shape':    
            case 'icon':    
            case 'line':    
                $scope.renderMasonryList(type, '#nbd-'+type+'-wrap .mansory-wrap', '.mansory-item', '#nbd-'+type+'-wrap', $scope.resource[type].init);
                break;         
        }
    };
    $scope.updateScrollBar = function( jSelector ){
        $timeout(function(){
            jQuery(jSelector).perfectScrollbar('update');
        });
    };
    $scope.renderMasonryList = function(type, container, item, scrollContainer, init){  
        imagesLoaded( jQuery(container), function() {
            if( !init ) jQuery(container).masonry('destroy');            
            var $grid = jQuery(container).masonry({
                itemSelector: item
            }); 
            //$grid.on( 'layoutComplete', function(){
                jQuery.each(jQuery(container + ' ' +item), function(e) {
                    var animate = Math.floor(Math.random() * 10);
                    animate = (animate + 1) * 100;           
                    if( checkMobileDevice() ){
                        jQuery(this).addClass("in-view");
                    }else{
                        jQuery(this).addClass("in-view slideInDown animated animate"+animate);
                    }
                }); 
                jQuery(scrollContainer+' .tab-scroll').perfectScrollbar('update');
                $timeout(function(){
                    jQuery(scrollContainer + ' .loading-photo').hide();
                }, 100);
                $scope.resource[type].onload = false;
                $scope.resource[type].init = false;
            //});            
        });
    };
    /* Infinite scroll */
    $scope.scrollLoadMore = function(container, type){
        if( $scope.resource[type].onload ) return;
        if( type == 'photo' && $scope.resource.personal.status ){
            var photoType = $scope.resource.personal.type;
            if( photoType == 'url' || photoType == 'upload' ) return;
            if( $scope.resource[photoType].filter.currentPage * $scope.resource[photoType].filter.perPage < $scope.resource[photoType].filter.total ){
                $scope.resource[photoType].filter.currentPage += 1;
            }else{
                jQuery(container + ' .loading-photo').hide();
                return;
            }
            jQuery(container + ' .loading-photo').show();
            $scope.resource[photoType].onload = true;
            if( photoType == 'facebook' ) $scope.getPersonalPhoto('facebook');
            $scope.updateApp();
            return;
        };
        if( type == 'element' ){
            var elementType = $scope.resource.element.type;
            if( ['icon', 'shape', 'line'].indexOf(elementType) > -1 ){
                if( $scope.resource[elementType].filter.currentPage < $scope.resource[elementType].filter.totalPage ){
                    $scope.resource[elementType].filter.currentPage += 1;
                    $scope.getMedia(elementType, 'more');
                }else{
                    jQuery(container + ' .loading-photo').hide();
                    return;
                }
            };
//            jQuery("#tab-element .tab-scroll").stop().animate({
//                scrollTop: jQuery('#tab-element .main-items').height()
//            }, 100);            
            return;
        };
        if( type == 'globalTemplate' ){
            if( $scope.resource[type].filter.currentPage < $scope.resource[type].filter.totalPage ){
                $scope.resource[type].filter.currentPage += 1;
                $scope.toggleStageLoading();
                $scope.resource[type].onload = true;                
                $scope.loadGlobalTemplate($scope.templateCat);
            }else{
                jQuery(container + ' .loading-photo').hide();
                return;
            }         
            return;
        }
        if( $scope.resource[type].filter.currentPage * $scope.resource[type].filter.perPage >= $scope.resource[type].filter.total){
            jQuery(container + ' .loading-photo').hide();
            return;
        }
        jQuery(container + ' .loading-photo').show();
        if( $scope.resource[type].filter.currentPage * $scope.resource[type].filter.perPage < $scope.resource[type].filter.total ){
            $scope.resource[type].filter.currentPage += 1;
        }
        switch(type){
            case 'typography':
            case 'clipart':    
                $scope.resource[type].onload = true;
                break;
            case 'font':
                //todo something
                break;  
            case 'photo':
                $scope.resource[type].onload = true;
                !$scope.resource.personal.status && $scope.getPhoto($scope.resource.photo.type, 'more');
                break;
        }
        $scope.updateApp();
    };
    $scope.generateTypoLink = function(typo){
        if( $scope.settings.task == 'typography' ){
            return NBDESIGNCONFIG['plg_url'] + '/data/typography/img/' + typo.id + '.png';
        }else{
            return '//dpeuzbvf3y4lr.cloudfront.net/typography/' + typo.folder + '/preview.png';
        }
    };
    /* Fonts */
    $scope.loadFontFailAction = function( font ){
        _.remove($scope.settings.gg_fonts, {
            id: font.id
        });
        $scope.resource.font.filteredFonts = filterFontFilter($scope.resource.font.data, $scope.resource.font.filter);
        $scope.updateApp();
    };
    /* Save Data */
    $scope.saveForLater = function(){
        $scope.login(function(){
            $scope.saveData('saveforlater');
        });
    };
    $scope.saveData = function(type){
        if( angular.isUndefined(type) ) type = $scope.settings.task;
        if(type != 'share' ) $scope.toggleStageLoading( 6E4 );
        if(type == 'typography') $scope.resource.usedFonts = [];
        if(type != 'saveforlater' && type != 'share' ) $scope.maybeZoomStage = true;
        $scope.saveDesign();
        $scope.resource.config.viewport = $scope.calcViewport(); 
        /* Backward compatible version 1.x */
        $scope.resource.config.scale =  ($window.innerWidth > ($window.innerHeight - 120) ? $window.innerHeight - 120 : $window.innerWidth) / 500;  
        $scope.resource.config.product = $scope.settings.product_data.product;
        $scope.resource.config.dpi = $scope.settings.product_data.option.dpi;
        var dataObj = {};
        dataObj.used_font = new Blob([JSON.stringify($scope.resource.usedFonts)], {type: "application/json"}); 
        if( type == 'template' ) $scope.resource.jsonDesign.canvas = {width: $scope.templateSize.width, height: $scope.templateSize.height};
        dataObj.design = new Blob([JSON.stringify($scope.resource.jsonDesign)], {type: "application/json"});
        _.each($scope.stages, function(stage, index){
            var key = 'frame_' + index,
                svg_key = 'frame_' + index + '_svg'; 
            dataObj[key] = $scope.makeblob(stage.design);
            if(type != 'typography' && type != 'template' ){
                dataObj[svg_key] = new Blob([stage.svg], {type: "image/svg"});  
            }
        });
        switch(type){
            case 'typography':
                dataObj.type = 'save_typography';
                dataObj.id = $scope.resource.currentTypo;
                _.each($scope.stages, function(stage, index){
                    var key = 'frame_' + index;
                    dataObj[key] = $scope.makeblob(stage.design);
                });
                NBDDataFactory.get('nbd_get_resource', dataObj, function(data){
                    $scope.stages[0].states.usedFonts = [];
                    alert('Success!');
                });
                break;
            case 'template':
                dataObj.type = 'save_template';
                dataObj.source = 'media';
                dataObj.tem_name = $scope.templateName;
                dataObj.cid = $scope.templateCat;
                jQuery('.popup-template .close-popup').triggerHandler('click');
                NBDDataFactory.get('nbd_get_resource', dataObj, function(data){
                    data = JSON.parse(data);
                    if( data.flag == 1 ){
                        _.each($scope.stages, function(stage, index){
                            stage.states.usedFonts = [];
                        });
                        $scope.resource.usedFonts = [];
                        $scope.listAddedColor = [];
                        $scope.resetStage();
                        $scope.toggleStageLoading();
                        alert('Success!');
                    }else{
                        alert('Try again!');
                    }
                });
                break;
            case 'saveforlater':    
            default:
                ['product_id', 'variation_id', 'task', 'task2', 'design_type', 'nbd_item_key', 'cart_item_key', 'order_id', 'enable_upload_without_design', 'auto_add_to_cart'].forEach(function(key){
                    dataObj[key] = NBDESIGNCONFIG[key];
                });
                if( type == 'share' ) dataObj['share'] = 1;
                dataObj['nbd_file'] = '';
                dataObj.config = new Blob([JSON.stringify($scope.resource.config)], {type: "application/json"}); 
                if( NBDESIGNCONFIG.task == 'new' && NBDESIGNCONFIG.ui_mode == 1 ){
                    dataObj.auto_add_to_cart = NBDESIGNCONFIG['nbdesigner_auto_add_cart_in_detail_page'];
                };
                $timeout(function(){
                    var action = ( type != 'share' && type != 'saveforlater' && NBDESIGNCONFIG.task == 'new' && NBDESIGNCONFIG.ui_mode == 2 ) ?  'nbd_save_cart_design' : 'nbd_save_customer_design';
                    if(NBDESIGNCONFIG.show_nbo_option == "1" && NBDESIGNCONFIG.task == 'new'){
                        action = 'nbd_save_customer_design';
                    }
                    NBDDataFactory.get(action, dataObj, function(data){
                        data = JSON.parse(data);
                        if(data.flag == 'success'){
                            if( type == 'saveforlater' ){
                                var _dataObj = {product_id: NBDESIGNCONFIG.product_id, variation_id: NBDESIGNCONFIG.variation_id, folder: data.folder};
                                NBDDataFactory.get('nbd_save_for_later', _dataObj, function(_data){
                                    _data = JSON.parse(_data);
                                    $scope.toggleStageLoading();
                                }); 
                                return;
                            } if( type == 'share' ) {
                                $scope.resource.social.folder = data.sfolder;
                                jQuery('.nbd-popup.popup-share').find('.overlay-main').removeClass('active');   
                                return;
                            }else{
                                if(NBDESIGNCONFIG.show_nbo_option == "1" && NBDESIGNCONFIG.task == 'new' && NBDESIGNCONFIG.task2 == '' ){
                                    jQuery('.variations_form').submit();
                                    jQuery('form.cart').submit();
                                    return;
                                }
                                if(NBDESIGNCONFIG['redirect_url'] != ""){
                                    window.location = NBDESIGNCONFIG['redirect_url'];
                                    return;
                                };                      
                                if( NBDESIGNCONFIG['nbdesigner_auto_add_cart_in_detail_page'] == "yes" && data.added == 1 ){
                                    nbd_window.location = NBDESIGNCONFIG['cart_url'];
                                }else{
                                    nbd_window.NBDESIGNERPRODUCT.product_id = NBDESIGNCONFIG['product_id'];
                                    nbd_window.NBDESIGNERPRODUCT.variation_id = NBDESIGNCONFIG['variation_id'];             
                                    nbd_window.NBDESIGNERPRODUCT.folder = data.folder;
                                    nbd_window.NBDESIGNERPRODUCT.show_design_thumbnail(data.image, NBDESIGNCONFIG['task']);
                                    nbd_window.NBDESIGNERPRODUCT.get_sugget_design(NBDESIGNCONFIG['product_id'], NBDESIGNCONFIG['variation_id']);                                     
                                    $scope.toggleStageLoading();
                                    $timeout(function(){
                                        _.each($scope.stages, function(stage, index){
                                            $scope.zoomStage(stage.states.fitScaleIndex, index);
                                        });                                        
                                    });                         
                                }
                            }
                        }else{
                            console.log('Oops! Design has not been saved!');
                            $scope.toggleStageLoading();
                        }    
                    });                    
                });
                break;
        }
    };
    $scope.createShareLink = function(type, origin_url){
        var d = new Date();
        var share_url = NBDESIGNCONFIG.nbd_create_own_page + '?product_id=' + NBDESIGNCONFIG.product_id + '&variation_id=' + NBDESIGNCONFIG.variation_id + '&reference=' + $scope.resource.social.folder + '&nbd_share_id=' + $scope.resource.social.folder + '&t=' + d.getTime();
        $scope.resource.social.link = origin_url + encodeURIComponent(share_url);
        if( type == 'twitter' ) $scope.resource.social.link += '&text=' + $scope.resource.social.comment;
    };
    $scope.updateShareLink = function(){
        var link = $scope.resource.social.link;
        if(link.indexOf('&text=') > -1){
            link = link.substr(0, link.indexOf('&text=') + 7) + $scope.resource.social.comment;
            $scope.resource.social.link = link;
        }
    };
    $scope.maybeZoomStage = false;
    $scope.saveDesign = function(){
        _.each($scope.stages, function(stage, index){
            $scope.deactiveAllLayer(index);
            var zoomIndex = stage.states.fillScaleIndex != -1 ? stage.states.fillScaleIndex : stage.states.fitScaleIndex;
            if($scope.maybeZoomStage) $scope.zoomStage(zoomIndex, index);
            var _canvas = stage.canvas,
                key = 'frame_' + index;
            $scope.renderStage(index);
            $scope.resource.jsonDesign[key] = _canvas.toJSON($scope.includeExport);
            stage.svg = _canvas.toSVG();
            stage.design = _canvas.toDataURL();
            $scope.resource.usedFonts = _.concat($scope.resource.usedFonts, stage.states.usedFonts);
        });
        $scope.resource.usedFonts = _.uniqBy($scope.resource.usedFonts, 'alias');
        $scope.maybeZoomStage = false;
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
    $scope.updateApp = function(){
        if ($scope.$root.$$phase !== "$apply" && $scope.$root.$$phase !== "$digest") $scope.$apply(); 
    };
    $scope.$on('nbd:keypress', function(event, e){
        $scope.keypressHandle(e);
    });
    $scope.$on('nbd:keydown', function(event, e){
        $scope.keydownHandle(e);
    });    
    $scope.keydownHandle = function(e){
        //todo
    };
    $scope.wraperClickHandle = function($event){
        var $textPicker = jQuery('#nbd-text-color-picker');
        var $bgPicker = jQuery('#nbd-bg-color-picker');
        var $globalPicker = jQuery('#nbd-global-color-picker');
        if (!jQuery($event.target).hasClass('color-palette-add') && $scope.showTextColorPicker 
                && $textPicker.has($event.target).length == 0 && !$textPicker.is($event.target)){
            $scope.showTextColorPicker = false;
        };
        if( !jQuery($event.target).hasClass('color-palette-add') && $scope.showBgColorPicker && $bgPicker.has($event.target).length == 0 && !$bgPicker.is($event.target) ){
            $scope.showBgColorPicker = false;
        }
        if( !jQuery($event.target).hasClass('color-palette-add') && $scope.globalPicker.active && $globalPicker.has($event.target).length == 0 && !$globalPicker.is($event.target) ){
            $scope.globalPicker.active = false;
        }        
    };
    /* Hotkeys */
    $scope.keypressHandle = function(e){
        var targetEl = e.target.tagName.toUpperCase();
        if( targetEl == 'INPUT' || targetEl == 'TEXTAREA' ||  $scope.stages[$scope.currentStage].states.isEditing ){
            if( !(e.ctrlKey && (e.which == 66 || e.which == 73))  ){
                return;
            }
        }
        var _stage = $scope.stages[$scope.currentStage],
        _states = _stage.states;        
        if(e.ctrlKey || e.metaKey){
            var keepDefault = [67, 116];
            if( _.includes(keepDefault, e.which) ) return;
            e.preventDefault();
            if( e.shiftKey ){
                switch( e.which ) { 
                    case 221:
                        /* Hold Ctrl + Shift + ] Bring layer to front */ 
                        $scope.setStackPosition('bring-front');
                        break;
                    case 219:
                        /* Hold Ctrl + Shift + [ Send layer to back */ 
                        $scope.setStackPosition('send-back');
                        break;   
                    case 73:
                        /* Hold Ctrl + Shift + I → Import Design */ 
                        $scope.importDesign();
                        break;
                    case 69:
                        /* Hold Ctrl + Shift + E → Export Design */ 
                        $scope.exportDesign();
                        break;      
                    case 83:
                        /* Hold Ctrl + Shift + S → Save Design for later*/ 
                        $scope.saveData('saveforlater');
                        break;  
                    case 76:
                        /* Hold Ctrl + Shift + L → clear all stages*/ 
                        $scope.clearAllStage();
                        break;
                    case 79:
                        /* Hold Ctrl + Shift + O → Load My Design in Cart*/ 
                        $scope.loadMyDesign(null, true);
                        break;
                    case 188:
                        /* Hold Ctrl + Shift + < → Decreate font size*/ 
                        if( _states.isText ){
                            _states.text.ptFontSize -= 1;
                            $scope.setTextAttribute('fontSize', _states.text.ptFontSize);
                        }
                        $scope.updateApp();
                        break;  
                    case 190:
                        /* Hold Ctrl + Shift + > → Increate font size*/ 
                        if( _states.isText ){
                            _states.text.ptFontSize += 1;
                            $scope.setTextAttribute('fontSize', _states.text.ptFontSize);
                        }
                        $scope.updateApp();
                        break; 
                    case 71:
                        /* Hold Ctrl + Shift + G → Ungroup */ 
                        if( _states.isNativeGroup ){
                            $scope.unGroupLayers();
                        }
                        $scope.updateApp();
                        break;                         
                }
            }else{
                switch( e.which ) {
                    case 65:
                        /* Hold Ctrl press A → select all layers */
                        $scope.selectAllLayers();
                        break;
                    case 66:
                        /* Hold Ctrl press B → set font weight bold */
                        if( _states.isText 
                                && (_states.text.font.file.b 
                                && ( _states.text.fontStyle != 'italic' || ( _states.text.fontStyle == 'italic'  && _states.text.font.file.bi ) )) ){
                            $scope.setTextAttribute('fontWeight', _states.text.fontWeight == 'bold' ? 'normal' : 'bold');
                        }
                        $scope.updateApp();
                        break;   
                    case 80:
                        /* Hold Ctrl press P → duplicate layers */
                        $scope.copyLayers();
                        break;                 
                    case 73:
                        /* Hold Ctrl press I → set text style italic */
                        if( _states.isText 
                                && (_states.text.font.file.i 
                                && ( _states.text.fontWeight != 'bold' || ( _states.text.fontWeight == 'bold'  && _states.text.font.file.bi ) )) ){                    
                            $scope.setTextAttribute('fontStyle', _states.text.fontStyle == 'italic' ? 'normal' : 'italic');
                        }
                        $scope.updateApp();
                        break; 
                    case 68:
                        /* Hold Ctrl press D → deselect group */
                        $scope.deactiveAllLayer();
                        break;    
                    case 69:
                        /* Hold Ctrl press E → clear stage */
                        $scope.clearStage();
                        break;                      
                    case 90:
                        /* Hold Ctrl press Z → Undo */
                        if( _states.isUndoable ){
                            $scope.undo();
                        }
                        break;    
                    case 89:
                        /* Hold Ctrl press Y → Undo */
                        if( _states.isRedoable ){
                            $scope.redo();
                        }
                        break;    
                    case 71:
                        /* Hold Ctrl press G → Group Layers */
                        if( _states.isGroup ){
                            $scope.groupLayers();
                        }
                        $scope.updateApp();
                        break;   
                    case 76:
                        /* Hold Ctrl press L → Toggle Bleed Line */
                        $scope.settings.bleedLine = !$scope.settings.bleedLine;
                        $scope.updateApp();
                        break;
                    case 82:
                        /* Hold Ctrl press R → Toggle Ruler */
                        $scope.settings.showRuler = !$scope.settings.showRuler;
                        $scope.updateApp();
                        break;    
                    case 72:
                        /* Hold Ctrl press H → Align layer center horizontal */
                        $scope.translateLayer('horizontal');
                        break;    
                    case 86:
                        /* Hold Ctrl press V → Align layer center vertical */
                        $scope.translateLayer('vertical');
                        break;     
                    case 107:
                        /* Hold Ctrl press + → Zoom In stage */
                        if( _states.currentScaleIndex < _states.scaleRange.length - 1 ){
                            $scope.zoomStage(_states.currentScaleIndex + 1);
                            $scope.updateApp();
                        }
                        break;    
                    case 109:
                        /* Hold Ctrl press - → Zoom out stage */
                        if( _states.currentScaleIndex > 0 ){
                            $scope.zoomStage(_states.currentScaleIndex - 1);
                            $scope.updateApp();
                        }
                        break;
                    case 48:
                    case 96:
                        /* Hold Ctrl press 0 → Resize stage to fit */
                        $scope.zoomStage(_states.fitScaleIndex);
                        $scope.updateApp();                
                        break;
                    case 49:
                    case 97:
                        /* Hold Ctrl press 1 → Resize stage to origin size */
                        _states.fillScaleIndex == -1 && $scope.zoomStage(_states.fitScaleIndex) || $scope.zoomStage(_states.fillScaleIndex);
                        $scope.updateApp();                
                        break;
                    case 221:
                        /* Hold Ctrl press ] Bring layer forward */ 
                        $scope.setStackPosition('bring-forward');
                        break;
                    case 219:
                        /* Hold Ctrl press [ Bring layer backward */ 
                        $scope.setStackPosition('send-backward');
                        break;  
                    case 79:
                        /* Hold Ctrl press O → Load My Design */ 
                        $scope.loadMyDesign(null, false);
                        break;                     
                }
            }   
        }else if( e.altKey ){
            e.preventDefault();
            switch( e.which ) {
                case 37:
                    /* Hold Alt press left arrow */
                    $scope.moveLayer('left', 'alt');
                    break;
                case 38:
                    /* Hold Alt press up arrow */
                    $scope.moveLayer('up', 'alt');
                    break;       
                case 39:
                    /* Hold Alt press right arrow */
                    $scope.moveLayer('right', 'alt');
                    break;
                case 40:
                    /* Hold Alt press down arrow */
                    $scope.moveLayer('down', 'alt');
                    break;   
                case 85:
                    /* Hold Alt press U */
                    if( _states.isText ) $scope.setTextAttribute('is_uppercase', true);
                    $scope.updateApp();
                    break;   
                case 76:
                    /* Hold Alt press U */
                    if( _states.isText ) $scope.setTextAttribute('is_uppercase', false);
                    $scope.updateApp();
                    break;                
            } 
        } else if( e.shiftKey ){
            switch( e.which ) {
                case 107:
                    /* Hold Shift press + → zoom out layer */
                    $scope.scaleLayer('+');
                    break;
                case 109:
                    /* Hold Shift press - → zoom in layer */
                    $scope.scaleLayer('-');
                    break; 
                case 71:
                    /* Hold Shift  + G → Toggle Grid */ 
                    $scope.settings.showGrid = !$scope.settings.showGrid;
                    $scope.updateApp();
            }
        } else {
            switch( e.which ) {
                case 37:
                    /* Press left arrow */
                    if( _states.isActiveLayer )
                        $scope.moveLayer('left');
                    break;
                case 38:
                    /* Press up arrow */
                    if( _states.isActiveLayer )
                        $scope.moveLayer('up');
                    break;
                case 39:
                    /* Press right arrow */
                    if( _states.isActiveLayer )    
                        $scope.moveLayer('right');
                    break;
                case 40:
                    /* Press down arrow */
                    if( _states.isActiveLayer )
                        $scope.moveLayer('down');
                    break; 
                case 46:
                    /* Press "delete" → delete layers */
                    $scope.deleteLayers();
                    break;  
                case 86:
                    /* Press "V" → disable draw mode */
                    if( $scope.resource.drawMode.status ) jQuery('.item[data-type="draw"]').triggerHandler('click');    
                    break;
                case 66:
                    /* Press "B" → enable draw mode */
                    if( !$scope.resource.drawMode.status ) jQuery('.item[data-type="draw"]').triggerHandler('click');                   
                    break;               
            }
        }
    };  
    $scope.onClickStage = function( $event ){
        /*
         * Deactive all layer if click outer canvas 
         * Hide context menu
         * Store stages
         */        
        if(angular.element($event.target).hasClass('stage')){
            $scope.deactiveAllLayer();
            /* store all stages */    
            if( $scope.settings.nbdesigner_save_latest_design == 'yes' ){
                $scope.saveDesign();
                var json = {config: {}};
                json.config.viewport = $scope.calcViewport();
                json.fonts = $scope.resource.usedFonts;
                json.design = $scope.resource.jsonDesign;
                var pid = NBDESIGNCONFIG['product_id'] + '-' + NBDESIGNCONFIG['variation_id'];
                $scope.localStore.update(pid, json, function(){
                    jQuery('.nbd-toasts').nbToasts();
                });     
            }
        }
        $scope.ctxMenuStyle.visibility = 'hidden';
        $scope.updateApp();
    };    
    $scope.$on('nbd:contextmenu', function(event, e){
        $scope.contextMenu(e);
    });
    $scope.ctxMenuStyle = {
        'top': '17%',
        'left': '33%',
        'visibility': 'hidden'
    };
    $scope.contextMenu = function(e){
        if( $scope.stages[$scope.currentStage].states.isEditing ) return;
        e.preventDefault();
        if($scope.stages[$scope.currentStage].states.isActiveLayer){
            var posX = e.pageX,
                posY = e.pageY;
            var contextEl = angular.element(document.getElementById('nbd-context-menu'))[0],
                height = contextEl.clientHeight,
                width = contextEl.clientWidth; 
            if($scope.workBenchWidth < (posX + width + 15)) posX = $scope.workBenchWidth - width - 15;
            if($scope.workBenchHeight < (posY + height + 15)) posY = $scope.workBenchHeight - height - 15;       
            $scope.ctxMenuStyle = {
                'visibility': 'visible',
                top: posY,
                left: posX
            }
        }else{
            $scope.ctxMenuStyle = {
                'visibility': 'hidden',
                'pointer-events': 'none'
            };
        }
        $scope.updateApp();
    }; 
    $scope.preventLoadDesign = false;
    $scope.globalPicker = {
        color: NBDESIGNCONFIG.nbdesigner_default_color,
        attr: 'text.stroke',
        active: false
    };
    $scope.selectGlobalPicker = function(color){
        $scope.globalPicker.color = color;
        var attr_arr = $scope.globalPicker.attr.split(".");
        if( attr_arr.length == 2 && attr_arr[0] == 'text' ){
            $scope.setTextAttribute(attr_arr[1], $scope.globalPicker.color);
        }
        jQuery('#nbd-global-color-palette').removeClass('show');
    };
    $scope.$on('nbd:picker', function(event, attr, color){
        $scope.globalPicker.attr = attr;
        $scope.globalPicker.color = color;
    });
    $scope.$on('canvas:created', function(event, id, last){
        /* init canvas parameters */
        $scope.initStageSetting( id );
        var _canvas = $scope.stages[id].canvas;
        if(!checkMobileDevice()){
            jQuery('#stage-container-'+id).perfectScrollbar();
            jQuery('#stage-container-'+id).on('drop', function(event){
                $scope.onDrop(event);
            });            
        }
        /* Listen canvas events */
        _canvas.on('mouse:down', function(options) {
            $scope.onMouseDown(id, options);
        });
        _canvas.on("mouse:over", function(options){
            $scope.onMouseOverStage(id, options);
        });
        _canvas.on("mouse:out", function(options){
            $scope.onMouseOutStage(id, options);
        });
        _canvas.on("mouse:move", function(options){
            $scope.onMouseMoveStage(id, options);
        });        
        _canvas.on("mouse:up", function(options){
            $scope.onMouseUpStage(id, options);
        });
        _canvas.on("path:created", function(options){
            $scope.onPathCreated(id, options);
        });
        _canvas.on("object:added", function(options){
            $scope.onObjectAdded(id, options);
        });
        _canvas.on("selection:created", function(options){
            $scope.onSelectionCreated(id, options);
        });
        _canvas.on("object:scaling", function(options){
            $scope.onObjectScaling(id, options);
        });
        _canvas.on("object:moving", function(options){
            $scope.onObjectMoving(id, options);
        });
        _canvas.on("object:rotating", function(options){
            $scope.onObjectRotating(id, options);
        });
        _canvas.on("object:modified", function(options){
            $scope.onObjectModified(id, options);
        });
        _canvas.on("before:render", function(options){
            $scope.onBeforeRender(id, options);
        });
        _canvas.on("after:render", function(options){
            $scope.onAfterRender(id, options);
        });
        _canvas.on("selection:cleared", function(options){
            $scope.onSelectionCleared(id, options);
        });
        _canvas.on("text:editing:entered", function(options){
            $scope.onEditingEntered(id, options);
        });   
        _canvas.on("text:editing:exited", function(options){
            $scope.onEditingExited(id, options);
        });        
        _canvas.on("text:changed", function(options){
            $scope.onTextChanged(id, options);
        });         
        _canvas.on("selection:updated", function(options){
            $scope.onSelectionUpdated(id, options);
        });        
        _canvas.on("text:selection:changed", function(options){
            $scope.onSelectionChanged(id, options);
        });
        _canvas.on("mouse:dblclick", function(options){
            $scope.onDblclick(options);
        });
        /* Load template after render canvas */
        if( last == '1' ){
            appConfig.ready = true;
            if( $scope.preventLoadDesign ){
                $scope.preventLoadDesign = false;
                return;
            }
            $scope.loadTemplateAfterRenderCanvas();
        }
    });
    $scope.loadTemplateAfterRenderCanvas = function(){
        if( $scope.forceInitStage ){
            $scope.initStagesSettingWithoutTemplate();
            $scope.forceInitStage = false;
            return;
        }
        if( !$scope.isTemplateMode || ($scope.isTemplateMode && $scope.settings.task == 'edit') ){
            $timeout(function(){
                function loadTemplate(){
                    if( angular.isDefined($scope.settings.product_data.design) ){
                        var config = angular.isDefined($scope.settings.product_data.config_ref) ? $scope.settings.product_data.config_ref : $scope.settings.product_data.config;
                        var viewport = config.viewport;
                        if( angular.isUndefined( config.viewport ) && angular.isDefined( config.scale ) ){
                            viewport = {width: config.scale * 500, height: config.scale * 500};
                        }
                        $scope.insertTemplate(true, {fonts: $scope.settings.product_data.fonts, design: $scope.settings.product_data.design, viewport: viewport});
                    }else{
                        if( NBDESIGNCONFIG.product_data.option.admindesign == "1" && $scope.resource.templates.length == 0 && NBDESIGNCONFIG.product_data.option.global_template_cat != "" ){
                            var interval = setInterval(function () {
                                if ($scope.globalTemplateLoaded) {
                                    if( $scope.resource.globalTemplate.data.length > 0 ){
                                        $scope.insertGlobalTemplate($scope.resource.globalTemplate.data[0].id);
                                    }else{
                                        $scope.initStagesSettingWithoutTemplate();
                                    };
                                    clearInterval(interval);
                                }
                            }, 100);
                        }else{
                            $scope.initStagesSettingWithoutTemplate();
                        }
                    }             
                }
                function loadLocalDesign(){
                    var pid = NBDESIGNCONFIG['product_id'] + '-' + NBDESIGNCONFIG['variation_id'];
                    if( $scope.settings.nbdesigner_save_latest_design == 'yes' ){
                        if($scope.localStore.ready){
                            $scope.localStore.get(pid, function(data){
                                if(data){
                                    $scope.insertTemplate(true, {fonts: data.data.fonts, design: data.data.design, viewport: data.data.config.viewport});
                                }else{
                                    loadTemplate();
                                }
                            });  
                        }else{
                            loadTemplate();
                        }                   
                    }else{
                        loadTemplate();
                    }                        
                }
                if( angular.isDefined($scope.settings.product_data.is_reference) ){
                    loadTemplate();
                    return;
                };
                if( angular.isDefined($scope.settings.product_data.is_template) || $scope.settings.task == 'create_template' ){
                    loadLocalDesign();
                }else{
                    loadTemplate();
                }               
            });
        }else{
            $scope.initStagesSettingWithoutTemplate();
        }
    };
    $scope.theFirstCalcViewport = true;
    $scope.calcViewport = function(){
        var _offsetWidth = checkMobileDevice() ? 20 : 100,
            _offsetHeight = checkMobileDevice() ? 70 : 100,
            _width = jQuery('.nbd-stages').width() - _offsetWidth,
            _height = jQuery('.nbd-stages').height() - _offsetHeight;     
        if(navigator.userAgent.indexOf("Safari")!=-1 && navigator.userAgent.indexOf("CriOS") ==-1 && $scope.theFirstCalcViewport){
            if( checkMobileDevice() ) _height -= 50;
        }
        $scope.theFirstCalcViewport = false;
        return {width: _width, height: _height};
    };
    $scope.reCalcViewPort = function(){

    };
    $scope.calcStyle = function(value){
        return value + 'px';
    };
    $scope.processProductSettings = function(){
        var unitRatio = $scope.settings.nbdesigner_dimensions_unit == 'mm' ? 0.1 : ($scope.settings.nbdesigner_dimensions_unit == 'in' ? 2.54 : 1);
        $scope.rateConvert2Px = $scope.rateConvertCm2Px96dpi * unitRatio * parseFloat($scope.settings.product_data.option.dpi) / 96;
        var viewPort = $scope.calcViewport();
        var scaleRange = [0.1, 0.25, 0.3, 0.5, 0.75, 1, 1.25, 1.5, 1.75, 2, 3, 4, 5], 
            maxSize = checkMobileDevice() ? 1000 : 5000;
        $scope.stages = [];
        _.each($scope.settings.product_data.product, function(side, index){
            var _width = side.product_width * $scope.rateConvert2Px,
                _height = side.product_height * $scope.rateConvert2Px,
                designViewPort = $scope.fitRectangle(viewPort.width, viewPort.height, _width, _height, true),
                fillScale = _width / designViewPort.width,
                //minScale = 200 / Math.max(_width, _height),
                minScale = 200 / Math.max(designViewPort.width, designViewPort.height),
                //maxScale = maxSize / Math.max(_width, _height),
                maxScale = maxSize / Math.max(designViewPort.width, designViewPort.height),
                screenViewPort = $scope.fitRectangle(screen.width, screen.height, _width, _height, true),
                fullScreenScale = screenViewPort.width / designViewPort.width;
            var _scaleRange = scaleRange.filter(function(item){
                return item >= minScale && item <= maxScale;
            });
            $scope.stages[index] = {
                config: {
                    _width: _width,
                    _height: _height,
                    name: side.orientation_name,
                    width: designViewPort.width * side.real_width / side.product_width,
                    height: designViewPort.width * side.real_height / side.product_width,
                    top: designViewPort.width * side.real_top / side.product_width,
                    left: designViewPort.width * side.real_left / side.product_width,
                    cwidth: designViewPort.width,
                    cheight: designViewPort.height,
                    bleed_lr: designViewPort.width * side.bleed_left_right / side.real_width,
                    bleed_tb: designViewPort.width * side.bleed_top_bottom / side.real_width,
                    margin_lr: designViewPort.width * side.margin_left_right / side.real_width,
                    margin_tb: designViewPort.width * side.margin_top_bottom / side.real_width,
                    bgType: side.bg_type,
                    bgColor: side.bg_color_value,
                    bgImage: side.img_src,
                    showBleed: side.show_bleed,
                    showOverlay: side.show_overlay,
                    showSafeZone: side.show_safe_zone,
                    area_design_type: side.area_design_type,
                    show_overlay: side.show_overlay,
                    img_overlay: side.img_overlay
                },
                states: {},
                undos: [],
                redos: [],
                layers: [],
                canvas: {}
            };
            var _state = $scope.stages[index].states;
            angular.copy($scope.defaultStageStates, _state);
            var factor = $scope.settings.nbdesigner_dimensions_unit == 'mm' ? 645.16 : ($scope.settings.nbdesigner_dimensions_unit == 'in' ? 1 :  6.4516);
            _state.ratioConvertFont = designViewPort.width / (side.product_width / unitRatio * 2.54 * 72) * factor;
            _scaleRange.forEach(function(value){
                value != 1 && _state.scaleRange.push({ratio: value, value: (value * 100).toFixed() + '%', label: (value * 100).toFixed() + '%'});
            });
            _state.scaleRange.push({ratio: 1, value: '100%', label: 'Fit'});
            _state.scaleRange.push({ratio: fullScreenScale, value: (fullScreenScale * 100).toFixed() + '%', label: (fullScreenScale * 100).toFixed() + '%'});
            if( fillScale >= minScale && fillScale <= maxScale  ) _state.scaleRange.push({ratio: fillScale, value: (fillScale * 100).toFixed() + '%', label: 'Fill'});
            _state.scaleRange = _.sortBy(_state.scaleRange, [function(o) { return o.ratio; }]);
            _state.currentScaleIndex = _.findIndex(_state.scaleRange, function(o) { return o.ratio == 1; });
            _state.fitScaleIndex = _.findIndex(_state.scaleRange, function(o) { return o.label == 'Fit'; });
            _state.fillScaleIndex = _.findIndex(_state.scaleRange, function(o) { return o.label == 'Fill'; });
            _state.fullScreenScaleIndex = _.findIndex(_state.scaleRange, function(o) { return o.ratio == fullScreenScale; });
        });   
        if( $scope.settings.task == 'typography' || $scope.settings.task == 'create_template' ){
            $scope.stages = [{
                    config: {},
                    states: {
                        scaleRange: [{ratio: 1, value: '100%', label: 'Fit'}, {ratio: 2, value: '200%', label: '200%'}, {ratio: 3, value: '300%', label: '300%'}],
                        currentScaleIndex: 0,
                        fitScaleIndex: 0,
                        fillScaleIndex: 0
                    },
                    undos: [],
                    redos: [],
                    layers: [],
                    canvas: {}
                }
            ]; 
            $scope.stages[0].states.ratioConvertFont = 1;
            if( $scope.settings.task == 'create_template' ) 
                $scope.stages[0].states.scaleRange = [{ratio: 1, value: '100%', label: 'Fit'}, {ratio: 2, value: '200%', label: '200%'}, {ratio: 3, value: '300%', label: '300%'}, {ratio: 4, value: '400%', label: '400%'}, {ratio: 5, value: '500%', label: '500%'}]
            angular.copy($scope.defaultConfig, $scope.stages[0].config);
            angular.merge($scope.stages[0].states, $scope.defaultStageStates);
        };
    };
    $scope.initStageSetting = function( id ){
        $scope.setStageDimension(id);
        $scope.renderStage(id);
        $scope.updateApp();
    };
    $scope.initStagesSettingWithoutTemplate = function(){
        _.each($scope.stages, function(stage, index){
            var _canvas = stage.canvas;
            if( stage.config.bgType == 'color' ){
                _canvas.backgroundColor = stage.config.bgColor;
            }
            if( stage.config.area_design_type == "2" ){
                $scope.contextAddLayers = 'template';
                var width = _canvas.width,
                height = _canvas.height,
                path = new fabric.Path("M0 0 H"+width+" V"+height+" H0z M "+width/2+" 0 A "+width/2+" "+height/2+", 0, 1, 0, "+width/2+" "+height+" A "+width/2+" "+height/2+", 0, 1, 0, "+width/2+" 0z");
                path.set({strokeWidth: 0, isAlwaysOnTop: true, fill: '#ffffff', selectable: false, evented: false});
                _canvas.add(path);                  
            }
            _canvas.requestRenderAll();
        });
        $scope.onLoadPrintingOptions = false;
    };
    $scope.addStage = function(){
        var new_stage = {};
        angular.copy($scope.stages[$scope.currentStage], new_stage);
        $scope.stages.splice($scope.currentStage + 1, 0, new_stage);
        $scope.preventLoadDesign = true;
        $scope.updateApp();
        $timeout(function(){
            $scope.switchStage($scope.currentStage, 'next');
        });
    }; 
    $scope.resetStage = function(){
        var new_stage = {};              
        angular.copy($scope.stages[0], new_stage);
        $scope.stages = [];
        $scope.stages.push(new_stage);
        $scope.currentStage = 0;
        $scope.preventLoadDesign = true;        
    };
    $scope.setStageDimension = function(id){
        id = angular.isDefined(id) ? id : $scope.currentStage;
        var _stage = $scope.stages[id];
        var currentWidth = Math.ceil(_stage.config.width * _stage.states.scaleRange[_stage.states.currentScaleIndex].ratio),
            currentHeight = Math.ceil(_stage.config.height * _stage.states.scaleRange[_stage.states.currentScaleIndex].ratio);
        $scope.stages[id]['canvas'].setDimensions({'width' : currentWidth, 'height' : currentHeight});
    };
    $scope.switchStage = function(id, command){
        var idCurrentStage = 'stage-container-' + id,
            next =  parseInt(id) + 1;   
        if(command == 'prev')  {
            next  = parseInt(id) - 1;
        };
        jQuery('.nbd-stages .ps__scrollbar-x-rail, .nbd-stages .ps__scrollbar-y-rail').addClass('nbd-hiden');
        $timeout(function(){
            jQuery('.nbd-stages .ps__scrollbar-x-rail, .nbd-stages .ps__scrollbar-y-rail').removeClass('nbd-hiden');
        }, 700);
        if(appConfig.isModern){            
            var idNextStage = 'stage-container-' + next;
            var currentStage = angular.element(document.getElementById(idCurrentStage)),
            nextStage = angular.element(document.getElementById(idNextStage));
            currentStage.addClass('animated');    
            currentStage.removeClass('fadeInUp');
            currentStage.removeClass('fadeInDown');  
            nextStage.addClass('animated');
            nextStage.removeClass('hidden');            
            nextStage.removeClass('fadeOutDown');            
            nextStage.removeClass('fadeOutUp');            
            if(command == 'prev'){
                currentStage.removeClass('fadeOutDown');
                currentStage.addClass('fadeOutUp');
                nextStage.addClass('fadeInDown');                 
            }else {
                currentStage.removeClass('fadeOutUp');
                currentStage.addClass('fadeOutDown');    
                nextStage.addClass('fadeInUp');                 
            }; 
        }
        $scope.currentStage = next;
        $scope.renderStage();
        $scope.updateLayersList();
    };
    $scope.onDrop = function(event){
        event.preventDefault();
        var src = event.originalEvent.dataTransfer.getData("src"),
        extenal = event.originalEvent.dataTransfer.getData("extenal"),
        type = event.originalEvent.dataTransfer.getData("type");
        switch(type){
            case 'image':
                if(extenal == 'true'){
                    $scope.addImageFromUrl(src, true);
                }else{
                    $scope.addImageFromUrl(src, false);
                };
                break;
            case 'svg':   
                $scope.addImageFromUrl(src, false);
                break;
            case 'typo':   
                $scope.insertTypography({folder: src});
                break;                
        };
    };
    $scope.onMouseDown = function(id, options){
        //angular.merge($scope.stages[$scope.currentStage].states.boundingObject, {visibility: 'hidden'}); 
        $scope.updateApp();
    };
    $scope.onDblclick = function(options){
        var item = options.target;
        if( item && item.type === 'activeSelection' ){
            $scope.deactiveAllLayer()
        }
    };    
    $scope.onMouseOverStage = function(id, options){
        var item = options.target;
        $scope.updateBoundingRect(item);
        $scope.updateApp();
    };   
    $scope.onMouseOutStage = function(id, options){
        if(options.target){  
            angular.merge($scope.stages[$scope.currentStage].states.boundingObject, {visibility: 'hidden'}); 
        }       
        $scope.updateApp();
    }; 
    $scope.onMouseMoveStage = function(id, options){
        //todo
    };   
    $scope.onMouseUpStage = function(id, options){
        var _stage = $scope.stages[$scope.currentStage];
        /*
         * Hide bounding rect, coordinates label, snap lines, rotate label
         */
        angular.merge(_stage.states.boundingObject, {visibility: 'hidden'});
        angular.merge(_stage.states.coordinates, {style: {visibility: 'hidden'}}); 
        var position = {
            ht: {top: -9999},
            hb: {top: -9999},
            hc: {top: -9999},
            vl: {left: -9999},
            vr: {left: -9999},
            vc: {left: -9999},
            hcc: {top: -9999},
            vcc: {left: -9999},
            vel: {left: -9999},
            ver: {left: -9999},
            het: {top: -9999},
            heb: {top: -9999}
        };        
        angular.merge(_stage.states.snaplines, position);
        angular.merge(_stage.states.rotate, {style: {visibility: 'hidden'}});       
        /* get layer parameters before modify */
        var _canvas = _stage.canvas,
            objects =  _canvas.getActiveObjects();  
        _stage.tempParameters = null;
        if( objects.length == 1 ){
            _stage.tempParameters = JSON.stringify(objects[0].toJSON());
        }
        /* Delete layer if out of stage fully */
        if( options.target ){
            if(!options.target.isOnScreen()) $scope.deleteLayers();
        }        
        $scope.updateApp(); 
    };  
    $scope.beforeObjectModify = function( item ){
        $scope.setHistory({
            element: item,
            parameters: JSON.stringify(item.toJSON()),
            interaction: 'modify'
        });
    };
    $scope.onPathCreated = function(id, options){
        //todo
    };   
    $scope.onObjectAdded = function(id, options){
        var _stage = $scope.stages[$scope.currentStage],
        _canvas = _stage['canvas'],
        item = options.target,   
        d = new Date(),
        itemId = d.getTime() + Math.floor(Math.random() * 1000);
        if( $scope.contextAddLayers == 'normal' || $scope.contextAddLayers == 'copy' || $scope.contextAddLayers == 'template' ){
            if( angular.isUndefined( item.get('itemId') ) ){
                item.set({"itemId" : itemId});
            }
        };
        if( $scope.contextAddLayers == 'normal' && !$scope.resource.drawMode.status ){
            _canvas.viewportCenterObject(item);
            $scope.toggleTip();
        }
        var type = item.get('type');
        if( $scope.resource.upload.ilr ){
            item.set({ilr: true});
            $scope.resource.upload.ilr = false;
        }
        if(type == 'i-text' || type == 'textbox' || type == 'text' || type == 'curvedText') item.initDimensions();
        item.setCoords();
        if( (['normal', 'copy', 'undo', 'redo'].indexOf($scope.contextAddLayers) > -1) && _stage.config.area_design_type == "2" )  $scope.setStackLayerAlwaysOnTop();
        var top = item.get('top'),
            left = item.get('left');
        if( $scope.contextAddLayers == 'normal' && !$scope.resource.drawMode.status ){
            item.set({top: top - 50});
            item.animate('top', top, {
                duration: 400,
                onChange: function(){
                    $scope.renderStage();
                },
                onComplete: function(){
                    _canvas.setActiveObject(item); 
                    $scope.setHistory({
                        element: item,
                        parameters: JSON.stringify(item.toJSON()),
                        interaction: 'add'
                    });   
                    $scope.stages[$scope.currentStage].tempParameters = JSON.stringify(item.toJSON());   
                    if(type == 'i-text' || type == 'textbox'){
                        item.selectAll();
                        item.enterEditing();
                    }
                    $scope.renderStage();       
                },
                easing: FabricWindow.util.ease['easeInQuad']
            });  
            $scope.stages[$scope.currentStage].states.isActiveLayer = true;
        }else if( $scope.contextAddLayers == 'copy' ){
            item.set({top: top - 20, left: left - 20});
            item.animate({'top': top, 'left': left}, {
                duration: 400,
                onChange: function(){
                    $scope.renderStage();
                },
                onComplete: function(){
                    $scope.setHistory({
                        element: item,
                        parameters: JSON.stringify(item.toJSON()),
                        interaction: 'add'
                    });   
                    $scope.stages[$scope.currentStage].tempParameters = JSON.stringify(item.toJSON());                    
                    $scope.renderStage();       
                },
                easing: FabricWindow.util.ease['easeInQuad']
            });             
        }else{
            $scope.renderStage();
        };
        if(!$scope.onloadTemplate){
            if($scope.onUnloadGroup.status){
                if( angular.isDefined($scope.onUnloadGroup.prevIndex) ){
                    item.moveTo( parseInt( $scope.onUnloadGroup.prevIndex ) + $scope.onUnloadGroup.length - $scope.onUnloadGroup.remain );
                }                
                if( $scope.onUnloadGroup.remain > 1 ){
                    $scope.onUnloadGroup.remain -= 1;
                }else{
                    $scope.onUnloadGroup = {
                        status: false,
                        remain: 0
                    };  
                    $scope.contextAddLayers = 'normal';
                }
            }else{
                $scope.contextAddLayers = 'normal';
            }
        }
        if( $scope.contextAddLayers == 'normal' && !$scope.resource.drawMode.status ){
            $scope.showDesignTab();
        }
        $scope.updateLayersList();
    };
    $scope.showDesignTab = function(){
        if( checkMobileDevice() ){
            jQuery('#design-tab').triggerHandler('click');
        };    
    };
    $scope.onObjectScaling = function(id, options){
        var item = options.target; 
        $scope.updateAssociateLayer(item);
    };    
    $scope.onObjectMoving = function(id, options){
        var item = options.target; 
        $scope.updateAssociateLayer(item); 
    }; 
    $scope.onObjectRotating = function(id, options){
        var item = options.target;
        $scope.updateAssociateLayer(item);
        $scope.updateAngleLabel(item);
    };   
    $scope.updateAssociateLayer = function(item){
        if(item){ 
            item.setCoords();
            $scope.updateCoordenatesLabel(item);
            $scope.updateBoundingRect(item);
            $scope.updateSnapLines();
            $scope.updateUploadZone(item);
            $scope.updateApp();     
        }
    };
    $scope.updateUploadZone = function(item){
        var type = item.get('type'),
        elementUpload = item.get('elementUpload');
        if( (type == 'image' || type == 'custom-image' ) && elementUpload  ){
            angular.merge($scope.stages[$scope.currentStage].states.uploadZone, {
                visibility: 'visible',
                top: item.oCoords.tl.y - 1,
                left: item.oCoords.tl.x - 1,
                width: Math.sqrt(Math.pow(item.oCoords.tl.x - item.oCoords.tr.x, 2) + Math.pow(item.oCoords.tl.y - item.oCoords.tr.y, 2 )) + 2,
                height: Math.sqrt(Math.pow(item.oCoords.tl.x - item.oCoords.bl.x, 2) + Math.pow(item.oCoords.tl.y - item.oCoords.bl.y, 2 )) + 2,
                transform: "rotate("+item.angle+"deg)"                
            });
        }else{
            angular.merge($scope.stages[$scope.currentStage].states.uploadZone, {visibility: 'hidden'}); 
        }
    };
    $scope.updateAngleLabel = function( item ){
        if(item){
            angular.merge($scope.stages[$scope.currentStage].states.rotate, {
                style: {
                    transform: "rotate("+item.angle+"deg)",
                    top: item.oCoords.mtr.y,
                    left: item.oCoords.mtr.x,
                    visibility: 'visible'                    
                },
                angle: fabric.util.toFixed(item.angle, 0)
            });
        }else{
            angular.merge($scope.stages[$scope.currentStage].states.rotate, {style: {visibility: 'hidden'}});   
        }
    };
    $scope.updateCoordenatesLabel = function(item){
        if(item){
            var bound = item.getBoundingRect();
            var top = item.oCoords.tl.y,
                left = item.oCoords.tl.x;
            if( (item.angle > 315 && item.angle < 360) || (item.angle > 45 && item.angle < 90) 
                    || (item.angle > 135 && item.angle < 180) || (item.angle > 225 && item.angle < 270) ){
                if( item.oCoords.tr.x < left ){
                    top = item.oCoords.tr.y;
                    left = item.oCoords.tr.x;
                }
                if( item.oCoords.br.x < left ){
                    top = item.oCoords.br.y;
                    left = item.oCoords.br.x;
                }   
                if( item.oCoords.bl.x < left ){
                    top = item.oCoords.bl.y;
                    left = item.oCoords.bl.x;
                }            
            }else{
                if( item.oCoords.tr.y < top ){
                    top = item.oCoords.tr.y;
                    left = item.oCoords.tr.x;
                }
                if( item.oCoords.br.y < top ){
                    top = item.oCoords.br.y;
                    left = item.oCoords.br.x;
                }   
                if( item.oCoords.bl.y < top ){
                    top = item.oCoords.bl.y;
                    left = item.oCoords.bl.x;
                }
            }
            angular.merge($scope.stages[$scope.currentStage].states.coordinates, {      
                style: {
                    visibility: 'visible',
                    top: top,
                    left: left                        
                },
                //todo something to recalculate real top, left
                top: parseInt(top),
                left: parseInt(left)
            });  
        }
    };
    $scope.updateBoundingRect = function(item){
        if(item){
            var bound = item.getBoundingRect();
            angular.merge($scope.stages[$scope.currentStage].states.boundingObject, {
                visibility: 'visible',
                top: item.oCoords.tl.y - 1,
                left: item.oCoords.tl.x - 1,
                width: Math.sqrt(Math.pow(item.oCoords.tl.x - item.oCoords.tr.x, 2) + Math.pow(item.oCoords.tl.y - item.oCoords.tr.y, 2 )) + 2,
                height: Math.sqrt(Math.pow(item.oCoords.tl.x - item.oCoords.bl.x, 2) + Math.pow(item.oCoords.tl.y - item.oCoords.bl.y, 2 )) + 2,
                transform: "rotate("+item.angle+"deg)"
            });
        }else{
            angular.merge($scope.stages[$scope.currentStage].states.boundingObject, {visibility: 'hidden'});   
            angular.merge($scope.stages[$scope.currentStage].states.coordinates, {visibility: 'hidden'});   
        }
    };
    $scope.updateSnapLines = function(){
        var _canvas = this.stages[$scope.currentStage]['canvas'],
            item = _canvas.getActiveObject(),
            position = {
                ht: {top: -9999},
                hb: {top: -9999},
                hc: {top: -9999},
                vl: {left: -9999},
                vr: {left: -9999},
                vc: {left: -9999},
                hcc: {top: -9999},
                vcc: {left: -9999},
                vel: {left: -9999},
                ver: {left: -9999},
                het: {top: -9999},
                heb: {top: -9999}                
            };
        if( item ){
            var bound = item.getBoundingRect();
            _canvas.forEachObject(function(obj) {
                if( obj === item ) return;
                var _bound = obj.getBoundingRect();
                if(Math.abs(bound.left - _bound.left) < 1)  position.vl.left = _bound.left;
                if(Math.abs(bound.left + bound.width - _bound.left) < 1) position.vr.left = _bound.left;
                if(Math.abs(bound.left - _bound.left - _bound.width) < 1)  position.vl.left = _bound.left + _bound.width;
                if(Math.abs(bound.top - _bound.top) < 1)  position.ht.top = _bound.top;
                if(Math.abs(bound.top + bound.height - _bound.top) < 1) position.ht.top = _bound.top;
                if(Math.abs(bound.top - _bound.top - _bound.height) < 1)  position.hb.top = _bound.top + _bound.height;
                if(Math.abs(bound.left + bound.width - _bound.left - _bound.width) < 1)  position.vr.left = _bound.left + _bound.width;
                if(Math.abs(bound.top + bound.height - _bound.top - _bound.height) < 1)  position.hb.top = _bound.top + _bound.height;
                if(Math.abs(bound.left + bound.width / 2 - _bound.left - _bound.width / 2) < 1) position.vc.left = _bound.left + _bound.width / 2;
                if(Math.abs(bound.top + bound.height / 2 - _bound.top - _bound.height / 2) < 1) position.hc.top = _bound.top + _bound.height / 2;  
            });
            if(Math.abs(bound.left + bound.width / 2 - _canvas.width / 2) < 1)  position.vcc.left = _canvas.width / 2;
            if(Math.abs(bound.top + bound.height / 2 - _canvas.height / 2) < 1)  position.hcc.top = _canvas.height / 2;
            
            if(Math.abs(bound.left) < 1)  position.vel.left = 0;
            if(Math.abs(bound.top) < 1)  position.het.top = 0;
            if(Math.abs(bound.left + bound.width - _canvas.width) < 1)  position.ver.left = _canvas.width;
            if(Math.abs(bound.top + bound.height - _canvas.height) < 1)  position.heb.top = _canvas.height;
            
            angular.merge($scope.stages[$scope.currentStage].states.snaplines, position);
        }
    };
    $scope.updateWarning = function(item){
        if($scope.settings.showWarning.oos){
            var stage = $scope.stages[$scope.currentStage];
            var _canvas = stage['canvas'],
            bound = item.getBoundingRect();
            if( bound.left < 0 || bound.top < 0 || (bound.left + bound.width) > (_canvas.width)|| (bound.top + bound.height) > (_canvas.height)  ){
                stage.states.oos = true;
            }else{
                stage.states.oos = false;
            }
            $scope.updateApp();
        }
    };
    $scope.onObjectModified = function(id, options){
        var item = options.target;
        var newAngle = item.angle;
        newAngle = (Math.abs(item.angle - 0) <= 1 || Math.abs(item.angle - 360) <= 1 ) ? 0 : ( Math.abs(item.angle - 180) <= 1 ? 180 : newAngle );
        item.set({angle: newAngle, dirty: true});    
        if( $scope.stages[$scope.currentStage].tempParameters ){
            $scope.setHistory({
                element: item,
                parameters: $scope.stages[$scope.currentStage].tempParameters,
                interaction: 'modify'
            });
            $scope.stages[$scope.currentStage].tempParameters = null;
        }
        if( $scope.stages[$scope.currentStage].states.isText && NBDESIGNCONFIG.nbdesigner_enable_text_free_transform == 'no'){
            var newFontSize = item.fontSize * item.scaleX;
            var newPtFontSize = newFontSize / $scope.stages[$scope.currentStage].states.ratioConvertFont;
            newPtFontSize = newPtFontSize.toFixed(2);
            item.set({
                dirty: true,
                scaleX: 1,
                scaleY: 1,
                fontSize: newFontSize,
                ptFontSize: newPtFontSize
            });
            $scope.stages[$scope.currentStage].states.text.fontSize = newFontSize;
            $scope.stages[$scope.currentStage].states.text.ptFontSize = newPtFontSize;
        }
        $scope.updateWarning(item);
    };    
    $scope.onBeforeRender = function(id, options){
        //todo
    };      
    $scope.onAfterRender = function(id, options){
        //todo
    };    
    $scope.onSelectionCleared = function(id, options){
        $scope.stages[$scope.currentStage].states.isActiveLayer = false;
        $scope.stages[$scope.currentStage].states.itemId = null;
        $scope.stages[$scope.currentStage].states.isEditing = false;
        angular.merge($scope.stages[$scope.currentStage].states.uploadZone, {visibility: 'hidden'});
        $scope.stages[$scope.currentStage].states.elementUpload = false;
        $scope.stages[$scope.currentStage].states.oos = false;
        $scope.stages[$scope.currentStage].states.ilr = false;
    };     
    $scope.onEditingEntered = function(id, options){
        $scope.stages[$scope.currentStage].states.isEditing = true;     
        $scope.updateApp();
    };    
    $scope.onEditingExited = function(id, options){
        $scope.stages[$scope.currentStage].states.isEditing = false;
        var item = options.target;
        if( item ){
            $scope.updateLayersList();
        }
        $scope.updateApp();
    };    
    $scope.onSelectionChanged = function(id, options){
        $scope.getCurrentLayerInfo();
        $scope.updateUploadZone(options.target);
        $scope.updateWarning(options.target);
        if( $scope.stages[$scope.currentStage].states.isGroup ){
            $scope.stages[$scope.currentStage].states.ilr = false;
        }
        $scope.scrollToSelectedLayer();
    }; 
    $scope.onSelectionUpdated = function(id, options){
        $scope.getCurrentLayerInfo();
        $scope.updateUploadZone(options.target);
        $scope.updateWarning(options.target);
        if( $scope.stages[$scope.currentStage].states.isGroup ){
            $scope.stages[$scope.currentStage].states.ilr = false;
        }  
        $scope.scrollToSelectedLayer();
    };
    $scope.onSelectionCreated = function(id, options){
        $scope.getCurrentLayerInfo();
        $scope.updateUploadZone(options.target);
        $scope.updateWarning(options.target);
        $scope.toggleTip();
        $scope.scrollToSelectedLayer();
    }; 
    $scope.scrollToSelectedLayer = function(){
//        if( $scope.stages[$scope.currentStage].states.isLayer ){
//            jQuery('#tab-layer .tab-scroll').stop().animate({
//                scrollTop: jQuery('.menu-layer li[data-id="'+$scope.stages[$scope.currentStage].states.itemId+'"]').position().top
//            }, 100);
//        }
    };
    $scope.onTextChanged = function(id, options){
        var item = options.target;
        if( item ){
            $scope.updateLayersList();
//            if( item.get('fixedWidth') ){
//                var largest  = item.getLineWidth(0);
//                _.each(item.__lineWidths, function(line, index){
//                    var _width = item.getLineWidth(index);
//                    if( largest < _width ) largest = _width;
//                });
//                var largest  = item.getBoundingRect().width;
//                if (largest > item._fixedWidth) {
//                    var fontSize = item.get('fontSize');
//                    item.set({
//                        dirty: true,
//                        fontSize: fontSize * item._fixedWidth / (largest  + 1)
//                    });
//                }else{
//                    item.set({
//                        dirty: true,
//                        fontSize: item.get('_fixedFontSize')
//                    });                    
//                }
//                $scope.renderStage();
//            }
        }
        angular.merge($scope.stages[$scope.currentStage].states.boundingObject, {visibility: 'hidden'});   
        $scope.updateApp();
    };
    $scope.getCurrentLayerInfo = function(){
        var _canvas = $scope.stages[$scope.currentStage]['canvas'],
        object = _canvas.getActiveObject(),
        objects = _canvas.getActiveObjects();
        
        $scope.stages[$scope.currentStage].states.isActiveLayer = true;
        $scope.stages[$scope.currentStage].states.isGroup = false;
        $scope.stages[$scope.currentStage].states.isNativeGroup = false;
        $scope.stages[$scope.currentStage].states.isLayer = false;
        $scope.stages[$scope.currentStage].states.isText = false;
        $scope.stages[$scope.currentStage].states.isImage = false;      
        $scope.stages[$scope.currentStage].states.isPath = false;      
        $scope.stages[$scope.currentStage].states.isShape = false;      
        $scope.stages[$scope.currentStage].states.isEditing = false; 
        $scope.stages[$scope.currentStage].states.elementUpload = false; 
                
        if( objects.length > 1 ){
            $scope.stages[$scope.currentStage].states.isGroup = true;
        }else{
            $scope.stages[$scope.currentStage].states.isLayer = true;
            if( object ){
                if(!object.get('itemId')) {
                    var d = new Date(),
                    itemId = d.getTime() + Math.floor(Math.random() * 1000);
                    object.set({"itemId" : itemId});
                }
                $scope.stages[$scope.currentStage].states.ilr  = angular.isDefined(object.get('ilr')) ? object.get('ilr') : false;
                $scope.stages[$scope.currentStage].states.opacity = fabric.util.toFixed(object.get('opacity') * 100);
                ['type', 'itemId', 'lockMovementX', 'lockMovementY', 'lockScalingX', 'lockScalingY', 'lockRotation', 'lockUniScaling', 'selectable', 'visible', 'angle', 'excludeFromExport'].forEach(function(key){
                    $scope.stages[$scope.currentStage].states[key] = object.get(key);
                });
                switch(object.type) {
                    case 'i-text':
                    case 'text':
                    case 'textbox':
                    case 'curvedText':
                        angular.copy($scope.defaultStageStates.text, $scope.stages[$scope.currentStage].states.text);
                        $scope.addColor(tinycolor(object.get('fill')).toHexString());
                        $scope.stages[$scope.currentStage].states.isText = true;
                        $scope.stages[$scope.currentStage].states.isEditing = object.isEditing ? object.isEditing : false;
                        $scope.stages[$scope.currentStage].states.fixedWidth = angular.isDefined(object.fixedWidth) ? object.fixedWidth : false;
                        $scope.stages[$scope.currentStage].states.text = {
                            font: $scope.getFontInfo(object.get('fontFamily')),
                            is_uppercase: $scope.isUpperCase(object)
                        };
                        ['fontFamily', 'ptFontSize', 'fontSize', 'textAlign', 'fontWeight', 'textDecoration', 'fontStyle', 'spacing', 'lineHeight', 'fill', 'charSpacing', 'textBackgroundColor', 'stroke', 'strokeWidth'].forEach(function(key){
                            $scope.stages[$scope.currentStage].states.text[key] = object.get(key);
                        });
                        if( angular.isUndefined($scope.stages[$scope.currentStage].states.text.ptFontSize) ){
                            $scope.stages[$scope.currentStage].states.text.ptFontSize = $scope.stages[$scope.currentStage].states.text.fontSize / $scope.stages[$scope.currentStage].states.ratioConvertFont;
                        }
                        if( $scope.stages[$scope.currentStage].states.text.textBackgroundColor == '' ) $scope.stages[$scope.currentStage].states.text.textBackgroundColor = '#ffffff';
                        if( !$scope.stages[$scope.currentStage].states.text.stroke ) $scope.stages[$scope.currentStage].states.text.stroke = '#ffffff';
                        break;
                    case 'image':
                    case 'custom-image':
                        $scope.stages[$scope.currentStage].states.elementUpload  = angular.isDefined(object.get('elementUpload')) ? object.get('elementUpload') : false;
                        $scope.stages[$scope.currentStage].states.ilr  = angular.isDefined(object.get('ilr')) ? object.get('ilr') : false;
                        $scope.stages[$scope.currentStage].states.isImage = true;
                        break;
                    case 'rect':
                    case 'triangle':
                    case 'line':
                    case 'polygon':                    
                    case 'circle':
                    case 'ellipse':
                        $scope.stages[$scope.currentStage].states.isShape = true;
                        $scope.stages[$scope.currentStage].states.svg.groupPath = $scope.getPathOfSvg(object);
                        break;     
                    case 'path-group':                    
                    case 'path':
                    case 'group':
                        $scope.stages[$scope.currentStage].states.isPath = true;
                        $scope.stages[$scope.currentStage].states.svg.groupPath = $scope.getPathOfSvg(object);
                        if( object.type == 'group' ) $scope.stages[$scope.currentStage].states.isNativeGroup = true;
                        break; 
                    default:
                        //todo
                        break;
                }
            }            
        }        
        $scope.updateApp();
    };
    /* Utility functions */
    $scope.toggleTip = function( close ){
        var first_visitor = getCookie("nbdesigner_user");
        if( angular.isDefined( close ) ){
            close == true ? jQuery('.nbd-tip').removeClass('nbd-show') : jQuery('.nbd-tip').addClass('nbd-show');
        }else{
            if (first_visitor == "") {
                setCookie("nbdesigner_user", 'Hello World', 0.5);
                jQuery('.nbd-tip').addClass('nbd-show');
            }             
        }   
    };
    $scope.startCountTime = function(){
        $scope.startTime = new Date();
    };
    $scope.endCountTime = function(){
        var endTime = new Date();
        console.log((endTime - $scope.startTime) + " ms");        
    };    
    $scope.getFontInfo = function(alias){
        var font = _.filter($scope.resource.font.data, { alias: alias })[0],
            _font = angular.copy(font, _font);
        if(_font){    
            _font.file = {r: 1};
            _font.file.i = angular.isDefined(font.file.i) ? 1 : 0;
            _font.file.b = angular.isDefined(font.file.b) ? 1 : 0;
            _font.file.bi = angular.isDefined(font.file.bi) ? 1 : 0;
        }else{
            _font = {name: 'Roboto', alias: 'Roboto', file: {r: 1, b: 1, i: 1, bi: 1}, cat: ["99"], type:"google",subset:"latin"};
        }
        return _font;
    };
    $scope.getPathOfSvg = function(object){
        var groupPath = [];
        _.each(object._objects, function(path, index){
            if( path.get('fill') != '' ){
                var color = tinycolor(path.get('fill')).toHexString();
                $scope.addColor(color);             
                if(  ( findex = _.findIndex(groupPath, ['color', color]) ) > -1 ){
                    groupPath[findex]['index'].push(index);
                }else{
                    groupPath.push({color: color, index: [index]});
                }
            }
        });
        if(groupPath.length == 0){         
            $scope.addColor(tinycolor(object.get('fill')).toHexString());
            groupPath.push({color: tinycolor(object.get('fill')).toHexString(), index: [-1]});
        }
        return groupPath;
    };  
    $scope.isUpperCase = function( object ){
        var _isUpperCase = angular.isDefined(object.is_uppercase) ? object.is_uppercase : false;
        return _isUpperCase;
    };  
    $scope.fitRectangle = function(x1, y1, x2, y2, fill){
        var rec = {};
        if(x2 < x1 && y2 < y1){
            if(fill){
                if(x1/y1 > x2/y2){
                    rec.width = x2 * y1 / y2;
                    rec.height = y1;
                    rec.top = 0;
                    rec.left = (x1 * y2 - x2 * y1) / y2 / 2;                    
                }else {
                    rec.width = x1;
                    rec.height = x1 * y2 / x2;
                    rec.top = (x2 * y1 - x1 * y2) / x2 / 2;
                    rec.left = 0;                     
                }
            }else {
                rec.top = (x1 - x2) / 2;
                rec.left = (y1 - y2) / 2;
                rec.width = x2;
                rec.height = y2;
            }
        } else if( x1/y1 > x2/y2 ){
            rec.width = x2 * y1 / y2;
            rec.height = y1;
            rec.top = 0;
            rec.left = (x1 * y2 - x2 * y1) / y2 / 2;
        } else {
            rec.width = x1;
            rec.height = x1 * y2 / x2;
            rec.top = (x2 * y1 - x1 * y2) / x2 / 2;
            rec.left = 0;            
        }
        return rec;
    };    
    $scope.insertTemplateFont = function(font_name, callback){
        if(!_.filter($scope.resource.font.data, ['alias', font_name]).length){
            NBDDataFactory.get('nbd_get_resource', {type: 'google_font',font_name: font_name}, function(data){
                data = JSON.parse(data);
                if( data.flag == 1 ){
                    if(!_.filter($scope.resource.font.data, ['alias', font_name]).length){
                        $scope.resource.font.data.push(data.data);
                    };
                    var fontName = data.data.alias;
                    var font_id = fontName.replace(/\s/gi, '').toLowerCase();
                    if( !jQuery('#' + font_id).length ){
                        jQuery('head').append('<link id="' + font_id + '" href="https://fonts.googleapis.com/css?family='+ fontName.replace(/\s/gi, '+') +':400,400i,700,700i" rel="stylesheet" type="text/css">');
                    };
                    var font = new FontFaceObserver(fontName);
                    font.load($scope.settings.subsets[data.data.subset]['preview_text']).then(function () {
                        if( angular.isDefined(callback) ) callback(fontName);
                    }, function () {
                        console.log('Fail to load: '+fontName);
                        if( angular.isDefined(callback) ) callback('Roboto');
                    });
                }else{
                    if( angular.isDefined(callback) ) callback('Roboto');
                }
            });  
        }else{
            var _font = $scope.getFontInfo(font_name);
            var fontName = font_name;
            var font_id = fontName.replace(/\s/gi, '').toLowerCase();
            if( !jQuery('#' + font_id).length ){
                if(_font.type == 'google'){
                    jQuery('head').append('<link id="' + font_id + '" href="https://fonts.googleapis.com/css?family='+ fontName.replace(/\s/gi, '+') +':400,400i,700,700i" rel="stylesheet" type="text/css">');
                }else{
                    var font_url = _font.url;
                    if(! (font_url.indexOf("http") > -1)) font_url = NBDESIGNCONFIG['font_url'] + font_url; 
                    var css = "";
                    css = "<style type='text/css' id='" + font_id + "' >";
                    css += "@font-face {font-family: '" + fontName + "';";
                    css += "src: local('\u263a'),";
                    css += "url('" + font_url + "') format('truetype')";
                    css += "}";
                    css += "</style>";
                    jQuery("head").append(css);                    
                }
            };
            var font = new FontFaceObserver(fontName);
            font.load($scope.settings.subsets[_font.subset]['preview_text']).then(function () {
                if( angular.isDefined(callback) ) callback(fontName);
            }, function () {
                console.log('Fail to load: '+fontName);
                if( angular.isDefined(callback) ) callback(fontName);
            });          
        };
    };
    $scope.onloadTemplate = false;  
    $scope.insertTemplate = function(local, temp){
        if( angular.isUndefined( temp.doNotShowLoading ) ){
            $scope.toggleStageLoading();
            $scope.showDesignTab();
        }
        $scope.onloadTemplate = true;
        $scope.contextAddLayers = 'template';
        function loadDesign(fonts, design, viewport){
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
                                    var layers = _stage.canvas.getObjects();
                                    $scope.renderTextAfterLoadFont(layers, function(){
                                        $scope.deactiveAllLayer();
                                        $scope.renderStage(index);
                                        $timeout(function(){
                                            $scope.deactiveAllLayer();
                                            $scope.renderStage(index);
                                            if( index == $scope.stages.length - 1 ){
                                                $scope.onloadTemplate = false;
                                                $scope.contextAddLayers = 'normal';
                                                if( angular.isDefined(viewport) ){
                                                    $scope.resizeStages(viewport);
                                                }else{
                                                    $scope.toggleStageLoading();  
                                                }
                                                $scope.onLoadPrintingOptions = false;
                                            }
                                        }, 500);         
                                    });                                         
                                });
                            }
                        }
                    };    
                    if( objects.length > 0 ){
                        var item = objects[layerIndex],
                        type = item.type;
                        if( type == 'image' || type == 'custom-image' ){
                            if( appConfig.domainChanged ){
//                                if( item.src.indexOf("https") == -1 ){
//                                    item.src = item.src.replace("http", "https");
//                                }
                                var _src = item.src;
                                var src = _src.split('nbdesigner');
                                item.src = NBDESIGNCONFIG['nbd_content_url'] + src[1];
                            };
                            fabric.Image.fromObject(item, function(_image){
                                _canvas.add(_image);
                                continueLoadLayer();
                            });
                        }else{
                            var klass = fabric.util.getKlass(type);
                            if( ['i-text', 'text', 'textbox', 'curvedText'].indexOf( type ) > -1  ){
                                if(!_.filter(stage.states.usedFonts, ['alias', item.fontFamily]).length){
                                    stage.states.usedFonts.push($scope.getFontInfo(item.fontFamily));
                                };
                            };
                            ['first_name', 'last_name', 'full_name', 'company', 'address', 'postcode', 'city', 'phone', 'email', 'mobile', 'website', 'title'].forEach(function(val){
                                if( angular.isDefined(item[val]) ){
                                    if( angular.isDefined($scope.settings.user_infos) ){
                                        item.text = $scope.settings.user_infos[val].value;
                                    }
                                }
                            });
                            if( angular.isDefined(item.vcard) ){
                                var config = {
                                    left: item.left,
                                    top: item.top,
                                    vcard: 1
                                };
                                $scope.strVcard = '';
                                if( angular.isDefined($scope.settings.user_infos) ){
                                    var infos = $scope.settings.user_infos;
                                    $scope.strVcard += 'BEGIN:VCARD\nVERSION:3.0\n';
                                    $scope.strVcard += 'N:'+infos.last_name.value+';'+infos.first_name.value+'\n'+ 'FN:'+infos.full_name.value;
                                    $scope.strVcard += '\nADR;TYPE=home:;;'+infos.address.value+';'+infos.city.value+';;'+infos.postcode.value+';'+infos.country.value;
                                    $scope.strVcard += '\nTEL;TYPE=home:'+infos.phone.value;
                                    $scope.strVcard += '\nTEL;TYPE=work:'+infos.mobile.value;
                                    $scope.strVcard += '\nEMAIL;TYPE=internet,work:'+infos.email.value;
                                    $scope.strVcard += '\nURL;TYPE=work:'+infos.website.value;
                                    $scope.strVcard += '\nEND:VCARD';
                                    var qr = qrcode('0', 'M');
                                    qr.addData( $scope.strVcard );
                                    qr.make();
                                    var _qrcode = qr.createSvgTag();
                                    fabric.loadSVGFromString(_qrcode, function(ob, op) {		
                                        var object = fabric.util.groupSVGElements(ob, op);
                                        object.set(config);
                                        object.scaleToWidth(item.width * item.scaleX);
                                        object.scaleToHeight(item.height * item.scaleY);
                                        object.vcard = 1;
                                        _canvas.add(object);
                                        continueLoadLayer();
                                    });                                    
                                }else{
                                    klass.fromObject(item, function(item){
                                        _canvas.add(item);
                                        continueLoadLayer();
                                    });
                                }
                            }else{
                                klass.fromObject(item, function(item){
                                    _canvas.add(item);
                                    continueLoadLayer();
                                });
                            }
                        }
                    }else{
                        continueLoadLayer();
                    }
                };
                loadLayer(layerIndex);
            };
            if(fonts.length){
                _.each(fonts, function(font, index){
                    if(!_.filter($scope.resource.font.data, ['alias', font.alias]).length){
                        if( angular.isDefined(font.file) && angular.isDefined(font.file.r) )$scope.resource.font.data.push(font);
                    };                     
                    if( index == fonts.length - 1 ){
                        $scope.insertTemplateFont(font.alias, function(){
                            loadStage(stageIndex);
                            if(!_.filter($scope.resource.usedFonts, ['alias', font.alias]).length){
                                $scope.resource.usedFonts.push($scope.getFontInfo(font.alias));
                            };                            
                        });
                    }else{
                        $scope.insertTemplateFont(font.alias, function(){
                            if(!_.filter($scope.resource.usedFonts, ['alias', font.alias]).length){
                                $scope.resource.usedFonts.push($scope.getFontInfo(font.alias));
                            };                            
                        });
                    }
                });                
            }else{
                loadStage(stageIndex);
            }            
        }
        if( local ){
            loadDesign(temp.fonts, temp.design, temp.viewport);
        }else{
            NBDDataFactory.get('nbdesigner_get_product_info', {product_id: NBDESIGNCONFIG['product_id'], variation_id: NBDESIGNCONFIG['variation_id'], template_id: temp.id}, function(data){
                data = JSON.parse(data);
                loadDesign(data.fonts, data.design, data.config.viewport);
            });
        }
    };   
    $scope.resizeStages = function(viewport){
        _.each($scope.stages, function(stage, index){ 
            var currentViewport = $scope.calcViewport();
            var newFitRec = $scope.fitRectangle(viewport.width, viewport.height, stage.config._width, stage.config._height, true);
            var oldFitRec = $scope.fitRectangle(currentViewport.width, currentViewport.height, stage.config._width, stage.config._height, true);
            var factor = oldFitRec.width / newFitRec.width;
            if( factor != 1 ){
                stage.canvas.forEachObject(function(obj) {     
                    var scaleX = obj.scaleX,
                    scaleY = obj.scaleY,
                    left = obj.left,
                    top = obj.top,
                    tempScaleX = scaleX * factor,
                    tempScaleY = scaleY * factor,
                    tempLeft = left * factor,
                    tempTop = top * factor;   
                    obj.scaleX = tempScaleX;
                    obj.scaleY = tempScaleY;
                    obj.left = tempLeft;
                    obj.top = tempTop;  
                    obj.setCoords();
                });
                stage.canvas.calcOffset();
                $scope.renderStage(index);
            }
            if( index == $scope.stages.length - 1 ){
                $scope.toggleStageLoading();
            }
        });
    };
    $scope.insertTypography = function(typo){
        var stage = $scope.stages[$scope.currentStage],
        _canvas = stage['canvas'];        
        $scope.toggleStageLoading();
        $scope.showDesignTab();
        NBDDataFactory.get('nbd_get_resource', {type: 'get_typo', folder: typo.folder}, function(data){
            data = JSON.parse(data);
            var fonts = data.data.font,
            layers = data.data.design.frame_0.objects;
            $scope.resource.tempData.template = [];
            function loadLayers(){
                _.each(layers, function(layer, _index){
                    if( _index == layers.length - 1 ){                                
                        $scope.loadTemplateLayer(layer, function(){                                    
                            $scope.renderTextAfterLoadFont($scope.resource.tempData.template, function(){
                                var selection = new fabric.ActiveSelection($scope.resource.tempData.template, {
                                  canvas: _canvas
                                });                                        
                                _canvas.setActiveObject(selection);
                                selection.addWithUpdate();
                                _canvas.viewportCenterObjectH(selection);
                                _canvas.viewportCenterObjectV(selection);
                                $scope.renderStage();
                                $timeout(function(){    
                                    $scope.deactiveAllLayer();                                
                                    _canvas.setActiveObject(selection);
                                    selection.addWithUpdate();
                                    _canvas.viewportCenterObjectH(selection);
                                    _canvas.viewportCenterObjectV(selection);
                                    if( stage.config.area_design_type == "2" ) $scope.setStackLayerAlwaysOnTop();
                                    $scope.renderStage();
                                    $scope.toggleStageLoading();  
                                }, 500);                                       
                            });                  
                        });
                    }else{
                        $scope.loadTemplateLayer(layer);
                    }
                });                
            };
            if(fonts.length){
                _.each(fonts, function(font, index){
                    if(!_.filter($scope.resource.font.data, ['alias', font.alias]).length){
                        $scope.resource.font.data.push(font);
                    };                    
                    if( index == fonts.length - 1 ){
                        $scope.insertTemplateFont(font.alias, function(){
                            loadLayers();
                            if(!_.filter(stage.states.usedFonts, ['alias', font.alias]).length){
                                stage.states.usedFonts.push($scope.getFontInfo(font.alias));
                            };                                
                        });
                    }else{
                        $scope.insertTemplateFont(font.alias, function(){
                            if(!_.filter(stage.states.usedFonts, ['alias', font.alias]).length){
                                stage.states.usedFonts.push($scope.getFontInfo(font.alias));
                            };                            
                        });
                    }
                });
            }else{
                loadLayers();
            }
        });
    };
    $scope.renderTextAfterLoadFont = function(layers, callback ){
        if( layers.length == 0 ) {
            callback();
            return;
        };
        _.each(layers, function(item, index){
            if( ['text', 'i-text', 'curvedText', 'textbox'].indexOf(item.type) > -1 ){
                var fontFamily = item.get('fontFamily'),
                fontWeight = item.get('fontWeight'),
                fontStyle = item.get('fontStyle'),
                _font = $scope.getFontInfo(fontFamily);
                var opt = {};
                if( fontWeight != '' ) opt.weight = fontWeight;
                if( fontStyle != '' ) opt.style = fontStyle;
                item.set({objectCaching: false});
                fabric.util.clearFabricFontCache();
                var font = new FontFaceObserver(fontFamily, {weight: fontWeight, style: fontStyle});
                font.load($scope.settings.subsets[_font.subset]['preview_text']).then(function () {
                    fabric.util.clearFabricFontCache();
                    item.initDimensions();
                    item.setCoords();
                }, function () {
                    //todo
                });                
            };
            if( index == (layers.length -1) && typeof callback == 'function' ){
                callback();
            }
        });
    };
    $scope.loadTemplateLayer = function(json, callback, stage_id){
        stage_id =  angular.isDefined(stage_id) ? stage_id : $scope.currentStage;
        var stage = $scope.stages[stage_id],
        _canvas = stage['canvas'];        
        var klass = fabric.util.getKlass(json.type);
        klass.fromObject(json, function(item){
            $scope.contextAddLayers = 'template';
            _canvas.add(item);
            var _item = _canvas.item( _canvas.getObjects().length - 1 );
            $scope.resource.tempData.template.push(_item);
            if( typeof callback == 'function' ) callback();
        });        
    };
    $scope.insertCanvaTypo = function(typo){
        if( $scope.settings.task != 'typography' ){
            $scope.insertTypography(typo);
            return;
        };
        $scope.stages[0].states.usedFonts = [];
        $scope.zoomStage(0);
        var url = $scope.generateTypoLink(typo);
        $scope.resource.currentTypo = typo.id;
        var svg_url = url.replace("png", "svg"),
            svg_url = svg_url.replace("/img/", "/svg/"),
        _stages = $scope.stages[0],
        _canvas = _stages['canvas'];
        _canvas.clear();
        $scope.toggleStageLoading();
        function validFontName(fontName){
            fontName = fontName.replace(/'/g, "");
            fontName = fontName.split("-")[0];
            fontName = fontName.replace(/([A-Z])/g, ' $1').trim();
            return fontName;
        };
        fabric.Image.fromURL(url, function(op) {
            _stages.config.width = op.width;
            _stages.config.height = op.height;
            _canvas.setDimensions({'width' : op.width, 'height' : op.height});         
            fabric.loadSVGFromURL(svg_url, function(ob, op) {
                _canvas.add((fabric.util.groupSVGElements(ob, op)).set({
                    scaleX: _stages.config.width / op.width,
                    scaleY: _stages.config.height / op.height                     
                }));       
                $scope.renderStage(0);
                $timeout(function(){
                    var object = _canvas.getActiveObject();
                    var textIndexArr = [],
                        count = 0;
                    _.each(object._objects, function(path, index){
                        if( angular.isDefined(path.text) ){
                            var color = tinycolor(path.get('fill')).toHexString();
                            color = color.toLowerCase() == '#ffffff' ? '#404762' : color;
                            textIndexArr.push({index: index, type: 'text', text: path.text, font: validFontName(path.fontFamily), fill: color});
                        }
                        if( path.get('fill') == '' ){
                            textIndexArr.push({index: index, type: 'empty_rect'});
                        };
                    });    
                    object.set({dirty: true});
                    _.each(textIndexArr, function(el, index){
                        var _index = el.index - count;
                        object._objects.splice(_index, 1);
                        count++;
                        if(el.type == 'text'){
                            var _text = new FabricWindow.IText(el.text, {
                                    radius: 50,
                                    fontSize: 20,
                                    noScaleCache: false,
                                    fill: el.fill,
                                    lockUniScaling: true,
                                    lockRotation: true,
                                    spacing: 0
                                });
                                _text["setControlVisible"]("mtr", false);
                            if( index < _.findLastIndex(textIndexArr, function(o) { return o.type == 'text'; }) ){
                                $scope.insertTemplateFont(el.font, function(fontName){
                                _text.set({fontFamily: fontName});
                                _canvas.add(_text);      
                                if(!_.filter(_stages.states.usedFonts, ['alias', fontName]).length){
                                    _stages.states.usedFonts.push($scope.getFontInfo(fontName));
                                };                        
                                });
                            }else{
                                $scope.insertTemplateFont(el.font, function(fontName){
                                    _text.set({fontFamily: fontName});
                                    _canvas.add(_text);
                                    if(!_.filter(_stages.states.usedFonts, ['alias', fontName]).length){
                                        _stages.states.usedFonts.push($scope.getFontInfo(fontName));
                                    };                                     
                                    $scope.renderStage(0);               
                                    $scope.toggleStageLoading();  
                                    $scope.updateLayersList();
                                });                            
                            }
                        }
                    });                    
                }, 1000);
            });
        });
    };
    /* History */
    $scope.itemToJson = function(item, params){
        if(params){
            return JSON.stringify(params);
        }else{
            return JSON.stringify(item);
        }
    };   
    $scope.setItemParameters = function(parameters, itemId){
        var params = JSON.parse(parameters),
            _canvas = this.stages[this.currentStage]['canvas'],    
            item = _canvas.item(this.getLayerById(itemId));
            if(typeof params.src !== "undefined"){
                fabric.Image.fromURL(params.src, function(op) {
                    item.getElement().setAttribute("src", params.src);  
                });
            } 
        item.set(params);  
        item.setCoords();
        /* In case image layer has filter */
        if( angular.isDefined(params.filters) ){
            _.each(params.filters, function(value, index){
                if(value != null){
                    //$scope.applyFilters(item, index, value, false);
                };
            });
//            item.applyFilters(function() {
//                _canvas.renderAll()
//            });
        }        
    };
    $scope.undo = function(){
        var _stage = this.stages[this.currentStage],
            _canvas = _stage['canvas']; 
        if( _stage.undos.length > 0 ){
            var last = _stage.undos.pop(),
                _parameters = last.parameters;    
            if(last.interaction === 'remove') {
                $scope.contextAddLayers = 'undo';
                _canvas.add(last.element);
                last.interaction = 'add';
            } else if(last.interaction === 'add') {
                var item = _canvas.item($scope.getLayerById(last.element.itemId));
                _canvas.remove(item);
                last.interaction = 'remove';
            } else {
                var item = _canvas.item($scope.getLayerById(last.element.itemId)),
                    parameters = JSON.parse(_parameters);
                _.each(parameters, function(val, key) {
                    parameters[key] = item.get(key);
                });
                _parameters = JSON.stringify(parameters);
                this.setItemParameters(last.parameters, last.element.itemId);  
            } 
            this.setHistory(false, {
                element: last.element,
                parameters: _parameters,
                interaction: last.interaction
            }); 
            $scope.deactiveAllLayer();
            this.renderStage();            
        }
        $scope.updateApp();
    };
    $scope.redo = function(){
        var _stage = this.stages[this.currentStage],
            _canvas = _stage['canvas'];    
        if( _stage.redos.length > 0 ){
            var last = _stage.redos.pop(),
                _parameters = last.parameters;    
            if(last.interaction === 'remove') {
                $scope.contextAddLayers = 'redo';
                _canvas.add(last.element);
                last.interaction = 'add';
            } else if(last.interaction === 'add') {
                var item = _canvas.item($scope.getLayerById(last.element.itemId));
                _canvas.remove(item);
                last.interaction = 'remove';
            } else {
                var item = _canvas.item($scope.getLayerById(last.element.itemId)),
                    parameters = JSON.parse(_parameters);
                _.each(parameters, function(val, key) {
                    parameters[key] = item.get(key);
                });
                _parameters = JSON.stringify(parameters);
                this.setItemParameters(last.parameters, last.element.itemId);  
            } 
            this.setHistory({
                element: last.element,
                parameters: _parameters,
                interaction: last.interaction
            }); 
            $scope.deactiveAllLayer();
            this.renderStage();            
        };
        $scope.updateApp();
    };  
    $scope.setHistory = function(undo, redo){
        var _stage = this.stages[this.currentStage];
        if (undo) {
            if(angular.isUndefined(_stage.undos)) _stage.undos = [];
            _stage.undos.push(undo);
            if(_stage.undos.length > 50) _stage.undos.shift();
            _stage.states.isUndoable = true;
        }else{
            if(angular.isUndefined(_stage.redos)) _stage.redos = [];
            _stage.states.isRedoable = true;
            _stage.redos.push(redo);
        };
        $scope.updateApp();
        $scope.updateStatusHistory();
    };
    $scope.updateStatusHistory = function(){
        var _stage = this.stages[this.currentStage];
        _stage.states.isUndoable = (_stage.undos.length > 0) ? true : false; 
        _stage.states.isRedoable = (_stage.redos.length > 0) ? true : false;
        $scope.updateApp();
    }; 
    $scope.clearHistory = function(){
        var _stage = this.stages[this.currentStage];
        _stage.undos = [];
        _stage.redos = [];
        _stage.states.isRedoable = false;
        _stage.states.isUndoable = false;
        $scope.updateApp();
    };
    $scope.enableFullScreenMode = function(){
        var ele = document.getElementById('nbd-stages');
        requestFullScreen(ele);  
    };
    $scope.exitFullscreenMode = function(){
        exitFullscreen();
    };
    $scope.toggleStageFullScreenMode = function(){
        _.each($scope.stages, function(stage, index){
            var zoomIndex = $scope.fullScreenMode ?  stage.states.fullScreenScaleIndex : stage.states.fitScaleIndex;
            $scope.zoomStage(zoomIndex, index);
            $scope.deactiveAllLayer(index);    
            $scope.renderStage(index);              
        });
    };    
    /* Design tools */
    $scope.debug = function(){
        var _canvas = $scope.stages[$scope.currentStage]['canvas'];
        //$scope.addText();
        
//Add group        
//        var _canvas = this.stages[$scope.currentStage]['canvas'],
//        item1 = _canvas.item(0),
//        item2 = _canvas.item(1);
//var selection = new fabric.ActiveSelection([item1, item2], {
//  canvas: _canvas
//});
//_canvas.setActiveObject(selection);
//$scope.renderStage();
//
//var item3 = _canvas.item(2);
//var selection = _canvas.getActiveObject();
//if (selection.type === 'activeSelection') {
//  selection.addWithUpdate(item3)
//}
//$scope.renderStage();

//Shape design
//        var path = new fabric.Path("M0 0 H20 V20 H0z M 10 0 A 10 10, 0, 1, 0, 10 20 A 10 10, 0, 1, 0, 10 0z");
//        path.set({strokeWidth: 0});
//        _canvas.add(path);

//Add group
//var iText = new fabric.IText('Hello World!', {
//    left: 10,
//    top: 20,
//    fontFamily: 'Roboto',
//    fill: '#333'            
//});
//var circle = new fabric.Circle({
//  radius: 100,
//  fill: '#eef',
//  scaleY: 0.5
//});
//var group = new fabric.Group([ circle, iText ], {
//  left: 150,
//  top: 100,
//  angle: -10
//});      
//this.stages[this.currentStage]['canvas'].add(group);
        

//Copy layer to other stage
//$scope.tempLayer = _canvas.getActiveObject().toJSON($scope.includeExport);
//$scope.tempLayer = _canvas.getActiveObject().toJSON();
//console.log($scope.tempLayer);
        
//console.log($scope.tempLayer1);
//	_canvas.getActiveObject().clone(function(cloned) {
//            $scope.tempLayer = cloned;
//            console.log(typeof $scope.tempLayer);
//	}); 

//console.log(_canvas.getActiveObject().getBoundingRect());

//getScaledWidth
//console.log(_canvas.getActiveObject().getScaledWidth());
//console.log(_canvas.getActiveObject());
//
//$scope.contextAddLayers = 'template';
//_canvas.add(
//  new fabric.LimitedTextbox('text', {
//    top: 10,
//    left: 10,
//    width: 300,
//    maxWidth: 300,
//    maxLines: 2,
//    fontSize: 20
//  })
//);
    
//        $scope.contextAddLayers = 'template';
//        var clipPath = new fabric.Circle({
//            radius: 40,
//            top: -40,
//            left: -40
//        });
//        var rect = new fabric.Rect({
//            width: 200,
//            height: 100,
//            fill: 'red'
//        });
//        rect.clipPath = clipPath;
//        _canvas.add(rect);        

        $scope.getPrintingOptions();
    };
    $scope.lineConfig = {
        dash1: 5,
        dash2: 5,
        width: 100,
        color: '#ff0000'
    };
    $scope.addLine = function(){
        var _canvas = $scope.stages[$scope.currentStage]['canvas'];
        _canvas.add(
            new fabric.Line([0, 20, $scope.lineConfig.width, 20], {
                strokeDashArray: [$scope.lineConfig.dash1, $scope.lineConfig.dash2],
                stroke: $scope.lineConfig.color
            })        
        );
    };
    $scope.addShape = function( type ){
        var _canvas = $scope.stages[$scope.currentStage]['canvas'];
        var shape = null;
        switch(type){
            case 'rect':
                shape = new fabric.Rect({
                    width: 50,
                    height: 50
                });
                break;
            case 'circle':
                shape = new fabric.Circle({
                    radius: 50
                });            
                break;
            case 'triangle':
                shape = new fabric.Triangle({
                    width: 50,
                    height: 50
                });            
                break;            
        }
        _canvas.add(shape);
    };
    $scope.tempLayer = {};
    $scope.renderStage = function( stage_id ){
        stage_id = stage_id ? stage_id :  $scope.currentStage;
        $scope.stages[stage_id]['canvas'].calcOffset();
        $scope.stages[stage_id]['canvas'].requestRenderAll();
    };
    $scope.deactiveAllLayer = function(stage_id){
        stage_id = stage_id ? stage_id :  $scope.currentStage;
        $scope.stages[stage_id]['canvas'].discardActiveObject();
        angular.merge($scope.stages[$scope.currentStage].states.uploadZone, {visibility: 'hidden'});
        $scope.renderStage();        
        $scope.updateApp();        
    };
    $scope.groupLayers = function(){
        var _canvas = $scope.stages[$scope.currentStage]['canvas'],
        activeObject = _canvas.getActiveObject();
        if (activeObject.type === 'activeSelection') {
            $scope.contextAddLayers = 'template';
            activeObject.toGroup();
            $scope.renderStage();
            $scope.getCurrentLayerInfo();
        }
    };
    $scope.onUnloadGroup = {
        status: false,
        remain: 0,
        length: 0
    };
    $scope.unGroupLayers = function(){
        var _canvas = $scope.stages[$scope.currentStage]['canvas'],
        activeObject = _canvas.getActiveObject();
        if (activeObject.type === 'group') {
            $scope.onUnloadGroup = {
                status: true,
                remain: activeObject._objects.length,
                length: activeObject._objects.length
            };
            if( angular.isDefined(activeObject.itemId) ){
                $scope.onUnloadGroup.prevIndex = $scope.getLayerById(activeObject.itemId);
            }
            $scope.contextAddLayers = 'template';
            activeObject.toActiveSelection();
            $scope.renderStage();
            $scope.getCurrentLayerInfo();            
        }
    };
    /* General */
    $scope.applyFilters = function(item, index, value, addintion){
        //do something
    };
    $scope.clearAllStage = function(){
        _.each($scope.stages, function(stage, index){
            stage.canvas.clear();
        });
        $scope.initStagesSettingWithoutTemplate();
    };
    /* Draw mode */
    $scope.disableDrawMode = function(){
        $scope.resource.drawMode.status = false;
        _.each($scope.stages, function(stage, index){
            stage.canvas.isDrawingMode = false;
        });
        $scope.changeBush();
        $scope.updateApp();
    };
    $scope.enableDrawMode = function(){
        $scope.resource.drawMode.status = true;
        _.each($scope.stages, function(stage, index){
            stage.canvas.isDrawingMode = true;
        });
        $scope.updateApp();
    }; 
    $scope.changeBush = function(){
        _.each($scope.stages, function(stage, index){
            stage.canvas.freeDrawingBrush = new fabric[$scope.resource.drawMode.brushType + "Brush"](stage.canvas);
            stage.canvas.freeDrawingBrush.color = $scope.resource.drawMode.brushColor;
            stage.canvas.freeDrawingBrush.width = $scope.resource.drawMode.brushWidth;
        });
    };
    $scope.importDesign = function(){
        var input = document.createElement('input');
        input.type = 'file';
        input.accept = 'text/json|application/json';
        input.style.display = 'none';
        input.addEventListener('change', onChange.bind(input), false);
        document.body.appendChild(input);
        input.click();
        function onChange(){
            if (this.files.length > 0) {
                var file = this.files[0],
                reader = new FileReader();
                reader.onload = function(event){
                    if (event.target.readyState === 2) {
                        var result = JSON.parse(reader.result);
                        $scope.insertTemplate(true, {fonts: result.fonts, design: result.design});
                        destroy();
                    }
                };
                reader.readAsText(file);                
            }            
        }
        function destroy() {
            input.removeEventListener('change', onChange.bind(input), false);
            document.body.removeChild(input);
        }
    };
    $scope.exportDesign = function(){
        $scope.saveDesign();
        var json = {config: {}};
        json.config.viewport = $scope.calcViewport();
        json.fonts = $scope.resource.usedFonts;
        json.design = $scope.resource.jsonDesign;
        var filename = 'design.json',
        text = JSON.stringify(json),
        a = document.createElement('a');
        a.setAttribute('href', 'data:text/plain;charset=utf-u,'+ text);
        a.setAttribute('download', filename);
        a.click();
    };   
    $scope.loadMyDesign = function(did, inCart){
        $scope.login(function(){
            var dataObj = {}, loadAllMyTemplate = true;
            $scope.toggleStageLoading();
            if( did != null ){
                dataObj = { did: did };
                loadAllMyTemplate = false;
            }else{
                dataObj = {
                    product_id: NBDESIGNCONFIG['product_id'],
                    variation_id: NBDESIGNCONFIG['variation_id']
                };
            };
            var action = inCart ? 'nbd_get_designs_in_cart' : 'nbd_get_user_designs';
            NBDDataFactory.get(action, dataObj, function(data){
                data = JSON.parse(data);
                if(data.flag == 1){
                    if( loadAllMyTemplate ){
                        $scope.resource.myTemplates = data.designs;
                        $scope.toggleStageLoading();
                    }else{
                        $scope.insertTemplate(true, {fonts: data.fonts, design: data.design, doNotShowLoading: true});
                    }
                }
            });
        });
    };   
    $scope.deleteLayers = function(itemIndex){
        var _canvas = this.stages[$scope.currentStage]['canvas'];
        //if(item.isEditing) return;
        var item = angular.isDefined(itemIndex) ? _canvas.item(itemIndex) : _canvas.getActiveObjects();
        if(item){
            if( angular.isDefined(itemIndex) ){
                $scope.setHistory({
                    element: item,
                    parameters: JSON.stringify(item.toJSON()),
                    interaction: 'remove'
                });
                _canvas.remove(item); 
            }else{
                _canvas.getActiveObjects().forEach(function(o){
                    $scope.setHistory({
                        element: o,
                        parameters: JSON.stringify(o.toJSON()),
                        interaction: 'remove'
                    }); 
                    _canvas.remove(o); 
                });
            }
            _canvas.discardActiveObject().requestRenderAll();
        };
        $scope.updateLayersList();
        return;
    };
    $scope.activeLayer = function(itemIndex, layerIndex){
        var _stage = $scope.stages[$scope.currentStage],
        _canvas = _stage['canvas'];
        _canvas.setActiveObject(_canvas.item(itemIndex));
        if( angular.isDefined(layerIndex) ) _stage.layers[layerIndex].active = true;
        $scope.renderStage();
    };
    $scope.copyLayers = function(){
        var _canvas = this.stages[$scope.currentStage]['canvas'];
        if( !_canvas.getActiveObject() ) return;
	_canvas.getActiveObject().clone(function(cloned) {
            _clipboard = cloned;
	}); 
        $timeout(function(){
            _clipboard.clone(function(clonedObj) {
                _canvas.discardActiveObject();
                clonedObj.set({
                    left: clonedObj.left + 10,
                    top: clonedObj.top + 10,
                    evented: true
                });
                if (clonedObj.type === 'activeSelection') {
                    clonedObj.canvas = _canvas;
                    clonedObj.forEachObject(function(obj) {
                        $scope.contextAddLayers = 'copy';
                        _canvas.add(obj);
                    });
                    clonedObj.setCoords();
                } else {
                    $scope.contextAddLayers = 'copy';
                    _canvas.add(clonedObj);
                }
                _canvas.setActiveObject(clonedObj);
                _canvas.requestRenderAll();            
            });
        });
    };  
    $scope.alignLayer = function(command){
        var _canvas = this.stages[this.currentStage].canvas,
            group = _canvas.getActiveObject(),   
            items = _canvas.getActiveObjects(),
            _bound = items[0].getBoundingRect(),    
            position = {
                left: _bound.left,
                top: _bound.top,
                right: _bound.left + _bound.width,
                bottom: _bound.top + _bound.height
            };  
        var _leftPosition = [],   
            _topPosition = [],   
            totalWidth = 0,
            totalHeight = 0;  

        items.forEach(function(item, index){
            var bound = item.getBoundingRect();
            if(bound.left < position.left) position.left = bound.left;
            if(bound.top < position.top) position.top = bound.top;
            if(bound.left + bound.width > position.right) position.right = bound.left + bound.width;
            if(bound.top + bound.height > position.bottom) position.bottom = bound.top + bound.height;
            _leftPosition.push({index: index, value: bound.left});
            _topPosition.push({index: index, value: bound.top});
            totalWidth += bound.width;
            totalHeight += bound.height;
        });
        switch(command) {
            case 'horizontal':
                items.forEach(function(item){
                    var bound = item.getBoundingRect();
                    item.set({top: item.get('top') + (position.top + position.bottom) / 2 - bound.top - bound.height / 2});
                    item.setCoords();                       
                });
                break;
            case 'vertical':
                items.forEach(function(item){
                    var bound = item.getBoundingRect();
                    item.set({left: item.get('left') + (position.left + position.right) / 2 - bound.left - bound.width / 2});
                    item.setCoords();
                });                    
                break;
            case 'top':
                items.forEach(function(item){
                    var bound = item.getBoundingRect();
                    item.set({top: item.get('top') + position.top - bound.top });
                    item.setCoords();
                });                    
                break;
            case 'bottom':
                items.forEach(function(item){
                    var bound = item.getBoundingRect();
                    item.set({top: item.get('top') + position.bottom - bound.top - bound.height });
                    item.setCoords();
                });                     
                break;  
            case 'left':
                items.forEach(function(item){
                    var bound = item.getBoundingRect();
                    item.set({left: item.get('left') - bound.left + position.left});
                    item.setCoords();
                });
                break;
            case 'right':
                items.forEach(function(item){
                    var bound = item.getBoundingRect();
                    item.set({left: item.get('left') - bound.left + position.right - bound.width});
                    item.setCoords();
                });                      
                break;
            case 'dis-horizontal':
                leftPosition = _.sortBy(_leftPosition, [function(o) { return o.value; }]);
                var space = (position.right - position.left - totalWidth) / (items.length - 1);
                leftPosition.forEach(function(_item, _index){
                    var index = _item.index;
                    if(_index > 0 && _index < items.length - 1){
                        var item = items[index],
                        previous_item = items[leftPosition[_index-1].index],
                        bound = item.getBoundingRect(),
                        previous_item_bound = previous_item.getBoundingRect();
                        item.set({'left': item.get('left') - bound.left +  previous_item_bound.left + previous_item_bound.width + space });
                        item.setCoords();                            
                    }
                });
                break;
            case 'dis-vertical':
                topPosition = _.sortBy(_topPosition, [function(o) { return o.value; }]);
                var space = (position.bottom - position.top - totalHeight) / (items.length - 1);
                topPosition.forEach(function(_item, _index){
                    var index = _item.index;
                    if(_index > 0 && _index < items.length - 1){
                        var item = items[index],
                        previous_item = items[topPosition[_index-1].index],
                        bound = item.getBoundingRect(),
                        previous_item_bound = previous_item.getBoundingRect();
                        item.set({'top': item.get('top') - bound.top + previous_item_bound.top + previous_item_bound.height + space });
                        item.setCoords();
                    }
                });
                break;                  
        };    
        group.addWithUpdate();
        this.renderStage();
    };    
    $scope.translateLayer = function(command){
        var stage = $scope.stages[$scope.currentStage],
            _canvas = stage.canvas,
            item = _canvas.getActiveObject();
        if(!item) return;
            var  bound = item.getBoundingRect(),
            scale = stage.states.scaleRange[stage.states.currentScaleIndex].ratio,
            left = item.get('left'),
            top = item.get('top');
        $scope.beforeObjectModify(item);
        switch(command) {
            case 'horizontal':
                _canvas.viewportCenterObjectH(item);
                break;
            case 'vertical':
                _canvas.viewportCenterObjectV(item);
                break;
            case 'center':
                _canvas.viewportCenterObjectH(item);
                _canvas.viewportCenterObjectV(item);
                break;                
            case 'top':
                item.set({top: 0});
                break;
                break;                
            case 'top-left':
                item.set({top: 0, left: 0});
                break;   
            case 'top-center':
                _canvas.viewportCenterObjectH(item);
                item.set({top: 0});
                break; 
            case 'top-right':
                item.set({top: 0, left: left + (_canvas.width - bound.width - bound.left)/scale});
                break;            
            case 'bottom':
                item.set({top: top + (_canvas.height - bound.height - bound.top)/scale});
                break;  
            case 'bottom-left':
                item.set({left: 0, top: top + (_canvas.height - bound.height - bound.top)/scale});
                break; 
            case 'bottom-center':
                _canvas.viewportCenterObjectH(item);
                item.set({top: top + (_canvas.height - bound.height - bound.top)/scale});
                break;
            case 'bottom-right':
                item.set({left: left + (_canvas.width - bound.width - bound.left)/scale, top: top + (_canvas.height - bound.height - bound.top)/scale});
                break;             
            case 'left':
                item.set({left: 0});
                break;
            case 'middle-left':
                _canvas.viewportCenterObjectV(item);
                item.set({left: 0});
                break;                
            case 'right':
                item.set({left: left + (_canvas.width - bound.width - bound.left)/scale});
                break;       
            case 'middle-right':
                _canvas.viewportCenterObjectV(item);
                item.set({left: left + (_canvas.width - bound.width - bound.left)/scale});
                break;             
        };
        item.setCoords();
        $scope.renderStage();        
    };
    $scope.getLayerById = function(itemId){
        var _canvas = this.stages[this.currentStage].canvas;
        var _index;
        _canvas.forEachObject(function(obj, index) {
            if(obj.get('itemId') == itemId) _index = index;
        });
        return _index;
    };     
    $scope.closePopupClearStage = function(){
        jQuery('.clear-stage-alert .close-popup').triggerHandler('click');
    };
    $scope.zoomStage = function(index, stage_id){
        stage_id = angular.isDefined(stage_id) ? stage_id : $scope.currentStage;
        var _stage = $scope.stages[stage_id],
           _canvas = _stage['canvas'];
        _stage.states.currentScaleIndex = index;
        $scope.setStageDimension(stage_id);
        _canvas.setZoom(_stage.states.scaleRange[_stage.states.currentScaleIndex].ratio);
        jQuery('#stage-container-'+$scope.currentStage).stop().animate({
            scrollTop: 0,
            scrollLeft: 0
        }, 100);  
        jQuery('#stage-container-'+$scope.currentStage).perfectScrollbar('update');
        this.renderStage();
    };
    $scope.clearStage = function(){
        var stage = $scope.stages[$scope.currentStage],
        _canvas = stage['canvas'];
        _canvas.clear();
        jQuery('.clear-stage-alert .close-popup').triggerHandler('click');
        if( stage.config.bgType == 'color' ){
            _canvas.backgroundColor = stage.config.bgColor;
        }
        if( stage.config.area_design_type == "2" ){
            $scope.contextAddLayers = 'template';
            var width = _canvas.width,
            height = _canvas.height,
            path = new fabric.Path("M0 0 H"+width+" V"+height+" H0z M "+width/2+" 0 A "+width/2+" "+height/2+", 0, 1, 0, "+width/2+" "+height+" A "+width/2+" "+height/2+", 0, 1, 0, "+width/2+" 0z");
            path.set({strokeWidth: 0, isAlwaysOnTop: true, fill: '#ffffff', selectable: false, evented: false});
            _canvas.add(path);                  
        }
        _canvas.requestRenderAll();
    };
    $scope.selectAllLayers = function(){
        var _canvas = this.stages[this.currentStage]['canvas'];
        $scope.deactiveAllLayer();
        var objs = [];
        _canvas.forEachObject(function(obj, index) {
            if( obj.get('selectable') ) objs.push(obj);
        });
        var selection = new fabric.ActiveSelection(objs, {
            canvas: _canvas
        });
        selection.addWithUpdate();
        _canvas.setActiveObject(selection);
        $scope.renderStage();        
    };
    $scope.stageToJson = function(stage_id){
        stage_id = stage_id ? stage_id :  $scope.currentStage;
        $scope.renderStage(stage_id);
        var json = this.stages[stage_id]['canvas'].toJSON($scope.includeExport);
        return json;
    };
    $scope.loadStageFromJson = function(stage_id, json){
        var _canvas = this.stages[stage_id]['canvas'];
        _canvas.loadFromJSON(json, function() {  
            $scope.renderStage(stage_id);
        });
    };
    $scope.copyStage = function( stage_id ){
        stage_id = stage_id ? stage_id :  $scope.currentStage;
        $scope.tempStageDesign = {
            id: stage_id,
            design: $scope.stageToJson()
        };
    };
    $scope.pasteStage = function( dist_stage ){
        dist_stage = dist_stage ? dist_stage :  $scope.currentStage;
        $scope.loadStageFromJson(dist_stage, $scope.tempStageDesign.design);
        $scope.tempStageDesign = null;
    };
    $scope.clearClipboardDesign = function(){
        $scope.tempStageDesign = null;
    };    
    $scope.rotateLayer = function(command){
        var _canvas = this.stages[this.currentStage]['canvas'],
        item = _canvas.getActiveObject();
        $scope.beforeObjectModify(item);
        switch(command){
            case 'reflect-hoz':
                item.toggle("flipY");
                break;
            case 'reflect-ver':
                item.toggle("flipX");
                break;       
            case '90cw':
                var angle = item.getAngle() + 90
                if (angle > 360) angle = angle - 360;
                if (angle < 0) angle = angle + 360;
                item.setAngle(angle);
                break;
            case '90ccw':
                var angle = item.getAngle() - 90
                if (angle > 360) angle = angle - 360;
                if (angle < 0) angle = angle + 360;
                item.setAngle(angle);
                break;    
            case '180':
                var angle = item.getAngle() + 180
                if (angle > 360) angle = angle - 360;
                if (angle < 0) angle = angle + 360;
                item.setAngle(angle);
                break;      
            default: 
                var angle = parseInt(command);
                item.setAngle(angle);
        };   
        item.setCoords();
        this.renderStage();
    };
    $scope.scaleLayer = function(command){
        var _stage = this.stages[this.currentStage],
            _canvas = _stage.canvas,
            obj = _canvas.getActiveObject();
        if (!obj) return;
        $scope.beforeObjectModify(obj);
        if( _stage.lockMovementY || _stage.lockMovementX ) return;
        var scaleX = obj.scaleX,
            scaleY = obj.scaleY,
            left = obj.left,
            top = obj.top,
            width = obj.width * scaleX,
            height = obj.height * scaleY,
            factor = command === "+" ? 1.1 : 0.9;   
        var tempScaleX = scaleX * factor,
            tempScaleY = scaleY * factor,
            tempWidth = width * factor,
            tempHeight = height * factor,
            tempLeft = left + width / 2 - tempWidth / 2,
            tempTop = top + height / 2 - tempHeight / 2;
        obj.scaleX = tempScaleX;
        obj.scaleY = tempScaleY;
        obj.left = tempLeft;
        obj.top = tempTop;
        obj.setCoords();
        $scope.renderStage();
    };
    $scope.moveLayer = function( command, alt ){
        var _canvas = this.stages[this.currentStage].canvas,
            items = _canvas.getActiveObjects(),
            selection = _canvas.getActiveObject(),
            step = alt ? 1 : 10;
        if( items.length == 0 ) return;    
        angular.merge($scope.stages[$scope.currentStage].states.boundingObject, {visibility: 'hidden'});
        items.forEach(function( item ){
            $scope.beforeObjectModify(item);
            switch(command) {
                case 'up':
                    if( !item.get("lockMovementY") ) item.set('top', item.get('top') - step);
                    break;
                case 'down':
                    if( !item.get("lockMovementY") ) item.set('top', item.get('top') + step);
                    break;    
                case 'left':
                    if( !item.get("lockMovementX") ) item.set('left', item.get('left') - step);
                    break;
                case 'right':
                    if( !item.get("lockMovementX") ) item.set('left', item.get('left') + step);
                    break;               
            };  
            item.setCoords();
        });
        if( selection.type === 'activeSelection' ){
            selection.addWithUpdate();
        };
        this.updateApp();
        this.renderStage();
    };
    $scope.sortLayer = function(srcIndex, dstIndex){
        var _canvas = this.stages[this.currentStage].canvas;
        _canvas.item(srcIndex).moveTo(dstIndex);
        $scope.deactiveAllLayer();
        $scope.renderStage();
        $scope.updateLayersList();
        $scope.updateApp();
    };
    $scope.updateLayersList = function(){
        var _stage = $scope.stages[$scope.currentStage],
        _canvas = _stage['canvas'];
        _stage.layers = [];
        _canvas.forEachObject(function(obj, index) {
            var layerInfo = {index: index, visible: obj.get('visible'), selectable: obj.get('selectable'), itemId: obj.get('itemId')};
            if( !obj.isAlwaysOnTop ){
                switch(obj.type) {
                    case 'i-text':
                    case 'text':
                    case 'textbox':
                    case 'curvedText':
                        layerInfo.type = 'text';
                        layerInfo.icon_class = 'text-fields';
                        layerInfo.text = obj.get('text');
                        break;
                    case 'image':
                    case 'custom-image':
                        layerInfo.type = 'image';
                        layerInfo.src = obj.getSvgSrc();
                        break;
                    case 'rect':
                    case 'triangle':
                    case 'line':
                    case 'polygon':                    
                    case 'circle':
                    case 'ellipse':
                        var type = obj.type == 'rect' ? 'rectangle' : obj.type;
                        layerInfo.icon_class = 'layer-'+type;
                        layerInfo.type = obj.type;
                        break;     
                    case 'path-group':                    
                    case 'path':
                        layerInfo.icon_class = 'vector';
                        layerInfo.type = 'path';
                        break; 
                    case 'group':
                        layerInfo.icon_class = 'layer-group';
                        layerInfo.type = 'group';
                        break;               
                    default:
                        layerInfo.type = obj.type;
                        break; 
                }
                _stage.layers.push(layerInfo);
            }
        });
        $timeout(function(){
            jQuery('#tab-layer .tab-scroll').perfectScrollbar('update');
        });
    }; 
    $scope.setStackLayerAlwaysOnTop = function(maybeRender){
        var _canvas = $scope.stages[$scope.currentStage]['canvas'];
        _canvas.forEachObject(function(obj) {
            if( obj.isAlwaysOnTop ){
                obj.bringToFront();
            }
        });
        if(maybeRender) $scope.renderStage();
    };
    $scope.setStackPosition = function(command, onLayer, _item){
        var item = _item ? _item : $scope.stages[$scope.currentStage]['canvas'].getActiveObject();
        $scope.beforeObjectModify(item);
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
        if(!onLayer) $scope.updateLayersList();
    };  
    $scope.changeBackground = function(color){
        $scope.stages[$scope.currentStage].config.bgColor = color;
    };
    $scope.changeFill = function(color){
        var _stage = $scope.stages[$scope.currentStage],
            _canvas = _stage.canvas;
        if( angular.equals({}, _canvas) ) return;
        var item = _canvas.getActiveObject();
        $scope.beforeObjectModify(item);
        if( !_stage.states.isPath ){
            item.set({fill: color});
            _stage.states.text.fill = color;
        }else{
            item.set({dirty: true});
            _.each(_stage.states.svg.groupPath[_stage.states.svg.currentPath].index, function(path_index){
                if( path_index > -1 ){
                    item._objects[path_index].set({fill: color});
                }else{
                    item.set({fill: color});
                }
            });
            _stage.states.svg.groupPath[_stage.states.svg.currentPath].color = color;
        }
        $scope.renderStage();
    };
    /* Text */
    $scope.addText = function(content, type){
        content = angular.isDefined(content) ? content : $scope.settings.nbdesigner_default_text;
        type = angular.isUndefined(type) ? 'bodytext' : type;
        var textType = 'IText',
        fontSize = 16,    
        fontName = NBDESIGNCONFIG.default_font.alias;
        var state= $scope.stages[$scope.currentStage].states;
        switch(type){
            case 'heading':
                textType = 'Textbox';
                fontSize = 42;
                break;
            case 'subheading':
                textType = 'Textbox';
                fontSize = 36;                
                break;           
        };
        var textObj = {
            fontFamily: fontName,
            radius: 50,
            objectCaching: false,
            fontSize: fontSize,            
            ptFontSize: fontSize  / state.ratioConvertFont
        };
        if( textType == 'Textbox' ) angular.extend(textObj, {textAlign: 'center'});
        function addText(){
            $scope.stages[$scope.currentStage]['canvas'].add(new FabricWindow[textType](content, textObj));            
        };
        var font = new FontFaceObserver(fontName);
        font.load($scope.settings.subsets[NBDESIGNCONFIG.default_font.subset]['preview_text']).then(function () {
            fabric.util.clearFabricFontCache(fontName);
            addText();
        }, function () {
            console.log('Fail to load font: '+fontName);
            addText();
        });      
    };
    $scope.setLayerAttribute = function(type, value, item_index, layer_index){
        var _canvas = $scope.stages[$scope.currentStage]['canvas'];
        if( !appConfig.ready ) return;
        var item = angular.isDefined(item_index) ? _canvas.item(item_index) : _canvas.getActiveObject();
        $scope.beforeObjectModify(item);
        item.set({[type]: value});
        var itemType = item.get('type');
        if( (itemType == 'i-text' || itemType == 'textbox') && type == 'selectable'){
            value == true ? item.set({editable: true}) : item.set({editable: false});
        };
        switch(type){
            case 'selectable':
            case 'visible':
                $scope.deactiveAllLayer();
                break;
            case 'selectable':
                item.set({_fixedWidth: item.getBoundingRect().width});
                break;
            case 'lockScalingX':
                var controlVisible = itemType == 'textbox' ? [] : ['tl', 'tr', 'bl', 'br'];
                controlVisible.forEach(function(key){
                    item.setControlVisible(key, !value);
                });
                break;
            case 'lockScalingY':
                var controlVisible = itemType == 'textbox' ? [] : ['tl', 'tr', 'bl', 'br'];
                controlVisible.forEach(function(key){
                    item.setControlVisible(key, !value);
                });
                break;
            case 'lockRotation':
                item.setControlVisible('mtr', !value);	
                break;
        }
        $scope.renderStage();
        if(angular.isDefined(item_index)){
            $scope.stages[$scope.currentStage].layers[layer_index][type] = value;
        }else{
            $scope.stages[$scope.currentStage].states[type] = value;  
        }
        $scope.updateApp();
    };
    $scope.setTextAttribute = function(type, value, extra_option){
        var _stage = $scope.stages[$scope.currentStage],
            _states = _stage.states,
            _canvas = _stage['canvas'];
        if( !appConfig.ready ) return;  
        var item = _canvas.getActiveObject();
        if( !item ) return;
        $scope.beforeObjectModify(item);
        item.set({[type]: value});
        if( type == 'fontSize' ){
            var minSize = arrayMin($scope.listFontSizeInPt);
            if( $scope.forceMinSize && minSize > value ) value = minSize;
            item.set({'ptFontSize': value, 'fontSize': value * _states.ratioConvertFont});
            _states.text.ptFontSize = value;
        }
        switch(type){
            case 'is_uppercase':
                value ? item.set({'text': item.get('text').toUpperCase()}) : item.set({'text': item.get('text').toLowerCase()});
                break;
            case 'fontFamily':
                if(!_.filter(_states.usedFonts, ['alias', value]).length){
                    _states.usedFonts.push($scope.getFontInfo(value));
                }
                _states.text.font = $scope.getFontInfo(value);
                if( !_states.text.font.file.b ) {
                    item.set({fontWeight: 'normal'});
                    _states.text.fontWeight = 'normal';
                };
                if( !_states.text.font.file.i ) {
                    item.set({fontStyle: 'normal'});
                    _states.text.fontStyle = 'normal';
                };
                if( !_states.text.font.file.bi && item.get('fontWeight') == 'bold' && item.get('fontStyle') == 'italic' ) {
                    item.set({fontWeight: 'normal', fontStyle: 'normal'});
                    _states.text.fontWeight = 'normal';
                    _states.text.fontStyle = 'normal';
                };
                break;
        }
        _states.text[type] = value;
        if( type.indexOf("font") > -1 ){
            var font = new FontFaceObserver(_states.text.fontFamily, {weight: _states.text.fontWeight, style: _states.text.fontStyle});
            font.load($scope.settings.subsets[_states.text.font.subset]['preview_text']).then(function () {
                fabric.util.clearFabricFontCache(_states.text.fontFamily);
                item.initDimensions();
                item.setCoords();
                $scope.renderStage(); 
            }, function () {
                item.setCoords();
                $scope.renderStage();
            });
        }else{
            item.setCoords();
            $scope.renderStage();       
        }        
    };    
    /* Image */
    $scope.addImage = function(url, showLoading, hideLoading){
        var stage = $scope.stages[$scope.currentStage],
            _canvas = stage['canvas'],
            scale = stage.states.scaleRange[stage.states.currentScaleIndex].ratio;
        if( showLoading ) $scope.toggleStageLoading();
        fabric.Image.fromURL(url, function(op) {  
            if( $scope.stages[$scope.currentStage].states.elementUpload ){
                var object = _canvas.getActiveObject(),
                element = object.getElement();
                $scope.beforeObjectModify(object);
                element.setAttribute("src", url);  
                _canvas.getActiveObject().set({
                    dirty: true,
                    width: op.width,
                    height: op.height,
                    scaleX: object.width * object.scaleX / op.width,
                    scaleY: object.width * object.scaleX / op.width                  
                });
                object.setCoords();  
                $scope.deactiveAllLayer();
                $scope.renderStage();
            }else{
                var max_width = _canvas.width / scale * .9,
                max_height = _canvas.height / scale * .9,
                new_width = max_width;
                if (op.width < max_width) new_width = op.width;
                var width_ratio = new_width / op.width,
                new_height = op.height * width_ratio;
                if (new_height > max_height) {
                    new_height = max_height;
                    var height_ratio = new_height / op.height;
                    new_width = op.width * height_ratio;
                } 
                op.set({
                    fill: '#ff0000',
                    scaleX: new_width / op.width,
                    scaleY: new_height / op.height                
                });
                $scope.stages[$scope.currentStage]['canvas'].add(op);
            }
            if( hideLoading ) $scope.toggleStageLoading();
        });
    };
    $scope.applyFilter = function(obj, index, filter) {
        var stage = $scope.stages[$scope.currentStage],
        _canvas = stage['canvas'];
        obj = obj ? obj : _canvas.getActiveObject();
        obj.filters[index] = filter;
        obj.applyFilters();
        $scope.renderStage();
    };
    $scope.filterImage = function(){
        var f = fabric.Image.filters;
        $scope.applyFilter(null, 0, new f.Grayscale());
    };
    /* SVG */
    $scope.addSvgFromString = function(svg, showLoading){
        if( angular.isUndefined(showLoading) ) $scope.toggleStageLoading();
        fabric.loadSVGFromString(svg, function(ob, op) {
            $scope._addSvg(ob, op, {name: ''}, true);
        });
    };
    $scope.addSvgFromMedia = function(art){
        $scope.showDesignTab();
        $scope.toggleStageLoading();
        $http({
            method: 'GET',
            url: appConfig.mediaUrl + '/clipart?get_svg=' + art.url.replace("//dpeuzbvf3y4lr.cloudfront.net/", "")
        }).then(function successCallback(response){
            var svg = response.data.data;
            $scope.addSvgFromString(svg, false);
        }, function errorCallback(response) {
            console.log('Fail to load: svg');
        });
    };
    $scope.addArt = function(art, showLoading, hideLoading){
        if( showLoading ) $scope.toggleStageLoading();
        if(art.url.match(/\.(jpeg|jpg|gif|png)$/) != null){
            $scope.addImage(art.url, false, hideLoading);
        }else{
            fabric.loadSVGFromURL(art.url, function(ob, op) {
                if(ob){ 
                    $scope._addSvg(ob, op, art, hideLoading);
                }else{
                    alert('Try again!');
                    $scope.toggleStageLoading();
                }
            })
        }
    };
    $scope._addSvg = function(ob, op, art, hideLoading){
        var stage = $scope.stages[$scope.currentStage],
        _canvas = stage['canvas'],
        scale = stage.states.scaleRange[stage.states.currentScaleIndex].ratio,
        max_width = _canvas.width / scale * .9,
        max_height = _canvas.height / scale * .9,
        new_width = max_width;

        if (op.width < max_width) new_width = op.width;
        var width_ratio = new_width / op.width,
        new_height = op.height * width_ratio;
        if (new_height > max_height) {
            new_height = max_height;
            var height_ratio = new_height / op.height;
            new_width = op.width * height_ratio;
        }
        var object = fabric.util.groupSVGElements(ob, op);
        object.scaleToWidth(new_width);
        object.scaleToHeight(new_height);
        _canvas.add(object);
        if( hideLoading ) $scope.toggleStageLoading();
    };
    $scope.addQrCode = function(){      
        var qr = qrcode(4, 'L');
        qr.addData( $scope.resource.qrText);
        qr.make();
        var _qrcode = qr.createSvgTag();
        fabric.loadSVGFromString(_qrcode, function(ob, op) {
            $scope._addSvg(ob, op, {name: ''}, false);
        });
        jQuery('.main-qrcode').html('').append(_qrcode);
    };
    $scope.strVcard = '';
    $scope.buildVcart = function( config ){
        var infos = $scope.settings.user_infos;
        $scope.strVcard += 'BEGIN:VCARD\nVERSION:3.0\n';
        $scope.strVcard += 'N:'+infos.last_name.value+';'+infos.first_name.value+'\n'+ 'FN:'+infos.full_name.value;
        $scope.strVcard += '\nADR;TYPE=home:;;'+infos.address.value+';'+infos.city.value+';;'+infos.postcode.value+';'+infos.country.value;
        $scope.strVcard += '\nTEL;TYPE=home:'+infos.phone.value;
        $scope.strVcard += '\nTEL;TYPE=work:'+infos.mobile.value;
        $scope.strVcard += '\nEMAIL;TYPE=internet,work:'+infos.email.value;
        $scope.strVcard += '\nURL;TYPE=work:'+infos.website.value;
        $scope.strVcard += '\nEND:VCARD';
        var qr = qrcode('0', 'M');
        qr.addData( $scope.strVcard );
        qr.make();
        var _qrcode = qr.createSvgTag();
        fabric.loadSVGFromString(_qrcode, function(ob, op) {
            var stage = $scope.stages[$scope.currentStage],
            _canvas = stage['canvas'],
            scale = stage.states.scaleRange[stage.states.currentScaleIndex].ratio,
            max_width = _canvas.width / scale * .9,
            max_height = _canvas.height / scale * .9,
            new_width = max_width;
            if (op.width < max_width) new_width = op.width;
            var width_ratio = new_width / op.width,
            new_height = op.height * width_ratio;
            if (new_height > max_height) {
                new_height = max_height;
                var height_ratio = new_height / op.height;
                new_width = op.width * height_ratio;
            }
            var object = fabric.util.groupSVGElements(ob, op);
            if( config ){
                object.set(config);
            }else{
                object.scaleToWidth(new_width);
                object.scaleToHeight(new_height);
            }
            object.vcard = 1;
            _canvas.add(object);
        });        
    };
    $scope.addUserInfo = function( iIndex ){
        var state= $scope.stages[$scope.currentStage].states;
        var ptPontSize = ( ['first_name', 'last_name', 'full_name'].indexOf(iIndex) > -1 ) ? 9 : 7;
        var fontName = ( ['first_name', 'last_name', 'full_name'].indexOf(iIndex) > -1 ) ? 'nbfontf7afb53fe3' : 'nbfont92f8d8c63d';
        //fontName = fontName = NBDESIGNCONFIG.default_font.alias;
        var textObj = {
            fontFamily: fontName,
            radius: 50,
            objectCaching: false,
            fontSize: ptPontSize * state.ratioConvertFont,
            ptFontSize: ptPontSize
        };
        textObj[iIndex] = 1;
        var textType = iIndex == 'title' ? 'Textbox' : 'IText';
        function addText(){
            $scope.stages[$scope.currentStage]['canvas'].add(new FabricWindow[textType]($scope.settings.user_infos[iIndex].value, textObj));            
        };
        state.text.font = $scope.getFontInfo(fontName);
        if(!_.filter(state.usedFonts, ['alias', fontName]).length){
            state.usedFonts.push(state.text.font);
        };        
        var font_id = fontName.replace(/\s/gi, '').toLowerCase();
        if( !jQuery('#' + font_id).length ){
            var font_url =  state.text.font.url;
            if(! ( state.text.font.url.indexOf("http") > -1)) font_url = NBDESIGNCONFIG['font_url'] +  state.text.font.url; 
            var css = "";
            css = "<style type='text/css' id='" + font_id + "' >";
            css += "@font-face {font-family: '" + fontName + "';";
            css += "src: local('\u263a'),";
            css += "url('" + font_url + "') format('truetype')";
            css += "}";
            css += "</style>";
            jQuery("head").append(css);
        }
        var font = new FontFaceObserver(fontName);
        font.load($scope.settings.subsets[state.text.font.subset]['preview_text']).then(function () {
            fabric.util.clearFabricFontCache(fontName);
            addText();
        }, function () {
            console.log('Fail to load font: '+fontName);
            addText();
        }); 
    };
    $scope.init();
}]);
nbdApp.factory('FabricWindow', ['$window', function($window) {
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
        selectionColor: "rgba(1, 196, 204, 0.3)",
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
    $window.fabric.Image.prototype.set({
        originX: 'center',
        originY: 'center'
    });    
    fabric.enableGLFiltering = false;
    fabric.PathGroup = { };
    fabric.PathGroup.fromObject = function (object, callback) {
        var originalPaths = object.paths;
        delete object.paths;
        if (typeof originalPaths === 'string') {
            fabric.loadSVGFromURL(originalPaths, function (elements) {
                var pathUrl = originalPaths;
                var group = fabric.util.groupSVGElements(elements, object, pathUrl);
                group.type = 'group';
                object.paths = originalPaths;
                callback(group);
            });
        } else {
            fabric.util.enlivenObjects(originalPaths, function (enlivenedObjects) {
                enlivenedObjects.forEach(function (obj) {
                    obj._removeTransformMatrix();
                });
                var group = new fabric.Group(enlivenedObjects, object);
                group.type = 'group';
                object.paths = originalPaths;
                callback(group);
            });
        }
    };  
    fabric.LimitedTextbox = fabric.util.createClass(fabric.Textbox, {
        // Override `insertChars` method
        updateFromTextArea: function () {
//            if (this.maxWidth) {
//                var textWidthUnderCursor = this._getLineWidth(this.ctx, this.get2DCursorLocation().lineIndex);
//                if (textWidthUnderCursor + this.ctx.measureText(chars).width > this.maxWidth) {
//                    chars = '\n' + chars;
//                }
//            }
//            if (this.maxLines) {
//                var newLinesLength = this._wrapText(this.ctx, this.text + chars).length;
//                if (newLinesLength > this.maxLines) {
//                    return;
//                }
//            }
            // Call parent class method
            this.callSuper('updateFromTextArea');
        }        
    });
    return $window.fabric;
}]);
nbdApp.directive('nbdCanvas', ['FabricWindow', '$timeout', '$rootScope', function(FabricWindow, $timeout, $rootScope){
    return {
        restrict: "AE",
        scope: {
            stage: '=stage',
            index: '@',
            last: '@'
        },
        link: function( scope, element, attrs ) {
            $timeout(function() {
                scope.stage.canvas = new FabricWindow.Canvas('nbd-stage-'+scope.index);
                scope.$emit('canvas:created', scope.index, scope.last);
                element.parent().children().on("contextmenu", function(e){
                    e.preventDefault();
                    scope.$emit('nbd:contextmenu', e);
                });
            });  
        }
    }
}]);
nbdApp.directive('keypress', ['$window', function($window){
    return {
        restrict: "AE",
        link: function( scope, element, attrs ) {
            $window.document.addEventListener("keydown", function(e){
                scope.$emit('nbd:keypress', e);
            }, false);           
        }
    }
}]);
nbdApp.directive('nbdScroll', ['$timeout', function($timeout){
    return {
        restrict: "AE",
        scope: {
            container: '@',
            type: '@',
            offset: '@',
            action: '&nbdScroll'
        },
        link: function( scope, element, attrs ) {
            $timeout(function() {
                var el = scope.type != 'font' ? jQuery(scope.container + ' .tab-scroll') : jQuery(scope.container),
                    offset = parseInt(scope.offset),
                    elInfo = jQuery(scope.container + ' .info-support');
                el.on('ps-scroll-y', function(){
                    if(el.prop("clientHeight") != el.prop("scrollHeight") && ((el.prop("scrollTop") + el.prop("clientHeight") - el.prop("scrollHeight") + offset) > 0) ){
                        scope.action({container: scope.container, type: scope.type});
                    };
                    if( elInfo.length ){
                        el.prop("scrollTop") > 1500 && elInfo.addClass('slideInDown animated show') || elInfo.removeClass('slideInDown animated show');
                    }
                });
            });
        }
    }
}]);
nbdApp.directive('nbdLayer', ['$timeout', function($timeout){
    return {
        restrict: "AE",
        scope: {
            action: '&nbdLayer'
        },
        link: function( scope, element, attrs ) {
            $timeout(function() {
                if( !checkMobileDevice() ){
                    jQuery(element).sortable({
                        placeholder: "sortable-placeholder",
                        stop: function(event, ui) {
                            var srcIndex = jQuery(this).attr('data-prev-index'),
                                oldIndex = jQuery(this).attr('data-previndex'),
                                newIndex = ui.item.index(),
                                dstIndex = 0;
                            if( oldIndex > newIndex ){
                                dstIndex = jQuery(ui.item).next().attr('data-index')
                            }else {
                                dstIndex = jQuery(ui.item).prev().attr('data-index')
                            };
                            jQuery(this).removeAttr('data-previndex');
                            jQuery(this).removeAttr('data-prev-index');
                            scope.action({srcIndex: srcIndex, dstIndex: dstIndex});
                        },
                        start: function(e, ui) {
                            jQuery(this).attr('data-prev-index', jQuery(ui.item).attr('data-index'));
                            jQuery(this).attr('data-previndex', ui.item.index());
                        },                    
                    });
                }
            });
        }
    };
}]);
nbdApp.directive('endRepeatColorPicker', ['$timeout', function($timeout){
    return {
        restrict: "A",
        link: function( scope, element, attrs ) {
            $timeout(function() {
                jQuery(element).nbdColorPalette();
            });
        }
    }    
}]);
nbdApp.directive('repeatEnd', [ function(){
    return {
        restrict: "AE",    
        link: function( scope, element, attrs ) {  
            if(scope.$last) {
                scope.$eval(attrs.repeatEnd);
            }            
        }
    }
}]);
nbdApp.directive('keyup', ['$window', function($window){
    return {
        restrict: "AE",
        link: function( scope, element, attrs ) {
            $window.document.addEventListener("keyup", function(e){
                scope.$emit('nbd:keyup', e);
            }, false);           
        }
    }
}]);
nbdApp.filter('keyboardShortcut', function($window) {
    return function(str) {
        if (!str)
            return;
        var keys = str.split('-');
        var isOSX = /Mac OS X/.test($window.navigator.userAgent);
        var seperator = (!isOSX || keys.length > 2) ? '+' : '';
        var abbreviations = {
            M: isOSX ? '⌘' : 'Ctrl',
            A: isOSX ? 'Option' : 'Alt',
            S: 'Shift'
        };
        return keys.map(function (key, index) {
            var last = index == keys.length - 1;
            return last ? key : abbreviations[key];
        }).join(seperator);
    };    
});
nbdApp.filter("filterFont", function() {
    return function(fonts, filterFont) {
        var arrFont = [];
        angular.forEach(fonts, function(font, key) {
            var check = [];
            check['limit'] = arrFont.length > ( filterFont.perPage * filterFont.currentPage  - 1 ) ? false : true;
            if( !!filterFont.search ){
               check['name'] = font.name.toLowerCase().indexOf(filterFont.search.toLowerCase()) >= 0 ? true : false;
            }else{
                check['name'] = true;
            };
            if( check['limit'] && check['name'] )arrFont.push(font);
        });
        arrFont = _.sortBy(arrFont, [function(o) { return o.name; }]);
        return arrFont
    }
});
nbdApp.filter("filterArt", function() {
    return function(arts, filterArt) {
        var arrArt = [];
        arts = _.sortBy(arts, [function(o) { return o.name; }]);
        angular.forEach(arts, function(art, key) {
            var check = [];
            check['limit'] = arrArt.length > ( filterArt.perPage * filterArt.currentPage  - 1 ) ? false : true;
            if( !!filterArt.search ){
               check['name'] = art.name.toLowerCase().indexOf(filterArt.search.toLowerCase()) >= 0 ? true : false;
            }else{
                check['name'] = true;
            };
            if( !!filterArt.currentCat.id ){
                check['cat'] = _.includes(art.cat, filterArt.currentCat.id) ? true : false;
            }else{
                check['cat'] = true;
            }
            if( check['limit'] && check['name'] && check['cat'] ) arrArt.push(art);
        });
        return arrArt
    }
});
nbdApp.filter('reverse', function() {
    return function(items) {
        return items.slice().reverse();
    };
});
nbdApp.directive("imageOnLoad", [ function() {
    return {
        restrict: "A",
        scope: {
            src: '=imageOnLoad'
        }, 
        link: function(scope, element) {
            var img = new Image();
            img.onload = function(){
                element.removeClass('image-onload');
            };
            img.src = scope.src;
            element.addClass('image-onload');
        }
    };
}]);    
nbdApp.directive("fontOnLoad", [ function() {
    return {
        restrict: "A",
        scope: {
            font: '=',
            preview: '=',
            loadFontFailAction: '&'
        },
        link: function(scope, element) {
            var fontName = scope.font.alias,
                fontType = scope.font.type;
            if( fontName == '' ) return;
            var font_id = fontName.replace(/\s/gi, '').toLowerCase();
            if( !jQuery('#' + font_id).length ){
                if(fontType == 'google'){
                    jQuery('head').append('<link id="' + font_id + '" href="https://fonts.googleapis.com/css?family='+ fontName.replace(/\s/gi, '+') +':400,400i,700,700i" rel="stylesheet" type="text/css">');
                }else{
                    var font_url = scope.font.url;
                    if(! (scope.font.url.indexOf("http") > -1)) font_url = NBDESIGNCONFIG['font_url'] + scope.font.url; 
                    var type = fontType.toLowerCase() == "ttf" ? "truetype" : 'woff';
                    var css = "";
                    css = "<style type='text/css' id='" + font_id + "' >";
                    css += "@font-face {font-family: '" + fontName + "';";
                    css += "src: local('\u263a'),";
                    css += "url('" + font_url + "') format('" + type + "')";
                    css += "}";
                    css += "</style>";
                    jQuery("head").append(css);
                }
            };
            var font = new FontFaceObserver(fontName);
            font.load(scope.preview).then(function () {
                element.removeClass('font-loading');
            }, function () {
                scope.loadFontFailAction({font: scope.font});
            }); 
            element.addClass('font-loading');
        }
    }
}]);
nbdApp.directive("nbdDndFile", ['$timeout', function($timeout) {
    return {
        restrict: "A",
        scope: {
            uploadFile: '&nbdDndFile'
        },
        link: function(scope, element) {  
            $timeout(function() {
                var dropArea = jQuery(element),
                Input = dropArea.find('input[type="file"]');
                _.each(['dragenter', 'dragover'], function(eventName, key) {
                    dropArea.on(eventName, highlight)
                });
                _.each(['dragleave', 'drop'], function(eventName, key) {
                    dropArea.on(eventName, unhighlight)
                });
                function highlight(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropArea.addClass('highlight');
                };
                function unhighlight(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropArea.removeClass('highlight');
                };
                dropArea.on('drop', handleDrop);
                function handleDrop(e) {
                    if( jQuery('#accept-term').length && !jQuery('#accept-term').is(':checked') ) {
                        alert(NBDESIGNCONFIG.nbdlangs.alert_upload_term);
                        return;
                    }else{
                        if(e.originalEvent.dataTransfer){
                            if(e.originalEvent.dataTransfer.files.length) {
                                e.preventDefault();
                                e.stopPropagation();
                                handleFiles(e.originalEvent.dataTransfer.files);
                            }                        
                        }                        
                    }
                };
                dropArea.on('click', function(e){
                    Input.click();
                });
                Input.on('click', function(e){
                    e.stopPropagation();
                    if( jQuery('#accept-term').length && !jQuery('#accept-term').is(':checked') ) {
                        alert(NBDESIGNCONFIG.nbdlangs.alert_upload_term);
                        e.preventDefault();
                        return;
                    }
                });
                Input.on('change', function(){
                    handleFiles(this.files);
                });               
                function handleFiles(files) {
                    if(files.length > 0) scope.uploadFile({files: files});
                }       
            });
        }
    }        
}]);
nbdApp.directive("nbdDrag", [ function() {
    return {
        restrict: "AE",
        scope: {
            url: '=nbdDrag',
            extenal: '@extenal',
            type: '@type'
        },
        link: function( scope, element, attrs ) {
            element.attr("draggable", "true");
            element.on('dragstart', function(event) { 
                event.originalEvent.dataTransfer.setData("src",scope.url);                    
                event.originalEvent.dataTransfer.setData("extenal",scope.extenal);             
                event.originalEvent.dataTransfer.setData("type",scope.type);                
            });          
        }
    }        
}]);
nbdApp.directive("nbdColorPicker", ['$timeout', function($timeout) {
    return {
        restrict: "C",
        scope: {
            cattr: '@',
            color: '@'
        },
        link: function(scope, element) {
            jQuery(element).on('click', function(){
                $timeout(function() {
                    jQuery('#nbd-global-color-palette').addClass('show');
                });
                scope.$emit('nbd:picker', scope.cattr, scope.color);
            });
        }
    };
}]);
nbdApp.directive("nbdClearStage", function() {
    return {
        restrict: "A",
        link: function(scope, element) {
            jQuery(element).on('click', function(){
                //$timeout(function() {
                    jQuery('.nbd-popup.popup-select').nbShowPopup();
                //});   
            });  
        }
    };    
});
nbdApp.factory('NBDDataFactory', function($http){
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
            if( data.type == 'typography' || data.type == 'get_typo' ) url = appConfig.mediaUrl + '/typo';
            if( data.source == 'media' ) url = appConfig.mediaUrl + '/template';
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
if( NBDESIGNCONFIG['nbdesigner_enable_facebook_photo'] == 'yes' && NBDESIGNCONFIG['fbID'] != ''){
    window.fbAsyncInit = function() {
      FB.init({
          appId      : NBDESIGNCONFIG['fbID'],
          status     : true, 
          cookie     : true,      
          xfbml      : true,
          autoLogAppEvents       : true,
          version    : 'v3.0'
      });
    };
    (function(d, s, id){
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) {return;}
          js = d.createElement(s); js.id = id;
          js.src = "https://connect.facebook.net/en_US/sdk.js";
          fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));  
    var nbdOnFBLogin = function(){
        FB.getLoginStatus(function(response) {
            if (response.status === "connected") {
                var uid = response.authResponse.userID;
                var accessToken = response.authResponse.accessToken;
                var scope = angular.element(document.getElementById("designer-controller")).scope();
                scope.getPersonalPhoto('facebook', [uid, accessToken]);
                scope.updateApp();            
            }
        });
    };
};
function requestFullScreen(element) {
    var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;
    if (requestMethod) { 
        requestMethod.call(element);
    } else if (typeof window.ActiveXObject !== "undefined") {
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{Esc}");
        }
    }
};
function exitFullscreen(){
    var a = document.webkitExitFullscreen || document.mozCancelFullScreen || document.msExitFullscreen || document.exitFullscreen;
    a && a.call(document);
};
document.addEventListener('DOMContentLoaded', function(){
    /* Dropbox */
    var options = {
        success: function(files) {
            var scope = angular.element(document.getElementById("designer-controller")).scope();
            scope.getPersonalPhoto('dropbox', files);
            scope.updateApp();
        },                 
        linkType: "direct",
        multiselect: true,
        extensions: ['.jpg', '.jpeg', '.png']
    };
    if( NBDESIGNCONFIG['enable_dropbox'] ){
        var button = Dropbox.createChooseButton(options);
        document.getElementById("nbdesigner_dropbox").appendChild(button); 
    };    
});
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
};
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
};
window.addEventListener("message", receiveMessage, false);
function receiveMessage(event){
    if( event.origin == window.location.origin && event.data == 'change_nbo_options' ){
        //event.source.postMessage("received", event.origin);
        var scope = angular.element(document.getElementById("designer-controller")).scope();
        scope.changePrintingOptions();
        //nbdPostMessage();
    };
};
function nbdPostMessage(){
    nbd_window.postMessage("received", window.location.origin);
};
/* Change variation */
nbd_window.jQuery('input[name="variation_id"]').on('change', function(){
    if( NBDESIGNCONFIG['ui_mode'] == 1 ){
        var variation_id = nbd_window.jQuery('input[name="variation_id"]').val();
        if(NBDESIGNCONFIG['variation_id'] == variation_id) return;  
        var scope = angular.element(document.getElementById("designer-controller")).scope();
        if(variation_id != ''){
            nbd_window.NBDESIGNERPRODUCT.nbdesigner_unready();
            if(NBDESIGNCONFIG['nbdesigner_hide_button_cart_in_detail_page'] == 'yes'){
                nbd_window.jQuery('button[type="submit"].single_add_to_cart_button').hide();
            }
        }
        NBDESIGNCONFIG['variation_id'] = variation_id;
        if(variation_id != ''){
            scope.changeVariation();
        }
    }
});
jQuery(document).on( 'change_nbo_options', function(){
    var scope = angular.element(document.getElementById("designer-controller")).scope();
    if( jQuery('input[name="variation_id"]').length ){
        scope.printingOptionsAvailable = jQuery('input[name="variation_id"]').val() > 0 ? true : false;
        NBDESIGNCONFIG.variation_id = jQuery('input[name="variation_id"]').val();
    }else{
        scope.printingOptionsAvailable = true;
    }
    scope.updateApp();
});
jQuery(document).on( 'invalid_nbo_options', function(){
    var scope = angular.element(document.getElementById("designer-controller")).scope();
    scope.printingOptionsAvailable = false;
    scope.updateApp();
});




function checkMobileDevice(){
    var isMobile = false;
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;
    return isMobile;
};

(function ($) {
    var modern = {
        init: function () {
            this.mainBar();
            this.mainMenu();
            this.clickOutside();
            this.sideBar.init();
            this.toolBar.init();
            this.showPopup();
            //this.animateStart();
            this.actionPopupShare();
            this.actionShowPreview();
            this.responsive();
            this.checkDevice();

        },
        checkDevice: function () {
            var uA = navigator.userAgent;
            if( uA.indexOf("Android") >= 0 ){
                $('body').addClass('android');
            }
            if(uA.indexOf('Trident') != -1 && uA.indexOf('rv:11') != -1){
                $('body').addClass('ie');
            }
            else if(navigator.userAgent.indexOf("Firefox")!=-1){
                $('body').addClass('firefox');
            }
            else if(navigator.userAgent.indexOf("Opera")!=-1){
                $('body').addClass('Opera');
            }
            else if(navigator.userAgent.indexOf("Chrome") != -1){
                $('body').addClass('chrome');
            }
            else if(navigator.userAgent.indexOf("Safari")!=-1 && navigator.userAgent.indexOf("CriOS") ==-1){
                $('body').addClass('safari');
            }
        },
        clickOutside: function () {
            var $menuItem = $('.nbd-main-menu .menu-item,.nbd-dropdown');
            var $colorPallette = $('.nbd-color-palette');
            var $win = $(document);
            $win.on("click", function(event){
                if ($menuItem.has(event.target).length == 0 && !$menuItem.is(event.target)){
                    $menuItem.removeClass('active');
                    if (checkMobileDevice()) {
                        $('.main-toolbar').removeClass('overflow-hidden');
                    }
                }
                if ($colorPallette.has(event.target).length == 0 && !$colorPallette.is(event.target) && !$('.nbd-show-color-palette span').is(event.target)) {
                    $colorPallette.removeClass('show');
                    $('.nbd-show-color-palette').removeClass('nbd-show');
                }

            });
        },
        mainMenu: function () {
            var $menuItem = $('.nbd-main-menu .menu-item');
            var $nbdDropdown = $('.nbd-dropdown');
            var $subMenu = $('.nbd-main-menu .menu-item .sub-menu');
            var $nbdSubDropdown = $('.nbd-sub-dropdown');
            var $subMenuItem = $('.nbd-main-menu .menu-item .sub-menu-item');
            var $closeSubMenu = $('.nbd-close-sub-menu');
            var $subMenuHover = $('.nbd-main-menu .sub-menu .hover-menu');
            var clickOutside = false;

            $menuItem.on('click touch', function (event) {
                var target = $(event.target);
                $menuItem.not(this).removeClass('active');
                if ( target.hasClass('sub-menu-item') || target.parents('.sub-menu-item').length
                    || !( target.hasClass('sub-menu') || target.parents('.sub-menu').length ) ){
                    if ($(this).find('.sub-menu').length) {
                        if (!$(this).hasClass('active')) {
                            $menuItem.removeClass('active');
                            $(this).addClass('active');
                            if (checkMobileDevice()) {
                                if ($(this).attr('data-range') == 'true') {
                                    $(this).closest('.main-toolbar').addClass('overflow-hidden');
                                }
                            }
                        }else {
                            $(this).removeClass('active');
                            if (checkMobileDevice()) {
                                if ($(this).attr('data-range') == 'true') {
                                    $(this).closest('.main-toolbar').removeClass('overflow-hidden');
                                }
                            }
                        }
                    }
                }
            });
            $nbdDropdown.on('click', function () {
                if ($(this).find('.nbd-sub-dropdown').length) {
                    if (!$(this).hasClass('active')) {
                        $(this).addClass('active');
                        $(this).find('.nbd-perfect-scroll').perfectScrollbar('update');
                    }else {
                        $(this).removeClass('active');
                    }
                }
            });
            $closeSubMenu.on('click', function () {
                $menuItem.removeClass('active');
            });
//            $subMenuItem.on('click', function () {
//                return false;
//            });
//            $subMenu.on('click', function () {
//                return false;
//            });
//            $nbdSubDropdown.on('click', function () {
//                return false;
//            });

            // Hover in submenu
            $subMenuHover.on({
                mouseenter: function () {
                    if (!checkMobileDevice()) {
                        $(this).addClass('show');
                    }
                },
                mouseleave: function () {
                    if (!checkMobileDevice()) {
                        $(this).removeClass('show');
                    }
                },
                click: function (e) {
                    if ($(this).hasClass('show')) {
                        $(this).removeClass('show');
                        if (checkMobileDevice()) {
                            $(this).find('.hover-sub-menu-item').slideUp();
                        }
                    }else {
                        $(this).siblings().removeClass('show');
                        $(this).addClass('show');
                        if (checkMobileDevice()) {
                            $(this).find('.hover-sub-menu-item').slideDown();
                        }
                    }
                    if ($(this).find('.hover-sub-menu-item').has(event.target).length == 0 && !$(this).find('.hover-sub-menu-item').is(e.target)) {
                        return false;
                    }

                }
            });
            if (checkMobileDevice()) {
                $subMenuHover.find(' > i').removeClass('rotate-90');
            }
        },
        mainBar: function () {
            var $mainBar = $('.nbd-main-bar');
        },
        sideBar: {
            init: function () {
                this.tab();
                this.tabPhto.init();
                //this.tabLayer.init();
                this.tabProductTemplate();
                //this.tabSvg();
                //this.tabTypography();
                this.tabElement.init();
            },
            tab: function () {
                var $tab = $('.nbd-sidebar .tabs-nav .tab');
                var $tabContent = $('.nbd-sidebar .tabs-content .tab');
                var $tabLayer = $('.nbd-sidebar .tabs-nav .tab.layerTab');
                var responsive = $(window).width();

                if (checkMobileDevice()) {
                    $tabContent.filter('.active').prevAll().addClass('left');
                    $tabContent.filter('.active').nextAll().addClass('right');
                    $tab.filter('.tab-first').removeClass('active');
                    $('.nbd-sidebar .tabs-content').addClass('nbd-hidden');

                }else{
                    $tabContent.filter('.active').prevAll().addClass('before');
                    $tabContent.filter('.active').nextAll().addClass('after');
                }
                $tab.on('click', function () {
                    var i = $(this).index();
                    i = ($tabLayer.length) ? parseInt(i) - 1 : parseInt(i);
                    var nthTab = 'tab-' + i;
                    ``
//                    if ($(this).hasClass('layerTab')) {
//                        $('.nbd-sidebar .tabs-content').hide();
//                    }else{
//                        $('.nbd-sidebar .tabs-content').show();
//                        $('.nbd-sidebar .tabs-content').removeClass('nbd-hidden');
//                    }

                    if (checkMobileDevice()) {
                        if ($(this).hasClass('layerTab')) {
                            $('.nbd-workspace .main').addClass('active');
                            // $('.nbd-sidebar .tabs-content').hide();
                            $('.nbd-sidebar .tabs-content').removeClass('active');
                        }else {
                            $('.nbd-workspace .main').removeClass('active');
                            // $('.nbd-sidebar .tabs-content').show();
                            $('.nbd-sidebar .tabs-content').addClass('active');
                            $('.nbd-sidebar .tabs-content').removeClass('nbd-hidden');
                        }
                    }

                    $(this).parent().removeAttr('data-tab').attr('data-tab', nthTab);
                    $tab.removeClass('active');
                    $(this).addClass('active');
                    $tabContent.removeClass('before after left right');
                    $tabContent.each(function (j) {
                        j += 1;
                        if (i == j) {
                            $(this).addClass('active');
                            if (checkMobileDevice()) {
                                $(this).prevAll().addClass('left');
                                $(this).nextAll().addClass('right');
                            }else {
                                $(this).prevAll().addClass('before');
                                $(this).nextAll().addClass('after');
                            }

                        }else {
                            $(this).removeClass('active');
                        }
                    });
                });
            },
            tabPhto: {
                init: function () {
                    // this.main();
                    // this.masonry();

                    $('#tab-photo .nbd-items-dropdown').nbdDropdown({
                        'getServer': {},
                        'itemInRow': 3,
                        'itemDistance' : 20
                    });

                    var $termCheck = $('.type-upload .nbd-term .nbd-checkbox input');
                    var $formUpload = $('.nbd-sidebar .type-upload .form-upload');
                    var isUpload = false;
                    $termCheck.on('click', function () {
                        var $typeUpload = $(this).closest('.type-upload');
                        if ($(this).is(':checked')) {
                            $typeUpload.addClass('accept');
                            isUpload = true;
                        }else {
                            $typeUpload.removeClass('accept');
                            isUpload = false;
                        }
                    });
                    $formUpload.on('click', function () {
                        if (!isUpload) {
                            return false;
                        }
                    });

                },
//                masonry: function (init) {
//                    init = true;
//                    imagesLoaded( $('#nbdesigner-gallery'), function() {
//                        if( !init ) $('#nbdesigner-gallery').masonry('destroy');
//                        $('#nbdesigner-gallery').masonry({
//                            itemSelector: '.nbdesigner-item'
//                        });
//                        $.each($('#nbdesigner-gallery .nbdesigner-item'), function(e) {
//                            $(this).addClass("in-view");
//                        });
//                    });
//                },
//                getImageItem: function () {
//                    var src1 = 'https://media-public.canva.com/MABf-7qI6NA/1/thumbnail.jpg';
//                    var src2 = 'https://media-public.canva.com/MABrm9_5-j0/3/thumbnail_large.jpg';
//                    var src3 = 'https://media-public.canva.com/MABLiofkWpk/2/thumbnail_large.jpg';
//                    var src4 = 'https://media-public.canva.com/MABKNOKek5k/1/thumbnail_large.jpg';
//                    var src5 = 'https://media-public.canva.com/MABKNF1976I/1/thumbnail_large.jpg';
//                    var src6 = 'https://media-public.canva.com/MABKNNgN1-U/1/thumbnail_large.jpg';
//                    var src7 = 'https://media-public.canva.com/MABjD-hdPCA/1/thumbnail.jpg';
//                    var src8 = 'https://media-public.canva.com/MABKNCXtIVk/1/thumbnail_large.jpg';
//                    var src9 = 'https://media-public.canva.com/MABKNJM4T9E/1/thumbnail_large.jpg';
//                    var src10 = 'https://media-public.canva.com/MABKNEG7Fmc/1/thumbnail_large.jpg';
//                    var item = '' +
//                        '<div class="nbdesigner-item"><img src="' + src1 + '"><span class="photo-desc">xxxxxx</span></div>' +
//                        '<div class="nbdesigner-item"><img src="' + src2 + '"><span class="photo-desc">xxxxxx</span></div>' +
//                        '<div class="nbdesigner-item"><img src="' + src3 + '"><span class="photo-desc">xxxxxx</span></div>' +
//                        '<div class="nbdesigner-item"><img src="' + src4 + '"><span class="photo-desc">xxxxxx</span></div>' +
//                        '<div class="nbdesigner-item"><img src="' + src5 + '"><span class="photo-desc">xxxxxx</span></div>' +
//                        '<div class="nbdesigner-item"><img src="' + src6 + '"><span class="photo-desc">xxxxxx</span></div>' +
//                        '<div class="nbdesigner-item"><img src="' + src7 + '"><span class="photo-desc">xxxxxx</span></div>' +
//                        '<div class="nbdesigner-item"><img src="' + src8 + '"><span class="photo-desc">xxxxxx</span></div>' +
//                        '<div class="nbdesigner-item"><img src="' + src9 + '"><span class="photo-desc">xxxxxx</span></div>' +
//                        '<div class="nbdesigner-item"><img src="' + src10 + '"><span class="photo-desc">xxxxxx</span></div>';
//                    return item;
//                },
                initPositionCate: function () {
                    var $category = $('.nbd-sidebar #tab-photo .categories .category');
                    $category.each(function () {
                        var index = $(this).index();
                        var indexMod = index % 3;
                        var indexI = parseInt(index / 3);
                        $(this).css({
                            'left': 115 * indexMod + 'px',
                            'top' : 132 * indexI + 'px'
                        });
                    });
                }
            },
            //tabLayer: {
//                init: function () {
//                    //this.main();
//                    //this.actionLayer();
//                },
//                main: function () {
//                    modern.sideBar.tabLayer.sortable();
//                },
//                sortable: function () {
//                    var $tabLayer = $('.nbd-sidebar #tab-layer');
//                    var $menuLayer = $('.nbd-sidebar #tab-layer .menu-layer');
//                    $menuLayer.sortable();
//                    // $menuLayer.disableSelection();
//                },
            //actionLayer: function () {
//                    var $menuLayer = $('.nbd-sidebar #tab-layer .menu-layer');
//                    var iconAction = $('.nbd-sidebar #tab-layer .menu-layer .item-right i');
//                    iconAction.on('click', function () {
//                        var dataAct = $(this).attr('data-act');
//                        var dataActive = $(this).attr('data-active');
//                        var $menuItem = $(this).closest('.menu-item');
//
//                        switch (dataAct) {
//                            case 'visibility':
//                                if (dataActive == 'true') {
//                                    $(this).removeClass('icon-nbd-fomat-visibility');
//                                    $(this).addClass('icon-nbd-fomat-visibility-off');
//                                }else{
//                                    $(this).addClass('icon-nbd-fomat-visibility');
//                                    $(this).removeClass('icon-nbd-fomat-visibility-off');
//                                }
//                                break;
//                            case 'lock':
//
//                                if (dataActive == 'true') {
//                                    $(this).removeClass('icon-nbd-fomat-lock-open');
//                                    $(this).addClass('icon-nbd-fomat-lock-outline');
//                                    $menuItem.addClass('lock-active');
//                                    // $menuItem.find('input').attr('disabled', 'disabled');
//                                }else{
//                                    $(this).removeClass('icon-nbd-fomat-lock-outline');
//                                    $(this).addClass('icon-nbd-fomat-lock-open');
//                                    $menuItem.removeClass('lock-active');
//                                    // $menuItem.find('input').removeAttr('disabled');
//                                }
//                                break;
//                            case 'close':
//                                // TODO Code hear : delete layer
//                                //$(this).closest('.menu-item').remove();
//                                break;
//                            default:
//                               return false;
//                        }
//
//                        if (dataActive == 'true') {
//                            $(this).attr('data-active', 'false');
//                        }else {
//                            $(this).attr('data-active', 'true');
//                        }
//
//                    });
            //},
            //},
            tabProductTemplate: function () {
                var $tabProductTemplate = $('.nbd-sidebar #tab-product-template');
                var $product = $('.nbd-sidebar #tab-product .nbd-product');
                var $template = $('.nbd-sidebar #tab-template');
                var $closeTemplate = $('.nbd-sidebar #tab-template .close-template');
                var $productImg = $('.nbd-sidebar #tab-product .nbd-product .nbd-product-img');
                var $itemTemplate = $('.nbd-sidebar #tab-template .nbd-items-dropdown .main-items item');

                $('#tab-template .nbd-items-dropdown').nbdDropdown({
                    'getServer': {},
                    'itemInRow': 2,
                    'itemDistance' : 10
                });

                // $productImg.on('click', function () {
                //     $tabProductTemplate.addClass('template-show');
                //     $template.addClass('animated slideInLeft');
                // });
                // $closeTemplate.on('click', function () {
                //     $tabProductTemplate.removeClass('template-show');
                //     $product.addClass('animated slideInRight');
                // });
            },
            //tabSvg : function () {
            // $('#tab-svg .nbd-items-dropdown').nbdDropdown({
            //     'getServer': {},
            //     'itemInRow': 3,
            //     'itemDistance' : 20
            // });

//                $('#tab-svg .nbdesigner-gallery').masonry({
//                    itemSelector: '.nbdesigner-item'
//                });

            //},
            //tabTypography: function () {
            // var $typographyItems = $('.nbd-sidebar .typography-items');
            // var $typographyItem = $('.nbd-sidebar .typography-items .typography-item');
//                var item = nbdGetItems.getImageItemTypography();
//                for (var i=0;i<30;i++) {
//                    $typographyItems.append(item);
//                }
//                $typographyItems.imagesLoaded()
//                    .always( function( instance ) {
//                        // All images loaded
//                        setTimeout(function () {
//                            $typographyItems.masonry({
//                                itemSelector: '.typography-item'
//                            });
//                        }, 1000);
//                    })
//                    .done( function( instance ) {
//                        // All images successfull loaded
//                    })
//                    .fail( function() {
//                        // All images loaded, at least one is broken
//                    })
//                    .progress( function( instance, image ) {
//                    });

            //},
            tabElement : {
                init: function () {
                    $('#tab-element .nbd-items-dropdown').nbdDropdown({
                        'getServer': {},
                        'itemInRow': 3,
                        'itemDistance' : 20
                    });
                },
            }
        },
        toolBar: {
            init: function () {
                //this.toolBarText();
                //this.toolBarCommon();
                this.toolBarImage();
            },
            //toolBarText: function () {
//                var $menuRight = $('.nbd-toolbar .toolbar-text .menu-right');
//                var $menuItemRight = $('.nbd-toolbar .toolbar-text .menu-right .menu-item:not(:first-child)');
//
//                $menuItemRight.on('click', function () {
//                    if ($(this).hasClass('selected')) {
//                        $(this).removeClass('selected')
//                    }else {
//                        $(this).addClass('selected');
//                    }
//                });


            //},
            //toolBarCommon: function () {
//                var $colorPalette = $('.nbd-color-palette');
//                var $addColorPalette = $colorPalette.find('.color-palette-add');
//                var colorClick = false;
            // $addColorPalette.on('click', function () {
            //     if ($colorPalette.hasClass('show-popup')) {
            //         $colorPalette.removeClass('show-popup');
            //     }else {
            //         $colorPalette.addClass('show-popup');
            //     }
            // });

//                $colorPalette.on('click', function (e) {
//                    var $target = $(e.target);
//                    if (!$target.is('li')) {
//                        if ($(this).hasClass('show-popup')) {
//                            $(this).removeClass('show-popup');
//                        }
//                    }
//                });
//
//                $('.color-palette-popup').on('click', function () {
//                    return false;
//                });

            //},
            toolBarImage: function () {
                var $scrollPreset = $('.nbd-toolbar .toolbar-image .filter-scroll');
                var $scrollRight = $('.nbd-toolbar .toolbar-image .filter-scroll.scrollRight');
                var $scrollLeft = $('.nbd-toolbar .toolbar-image .filter-scroll.scrollLeft');
                var $filterImg = $('.nbd-toolbar .toolbar-image .main-presets .preset');
                var $range = $('.nbd-toolbar .toolbar-image .main-ranges .range');
                var $inputSlide = $('.nbd-toolbar .toolbar-image .main-ranges .range .slide-input');

                $scrollPreset.on('click', function () {
                    var tranform = $filterImg.css('transform').split(/[()]/)[1];
                    var curPosTranform = parseInt(tranform.split(',')[4]);
                    var newPosTranform = 0;
                    var addTranform = $filterImg.outerWidth() * 3;
                    var minThreshold = 0;
                    var maxThreshold = -(parseInt($filterImg.length / 3) - 1) * addTranform;
                    if ($(this).hasClass('scrollLeft')) {
                        var newPosTranform = curPosTranform + addTranform;
                        if (curPosTranform >= minThreshold) {
                            $(this).filter('.scrollLeft').addClass('disable');
                            return false;
                        }else {
                            if ($scrollRight.hasClass('disable')) {
                                $scrollRight.removeClass('disable');
                            }
                            $filterImg.css({
                                'transform': 'translateX('+ newPosTranform +'px)'
                            });
                        }
                    }else if ($(this).hasClass('scrollRight')) {
                        var newPosTranform = curPosTranform - addTranform;
                        if (curPosTranform <= maxThreshold) {
                            $(this).filter('.scrollRight').addClass('disable');
                            return false;
                        }else {
                            if ($scrollLeft.hasClass('disable')) {
                                $scrollLeft.removeClass('disable');
                            }
                            $filterImg.css({
                                'transform': 'translateX('+ newPosTranform +'px)'
                            });
                        }
                    }else {
                        return false;
                    }
                });
//                $inputSlide.on({
//                    'change' : function () {
//                        var value = $(this).val();
//                        $(this).closest('.range').find('.value-display').text(value);
//                    },
//                    'mousedown' : function () {
//                        var value = $(this).val();
//                        $(this).closest('.range').find('.value-display').text(value);
//                    }
//                });
                $filterImg.on('click', function () {
                    $filterImg.removeClass('active');
                    $(this).addClass('active');
                });
            }
        },
        showPopup: function () {

            // Pop up share
            $('.nbd-show-popup-share').on('click', function () {
                $('.nbd-popup.popup-share').nbShowPopup();
                $('.nbd-popup.popup-share').find('.overlay-main').addClass('active');
            });

            // Popup file type
            $('.nbd-show-popup-fileType').on('click', function () {
                $('.nbd-popup.popup-fileType').nbShowPopup();
            });

            // Popup term
            $('.nbd-term .term-read').on('click', function () {
                $('.nbd-popup.popup-term').nbShowPopup();
            });

            // Popup select
            $('.nbd-stages .icon-nbd-refresh').on('click', function () {
                $('.nbd-popup.popup-select').nbShowPopup();
            });

            // Popup keyboard
            $('.nbd-sidebar .keyboard-shortcuts i').on('click', function () {
                $('.nbd-popup.popup-keyboard').nbShowPopup();
                $('.nbd-popup.popup-keyboard .nbd-tabs').nbTab();
            });

            // popup save tempalte
            $('.nbd-main-bar #save-template').on('click', function () {
                $('.nbd-popup.popup-template').nbShowPopup();
            });

        },
        actionPopupShare: function () {
            var $socialSare = $('.popup-share .socials .social');
            $socialSare.on('click', function () {
                $socialSare.removeClass('active');
                if (!$(this).hasClass('active')) {
                    $(this).addClass('active');
                }
            });
        },

        actionShowPreview: function () {
            var $iconShowPreview = $('.nbd-sidebar #tab-product .nbd-product .product-more-info');
            var $sidebarPreview = $('.nbd-sidebar .nbd-sidebar-preview')
            $iconShowPreview.on('click', function () {
                if ($sidebarPreview.hasClass('show')) {
                    $sidebarPreview.removeClass('show');
                }else {
                    $sidebarPreview.addClass('show');
                }
            });
            $sidebarPreview.find('.close-preview').on('click', function () {
                $sidebarPreview.removeClass('show');
            });
        },
//        animateStart: function () {
//            var $toolBar = $('#design-container .nbd-toolbar');
//            var $mainBar = $('#design-container .nbd-main-bar');
//            var $sideBar = $('#design-container .nbd-sidebar');
//            var $sideBarTab = $('#design-container .nbd-sidebar .tabs-nav');
//            var $sideBarTabContent = $('#design-container .nbd-sidebar .tabs-content');
//
//            $(window).on('load', function () {
////                if (!checkMobileDevice()) {
////                    $sideBarTabContent.addClass('animated slideInDown');
////                }
////                $mainBar.find('.menu-item').each(function (i) {
////                    i += 3;
////                    $(this).addClass('animated slideInDown animate' + i * 100);
////                });
////                $sideBarTab.find('.tab').each(function (i) {
////                    i += 3;
////                    $(this).addClass('animated slideInLeft animate' + i * 100);
////                });
//            });
//        },
        responsive: function () {
            if (checkMobileDevice()) {
                var $mainTab = $('.nbd-sidebar .main-tabs');
                var $tabs = $('.nbd-sidebar .main-tabs .tab');
                var $menuMobile = $('.nbd-main-bar .menu-mobile');
                var $tabContent = $('.nbd-sidebar .tabs-content .tab');
                var $tabMainContent = $('.nbd-sidebar .tabs-content .tab .tab-main');
                var isRtl = checkRtl();

                // Sidebar Tab
                $menuMobile.on('click', function () {
                    var $mainMenus = $('.nbd-main-bar .nbd-main-menu');
                    if ($(this).hasClass('icon-nbd-menu')) {
                        $(this).removeClass('icon-nbd-menu').addClass('icon-nbd-clear');
                        $mainMenus.each(function (i) {
                            if ($(this).hasClass('menu-left')) {
                                $(this).show();
                            }else {
                                $(this).hide();
                            }
                        });
                    }else{
                        $(this).removeClass('icon-nbd-clear').addClass('icon-nbd-menu');
                        $mainMenus.each(function (i) {
                            if ($(this).hasClass('menu-left')) {
                                $(this).hide();
                            }else {
                                $(this).show();
                            }
                        });
                    }
                });

                // swipe
                $tabMainContent.on({
                    'swiperight': function () {
                        // left to right
                        var $tabCur = $(this).closest('.tab');
                        var nthTab = $tabCur.prev().index();
                        var curSl = (isRtl) ? $mainTab.scrollLeft() : $mainTab.scrollLeft();
                        var tabW = $('.nbd-sidebar .main-tabs .tab').eq(nthTab-1).width();
                        if ($tabCur.hasClass('tab-first')) {
                            return;
                        }
                        if (isRtl) {
                            $mainTab.animate({scrollLeft: curSl + tabW}, 300);
                        }else{
                            $mainTab.animate({scrollLeft: curSl - tabW}, 300);
                        }
                        $('.nbd-sidebar .main-tabs .tab').eq(nthTab-1).triggerHandler('click');
                    },
                    'swipeleft': function () {
                        // right to left
                        var $tabCur = $(this).closest('.tab');
                        var nthTab = $tabCur.next().index()
                        var curSl = $mainTab.scrollLeft();
                        var tabW = $('.nbd-sidebar .main-tabs .tab').eq(nthTab-1).width();
                        if ($tabCur.hasClass('tab-last')) {
                            return;
                        }
                        if (isRtl) {
                            $mainTab.animate({scrollLeft: curSl - tabW}, 300);
                        }else {
                            $mainTab.animate({scrollLeft: curSl + tabW}, 300);
                        }
                        $('.nbd-sidebar .main-tabs .tab').eq(nthTab-1).triggerHandler('click');
                    }
                });
            }
        }
    };
    $.fn.nbdDropdown = function (options) {
        var sefl = this;
        var defaults = {
            'getServer': {},
            // Item in 1 row
            'itemInRow': 3,
            // Margin Item
            'itemDistance' : 10
        };

        var opts = $.extend({}, $.fn.nbdDropdown.default, options);
        this.initPositionItem = function (items, item, itemInRow, itemDistance) {

            var leftItem = items.width() / itemInRow;
            var topItem = item.height() + itemDistance;
            item.show();
            item.each(function () {
                var index = $(this).index();
                var indexMod = index % itemInRow;
                var indexI = parseInt(index / itemInRow);
                $(this).css({
                    'left': leftItem * indexMod + 'px',
                    'top' : topItem * indexI + 'px'
                });
            });

        };
        return this.each(function () {
            var self = this;
            var $items = $(this).find('.items');
            var $item = $(this).find('.item');
            var $mainItems = $(this).find('.main-items');
            var $resultLoaded = $(this).find('.result-loaded');
            var $galleryItem = $(this).find('.nbdesigner-gallery');
            var $infoSupport = $(this).find('.info-support');
            var $tabScroll = $(this).closest('.tab-scroll');
            var $contentItem = $(this).find('.result-loaded .content-item');
            var noItem = $item.length;
            var noItemRow = parseInt(noItem / opts.itemInRow);
            var itemHeight = $item.outerHeight() + opts.itemDistance;
            var $loadingGif = $(this).find('.loading-photo');
            var isMasonry = false;
            // ========================= Main================================================
            // init items
            sefl.initPositionItem($items, $item, opts.itemInRow, opts.itemDistance);
            // set height for content cate
            $mainItems.css({
                'height': noItemRow * itemHeight + 'px'
            });
            $item.on('click', function () {
                var indexItem = $(this).index();
                var indexItemRow = parseInt(indexItem / opts.itemInRow) + 1;
                var widthItem = $(this).outerWidth();
                var itemName = $(this).find('.item-name').text();
                var dataType = $(this).attr('data-type');
                var dataApi = $(this).attr('data-api');

                if (dataType == 'webcam') {
                    var $popupWebcam = $('.nbd-popup.popup-webcam');
                    $popupWebcam.addClass('nb-show');
                    return false;
                }

                $infoSupport.find('span').text(itemName);
                // Set height for categories
                $mainItems.css({
                    'height': indexItemRow * (itemHeight - 15) + 'px'
                });
                $mainItems.find('.pointer').css({
                    'left': ((widthItem) * (indexItem % opts.itemInRow + 1) - widthItem / 2)  + 'px'
                });
                if (dataApi == 'false') {
                    $resultLoaded.show().addClass('overflow-visible');
                    $contentItem.filter(function (index) {
                        return $(this).attr('data-type') === dataType;
                    }).show().find('input[type="text"]').first().focus();
                    $galleryItem.hide();
                    if (!$mainItems.hasClass('active-expanded')) {
                        $(this).siblings().css({
                            'opacity': '0.5'
                        });
                        $mainItems.addClass('active-expanded');
                        $resultLoaded.addClass('loaded');
                        var nextAllItem = $items.find('.item:nth-child(' + indexItemRow * opts.itemInRow + ')').nextAll();
                        $(nextAllItem).each(function () {
                            $(this).hide();
                        });
                    }else {
                        $(this).css({
                            'opacity': '1'
                        });
                        $(this).siblings().css({
                            'opacity': '1'
                        });
                        $mainItems.removeClass('active-expanded');
                        sefl.initPositionItem($items, $item, opts.itemInRow, opts.itemDistance);
                        $resultLoaded.hide();
                        $contentItem.hide();
                        $resultLoaded.removeClass('loaded');
                    }
                    $infoSupport.find('.close-result-loaded').on('click', function () {
                        $mainItems.removeClass('active-expanded');
                        sefl.initPositionItem($items, $item, opts.itemInRow, opts.itemDistance);
//                        $resultLoaded.find('.nbdesigner-gallery').empty();
                        $resultLoaded.hide();
                        $contentItem.hide();
                        $item.show().css({'opacity' : '1'});
                        $resultLoaded.removeClass('loaded');
                        $tabScroll.scrollTop(0);
                        $infoSupport.removeClass('slideInDown animated show');
                    });
                }else {
                    $resultLoaded.removeClass('overflow-visible');
                    if (!$mainItems.hasClass('active-expanded')) {
                        $(this).siblings().css({
                            'opacity': '0.5'
                        });
                        var nextAllItem = $items.find('.item:nth-child(' + indexItemRow * opts.itemInRow + ')').nextAll();
                        $(nextAllItem).each(function () {
                            $(this).hide();
                        });
                        $resultLoaded.show();
                        $galleryItem.show();
                        $mainItems.addClass('active-expanded');
                        $resultLoaded.addClass('loaded');
                    }else {
                        $(this).css({
                            'opacity': '1'
                        });
                        $(this).siblings().css({
                            'opacity': '1'
                        });
                        $mainItems.removeClass('active-expanded');
                        sefl.initPositionItem($items, $item, opts.itemInRow, opts.itemDistance);
//                        $resultLoaded.find('.nbdesigner-gallery').empty();
                        $resultLoaded.hide();
                        $resultLoaded.removeClass('loaded');
                        $galleryItem.hide();
                        $contentItem.hide();

                    }

                    // Event click in close result
                    $infoSupport.find('.close-result-loaded').on('click', function () {
                        $mainItems.removeClass('active-expanded');
                        sefl.initPositionItem($items, $item, opts.itemInRow, opts.itemDistance);
//                        $resultLoaded.find('.nbdesigner-gallery').empty();
                        $resultLoaded.hide();
                        $item.show().css({'opacity' : '1'});
                        $resultLoaded.removeClass('loaded');
                        $tabScroll.scrollTop(0);
                        $infoSupport.removeClass('slideInDown animated show');
                    });

                    return false;
                }

            });
        });

    };
    $.fn.nbdColorPalette = function (options) {
        var defaults = {};
        var opts = $.extend({}, $.fn.nbdColorPalette.defaults, options);
        return this.each(function () {
            var sefl = this;
            var $colorPalette = $('#nbd-color-palette');
            $(this).on('click', function (e) {
                var posL = $(this).offset().left;
                var toolbarL = $('.nbd-toolbar').offset().left;

                $('.nbd-main-menu .menu-item').removeClass('active');
                $colorPalette.css({
                    'left' : (posL - toolbarL) + 'px'
                });
                if(!$(this).hasClass('nbd-show')){
                    $('.nbd-show-color-palette').removeClass('nbd-show');
                    $colorPalette.addClass('show');
                    $(this).addClass('nbd-show');
                }else{
                    $colorPalette.removeClass('show');
                    $(this).removeClass('nbd-show');
                };
            });
        });
    };
    /**
     *
     * @desc Component Tab
     * @version 2.0.0
     * @author Netbase Online Design Team
     */
    $.fn.nbTab = function () {
        return this.each(function () {
            var $tab = $(this).find('.nbd-tab');
            var $tabContent = $('.nbd-tab-contents .nbd-tab-content');
            $tab.on('click', function () {
                var tabId = $(this).attr('data-tab');
                $tab.removeClass('active');
                $(this).addClass('active');
                $tabContent.removeClass('active');
                $('.nbd-tab-contents #' + tabId).addClass('active')
                $('.nbd-tab-contents .tab-scroll').stop().animate({
                    scrollTop: 0
                }, 100);
            });
        });
    };

    /**
     *  @author Netbase Online Design Team
     */
    $.fn.nbShowPopup = function () {
        return this.each(function () {
            var sefl = this;
            var $close = $(this).find('.overlay-popup, .close-popup');
            if (!$(this).hasClass('nb-show')) {
                $(this).addClass('nb-show');
            }
            $close.on('click', function () {
                $(sefl).removeClass('nb-show');
            });
        });
    };
    /**
     *
     * @param text
     * @version 2.0.0
     * @author Netbase Online Design Team
     */
    $.fn.nbToasts = function () {
        return this.each(function () {
            var $toast = $(this).find('.toast');
            var sefl = $(this);
            $(this).addClass('nbd-show');
            $toast.addClass('nbSlideInUp');
            $toast.find('.nbd-close-toast').on('click', function () {
                $toast.removeClass('nbSlideInUp').addClass('nbSlideInDown');
                $toast.bind('webkitAnimationEnd oanimationend msAnimationEnd animationend', function () {
                    sefl.removeClass('nbd-show');
                });
            });
            if(t) clearTimeout(t);
            var t = setTimeout(function () {
                if( sefl.hasClass('nbd-show') ){
                    $toast.removeClass('nbSlideInUp').addClass('nbSlideInDown');
                    $toast.bind('webkitAnimationEnd oanimationend msAnimationEnd animationend', function () {
                        sefl.removeClass('nbd-show');
                    });
                }else{
                    clearTimeout(t);
                }
            }, 3000);
        });
    };
    /**
     *
     * @param text
     * @version 2.0.0
     * @author Netbase Online Design Team
     */
    $.fn.nbWarning = function (text) {
        return this.each(function () {
            var $itemWarning = $(this).find('.item');
            $(this).addClass('nbd-show');
            if ($itemWarning.length < 3) {
                var htmlWaring = '<div class="item animate300 animated nbScaleOut main-warning nbd-show">' +
                    '<i class="icon-nbd icon-nbd-baseline-warning warning"></i>' +
                    '<span class="title-warning">'+ text +'</span>' +
                    '<i class="icon-nbd icon-nbd-clear close-warning"></i>' +
                    '</div>';
                var $warning = $(htmlWaring);
                var $close = $warning.find('.close-warning');
                $(this).append($warning);
                $close.on('click', function () {
                    $warning.removeClass('nbScaleOut').addClass('nbScaleIn');
                    $warning.bind('webkitAnimationEnd oanimationend msAnimationEnd animationend', function () {
                        $warning.remove();
                    });
                });

                setTimeout(function () {
                    $warning.removeClass('nbScaleOut').addClass('nbScaleIn');
                    $warning.bind('webkitAnimationEnd oanimationend msAnimationEnd animationend', function () {
                        $warning.remove();
                    });
                }, 10000);

            }

        });
    };
    $(document).ready(function () {
//        var $loadingPage = $('.nbd-load-page');
//        $loadingPage.hide();
        modern.init();

//        $('.nbd-navigations .logo').on('click', function () {
//            $('.nbd-toasts').nbToasts('I am a toast');
//            $('.nbd-warning').nbWarning('warning');
//        });
        $('.nbd-tooltip-hover').tooltipster({
            side: "top",
            theme: 'tooltipster-borderless',
        });
        $('.nbd-tooltip-hover-left').tooltipster({
            side: "left",
            theme: 'tooltipster-borderless',
        });

        $('#toolbar-font-size-dropdown,#toolbar-font-familly-dropdown, .nbd-sidebar .tab-scroll,.nbd-popup .tab-scroll, .nbd-perfect-scroll').perfectScrollbar();
        $('.nbd-show-color-palette').nbdColorPalette();
        var width = jQuery(window).width();
        if(width > 767 && width <= 1024){
            jQuery('.main-tabs .tab').on('click', function(){
                jQuery('.nbd-sidebar').addClass('is_open');
            });
            jQuery('.hide-tablet').on('click', function(){
                jQuery('.nbd-sidebar').removeClass('is_open');
            });
        };
        jQuery('.popup-webcam .close-popup, .popup-webcam .overlay-popup').on('click', function(){
            jQuery('.popup-webcam').removeClass('nb-show');
        });
    });
    function checkRtl() {
        var isRtl = false;
        if ($('body').hasClass('nbd-modern-rtl')) {
            isRtl = true;
        }
        return isRtl;
    }
})(jQuery);