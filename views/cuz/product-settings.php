<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<style>
    .nbd_setting_table {
        border: 1px solid #ddd;
        border-collapse: collapse;
        background: #fff;        
    }  
    .nbd_setting_table td, .nbd_setting_table th {
        padding: 8px 10px;
        text-align: left;
        border: 1px solid #ddd;
    }
    .nbd_setting_table th {
        border-bottom: 1px solid #ddd;
    }
    .nbd_setting_table tfoot th {
        border-top: 1px solid #ddd;
    }
    .nbd_setting_table .nbd-table-setting-label {
        margin-right: 10px;
        display: inline-block;
    }
    .nbd_setting_table .nbd-setting-table-add-rule {
        float: left;
    }
    .nbd_setting_table .nbd-setting-table-delete-rules {
        float: right;
    }    
    .nbd_setting_table .nbd-setting-table-input{
        width: 100px;
    }
    .nbd_setting_table .nbd-setting-table-input[type="color"] {
        cursor: pointer;
        padding: 0;
        margin: 0;
        height: 30px;
        width: 50px;        
    }
    .nbd_table {
        border: 1px solid #ddd;
        border-collapse: collapse;
        background: #fff;        
    }  
    .nbd_table td, .nbd_table th {
        padding: 8px 10px;
        text-align: left;
        border: 1px solid #ddd;
    }
    .nbd_table th {
        border-bottom: 1px solid #ddd;
    }
    .nbd_table tfoot th {
        border-top: 1px solid #ddd;
    }    
</style>
<div class="nbdesigner-opt-inner">
    <div>
        <label for="nbdesigner_font_size" class="nbdesigner-option-label"><?php _e('Font sizes (pt) can use', 'web-to-print-online-designer'); ?><?php echo wc_help_tip( __( 'Increment font size(pt) seperated by a comma. Do not use dots or spaces. Example: 12,14,16,18', 'web-to-print-online-designer' ) ); ?></label>
        <input name="_nbdesigner_option[listFontSizeInPt]" id="nbdesigner_font_size" value="<?php if(isset($option['listFontSizeInPt'])){ echo $option['listFontSizeInPt']; } else { echo ''; }?>" type="text" style="width: 350px; vertical-align: top;" placeholder="9,10,12,14,16,18">
    </div>   
</div>   
<?php
    $art_cat_path = NBDESIGNER_DATA_DIR . '/art_cat.json';
    $font_cat_path = NBDESIGNER_DATA_DIR . '/font_cat.json';
    $color_cat_path = NBDESIGNER_DATA_DIR . '/color_cat.json';
    $list_art_cats = (array)json_decode(file_get_contents($art_cat_path));
    $list_font_cats = (array)json_decode(file_get_contents($font_cat_path));
    $list_color_cats = (array)json_decode(file_get_contents($color_cat_path));
    $allow_all_art_cat = $allow_all_font_cat = $allow_all_color_cat = false;
    if( !isset($option['art_cats']) ){
        $allow_all_art_cat = true;
        $option['art_cats'] = array();
    }
    if( !isset($option['font_cats']) ){
        $allow_all_font_cat = true;
        $option['font_cats'] = array();
    }
    if( !isset($option['color_cats']) ){
        $allow_all_color_cat = true;
        $option['color_cats'] = array();
    }
    if( !isset($option['use_all_color']) ){
        $option['use_all_color'] = nbdesigner_get_option('nbdesigner_show_all_color') == 'yes' ? 1 : 2;
    }
    if( !isset($option['list_color']) ){
        $option['list_color'] = nbdesigner_get_option('nbdesigner_hex_names');
        $_colors = explode(",",$option['list_color']); 
        $colors = array();
        foreach($_colors as $color){
            $c = explode(':', $color);
            $colors[] = array(
                'code'  => $c[0],
                'name'  => $c[1]
            );
        }
    }else{
        $colors = $option['list_color'];
    }
?>
<div class="nbdesigner-opt-inner">
    <div>
        <label for="nbdesigner_list_art_cats" class="nbdesigner-option-label"><?php _e('Clipart categories can use', 'web-to-print-online-designer'); ?></label>
        <select name="_nbdesigner_option[art_cats][]" multiple="" id="nbdesigner_list_art_cats" class="nbd-slect-woo" style="width: 500px;">
            <?php 
                foreach($list_art_cats as $art_cat ): 
                    $selected = ($allow_all_art_cat || in_array( $art_cat->id, $option['art_cats'] )) ? ' selected="selected" ' : ''; 
            ?>
            <option value="<?php echo $art_cat->id; ?>" <?php echo $selected; ?>><?php echo $art_cat->name; ?></option>
            <?php  endforeach; ?>
        </select>
    </div>
</div>    
<div class="nbdesigner-opt-inner">
    <div>
        <label for="nbdesigner_list_font_cats" class="nbdesigner-option-label"><?php _e('Font categories can use', 'web-to-print-online-designer'); ?></label>
        <select name="_nbdesigner_option[font_cats][]" multiple="" id="nbdesigner_list_font_cats" class="nbd-slect-woo" style="width: 500px;">
            <?php 
                foreach($list_font_cats as $font_cat ): 
                    $selected = ($allow_all_font_cat || in_array( $font_cat->id, $option['font_cats'] )) ? ' selected="selected" ' : ''; 
            ?>
            <option value="<?php echo $font_cat->id; ?>" <?php echo $selected; ?>><?php echo $font_cat->name; ?></option>
            <?php  endforeach; ?>
        </select>
    </div>
</div>
<div class="nbdesigner-opt-inner">
    <div>
        <label for="nbdesigner_use_all_color" class="nbdesigner-option-label"><?php _e('Colors can use', 'web-to-print-online-designer'); ?></label>
        <input name="_nbdesigner_option[use_all_color]" value="1" type="radio" <?php checked( $option['use_all_color'], 1); ?> /><?php _e('Use all colors', 'web-to-print-online-designer'); ?>   
        &nbsp;<input name="_nbdesigner_option[use_all_color]" value="2" type="radio" <?php checked( $option['use_all_color'], 2); ?> /><?php _e('Use colors in list', 'web-to-print-online-designer'); ?>  
    </div>
</div>   
<div class="nbdesigner-opt-inner">
    <div class="<?php if( $option['use_all_color'] == 1 ) echo 'nbdesigner-disable'; ?>" id="nbd_list_colors_wrap">
        <label for="nbdesigner_list_color_cats" class="nbdesigner-option-label"><?php echo _e('List colors can use', 'web-to-print-online-designer'); ?></label>
        <select name="_nbdesigner_option[color_cats][]" multiple="" id="nbdesigner_list_color_cats" class="nbd-slect-woo" style="width: 500px;">
            <?php 
                foreach($list_color_cats as $color_cat ): 
                    $selected = ($allow_all_color_cat || in_array( $color_cat->id, $option['color_cats'] )) ? ' selected="selected" ' : ''; 
            ?>
            <option value="<?php echo $color_cat->id; ?>" <?php echo $selected; ?>><?php echo $color_cat->name; ?></option>
            <?php  endforeach; ?>
        </select>
    </div>
</div>
<div class="nbdesigner-opt-inner">     
    <div class="<?php if( $option['use_all_color'] == 1 ) echo 'nbdesigner-disable'; ?>" id="nbd_list_colors_wrap2">
        <label class="nbdesigner-option-label"><?php echo _e('List colors', 'web-to-print-online-designer'); ?></label>
        <div style="display: inline-block; vertical-align: top;">
            <table id="nbd_list_color_table" class="nbd_setting_table">
                <thead>
                    <tr>
                        <th class="check-column">
                            <input type="checkbox" >
                        </th>
                        <th class="range-column">
                            <span class="column-title" data-text="<?php _e( 'Color', 'web-to-print-online-designer' ); ?>"><?php _e( 'Color', 'web-to-print-online-designer' ); ?></span>
                        </th>
                        <th class="price-column">
                            <span><?php _e('Color name', 'web-to-print-online-designer'); ?></span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($colors as $cindex => $c): ?>
                    <tr>
                        <td><input type="checkbox" ></td>                         
                        <td><input type="color" name="_nbdesigner_option[list_color][<?php echo $cindex; ?>][code]" value="<?php echo $c['code']; ?>" class="nbd-setting-table-input short"></td>
                        <td><input type="text" name="_nbdesigner_option[list_color][<?php echo $cindex; ?>][name]" value="<?php echo $c['name']; ?>" class="nbd-setting-table-input short"></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">
                            <button type="button" data-type="quantity" class="button button-primary nbd-setting-table-add-rule"><?php _e( 'Add Color', 'web-to-print-online-designer' ); ?></button>
                            <button type="button" class="button button-secondary nbd-setting-table-delete-rules"><?php _e( 'Delete Selected', 'web-to-print-online-designer' ); ?></button>
                        </th>
                    </tr>
                </tfoot>            
            </table>
        </div>
    </div>
</div> 
<?php
    $product = wc_get_product($post_id);
    $product_type       =  $product->get_type();
    if ( $product_type == 'variable' ) :
    $product = new WC_Product_Variable( $post_id );
    $attributes = $product->get_variation_attributes();
?>
<hr />
<div class="nbdesigner-opt-inner">
    <label class="nbdesigner-option-label"><?php _e('Use attribute as color swatch', 'web-to-print-online-designer'); ?></label>
    <?php if ((!empty($attributes)) && (sizeof($attributes) >0)) : ?>
    <select name="_nbdesigner_option[att_swatch]">
        <?php foreach ($attributes as $key => $values) : ?>
        <option value="<?php echo $key; ?>" <?php if (isset($option['att_swatch']) && ($option['att_swatch'] == $key)) { echo 'selected'; } ?>><?php echo wc_attribute_label( $key ); ?></option>
        <?php endforeach; ?>
    </select>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php
    if(isset($option['att_swatch'])):
    $values = $attributes[$option['att_swatch']];
    $number_side = count($designer_setting);
?>
<div class="nbdesigner-opt-inner">
    <label class="nbdesigner-option-label"><?php _e('Attribute value background', 'web-to-print-online-designer'); ?></label>
    <table class="nbd_table">
        <thead>
            <tr>
                <th rowspan="2"><?php _e('Attribute value', 'web-to-print-online-designer'); ?></th>
                <th rowspan="2"><?php _e('Preview', 'web-to-print-online-designer'); ?></th>
                <?php foreach($designer_setting as $s_index => $side): ?>
                <th><?php echo $side['orientation_name']; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($values as $v_key => $value): ?>
            <tr>
                <td><?php echo $value; ?></td>
                <td>
                    <?php 
                        $att_img_preview_id = (isset($option['swatch_preview']) && isset($option['swatch_preview'][$value])) ? $option['swatch_preview'][$value] : 0;    
                    ?>
                    <input type="hidden" name="_nbdesigner_option[swatch_preview][<?php echo $value; ?>]" value="<?php echo $att_img_preview_id; ?>" id="att_img_preview<?php echo $value; ?>"/>
                    <img id="att_img_src_preview<?php echo $v_key; ?>" onclick="nbd_cuz_wp_media(this, 'att_img_preview<?php echo $v_key; ?>')" style="max-width : 30px; max-height: 30px; background: #ddd; border: 1px silid #ddd;" src="<?php echo wp_get_attachment_thumb_url($att_img_preview_id); ?>" />
                    <a href="javascript:void(0)" onclick="nbd_cuz_wp_media(this, 'att_img_preview<?php echo $v_key; ?>', 'att_img_src_preview<?php echo $v_key; ?>')" ><?php _e('Select image', 'web-to-print-online-designer'); ?></a>
                </td>
                    <?php foreach($designer_setting as $s_index => $side): ?>
                    <td>
                        <?php 
                            $att_img_src_id = (isset($option['swatches']) && isset($option['swatches'][$value]) && isset($option['swatches'][$value][$s_index]) && isset($option['swatches'][$value][$s_index]['image'])) ? $option['swatches'][$value][$s_index]['image'] : $side['img_src'];
                            $att_img_src = wp_get_attachment_url( $att_img_src_id );
                        ?>
                        <span style="<?php if($side['bg_type'] == 'image') echo 'display: none;'; ?>"><input class="nbd_cuz_wp_color" value="<?php if(isset($option['swatches']) && isset($option['swatches'][$value]) && isset($option['swatches'][$value][$s_index]) && isset($option['swatches'][$value][$s_index]['color'])) echo $option['swatches'][$value][$s_index]['color'];else echo $side['bg_color_value']; ?>" name="_nbdesigner_option[swatches][<?php echo $value; ?>][<?php echo $s_index; ?>][color]"/></span>
                        <input id="att_img_src<?php echo $v_key.'_'.$s_index; ?>" type="hidden" value="<?php echo $att_img_src_id; ?>" name="_nbdesigner_option[swatches][<?php echo $value; ?>][<?php echo $s_index; ?>][image]"/>
                        <img alt="<?php _e('Click to change image', 'web-to-print-online-designer'); ?>" src="<?php echo $att_img_src; ?>" style="max-width : 30px; max-height: 30px;<?php if($side['bg_type'] == 'color') echo 'display: none;'; ?>" onclick="nbd_cuz_wp_media(this, 'att_img_src<?php echo $v_key.'_'.$s_index; ?>')"/>
                    </td>
                    <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<script>
    function nbd_cuz_wp_media(e, input_id, image_id){
        var upload;
        if (upload) {
            upload.open();
            return;
        }
        var index = jQuery(e).data('index'),
            _img = image_id ? jQuery('#'+image_id) : jQuery(e),
            _input = jQuery('#'+input_id);
        upload = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        upload.on('select', function () {
            attachment = upload.state().get('selection').first().toJSON();
            _img.attr('src', attachment.url);
            _img.show();
            _input.val(attachment.id);
        });
        upload.open();        
    }
    jQuery(document).ready(function(){
        jQuery.each(jQuery('.nbd_cuz_wp_color'), function () {
            jQuery(this).wpColorPicker({
                change: function (evt, ui) {
                    var $input = jQuery(this);
                    setTimeout(function () {
                        if ($input.wpColorPicker('color') !== $input.data('tempcolor')) {
                            $input.change().data('tempcolor', $input.wpColorPicker('color'));
                            $input.val($input.wpColorPicker('color'));
                        }
                    }, 10);
                }
            });    
        });          
        jQuery('.nbd-slect-woo').selectWoo();
        jQuery('input[name="_nbdesigner_option[use_all_color]"]').on('change', function(){
            if(jQuery(this).is(':checked') && jQuery(this).val() == 2) {
                jQuery('#nbd_list_colors_wrap').removeClass('nbdesigner-disable');
            }else{
                jQuery('#nbd_list_colors_wrap').addClass('nbdesigner-disable');
            }
        });  
        jQuery('table thead input').change(function(){
            var _setting_table = jQuery(this).parents('table.nbd_setting_table').find('tbody input'),
            _check = this.checked ? true : false;
            jQuery.each(_setting_table, function(){
                jQuery(this).prop('checked', _check);
            });            
        });  
        jQuery('table .nbd-setting-table-add-rule').on('click', function(){
            var tb = jQuery(this).parents('table.nbd_setting_table').find('tbody'),
                row = tb.find('tr').last().clone();
            tb.append(row);
        });
        jQuery('table .nbd-setting-table-delete-rules').on('click', function(){
            var tb = jQuery(this).parents('table.nbd_setting_table').find('tbody');
            jQuery.each(tb.find('input:checked'), function(){
                if( tb.find('tr').length > 1 ) jQuery(this).parents('tr').remove();
            });       
            jQuery(this).parents('table.nbd_setting_table').find('thead input').prop('checked', false);
        });        
    });
</script>