<div class="nbd-color-palette">
    <div class="nbd-color-palette-inner">
        <div class="working-palette" ng-if="settings['nbdesigner_show_all_color'] == 'yes'">
            <h3 class="color-palette-label"><?php _e('Set color','web-to-print-online-designer'); ?></h3>
            <ul class="main-color-palette">
                <li class="color-palette-add" ng-click="showTextColorPalette()" ng-style="{'background-color': currentColor}"></li>
                <li ng-repeat="color in listAddedColor track by $index" ng-click="changeTextFill(color)" class="color-palette-item" data-color="{{color}}" title="{{color}}" ng-style="{'background-color': color}"></li>
            </ul>
        </div>
        <div class="pinned-palette default-palette">
            <h3 class="color-palette-label"><?php _e('Default color','web-to-print-online-designer'); ?></h3>
            <ul class="main-color-palette">
                <li ng-repeat="color in __colorPalette track by $index" ng-click="changeTextFill(color)" class="color-palette-item" data-color="{{color}}" title="{{__colorPalette}}" ng-style="{'background': color}">{{__colorPalette}}</li>
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
        <div class="nbd-text-color-picker" id="nbd-text-color-picker" ng-class="showTextColorPicker ? 'active' : ''">
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
                <button class="nbd-button" ng-click="addColor()"><?php _e('Add color','web-to-print-online-designer'); ?></button>
            </div>
        </div>
    </div>
</div>