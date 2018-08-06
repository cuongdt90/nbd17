<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-option-field nbd-field-input-wrap">
    <div class="nbd-field-header">
        <label for='nbd-field-<?php echo $field['id']; ?>'><?php echo $field['general']['title']; ?></label> 
        <?php if( $field['general']['description'] != '' ): ?>
        <span data-tip="<?php echo $field['general']['description']; ?>" class="nbd-help-tip"></span>
        <?php endif; ?>
    </div>
    <div class="nbd-field-content"><input name="nbd-field[<?php echo $field['id']; ?>]" id="nbd-field-<?php echo $field['id']; ?>" type="text"/></div>
</div>