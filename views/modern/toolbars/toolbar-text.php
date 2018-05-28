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
                <input class="toolbar-input" type="text" name="font-size" value="12"/>
                <i class="icon-nbd icon-nbd-dropdown-arrows"></i>
                <div class="sub-menu" data-pos="left">
                    <div id="toolbar-font-size-dropdown">
                        <ul>
                            <li class="sub-menu-item chosen">
                                <span>12</span>
                                <i class="icon-nbd icon-nbd-fomat-done"></i>
                            </li>

                            <li class="sub-menu-item">
                                <span>14</span>
                            </li>

                            <li class="sub-menu-item">
                                <span>16</span>
                            </li>

                            <li class="sub-menu-item">
                                <span>18</span>
                            </li>
                            <li class="sub-menu-item">
                                <span>20</span>
                            </li>
                            <li class="sub-menu-item">
                                <span>22</span>
                            </li>
                            <li class="sub-menu-item">
                                <span>24</span>
                            </li>
                            <li class="sub-menu-item">
                                <span>26</span>
                            </li>
                            <li class="sub-menu-item">
                                <span>28</span>
                            </li>
                            <li class="sub-menu-item">
                                <span>30</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </button>
        </li>     
    </ul>
    <ul class="nbd-main-menu menu-right">
        <li class="menu-item item-color-fill">
            <span ng-style="{'background': stages[currentStage].states.text.fill}" style="width: 21px; height: 21px; border-radius: 4px;display: inline-block;"  class="nbd-tooltip-hover color-fill" title="<?php _e('Color','web-to-print-online-designer'); ?>" ></span>
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
                                ng-model="stages[currentStage].states.text.fill"
                                ng-change="changeBackgroundColor()"
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
    </ul>
    <ul class="nbd-main-menu menu-right">
        <li class="menu-item item-align">
            <i class="icon-nbd icon-nbd-format-align-center nbd-tooltip-hover" title="Text align"></i>
            <div class="sub-menu" data-pos="center">
                <ul>
                    <li class="sub-menu-item" ng-show="settings['nbdesigner_text_align_left'] == '1'"><i class="icon-nbd icon-nbd-format-align-left nbd-tooltip-hover" title="Text align left"></i></li>
                    <li class="sub-menu-item" ng-show="settings['nbdesigner_text_align_center'] == '1'"><i class="icon-nbd icon-nbd-format-align-center nbd-tooltip-hover" title="Text align center"></i></li>
                    <li class="sub-menu-item"><i class="icon-nbd icon-nbd-format-align-justify nbd-tooltip-hover" title="Text align justify"></i></li>
                    <li class="sub-menu-item" ng-show="settings['nbdesigner_text_align_right'] == '1'"><i class="icon-nbd icon-nbd-format-align-right nbd-tooltip-hover" title="Text align right"></i></li>
                </ul>
            </div>
        </li>
        <li class="menu-item item-transform"><i class="icon-nbd icon-nbd-uppercase nbd-tooltip-hover" title="Uppercase"></i></li>
        <li class="menu-item item-text-bold" ng-if="settings['nbdesigner_text_bold'] == '1'"><i class="icon-nbd icon-nbd-format-bold nbd-tooltip-hover" title="Bold"></i></li>
        <li class="menu-item item-text-italic" ng-if="settings['nbdesigner_text_italic'] == '1'"><i class="icon-nbd icon-nbd-format-italic nbd-tooltip-hover" title="Italic"></i></li>
        <li style="display: none" class="menu-item"><i class="icon-nbd icon-nbd-format-underlined nbd-tooltip-hover" title="Underline"></i></li>
    </ul>
</div>