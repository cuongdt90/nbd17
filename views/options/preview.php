<?php if (!defined('ABSPATH')) exit; ?>
<div class="frontend-prview" ng-class="previewWide ? 'wide' : ''">
    <div class="frontend-prview-header">
        <?php _e('Frontend Preview', 'web-to-print-online-designer'); ?>
        <span class="nbdesigner-right" style="margin-top: -4px;">
            <span class="dashicons dashicons-editor-expand" ng-show="!previewWide" ng-click="previewWide = !previewWide"></span>
            <span class="dashicons dashicons-editor-contract" ng-show="previewWide" ng-click="previewWide = !previewWide"></span>
            <span class="dashicons dashicons-arrow-up" ng-show="!showPreview" ng-click="showPreview = !showPreview"></span>
            <span class="dashicons dashicons-arrow-down" ng-show="showPreview" ng-click="showPreview = !showPreview"></span>
        </span>
    </div>
    <div ng-show="showPreview" class="frontend-prview-content">
        <!-- show field -->
        <div class="nbd-quantity preview-wrap">
            <div><b><?php _e('Quantity', 'web-to-print-online-designer'); ?></b></div>
            <div ng-if="options.quantity_type == 'i'">
                <input type="number" string-to-number name="nbd-quantity" ng-model="options.quantity_value"/>
            </div>
            <div ng-if="options.quantity_type == 'r'">
                <input name="nbd-quantity" string-to-number type="range" min="{{options.quantity_min}}" max="{{options.quantity_max}}" step="{{options.quantity_step}}" ng-model="options.quantity_value">
            </div>
            <div ng-if="options.quantity_type == 's'">
                <span ng-repeat="break in options.quantity_breaks" class="nbd-quantity-r">
                    <input id="nbd-quantity_{{$index}}" name="nbd-quantity-r" type="radio" ng-model="options.quantity_value" value="{{break.val}}"/>
                    <label for="nbd-quantity_{{$index}}">{{break.val}}</label>
                </span>
            </div>
        </div>
        <div ng-repeat="(fieldIndex, field) in options.fields" ng-if="field.general.enabled.value == 'y'" ng-show="check_option_visible(fieldIndex)">
            <div><label><b>{{field.general.title.value}}</b> </label></div>
            <div>
                <input ng-model="option_values[fieldIndex]" name="nbd_field[{{fieldIndex}}]" ng-if="field.general.data_type.value == 'i'" ng-required="field.general.required.value == 'y'"/>
                <select ng-model="option_values[fieldIndex]" name="nbd_field[{{fieldIndex}}]" ng-if="field.general.data_type.value == 'm' && field.appearance.display_type.value == 'd'">
                    <option ng-value="{{$index}}" ng-repeat="op in field.general.attributes.options" ng-selected="op.selected" >{{op.name}}</option>
                </select>
                <span class="nbd-inline-option" ng-class="field.appearance.display_type.value == 's' ? 'nbd-option-label' : 'nbd-option-radio'" ng-if="field.general.data_type.value == 'm' && (field.appearance.display_type.value == 'r' || field.appearance.display_type.value == 's')" 
                    ng-repeat="(opIndex, op) in field.general.attributes.options">
                    <input ng-model="option_values[fieldIndex]" type="radio" id="nbd_field_{{fieldIndex}}_{{opIndex}}" name="nbd_field[{{fieldIndex}}]" value="{{$index}}" ng-checked="op.selected">
                    <label for="nbd_field_{{fieldIndex}}_{{opIndex}}" ng-style="{'background': op.preview_type == 'i' ? 'url('+op.image_url+') 0% 0% / cover' : op.color}">{{op.name}}</label>
                    <input ng-if="field.appearance.quantity_selector.value == 'y'" name="option_value[{{fieldIndex}}][quantity]"/>
                </span>
            </div>
        </div>
    </div>
</div> 

