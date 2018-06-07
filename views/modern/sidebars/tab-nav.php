<div class="tabs-nav">
    <ul class="main-tabs" data-tab="tab-1">
        <div id="selectedTab"></div>
        <li class="tab layerTab active" id="design-tab"><i class="icon-nbd icon-nbd-baseline-palette"></i><span><?php _e('Design','web-to-print-online-designer'); ?></span></li>
        <li ng-click="getProduct()" class="tab tab-first active"><i class="icon-nbd icon-nbd-package"></i><span><?php _e('Product','web-to-print-online-designer'); ?></span></li>
        <li ng-click="getResource('typography', '#tab-typography')" class="tab" ng-if="settings['nbdesigner_enable_text'] == 'yes'"><i class="icon-nbd icon-nbd-text" style="font-size: 21px"></i><span><?php _e('Text','web-to-print-online-designer'); ?></span></li>
        <li ng-click="getResource('clipart', '#tab-svg', true)" class="tab" ng-if="settings['nbdesigner_enable_clipart'] == 'yes'"><i class="icon-nbd icon-nbd-sharp-star" style="font-size: 28px"></i><span><?php _e('Cliparts','web-to-print-online-designer'); ?></span></li>
        <li class="tab" ng-if="settings['nbdesigner_enable_image'] == 'yes'"><i class="icon-nbd icon-nbd-images" style="font-size: 21px"></i><span><?php _e('Photos','web-to-print-online-designer'); ?></span></li>
        <li class="tab"><i class="icon-nbd icon-nbd-geometrical-shapes-group"></i><span><?php _e('Elements','web-to-print-online-designer'); ?></span></li>
        <li class="tab"><i class="icon-nbd icon-nbd-stack"></i><span><?php _e('Layers','web-to-print-online-designer'); ?></span></li>
        <li class="tab tab-end" style="pointer-events: none"></li>
    </ul>
    <div class="keyboard-shortcuts"><i class="icon-nbd icon-nbd-info-circle nbd-tooltip-hover tooltipstered nbd-hover-shadow"></i></div>
    <div class="nbd-sidebar-close"><i class="icon-nbd icon-nbd-clear"></i></div>
</div>