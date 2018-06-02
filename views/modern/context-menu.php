<div class="nbd-context-menu" id="nbd-context-menu" ng-style="ctxMenuStyle" ng-click="ctxMenuStyle.visibility = 'hidden'">
    <div class="main-context">
        <ul class="contexts">
            <li class="context-item" ng-click="rotateLayer('reflect-hoz')" ng-show="stages[currentStage].states.isLayer"><i class="icon-nbd icon-nbd-reflect-horizontal"></i> <?php _e('Reflect Horizontal','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="rotateLayer('reflect-ver')" ng-show="stages[currentStage].states.isLayer"><i class="icon-nbd icon-nbd-reflect-vertical"></i> <?php _e('Reflect Vertical','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="replaceImage()" ng-show="stages[currentStage].states.isImage"><i class="icon-nbd icon-nbd-replace-image"></i> <?php _e('Replace Image','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('vertical')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-fomat-vertical-align-center rotate90"></i> <?php _e('Align Vertical Center','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('horizontal')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-fomat-vertical-align-center"></i> <?php _e('Align Horizontal Center','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('left')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-fomat-vertical-align-top rotate-90"></i> <?php _e('Align Left','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('right')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-fomat-vertical-align-top rotate90"></i> <?php _e('Align Right','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('top')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-fomat-vertical-align-top"></i> <?php _e('Align Top','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('bottom')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-fomat-vertical-align-top rotate-180"></i> <?php _e('Align Bottom','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('dis-horizontal')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-dis-horizontal"></i> <?php _e('Distribute Horizontal','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="alignLayer('dis-vertical')" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-dis-vertical"></i> <?php _e('Distribute Vertical','web-to-print-online-designer'); ?></li>
            <li class="separator"></li>
            <li class="context-item" ng-click="copyLayers()"><i class="icon-nbd icon-nbd-content-copy"></i> <?php _e('Duplicate','web-to-print-online-designer'); ?></li>
            <li class="context-item"  ng-click="deactiveAllLayer()" ng-show="stages[currentStage].states.isGroup"><i class="icon-nbd icon-nbd-ungroup"></i> <?php _e('Ungroup','web-to-print-online-designer'); ?></li>
            <li class="context-item" ng-click="deleteLayers()"><i class="icon-nbd icon-nbd-delete"></i> <?php _e('Delete','web-to-print-online-designer'); ?></li>
        </ul>
    </div>
</div>