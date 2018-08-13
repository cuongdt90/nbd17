<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-option-field nbd-field-input-wrap" ng-if="nbd_fields['<?php echo $field['id']; ?>'].enable">
    <div class="nbd-field-header">
        <label for='nbd-field-<?php echo $field['id']; ?>'>
            <?php echo $field['general']['title']; ?>
            <?php if( $field['general']['required'] == 'y' ): ?>
            <span class="nbd-required">*</span>
            <?php endif; ?>            
        </label> 
        <?php if( $field['general']['description'] != '' ): ?>
        <span data-tip="<?php echo $field['general']['description']; ?>" class="nbd-help-tip"></span>
        <?php endif; ?>
    </div>
    <div class="nbd-field-content">
        <input ng-change="check_valid()" ng-model="nbd_fields['<?php echo $field['id']; ?>'].value" <?php if( $field['general']['required'] == 'y' ) echo 'required'; ?> name="nbd-field[<?php echo $field['id']; ?>]" id="nbd-field-<?php echo $field['id']; ?>"
            <?php if($field['general']['input_type'] == 't'){ echo 'type="text"'; }else{ echo 'min="'. $field['general']['input_option']['min'] .' max="'. $field['general']['input_option']['max'] .' step="'. $field['general']['input_option']['step'] .'"'; 
            if($field['general']['input_type'] == 'n'){ echo ' type="number"'; }else{ echo ' type="range"'; } }; ?> />
    </div>
</div>