<div class="tab" id="tab-element" nbd-scroll="scrollLoadMore(container, type)" data-container="#tab-element" data-type="element" data-offset="20">
    <div class="nbd-search">
        <input ng-class="(resource.element.type != 'icon' || !resource.element.onclick) ? 'nbd-disabled' : ''" ng-keyup="$event.keyCode == 13 && getMedia(resource.element.type, 'search')" type="search" name="search" placeholder="search" ng-model="resource.element.contentSearch"/>
        <i class="icon-nbd icon-nbd-fomat-search"></i>
    </div>     
    <div class="tab-main tab-scroll" style="margin-top: 70px;height: calc(100% - 70px);">
        <div class="nbd-items-dropdown">
            <div class="main-items">
                <div class="items">
                    <div ng-if="settings['nbdesigner_enable_draw'] == 'yes'" class="item" data-type="draw" data-api="false" ng-click="onClickTab('draw', 'element')">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-drawing"></i></div>
                            <div class="item-info">
                                <span class="item-name"><?php _e('Draw','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div ng-if="settings['nbdesigner_enable_clipart'] == 'yes'" class="item" data-type="shapes" data-api="false" ng-click="onClickTab('shape', 'element')">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-shapes"></i></div>
                            <div class="item-info">
                                <span class="item-name"><?php _e('Shapes','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div ng-if="settings['nbdesigner_enable_clipart'] == 'yes'" class="item" data-type="icons" data-api="false" ng-click="onClickTab('icon', 'element')">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-diamond"></i></div>
                            <div class="item-info">
                                <span class="item-name"><?php _e('Icons','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
<!--                    <div class="item" data-type="lines" data-api="false" ng-click="onClickTab('line', 'element')">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-line"></i></div>
                            <div class="item-info">
                                <span class="item-name"><?php _e('Lines','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>-->
                    <div ng-if="settings['nbdesigner_enable_qrcode'] == 'yes'" class="item" data-type="qr-code" data-api="false" ng-click="onClickTab('qrcode', 'element')">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-qrcode"></i></div>
                            <div class="item-info">
                                <span class="item-name"><?php _e('QR-Code','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pointer"></div>
            </div>
            <div class="result-loaded">
                <div class="content-items">
                    <div class="content-item type-draw" data-type="draw">
                        <div class="main-type">
                            <span class="heading-title"><?php _e('Free Drawing','web-to-print-online-designer'); ?></span>
                            <div class="brush" style="text-align: left;">
                                <h3 class="color-palette-label" style="font-size: 12px; text-align: left; margin: 0 0 5px;"><?php _e('Choose ','web-to-print-online-designer'); ?></h3>
                                <button class="nbd-button nbd-dropdown">
                                    <?php _e('Brush','web-to-print-online-designer'); ?> <i class="icon-nbd icon-nbd-arrow-drop-down"></i>
                                    <div class="nbd-sub-dropdown" data-pos="left">
                                        <ul class="tab-scroll">
                                            <li ng-click="resource.drawMode.brushType = 'Pencil';changeBush()" ng-class="resource.drawMode.brushType == 'Pencil' ? 'active' : ''"><span><?php _e('Pencil','web-to-print-online-designer'); ?></span></li>
                                            <li ng-click="resource.drawMode.brushType = 'Circle';changeBush()" ng-class="resource.drawMode.brushType == 'Circle' ? 'active' : ''"><span><?php _e('Circle','web-to-print-online-designer'); ?></span></li>
                                            <li ng-click="resource.drawMode.brushType = 'Spray';changeBush()" ng-class="resource.drawMode.brushType == 'Spray' ? 'active' : ''"><span><?php _e('Spray','web-to-print-online-designer'); ?></span></li>
                                        </ul>
                                    </div>
                                </button>
                            </div>                            
                            <ul class="main-ranges" style="margin-top: 15px;">
                                <li class="range range-brightness">
                                    <label><?php _e('Brush width ','web-to-print-online-designer'); ?></label>
                                    <div class="main-track">
                                        <input class="slide-input" type="range" step="1" min="1" max="100" ng-change="changeBush()" ng-model="resource.drawMode.brushWidth">
                                        <span class="range-track"></span>
                                    </div>
                                    <span class="value-display">{{resource.drawMode.brushWidth}}</span>
                                </li>
                            </ul>
                            <div class="color">
                                <h3 class="color-palette-label" style="font-size: 12px; text-align: left; margin: 0 0 5px;"><?php _e('Brush color','web-to-print-online-designer'); ?></h3>
                                <ul class="main-color-palette nbd-perfect-scroll" style="margin-bottom: 10px; max-height: 220px">
                                    <li class="color-palette-add" ng-init="showBrushColorPicker = false" ng-click="showBrushColorPicker = !showBrushColorPicker;" ng-style="{'background-color': currentColor}"></li>
                                    <li ng-repeat="color in listAddedColor track by $index" ng-click="resource.drawMode.brushColor=color; changeBush()" class="color-palette-item" data-color="{{color}}" title="{{color}}" ng-style="{'background-color': color}"></li>
                                </ul>
                                <div class="pinned-palette default-palette" style="margin-bottom: 10px">
                                    <h3 class="color-palette-label" style="font-size: 12px; text-align: left; margin: 0 0 5px;"><?php _e('Default palette','web-to-print-online-designer'); ?></h3>
                                    <ul class="main-color-palette" ng-repeat="palette in resource.defaultPalette" style="margin-bottom: 15px;">
                                        <li ng-class="{'first-left': $first, 'last-right': $last}" ng-repeat="color in palette track by $index" ng-click="resource.drawMode.brushColor=color; changeBush()" class="color-palette-item" data-color="{{color}}" title="{{color}}" ng-style="{'background': color}"></li>
                                    </ul>                        
                                </div>
                                <div class="nbd-text-color-picker" id="nbd-bg-color-picker" ng-class="showBrushColorPicker ? 'active' : ''" style="z-index: 999;">
                                    <spectrum-colorpicker
                                        ng-model="currentColor"
                                        options="{
                                                preferredFormat: 'hex',
                                                color: '#fff',
                                                flat: true,
                                                showButtons: false,
                                                showInput: true,
                                                containerClassName: 'nbd-sp'
                                        }">
                                    </spectrum-colorpicker>
                                    <div style="text-align: <?php echo (is_rtl()) ? 'right' : 'left'?>">
                                        <button class="nbd-button" ng-click="addColor();changeBush()"><?php _e('Choose','web-to-print-online-designer'); ?></button>
                                    </div>
                                </div>        
                            </div>
                        </div>
                    </div>
                    <div class="content-item type-shapes" data-type="shapes" id="nbd-shape-wrap">
                        <div class="mansory-wrap">
                            <div nbd-drag="art.url" extenal="true" type="svg" class="mansory-item" ng-click="addSvgFromMedia(art)" ng-repeat="art in resource.shape.data" repeat-end="onEndRepeat('shape')"><img ng-src="{{art.url}}"><span class="photo-desc">{{art.name}}</span></div>
                        </div>                        
                    </div>
                    <div class="content-item type-icons" data-type="icons" id="nbd-icon-wrap">
                        <div class="mansory-wrap">
                            <div nbd-drag="art.url" extenal="true" type="svg" class="mansory-item" ng-click="addSvgFromMedia(art)" ng-repeat="art in resource.icon.data" repeat-end="onEndRepeat('icon')"><img ng-src="{{art.url}}"><span class="photo-desc">{{art.name}}</span></div>
                        </div>                          
                    </div>
                    <div class="content-item type-lines" data-type="lines" id="nbd-line-wrap">
                        <div class="mansory-wrap">
                            <div nbd-drag="art.url" extenal="true" type="svg" class="mansory-item" ng-click="addSvgFromMedia(art)" ng-repeat="art in resource.line.data" repeat-end="onEndRepeat('line')"><img ng-src="{{art.url}}"><span class="photo-desc">{{art.name}}</span></div>
                        </div>                          
                    </div>
                    <div class="content-item type-qrcode" data-type="qr-code">
                        <div class="main-type">
                            <div class="main-input">
                                <input ng-model="resource.qrText" type="text" class="nbd-input input-qrcode" name="qr-code" placeholder="https://yourcompany.com">
                            </div>
                            <button ng-class="resource.qrText != '' ? '' : 'nbd-disabled'" class="nbd-button" ng-click="addQrCode()"><?php _e('Create QRCode','web-to-print-online-designer'); ?></button>
                            <div class="main-qrcode">
                                
                            </div>

                        </div>
                    </div>
                </div>
                <div class="nbdesigner-gallery" id="nbdesigner-gallery">
                </div>
                <div class="loading-photo" style="width: 40px; height: 40px;">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                    </svg>
                </div>           
            </div>
            <div class="info-support">
                <span>Facebook</span>
                <i class="icon-nbd icon-nbd-clear close-result-loaded" ng-click="onClickTab('', 'element')"></i>
            </div>
        </div>
    </div>
</div>