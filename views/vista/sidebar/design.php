<div id="tab-design" class="v-tab-content active nbd-main-tab">
    <ul class="nbd-nav-tabs">
        <li class="nbd-nav-tab active" data-tab="nbd-tab-design-workflow"><span class="v-title">Design</span></li>
        <li class="nbd-nav-tab" data-tab="nbd-tab-bg-color"><span class="v-title">Background</span></li>
    </ul>

    <div class="v-content nbd-tab-contents" data-action="no">
        <div class="layout tab-scroll nbd-tab-content active" id="nbd-tab-design-workflow">
            <div class="main-scrollbar">
                <div class="short-design" style="display: none">
                    <button class="v-btn btn-svg-upload">Upload Svg</button>
                    <button class="v-btn btn-add-text">Add Text</button>
                </div>
                <div class="items">
                    <div class="item" ng-repeat="temp in resource.templates" ng-click="insertTemplate(false, temp)">
                        <img ng-src="{{temp.thumbnail}}" alt="<?php _e('Template','web-to-print-online-designer'); ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="design-color nbd-tab-content" id="nbd-tab-bg-color">
            <div class="tab-scroll bg-color">
                <div class="main-scrollbar">
                    <div class="main-color">
                        <div class="nbd-color-palette show">
                            <div class="nbd-color-palette-inner">
                                <div class="working-palette">
                                    <h3 class="color-palette-label">Set color</h3>
                                    <ul class="main-color-palette tab-scroll" style="max-height: 150px">
                                        <li class="color-palette-add" ng-style="{'background-color': currentColor}"></li>
                                        <li ng-repeat="color in listAddedColor track by $index" class="color-palette-item" data-color="{color}" title="{color}" ng-style="{'background-color': color}"></li>
                                    </ul>
                                </div>
                                <div class="pinned-palette default-palette">
                                    <h3 class="color-palette-label">Default color</h3>
                                    <ul class="main-color-palette">
                                        <li class="color-palette-item ng-scope" data-color="#81d742" style="background: rgb(129, 215, 66);"></li>
                                        <li class="color-palette-item ng-scope" data-color="#1e73be" style="background: rgb(30, 115, 190);"></li>
                                        <li class="color-palette-item ng-scope" data-color="#dd3333" style="background: rgb(221, 51, 51);"></li>
                                        <li class="color-palette-item ng-scope" data-color="#8224e3" style="background: rgb(130, 36, 227);"></li>
                                    </ul>
                                </div>
                                <div class="pinned-palette default-palette">
                                    <ul class="main-color-palette">
                                        <!--                                        <li ng-repeat="color in listAddedColor track by $index" class="color-palette-item" data-color="{color}" title="{color}" ng-style="{'background-color': color}"></li>-->
                                        <li class="color-palette-item" data-color="#333333" title="#333333"
                                            style="background-color: #333333;"></li>
                                        <li class="color-palette-item" data-color="#666666" title="#666666"
                                            style="background-color: #666666;"></li>
                                        <li class="color-palette-item" data-color="#a8a8a8" title="#a8a8a8"
                                            style="background-color: #a8a8a8;"></li>
                                        <li class="color-palette-item" data-color="#d9d9d9" title="#d9d9d9"
                                            style="background-color: #d9d9d9;"></li>
                                        <li class="color-palette-item" data-color="#ffffff" title="#ffffff"
                                            style="background-color: #ffffff;"></li>
                                    </ul>
                                </div>
                                <div class="nbd-text-color-picker" id="nbd-text-color-picker">
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
                                    <div>
                                        <button class="v-btn" ng-click="addColor()"><?php _e('Add color','web-to-print-online-designer'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>