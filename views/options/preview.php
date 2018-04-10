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
            <div ng-show="options.quantity_type == 'i'">
                <input type="number" string-to-number name="nbd-quantity" ng-model="options.quantity_value"/>
            </div>
            <div ng-show="options.quantity_type == 'r'">
                <input name="nbd-quantity" string-to-number type="range" min="{{options.quantity_min}}" max="{{options.quantity_max}}" step="{{options.quantity_step}}" ng-model="options.quantity_value">
            </div>
            <div ng-show="options.quantity_type == 's'">
                <span ng-repeat="break in options.quantity_breaks" class="nbd-quantity-r">
                    <input id="nbd-quantity_{{$index}}" name="nbd-quantity-r" type="radio" ng-model="options.quantity_value" value="{{break.val}}"/>
                    <label for="nbd-quantity_{{$index}}">{{break.val}}</label>
                </span>
            </div>
        </div>
    </div>
</div> 

