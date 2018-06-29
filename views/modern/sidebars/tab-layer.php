<div class="tab tab-last" id="tab-layer">
    <div class="tab-main tab-scroll">
        <div class="inner-tab-layer">
            <ul class="menu-layer" nbd-layer="sortLayer(srcIndex, dstIndex)">
                <li class="menu-item item-layer-text" data-index="{{layer.index}}" ng-click="activeLayer(layer.index)" ng-class="layer.selectable ? '' : 'lock-active'" ng-repeat="layer in stages[currentStage].layers">
                    <i ng-if="layer.type == 'text'" class="icon-nbd icon-nbd-text-fields item-left"></i>
                    <i ng-if="layer.type == 'path'" class="icon-nbd icon-nbd-vector item-left"></i>
                    <img ng-if="layer.type == 'image'" style="max-width: 34px; max-height: 34px; display: inline-block; padding: 5px;" ng-src="{{layer.src}}" />
                    <div ng-if="layer.type == 'text'" class="item-center"><input style="border: none;" ng-change="setLayerAttribute('text', layer.text, layer.index, $index)" ng-model="layer.text" type="text"/></div>
                    <span ng-if="layer.type == 'path'" class="item-center"><?php _e('Path group','web-to-print-online-designer'); ?></span>
                    <span ng-if="layer.type == 'image'" class="item-center"><?php _e('Image','web-to-print-online-designer'); ?></span>
                    <span class="item-right">
                        <i ng-click="setLayerAttribute('visible', !layer.visible, layer.index, $index); $event.stopPropagation();" ng-class="layer.visible ? 'icon-nbd-fomat-visibility' : 'icon-nbd-fomat-visibility-off'" class="icon-nbd icon-visibility" data-active="true" data-act="visibility"></i>
                        <i ng-click="setLayerAttribute('selectable', !layer.selectable, layer.index, $index); $event.stopPropagation();" ng-class="layer.selectable ? 'icon-nbd-fomat-lock-open' : 'icon-nbd-fomat-lock-outline'" class="icon-nbd icon-lock" data-active="true" data-act="lock"></i>
                        <i ng-click="deleteLayers(layer.index); $event.stopPropagation();" class="icon-nbd icon-nbd-fomat-highlight-off icon-close" data-act="close"></i>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>