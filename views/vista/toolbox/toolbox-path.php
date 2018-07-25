<div class="v-toolbox-path v-toolbox-item" ng-class="stages[currentStage].states.isShowToolBox ? 'nbd-show' : ''" ng-show="stages[currentStage].states.isPath || stages[currentStage].states.isShape || stages[currentStage].states.isNativeGroup" ng-style="stages[currentStage].states.toolboxStyle">
    <div class="v-triangle" data-pos="{{stages[currentStage].states.toolboxTriangle}}">
        <div class="header-box">
            <span ng-if="stages[currentStage].states.isPath">Path</span>
            <span ng-if="stages[currentStage].states.isShape">Shape</span>
        </div>
        <div class="main-box">
            <?php include __DIR__ . '/../toollock.php'?>
            <div class="toolbox-row toolbox-second toolbox-color-palette">
                <ul class="items v-assets nbd-justify-content-start">
                    <li class="item v-asset v-asset-margin item-color-palette nbdColorPalette" ng-click="stages[currentStage].states.svg.currentPath = $index" ng-repeat="path in stages[currentStage].states.svg.groupPath" end-repeat-color-picker>
                        <span style="width: 100%; height: 100%;" ng-style="{'background': path.color}" class="color-fill nbd-color-picker-preview" title="<?php _e('Color','web-to-print-online-designer'); ?>"></span>
                    </li>
                </ul>
                <div class="nbd-color-palette">
                    <div class="nbd-color-palette-inner">
                        <div class="working-palette" ng-if="settings['nbdesigner_show_all_color'] == 'yes'" style="margin-bottom: 10px">
                            <h3 class="color-palette-label">Set color</h3>
                            <ul class="main-color-palette tab-scroll">
                                <li class="color-palette-add" ng-style="{'background-color': currentColor}"></li>
                                <li
                                        ng-repeat="color in listAddedColor track by $index"
                                        ng-click="changeFill(color)"
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
                                    ng-click="changeFill(color)"
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
                                <button class="v-btn"
                                        ng-click="addColor();changeFill(currentColor);">
                                    <?php _e('Add color','web-to-print-online-designer'); ?>
                                </button>
                            </div>
                        </div>
                        <div class="v-triangle-box"></div>
                        <div class="close-block"><i class="nbd-icon-vista nbd-icon-vista-clear"></i></div>
                    </div>
                </div>
            </div>
            <div class="toolbox-row toolbox-delete">
                <ul class="items v-assets">
                    <li class="item v-asset item-delete"
                        ng-click="deleteLayers()"
                        title="Delete path">
                        <i class="nbd-icon-vista nbd-icon-vista-clear"></i>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-box">
            <div class="main-footer" title="Done" ng-click="onClickDone()">
                <i class="nbd-icon-vista nbd-icon-vista-done"></i>
            </div>
        </div>
    </div>
</div>