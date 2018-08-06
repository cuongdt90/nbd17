<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-option-field nbd-swatch-wrap">
    <div class="nbd-field-header">
        <?php echo $field['general']['title']; ?> 
        <?php if( $field['general']['description'] != '' ): ?>
        <span data-tip="<?php echo $field['general']['description']; ?>" class="nbd-help-tip"></span>
        <?php endif; ?>
    </div>
    <div class="nbd-field-content">
        <?php 
            foreach ($field['general']['attributes']["options"] as $key => $attr): 
                $image_url = absint($attr['image']) != 0 ? wp_get_attachment_url( absint($attr['image']) ) : NBDESIGNER_ASSETS_URL . 'images/placeholder.png';
        ?>
        <input name="nbd-field[<?php echo $field['id']; ?>]" type="radio" id='nbd-field-<?php echo $field['id'].'-'.$key; ?>'/>
        <label class="nbd-swatch" style="<?php if( $attr['preview_type'] == 'i' ){echo 'background: url('.$image_url . ') 0% 0% / cover';}else{ echo 'background: '.$attr['color']; }; ?>" 
            title="<?php echo $attr['name']; ?>" for='nbd-field-<?php echo $field['id'].'-'.$key; ?>'>
        </label>
        <?php endforeach; ?>
    </div>
</div>
