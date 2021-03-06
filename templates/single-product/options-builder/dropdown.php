<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-option-field nbd-field-dropdown-wrap <?php echo $class; ?>" ng-if="nbd_fields['<?php echo $field['id']; ?>'].enable">
    <div class="nbd-field-header">
        <label for='nbd-field-<?php echo $field['id']; ?>'>
            <?php echo $field['general']['title']; ?>
            <?php if( $field['general']['required'] == 'y' ): ?>
            <span class="nbd-required">*</span>
            <?php endif; ?>
        </label> 
        <?php if( $field['general']['description'] != '' ): ?>
        <span data-position="<?php echo $tooltip_position; ?>" data-tip="<?php echo $field['general']['description']; ?>" class="nbd-help-tip"></span>
        <?php endif; ?>
    </div>
    <div class="nbd-field-content">
        <select ng-change="check_valid()" name="nbd-field[<?php echo $field['id']; ?>]" class="nbo-dropdown" ng-model="nbd_fields['<?php echo $field['id']; ?>'].value">
        <?php foreach ($field['general']['attributes']["options"] as $key => $attr): ?>
            <option value="<?php echo $key; ?>" 
                <?php 
                    if( isset($form_values[$field['id']]) ){
                        selected( $form_values[$field['id']], $key ); 
                    }else{
                        selected( isset($attr['selected']) ? $attr['selected'] : 'off', 'on' ); 
                    }
                ?>><?php echo $attr['name']; ?></option>
        <?php endforeach; ?>
        </select>  
    </div>
</div>

