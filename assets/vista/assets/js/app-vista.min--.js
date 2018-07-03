/* nbdesignerjs
 * @author  netbaseteam
 * @link https://cmsmart.net
 * @version 1.9.0
 * @created Jun 2016
 * @modified 23, May 2018
 * */
var nbdApp = angular.module('nbd-app', ["angularSpectrumColorpicker"]);
nbdApp.constant("_", window._);
nbdApp.controller('designCtrl', ['$scope', 'FabricWindow', '$window', 'NBDDataFactory', 'filterFontFilter', 'filterArtFilter', '$timeout', '$http', '$document',
    function($scope, FabricWindow, $window, NBDDataFactory, filterFontFilter, filterArtFilter, $timeout, $http, $document){
        $scope.stages = [];
        $scope.defaultStageStates = {
            isActiveLayer: false,
            isLayer: false,
            isGroup: false,
            isText: false,
            isImage: false,
            isPath: false,
            isShape: false,
            isEditing: false,
            isRedoable: false,
            isUndoable: false,
            boundingObject: {},
            coordinates: {},
            rotate: {},
            opacity: 100,
            snaplines: {},
            itemId: null,
            tempParameters: null,
            usedFonts: [],
            type: null,
            text: {
                fontFamily: {
                    alias: 'Roboto',
                    r: 1,
                    b: 1,
                    i: 1,
                    bi: 1
                },
                fontSize: 14,
                fontFamily: 'Roboto',
                textAlign: 'left',
                fontWeight: false,
                textDecoration: false,
                fontStyle: '',
                spacing: 0,
                lineHeight: 1.2,
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
            bgType: 'color',
            bgColor: '#ffffff',
            bgImage: 0,
            showBleed: 0,
            showOverlay: 0,
            showSafeZone: 0
        };
        $scope.initSettings = function(){
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
            $scope.showTextColorPicker = false;
            $scope.showBgColorPicker = false;
            $scope.__colorPalette = __colorPalette;
            $scope.currentColor = '#fff';
            $scope.listAddedColor = [];
            $scope.tempStageDesign = null;

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
                upload: {filter: {perPage: 10, currentPage: 1, total: 0}, data: [], onload: false, init: true},
                element: {onclick: false, onload: false, contentSearch: ''},
                shape: {filter: {perPage: 20, currentPage: 1, totalPage: 0}, data: [], init: true, onload: false},
                icon: {filter: {perPage: 20, currentPage: 1, totalPage: 0}, data: [], init: true, onload: false},
                line: {filter: {perPage: 20, currentPage: 1, totalPage: 0}, data: [], init: true, onload: false}
            };
            $scope.includeExport = ['objectCaching', 'itemId', 'selectable', 'lockMovementX', 'lockMovementY','lockScalingX', 'lockScalingY', 'lockRotation', 'rtl', 'elementUpload', 'forceLock', 'isBg','is_uppercase','available_color','available_color_list','color_link_group','isOverlay', 'isAlwaysOnTop'];

            $scope.resource.font.data = $scope.settings.fonts;
            // if(!_.filter($scope.resource.font.data, ['alias', $scope.settings.default_font.alias]).length){
            //     $scope.resource.font.data.push($scope.settings.default_font);
            // };
            $scope.resource.templates = $scope.settings.templates;
            // $scope.resource.font.filter.total = $scope.resource.font.data.length;
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
        $scope.addColor = function(){
            $scope.listAddedColor.push($scope.currentColor);
            $scope.listAddedColor = _.uniq($scope.listAddedColor);
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
        $scope.isModern = true;
        $scope.init = function() {
            if(typeof nbd_window.NBDESIGNERPRODUCT != 'undefined'){
                nbd_window.NBDESIGNERPRODUCT.hide_loading_iframe();
            };
            $scope.isTemplateMode = NBDESIGNCONFIG.task === 'create' || (NBDESIGNCONFIG.task == 'edit' && NBDESIGNCONFIG.design_type == 'template' );
            $scope.localStore.init();
            $scope.initSettings();
            $scope.contextAddLayers = 'normal';
            $scope.workBenchHeight = $window.innerHeight;
            $scope.workBenchWidth = $window.innerWidth;
            $timeout(function(){
                jQuery('.nbd-load-page').hide();
            });
            var _window = angular.element($window);
            _window.bind('resize', function(){
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
            if( $scope.settings.nbdesigner_cache_uploaded_image == 'yes' ){
                $scope.resource.upload.data = $scope._localStorage.get('nbduploaded');
            };
        };
        /* Util */
        $scope.localStore = {
            db: null,
            ready: false,
            init: function(){
                var self = this;
                var indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB || window.shimIndexedDB;
                var open = indexedDB.open("NBDesigner", 1);
                open.onsuccess = function (e) {
                    self.db = e.target.result;
                    self.ready = true;
                };
                open.onupgradeneeded = function(event){
                    var db =  event.target.result;
                    var objectStore = db.createObjectStore("designs", { keyPath: "id" });
                };
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
                        if(event.target.result) {
                            if(typeof callback == 'function') callback(event.target.result);
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
                if( type == 'nbduploaded') value = JSON.stringify($scope.resource.upload.data);
                localStorage.setItem(type, value);
            },
            get: function(type){
                var data = localStorage.getItem(type);
                if( data ){
                    return JSON.parse(data);
                }else{
                    return [];
                }
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
                    if($scope.resource[tab].onclick){
                        $scope.renderMasonryList(type, '#nbd-'+type+'-wrap .mansory-wrap', '.mansory-item', '#nbd-'+type+'-wrap', $scope.resource[type].init);
                    }
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
                    break;
                default:
                    //todo
                    break;
            };
        };
        $scope.getMedia = function(type, context){
            jQuery('#tab-element .loading-photo').show();
            $scope.resource.element.type = type;
            if( $scope.resource.element.type != type || context == 'search' ){
                $scope.resource[type].data = [];
                $scope.resource[type].filter.total = 0;
                $scope.resource[type].filter.currentPage = 1;
                //jQuery('#tab-element .content-items').css('height', 0);
                jQuery("#tab-element .tab-scroll").stop().animate({
                    scrollTop: jQuery('.main-items').height()
                }, 100);
            };
            $scope.resource.element.type = type;
            var category = type == 'shape' ? 66 : (type == 'line' ? 78 : 73);
            var search = type == 'icon' ? $scope.resource.element.contentSearch : '';
            $http({
                method: 'GET',
                url: 'https://media.printcart.com/v1/clipart?limit=20&category=' + category + '&search=' + search + '&start=' + ($scope.resource[type].filter.currentPage-1) * 20
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
                                    url: val.urls.raw,
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
                    // $scope.resource.dropbox.data = _.uniqBy($scope.resource.dropbox.data, 'id');
                    // console.log($scope.resource.dropbox.data);
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
                    _.each($scope.resource.clipart.data.cat, function(cat, key) {
                        cat.amount = 0;
                        _.each($scope.resource.clipart.data.arts, function(art, k) {
                            art.url = art.url.indexOf("http") > -1 ? art.url : NBDESIGNCONFIG['art_url'] + art.url;
                            if (art.cat.length == 0) art.cat = ["0"];
                            if ( _.includes(art.cat, cat.id) ) cat.amount++
                        });
                    });
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
        $scope.getProduct = function(){
            //todo
        };
        /* Upload Image */
        $scope.uploadFile = function(files){
            //check file
            var file = files[0],
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
            $scope.toggleStageLoading();
            NBDDataFactory.get('nbdesigner_customer_upload', {file: file}, function(data){
                var data = JSON.parse(data);
                if( data.flag == 1 ){
                    $scope.addImage(data.src, false, true );
                    $scope.storeUploadFile(data.src, data.name);
                    jQuery("#tab-photo .tab-scroll").stop().animate({
                        scrollTop: jQuery("#tab-photo .tab-scroll").prop("scrollHeight")
                    }, 100);
                    localStorage.setItem('uploaded', $scope.resource.upload.data);
                    $scope.onEndRepeat('upload');
                }else{
                    $scope.toggleStageLoading();
                    alert(data.mes);
                }
            });
        };
        $scope.storeUploadFile = function(src, name){
            $scope.resource.upload.data.push({
                url: src,
                des: name
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
            }
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
                            if(popup.location.hash.length){
                                clearInterval(interval);
                                $scope.settings['is_logged'] = 1;
                                popup.close();
                                $scope.updateApp();
                                if(typeof callback == 'function') callback();
                            }
                        }
                    } catch (evt) {
                        //permission denied
                    }
                }, 100);
            }
        };
        /* Extenal Image */
        $scope.addImageFromUrl = function( url, extenal ){
            if( url == '' ) return;
            $scope.toggleStageLoading();
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
                $scope.addImage(url, false, true);
            }
        };
        $scope.stageOnload = false;
        $scope.toggleStageLoading = function(){
            jQuery('.loading-workflow').toggleClass('nbd-show');
            jQuery('body').toggleClass('nbd-onloading');
            if( jQuery('.loading-workflow').hasClass('nbd-show') ){
                $scope.stageOnload = true;
                promise = $timeout(function(){
                    if( $scope.stageOnload ){
                        jQuery('.loading-workflow').toggleClass('nbd-show');
                        jQuery('body').toggleClass('nbd-onloading');
                    }
                }, 20000);
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
                    //todo something
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
        $scope.renderMasonryList = function(type, container, item, scrollContainer, init){
            imagesLoaded( jQuery(container), function() {
                if( !init ) jQuery(container).masonry('destroy');
                jQuery(container).masonry({
                    itemSelector: item
                });
                jQuery.each(jQuery(container + ' ' +item), function(e) {
                    var animate = Math.floor(Math.random() * 10);
                    animate = (animate + 1) * 100;
                    if( checkMobileDevice() ){
                        jQuery(this).addClass("in-view");
                    }else{
                        jQuery(this).addClass("in-view slideInDown animated animate" + animate);
                    }
                });
                // jQuery(scrollContainer+' .tab-scroll').perfectScrollbar('update');
                jQuery('.nbd-vista .tab-scroll').perfectScrollbar('update');
                $timeout(function(){
                    jQuery(scrollContainer + ' .loading-photo').hide();
                }, 100);
                $scope.resource[type].onload = false;
                $scope.resource[type].init = false;
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
                jQuery("#tab-element .tab-scroll").stop().animate({
                    scrollTop: jQuery('#tab-element .main-items').height()
                }, 100);
                return;
            };
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
                return NBDESIGNCONFIG['plg_url'] + '/data/typography/store/' + typo.folder + '/preview.png';
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
        $scope.saveData = function(type){
            if( angular.isUndefined(type) ) type = $scope.settings.task;
            if(type != 'share' ) $scope.toggleStageLoading();
            if(type == 'typography') $scope.resource.usedFonts = [];
            if(type != 'saveforlater' && type != 'share' ) $scope.maybeZoomStage = true;
            $scope.saveDesign();
            $scope.resource.config.viewport = $scope.calcViewport();
            $scope.resource.config.product = NBDESIGNCONFIG['product_data'].product;
            var dataObj = {};
            dataObj.used_font = new Blob([JSON.stringify($scope.resource.usedFonts)], {type: "application/json"});
            dataObj.design = new Blob([JSON.stringify($scope.resource.jsonDesign)], {type: "application/json"});
            _.each($scope.stages, function(stage, index){
                var key = 'frame_' + index,
                    svg_key = 'frame_' + index + '_svg';
                dataObj[key] = $scope.makeblob(stage.design);
                dataObj[svg_key] = new Blob([stage.svg], {type: "image/svg"});
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
                case 'saveforlater':
                default:
                    ['product_id', 'variation_id', 'task', 'task2', 'design_type', 'nbd_item_key', 'cart_item_key', 'order_id', 'enable_upload_without_design', 'auto_add_to_cart'].forEach(function(key){
                        dataObj[key] = NBDESIGNCONFIG[key];
                    });
                    if( type == 'share' ) dataObj['share'] = 1;
                    dataObj['nbd_file'] = '';
                    dataObj.config = new Blob([JSON.stringify($scope.resource.config)], {type: "application/json"});
                    $timeout(function(){
                        var action = ( type != 'share' && NBDESIGNCONFIG.task == 'new' && NBDESIGNCONFIG.ui_mode == 2 ) ?  'nbd_save_cart_design' : 'nbd_save_customer_design';
                        NBDDataFactory.get(action, dataObj, function(data){
                            data = JSON.parse(data);
                            if(data.flag == 'success'){
                                if( type == 'saveforlater' ){
                                    var _dataObj = {product_id: NBDESIGNCONFIG.product_id, variation_id: NBDESIGNCONFIG.variation_id, folder: data.folder};
                                    NBDDataFactory.get('nbd_save_for_later', _dataObj, function(_data){
                                        _data = JSON.parse(_data);
                                        $scope.toggleStageLoading();
                                        return;
                                    });
                                } if( type == 'share' ) {
                                    $scope.resource.social.folder = data.sfolder;
                                    jQuery('.nbd-popup.popup-share').find('.overlay-main').removeClass('active');
                                    return;
                                }else{
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
            link = link.substr(0, link.indexOf('&text=') + 7) + $scope.resource.social.comment;
            $scope.resource.social.link = link;
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
            if (!jQuery($event.target).hasClass('color-palette-add') && $scope.showTextColorPicker
                && $textPicker.has($event.target).length == 0 && !$textPicker.is($event.target)){
                $scope.showTextColorPicker = false;
            };
            if( !jQuery($event.target).hasClass('color-palette-add') && $scope.showBgColorPicker && $bgPicker.has($event.target).length == 0 && !$bgPicker.is($event.target) ){
                $scope.showBgColorPicker = false;
            }
        };
        /* Hotkeys */
        $scope.keypressHandle = function(e){
            var targetEl = e.target.tagName.toUpperCase();
            if( targetEl == 'INPUT' || targetEl == 'TEXTAREA' ||  $scope.stages[$scope.currentStage].states.isEditing ) return;
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
                                _states.text.fontSize -= 1;
                                $scope.setTextAttribute('fontSize', _states.text.fontSize);
                            }
                            $scope.updateApp();
                            break;
                        case 190:
                            /* Hold Ctrl + Shift + > → Increate font size*/
                            if( _states.isText ){
                                _states.text.fontSize += 1;
                                $scope.setTextAttribute('fontSize', _states.text.fontSize);
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
                            /* Hold Ctrl press G → Toggle Grid */
                            $scope.settings.showGrid = !$scope.settings.showGrid;
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
            if( last ){
                if( !$scope.isTemplateMode ){
                    $timeout(function(){
                        if( angular.isDefined($scope.settings.product_data.design) ){
                            $scope.insertTemplate(true, {fonts: $scope.settings.product_data.fonts, design: $scope.settings.product_data.design, viewport: $scope.settings.product_data.config.viewport});
                        }else{
                            if( $scope.settings.nbdesigner_save_latest_design == 'yes' ){
                                var pid = NBDESIGNCONFIG['product_id'] + '-' + NBDESIGNCONFIG['variation_id'];
                                $scope.localStore.get(pid, function(data){
                                    if(data){
                                        $scope.insertTemplate(true, {fonts: data.data.fonts, design: data.data.design, viewport: data.data.config.viewport});
                                    }
                                });
                            }
                        }
                    });
                }
            }
        });
        $scope.calcViewport = function(){
            var _offsetWidth = checkMobileDevice() ? 20 : 100,
                _offsetHeight = checkMobileDevice() ? 70 : 100,
                _width = jQuery('.nbd-stages').width() - _offsetWidth,
                _height = jQuery('.nbd-stages').height() - _offsetHeight;
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
            var viewPort = $scope.calcViewport(),
                scaleRange = [0.1, 0.25, 0.3, 0.5, 0.75, 1, 1.25, 1.5, 1.75, 2, 3, 4, 5];
            _.each($scope.settings.product_data.product, function(side, index){
                var _width = side.product_width * $scope.rateConvert2Px,
                    _height = side.product_height * $scope.rateConvert2Px,
                    designViewPort = $scope.fitRectangle(viewPort.width, viewPort.height, _width, _height, true),
                    fillScale = _width / designViewPort.width,
                    minScale = 200 / Math.max(_width, _height),
                    maxScale = 5000 / Math.max(_width, _height),
                    screenViewPort = $scope.fitRectangle(screen.width, screen.height, _width, _height, true),
                    fullScreenScale = screenViewPort.width / designViewPort.width;
                var _scaleRange = scaleRange.filter(function(item){
                    return item > minScale && item < maxScale;
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
                        showSafeZone: side.show_safe_zone
                    },
                    states: {},
                    undos: [],
                    redos: [],
                    layers: [],
                    canvas: {}
                };
                var _state = $scope.stages[index].states;
                angular.copy($scope.defaultStageStates, _state);
                _scaleRange.forEach(function(value){
                    value != 1 && _state.scaleRange.push({ratio: value, value: (value * 100).toFixed() + '%', label: (value * 100).toFixed() + '%'});
                });
                _state.scaleRange.push({ratio: 1, value: '100%', label: 'Fit'});
                _state.scaleRange.push({ratio: fullScreenScale, value: (fullScreenScale * 100).toFixed() + '%', label: (fullScreenScale * 100).toFixed() + '%'});
                if( fillScale > minScale && fillScale < maxScale  ) _state.scaleRange.push({ratio: fillScale, value: (fillScale * 100).toFixed() + '%', label: 'Fill'});
                _state.scaleRange = _.sortBy(_state.scaleRange, [function(o) { return o.ratio; }]);
                _state.currentScaleIndex = _.findIndex(_state.scaleRange, function(o) { return o.ratio == 1; });
                _state.fitScaleIndex = _.findIndex(_state.scaleRange, function(o) { return o.label == 'Fit'; });
                _state.fillScaleIndex = _.findIndex(_state.scaleRange, function(o) { return o.label == 'Fill'; });
                _state.fullScreenScaleIndex = _.findIndex(_state.scaleRange, function(o) { return o.ratio == fullScreenScale; });
            });
            if( $scope.settings.task == 'typography'){
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
                angular.copy($scope.defaultConfig, $scope.stages[0].config);
                angular.merge($scope.stages[0].states, $scope.defaultStageStates);
            };
        };
        $scope.initStageSetting = function( id ){
            var _canvas = $scope.stages[id]['canvas'];
            $scope.setStageDimension(id);
            _canvas.calcOffset().renderAll();
            $scope.updateApp();
        };
        $scope.addStage = function(){
            $scope.stages.push({canvas: {}});
        };
        $scope.setStageDimension = function(id){
            id = angular.isDefined(id) ? id : $scope.currentStage;
            var _stage = $scope.stages[id];
            var currentWidth = _stage.config.width * _stage.states.scaleRange[_stage.states.currentScaleIndex].ratio,
                currentHeight = _stage.config.height * _stage.states.scaleRange[_stage.states.currentScaleIndex].ratio;
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
            if($scope.isModern){
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

        };
        $scope.onObjectAdded = function(id, options){
            var _canvas = this.stages[$scope.currentStage]['canvas'],
                item = options.target,
                d = new Date(),
                itemId = d.getTime() + Math.floor(Math.random() * 1000);
            if( $scope.contextAddLayers == 'normal' || $scope.contextAddLayers == 'copy' || $scope.contextAddLayers == 'template' ){
                item.set({"itemId" : itemId});
            };
            if( $scope.contextAddLayers == 'normal' && !$scope.resource.drawMode.status ){
                _canvas.viewportCenterObject(item);
            }
            item.setCoords();
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
            if(!$scope.onloadTemplate) $scope.contextAddLayers = 'normal';
            if( checkMobileDevice() ){
                jQuery('#design-tab').triggerHandler('click');
            };
            $scope.updateLayersList();
        };
        $scope.onObjectScaling = function(id, options){
            var item = options.target;
            if(item) item.setCoords();
            $scope.updateCoordenatesLabel(item);
            $scope.updateBoundingRect(item);
            $scope.updateSnapLines();
            $scope.updateApp();
        };
        $scope.onObjectMoving = function(id, options){
            var item = options.target;
            if(item) item.setCoords();
            $scope.updateCoordenatesLabel(item);
            $scope.updateBoundingRect(item);
            $scope.updateSnapLines();
            $scope.updateApp();
        };
        $scope.onObjectRotating = function(id, options){
            var item = options.target;
            if(item) item.setCoords();
            $scope.updateCoordenatesLabel(item);
            $scope.updateBoundingRect(item);
            $scope.updateSnapLines();
            $scope.updateAngleLabel(item);
            $scope.updateApp();
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
        $scope.onObjectModified = function(id, options){
            var item = options.target;
            if( $scope.stages[$scope.currentStage].tempParameters ){
                $scope.setHistory({
                    element: item,
                    parameters: $scope.stages[$scope.currentStage].tempParameters,
                    interaction: 'modify'
                });
                $scope.stages[$scope.currentStage].tempParameters = null;
            }
        };
        $scope.onBeforeRender = function(id, options){

        };
        $scope.onAfterRender = function(id, options){

        };
        $scope.onSelectionCleared = function(id, options){
            $scope.stages[$scope.currentStage].states.isActiveLayer = false;
            $scope.stages[$scope.currentStage].states.itemId = null;
            $scope.stages[$scope.currentStage].states.isEditing = false;
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
        };
        $scope.onSelectionUpdated = function(id, options){
            $scope.getCurrentLayerInfo();
        };
        $scope.onSelectionCreated = function(id, options){
            $scope.getCurrentLayerInfo();
        };
        $scope.onTextChanged = function(id, options){
            var item = options.target;
            if( item ){
                $scope.updateLayersList();
            }
            $scope.updateApp();
        };
        $scope.getCurrentLayerInfo = function(){
            var _canvas = $scope.stages[$scope.currentStage]['canvas'],
                object = _canvas.getActiveObject(),
                objects = _canvas.getActiveObjects();

            $scope.stages[$scope.currentStage].states.isActiveLayer = true;
            $scope.stages[$scope.currentStage].states.isGroup = false;
            $scope.stages[$scope.currentStage].states.isLayer = false;
            $scope.stages[$scope.currentStage].states.isText = false;
            $scope.stages[$scope.currentStage].states.isImage = false;
            $scope.stages[$scope.currentStage].states.isPath = false;
            $scope.stages[$scope.currentStage].states.isShape = false;
            $scope.stages[$scope.currentStage].states.isEditing = false;

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
                    angular.copy($scope.defaultStageStates.text, $scope.stages[$scope.currentStage].states.text);
                    $scope.stages[$scope.currentStage].states.opacity = fabric.util.toFixed(object.get('opacity') * 100);
                    ['type', 'itemId', 'lockMovementX', 'lockMovementY', 'lockScalingX', 'lockScalingY', 'lockRotation', 'lockUniScaling', 'selectable', 'visible'].forEach(function(key){
                        $scope.stages[$scope.currentStage].states[key] = object.get(key);
                    });
                    switch(object.type) {
                        case 'i-text':
                        case 'text':
                        case 'curvedText':
                            $scope.stages[$scope.currentStage].states.isText = true;
                            $scope.stages[$scope.currentStage].states.isEditing = object.isEditing ? object.isEditing : false;
                            $scope.stages[$scope.currentStage].states.text = {
                                font: $scope.getFontInfo(object.get('fontFamily')),
                                is_uppercase: $scope.isUpperCase(object)
                            };
                            ['fontFamily', 'fontSize', 'textAlign', 'fontWeight', 'textDecoration', 'fontStyle', 'spacing', 'lineHeight', 'fill', 'charSpacing'].forEach(function(key){
                                $scope.stages[$scope.currentStage].states.text[key] = object.get(key);
                            });
                            break;
                        case 'image':
                        case 'custom-image':
                            $scope.stages[$scope.currentStage].states.elementUpload  = angular.isDefined(object.get('elementUpload')) ? object.get('elementUpload') : false;
                            $scope.stages[$scope.currentStage].states.isImage = true;
                            break;
                        case 'rect':
                        case 'triangle':
                        case 'line':
                        case 'polygon':
                        case 'circle':
                            $scope.stages[$scope.currentStage].states.isShape = true;
                            break;
                        case 'path-group':
                        case 'path':
                        case 'group':
                            $scope.stages[$scope.currentStage].states.isPath = true;
                            $scope.stages[$scope.currentStage].states.svg.groupPath = $scope.getPathOfSvg(object);
                            break;
                        default:
                        //
                    }
                }
            }
            $scope.updateApp();
        };
        /* Utility functions */
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
            _font.file = {r: 1};
            _font.file.i = angular.isDefined(font.file.i) ? 1 : 0;
            _font.file.b = angular.isDefined(font.file.b) ? 1 : 0;
            _font.file.bi = angular.isDefined(font.file.bi) ? 1 : 0;
            return _font;
        };
        $scope.getPathOfSvg = function(object){
            var groupPath = [];
            _.each(object._objects, function(path, index){
                if( path.get('fill') != '' ){
                    var color = tinycolor(path.get('fill')).toHexString();
                    if(  ( findex = _.findIndex(groupPath, ['color', color]) ) > -1 ){
                        groupPath[findex]['index'].push(index);
                    }else{
                        groupPath.push({color: color, index: [index]});
                    }
                }
            });
            if(groupPath.length == 0) groupPath.push({color: tinycolor(object.get('fill')).toHexString(), index: [-1]});
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
                        rec.left = (x1 * y2 - x2 * y1) / y2;
                    }else {
                        rec.width = x1;
                        rec.height = x1 * y2 / x2;
                        rec.top = (x2 * y1 - x1 * y2) / x2;
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
                rec.left = (x1 * y2 - x2 * y1) / y2;
            } else {
                rec.width = x1;
                rec.height = x1 * y2 / x2;
                rec.top = (x2 * y1 - x1 * y2) / x2;
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
            if( angular.isUndefined( temp.doNotShowLoading ) ) $scope.toggleStageLoading();
            $scope.onloadTemplate = true;
            $scope.contextAddLayers = 'template';
            function loadDesign(fonts, design, viewport){
                function loadLayers(){
                    _.each($scope.stages, function(stage, index){
                        var _index = 'frame_' + index,
                            layers = design[_index].objects,
                            _canvas = stage['canvas'];
                        _canvas.clear();
                        _canvas.loadFromJSON(design[_index], function() {
                            $scope.renderStage(index);
                            $scope.onloadTemplate = false;
                            $scope.renderTextAfterLoadFont(_canvas.getObjects(), function(){
                                $scope.deactiveAllLayer();
                                $scope.renderStage(index);
                                $timeout(function(){
                                    $scope.deactiveAllLayer();
                                    $scope.renderStage(index);
                                    if( index == $scope.stages.length - 1 ){
                                        $scope.contextAddLayers = 'normal';
                                        if( angular.isDefined(viewport) ){
                                            $scope.resizeStages(viewport);
                                        }else{
                                            $scope.toggleStageLoading();
                                        }
                                    }
                                }, 500);
                            });
                        });
                    });
                };
                if(fonts.length){
                    _.each(fonts, function(font, index){
                        if( index == fonts.length - 1 ){
                            $scope.insertTemplateFont(font.alias, function(){
                                loadLayers();
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
                    loadLayers();
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
            _.each(layers, function(item, index){
                if( ['text', 'i-text', 'curvedText'].indexOf(item.type) > -1 ){
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
                item.applyFilters(function() {
                    _canvas.renderAll()
                });
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


        };
        $scope.debug3 = function(){
            //Shape design area: circle
            var _canvas = $scope.stages[$scope.currentStage]['canvas'];
            var path = new fabric.Path("M0 0 H20 V20 H0z M 10 0 A 10 10, 0, 1, 0, 10 20 A 10 10, 0, 1, 0, 10 0z");
            path.set({strokeWidth: 0, scaleX: 15, scaleY: 15});
            _canvas.add(path);
            $scope.renderStage();
        };
        $scope.tempLayer = {};
        $scope.tempLayer1 = {};
        $scope.debug2 = function(){
            //var _canvas = $scope.stages[$scope.currentStage]['canvas'];

        };
        $scope.renderStage = function( stage_id ){
            stage_id = stage_id ? stage_id :  $scope.currentStage;
            $scope.stages[stage_id]['canvas'].calcOffset();
            $scope.stages[stage_id]['canvas'].renderAll();
        };
        $scope.deactiveAllLayer = function(stage_id){
            stage_id = stage_id ? stage_id :  $scope.currentStage;
            $scope.stages[stage_id]['canvas'].discardActiveObject();
            $scope.renderStage();
        };
        /* General */
        $scope.applyFilters = function(item, index, value, addintion){
            //do something
        };
        $scope.clearAllStage = function(){
            _.each($scope.stages, function(stage, index){
                stage.canvas.clear();
            });
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
                _canvas.discardActiveObject().renderAll();
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
            this.stages[this.currentStage]['canvas'].clear();
            jQuery('.clear-stage-alert .close-popup').triggerHandler('click');
        };
        $scope.selectAllLayers = function(){
            var _canvas = this.stages[this.currentStage]['canvas'];
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
                var layerInfo = {index: index, visible: obj.get('visible'), selectable: obj.get('selectable')};
                if( !obj.isAlwaysOnTop ){
                    switch(obj.type) {
                        case 'i-text':
                        case 'text':
                        case 'curvedText':
                            layerInfo.type = 'text';
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
                            layerInfo.type = 'path';
                            break;
                        case 'path-group':
                        case 'path':
                        case 'group':
                            layerInfo.type = 'path';
                            break;
                        default:
                            layerInfo.type = 'layer';
                            break;
                    }
                    _stage.layers.push(layerInfo);
                }
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
        $scope.setStackPosition = function(command, onLayer){
            var item = $scope.stages[$scope.currentStage]['canvas'].getActiveObject();
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
            if( _stage.states.type != 'group' ){
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
        $scope.addText = function(content){
            var content = angular.isDefined(content) ? content : $scope.settings.nbdesigner_default_text;
            $scope.stages[$scope.currentStage]['canvas'].add(new FabricWindow.IText(content, {
                fontFamily: "Roboto",
                radius: 50,
                objectCaching: false,
                fontSize: 36
            }));
        };
        $scope.setLayerAttribute = function(type, value, item_index, layer_index){
            var _canvas = $scope.stages[$scope.currentStage]['canvas'];
            var item = angular.isDefined(item_index) ? _canvas.item(item_index) : _canvas.getActiveObject();
            $scope.beforeObjectModify(item);
            item.set({[type]: value});
            if( item.get('type') == 'i-text' && type == 'selectable'){
                value == true ? item.set({editable: true}) : item.set({editable: false});
            };
            if( type == 'selectable' || type == 'visible' ){
                $scope.deactiveAllLayer();
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
            var item = _canvas.getActiveObject();
            if( !item ) return;
            $scope.beforeObjectModify(item);
            item.set({[type]: value});
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
                if( hideLoading ) $scope.toggleStageLoading();
            });
        };
        /* SVG */
        $scope.addSvgFromString = function(svg){
            $scope.toggleStageLoading();
            fabric.loadSVGFromString(svg, function(ob, op) {
                $scope._addSvg(ob, op, {name: ''}, true);
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
            _canvas.add((fabric.util.groupSVGElements(ob, op)).set({
                left: 100,
                top: 100,
                svg_name: art.name,
                scaleX: new_width / op.width,
                scaleY: new_height / op.height
            }));
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
        selectionColor: "rgba(19, 147, 255, 0.3)",
        cursorDuration: 500
    });
    $window.fabric.Canvas.prototype.set({
        preserveObjectStacking : true,
        controlsAboveOverlay: true,
        selectionColor: 'rgba(1, 196, 204, 0.3)',
        selectionBorderColor: '#01c4cc',
        selectionLineWidth: 0.5,
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
                        el.prop("scrollTop") > 1500 && elInfo.addClass('nbd-show') || elInfo.removeClass('nbd-show');
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
            var font_id = fontName.replace(/\s/gi, '').toLowerCase();
            if( !jQuery('#' + font_id).length ){
                if(fontType == 'google'){
                    jQuery('head').append('<link id="' + font_id + '" href="https://fonts.googleapis.com/css?family='+ fontName.replace(/\s/gi, '+') +':400,400i,700,700i" rel="stylesheet" type="text/css">');
                }else{
                    var font_url = scope.font.url;
                    if(! (scope.font.url.indexOf("http") > -1)) font_url = NBDESIGNCONFIG['font_url'] + scope.font.url;
                    if (fontType == "ttf") type = "truetype";
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
                        alert('Please accept the upload term conditions');
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
                        alert('Please accept the upload term conditions');
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
if(0){
// if( NBDESIGNCONFIG['nbdesigner_enable_facebook_photo'] == 'yes' && NBDESIGNCONFIG['fbID'] != ''){
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