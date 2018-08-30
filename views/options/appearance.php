<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-field-info">
    <div class="nbd-field-info-1">
        <div><label><b><?php _e('Display type', 'web-to-print-online-designer'); ?></b></label></div>
    </div>
    <div class="nbd-field-info-2">
        <div>
            <select name="options[display_type]" ng-model="options.display_type">
                <option value="1"><?php _e('Default', 'web-to-print-online-designer'); ?></option>
                <option value="2"><?php _e('Price Matrix', 'web-to-print-online-designer'); ?></option>
                <option value="3"><?php _e('Bulk order', 'web-to-print-online-designer'); ?></option>
            </select>                        
        </div>
    </div>
</div>
<div class="nbd-field-info" ng-if="options.display_type == 2">
    <div class="nbd-field-info">
        <div class="nbd-field-info-1">
            <div><label><b><?php _e('Horizontal field', 'web-to-print-online-designer'); ?></b></label></div>
        </div>
        <div class="nbd-field-info-2">
            <div>
                <select name="options[pm_hoz][]" multiple ng-model="options.pm_hoz">
                    <option value="{{fieldIndex}}" ng-repeat="(fieldIndex, field) in options.fields">{{field.general.title.value}}</option>
                </select>
            </div>
        </div>    
    </div>   
    <div class="nbd-field-info">
        <div class="nbd-field-info-1">
            <div><label><b><?php _e('Vertical field', 'web-to-print-online-designer'); ?></b></label></div>
        </div>
        <div class="nbd-field-info-2">
            <div>
                <select name="options[pm_ver][]" multiple ng-model="options.pm_ver">
                    <option value="{{fieldIndex}}" ng-repeat="(fieldIndex, field) in options.fields">{{field.general.title.value}}</option>
                </select>                        
            </div>
        </div>    
    </div>     
</div>
