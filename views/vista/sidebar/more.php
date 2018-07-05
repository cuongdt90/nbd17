<div id="tab-element" class="v-tab-content v-more-toolbar" nbd-scroll="scrollLoadMore(container, type)" data-container="#tab-element" data-type="element" data-offset="20">
    <span class="v-title">More</span>
    <div class="nbd-search">
        <input ng-class="(resource.element.type != 'icon' || !resource.element.onclick) ? 'nbd-disabled' : ''" ng-keyup="$event.keyCode == 13 && getMedia(resource.element.type, 'search')" type="search" name="search" placeholder="search" ng-model="resource.element.contentSearch"/>
        <i class="nbd-icon-vista nbd-icon-vista-search"></i>
    </div>
    <div class="v-content">
        <div class="tab-scroll">
            <div class="main-scrollbar">
                <div class="v-elements">
                    <div class="main-items">
                        <div class="items">
                            <div class="item" data-type="draw" data-api="false">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-drawing"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Draw"><?php _e('Draw','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div ng-if="settings['nbdesigner_enable_clipart'] == 'yes'" data-api="false" class="item" data-type="shapes" data-api="false" ng-click="onClickTab('shape', 'element')">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-shapes"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Shapes"><?php _e('Shapes','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div ng-if="settings['nbdesigner_enable_clipart'] == 'yes'" data-api="false" ng-click="onClickTab('icon', 'element')" class="item" data-type="icons" data-api="false">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-diamond"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Icons"><?php _e('Icons','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
<!--                            <div class="item" data-type="lines" data-api="true">-->
<!--                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-line"></i></div>-->
<!--                                <div class="item-info">-->
<!--                                    <span class="item-name" title="Lines">--><?php //_e('Lines','web-to-print-online-designer'); ?><!--</span>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="item" data-type="qr-code" data-api="false">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-qrcode"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="QR Code"><?php _e('QR Code','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div class="item" data-type="none"></div>
                        </div>
                        <div class="pointer"></div>
                    </div>
                    <div class="result-loaded">
                        <div class="content-items">
                            <div class="content-item type-draw" data-type="draw">
                                <div class="main-type">
                                    <span class="heading-title"><?php _e('Drawing Mode','web-to-print-online-designer'); ?></span>
                                    <ul class="v-ranges">
                                        <li class="range range-brightness">
                                            <label>Brightness</label>
                                            <div class="main-track">
                                                <input class="slide-input" type="range" step="1" min="0" max="100" value="50">
                                                <span class="range-track"></span>
                                            </div>
                                            <span class="value-display">50</span>
                                        </li>
                                        <li class="range range-brightness">
                                            <label>Brightness</label>
                                            <div class="main-track">
                                                <input class="slide-input" type="range" step="1" min="0" max="100" value="50">
                                                <span class="range-track"></span>
                                            </div>
                                            <span class="value-display">50</span>
                                        </li>
                                    </ul>
                                    <div class="brush v-dropdown">
                                        <button class="v-btn v-btn-dropdown">
                                            Brush <i class="nbd-icon-vista nbd-icon-vista-arrow-drop-down"></i>
                                        </button>
                                        <div class="v-dropdown-menu" data-pos="left">
                                            <ul class="tab-scroll">
                                                <li><span><?php _e('Pencil','web-to-print-online-designer'); ?></span></li>
                                                <li><span><?php _e('Circle','web-to-print-online-designer'); ?></span></li>
                                                <li><span><?php _e('Spray','web-to-print-online-designer'); ?></span></li>
                                                <li><span><?php _e('Pattern','web-to-print-online-designer'); ?></span></li>
                                                <li><span><?php _e('Horizontal line','web-to-print-online-designer'); ?></span></li>
                                                <li><span><?php _e('Vertical line','web-to-print-online-designer'); ?></span></li>
                                                <li><span><?php _e('Square','web-to-print-online-designer'); ?></span></li>
                                                <li><span><?php _e('Diamond','web-to-print-online-designer'); ?></span></li>
                                                <li><span><?php _e('Textture','web-to-print-online-designer'); ?></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content-item type-shapes" data-type="shapes" id="nbd-shape-wrap">
                                <div class="mansory-wrap">
                                    <div nbd-drag="art.url" extenal="true" type="svg" class="mansory-item" ng-click="addArt(art, true, true)" ng-repeat="art in resource.shape.data" repeat-end="onEndRepeat('shape')"><img ng-src="{{art.url}}"><span class="photo-desc">{{art.name}}</span></div>
                                </div>
                            </div>
                            <div class="content-item type-icons" data-type="icons" id="nbd-icon-wrap">
                                <div class="mansory-wrap">
                                    <div nbd-drag="art.url" extenal="true" type="svg" class="mansory-item" ng-click="addArt(art, true, true)" ng-repeat="art in resource.icon.data" repeat-end="onEndRepeat('icon')"><img ng-src="{{art.url}}"><span class="photo-desc">{{art.name}}</span></div>
                                </div>
                            </div>
<!--                            <div class="content-item type-lines" data-type="lines"></div>-->
                            <div class="content-item type-qrcode" data-type="qr-code">
                                <div class="main-type">
                                    <div class="main-input">
                                        <input type="text" class="nbd-input input-qrcode" name="qr-code" placeholder="http://example.com">
                                    </div>
                                    <button class="v-btn"><?php _e('Create QRCode','web-to-print-online-designer'); ?></button>
                                    <div class="main-qrcode">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="256" height="256">
                                            <rect x="0" y="0" width="256" height="256" style="fill:#ffffff;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="10.24" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="30.72" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="51.2" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="81.92" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="112.64" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="122.88" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="143.36" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="194.56" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="215.04" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="235.52" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="0" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="10.24" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="10.24" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="10.24" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="10.24" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="112.64" y="10.24" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="143.36" y="10.24" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="10.24" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="10.24" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="10.24" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="30.72" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="81.92" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="112.64" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="143.36" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="215.04" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="20.48" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="30.72" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="30.72" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="30.72" y="30.72" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="30.72" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="30.72" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="122.88" y="30.72" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="133.12" y="30.72" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="30.72" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="30.72" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="215.04" y="30.72" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="30.72" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="30.72" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="30.72" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="112.64" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="133.12" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="143.36" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="153.6" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="215.04" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="40.96" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="51.2" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="51.2" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="51.2" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="112.64" y="51.2" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="122.88" y="51.2" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="153.6" y="51.2" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="51.2" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="51.2" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="10.24" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="30.72" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="51.2" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="81.92" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="122.88" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="143.36" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="194.56" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="215.04" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="235.52" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="61.44" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="81.92" y="71.68" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="71.68" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="112.64" y="71.68" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="122.88" y="71.68" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="133.12" y="71.68" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="143.36" y="71.68" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="81.92" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="81.92" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="51.2" y="81.92" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="81.92" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="81.92" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="112.64" y="81.92" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="174.08" y="81.92" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="81.92" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="81.92" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="81.92" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="51.2" y="92.16" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="71.68" y="92.16" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="81.92" y="92.16" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="92.16" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="92.16" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="153.6" y="92.16" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="92.16" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="92.16" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="92.16" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="92.16" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="235.52" y="92.16" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="102.4" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="10.24" y="102.4" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="30.72" y="102.4" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="102.4" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="51.2" y="102.4" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="102.4" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="81.92" y="102.4" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="102.4" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="102.4" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="194.56" y="102.4" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="102.4" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="102.4" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="102.4" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="112.64" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="10.24" y="112.64" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="30.72" y="112.64" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="112.64" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="51.2" y="112.64" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="112.64" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="112.64" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="112.64" y="112.64" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="143.36" y="112.64" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="112.64" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="194.56" y="112.64" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="112.64" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="112.64" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="10.24" y="122.88" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="122.88" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="122.88" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="122.88" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="81.92" y="122.88" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="112.64" y="122.88" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="122.88" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="174.08" y="122.88" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="122.88" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="194.56" y="122.88" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="122.88" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="10.24" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="51.2" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="71.68" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="81.92" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="122.88" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="133.12" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="153.6" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="215.04" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="235.52" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="133.12" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="143.36" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="10.24" y="143.36" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="143.36" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="51.2" y="143.36" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="143.36" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="143.36" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="112.64" y="143.36" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="122.88" y="143.36" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="133.12" y="143.36" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="143.36" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="194.56" y="143.36" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="143.36" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="215.04" y="143.36" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="153.6" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="30.72" y="153.6" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="71.68" y="153.6" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="153.6" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="153.6" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="112.64" y="153.6" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="122.88" y="153.6" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="133.12" y="153.6" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="143.36" y="153.6" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="153.6" y="153.6" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="153.6" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="153.6" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="10.24" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="51.2" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="71.68" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="81.92" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="122.88" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="133.12" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="143.36" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="153.6" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="174.08" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="194.56" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="215.04" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="235.52" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="163.84" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="174.08" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="143.36" y="174.08" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="174.08" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="174.08" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="215.04" y="174.08" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="235.52" y="174.08" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="10.24" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="30.72" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="51.2" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="122.88" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="133.12" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="184.32" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="194.56" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="194.56" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="81.92" y="194.56" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="194.56" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="122.88" y="194.56" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="133.12" y="194.56" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="153.6" y="194.56" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="194.56" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="194.56" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="235.52" y="194.56" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="30.72" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="112.64" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="174.08" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="194.56" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="215.04" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="235.52" y="204.8" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="215.04" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="215.04" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="30.72" y="215.04" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="215.04" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="215.04" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="215.04" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="215.04" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="112.64" y="215.04" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="143.36" y="215.04" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="215.04" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="215.04" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="215.04" y="215.04" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="215.04" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="225.28" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="225.28" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="30.72" y="225.28" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="225.28" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="225.28" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="81.92" y="225.28" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="225.28" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="143.36" y="225.28" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="174.08" y="225.28" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="215.04" y="225.28" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="235.52" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="235.52" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="235.52" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="133.12" y="235.52" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="163.84" y="235.52" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="235.52" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="215.04" y="235.52" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="235.52" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="0" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="10.24" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="20.48" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="30.72" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="40.96" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="51.2" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="61.44" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="81.92" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="92.16" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="102.4" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="122.88" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="133.12" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="143.36" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="174.08" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="184.32" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="194.56" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="204.8" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="225.28" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                            <rect x="245.76" y="245.76" width="10.24" height="10.24" style="fill:#4F5467;shape-rendering:crispEdges;"></rect>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nbdesigner-gallery" id="nbdesigner-gallery"></div>
                    </div>
                    <div class="loading-photo" style="display: none; width: 40px; height: 40px;">
                        <svg class="circular" viewBox="25 25 50 50">
                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="info-support">
            <span>Facebook</span>
            <i class="nbd-icon-vista nbd-icon-vista-clear close-result-loaded"></i>
        </div>
    </div>

</div>