<div class="tabs-nav">
    <ul class="main-tabs" data-tab="tab-1">
        <div id="selectedTab"></div>
        <li class="tab layerTab active animated slideInLeft animate300" id="design-tab"><i class="icon-nbd icon-nbd-baseline-palette"></i><span><?php _e('Design','web-to-print-online-designer'); ?></span></li>
        <?php if(count($templates) != 0 ): ?>
        <li ng-click="disableDrawMode();getProduct()" class="tab tab-first active animated slideInLeft animate400"><i class="icon-nbd icon-nbd-package"></i><span><?php _e('Templates','web-to-print-online-designer'); ?></span></li>
        <?php endif; ?>
        <li id="tab-typo" ng-click="disableDrawMode();getResource('typography', '#tab-typography')" class="<?php if(count($templates) == 0 ) echo 'active'; ?> tab animated slideInLeft animate500" ng-if="settings['nbdesigner_enable_text'] == 'yes'"><i class="icon-nbd icon-nbd-text" style="font-size: 21px"></i><span><?php _e('Text','web-to-print-online-designer'); ?></span></li>
        <li ng-click="disableDrawMode();getResource('clipart', '#tab-svg', true)" class="tab animated slideInLeft animate600" ng-if="settings['nbdesigner_enable_clipart'] == 'yes'"><i class="icon-nbd icon-nbd-sharp-star" style="font-size: 28px"></i><span><?php _e('Cliparts','web-to-print-online-designer'); ?></span></li>
        <li class="tab animated slideInLeft animate700" ng-click="disableDrawMode()" ng-if="settings['nbdesigner_enable_image'] == 'yes'"><i class="icon-nbd icon-nbd-images" style="font-size: 21px"></i><span><?php _e('Photos','web-to-print-online-designer'); ?></span></li>
        <li class="tab animated slideInLeft animate800" ng-click="disableDrawMode()"><i class="icon-nbd icon-nbd-geometrical-shapes-group"></i><span><?php _e('Elements','web-to-print-online-designer'); ?></span></li>
        <li class="tab animated slideInLeft animate900" ng-click="disableDrawMode()"><i class="icon-nbd icon-nbd-stack"></i><span><?php _e('Layers','web-to-print-online-designer'); ?></span></li>
        <li class="tab tab-end" style="pointer-events: none"></li>
    </ul>
    <div class="keyboard-shortcuts"><i class="icon-nbd icon-nbd-info-circle nbd-tooltip-hover tooltipstered nbd-hover-shadow"></i></div>
    <div class="nbd-sidebar-close"><i class="icon-nbd icon-nbd-clear"></i></div>
</div>