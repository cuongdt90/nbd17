<div class="nbd-main-bar">
    <a href="#" class="logo"><img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/netbaseteam.png" alt="online design"></a>
    <i class="icon-nbd icon-nbd-menu menu-mobile"></i>
    <ul class="nbd-main-menu menu-left">
        <li class="menu-item item-edit">
            <span><?php _e('Edit','web-to-print-online-designer'); ?></span>
            <div class="sub-menu" data-pos="left">
                <ul>
                    <li class="sub-menu-item flex space-between">
                        <span><?php _e('Import file','web-to-print-online-designer'); ?></span>
                        <small>Ctrl+O</small>
                    </li>
                    <li class="sub-menu-item flex space-between">
                        <span><?php _e('Export file','web-to-print-online-designer'); ?></span>
                        <small>Ctrl+O</small>
                    </li>
                    <li class="sub-menu-item flex space-between">
                        <span><?php _e('Clear all design','web-to-print-online-designer'); ?></span>
                        <small>Ctrl+L</small>
                    </li>
                    <li class="sub-menu-item flex space-between">
                        <span><?php _e('Save for later','web-to-print-online-designer'); ?></span>
                        <small>Ctrl+Shift+S</small>
                    </li>                    
                </ul>
            </div>
            <div id="nbd-overlay"></div>
        </li>
        <li class="menu-item item-view">
            <span><?php _e('View','web-to-print-online-designer'); ?></span>
            <ul class="sub-menu" data-pos="left">
                <li class="sub-menu-item flex space-between">
                    <span><?php _e('Rule','web-to-print-online-designer'); ?></span>
                    <small>Ctrl+R</small>
                </li>
                <li class="sub-menu-item flex space-between">
                    <span><?php _e('Show grid','web-to-print-online-designer'); ?></span>
                    <small>Ctrl+'</small>
                </li>

                <!------------------------------------------------------------------------------------
                data-animate:
                    + bottom-to-top
                    + top-to-bottom
                    + left-to-right
                    + right-to-left
                    + scale
                ------------------------------------------------------------------------------------->

                <li class="sub-menu-item flex space-between">
                    <span><?php _e('Show guideline','web-to-print-online-designer'); ?></span>
                    <small>Ctrl+;</small>
                </li>
                <li class="sub-menu-item flex space-between hover-menu" data-animate="bottom-to-top">
                    <span><?php _e('Snap to','web-to-print-online-designer'); ?></span>
                    <i class="icon-nbd icon-nbd-arrow-drop-down rotate-90"></i>
                    <div class="hover-sub-menu-item">
                        <ul>
                            <li><span><?php _e('Layer','web-to-print-online-designer'); ?></span></li>
                            <li><span><?php _e('Bounding','web-to-print-online-designer'); ?></span></li>
                            <li><span><?php _e('Grid','web-to-print-online-designer'); ?></span></li>
                        </ul>
                    </div>
                </li>
                <li class="sub-menu-item flex space-between hover-menu" data-animate="bottom-to-top">
                    <span><?php _e('Show warning','web-to-print-online-designer'); ?></span>
                    <i class="icon-nbd icon-nbd-arrow-drop-down rotate-90"></i>
                    <div class="hover-sub-menu-item">
                        <ul>
                            <li><?php _e('Out of stage','web-to-print-online-designer'); ?></li>
                            <li><?php _e('Image low resolution','web-to-print-online-designer'); ?></li>
                        </ul>
                    </div>
                </li>
            </ul>
            <div id="nbd-overlay"></div>
        </li>

    </ul>
    <ul class="nbd-main-menu menu-center">

        <li class="menu-item in">
            <i class="icon-nbd icon-nbd-undo2"></i>
            <span style="font-size: 12px;"><?php _e('undo','web-to-print-online-designer'); ?></span>
        </li>
        <li class="menu-item in">
            <i class="icon-nbd icon-nbd-redo2"></i>
            <span style="font-size: 12px;"><?php _e('Redo','web-to-print-online-designer'); ?></span>
        </li>        

        <li class="menu-item in" ng-click='debug()' style="display: none;">
            <i class="icon-nbd icon-nbd-format-bold"></i>
            <span><?php _e('Debug','web-to-print-online-designer'); ?></span>
        </li>
    </ul>
    <ul class="nbd-main-menu menu-right">
        <li class="menu-item item-title">
            <input type="text" name="title" class="title" placeholder="Title" value="Business Card"/>
        </li>
        <li class="menu-item item-share nbd-show-popup-share"><i class="icon-nbd icon-nbd-share2"></i></li>
        <li class="menu-item item-process" data-overlay="overlay">
            <span>Process</span><i class="icon-nbd icon-nbd-arrow-upward rotate90"></i>
            <div class="sub-menu" data-pos="right">
                <div class="main-sub-menu">
                    <div class="sub-header">
                        <span><?php _e('Product Option','web-to-print-online-designer'); ?></span>
                        <i class="icon-nbd-clear nbd-close-sub-menu"></i>
                    </div>
                    <div class="sub-body">
                        <select class="process-select">
                            <option value="pdf-standard"><span><?php _e('PDF-Standard','web-to-print-online-designer'); ?></span></option>
                            <option value="pdf-print"><span><?php _e('PDF-Standard','web-to-print-online-designer'); ?></span></option>
                            <option value="jpg"><span>JPG</span></option>
                            <option value="png"><span>PNG</span></option>
                        </select>
                    </div>
                    <div class="sub-footer">
                        <button class="nbd-button nbd-add-to-cart"><?php _e('Add To Cart','web-to-print-online-designer'); ?></button>
                        <i class="icon-nbd-info-circle nbd-show-popup-fileType nbd-hover-shadow"></i>
                    </div>
                </div>
            </div>
        </li>
<!--        <li class="menu-item item-more">-->
<!--            <i class="icon-nbd icon-nbd-baseline-more-vert"></i>-->
<!--            <div class="sub-menu" data-pos="right">-->
<!--                <ul>-->
<!--                    <li class="sub-menu-item">aaaaa</li>-->
<!--                    <li class="sub-menu-item">bbbbb</li>-->
<!--                    <li class="sub-menu-item">ccccc</li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </li>-->
    </ul>

</div>