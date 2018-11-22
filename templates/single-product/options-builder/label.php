<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-option-field nbd-label-wrap <?php echo $class; ?>" ng-if="nbd_fields['<?php echo $field['id']; ?>'].enable">
    <div class="nbd-field-header">
        <label><?php echo $field['general']['title']; ?></label> 
        <?php if( $field['general']['required'] == 'y' ): ?>
        <span class="nbd-required">*</span>
        <?php endif; ?>        
        <?php if( $field['general']['description'] != '' ): ?>
        <span data-position="<?php echo $tooltip_position; ?>" data-tip="<?php echo $field['general']['description']; ?>" class="nbd-help-tip"></span>
        <?php endif; ?>
    </div>
    <div class="nbd-field-content">
        <?php foreach ($field['general']['attributes']["options"] as $key => $attr): ?>
        <input ng-change="check_valid()" value="<?php echo $key; ?>" ng-model="nbd_fields['<?php echo $field['id']; ?>'].value" name="nbd-field[<?php echo $field['id']; ?>]" type="radio" id='nbd-field-<?php echo $field['id'].'-'.$key; ?>' 
            <?php 
                if( isset($form_values[$field['id']]) ){
                    checked( $form_values[$field['id']], $key ); 
                }else{
                    checked( isset($attr['selected']) ? $attr['selected'] : 'off', 'on' ); 
                }
            ?> />
        <label class="nbd-label" for='nbd-field-<?php echo $field['id'].'-'.$key; ?>' >
            <?php echo $attr['name']; ?> 
        </label>
        <?php endforeach; ?>
    </div>
</div>

