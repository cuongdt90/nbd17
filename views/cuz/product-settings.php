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
    $list_art_cats = (array)json_decode(file_get_contents($art_cat_path));
    $list_font_cats = (array)json_decode(file_get_contents($font_cat_path));
    $allow_all_art_cat = $allow_all_font_cat =false;
    if( !isset($option['art_cats']) ){
        $allow_all_art_cat = true;
        $option['art_cats'] = array();
    }
    if( !isset($option['font_cats']) ){
        $allow_all_font_cat = true;
        $option['font_cats'] = array();
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
        <label for="nbdesigner_list_art_cats" class="nbdesigner-option-label"><?php echo _e('Clipart categories can use', 'web-to-print-online-designer'); ?></label>
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
        <label for="nbdesigner_list_font_cats" class="nbdesigner-option-label"><?php echo _e('Font categories can use', 'web-to-print-online-designer'); ?></label>
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
        <label for="nbdesigner_use_all_color" class="nbdesigner-option-label"><?php echo _e('Colors can use', 'web-to-print-online-designer'); ?></label>
        <input name="_nbdesigner_option[use_all_color]" value="1" type="radio" <?php checked( $option['use_all_color'], 1); ?> /><?php _e('Use all colors', 'web-to-print-online-designer'); ?>   
        &nbsp;<input name="_nbdesigner_option[use_all_color]" value="2" type="radio" <?php checked( $option['use_all_color'], 2); ?> /><?php _e('Use colors in list', 'web-to-print-online-designer'); ?>  
    </div>
</div>    
<div class="nbdesigner-opt-inner">     
    <div class="<?php if( $option['use_all_color'] == 1 ) echo 'nbdesigner-disable'; ?>" id="nbd_list_colors_wrap">
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
<script>
    jQuery(document).ready(function(){
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