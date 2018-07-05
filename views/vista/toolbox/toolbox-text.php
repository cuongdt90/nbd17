<div class="v-toolbox-text" ng-show="stages[currentStage].states.isActiveLayer">
    <div class="v-triangle">
        <div class="header-box">
            <span>Format Text</span>
        </div>
        <div class="main-box">
            <div class="toolbox-row toolbox-first toolbox-font-family">
                <div class="v-dropdown">
                    <button class="v-btn btn-font-family v-btn-dropdown" title="Font family">
                        <span>Roboto</span>
                        <i class="nbd-icon-vista nbd-icon-vista-expand-more"></i></button>
                    <div class="v-dropdown-menu">
                        <ul class="items tab-scroll">
                            <li class="item">
                                <span class="font-left">Roboto</span>
                                <span class="font-right"></span>
                                <i class="nbd-icon-vista nbd-icon-vista-done checked"></i>
                            </li>
                            <li class="item">
                                <span class="font-left">Khmer</span>
                                <span class="font-right">កខគឃង</span>
                                <i class="nbd-icon-vista nbd-icon-vista-done checked"></i>
                            </li>
                            <li class="item active">
                                <span class="font-left">Roboto</span>
                                <span class="font-right"></span>
                                <i class="nbd-icon-vista nbd-icon-vista-done checked"></i>
                            </li>
                            <li class="item">
                                <span class="font-left">Roboto</span>
                                <span class="font-right"></span>
                                <i class="nbd-icon-vista nbd-icon-vista-done checked"></i>
                            </li>
                            <li class="item">
                                <span class="font-left">Roboto</span>
                                <span class="font-right"></span>
                                <i class="nbd-icon-vista nbd-icon-vista-done checked"></i>
                            </li>
                            <li class="item">
                                <span class="font-left">Roboto</span>
                                <span class="font-right"></span>
                                <i class="nbd-icon-vista nbd-icon-vista-done checked"></i>
                            </li>
                            <li class="item">
                                <span class="font-left">Roboto</span>
                                <span class="font-right"></span>
                                <i class="nbd-icon-vista nbd-icon-vista-done checked"></i>
                            </li>
                            <li class="item">
                                <span class="font-left">Roboto</span>
                                <span class="font-right"></span>
                                <i class="nbd-icon-vista nbd-icon-vista-done checked"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

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

            <div class="toolbox-row toolbox-last">
                <div class="toolbox-font-size">
                    <div class="v-dropdown">
                        <button class="v-btn btn-font-size v-btn-dropdown" title="Font size">
                            <input class="toolbar-input" type="text" name="font-size" value="12"
                               ng-keyup="$event.keyCode == 13 && setTextAttribute('fontSize', stages[currentStage].states.text.fontSize)"
                               ng-model="stages[currentStage].states.text.fontSize"
                            >
                            <i class="nbd-icon-vista nbd-icon-vista-arrows"></i>
                        </button>
                        <div class="v-dropdown-menu">
                            <ul class="items tab-scroll">
                                <li class="item"
                                    ng-click="setTextAttribute('fontSize', fontsize)"
                                    ng-class="stages[currentStage].states.text.fontSize == fontsize ? 'active' : ''"
                                    ng-repeat="fontsize in ['6','8','10','12','14','16','18','21','24','28','32','36','42','48','56','64','72','80','88','96','104','120','144']"
                                >
                                    <span>{{fontsize}}</span>
                                    <i class="nbd-icon-vista nbd-icon-vista-done checked"></i>
                                </li>
<!--                                <li class="item active"><span>13</span><i-->
<!--                                            class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>-->
<!--                                <li class="item"><span>14</span><i-->
<!--                                            class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>-->
<!--                                <li class="item"><span>16</span><i-->
<!--                                            class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>-->
<!--                                <li class="item"><span>18</span><i-->
<!--                                            class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>-->
<!--                                <li class="item"><span>21</span><i-->
<!--                                            class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>-->
<!--                                <li class="item"><span>24</span><i-->
<!--                                            class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>-->
<!--                                <li class="item"><span>28</span><i-->
<!--                                            class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>-->
<!--                                <li class="item"><span>30</span><i-->
<!--                                            class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>-->
<!--                                <li class="item"><span>36</span><i-->
<!--                                            class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>-->
<!--                                <li class="item"><span>40</span><i-->
<!--                                            class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>-->
<!--                                <li class="item"><span>42</span><i-->
<!--                                            class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>-->
<!--                                <li class="item"><span>44</span><i-->
<!--                                            class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>-->
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
                            <div class="nbd-color-palette show">
                                <div class="nbd-color-palette-inner">
                                    <div class="working-palette" ng-if="settings['nbdesigner_show_all_color'] == 'yes'">
                                        <h3 class="color-palette-label">Set color</h3>
                                        <ul class="main-color-palette tab-scroll">
                                            <li class="color-palette-add" ng-style="{'background-color': currentColor}"></li>
                                            <li
                                                ng-repeat="color in listAddedColor track by $index"
                                                ng-click="changeFill(color)"
                                                class="color-palette-item"
                                                data-color="{{color}}"
                                                title="{{color}}"
                                                ng-style="{'background-color': color}">
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="pinned-palette default-palette">
                                        <h3 class="color-palette-label"><?php _e('Default palette','web-to-print-online-designer'); ?></h3>
                                        <ul class="main-color-palette" ng-repeat="palette in resource.defaultPalette" style="margin-bottom: 15px;">
                                            <li ng-class="{'first-left': $first, 'last-right': $last, 'first-right': $index == 4,'last-left': $index == (palette.length - 5)}"
                                                ng-repeat="color in palette track by $index"
                                                ng-click="changeFill(color)"
                                                class="color-palette-item"
                                                data-color="{{color}}"
                                                title="{{color}}"
                                                ng-style="{'background': color}">
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="nbd-text-color-picker"
                                         ng-class="showTextColorPicker ? 'active' : ''"
                                         id="nbd-text-color-picker">
                                        <spectrum-colorpicker
                                                ng-model="currentColor"
                                                options="{
                                                preferredFormat: 'hex',
                                                color: '#fff',
                                                flat: true,
                                                showButtons: false,
                                                showInput: true,
                                                containerClassName: 'nbd-sp'
                                            }">
                                        </spectrum-colorpicker>
                                        <div>
                                            <button class="v-btn"
                                                ng-click="addColor();changeFill(currentColor);">
                                                <?php _e('Add color','web-to-print-online-designer'); ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-box">
            <div class="main-footer">
                <ul class="items">
                    <li class="item item-reset" title="Reset">
                        <i class="nbd-icon-vista nbd-icon-vista-refresh"></i>
                    </li>
                    <li class="item item-done" title="Done">
                        <i class="nbd-icon-vista nbd-icon-vista-done"></i>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>