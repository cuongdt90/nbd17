<div class="tabs-nav">
    <ul class="main-tabs" data-tab="tab-1">
        <div id="selectedTab"></div>
        <li class="tab layerTab active animated slideInLeft animate300" id="design-tab"><i class="icon-nbd icon-nbd-baseline-palette"></i><span><?php _e('Design','web-to-print-online-designer'); ?></span></li>
        <?php if( $product_data["option"]['admindesign'] != "0" ): ?>
        <li ng-click="disableDrawMode();getProduct()" class="tab tab-first active animated slideInLeft animate400"><i class="icon-nbd icon-nbd-package"></i><span><?php _e('Templates','web-to-print-online-designer'); ?></span></li>
        <?php endif; ?>
        <li id="tab-typo" data-title="Typography" data-tour-active ng-click="disableDrawMode();getResource('typography', '#tab-typography')" class="<?php if($product_data["option"]['admindesign'] == "0" ) echo 'active'; ?> tab animated slideInLeft animate500" ng-if="settings['nbdesigner_enable_text'] == 'yes'"><i class="icon-nbd icon-nbd-text" style="font-size: 21px"></i><span><?php _e('Text','web-to-print-online-designer'); ?></span></li>
        <li data-title="Clipart" ng-click="disableDrawMode();getResource('clipart', '#tab-svg', true)" class="tab animated slideInLeft animate600 nav-tab-clipart" ng-if="settings['nbdesigner_enable_clipart'] == 'yes'"><i class="icon-nbd icon-nbd-sharp-star" style="font-size: 28px"></i><span><?php _e('Cliparts','web-to-print-online-designer'); ?></span></li>
        <li data-title="Photos" class="tab animated slideInLeft animate700 nav-tab-photos" ng-click="disableDrawMode()" ng-if="settings['nbdesigner_enable_image'] == 'yes'"><i class="icon-nbd icon-nbd-images" style="font-size: 21px"></i><span><?php _e('Photos','web-to-print-online-designer'); ?></span></li>
        <li data-title="Elements" class="tab animated slideInLeft animate800 nav-tab-elements" ng-click="disableDrawMode()"><i class="icon-nbd icon-nbd-geometrical-shapes-group"></i><span><?php _e('Elements','web-to-print-online-designer'); ?></span></li>
        <li data-title="Layers" class="tab animated slideInLeft animate900 nav-tab-layers" ng-click="disableDrawMode()"><i class="icon-nbd icon-nbd-stack"></i><span><?php _e('Layers','web-to-print-online-designer'); ?></span></li>
        <li class="tab tab-end" style="pointer-events: none"></li>
    </ul>
    <div class="keyboard-shortcuts"><i class="icon-nbd icon-nbd-info-circle nbd-tooltip-hover tooltipstered nbd-hover-shadow"></i></div>
    <div class="tour-start">
        <svg class="svg-tour" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 330 330" style="enable-background:new 0 0 330 330;" xml:space="preserve"><g>
            <path d="M165,0C74.019,0,0,74.018,0,164.999C0,255.98,74.019,330,165,330s165-74.02,165-165.001C330,74.018,255.981,0,165,0z
                 M165,300c-74.439,0-135-60.561-135-135.001C30,90.56,90.561,30,165,30s135,60.56,135,134.999C300,239.439,239.439,300,165,300z"/>
            <path d="M165.002,230c-11.026,0-19.996,8.968-19.996,19.991c0,11.033,8.97,20.009,19.996,20.009
                c11.026,0,19.996-8.976,19.996-20.009C184.998,238.968,176.028,230,165.002,230z"/>
            <path d="M165,60c-30.342,0-55.026,24.684-55.026,55.024c0,8.284,6.716,15,15,15c8.284,0,15-6.716,15-15
                C139.974,101.226,151.2,90,165,90s25.027,11.226,25.027,25.024c0,13.8-11.227,25.026-25.027,25.026c-8.284,0-15,6.716-15,15V185
                c0,8.284,6.716,15,15,15s15-6.716,15-15v-17.044c23.072-6.548,40.027-27.79,40.027-52.931C220.027,84.684,195.342,60,165,60z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
        </svg>
    </div>
    <div class="nbd-sidebar-close"><i class="icon-nbd icon-nbd-clear"></i></div>
</div>