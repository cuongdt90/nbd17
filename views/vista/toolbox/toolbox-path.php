<div class="v-toolbox-path v-toolbox-item" ng-class="stages[currentStage].states.isShowToolBox ? 'nbd-show' : ''" ng-show="stages[currentStage].states.isPath || stages[currentStage].states.isShape" ng-style="stages[currentStage].states.toolboxStyle">
    <div class="v-triangle" data-pos="{{stages[currentStage].states.toolboxTriangle}}">
        <div class="header-box">
            <span ng-if="stages[currentStage].states.isPath">Path</span>
            <span ng-if="stages[currentStage].states.isShape">Shape</span>
        </div>
        <div class="main-box">
            <?php include __DIR__ . '/../toollock.php'?>
            <div class="toolbox-row toolbox-second toolbox-general">
                <ul class="items v-assets nbd-justify-content-start">
<!--                    <li class="item toolbox-color-palette">-->
<!--                        <div class="v-dropdown">-->
<!--                            <button class="v-btn btn-color v-btn-dropdown" title="Text color">-->
<!--                                <span class="color-selected" ng-style="{'background-color': currentColor}"></span>-->
<!--                                <i class="nbd-icon-vista nbd-icon-vista-expand-more"></i>-->
<!--                            </button>-->
<!--                            <div class="v-dropdown-menu">-->
<!--                                --><?php //include __DIR__ . '/../color-palette.php'?>
<!--                            </div>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li class="item v-asset" style="visibility: hidden;"></li>-->
                    <li class="item v-asset v-asset-margin item-color-palette nbdColorPalette " ng-click="stages[currentStage].states.svg.currentPath = $index" ng-repeat="path in stages[currentStage].states.svg.groupPath" end-repeat-color-picker>
                        <span style="width: 100%; height: 100%;" ng-style="{'background': path.color}" class="color-fill nbd-color-picker-preview" title="<?php _e('Color','web-to-print-online-designer'); ?>"></span>
                    </li>
                </ul>
                <?php include __DIR__ . '/../color-palette.php'?>
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