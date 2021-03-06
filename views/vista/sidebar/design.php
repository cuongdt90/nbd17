<div id="tab-design" class="v-tab-content active nbd-main-tab">
    <ul class="nbd-nav-tabs">
        <li ng-if="resource.templates.length > 0" class="nbd-nav-tab active" data-tab="nbd-tab-design-workflow"><span class="v-title"><?php _e('Template','web-to-print-online-designer'); ?></span></li>
        <li ng-class="{'active':resource.templates.length == 0}" class="nbd-nav-tab" data-tab="nbd-tab-bg-color"><span class="v-title"><?php _e('Background','web-to-print-online-designer'); ?></span></li>
    </ul>

    <div class="v-content nbd-tab-contents" data-action="no">
        <div ng-if="resource.templates.length > 0" class="layout tab-scroll nbd-tab-content active" id="nbd-tab-design-workflow" data-tab="nbd-tab-design-workflow">
            <div class="main-scrollbar">
                <div class="short-design" style="display: none">
                    <button class="v-btn btn-svg-upload"><?php _e('Upload Svg','web-to-print-online-designer'); ?></button>
                    <button class="v-btn btn-add-text"><?php _e('Add Text','web-to-print-online-designer'); ?></button>
                </div>
                <div class="items">
                    <div class="item" ng-repeat="temp in resource.templates" ng-click="insertTemplate(false, temp)">
                        <img ng-src="{{temp.thumbnail}}" alt="<?php _e('Template','web-to-print-online-designer'); ?>">
                    </div>
                </div>
            </div>
        </div>
        <div ng-class="{'active':resource.templates.length == 0}" class="design-color nbd-tab-content" id="nbd-tab-bg-color" data-tab="nbd-tab-bg-color">
            <div class="tab-scroll bg-color">
                <div class="main-scrollbar">
                    <div class="main-color">
                        <div class="nbd-color-palette show">
                            <div class="nbd-color-palette-inner">
                                <div class="working-palette" ng-if="settings['nbdesigner_show_all_color'] == 'yes'" style="margin-bottom: 10px">
                                    <h3 class="color-palette-label"><?php _e('Set color','web-to-print-online-designer'); ?></h3>
                                    <ul class="main-color-palette tab-scroll">
                                        <li class="color-palette-add" ng-style="{'background-color': currentColor}"></li>
                                        <li ng-repeat="color in listAddedColor track by $index"
                                            ng-click="changeBackgroundCanvas(color)"
                                            class="color-palette-item"
                                            data-color="{{color}}"
                                            title="{{color}}"
                                            ng-style="{'background-color': color}">
                                        </li>
                                    </ul>
                                </div>
                                <div class="pinned-palette default-palette">
                                    <h3 class="color-palette-label"><?php _e('Default palette','web-to-print-online-designer'); ?></h3>
                                    <ul class="main-color-palette tab-scroll" ng-repeat="palette in resource.defaultPalette" style="margin-bottom: 5px; max-height: 80px">
                                        <li ng-class="{'first-left': $first, 'last-right': $last, 'first-right': $index == 4,'last-left': $index == (palette.length - 5)}"
                                            ng-repeat="color in palette track by $index"
                                            ng-click="changeBackgroundCanvas(color)"
                                            class="color-palette-item"
                                            data-color="{{color}}"
                                            title="{{color}}"
                                            ng-style="{'background': color}">
                                        </li>
                                    </ul>
                                </div>
                                <div class="nbd-text-color-picker"
                                     ng-class="showTextColorPicker ? 'active' : ''"
                                     id="nbd-text-color-picker">
                                    <spectrum-colorpicker
                                        ng-model="bgCurrentColor"
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
                                        <button class="v-btn"
                                                ng-click="changeBackgroundCanvas(bgCurrentColor);">
                                            <?php _e('Add color','web-to-print-online-designer'); ?>
                                        </button>
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