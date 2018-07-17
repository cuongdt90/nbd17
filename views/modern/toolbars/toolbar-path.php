<ul class="nbd-main-menu menu-center tool-path"  ng-show="stages[currentStage].states.isPath || stages[currentStage].states.isNativeGroup">
    <li ng-click="unGroupLayers()" class="menu-item menu-group" ng-show="stages[currentStage].states.isNativeGroup">
        <i style="border-right: 1px solid #ebebeb;padding-right: 10px;margin-top: 8px;" class="icon-nbd icon-nbd-ungroup nbd-tooltip-hover tooltipstered" title="<?php _e('Ungroup','web-to-print-online-designer'); ?>"></i>
    </li>
    <li class="menu-item item-color-fill nbd-show-color-palette" ng-click="stages[currentStage].states.svg.currentPath = $index" ng-repeat="path in stages[currentStage].states.svg.groupPath" end-repeat-color-picker>
        <span ng-style="{'background': path.color}"  class="nbd-tooltip-hover color-fill nbd-color-picker-preview" title="<?php _e('Color','web-to-print-online-designer'); ?>" ></span>
    </li>
</ul>