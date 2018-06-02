<div class="toolbar-common">
    <ul class="nbd-main-menu">
        <li class="menu-item item-opacity" data-range="true">
            <i class="icon-nbd icon-nbd-opacity nbd-tooltip-hover" title="<?php _e('Opacity','web-to-print-online-designer'); ?>"></i>
            <div class="sub-menu" data-pos="center">
                <div class="main-ranges" style="padding: 30px 15px 10px;">
                    <div class="range range-opacity">
                        <label><?php _e('Opacity','web-to-print-online-designer'); ?></label>
                        <div class="main-track">
                            <input class="slide-input" type="range" step="1" min="0" max="100" ng-mouseup="changeOpacity()" ng-model="stages[currentStage].states.opacity">
                            <span class="range-track"></span>
                        </div>
                        <span class="value-display">{{stages[currentStage].states.opacity}}</span>
                    </div>
                </div>
            </div>
        </li>
        <li class="menu-item item-stack" ng-class="stages[currentStage].states.isLayer ? '' : 'nbd-disabled'">
            <i class="icon-nbd icon-nbd-layer-stack nbd-tooltip-hover" title="<?php _e('Layer stack','web-to-print-online-designer'); ?>"></i>
            <div class="sub-menu" data-pos="right">
                <ul>
                    <li class="sub-menu-item" ng-click="setStackPosition('bring-front')">
                        <i class="icon-nbd icon-nbd-bring-to-front"></i>
                        <span><?php _e('Bring to Front','web-to-print-online-designer'); ?></span>
                        <span class="keyboard">Ctrl+Shift+]</span>
                    </li>
                    <li class="sub-menu-item" ng-click="setStackPosition('bring-forward')">
                        <i class="icon-nbd icon-nbd-bring-forward"></i>
                        <span><?php _e('Bring Forward','web-to-print-online-designer'); ?></span>
                        <span class="keyboard">Ctrl+]</span>
                    </li>
                    <li class="sub-menu-item" ng-click="setStackPosition('send-backward')">
                        <i class="icon-nbd icon-nbd-sent-to-backward"></i>
                        <span><?php _e('Send to Backward','web-to-print-online-designer'); ?></span>
                        <span class="keyboard">Ctrl+[</span>
                    </li>
                    <li class="sub-menu-item" ng-click="setStackPosition('send-back')">
                        <i class="icon-nbd icon-nbd-send-to-back"></i>
                        <span><?php _e('Send to Back','web-to-print-online-designer'); ?></span>
                        <span class="keyboard">Ctrl+Shift+[</span>
                    </li>
                </ul>
            </div>
        </li>
        <li class="menu-item item-position">
            <i class="icon-nbd icon-nbd-apps nbd-tooltip-hover" title="<?php _e('layer position','web-to-print-online-designer'); ?>"></i>
            <div class="sub-menu" data-pos="right">
                <ul>
                    <i class="icon-nbd-clear nbd-close-sub-menu"></i>
                    <li class="title">
                        <span>Layer position</span>
                        <i class="colse"></i>
                    </li>
                    <li ng-click="translateLayer('vertical')"><i class="icon-nbd icon-nbd-fomat-vertical-align-center nbd-tooltip-hover" title="<?php _e('Center horizontal','web-to-print-online-designer'); ?>"></i></li>
                    <li ng-click="translateLayer('top-left')"><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate-90" title="<?php _e('Top left','web-to-print-online-designer'); ?>"></i></li>
                    <li ng-click="translateLayer('top-center')"><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate-45" title="<?php _e('Top center','web-to-print-online-designer'); ?>"></i></li>
                    <li ng-click="translateLayer('top-right')"><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover" title="Top right"></i></li>
                    <li ng-click="translateLayer('horizontal')"><i class="icon-nbd icon-nbd-fomat-vertical-align-center nbd-tooltip-hover rotate90" title="<?php _e('Center vertical','web-to-print-online-designer'); ?>"></i></li>
                    <li ng-click="translateLayer('middle-left')"><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate-135" title="<?php _e('Middle left','web-to-print-online-designer'); ?>"></i></li>
                    <li ng-click="translateLayer('center')"><i class="icon-nbd icon-nbd-bottom-center nbd-tooltip-hover middle-center" title="<?php _e('Middle center','web-to-print-online-designer'); ?>"></i></li>
                    <li ng-click="translateLayer('middle-right')"><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate45" title="<?php _e('Middle right','web-to-print-online-designer'); ?>"></i></li>
                    <li style="opacity: 0;visibility: hidden"><i class="icon-nbd icon-nbd-info-circle nbd-tooltip-hover" title="<?php _e('Intro','web-to-print-online-designer'); ?>"></i></li>
                    <li ng-click="translateLayer('bottom-left')"><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate-180" title="<?php _e('Bottom left','web-to-print-online-designer'); ?>"></i></li>
                    <li ng-click="translateLayer('bottom-center')"><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate135" title="<?php _e('Bottom center','web-to-print-online-designer'); ?>"></i></li>
                    <li ng-click="translateLayer('bottom-right')"><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate90" title="<?php _e('Bottom right','web-to-print-online-designer'); ?>"></i></li>
                </ul>
            </div>
        </li>
    </ul>
</div>