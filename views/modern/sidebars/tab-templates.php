<div class="tab tab-first active" id="tab-product-template">
<!--    <div class="nbd-search" ng-if="settings.ui_mode != '1'">
        <input type="search" name="search" placeholder="search"/>
        <i class="icon-nbd icon-nbd-fomat-search"></i>
    </div>-->
    <div class="tab-template show" id="tab-template">
        <!--            <i class="icon-nbd icon-nbd-fomat-highlight-off close-template"></i>-->
        <div class="tab-main tab-scroll">
            <div style="padding: 10px">
                <h3 class="color-palette-label" style="font-size: 11px; text-align: left; margin: 0 0 5px; text-transform: uppercase;"><?php _e('Document colors','web-to-print-online-designer'); ?></h3>
                <ul class="main-color-palette nbd-perfect-scroll" style="margin-bottom: 10px; max-height: 220px">
                    <li class="color-palette-add" ng-click="showBgColorPalette()" ng-style="{'background-color': currentColor}"></li>
                    <li ng-repeat="color in listAddedColor track by $index" ng-click="changeBackground(color)" class="color-palette-item" data-color="{{color}}" title="{{color}}" ng-style="{'background-color': color}"></li>
                </ul>
                <div class="pinned-palette default-palette" style="margin-bottom: 10px">
                    <h3 class="color-palette-label" style="font-size: 11px; text-align: left; margin: 0 0 5px; text-transform: uppercase;"><?php _e('Default palette','web-to-print-online-designer'); ?></h3>
                    <ul class="main-color-palette" ng-repeat="palette in resource.defaultPalette" style="margin-bottom: 15px;">
                        <li ng-class="{'first-left': $first, 'last-right': $last}" ng-repeat="color in palette track by $index" ng-click="changeBackground(color)" class="color-palette-item" data-color="{{color}}" title="{{color}}" ng-style="{'background': color}"></li>
                    </ul>   
                </div>
                <div class="nbd-text-color-picker" id="nbd-bg-color-picker" ng-class="showBgColorPicker ? 'active' : ''" style="z-index: 999;">
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
                        <button class="nbd-button" ng-click="addColor();changeBackground(currentColor);"><?php _e('Choose','web-to-print-online-designer'); ?></button>
                    </div>
                </div>

            </div>
            <div class="nbd-templates">
                <div class="main-items">
                    <div class="items" style="text-align: left;">
                        <p ng-show="resource.myTemplates.length > 0" style="padding: 0 10px;">My designs</p>
                        <div class="item slideInDown animate300 animated" ng-repeat="temp in resource.myTemplates" ng-click="loadMyDesign(temp.id, false)">
                            <div class="main-item">
                                <div class="item-img">
                                    <img ng-src="{{temp.src}}" alt="<?php _e('Template','web-to-print-online-designer'); ?>">
                                </div>
                            </div>
                        </div>  
                        <p ng-show="resource.cartTemplates.length > 0" style="padding: 0 10px;">My designs in cart</p>
                        <div class="item slideInDown animate300 animated" ng-repeat="temp in resource.cartTemplates" ng-click="loadMyDesign(temp.id, true)">
                            <div class="main-item">
                                <div class="item-img">
                                    <img ng-src="{{temp.src}}" alt="<?php _e('Template','web-to-print-online-designer'); ?>">
                                </div>
                            </div>
                        </div>                         
                        <div class="item" ng-repeat="temp in resource.templates" ng-click="insertTemplate(false, temp)">
                            <div class="main-item">
                                <div class="item-img">
                                    <img ng-src="{{temp.thumbnail}}" alt="<?php _e('Template','web-to-print-online-designer'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pointer"></div>
                </div>
                <div class="loading-photo" style="width: 40px; height: 40px; display: none;">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>