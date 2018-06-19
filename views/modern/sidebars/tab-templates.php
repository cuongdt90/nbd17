<div class="tab tab-first active" id="tab-product-template">
    <div class="nbd-search" ng-if="settings.ui_mode != '1'">
        <input type="search" name="search" placeholder="search"/>
        <i class="icon-nbd icon-nbd-fomat-search"></i>
    </div>
    <div class="tab-template show" id="tab-template">
        <!--            <i class="icon-nbd icon-nbd-fomat-highlight-off close-template"></i>-->
        <div class="tab-main tab-scroll">
            <div style="padding: 10px">
                <ul class="main-color-palette nbd-perfect-scroll" style="margin-bottom: 10px; max-height: 220px">
                    <li class="color-palette-add" ng-click="showTextColorPalette()" ng-style="{'background-color': currentColor}"></li>
                    <li ng-repeat="color in listAddedColor track by $index" ng-click="changeFill(color)" class="color-palette-item" data-color="{{color}}" title="{{color}}" ng-style="{'background-color': color}"></li>
                </ul>
                <div class="pinned-palette default-palette" style="margin-bottom: 10px">
                    <h3 class="color-palette-label" style="font-size: 14px; text-align: left; margin-top: 15px"><?php _e('Default palette','web-to-print-online-designer'); ?></h3>
                    <ul class="main-color-palette">
                        <li ng-repeat="color in __colorPalette track by $index" ng-click="changeBackground(color)" class="color-palette-item" data-color="{{color}}" title="{{color}}" ng-style="{'background': color}"></li>
                    </ul>
                </div>
                <div class="pinned-palette default-palette" >
                    <ul class="main-color-palette">
                        <li class="color-palette-item" data-color="#000000" title="#000000" style="background-color: #000000;"></li>
                        <li class="color-palette-item" data-color="#666666" title="#666666" style="background-color: #666666;"></li>
                        <li class="color-palette-item" data-color="#a8a8a8" title="#a8a8a8" style="background-color: #a8a8a8;"></li>
                        <li class="color-palette-item" data-color="#d9d9d9" title="#d9d9d9" style="background-color: #d9d9d9;"></li>
                        <li class="color-palette-item" data-color="#ffffff" title="#ffffff" style="background-color: #ffffff;"></li>
                    </ul>
                </div>

                <div class="nbd-text-color-picker" id="nbd-text-color-picker" ng-class="showTextColorPicker ? 'active' : ''" style="z-index: 999;">
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
                        <button class="nbd-button" ng-click="addColor()"><?php _e('Add color','web-to-print-online-designer'); ?></button>
                    </div>
                </div>

            </div>
            <div class="nbd-items-dropdown">
                <div class="main-items">
                    <div class="items">
                        <div class="item" data-type="business-card" data-api="true">
                            <div class="main-item">
                                <div class="item-img">
                                    <img src="<?php echo NBDESIGNER_ASSETS_URL . 'images/business.jpg';?>" alt="Image Template">
                                </div>
                                <div class="item-info">
                                    <span class="item-name" title="Business Card"><?php _e('Business Card','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="item" data-type="business-card" data-api="true">
                            <div class="main-item">
                                <div class="item-img">
                                    <img src="<?php echo NBDESIGNER_ASSETS_URL . 'images/business.jpg';?>" alt="Image Template">
                                </div>
                                <div class="item-info">
                                    <span class="item-name" title="Business Card"><?php _e('Business Card','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="item" data-type="business-card" data-api="true">
                            <div class="main-item">
                                <div class="item-img">
                                    <img src="<?php echo NBDESIGNER_ASSETS_URL . 'images/business.jpg';?>" alt="Image Template">
                                </div>
                                <div class="item-info">
                                    <span class="item-name" title="Business Card"><?php _e('Business Card','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="item" data-type="business-card" data-api="true">
                            <div class="main-item">
                                <div class="item-img">
                                    <img src="<?php echo NBDESIGNER_ASSETS_URL . 'images/business.jpg';?>" alt="Image Template">
                                </div>
                                <div class="item-info">
                                    <span class="item-name" title="Business Card"><?php _e('Business Card','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="item" data-type="business-card" data-api="true">
                            <div class="main-item">
                                <div class="item-img">
                                    <img src="<?php echo NBDESIGNER_ASSETS_URL . 'images/business.jpg';?>" alt="Image Template">
                                </div>
                                <div class="item-info">
                                    <span class="item-name" title="Business Card"><?php _e('Business Card','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="item" data-type="business-card" data-api="true">
                            <div class="main-item">
                                <div class="item-img">
                                    <img src="<?php echo NBDESIGNER_ASSETS_URL . 'images/business.jpg';?>" alt="Image Template">
                                </div>
                                <div class="item-info">
                                    <span class="item-name" title="Business Card"><?php _e('Business Card','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="item" data-type="business-card" data-api="true">
                            <div class="main-item">
                                <div class="item-img">
                                    <img src="<?php echo NBDESIGNER_ASSETS_URL . 'images/business.jpg';?>" alt="Image Template">
                                </div>
                                <div class="item-info">
                                    <span class="item-name" title="Business Card"><?php _e('Business Card','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="item" data-type="business-card" data-api="true">
                            <div class="main-item">
                                <div class="item-img">
                                    <img src="<?php echo NBDESIGNER_ASSETS_URL . 'images/business.jpg';?>" alt="Image Template">
                                </div>
                                <div class="item-info">
                                    <span class="item-name" title="Business Card"><?php _e('Business Card','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pointer"></div>
                </div>
                <div class="loading-photo" style="width: 40px; height: 40px;">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                    </svg>
                </div>
                <div class="result-loaded">
                    <div class="nbdesigner-gallery">fsdfsdfdsfsf
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>