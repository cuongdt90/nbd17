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
                    <div class="items" style="text-align: left; padding-left: 5px; padding-right: 5px;">
                        <p ng-show="resource.myTemplates.length > 0" style="padding: 0 5px;">My designs</p>
                        <div class="item slideInDown animate300 animated" ng-repeat="temp in resource.myTemplates" ng-click="loadMyDesign(temp.id, false)">
                            <div class="main-item">
                                <div class="item-img">
                                    <img ng-src="{{temp.src}}" alt="<?php _e('Template','web-to-print-online-designer'); ?>">
                                </div>
                            </div>
                        </div>  
                        <p ng-show="resource.cartTemplates.length > 0" style="padding: 0 5px;">My designs in cart</p>
                        <div class="item slideInDown animate300 animated" ng-repeat="temp in resource.cartTemplates" ng-click="loadMyDesign(temp.id, true)">
                            <div class="main-item">
                                <div class="item-img">
                                    <img ng-src="{{temp.src}}" alt="<?php _e('Template','web-to-print-online-designer'); ?>">
                                </div>
                            </div>
                        </div>                         
                        <div ng-style="{'display': settings.task == 'create_template' ? 'none' : 'inline-block' }" class="item" ng-repeat="temp in resource.templates" ng-click="insertTemplate(false, temp)">
                            <div class="main-item">
                                <div class="item-img">
                                    <img ng-src="{{temp.thumbnail}}" alt="<?php _e('Template','web-to-print-online-designer'); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <?php if(1): //if( $task == 'create_template' ): ?>
                        <div style="padding:5px;">
<!--                            <div>
                                <button style="margin-left: 0" class="nbd-button" ng-click="debug()">Debug</button>
                            </div>                            -->
                            <div>
                                <button style="margin-left: 0" class="nbd-button" ng-click="uploadSvgFile()">Upload SVG</button>
                                <button style="margin-left: 0" class="nbd-button" ng-click="addText()">Add Text</button>
                            </div>
                            <div>
                                <button style="margin-left: 0" class="nbd-button" ng-click="_loadTemplateCat()">Load templates</button>
                                <select ng-change="changeGlobalTemplate()" ng-show="templateCats.length > 0" style="line-height: 35px; width: 100%; height: 35px;border-radius: 4px;border: 1px solid #404762;" class="process-select" ng-model="templateCat" id="category_template">
                                    <option ng-repeat="cat in templateCats" ng-value="{{cat.id}}"><span>{{cat.name}}</span></option>
                                </select>
                            </div>
                        </div>
                        <div class="item" ng-repeat="temp in resource.globalTemplate.data" ng-click="insertGlobalTemplate(temp.id)">
                            <div class="main-item">
                                <div class="item-img">
                                    <img ng-src="{{temp.thumbnail}}" alt="{{temp.name}}">
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