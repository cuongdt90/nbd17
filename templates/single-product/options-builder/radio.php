<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-option-field nbd-field-radio-wrap">
    <div class="nbd-field-header">
        <?php echo $field['general']['title']; ?> 
        <?php if( $field['general']['description'] != '' ): ?>
        <span data-tip="<?php echo $field['general']['description']; ?>" class="nbd-help-tip"></span>
        <?php endif; ?>
    </div>
    <div class="nbd-field-content nbd-radio">
        <?php foreach ($field['general']['attributes']["options"] as $key => $attr): ?>
        <input id='nbd-field-<?php echo $field['id'].'-'.$key; ?>' name="nbd-field[<?php echo $field['id']; ?>]" type="radio"/> <label for='nbd-field-<?php echo $field['id'].'-'.$key; ?>'><?php echo $attr['name']; ?></label>
        <?php endforeach; ?>
    </div>
</div>
