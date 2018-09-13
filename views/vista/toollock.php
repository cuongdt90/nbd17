<!--<div class="nbd-tool-lock" style="display: none">-->
<!--    <div class="main-tool-lock">-->
<!--        <ul class="items-lock">-->
<!--            <li class="item-lock nbd-tooltip-hover-left" title="Lock all adjustment"><i class="nbd-icon-vista nbd-icon-vista-lock"></i></li>-->
<!--            <li class="item-lock nbd-tooltip-hover-left" title="Lock horizontal movement"><i class="nbd-icon-vista nbd-icon-vista-arrows-h"></i></li>-->
<!--            <li class="item-lock active nbd-tooltip-hover-left" title="Lock vertical movement"><i class="nbd-icon-vista nbd-icon-vista-arrows-v"></i></li>-->
<!--            <li class="item-lock nbd-tooltip-hover-left" title="Lock horizontal scaling"><i class="nbd-icon-vista nbd-icon-vista-expand horizontal horizontal-x"><sub>x</sub></i></li>-->
<!--            <li class="item-lock nbd-tooltip-hover-left" title="Lock vertical scaling"><i class="nbd-icon-vista nbd-icon-vista-expand horizontal horizontal-y"><sub>y</sub></i></li>-->
<!--            <li class="item-lock nbd-tooltip-hover-left" title="Lock rotation"><i class="nbd-icon-vista nbd-icon-vista-refresh rotate180"></i></li>-->
<!--        </ul>-->
<!--    </div>-->
<!--</div>-->

<?php if ($isTask && current_user_can('administrator')) :?>
    <div class="toolbox-row toolbox-second toolbox-lock" ng-if="!stages[currentStage].states.isGroup">
        <ul class="items v-assets">
            <li class="item v-asset item-lock-horizontal-movement"
                ng-class="!stages[currentStage].states.lockMovementX ? '' : 'active'"
                ng-click="setLayerAttribute('lockMovementX', !stages[currentStage].states.lockMovementX)"
                ng-show="stages[currentStage].states.isLayer && isTemplateMode"
                title="<?php _e('Lock horizontal movement','web-to-print-online-designer'); ?>">
                <i class="nbd-icon-vista nbd-icon-vista-arrows-h"></i>
            </li>
            <li class="item v-asset item-lock-vertical-movement"
                ng-class="!stages[currentStage].states.lockMovementY ? '' : 'active'"
                ng-click="setLayerAttribute('lockMovementY', !stages[currentStage].states.lockMovementY)"
                ng-show="stages[currentStage].states.isLayer && isTemplateMode"
                title="<?php _e('Lock vertical movement','web-to-print-online-designer'); ?>">
                <i class="nbd-icon-vista nbd-icon-vista-arrows-v"></i>
            </li>
            <li class="item v-asset item-lock-horizontal-scaling"
                ng-class="!stages[currentStage].states.lockScalingX ? '' : 'active'"
                ng-click="setLayerAttribute('lockScalingX', !stages[currentStage].states.lockScalingX)"
                ng-show="stages[currentStage].states.isLayer && isTemplateMode"
                title="<?php _e('Lock horizontal scaling','web-to-print-online-designer'); ?>">
                <i class="nbd-icon-vista nbd-icon-vista-expand horizontal horizontal-x"><sub>x</sub></i>
            </li>
            <li class="item v-asset item-lock-vertical-scaling"
                ng-class="!stages[currentStage].states.lockScalingY ? '' : 'active'"
                ng-click="setLayerAttribute('lockScalingY', !stages[currentStage].states.lockScalingY)"
                ng-show="stages[currentStage].states.isLayer && isTemplateMode"
                title="<?php _e('Lock vertical scaling','web-to-print-online-designer'); ?>">
                <i class="nbd-icon-vista nbd-icon-vista-expand horizontal horizontal-y"><sub>y</sub></i>
            </li>
            <li class="item v-asset" style="visibility: hidden"></li>
        </ul>
    </div>
<?php endif; ?>