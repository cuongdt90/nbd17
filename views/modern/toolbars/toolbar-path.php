<ul class="nbd-main-menu menu-center tool-path"  ng-show="stages[currentStage].states.isPath">
    <li class="menu-item item-color-fill nbd-show-color-palette" ng-click="stages[currentStage].states.svg.currentPath = $index" ng-repeat="path in stages[currentStage].states.svg.groupPath" end-repeat-color-picker>
        <span ng-style="{'background': path.color}"  class="nbd-tooltip-hover color-fill nbd-color-picker-preview" title="<?php _e('Color','web-to-print-online-designer'); ?>" ></span>
    </li>
</ul>