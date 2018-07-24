<div class="toolbar-text" ng-show="stages[currentStage].states.isText">
    <ul class="nbd-main-menu menu-left">
        <li class="menu-item item-font-familly" ng-click="updateScrollBar('#toolbar-font-familly-dropdown')">
            <button class="toolbar-bottom">
                <span class="toolbar-label toolbar-label-font" ng-style="{'font-family': stages[currentStage].states.text.font.alias}">{{stages[currentStage].states.text.font.name}}</span>
                <i class="icon-nbd icon-nbd-dropdown-arrows"></i>
            </button>
            <div class="sub-menu" data-pos="left">
                <div class="toolbar-font-search">
                    <input type="search" name="font-search" ng-model="resource.font.filter.search" placeholder="<?php _e('Search in','web-to-print-online-designer'); ?> {{resource.font.data.length}} <?php _e('fonts','web-to-print-online-designer'); ?>"/>
                    <i ng-show="resource.font.filter.search.length > 0" ng-click="resource.font.filter.search = ''" class="icon-nbd icon-nbd-clear"></i>
                </div>
                <div id="toolbar-font-familly-dropdown" nbd-scroll="scrollLoadMore(container, type)" data-container="#toolbar-font-familly-dropdown" data-type="font" data-offset="40">
                    <div class="group-font" ng-show="stages[currentStage].states.usedFonts.length > 0">
                        <div class="toolbar-menu-header">
                            <div class="toolbar-header-line"></div>
                            <div class="toolbar-separator"><?php _e('Document Fonts','web-to-print-online-designer'); ?></div>
                            <div class="toolbar-header-line"></div>
                        </div>
                        <ul>
                            <li ng-click="setTextAttribute('fontFamily', font.alias)" class="sub-menu-item" ng-repeat="font in stages[currentStage].states.usedFonts">
                                <span class="font-name-wrap" style="font-family: '{{font.alias}}',-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;"><span class="font-name">{{font.name}}</span><span ng-if="['all', 'latin', 'latin-ext', 'vietnamese'].indexOf(font.subset) < 0"> {{settings.subsets[font.subset]['preview_text']}}</span></span>
                            </li>
                        </ul>
                    </div>
                    <div class="group-font">
                        <div class="toolbar-menu-header">
                            <div class="toolbar-header-line"></div>
                            <div class="toolbar-separator"><?php _e('All Fonts','web-to-print-online-designer'); ?></div>
                            <div class="toolbar-header-line"></div>
                        </div>
                        <ul>
                            <li class="sub-menu-item" ng-class="font.alias == stages[currentStage].states.text.fontFamily ? 'chosen' : ''" ng-click="setTextAttribute('fontFamily', font.alias)" ng-repeat="font in resource.font.filteredFonts" repeat-end="onEndRepeat('font')" data-font="font" font-on-load load-font-fail-action="loadFontFailAction(font)" data-preview="settings.subsets[font.subset]['preview_text']" >
                                <span class="font-name-wrap" style="font-family: '{{font.alias}}',-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;"><span class="font-name">{{font.name}}</span><span ng-if="['all', 'latin', 'latin-ext', 'vietnamese'].indexOf(font.subset) < 0"> {{settings.subsets[font.subset]['preview_text']}}</span></span>
                                <i ng-if="font.alias == stages[currentStage].states.text.fontFamily" class="icon-nbd icon-nbd-fomat-done font-selected"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>
        <li class="menu-item item-font-size" ng-click="updateScrollBar('#toolbar-font-size-dropdown')">
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
            <span ng-style="{'background': stages[currentStage].states.text.fill}"  class="nbd-tooltip-hover color-fill nbd-color-picker-preview" title="<?php _e('Color','web-to-print-online-designer'); ?>" ></span>
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
            ng-class="{'selected': stages[currentStage].states.text.fontWeight == 'bold', 'nbd-disabled': !(stages[currentStage].states.text.font.file.b && ( stages[currentStage].states.text.fontStyle != 'italic' || ( stages[currentStage].states.text.fontStyle == 'italic' && stages[currentStage].states.text.font.file.bi ) ))}" class="menu-item item-text-bold"             
            ng-if="settings['nbdesigner_text_bold'] == '1'"><i class="icon-nbd icon-nbd-format-bold nbd-tooltip-hover" title="<?php _e('Bold','web-to-print-online-designer'); ?>"></i></li>
        <li ng-click="setTextAttribute('fontStyle', stages[currentStage].states.text.fontStyle == 'italic' ? 'normal' : 'italic')" 
            ng-class="{'selected': stages[currentStage].states.text.fontStyle == 'italic','nbd-disabled' : !(stages[currentStage].states.text.font.file.i && ( stages[currentStage].states.text.fontWeight != 'bold' || ( stages[currentStage].states.text.fontWeight == 'bold' && stages[currentStage].states.text.font.file.bi ) ))}" class="menu-item item-text-italic" 
            ng-if="settings['nbdesigner_text_italic'] == '1'"><i class="icon-nbd icon-nbd-format-italic nbd-tooltip-hover" 
            title="<?php _e('Italic','web-to-print-online-designer'); ?>"></i></li>
        <li style="display: none" class="menu-item"><i class="icon-nbd icon-nbd-format-underlined nbd-tooltip-hover" title="Underline"></i></li>
    </ul>
    <ul class="nbd-main-menu menu-right">
        <li class="menu-item item-spacing  nbd-tooltip-hover" data-range="true" title="<?php _e('Line height and spacing','web-to-print-online-designer'); ?>">
            <i class="icon-nbd icon-nbd-line_spacing"></i>
            <div class="sub-menu" data-pos="center">
                <div class="main-ranges" style="padding: 30px 10px 15px">
                    <div class="range range-spacing">
                        <label><?php _e('Spacing','web-to-print-online-designer'); ?></label>
                        <div class="main-track">
                            <input class="slide-input" ng-change="setTextAttribute('charSpacing', stages[currentStage].states.text.charSpacing)" ng-model="stages[currentStage].states.text.charSpacing" type="range" step="1" min="0" max="1000">
                            <span class="range-track"></span>
                        </div>
                        <span class="value-display">{{stages[currentStage].states.text.charSpacing}}</span>
                    </div>
                    <div class="range range-line-height">
                        <label><?php _e('Line height','web-to-print-online-designer'); ?></label>
                        <div class="main-track">
                            <input class="slide-input" ng-change="setTextAttribute('lineHeight', stages[currentStage].states.text.lineHeight)" ng-model="stages[currentStage].states.text.lineHeight" type="range" step="0.01" min="0" max="3">
                            <span class="range-track"></span>
                        </div>
                        <span class="value-display">{{stages[currentStage].states.text.lineHeight}}</span>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>