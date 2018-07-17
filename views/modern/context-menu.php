<div class="nbd-context-menu" id="nbd-context-menu" ng-style="ctxMenuStyle" ng-click="ctxMenuStyle.visibility = 'hidden'">
    <div class="main-context">
        <ul class="contexts">
            <li class="context-item" ng-click="rotateLayer('reflect-hoz')" ng-show="stages[currentStage].states.isLayer"><i class="icon-nbd icon-nbd-reflect-horizontal"></i> <?php _e('Reflect Horizontal','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="rotateLayer('reflect-ver')" ng-show="stages[currentStage].states.isLayer"><i class="icon-nbd icon-nbd-reflect-vertical"></i> <?php _e('Reflect Vertical','web-to-print-online-designer'); ?></li>
            <li class="separator" ng-show="stages[currentStage].states.isLayer"></li>
            <li class="context-item" ng-click="setStackPosition('bring-front')" ng-show="stages[currentStage].states.isLayer && !isTemplateMode"><i class="icon-nbd icon-nbd-bring-to-front"></i> <?php _e('Bring to Front','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="setStackPosition('bring-forward')" ng-show="stages[currentStage].states.isLayer && !isTemplateMode"><i class="icon-nbd icon-nbd-bring-forward"></i> <?php _e('Bring Forward','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="setStackPosition('send-backward')" ng-show="stages[currentStage].states.isLayer && !isTemplateMode"><i class="icon-nbd icon-nbd-sent-to-backward"></i> <?php _e('Send to Backward','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="setStackPosition('send-back')" ng-show="stages[currentStage].states.isLayer && !isTemplateMode"><i class="icon-nbd icon-nbd-send-to-back"></i> <?php _e('Send to Back','web-to-print-online-designer'); ?></li>
            <li class="separator" ng-show="stages[currentStage].states.isLayer && !isTemplateMode"></li>
            <li class="context-item" ng-click="translateLayer('vertical')" ng-show="stages[currentStage].states.isLayer && !isTemplateMode"><i class="icon-nbd icon-nbd-fomat-vertical-align-center"></i> <?php _e('Center horizontal','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="translateLayer('horizontal')" ng-show="stages[currentStage].states.isLayer && !isTemplateMode"><i class="icon-nbd icon-nbd-fomat-vertical-align-center rotate90"></i> <?php _e('Center vertical','web-to-print-online-designer'); ?></li>
            <!--  Group  -->
            <li class="context-item" ng-click="alignLayer('vertical')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-fomat-vertical-align-center rotate90"></i> <?php _e('Align Vertical Center','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('horizontal')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-fomat-vertical-align-center"></i> <?php _e('Align Horizontal Center','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('left')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-fomat-vertical-align-top rotate-90"></i> <?php _e('Align Left','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('right')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-fomat-vertical-align-top rotate90"></i> <?php _e('Align Right','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('top')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-fomat-vertical-align-top"></i> <?php _e('Align Top','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('bottom')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-fomat-vertical-align-top rotate-180"></i> <?php _e('Align Bottom','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('dis-horizontal')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-dis-horizontal"></i> <?php _e('Distribute Horizontal','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('dis-vertical')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-dis-vertical"></i> <?php _e('Distribute Vertical','web-to-print-online-designer'); ?></li>
            <!--  Template Mode  -->
            <li ng-class="stages[currentStage].states.elementUpload ? 'active' : ''" ng-click="setLayerAttribute('elementUpload', !stages[currentStage].states.elementUpload)" class="context-item" ng-show="stages[currentStage].states.isImage && isTemplateMode"><i class="icon-nbd icon-nbd-replace-image"></i> <?php _e('Replace Image','web-to-print-online-designer'); ?></li>
            <li ng-class="stages[currentStage].states.selectable ? '' : 'active'" class="context-item" ng-click="setLayerAttribute('selectable', !stages[currentStage].states.selectable)" ng-show="stages[currentStage].states.isLayer && isTemplateMode">
                <i style="padding-left: 3px;" class="icon-nbd icon-nbd-lock"></i> <?php _e('Lock all adjustment','web-to-print-online-designer'); ?>
            </li>
<!--            <li ng-class="!stages[currentStage].states.fixedWidth ? '' : 'active'" class="context-item" ng-click="setLayerAttribute('fixedWidth', !stages[currentStage].states.fixedWidth)" ng-show="stages[currentStage].states.isText && isTemplateMode">
                <i style="padding-left: 3px;" class="icon-nbd icon-nbd-lock"></i> <?php _e('Edit only','web-to-print-online-designer'); ?>
            </li>            -->
            <li ng-class="!stages[currentStage].states.lockMovementX ? '' : 'active'" class="context-item" ng-click="setLayerAttribute('lockMovementX', !stages[currentStage].states.lockMovementX)" ng-show="stages[currentStage].states.isLayer && isTemplateMode">
                <i style="font-size: 18px;" class="icon-nbd icon-nbd-arrows-h"></i> <?php _e('Lock horizontal movement','web-to-print-online-designer'); ?>
            </li>       
            <li ng-class="!stages[currentStage].states.lockMovementY ? '' : 'active'" class="context-item" ng-click="setLayerAttribute('lockMovementY', !stages[currentStage].states.lockMovementY)" ng-show="stages[currentStage].states.isLayer && isTemplateMode">
                <i style="padding-left: 5px; font-size: 18px;" class="icon-nbd icon-nbd-arrows-v"></i> <?php _e('Lock vertical movement','web-to-print-online-designer'); ?>
            </li>
            <li ng-class="!stages[currentStage].states.lockScalingX ? '' : 'active'" class="context-item" ng-click="setLayerAttribute('lockScalingX', !stages[currentStage].states.lockScalingX)" ng-show="stages[currentStage].states.isLayer && isTemplateMode">
                <i style="font-size: 18px;" class="icon-nbd icon-nbd-expand horizontal horizontal-x"><sub>x</sub></i> <?php _e('Lock horizontal scaling','web-to-print-online-designer'); ?>
            </li>     
            <li ng-class="!stages[currentStage].states.lockScalingY ? '' : 'active'" class="context-item" ng-click="setLayerAttribute('lockScalingY', !stages[currentStage].states.lockScalingY)" ng-show="stages[currentStage].states.isLayer && isTemplateMode">
                <i style="font-size: 18px;" class="icon-nbd icon-nbd-expand horizontal horizontal-y"><sub>y</sub></i> <?php _e('Lock vertical scaling','web-to-print-online-designer'); ?>
            </li>
            <li ng-class="!stages[currentStage].states.lockRotation ? '' : 'active'" class="context-item" ng-click="setLayerAttribute('lockRotation', !stages[currentStage].states.lockRotation)" ng-show="stages[currentStage].states.isLayer && isTemplateMode">
                <i class="icon-nbd icon-nbd-refresh rotate180"></i> <?php _e('Lock rotation','web-to-print-online-designer'); ?>
            </li>         
            <!--  Template Mode  -->
            <li class="separator"></li>
            <li class="context-item" ng-click="copyLayers()"><i class="icon-nbd icon-nbd-content-copy"></i> <?php _e('Duplicate','web-to-print-online-designer'); ?></li>
            <li class="context-item"  ng-click="deactiveAllLayer()" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-ungroup"></i> <?php _e('Ungroup','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="deleteLayers()"><i class="icon-nbd icon-nbd-delete"></i> <?php _e('Delete','web-to-print-online-designer'); ?></li>
        </ul>
    </div>
</div>