<div class="tab tab-first active" id="tab-product-template">
<!--    <div class="nbd-search" ng-if="settings.ui_mode != '1'">
        <input type="search" name="search" placeholder="search"/>
        <i class="icon-nbd icon-nbd-fomat-search"></i>
    </div>-->
    <div class="tab-template show" id="tab-template">
        <!--            <i class="icon-nbd icon-nbd-fomat-highlight-off close-template"></i>-->
        <div class="tab-main tab-scroll">
<!--            <p class="nbd-template-head"><?php echo $_product->get_title(); ?> <?php _e('designs','web-to-print-online-designer'); ?></p>-->
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
                        <?php if( $task == 'create_template' ): ?>
                        <div>
                            <p ng-click="loadTemplateCat()">Load library templates</p>
                            <select ng-change="loadGlobalTemplate(templateCat)" ng-show="templateCats.length > 0" style="line-height: 30px; width: 200px; height: 30px;" class="process-select" ng-model="templateCat" id="category_template">
                                <option ng-repeat="cat in templateCats" ng-value="{{cat.id}}"><span>{{cat.name}}</span></option>
                            </select>
                            <div class="item" ng-repeat="temp in resource.globalTemplate.data" ng-click="insertGlobalTemplate(false, temp)">
                                <div class="main-item">
                                    <div class="item-img">
                                        <img ng-src="{{temp.thumbnail}}" alt="<?php _e('Template','web-to-print-online-designer'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>        
                        <?php endif; ?>
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