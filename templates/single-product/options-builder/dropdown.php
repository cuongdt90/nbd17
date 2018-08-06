<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-option-field nbd-field-dropdown-wrap">
    <div class="nbd-field-header">
        <label for='nbd-field-<?php echo $field['id']; ?>'><?php echo $field['general']['title']; ?></label> 
        <?php if( $field['general']['description'] != '' ): ?>
        <span data-tip="<?php echo $field['general']['description']; ?>" class="nbd-help-tip"></span>
        <?php endif; ?>
    </div>
    <div class="nbd-field-content">
        <select name="nbd-field[<?php echo $field['id']; ?>]" class="nbd-dropdown">
        <?php foreach ($field['general']['attributes']["options"] as $key => $attr): ?>
            <option <?php echo $key; ?>><?php echo $attr['name']; ?></option>
        <?php endforeach; ?>
        </select>  
    </div>
</div>

