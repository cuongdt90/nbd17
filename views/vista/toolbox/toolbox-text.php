<div class="v-toolbox-text" style="display: none">
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
                <li class="item v-asset item-align-left active" title="Align left"><i
                        class="nbd-icon-vista nbd-icon-vista-align-left"></i></li>
                <li class="item v-asset item-align-left" title="Align center"><i
                        class="nbd-icon-vista nbd-icon-vista-align-center"></i></li>
                <li class="item v-asset item-align-left" title="Align right"><i
                        class="nbd-icon-vista nbd-icon-vista-align-right"></i></li>
                <li class="item v-asset item-align-left" title="Text bold"><i
                        class="nbd-icon-vista nbd-icon-vista-bold"></i></li>
                <li class="item v-asset item-align-left" title="Text italic"><i
                        class="nbd-icon-vista nbd-icon-vista-italic"></i></li>
            </ul>
        </div>
        <div class="toolbox-row toolbox-last">
            <div class="toolbox-font-size">
                <div class="v-dropdown">
                    <button class="v-btn btn-font-size v-btn-dropdown" title="Font size">
                        <input class="toolbar-input" type="text" name="font-size" value="12">
                        <i class="nbd-icon-vista nbd-icon-vista-arrows"></i>
                    </button>
                    <div class="v-dropdown-menu">
                        <ul class="items tab-scroll">
                            <li class="item active"><span>12</span><i
                                    class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>
                            <li class="item"><span>13</span><i
                                    class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>
                            <li class="item"><span>14</span><i
                                    class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>
                            <li class="item"><span>16</span><i
                                    class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>
                            <li class="item"><span>18</span><i
                                    class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>
                            <li class="item"><span>21</span><i
                                    class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>
                            <li class="item"><span>24</span><i
                                    class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>
                            <li class="item"><span>28</span><i
                                    class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>
                            <li class="item"><span>30</span><i
                                    class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>
                            <li class="item"><span>36</span><i
                                    class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>
                            <li class="item"><span>40</span><i
                                    class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>
                            <li class="item"><span>42</span><i
                                    class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>
                            <li class="item"><span>44</span><i
                                    class="nbd-icon-vista nbd-icon-vista-done checked"></i></li>
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
                                <div class="working-palette">
                                    <h3 class="color-palette-label">Set color</h3>
                                    <ul class="main-color-palette tab-scroll">
                                        <li class="color-palette-add" ng-style="{'background-color': currentColor}"></li>
                                        <li ng-repeat="color in listAddedColor track by $index" class="color-palette-item" data-color="{color}" title="{color}" ng-style="{'background-color': color}"></li>
                                    </ul>
                                </div>
                                <div class="pinned-palette default-palette">
                                    <h3 class="color-palette-label">Default color</h3>
                                    <ul class="main-color-palette">
                                        <li class="color-palette-item ng-scope" data-color="#81d742" style="background: rgb(129, 215, 66);"></li>
                                        <li class="color-palette-item ng-scope" data-color="#1e73be" style="background: rgb(30, 115, 190);"></li>
                                        <li class="color-palette-item ng-scope" data-color="#dd3333" style="background: rgb(221, 51, 51);"></li>
                                        <li class="color-palette-item ng-scope" data-color="#8224e3" style="background: rgb(130, 36, 227);"></li>
                                    </ul>
                                </div>
                                <div class="pinned-palette default-palette">
                                    <ul class="main-color-palette">
<!--                                        <li ng-repeat="color in listAddedColor track by $index" class="color-palette-item" data-color="{color}" title="{color}" ng-style="{'background-color': color}"></li>-->
                                        <li class="color-palette-item" data-color="#333333" title="#333333"
                                            style="background-color: #333333;"></li>
                                        <li class="color-palette-item" data-color="#666666" title="#666666"
                                            style="background-color: #666666;"></li>
                                        <li class="color-palette-item" data-color="#a8a8a8" title="#a8a8a8"
                                            style="background-color: #a8a8a8;"></li>
                                        <li class="color-palette-item" data-color="#d9d9d9" title="#d9d9d9"
                                            style="background-color: #d9d9d9;"></li>
                                        <li class="color-palette-item" data-color="#ffffff" title="#ffffff"
                                            style="background-color: #ffffff;"></li>
                                    </ul>
                                </div>
                                <div class="nbd-text-color-picker" id="nbd-text-color-picker">
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
                                        <button class="v-btn" ng-click="addColor()"><?php _e('Add color','web-to-print-online-designer'); ?></button>
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