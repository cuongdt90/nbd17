<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-option-field nbd-field-checkbox-wrap <?php echo $class; ?>" ng-if="nbd_fields['<?php echo $field['id']; ?>'].enable">
    <div class="nbd-field-header">
        <label><?php echo $field['general']['title']; ?></label> 
        <?php if( $field['general']['required'] == 'y' ): ?>
        <span class="nbd-required">*</span>
        <?php endif; ?>
        <?php if( $field['general']['description'] != '' ): ?>
        <span data-tip="<?php echo $field['general']['description']; ?>" class="nbd-help-tip"></span>
        <?php endif; ?>
    </div>
    <div class="nbd-field-content nbo-checkbox-wrap">
        <?php foreach ($field['general']['attributes']["options"] as $key => $attr):
            $image_url = nbd_get_image_thumbnail( $attr['image'] );
        ?>
        <input ng-disabled="nbd_fields['<?php echo $field['id']; ?>'].values.length == 1 && nbd_fields['<?php echo $field['id']; ?>']._values['<?php echo $key; ?>']" ng-change="updateMultiselectValue('<?php echo $field['id']; ?>')" value="<?php echo $key; ?>" ng-model="nbd_fields['<?php echo $field['id']; ?>']._values['<?php echo $key; ?>']" id='nbd-field-<?php echo $field['id'].'-'.$key; ?>' name="nbd-field[<?php echo $field['id']; ?>][]" type="checkbox" /> 
        <label class="nbo-checkbox" for='nbd-field-<?php echo $field['id'].'-'.$key; ?>'
            style="<?php if( $attr['preview_type'] == 'i' ){echo 'background: url('.$image_url . ') 0% 0% / cover';}else{ echo 'background: '.$attr['color']; }; ?>" 
            title="<?php echo $attr['name']; ?>" ></label>
        <?php endforeach; ?>
    </div>
</div>
