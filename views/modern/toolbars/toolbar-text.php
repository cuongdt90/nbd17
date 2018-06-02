<div class="toolbar-text" ng-show="stages[currentStage].states.isText">
    <ul class="nbd-main-menu menu-left">
        <li class="menu-item item-font-familly">
            <button class="toolbar-bottom">
                <span class="toolbar-label toolbar-label-font">Roboto</span>
                <i class="icon-nbd icon-nbd-dropdown-arrows"></i>
            </button>
            <div class="sub-menu" data-pos="left">
                <div class="toolbar-font-search">
                    <input type="search" name="font-search" value="" placeholder="Search"/>
                </div>
                <div id="toolbar-font-familly-dropdown">
                    <div class="group-font">
                        <div class="toolbar-menu-header">
                            <div class="toolbar-header-line"></div>
                            <div class="toolbar-separator"><?php _e('Font document','web-to-print-online-designer'); ?></div>
                            <div class="toolbar-header-line"></div>
                        </div>
                        <ul>
                            <li class="sub-menu-item chosen">
                                <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/ABeeZee.png" alt="ABeeZee"/>
                                <i class="icon-nbd icon-nbd-fomat-done"></i>
                            </li>

                            <li class="sub-menu-item">
                                <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Abel.png" alt="Abel"/>
                            </li>

                            <li class="sub-menu-item">
                                <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Abhaya Libre.png" alt="Abhaya Libre"/>
                            </li>

                            <li class="sub-menu-item">
                                <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Abril Fatface.png" alt="Abril Fatface"/>
                            </li>
                            <li class="sub-menu-item">
                                <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Aclonica.png" alt="Aclonica"/>
                            </li>
                            <li class="sub-menu-item">
                                <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Acme.png" alt="Acme"/>
                            </li>
                        </ul>
                    </div>
                    <div class="group-font">
                        <div class="toolbar-menu-header">
                            <div class="toolbar-header-line"></div>
                            <div class="toolbar-separator"><?php _e('Font Vietnamese','web-to-print-online-designer'); ?></div>
                            <div class="toolbar-header-line"></div>
                        </div>
                        <ul>
                            <li class="sub-menu-item">
                                <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Actor.png" alt="Actor"/>
                            </li>
                            <li class="sub-menu-item">
                                <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Adamina.png" alt="Adamina"/>
                            </li>
                            <li class="sub-menu-item">
                                <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Advent Pro.png" alt="Advent Pro"/>
                            </li>
                            <li class="sub-menu-item">
                                <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Aguafina Script.png" alt="Aguafina Script"/>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>
        <li class="menu-item item-font-size">
            <button class="toolbar-bottom">
                <input class="toolbar-input" type="text" ng-keyup="$event.keyCode == 13 && setTextAttribute('fontSize', stages[currentStage].states.text.fontSize)" name="font-size" ng-model="stages[currentStage].states.text.fontSize"/>
                <i class="icon-nbd icon-nbd-dropdown-arrows"></i>
                <div class="sub-menu" data-pos="left">
                    <div id="toolbar-font-size-dropdown">
                        <ul>
                            <li class="sub-menu-item" ng-click="setTextAttribute('fontSize', fontsize)" ng-class="stages[currentStage].states.text.fontSize == fontsize ? 'chosen' : ''" ng-repeat="fontsize in ['6','8','10','12','14','16','18','21','24','28','32','36','42','48','56','64','72','80','88','96','104','120','144']">
                                <span>{{fontsize}}</span>
                                <i class="icon-nbd icon-nbd-fomat-done" ng-if="stages[currentStage].states.text.fontSize == fontsize"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </button>
        </li>     
    </ul>
    <ul class="nbd-main-menu menu-center">
        <li class="menu-item item-color-fill nbd-show-color-palette">
            <span ng-style="{'background': stages[currentStage].states.text.fill}" style="width: 21px; height: 21px; border-radius: 4px;display: inline-block;border: 1px solid rgb(221, 221, 221);"  class="nbd-tooltip-hover color-fill" title="<?php _e('Color','web-to-print-online-designer'); ?>" ></span>
        </li>
    </ul>
    <ul class="nbd-main-menu menu-right">
        <li class="menu-item item-align">
            <i class="icon-nbd icon-nbd-format-align-center nbd-tooltip-hover" title="Text align"></i>
            <div class="sub-menu" data-pos="center">
                <ul>
                    <li ng-click="setTextAttribute('textAlign', 'left')" class="sub-menu-item" 
                        ng-class="stages[currentStage].states.text.textAlign == 'left' ? 'selected' : ''"
                        ng-if="settings['nbdesigner_text_align_left'] == '1'"><i class="icon-nbd icon-nbd-format-align-left nbd-tooltip-hover" title="<?php _e('Text align left','web-to-print-online-designer'); ?>"></i></li>
                    <li ng-click="setTextAttribute('textAlign', 'center')" class="sub-menu-item" 
                        ng-class="stages[currentStage].states.text.textAlign == 'center' ? 'selected' : ''"
                        ng-if="settings['nbdesigner_text_align_center'] == '1'"><i class="icon-nbd icon-nbd-format-align-center nbd-tooltip-hover" title="<?php _e('Text align center','web-to-print-online-designer'); ?>"></i></li>
                    <li ng-click="setTextAttribute('textAlign', 'right')" class="sub-menu-item" 
                        ng-class="stages[currentStage].states.text.textAlign == 'right' ? 'selected' : ''"
                        ng-if="settings['nbdesigner_text_align_right'] == '1'"><i class="icon-nbd icon-nbd-format-align-right nbd-tooltip-hover" title="<?php _e('Text align right','web-to-print-online-designer'); ?>"></i></li>
                </ul>
            </div>
        </li>
        <li ng-click="setTextAttribute('is_uppercase', stages[currentStage].states.text.is_uppercase ? false : true)"
            ng-class="stages[currentStage].states.text.is_uppercase ? 'selected' : ''" class="menu-item item-transform"><i class="icon-nbd icon-nbd-uppercase nbd-tooltip-hover" title="<?php _e('Uppercase','web-to-print-online-designer'); ?>"></i></li>
        <li ng-click="setTextAttribute('fontWeight', stages[currentStage].states.text.fontWeight == 'bold' ? 'normal' : 'bold')" 
            ng-class="stages[currentStage].states.text.fontWeight == 'bold' ? 'selected' : ''" class="menu-item item-text-bold" 
            ng-if="settings['nbdesigner_text_bold'] == '1'"><i class="icon-nbd icon-nbd-format-bold nbd-tooltip-hover" title="<?php _e('Bold','web-to-print-online-designer'); ?>"></i></li>
        <li ng-click="setTextAttribute('fontStyle', stages[currentStage].states.text.fontStyle == 'italic' ? 'normal' : 'italic')" 
            ng-class="stages[currentStage].states.text.fontStyle == 'italic' ? 'selected' : ''" class="menu-item item-text-italic" 
            ng-if="settings['nbdesigner_text_italic'] == '1'"><i class="icon-nbd icon-nbd-format-italic nbd-tooltip-hover" 
            title="<?php _e('Italic','web-to-print-online-designer'); ?>"></i></li>
        <li style="display: none" class="menu-item"><i class="icon-nbd icon-nbd-format-underlined nbd-tooltip-hover" title="Underline"></i></li>
    </ul>
    <ul class="nbd-main-menu menu-right">
        <li class="menu-item item-spacing  nbd-tooltip-hover" title="<?php _e('Line height and spacing','web-to-print-online-designer'); ?>">
        <li class="menu-item item-spacing" data-range="true">
            <i class="icon-nbd icon-nbd-line_spacing"></i>
            <div class="sub-menu" data-pos="center">
                <div class="main-ranges" style="padding: 30px 10px 15px">
                    <div class="range range-spacing">
                        <label><?php _e('Spacing','web-to-print-online-designer'); ?></label>
                        <div class="main-track">
                            <input class="slide-input" ng-mouseup="setTextAttribute('spacing', stages[currentStage].states.text.spacing)" ng-model="stages[currentStage].states.text.spacing" type="range" step="1" min="0" max="100">
                            <span class="range-track"></span>
                        </div>
                        <span class="value-display">{{stages[currentStage].states.text.spacing}}</span>
                    </div>
                    <div class="range range-line-height">
                        <label><?php _e('Line height','web-to-print-online-designer'); ?></label>
                        <div class="main-track">
                            <input class="slide-input" ng-mouseup="setTextAttribute('lineHeight', stages[currentStage].states.text.lineHeight)" ng-model="stages[currentStage].states.text.lineHeight" type="range" step="0.1" min="0" max="3">
                            <span class="range-track"></span>
                        </div>
                        <span class="value-display">{{stages[currentStage].states.text.lineHeight}}</span>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>