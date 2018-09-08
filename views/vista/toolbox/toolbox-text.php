<div class="v-toolbox-text v-toolbox-item nbd-main-tab"
     ng-class="stages[currentStage].states.isShowToolBox ? 'nbd-show' : ''"
     ng-show="stages[currentStage].states.isText"
     ng-style="stages[currentStage].states.toolboxStyle">
    <div class="v-triangle" data-pos="{{stages[currentStage].states.toolboxTriangle}}">
        <div class="header-box has-box-more">
            <span><?php _e('Format Text','web-to-print-online-designer'); ?></span>
            <ul class="link-breadcrumb">
               <li class="link-item nbd-nav-tab nbd-ripple active" data-tab="tab-main-box"><i class="nbd-icon-vista nbd-icon-vista-cog"></i></li>
               <li class="link-item nbd-nav-tab nbd-ripple" data-tab="tab-box-position"><i class="nbd-icon-vista nbd-icon-vista-apps"></i></li>
                <li class="link-item nbd-nav-tab nbd-ripple" data-tab="tab-box-opacity"><i class="nbd-icon-vista nbd-icon-vista-opacity"></i></li>
            </ul>
<!--            <span class="link-more">More <i class="view-more">→</i></span>-->
<!--            <span class="link-back"><i class="view-more">&larr;</i> Back</span>-->
        </div>
        <div class="nbd-tab-contents">
            <div class="main-box nbd-tab-content active" id="tab-main-box">
                <div class="toolbox-row toolbox-first toolbox-font-family">
                    <div class="v-dropdown">
                        <button class="v-btn btn-font-family v-btn-dropdown" title="Font family">
                            <span ng-style="{'font-family': stages[currentStage].states.text.font.alias}">{{stages[currentStage].states.text.font.name}}</span>
                            <i class="nbd-icon-vista nbd-icon-vista-expand-more"></i></button>
                        <div class="v-dropdown-menu">

                            <div class="toolbar-font-search">
                                <input type="search" name="font-search" ng-model="resource.font.filter.search" placeholder="<?php _e('Search in','web-to-print-online-designer'); ?> {{resource.font.data.length}} <?php _e('fonts','web-to-print-online-designer'); ?>"/>
                                <i ng-show="resource.font.filter.search.length > 0" ng-click="resource.font.filter.search = ''" class="nbd-icon-vista nbd-icon-vista-clear"></i>
                            </div>

                            <ul class="items tab-scroll"
                                id="toolbar-font-familly-dropdown"
                                nbd-scroll="scrollLoadMore(container, type)"
                                data-container="#toolbar-font-familly-dropdown"
                                data-type="font" data-offset="40">
                                <div class="toolbar-menu-header">
                                    <div class="toolbar-header-line"></div>
                                    <div class="toolbar-separator">All Fonts</div>
                                    <div class="toolbar-header-line"></div>
                                </div>
                                <li class="item"
                                    ng-class="font.alias == stages[currentStage].states.text.fontFamily ? 'active' : ''"
                                    ng-click="setTextAttribute('fontFamily', font.alias)"
                                    ng-repeat="font in resource.font.filteredFonts"
                                    repeat-end="onEndRepeat('font')"
                                    data-font="font"
                                    font-on-load
                                    load-font-fail-action="loadFontFailAction(font)"
                                    data-preview="settings.subsets[font.subset]['preview_text']" >
                                <span class="font-left"
                                      style="font-family: '{{font.alias}}',-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif; font-size: 14px"
                                >
                                    {{font.name}}
                                </span>
                                    <span class="font-right" ng-if="['all', 'latin', 'latin-ext', 'vietnamese'].indexOf(font.subset) < 0">{{settings.subsets[font.subset]['preview_text']}}</span>
                                    <i class="nbd-icon-vista nbd-icon-vista-done checked"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php include __DIR__ . '/../toollock.php'?>
                <div class="toolbox-row toolbox-second toolbox-align">
                    <ul class="items v-assets">
                        <li class="item v-asset item-align-left"
                            ng-click="setTextAttribute('textAlign', 'left')"
                            ng-class="stages[currentStage].states.text.textAlign == 'left' ? 'active' : ''"
                            ng-if="settings['nbdesigner_text_align_left'] == '1'"
                            title="Align left">
                            <i class="nbd-icon-vista nbd-icon-vista-align-left"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="setTextAttribute('textAlign', 'center')"
                            ng-class="stages[currentStage].states.text.textAlign == 'center' ? 'active' : ''"
                            ng-if="settings['nbdesigner_text_align_center'] == '1'"
                            title="Align center">
                            <i class="nbd-icon-vista nbd-icon-vista-align-center"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="setTextAttribute('textAlign', 'right')"
                            ng-class="stages[currentStage].states.text.textAlign == 'right' ? 'active' : ''"
                            ng-if="settings['nbdesigner_text_align_right'] == '1'"
                            title="Align right">
                            <i class="nbd-icon-vista nbd-icon-vista-align-right"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="setTextAttribute('fontWeight', stages[currentStage].states.text.fontWeight == 'bold' ? 'normal' : 'bold')"
                            ng-class="{'active': stages[currentStage].states.text.fontWeight == 'bold', 'nbd-disabled': !(stages[currentStage].states.text.font.file.b && ( stages[currentStage].states.text.fontStyle != 'italic' || ( stages[currentStage].states.text.fontStyle == 'italic' && stages[currentStage].states.text.font.file.bi ) ))}"
                            title="Text bold">
                            <i class="nbd-icon-vista nbd-icon-vista-bold"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="setTextAttribute('fontStyle', stages[currentStage].states.text.fontStyle == 'italic' ? 'normal' : 'italic')"
                            ng-class="{'active': stages[currentStage].states.text.fontStyle == 'italic','nbd-disabled' : !(stages[currentStage].states.text.font.file.i && ( stages[currentStage].states.text.fontWeight != 'bold' || ( stages[currentStage].states.text.fontWeight == 'bold' && stages[currentStage].states.text.font.file.bi ) ))}"
                            title="Text italic">
                            <i class="nbd-icon-vista nbd-icon-vista-italic"></i>
                        </li>
                    </ul>
                </div>
                <div class="toolbox-row toolbox-second toolbox-general">
                    <ul class="items v-assets">
                        <!--                    <li class="item v-asset item-reset" title="Reset" ng-click="addLine()"></li>-->
                        <li class="item v-asset item-reset" ng-click="resetLayer()" title="Reset" ng-class="stages[currentStage].states.hasReset ? '' : 'nbd-disabled'">
                            <i class="nbd-icon-vista nbd-icon-vista-refresh"></i>
                        </li>
                        <li class="item v-asset item-delete"
                            ng-click="deleteLayers()"
                            title="Delete layer">
                            <i class="nbd-icon-vista nbd-icon-vista-clear"></i>
                        </li>
                        <li class="item v-asset" style="visibility: hidden"></li>
                        <li class="item v-asset" style="visibility: hidden"></li>
                        <li class="item v-asset" style="visibility: hidden"></li>
                    </ul>
                </div>
                <div class="toolbox-row toolbox-last">
                    <div class="toolbox-font-size">
                        <div class="v-dropdown">
                            <button class="v-btn btn-font-size v-btn-dropdown" title="Font size">
                                <input class="toolbar-input" type="text" name="font-size" value="12"
                                       ng-keyup="$event.keyCode == 13 && setTextAttribute('fontSize', stages[currentStage].states.text.fontSize)"
                                       ng-model="stages[currentStage].states.text.fontSize"/>
                                <i class="nbd-icon-vista nbd-icon-vista-arrows"></i>
                            </button>
                            <div class="v-dropdown-menu">
                                <ul class="items tab-scroll">
                                    <li class="item"
                                        ng-click="setTextAttribute('fontSize', fontsize)"
                                        ng-class="stages[currentStage].states.text.fontSize == fontsize ? 'active' : ''"
                                        ng-repeat="fontsize in ['6','8','10','12','14','16','18','21','24','28','32','36','42','48','56','64','72','80','88','96','104','120','144']">
                                        <span>{{fontsize}}</span>
                                        <i class="nbd-icon-vista nbd-icon-vista-done checked"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="toolbox-color-palette">
                        <div class="v-dropdown">
                            <button class="v-btn btn-color v-btn-dropdown" title="Text color">
                                <span class="color-selected" ng-style="{'background-color': currentColor}"></span>
                                <i class="nbd-icon-vista nbd-icon-vista-expand-more"></i>
                            </button>
                            <div class="v-dropdown-menu">
                                <?php include __DIR__ . '/../color-palette.php'?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-box-more nbd-tab-content" id="tab-box-position">
                <div class="toolbox-row toolbox-first toolbox-align">
                    <ul class="items v-assets">
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('vertical')"
                            title="Position center horizontal">
                            <i class="nbd-icon-vista nbd-icon-vista-vertical-align-center"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('top-left')"
                            title="Position top right">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate-90"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('top-center')"
                            title="Position top center">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate-45"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('top-right')"
                            title="Position top left">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left"></i>
                        </li>
                        <li class="item v-asset item-align-left" style="visibility: hidden">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left"></i>
                        </li>
                    </ul>
                </div>
                <div class="toolbox-row toolbox-second toolbox-align">
                    <ul class="items v-assets">
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('horizontal')"
                            title="Position center vertical">
                            <i class="nbd-icon-vista nbd-icon-vista-vertical-align-center rotate90"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('middle-left')"
                            title="Position middle right">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate-135"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('center')"
                            title="Position middle center">
                            <i class="nbd-icon-vista nbd-icon-vista-center"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('middle-right')"
                            title="Position middle left">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate45"></i>
                        </li>
                        <li class="item v-asset item-align-left" style="visibility: hidden">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left"></i>
                        </li>
                    </ul>
                </div>
                <div class="toolbox-row toolbox-three toolbox-align">
                    <ul class="items v-assets">
                        <li class="item v-asset item-align-left" style="visibility: hidden">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('bottom-left')"
                            title="Position bottom left">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate-180"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('bottom-center')"
                            title="Position bottom center">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate135"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('bottom-right')"
                            title="Position bottom right">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate90"></i>
                        </li>
                        <li class="item v-asset item-align-left" style="visibility: hidden">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left"></i>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-box-more nbd-tab-content" id="tab-box-opacity">
                <div class="toolbox-row toolbox-first toolbox-align">
                    <div style="display: flex;justify-content: space-between; align-items: center">
                        <div>Opacity</div>
                        <div class="v-ranges">
                            <div class="main-track" style="display: flex">
                                <input class="slide-input" type="range" step="1" min="0" max="100" ng-change="setTextAttribute('opacity', stages[currentStage].states.opacity / 100)" ng-model="stages[currentStage].states.opacity">
                                <span class="range-track"></span>
                            </div>
                        </div>
                        <div>{{stages[currentStage].states.opacity}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-box">
            <div class="main-footer">
                <ul class="items">
<!--                    <li class="item item-reset" title="Reset">-->
<!--                        <i class="nbd-icon-vista nbd-icon-vista-refresh"></i>-->
<!--                    </li>-->
                    <li class="item item-done" title="Done" ng-click="onClickDone()">
                        <i class="nbd-icon-vista nbd-icon-vista-done"></i>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>