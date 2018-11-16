<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-option-field nbd-swatch-wrap <?php echo $class; ?>" ng-if="nbd_fields['<?php echo $field['id']; ?>'].enable">
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
        <?php 
            foreach ($field['general']['attributes']["options"] as $key => $attr): 
                $image_url = nbd_get_image_thumbnail( $attr['image'] );
        ?>
        <?php if($hide_swatch_label == 'no'): ?>
        <div class="nbd-swatch-label-wrap">
            <div class="nbd-swatch-value">
        <?php endif; ?>
        <input ng-change="check_valid()" value="<?php echo $key; ?>" ng-model="nbd_fields['<?php echo $field['id']; ?>'].value" name="nbd-field[<?php echo $field['id']; ?>]" type="radio" id='nbd-field-<?php echo $field['id'].'-'.$key; ?>' 
            <?php 
                if( isset($form_values[$field['id']]) ){
                    checked( $form_values[$field['id']], $key ); 
                }else{
                    checked( isset($attr['selected']) ? $attr['selected'] : 'off', 'on' ); 
                }
            ?> />
        <label class="nbd-swatch" style="<?php if( $attr['preview_type'] == 'i' ){echo 'background: url('.$image_url . ') 0% 0% / cover';}else{ echo 'background: '.$attr['color']; }; ?>" 
            title="<?php echo $attr['name']; ?>" for='nbd-field-<?php echo $field['id'].'-'.$key; ?>'>
        </label>
        <?php if($hide_swatch_label == 'no'): ?>
            </div>
            <label for='nbd-field-<?php echo $field['id'].'-'.$key; ?>'>
                <div class="nbd-swatch-description">
                    <div class="nbd-swatch-title"><b><?php echo $attr['name']; ?></b></div>
                    <?php if(isset($attr['des'])): ?>
                    <div class="nbd-swatch-title"><?php echo $attr['des']; ?></div>
                    <?php endif; ?>
                </div>
            </label>
        </div>
        <?php endif; ?>        
        <?php endforeach; ?>
    </div>
</div>
