<div class="toolbar-common">
    <ul class="nbd-main-menu">
        <li class="menu-item item-color-fill">
            <span style="background: #06d79c; width: 21px; height: 21px; border-radius: 4px;display: inline-block;"  class="nbd-tooltip-hover color-fill" title="<?php _e('Color','web-to-print-online-designer'); ?>" ></span>
            <div class="sub-menu" data-pos="center">
                <div class="nbd-color-palette" style="position: relative">
                    <div class="working-palette" ng-if="settings['nbdesigner_show_all_color'] == 'yes'">
                        <h3 class="color-palette-label"><?php _e('Set color','web-to-print-online-designer'); ?></h3>
                        <ul class="main-color-palette">
                            <li class="color-palette-add">

                            </li>
                            <li class="color-palette-item" data-color="#253702" title="#253702" style="color: red;"></li>
                        </ul>
                    </div>
                    <div class="pinned-palette default-palette">
                        <h3 class="color-palette-label"><?php _e('Default color','web-to-print-online-designer'); ?></h3>
                        <ul class="main-color-palette">
                            <li ng-repeat="color in __colorPalette track by $index" class="color-palette-item" data-color="{{color}}" title="{{__colorPalette}}" ng-style="{'background': color}">{{__colorPalette}}</li>
                        </ul>
                    </div>
                    <div class="pinned-palette default-palette">
                        <ul class="main-color-palette">
                            <li class="color-palette-item" data-color="#000000" title="#000000" style="background-color: #000000;"></li>
                            <li class="color-palette-item" data-color="#666666" title="#666666" style="background-color: #666666;"></li>
                            <li class="color-palette-item" data-color="#a8a8a8" title="#a8a8a8" style="background-color: #a8a8a8;"></li>
                            <li class="color-palette-item" data-color="#d9d9d9" title="#d9d9d9" style="background-color: #d9d9d9;"></li>
                            <li class="color-palette-item" data-color="#ffffff" title="#ffffff" style="background-color: #ffffff;"></li>
                        </ul>
                    </div>
                    <div class="nbd-color-picker" style="position: absolute; left: -0; transform: translateX(-100%); top: 0; ">
                        <spectrum-colorpicker
                                ng-model="colorBackground"
                                ng-change="changeBackgroundColor(colorBackground)"
                                options="{
                                    color: '#169ddf',
                                    preferredFormat: 'hex',
                                    flat: true,
                                    showInput: true,
                                    containerClassName: 'nbd-sp',
                                    chooseText: '<?php _e('OK','web-to-print-online-designer'); ?>',
                                    cancelText: '<?php _e('Cancel','web-to-print-online-designer'); ?>'
                        }">
                        </spectrum-colorpicker>                        
                    </div>
                </div>
            </div>
        </li>
        <li class="menu-item item-stack">
            <i class="icon-nbd icon-nbd-layer-stack nbd-tooltip-hover" title="layer stack"></i>
            <div class="sub-menu" data-pos="right">
                <ul>
                    <li class="sub-menu-item">
                        <i class="icon-nbd icon-nbd-bring-to-front"></i>
                        <span><?php _e('Bring to Front','web-to-print-online-designer'); ?></span>
                        <span class="keyboard">Ctrl+Shift+]</span>
                    </li>
                    <li class="sub-menu-item">
                        <i class="icon-nbd icon-nbd-bring-forward"></i>
                        <span><?php _e('Bring Forward','web-to-print-online-designer'); ?></span>
                        <span class="keyboard">Ctrl+]</span>
                    </li>
                    <li class="sub-menu-item">
                        <i class="icon-nbd icon-nbd-sent-to-backward"></i>
                        <span><?php _e('Send to Backward','web-to-print-online-designer'); ?></span>
                        <span class="keyboard">Ctrl+[</span>
                    </li>
                    <li class="sub-menu-item">
                        <i class="icon-nbd icon-nbd-send-to-back"></i>
                        <span><?php _e('Send to Back','web-to-print-online-designer'); ?></span>
                        <span class="keyboard">Ctrl+Shift+[</span>
                    </li>
                </ul>
            </div>
        </li>
        <li class="menu-item item-position">
            <i class="icon-nbd icon-nbd-apps nbd-tooltip-hover" title="layer position"></i>
            <div class="sub-menu" data-pos="right">
                <ul>
                    <i class="icon-nbd-clear nbd-close-sub-menu"></i>
                    <li class="title">
                        <span>Layer position</span>
                        <i class="colse"></i>
                    </li>
                    <li><i class="icon-nbd icon-nbd-fomat-vertical-align-center nbd-tooltip-hover" title="Center vertical"></i></li>
                    <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate-90" title="Top left"></i></li>
                    <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate-45" title="Top center"></i></li>
                    <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover" title="Top right"></i></li>
                    <li><i class="icon-nbd icon-nbd-fomat-vertical-align-center nbd-tooltip-hover rotate90" title="Center horizontal"></i></li>
                    <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate-135" title="Middle left"></i></li>
                    <li><i class="icon-nbd icon-nbd-bottom-center nbd-tooltip-hover middle-center" title="Middle center"></i></li>
                    <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate45" title="Middle right"></i></li>
                    <li style="opacity: 0;visibility: hidden"><i class="icon-nbd icon-nbd-info-circle nbd-tooltip-hover" title="Intro"></i></li>
                    <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate-180" title="Bottom left"></i></li>
                    <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate135" title="Bottom center"></i></li>
                    <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate90" title="Bottom right"></i></li>
                </ul>
            </div>
        </li>
    </ul>
</div>