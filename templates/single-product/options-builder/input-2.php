<?php if (!defined('ABSPATH')) exit; ?>
<tr class="nbd-option-field nbd-field-input-wrap <?php echo $class; ?>" ng-if="nbd_fields['<?php echo $field['id']; ?>'].enable">
    <td>
        <label for='nbd-field-<?php echo $field['id']; ?>'>
            <?php echo $field['general']['title']; ?>
            <?php if( $field['general']['required'] == 'y' ): ?>
            <span class="nbd-required">*</span>
            <?php endif; ?>            
        </label> 
        <?php if( $field['general']['description'] != '' ): ?>
        <span data-position="<?php echo $tooltip_position; ?>" data-tip="<?php echo $field['general']['description']; ?>" class="nbd-help-tip"></span>
        <?php endif; ?>
    </td>
    <td class="nbd-field-content">
        <input ng-change="check_valid()" 
            <?php if( isset($field['nbd_type']) && $field['nbd_type'] == 'dimension' ): ?>
                ng-model="nbd_fields['<?php echo $field['id']; ?>'].value" ng-hide="true"
            <?php else: ?>
                ng-model="nbd_fields['<?php echo $field['id']; ?>'].value" 
            <?php endif; ?>
            <?php if( $field['general']['required'] == 'y' ) echo 'required'; ?> name="nbd-field[<?php echo $field['id']; ?>]" id="nbd-field-<?php echo $field['id']; ?>"
            <?php if($field['general']['input_type'] == 't'){ echo 'type="text"'; }else{ echo 'string-to-number min="'. $field['general']['input_option']['min'] .'" max="'. $field['general']['input_option']['max'] .'" step="'. $field['general']['input_option']['step'] .'" ng-step="0.0001"'; 
            if($field['general']['input_type'] == 'n'){ echo ' type="number"'; }else{ echo ' type="range"'; } }; ?> /><?php if($field['general']['input_type'] == 'r'): ?><span class="nbd-input-range">{{nbd_fields['<?php echo $field['id']; ?>'].value}}</span><?php endif; ?>
        <?php if( isset($field['nbd_type']) && $field['nbd_type'] == 'dimension' ): ?>
        <input class="nbo-dimension" placeholder="<?php _e('Width', 'web-to-print-online-designer'); ?>" ng-change="update_dimensionvalue('<?php echo $field['id']; ?>')" id="nbd-field-<?php echo $field['id']; ?>-width" required ng-model="nbd_fields['<?php echo $field['id']; ?>'].width" type="number" min="<?php echo $field['general']['min_width']; ?>" max="<?php echo $field['general']['max_width']; ?>" step="<?php echo $field['general']['step_width']; ?>"  ng-step="0.0001" />
        <input class="nbo-dimension" placeholder="<?php _e('Height', 'web-to-print-online-designer'); ?>" ng-change="update_dimensionvalue('<?php echo $field['id']; ?>')" id="nbd-field-<?php echo $field['id']; ?>-height" required ng-model="nbd_fields['<?php echo $field['id']; ?>'].height" type="number" min="<?php echo $field['general']['min_height']; ?>" max="<?php echo $field['general']['max_height']; ?>" step="<?php echo $field['general']['step_height']; ?>"  ng-step="0.0001" />
        <span><?php echo nbdesigner_get_option('nbdesigner_dimensions_unit'); ?></span>
        <br /><small class="nbo-dimension-width"><?php echo sprintf(__('Width: min %s - max %s', 'web-to-print-online-designer'), $field['general']['min_width'], $field['general']['max_width']); ?></small>
        <br /><small class="nbo-dimension-width"><?php echo sprintf(__('Height: min %s - max %s', 'web-to-print-online-designer'), $field['general']['min_height'], $field['general']['max_height']); ?></small>
        <br /><span class="nbd-invalid-notice nbd-invalid-min nbd-invalid-max"><?php echo __('Invalid value', 'web-to-print-online-designer'); ?></span>
        <?php endif; ?>
        <?php if( !(isset($field['nbd_type']) && $field['nbd_type'] == 'dimension') ): ?>
        <span class="nbd-invalid-notice nbd-invalid-min"><?php echo __('Invalid value, min: ', 'web-to-print-online-designer') . $field['general']['input_option']['min']; ?></span>
        <span class="nbd-invalid-notice nbd-invalid-max"><?php echo __('Invalid value, max: ', 'web-to-print-online-designer') . $field['general']['input_option']['max']; ?></span>
        <?php endif; ?>
    </td>
</tr>