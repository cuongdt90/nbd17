<div class="tab" id="tab-element" nbd-scroll="scrollLoadMore(container, type)" data-container="#tab-element" data-type="element" data-offset="20">
    <div class="tab-main tab-scroll">
        <div class="nbd-items-dropdown">
            <div class="main-items">
                <div class="items">
                    <div class="item" data-type="draw" data-api="false" ng-click="onClickTab('draw', 'element')">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-drawing"></i></div>
                            <div class="item-info">
                                <span class="item-name"><?php _e('Draw','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="item" data-type="shapes" data-api="false" ng-click="onClickTab('shape', 'element')">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-shapes"></i></div>
                            <div class="item-info">
                                <span class="item-name"><?php _e('Shapes','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="item" data-type="icons" data-api="false" ng-click="onClickTab('icon', 'element')">
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
                    <div class="item" data-type="qr-code" data-api="false" ng-click="onClickTab('qrcode', 'element')">
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
                            <span class="heading-title"><?php _e('Drawing Mode','web-to-print-online-designer'); ?></span>
                            <ul class="main-ranges">
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
                            <div class="brush">
                                <button class="nbd-button nbd-dropdown">
                                    Brush <i class="icon-nbd icon-nbd-arrow-drop-down"></i>
                                    <div class="nbd-sub-dropdown" data-pos="left">
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
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="content-item type-shapes" data-type="shapes" id="nbd-shape-wrap">
                        <div class="mansory-wrap">
                            <div class="mansory-item" ng-click="addArt(art, true, true)" ng-repeat="art in resource.shape.data" repeat-end="onEndRepeat('shape')"><img ng-src="{{art.url}}"><span class="photo-desc">{{art.name}}</span></div>
                        </div>                        
                    </div>
                    <div class="content-item type-icons" data-type="icons" id="nbd-icon-wrap">
                        <div class="mansory-wrap">
                            <div class="mansory-item" ng-click="addArt(art, true, true)" ng-repeat="art in resource.icon.data" repeat-end="onEndRepeat('icon')"><img ng-src="{{art.url}}"><span class="photo-desc">{{art.name}}</span></div>
                        </div>                          
                    </div>
                    <div class="content-item type-lines" data-type="lines" id="nbd-line-wrap">
                        <div class="mansory-wrap">
                            <div class="mansory-item" ng-click="addArt(art, true, true)" ng-repeat="art in resource.line.data" repeat-end="onEndRepeat('line')"><img ng-src="{{art.url}}"><span class="photo-desc">{{art.name}}</span></div>
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