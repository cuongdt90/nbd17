<div class="v-toolbox-image v-toolbox-item" ng-class="stages[currentStage].states.isShowToolBox ? 'nbd-show' : ''" ng-show="stages[currentStage].states.isImage" ng-style="stages[currentStage].states.toolboxStyle">
    <div class="v-triangle" data-pos="{{stages[currentStage].states.toolboxTriangle}}">
        <div class="header-box">
            <span>Image edit</span>
        </div>
        <div class="main-box">
            <div class="toolbox-row toolbox-first">
                <div class="toolbox-general">
                    <ul class="v-assets items">
                        <li class="item" title="Rotate" ng-click="rotateLayer('90cw')">
                            <div class="v-asset"><i class="nbd-icon-vista nbd-icon-vista-rotate-right"></i></div>
                            <span class="v-asset-title">rotate</span>
                        </li>
                        <li class="item" title="Reset">
                            <div class="v-asset"><i class="nbd-icon-vista nbd-icon-vista-refresh"></i></div>
                            <span class="v-asset-title">reset</span>
                        </li>
                        <?php if ($isTask && current_user_can('administrator')) :?>
                        <li
                            ng-class="stages[currentStage].states.elementUpload ? 'active' : ''"
                            ng-click="setLayerAttribute('elementUpload', !stages[currentStage].states.elementUpload)"
                            class="item"
                            ng-show="stages[currentStage].states.isImage && isTemplateMode"
                            title="Replace image">
                            <div class="v-asset"><i class="nbd-icon-vista nbd-icon-vista-replace-image"></i></div>
                            <span class="v-asset-title">replace</span>
                        </li>
                        <?php endif; ?>
                        <li class="item" title="Remove" ng-click="deleteLayers()">
                            <div class="v-asset"><i class="nbd-icon-vista nbd-icon-vista-clear"></i></div>
                            <span class="v-asset-title">remove</span>
                        </li>
                    </ul>
                </div>

                <div class="toolbox-directional">
                    <div class="item-direct rotate180" ng-click="moveLayer('up',1)"><i class="nbd-icon-vista nbd-icon-vista-expand-more"></i></div>
                    <div class="item-direct rotate-90" ng-click="moveLayer('right',1)"><i class="nbd-icon-vista nbd-icon-vista-expand-more"></i></div>
                    <div class="item-direct" ng-click="moveLayer('down',1)"><i class="nbd-icon-vista nbd-icon-vista-expand-more"></i></div>
                    <div class="item-direct rotate90" ng-click="moveLayer('left',1)"><i class="nbd-icon-vista nbd-icon-vista-expand-more"></i></div>
                </div>
            </div>

            <?php if ($isTask && current_user_can('administrator')) :?>
                <div class="toolbox-row toolbox-second toolbox-lock" ng-if="!stages[currentStage].states.isGroup">
                    <ul class="items v-assets" style="width: calc(100% - 88px)">
                        <li class="item v-asset item-lock-horizontal-movement"
                            ng-class="!stages[currentStage].states.lockMovementX ? '' : 'active'"
                            ng-click="setLayerAttribute('lockMovementX', !stages[currentStage].states.lockMovementX)"
                            ng-show="stages[currentStage].states.isLayer && isTemplateMode"
                            title="Lock horizontal movement">
                            <i class="nbd-icon-vista nbd-icon-vista-arrows-h"></i>
                        </li>
                        <li class="item v-asset item-lock-vertical-movement"
                            ng-class="!stages[currentStage].states.lockMovementY ? '' : 'active'"
                            ng-click="setLayerAttribute('lockMovementY', !stages[currentStage].states.lockMovementY)"
                            ng-show="stages[currentStage].states.isLayer && isTemplateMode"
                            title="Lock vertical movement">
                            <i class="nbd-icon-vista nbd-icon-vista-arrows-v"></i>
                        </li>
                        <li class="item v-asset item-lock-horizontal-scaling"
                            ng-class="!stages[currentStage].states.lockScalingX ? '' : 'active'"
                            ng-click="setLayerAttribute('lockScalingX', !stages[currentStage].states.lockScalingX)"
                            ng-show="stages[currentStage].states.isLayer && isTemplateMode"
                            title="Lock horizontal scaling">
                            <i class="nbd-icon-vista nbd-icon-vista-expand horizontal horizontal-x"><sub>x</sub></i>
                        </li>
                        <li class="item v-asset item-lock-vertical-scaling"
                            ng-class="!stages[currentStage].states.lockScalingY ? '' : 'active'"
                            ng-click="setLayerAttribute('lockScalingY', !stages[currentStage].states.lockScalingY)"
                            ng-show="stages[currentStage].states.isLayer && isTemplateMode"
                            title="Lock vertical scaling">
                            <i class="nbd-icon-vista nbd-icon-vista-expand horizontal horizontal-y"><sub>y</sub></i>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="toolbox-row toolbox-last toolbox-zoom">
                <div class="v-assets">
                    <div class="v-asset" title="Zoom out" ng-click="scaleLayer('-')"><i class="nbd-icon-vista nbd-icon-vista-zoom-out"></i></div>
                    <div class="v-ranges" style="display: none">
                        <div class="main-track">
                            <input class="slide-input" type="range" step="1" min="0" max="100">
                            <span class="range-track"></span>
                        </div>
                    </div>
                    <div class="v-asset" title="Zoom in" ng-click="scaleLayer('+')"><i class="nbd-icon-vista nbd-icon-vista-zoom-in"></i></div>
                </div>
            </div>
        </div>
        <div class="footer-box">
            <div class="main-footer" title="Done" ng-click="onClickDone()">
                <i class="nbd-icon-vista nbd-icon-vista-done"></i>
            </div>
        </div>
    </div>
</div>