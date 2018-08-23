<div class="nbd-color-palette nbd-global-color-palette" id="nbd-global-color-palette">
    <div class="nbd-color-palette-inner">
        <div class="working-palette" ng-if="settings['nbdesigner_show_all_color'] == 'yes'">
            <h3 class="color-palette-label"><?php _e('Document colors','web-to-print-online-designer'); ?></h3>
            <ul class="main-color-palette nbd-perfect-scroll">
                <li class="color-palette-add" ng-click="globalPicker.active = !globalPicker.active;"></li>
                <li ng-repeat="color in listAddedColor track by $index" ng-click="selectGlobalPicker(color);" class="color-palette-item" data-color="{{color}}" title="{{color}}" ng-style="{'background-color': color}"></li>
            </ul>
        </div>
        <div class="pinned-palette default-palette">
            <h3 class="color-palette-label"><?php _e('Default palette','web-to-print-online-designer'); ?></h3>
            <ul class="main-color-palette" ng-repeat="palette in resource.defaultPalette" style="margin-bottom: 15px;">
                <li ng-class="{'first-left': $first, 'last-right': $last, 'first-right': $index == 4,'last-left': $index == (palette.length - 5)}" ng-repeat="color in palette track by $index" ng-click="selectGlobalPicker(color)" class="color-palette-item" data-color="{{color}}" title="{{color}}" ng-style="{'background': color}"></li>
            </ul>   
        </div>
        <div class="nbd-text-color-picker" id="nbd-global-color-picker" ng-class="globalPicker.active ? 'active' : ''">
            <spectrum-colorpicker
                ng-model="globalPicker.color"
                options="{
                    preferredFormat: 'hex',
                    flat: true,
                    showButtons: false,
                    showInput: true,
                    containerClassName: 'nbd-sp'
            }">
            </spectrum-colorpicker>
            <div>
                <button class="nbd-button" ng-click="addColor(globalPicker.color);selectGlobalPicker(globalPicker.color);"><?php _e('Choose','web-to-print-online-designer'); ?></button>
            </div>
        </div>
    </div>
</div>
