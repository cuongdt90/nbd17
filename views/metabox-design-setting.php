<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<?php
    global $wp;
    $product = wc_get_product($post_id);
    $current_url = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<style type="text/css">
    .nbdesigner-option-size-type .nbd_pricing_table td, .nbdesigner-option-size-type .nbd_pricing_table th{
        padding: 5px 8px;
    }
    .nbdesigner-td-option-size {
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }
    .nbdesigner-td-option-size span{
        margin-right: 5px;
    }
    .nbdesigner-td-option-size input{
        max-width: 60px;
    }
    .nbdesigner-container-table {
        overflow: auto;
        max-height: 500px;
    }
    .nbd-tabs {
        margin-bottom: 0;
    }
    .nbd-tabber.selected {
        background: #eee;      
    }
    .nbd-tabber {
        display: inline-block;
        margin: 0px 5px 0px 0px;
        padding: 10px 15px;
        line-height: 18px;
        background: #fff;
        cursor: pointer;
        border: 1px solid #eee;
        border-bottom: none;        
    }    
    .nbd-options-tab {
        display: none;
    }
    .nbd-options-tab.selected {
        display: block;
    }    
    #nbd-custom-design, #nbd-upload-design {
        background: #eee;
        padding: 5px;        
    }
    .nbd-independence {
        padding-left: 15px;
        border-left: 1px solid #ddd;
    }
    .nbd-option-top {
        display: inline-block;
        margin-right: 30px;
    }
    .nbd-option-top label{
        font-weight: bold;
    }
    .rtl .nbd-option-top {
        margin-left: 30px;
        margin-right: 0px;
    }
    .nbdesigner-color-add-image {
        cursor: pointer;
    }
</style>
<div id="nbdesigner-setting-container">
    <?php wp_nonce_field('nbdesigner_setting_box', 'nbdesigner_setting_box_nonce'); ?>	
    <div>
        <p class="nbd-option-top">
            <input type="hidden" value="0" name="_nbdesigner_enable"/>
            <label for="_nbdesigner_enable"><?php _e('Enable Design', 'web-to-print-online-designer'); ?></label>
            <input type="checkbox" value="1" name="_nbdesigner_enable" id="_nbdesigner_enable" <?php checked($enable); ?> class="short" />
        </p>
        <p class="nbd-option-top <?php if (!$enable) echo 'nbdesigner-disable'; ?>" id="nbd_upload_status">
            <input type="hidden" value="0" name="_nbdesigner_enable_upload"/>
            <label for="_nbdesigner_enable_upload"><?php _e('Enable Upload Design', 'web-to-print-online-designer'); ?></label>
            <input type="checkbox" value="1" name="_nbdesigner_enable_upload" id="_nbdesigner_enable_upload" <?php checked($enable_upload); ?> class="short" /> 
        </p>
        <p class="nbd-option-top <?php if (! ($enable && $enable_upload ) ) echo 'nbdesigner-disable'; ?>" id="nbd_upload_without_design_status">
            <input type="hidden" value="0" name="_nbdesigner_enable_upload_without_design"/>
            <label for="_nbdesigner_upload_without_design"><?php _e('Enable Upload Without Design', 'web-to-print-online-designer'); ?></label>
            <input type="checkbox" value="1" name="_nbdesigner_enable_upload_without_design" id="_nbdesigner_upload_without_design" <?php checked($upload_without_design); ?> class="short" /> 
        </p>        
    </div>
    <div id="nbd-setting-container" class="<?php if (!$enable) echo 'nbdesigner-disable'; ?>">
        <ul class="nbd-tabs">
            <li class="nbd-tabber selected nbd-design" data-target="#nbd-custom-design">
                <span class="dashicons dashicons-art"></span>
                <?php _e('Cutom Design', 'web-to-print-online-designer'); ?>
            </li>
            <li class="nbd-tabber nbd-upload <?php if (!$enable_upload) echo 'nbdesigner-disable'; ?>" data-target="#nbd-upload-design">
                <span class="dashicons dashicons-upload"></span>
                <?php _e('Upload Design', 'web-to-print-online-designer'); ?>
            </li>
        </ul>
        <div id="nbd-custom-design" class="nbd-options-tab selected">
            <div class="nbdesigner-right add_more" style="display: none;">
                <a class="button button-primary" onclick="NBDESIGNADMIN.addOrientation('com')"><?php echo __('Add More', 'web-to-print-online-designer'); ?></a>
                <a class="button button-primary" onclick="NBDESIGNADMIN.collapseAll('com')"><?php echo __('Collapse All', 'web-to-print-online-designer'); ?></a>
            </div>
            <div class="nbdesigner-clearfix"></div>
            <div id="nbdesigner-boxes" class="nbdesigner-boxes">
                <?php $count = 0;
                foreach ($designer_setting as $k => $v): ?>
                    <div class="nbdesigner-box-container">
                        <div class="nbdesigner-box">
                            <label class="nbdesigner-setting-box-label"><?php _e('Name', 'web-to-print-online-designer'); ?></label>
                            <div class="nbdesigner-setting-box-value">
                                <input name="_designer_setting[<?php echo $k; ?>][orientation_name]" class="short orientation_name" 
                                       value="<?php echo $v['orientation_name']; ?>" type="text" required/>
                            </div>
                            <div class="nbdesigner-right">
                                <a class="button nbdesigner-collapse" onclick="NBDESIGNADMIN.collapseBox(this)"><span class="dashicons dashicons-arrow-up"></span><?php _e('Less setting', 'web-to-print-online-designer'); ?></a>
                                <a class="button nbdesigner-delete delete_orientation" data-index="<?php echo $k; ?>" data-variation="com" onclick="NBDESIGNADMIN.deleteOrientation(this)">&times;</a>
                            </div>
                        </div>
                        <div class="nbdesigner-box nbdesigner-box-collapse" data-variation="com">
                            <div class="nbdesigner-image-box">
                                <div class="nbdesigner-image-inner">
                                    <?php 
                                        if($v['product_width'] >= $v['product_height']){
                                            $ratio = 500 / $v['product_width'];
                                            $style_width = 500;
                                            $style_height = round($v['product_height'] * $ratio);
                                            $style_left = 0;
                                            $style_top = round((500 - $style_height) / 2);
                                            $left = 0;
                                            $top = ( $v['product_width'] - $v['product_height']) / 2;
                                        } else {
                                            $ratio = 500 / $v['product_height'];
                                            $style_height = 500;
                                            $style_width = round($v['product_width'] * $ratio);
                                            $style_top = 0;
                                            $style_left = round((500 - $style_width) / 2); 
                                            $top = 0;
                                            $left = ( $v['product_height'] - $v['product_width']) / 2;                                            
                                        }
                                        $area_design_type = isset($v['area_design_type']) ? $v['area_design_type'] : 1;
                                    ?>
                                    <div class="nbdesigner-image-original <?php if($v['bg_type'] == 'tran') echo "background-transparent"; ?>"
                                        style="width: <?php echo $style_width; ?>px;
                                               height: <?php echo $style_height; ?>px;
                                               left: <?php echo $style_left; ?>px;
                                               top: <?php echo $style_top; ?>px;
                                        <?php if($v['bg_type'] == 'color') echo 'background: ' .$v['bg_color_value']?>"       
                                    >
                                        <?php
                                            $img_src = is_numeric( $v['img_src'] ) ? wp_get_attachment_url( $v['img_src'] ) : $v['img_src'];
                                        ?>
                                        <img src="<?php echo $img_src; ?>" 
                                            <?php if($v['bg_type'] != 'image') echo ' style="display: none;"' ?>
                                             class="designer_img_src "
                                            />
                                    </div>
                                    <?php $overlay_style = 'none'; if($v['show_overlay']) $overlay_style = 'block'; ?>
                                    <div class="nbdesigner-image-overlay <?php if( $area_design_type == 2 ) echo 'nbd-rounded' ?>"
                                        style="width: <?php echo $v['area_design_width']; ?>px;
                                               height: <?php echo $v['area_design_height']; ?>px;
                                               left: <?php echo $v['area_design_left']; ?>px;
                                               top: <?php echo $v['area_design_top']; ?>px;
                                               display: <?php echo $overlay_style; ?>"                                 
                                    >
                                        <?php
                                            $img_overlay = is_numeric( $v['img_overlay'] ) ? wp_get_attachment_url( $v['img_overlay'] ) : $v['img_overlay'];
                                        ?>                                        
                                        <img src="<?php echo $img_overlay; ?>" class="img_overlay"/>
                                    </div>
                                    <div class="nbd-bleed <?php if (!$v['show_bleed']) echo 'nbdesigner-disable'; ?> <?php if( $area_design_type == 2 ) echo 'nbd-rounded' ?>"
                                        style="width: <?php echo round( $ratio * ($v['real_width'] - 2 * $v['bleed_left_right']))  ?>px;
                                                height: <?php echo round( $ratio * ($v['real_height'] - 2 * $v['bleed_top_bottom']))  ?>px;
                                                top: <?php echo round( $ratio * ($top + $v['real_top'] + $v['bleed_top_bottom']))  ?>px;
                                                left: <?php echo round( $ratio * ($left + $v['real_left'] + $v['bleed_left_right']))  ?>px;"> 
                                    </div>
                                    <div class="nbd-safe-zone <?php if (!$v['show_safe_zone']) echo 'nbdesigner-disable'; ?> <?php if( $area_design_type == 2 ) echo 'nbd-rounded' ?>"
                                        style="width: <?php echo round( $ratio * ($v['real_width'] - 2 * $v['bleed_left_right'] - 2 * $v['margin_left_right']))  ?>px;
                                                height: <?php echo round( $ratio * ($v['real_height'] - 2 * $v['bleed_top_bottom'] - 2 * $v['margin_top_bottom']))  ?>px;
                                                top: <?php echo round( $ratio * ($top + $v['real_top'] + $v['bleed_top_bottom'] + $v['margin_top_bottom']))  ?>px;
                                                left: <?php echo round( $ratio * ($left + $v['real_left'] + $v['bleed_left_right'] + $v['margin_left_right']))  ?>px;">                                         
                                    </div>
                                    <div class="nbdesigner-area-design <?php if( $area_design_type == 2 ) echo 'nbd-rounded' ?>" id="nbdesigner-area-design-<?php echo $k; ?>" 
                                         style="width: <?php echo $v['area_design_width'] . 'px'; ?>; 
                                                height: <?php echo $v['area_design_height'] . 'px'; ?>; 
                                                left: <?php echo $v['area_design_left'] . 'px'; ?>; 
                                                top: <?php echo $v['area_design_top'] . 'px'; ?>;"> </div>
                                </div>
                                <input type="hidden" class="hidden_img_src" name="_designer_setting[<?php echo $k; ?>][img_src]" value="<?php echo $v['img_src']; ?>" >
                                <input type="hidden" class="hidden_img_src_top" name="_designer_setting[<?php echo $k; ?>][img_src_top]" value="<?php echo $v['img_src_top']; ?>">
                                <input type="hidden" class="hidden_img_src_left" name="_designer_setting[<?php echo $k; ?>][img_src_left]" value="<?php echo $v['img_src_left']; ?>">
                                <input type="hidden" class="hidden_img_src_width" name="_designer_setting[<?php echo $k; ?>][img_src_width]" value="<?php echo $v['img_src_width']; ?>">
                                <input type="hidden" class="hidden_img_src_height" name="_designer_setting[<?php echo $k; ?>][img_src_height]" value="<?php echo $v['img_src_height']; ?>">
                                <input type="hidden" class="hidden_overlay_src" name="_designer_setting[<?php echo $k; ?>][img_overlay]" value="<?php echo $v['img_overlay']; ?>">
                                <input type="hidden" class="hidden_nbd_version" name="_designer_setting[<?php echo $k; ?>][version]" value="<?php echo $v['version']; ?>">
                                <input type="hidden" class="hidden_nbd_ratio" name="_designer_setting[<?php echo $k; ?>][ratio]" value="<?php echo $ratio; ?>">
                                <div>	
                                    <a class="button nbdesigner_move nbdesigner_move_left" data-index="<?php echo $k; ?>" onclick="NBDESIGNADMIN.nbdesigner_move(this, 'left')">&larr;</a>
                                    <a class="button nbdesigner_move nbdesigner_move_right" data-index="<?php echo $k; ?>" onclick="NBDESIGNADMIN.nbdesigner_move(this, 'right')">&rarr;</a>
                                    <a class="button nbdesigner_move nbdesigner_move_up" data-index="<?php echo $k; ?>" onclick="NBDESIGNADMIN.nbdesigner_move(this, 'up')">&uarr;</a>
                                    <a class="button nbdesigner_move nbdesigner_move_down" data-index="<?php echo $k; ?>" onclick="NBDESIGNADMIN.nbdesigner_move(this, 'down')">&darr;</a>
                                    <a class="button nbdesigner_move nbdesigner_move_center" data-index="<?php echo $k; ?>" onclick="NBDESIGNADMIN.nbdesigner_move(this, 'center')">&frac12;</a>
                                    <a class="button nbdesigner_move nbdesigner_move_center" style="padding-left: 7px; padding-right: 7px;" data-index="<?php echo $k; ?>" onclick="NBDESIGNADMIN.nbdesigner_move(this, 'fit')"><i class="mce-ico mce-i-dfw" style="margin: 4px 0px 0px 0px !important; padding: 0 !important;"></i></a>
                                </div>
                                <div class="nbb-background-group">
                                    <div>
                                        <p>
                                            <label for="nbdesigner_bg_type" class="nbd-label nbdesigner-setting-box-label"><?php _e('Background type'); ?></label>
                                            <label class="nbdesigner-lbl-setting"><input type="radio" name="_designer_setting[<?php echo $k; ?>][bg_type]" value="image" 
                                                <?php checked($v['bg_type'], 'image', true); ?> class="bg_type image"
                                                onclick="NBDESIGNADMIN.change_background_type(this)"   /><?php _e('Image', 'web-to-print-online-designer'); ?></label>
                                            <label class="nbdesigner-lbl-setting"><input type="radio" name="_designer_setting[<?php echo $k; ?>][bg_type]" value="color" 
                                                <?php checked($v['bg_type'], 'color', true); ?> class="bg_type color"
                                                onclick="NBDESIGNADMIN.change_background_type(this)"   /><?php _e('Color', 'web-to-print-online-designer'); ?></label>
                                            <label class="nbdesigner-lbl-setting"><input type="radio" name="_designer_setting[<?php echo $k; ?>][bg_type]" value="tran" 
                                                <?php checked($v['bg_type'], 'tran', true); ?> class="bg_type tran"
                                                onclick="NBDESIGNADMIN.change_background_type(this)"   /><?php _e('Transparent', 'web-to-print-online-designer'); ?></label>
                                        </p>
                                    </div> 
                                    <div class="nbdesigner_bg_image" <?php if($v['bg_type'] != 'image') echo ' style="display: none;"' ?>>
                                        <a class="button nbdesigner-button nbdesigner-add-image" onclick="NBDESIGNADMIN.loadImage(this)" data-index="<?php echo $k; ?>"><?php echo __('Set image', 'web-to-print-online-designer'); ?></a>     
                                    </div>
                                    <div class="nbdesigner_bg_color" <?php if($v['bg_type'] != 'color') echo ' style="display: none;"' ?>>
                                        <input type="text" name="_designer_setting[<?php echo $k; ?>][bg_color_value]" value="<?php echo $v['bg_color_value'] ?>" class="nbd-color-picker" />
                                    </div>
                                </div>    
                                <div class="nbdesigner_overlay_box" style="text-align: left;">
                                    <label class="nbd-label nbdesigner-setting-box-label"><?php  _e('Overlay', 'web-to-print-online-designer'); ?></label>
                                    <input type="hidden" value="0" name="_designer_setting[<?php echo $k; ?>][show_overlay]" class="show_overlay"/>                   
                                    <input type="checkbox" value="1" 
                                        name="_designer_setting[<?php echo $k; ?>][show_overlay]" id="_designer_setting[<?php echo $k; ?>][bg_type]" <?php checked($v['show_overlay']); ?> 
                                        class="show_overlay" onchange="NBDESIGNADMIN.toggleShowOverlay(this)"/>  
                                    <a class="button overlay-toggle" onclick="NBDESIGNADMIN.loadImageOverlay(this)" style="display: <?php if($v['show_overlay']) {echo 'inline-block';} else {echo 'none';} ?>">
                                        <?php echo __('Set image', 'web-to-print-online-designer'); ?>
                                    </a>
                                    <img style="display: <?php if($v['show_overlay']) {echo 'inline-block';} else {echo 'none';} ?>"
                                         src="<?php if ($v['img_overlay'] != '') {echo $img_overlay;} else {echo NBDESIGNER_PLUGIN_URL . 'assets/images/overlay.png';} ?>" class="img_overlay"/>                            
                                    <p class="overlay-toggle" style="display: <?php if($v['show_overlay']) {echo 'block';} else {echo 'none';} ?>">
                                        <input type="hidden" value="0" name="_designer_setting[<?php echo $k; ?>][include_overlay]" class="include_overlay"/> 
                                        <input type="checkbox" value="1"  class="include_overlay"
                                            name="_designer_setting[<?php echo $k; ?>][include_overlay]"  <?php checked($v['include_overlay']); ?>   
                                            />
                                        <span><?php  _e('Include in final design', 'web-to-print-online-designer'); ?></span>
                                    </p>
                                </div>
                                <div class="nbd_area_design_type" style="margin-top: 15px; clear: both; text-align: left;">
                                    <label class="nbd-label nbdesigner-setting-box-label"><?php  _e('Area design shape', 'web-to-print-online-designer'); ?></label>
                                    <label class="nbdesigner-lbl-setting"><input type="radio" name="_designer_setting[<?php echo $k; ?>][area_design_type]" value="1" 
                                        <?php checked($area_design_type, 1, true); ?> class="area_design_type"
                                        onclick="NBDESIGNADMIN.changeAreaDesignShape(this, 1)"   /><?php _e('Rectangle', 'web-to-print-online-designer'); ?> </label>
                                    <label class="nbdesigner-lbl-setting"><input type="radio" name="_designer_setting[<?php echo $k; ?>][area_design_type]" value="2" 
                                        <?php checked($area_design_type, 2, true); ?> class="area_design_type"
                                        onclick="NBDESIGNADMIN.changeAreaDesignShape(this, 2)"   /><?php _e('Circle/Ellipse', 'web-to-print-online-designer'); ?></label>                                    
                                </div>
                            </div>
                            <div class="nbdesigner-info-box">                             
                                <?php if($k ==0): ?>
                                <p style="margin-top: 0;">
                                    <?php if(is_admin()): ?>
                                    <small class="nbd-helper"><?php _e('(Click', 'web-to-print-online-designer'); ?>  <span class="dashicons dashicons-editor-help"></span><?php _e('to know how to setting product design)', 'web-to-print-online-designer'); ?></small><br />
                                    <?php endif; ?>
                                    <span style="background: #b8dce8; width: 15px; height: 15px; display: inline-block;"></span>&nbsp;<?php _e('Product area', 'web-to-print-online-designer'); ?>&nbsp;
                                    <span style="background: #dddacd; width: 15px; height: 15px; display: inline-block;"></span>&nbsp;<?php _e('Design area', 'web-to-print-online-designer'); ?><br />
                                    <span style="border:2px solid #f0c6f6; width: 11px; height: 11px; display: inline-block;box-sizing: content-box;"></span>&nbsp;<?php _e('Bounding box', 'web-to-print-online-designer'); ?><small> (<?php _e('product always align vertical/horizontal center bounding box', 'web-to-print-online-designer'); ?>)</small>
                                </p>
                                <?php endif; ?>                        
                                <p class="nbd-setting-section-title">
                                    <?php echo __('Product size', 'web-to-print-online-designer'); ?>
                                    <?php if($k ==0 && is_admin()): ?>
                                    <span class="nbdesign-config-size-tooltip dashicons dashicons-editor-help nbd-helper"></span>
                                    <?php endif; ?>
                                </p>
                                <div class="nbdesigner-info-box-inner notice-width nbd-has-notice">
                                    <label class="nbdesigner-setting-box-label"><?php echo __('Width', 'web-to-print-online-designer'); ?><br /><small>(W<sub>p</sub>)</small></label>
                                    <div>
                                        <input type="number" step="any" min="0" name="_designer_setting[<?php echo $k; ?>][product_width]" 
                                               value="<?php echo $v['product_width']; ?>" class="short product_width" 
                                               onchange="NBDESIGNADMIN.change_dimension_product(this, 'width')"> <?php echo $unit; ?>
                                    </div>
                                </div>
                                <div class="nbdesigner-info-box-inner notice-height nbd-has-notice">
                                    <label class="nbdesigner-setting-box-label"><?php echo __('Height', 'web-to-print-online-designer'); ?><br /><small>(H<sub>p</sub>)</small></label>
                                    <div>
                                        <input type="number" step="any" min="0" name="_designer_setting[<?php echo $k; ?>][product_height]" 
                                               value="<?php echo $v['product_height']; ?>" class="short product_height"  
                                               onchange="NBDESIGNADMIN.change_dimension_product(this, 'height')"> <?php echo $unit; ?>
                                    </div>
                                </div> 
                                <p class="nbd-setting-section-title">
                                    <?php echo __('Design area size', 'web-to-print-online-designer'); ?>
                                    <?php if($k ==0 && is_admin()): ?>
                                    <span class="nbdesign-config-realsize-tooltip dashicons dashicons-editor-help nbd-helper"></span>
                                    <?php endif; ?>                              
                                </p>
                                <div class="nbdesigner-info-box-inner notice-width nbd-has-notice">
                                    <label class="nbdesigner-setting-box-label"><?php echo __('Width', 'web-to-print-online-designer'); ?><br /><small>(W<sub>d</sub>)</small></label>
                                    <div>
                                        <input type="number" step="any" name="_designer_setting[<?php echo $k; ?>][real_width]" value="<?php echo $v['real_width']; ?>" class="short real_width" 
                                               onchange="NBDESIGNADMIN.updateRelativePosition(this, 'width')"> <?php echo $unit; ?> 
                                    </div>
                                </div>
                                <div class="nbdesigner-info-box-inner notice-height nbd-has-notice">
                                    <label class="nbdesigner-setting-box-label"><?php echo __('Height', 'web-to-print-online-designer'); ?><br /><small>(H<sub>d</sub>)</small></label>
                                    <div>
                                        <input type="number" step="any" min="0" name="_designer_setting[<?php echo $k; ?>][real_height]" value="<?php echo $v['real_height']; ?>" class="short real_height"  
                                               onchange="NBDESIGNADMIN.updateRelativePosition(this, 'height')"> <?php echo $unit; ?> 
                                    </div>
                                </div>   
                                <div class="nbdesigner-info-box-inner notice-height nbd-has-notice">
                                    <label class="nbdesigner-setting-box-label"><?php echo __('Top', 'web-to-print-online-designer'); ?><br /><small>(T<sub>d</sub>)</small></label>
                                    <div>
                                        <input type="number" step="any" min="0" name="_designer_setting[<?php echo $k; ?>][real_top]" value="<?php echo $v['real_top']; ?>" class="short real_top"  
                                               onchange="NBDESIGNADMIN.updateRelativePosition(this, 'top')"> <?php echo $unit; ?> 
                                    </div>
                                </div> 
                                <div class="nbdesigner-info-box-inner">
                                    <label class="nbdesigner-setting-box-label notice-width nbd-has-notice"><?php echo __('Left', 'web-to-print-online-designer'); ?><br /><small>(L<sub>d</sub>)</small></label>
                                    <div>
                                        <input type="number" step="any" min="0" name="_designer_setting[<?php echo $k; ?>][real_left]" value="<?php echo $v['real_left']; ?>" class="short real_left"  
                                               onchange="NBDESIGNADMIN.updateRelativePosition(this, 'left')"> <?php echo $unit; ?> 
                                    </div>
                                </div>                         
                                <p class="nbd-setting-section-title">
                                    <?php echo __('Relative position', 'web-to-print-online-designer'); ?>&nbsp;
                                    <?php if($k == 0 && is_admin()): ?> 
                                    <span class="nbdesign-config-tooltip dashicons dashicons-editor-help nbd-helper"></span>
                                    <?php endif; ?>
                                    <span class="dashicons dashicons-update nbdesiger-update-area-design" onclick="NBDESIGNADMIN.updateDesignAreaSize(this)"></span>
                                </p>
                                <div class="nbdesigner-info-box-inner">
                                    <label class="nbdesigner-setting-box-label"><?php echo __('Width', 'web-to-print-online-designer'); ?></label>
                                    <div>
                                        <input type="number" step="any"  min="0" name="_designer_setting[<?php echo $k; ?>][area_design_width]" 
                                               value="<?php echo $v['area_design_width']; ?>" class="short area_design_dimension area_design_width" data-index="width" 
                                               onchange="NBDESIGNADMIN.updatePositionDesignArea(this)">&nbsp;px
                                    </div>
                                </div>
                                <div class="nbdesigner-info-box-inner">
                                    <label class="nbdesigner-setting-box-label"><?php echo __('Height', 'web-to-print-online-designer'); ?></label>
                                    <div>
                                        <input type="number"  step="any" min="0" name="_designer_setting[<?php echo $k; ?>][area_design_height]" value="<?php echo $v['area_design_height']; ?>" class="short area_design_dimension area_design_height" data-index="height" onchange="NBDESIGNADMIN.updatePositionDesignArea(this)">&nbsp;px
                                    </div>
                                </div>	
                                <div class="nbdesigner-info-box-inner">
                                    <label class="nbdesigner-setting-box-label"><?php echo __('Left', 'web-to-print-online-designer'); ?></label>
                                    <div>
                                        <input type="number" step="any"  min="0" name="_designer_setting[<?php echo $k; ?>][area_design_left]" value="<?php echo $v['area_design_left']; ?>" class="short area_design_dimension area_design_left" data-index="left" onchange="NBDESIGNADMIN.updatePositionDesignArea(this)">&nbsp;px
                                    </div>
                                </div>	                        
                                <div class="nbdesigner-info-box-inner">
                                    <label class="nbdesigner-setting-box-label"><?php echo __('Top', 'web-to-print-online-designer'); ?></label>
                                    <div>
                                        <input type="number" step="any"  min="0" name="_designer_setting[<?php echo $k; ?>][area_design_top]" value="<?php echo $v['area_design_top']; ?>" class="short area_design_dimension area_design_top" data-index="top" onchange="NBDESIGNADMIN.updatePositionDesignArea(this)">&nbsp;px
                                    </div>
                                </div>  
                                <p class="nbd-setting-section-title"><?php _e('For paper/card', 'web-to-print-online-designer'); ?></p>
                                <div class="nbdesigner-info-box-inner">
                                    <label class="nbdesigner-setting-box-label"><?php echo __('Show bleed', 'web-to-print-online-designer'); ?> <span class="nbd-bleed-notation"></span></label>
                                    <div>
                                        <input type="hidden" value="0" class="show_bleed" name="_designer_setting[<?php echo $k; ?>][show_bleed]"/>
                                        <input type="checkbox" value="1" class="show_bleed" name="_designer_setting[<?php echo $k; ?>][show_bleed]" <?php checked( $v['show_bleed'] ); ?> class="short nbd-dependence" data-target="#nbd-bleed<?php echo $k ?>" onchange="NBDESIGNADMIN.toggleBleed(this)"/> 
                                    </div>                                    
                                </div> 
                                <div id="nbd-bleed<?php echo $k ?>" class="nbd-bleed-con <?php if (!$v['show_bleed']) echo 'nbdesigner-disable'; ?> nbd-independence">
                                    <div class="nbdesigner-info-box-inner">
                                        <label class="nbdesigner-setting-box-label"><?php echo __('Bleed top-bottom', 'web-to-print-online-designer'); ?></label>
                                        <div>
                                            <input type="number" step="any" min="0" name="_designer_setting[<?php echo $k; ?>][bleed_top_bottom]" value="<?php echo $v['bleed_top_bottom']; ?>" class="short bleed_top_bottom" onchange="NBDESIGNADMIN.updateBleed(this)">
                                        </div>
                                    </div>     
                                    <div class="nbdesigner-info-box-inner">
                                        <label class="nbdesigner-setting-box-label"><?php echo __('Bleed left-right', 'web-to-print-online-designer'); ?></label>
                                        <div>
                                            <input type="number" step="any"  min="0" name="_designer_setting[<?php echo $k; ?>][bleed_left_right]" value="<?php echo $v['bleed_left_right']; ?>" class="short bleed_left_right" onchange="NBDESIGNADMIN.updateBleed(this)">
                                        </div>
                                    </div>
                                </div>    
                                <div class="nbdesigner-info-box-inner">
                                    <label class="nbdesigner-setting-box-label"><?php echo __('Show safe zone', 'web-to-print-online-designer'); ?> <span class="nbd-safe-zone-notation"></span></label>
                                    <div>
                                        <input type="hidden" value="0" class="show_safe_zone" name="_designer_setting[<?php echo $k; ?>][show_safe_zone]"/>
                                        <input type="checkbox" value="1" class="show_safe_zone" name="_designer_setting[<?php echo $k; ?>][show_safe_zone]" <?php checked( $v['show_safe_zone'] ); ?> class="short nbd-dependence" data-target="#nbd-safe-zone<?php echo $k ?>" onchange="NBDESIGNADMIN.toggleSafeZone(this)"/> 
                                    </div>                                    
                                </div>    
                                <div id="nbd-safe-zone<?php echo $k ?>" class="nbd-safe-zone-con <?php if (!$v['show_safe_zone']) echo 'nbdesigner-disable'; ?> nbd-independence">
                                    <div class="nbdesigner-info-box-inner">
                                        <label class="nbdesigner-setting-box-label"><?php echo __('Magin top-bottom', 'web-to-print-online-designer'); ?></label>
                                        <div>
                                            <input type="number" step="any"  min="0" name="_designer_setting[<?php echo $k; ?>][margin_top_bottom]" value="<?php echo $v['margin_top_bottom']; ?>" class="short  margin_top_bottom" onchange="NBDESIGNADMIN.updateSafeZone(this)">
                                        </div>
                                    </div>     
                                    <div class="nbdesigner-info-box-inner">
                                        <label class="nbdesigner-setting-box-label"><?php echo __('Magin left-right', 'web-to-print-online-designer'); ?></label>
                                        <div>
                                            <input type="number" step="any"  min="0" name="_designer_setting[<?php echo $k; ?>][margin_left_right]" value="<?php echo $v['margin_left_right']; ?>" class="short  margin_left_right" onchange="NBDESIGNADMIN.updateSafeZone(this)">
                                        </div>
                                    </div>   
                                </div>    
                            </div>	
                        </div>
                    </div>

                    <?php $slugD = sanitize_title($v['orientation_name']);?>
                    <input name="_designer_setting[<?php echo $k; ?>][slug_nbdesigner]" value="<?php echo $slugD; ?>" type="hidden" />
            <?php $count++; endforeach; ?>
                <input type="hidden" value="<?php echo $count; ?>" id="nbdesigner-count-box"/>
            </div>
            <div id="nbdesigner-option" class="nbdesigner-option">
                <div class="nbdesigner-opt-inner">
                    <?php $multiple_edit = isset( $option['multiple_edit'] ) ? $option['multiple_edit'] : 0;?>
                    <input type="hidden" value="0" name="_nbdesigner_option[multiple_edit]"/>
                    <label for="_nbd_multiple_edit" class="nbdesigner-option-label"><?php echo _e('Multiple edit', 'web-to-print-online-designer'); ?></label>
                    <input type="checkbox" value="1" name="_nbdesigner_option[multiple_edit]" id="_nbd_multiple_edit" <?php checked( $multiple_edit ); ?> class="short"/> 
                </div>                
                <div class="nbdesigner-opt-inner">
                    <input type="hidden" value="0" name="_nbdesigner_option[admindesign]"/>
                    <label for="_nbdesigner_admindesign" class="nbdesigner-option-label"><?php echo _e('Use primary template', 'web-to-print-online-designer'); ?></label>
                    <input type="checkbox" value="1" name="_nbdesigner_option[admindesign]" id="_nbdesigner_admindesign" <?php checked( $option['admindesign'] ); ?> class="short"/>
                    <?php 
                    if( $enable ): 
                        $link_manager_template = add_query_arg(array(
                            'pid' => $post_id, 
                            'view' => 'templates'), 
                             admin_url('admin.php?page=nbdesigner_manager_product'));   
                        if( !is_admin() ) $link_manager_template =  add_query_arg(array('id' => get_current_user_id()), getUrlPageNBD('designer'));   
                        $link_create_template = add_query_arg(array(
                                'product_id' => $post_id,
                                'task'  =>  'create',
                                'rd'    => urlencode($link_manager_template)
                            ), getUrlPageNBD('create'));    
                        $variations = get_nbd_variations( $post_id );   
                    ?>
                        <?php if( count($variations) > 0 ):  ?>
                        <a class="button nbd-admin-tem-link thickbox" <?php if( !is_admin() ) echo 'onclick="NBDESIGNADMIN.show_option_variation( event )"';  ?>  href="#TB_inline?width=300&height=160&inlineId=nbd-thickbox-setting">
                                <span class="dashicons dashicons-art"></span>
                                <?php _e('Create Template', 'web-to-print-online-designer'); ?>
                            </a>                    
                        <?php else: ?>
                            <a class="button nbd-admin-tem-link" href="<?php echo $link_create_template; ?>">
                                <span class="dashicons dashicons-art"></span>
                                <?php _e('Create Template', 'web-to-print-online-designer'); ?>
                            </a>                    
                        <?php endif; ?>
                        <a href="<?php echo $link_manager_template; ?>" class="button nbd-admin-tem-link">
                            <span class="dashicons dashicons-images-alt"></span>
                            <?php _e('Manage Templates', 'web-to-print-online-designer'); ?>
                        </a>   
                        <?php if( count($variations) > 0 ):  ?>    
                            <div id="nbd-thickbox-setting" style="display:none;">
                                <table class="form-table">
                                    <tr valign="top">
                                        <th scope="row" class="titledesc"><?php echo __("Choose variation", 'web-to-print-online-designer'); ?></th>
                                        <td class="forminp-text">
                                            <select onchange="changeLink(this)">
                                            <?php foreach ($variations as $variation): ?>
                                                <option value="<?php echo $variation['id']; ?>"><?php echo $variation['name']; ?></option>
                                                <option value="0">Template apply for all variations</option>
                                            <?php endforeach; ?>
                                            </select>    
                                        </td>
                                    </tr>
                                </table>
                                <p style="text-align: center;"><a class="button button-primary nbd-create" href="<?php echo $link_create_template; ?><?php echo '&variation_id='.$variations[0]['id'];  ?>" data-href="<?php echo $link_create_template; ?>"><?php echo __("Create template", 'web-to-print-online-designer'); ?></a></p>
                            </div>  
                            <script>
                                changeLink = function(e){
                                    var vid = jQuery(e).val(),
                                    btn = jQuery(e).parents('table').siblings('p').find('a.nbd-create'),
                                    origin_fref = btn.data('href'),
                                    new_href = origin_fref + '&variation_id=' + vid;
                                    btn.attr('href', new_href);
                                }
                            </script>                              
                        <?php endif; ?>    
                    <?php endif; ?>
                </div> 
                <div class="nbdesigner-opt-inner">     
                    <div>
                        <label for="nbdesigner_dpi" class="nbdesigner-option-label"><?php echo _e('DPI ( Dots Per Inch )', 'web-to-print-online-designer'); ?></label>
                        <input name="_nbdesigner_option[dpi]" id="nbdesigner_dpi" value="<?php echo $option['dpi'];?>" type="number"  min="0" style="width: 60px;">&nbsp;
                    </div>   
                </div>   
                <div class="nbdesigner-opt-inner">
                    <label for="_nbdesigner_customprice" class="nbdesigner-option-label"><?php echo _e('Extra price', 'web-to-print-online-designer'); ?></label>
                    <input type="number" step="any" class="short nbdesigner-short-input wc_input_price" id="_nbdesigner_customprice" name="_nbdesigner_option[extra_price]" value="<?php echo $option['extra_price']; ?>"/>
                    &nbsp;<input name="_nbdesigner_option[type_price]" value="1" type="radio" <?php checked( $option['type_price'], 1); ?> /><?php _e('Flaten', 'web-to-print-online-designer'); ?>   
                    &nbsp;<input name="_nbdesigner_option[type_price]" value="2" type="radio" <?php checked( $option['type_price'], 2); ?> /><?php _e('Percentage', 'web-to-print-online-designer'); ?>                   
                </div>
                <div class="nbdesigner-opt-inner">
                    <input type="hidden" value="0" name="_nbdesigner_option[bulk_variation]"/>
                    <?php $bulk_variation = isset($option['bulk_variation']) ? $option['bulk_variation'] : 0; ?>
                    <label for="_nbd_bulk_variation" class="nbdesigner-option-label"><?php echo _e('Bulk variation', 'web-to-print-online-designer'); ?></label>
                    <input type="checkbox" value="1" name="_nbdesigner_option[bulk_variation]" id="_nbd_bulk_variation" <?php checked( $bulk_variation ); ?> class="short"/> 
                    <?php echo __('Enable bulk variation form - add to cart multiple variation with same design', 'web-to-print-online-designer'); ?>
                </div>                
                <div class="nbdesigner-opt-inner">
                    <input type="hidden" value="0" name="_nbdesigner_option[request_quote]"/>
                    <label for="_nbd_request_quote" class="nbdesigner-option-label"><?php echo _e('Get a quote', 'web-to-print-online-designer'); ?></label>
                    <input type="checkbox" value="1" name="_nbdesigner_option[request_quote]" id="_nbd_request_quote" <?php checked( $option['request_quote'] ); ?> class="short"/> 
                    <?php echo __('Set product price to ', 'web-to-print-online-designer') . wc_price(0); ?>
                </div>
                <div class="nbdesigner-opt-inner">
                    <input type="hidden" value="0" name="_nbdesigner_option[allow_specify_dimension]"/>
                    <label for="_nbd_allow_specify_dimension" class="nbdesigner-option-label"><?php echo _e('Allow user define dimension', 'web-to-print-online-designer'); ?></label>
                    <input type="checkbox" value="1" name="_nbdesigner_option[allow_specify_dimension]" id="_nbd_allow_specify_dimension" <?php checked( $option['allow_specify_dimension'] ); ?> class="short nbd-dependence" data-target="#nbd-custom-size"/>
                </div> 
                <div id="nbd-custom-size" class="<?php if (!$option['allow_specify_dimension']) echo 'nbdesigner-disable'; ?> nbd-independence nbdesigner-opt-inner">
                    <label for="_nbdesigner_customprice" class="nbdesigner-option-label"><?php echo _e('Allow', 'web-to-print-online-designer'); ?></label>
                    <input name="_nbdesigner_option[type_dimension]" value="1" type="radio" <?php checked( $option['type_dimension'], 1); ?> class="nbd-dependence" data-target="#nbd-custom-size-free" /><?php _e('All dimensions', 'web-to-print-online-designer'); ?>   
                    <input name="_nbdesigner_option[type_dimension]" value="2" type="radio" <?php checked( $option['type_dimension'], 2); ?> class="nbd-dependence" data-target="#nbd-custom-size-defined" /><?php _e('Predefined dimensions', 'web-to-print-online-designer'); ?>
                    <div id="nbd-custom-size-free" class="<?php if ($option['type_dimension'] != 1) echo 'nbdesigner-disable'; ?> nbd-untarget">
                        <div class="nbdesigner-opt-inner">
                            <label class="nbdesigner-option-label"><?php echo _e('Min', 'web-to-print-online-designer'); ?> (<?php echo $unit; ?>)</label>
                            <?php _e('Width', 'web-to-print-online-designer'); ?>: <input type="number" step="any" class="short nbdesigner-short-input" name="_nbdesigner_option[min_width]" value="<?php echo $option['min_width']; ?>"/>
                            <?php _e('Height', 'web-to-print-online-designer'); ?>: <input type="number" step="any" class="short nbdesigner-short-input" name="_nbdesigner_option[min_height]" value="<?php echo $option['min_height']; ?>"/>
                        </div>       
                        <div class="nbdesigner-opt-inner">
                            <label class="nbdesigner-option-label"><?php echo _e('Max', 'web-to-print-online-designer'); ?> (<?php echo $unit; ?>)</label>
                            <?php _e('Width', 'web-to-print-online-designer'); ?>: <input type="number" step="any" class="short nbdesigner-short-input" name="_nbdesigner_option[max_width]" value="<?php echo $option['max_width']; ?>"/>
                            <?php  _e('Height', 'web-to-print-online-designer'); ?>: <input type="number" step="any" class="short nbdesigner-short-input" name="_nbdesigner_option[max_height]" value="<?php echo $option['max_height']; ?>"/>
                        </div>  
                    </div>
                    <div id="nbd-custom-size-defined" class="<?php if ($option['type_dimension'] != 2) echo 'nbdesigner-disable'; ?> nbd-untarget">
                        <?php foreach ($option['defined_dimension'] as $key => $dim): ?>
                            <div class="nbdesigner-opt-inner nbd-defined-size">
                                <?php _e('Width', 'web-to-print-online-designer'); ?>: <input type="number" step="any" class="short nbdesigner-short-input nbd-defined-width" name="_nbdesigner_option[defined_dimension][<?php echo $key; ?>][width]" value="<?php echo $dim['width']; ?>"/>
                                <?php _e('Height', 'web-to-print-online-designer'); ?>: <input type="number" step="any" class="short nbdesigner-short-input nbd-defined-height" name="_nbdesigner_option[defined_dimension][<?php echo $key; ?>][height]" value="<?php echo $dim['height']; ?>"/>
                                <?php _e('Extra price', 'web-to-print-online-designer'); ?>: <input type="number" step="any" class="short nbdesigner-short-input nbd-defined-price" name="_nbdesigner_option[defined_dimension][<?php echo $key; ?>][price]" value="<?php echo $dim['price']; ?>"/>
                                <a class="button nbdesigner-delete" onclick="NBDESIGNADMIN.deleteDefinedDimension(this)">&times;</a>
                            </div>             
                        <?php endforeach; ?>
                        <div style="margin-top: 15px;" id="nbd-duplicate-size-con">
                            <p><small>(<?php _e('Extra price for each variation, ex: + 5 or - 5', 'web-to-print-online-designer'); ?>)</small></p>
                            <a class="button button-primary" onclick="NBDESIGNADMIN.duplicateDefinedDimension(this)"><?php _e('Add', 'web-to-print-online-designer'); ?></a>
                        </div>
                    </div>
                    <div class="nbdesigner-opt-inner">
                        <label class="nbdesigner-option-label"><?php echo _e('Dynamic page / side', 'web-to-print-online-designer'); ?></label>
                        <input name="_nbdesigner_option[dynamic_side]" value="1" type="radio" <?php checked( $option['dynamic_side'], 1); ?> /><?php _e('Yes', 'web-to-print-online-designer'); ?>   
                        &nbsp;<input name="_nbdesigner_option[dynamic_side]" value="0" type="radio" <?php checked( $option['dynamic_side'],0); ?> /><?php _e('No', 'web-to-print-online-designer'); ?>  
                    </div>      
                    <div class="nbdesigner-opt-inner nbd-price-per-page <?php if ($option['dynamic_side'] != 1) echo 'nbdesigner-disable'; ?>">
                        <label class="nbdesigner-option-label"><?php echo _e('Price per page/side', 'web-to-print-online-designer'); ?></label>
                        <input type="number" step="any" class="short nbdesigner-short-input wc_input_price" name="_nbdesigner_option[price_per_page]" value="<?php if(isset($option['price_per_page'])) echo $option['price_per_page']; else echo '0'; ?>"/>
                    </div>
                </div> 
                <?php do_action('nbd_after_option_product_design', $post_id, $option); ?>

                <!-- Option color -->
                <div class="nbdesigner-opt-inner">
                    <label class="nbdesigner-option-label"><?php echo _e('Option color', 'web-to-print-online-designer'); ?></label>
                    <?php
                        $option_color = isset($option['color']['show']) ? $option['color']['show'] : 0;
                        $option_color_type = isset($option['color']['type']) ? $option['color']['type'] : 'setting';
                    ?>

                    <input name="_nbdesigner_option[color][show]" value="1" type="radio" <?php checked( $option_color, 1); ?> /><?php _e('Yes', 'web-to-print-online-designer'); ?>
                    <input name="_nbdesigner_option[color][show]" value="0" type="radio" <?php checked( $option_color,0); ?> /><?php _e('No', 'web-to-print-online-designer'); ?>
                </div>
                <div class="nbdesigner-opt-inner nbd-independence nbdesigner-option-color-type" style="display: <?php echo ($option_color == 0) ? 'none' : 'block';?>" >
                    <label class="nbdesigner-option-label"><?php echo _e('Color Type', 'web-to-print-online-designer'); ?></label>
                    <input name="_nbdesigner_option[color][type]" value="setting" type="radio" <?php echo ($option_color_type == 'setting') ? 'checked="checked"' : ''?>  /><?php _e('Setting color', 'web-to-print-online-designer'); ?>
                    <?php if ($product->is_type('variable')) : ?>
                        <input name="_nbdesigner_option[color][type]" value="swatch" type="radio" <?php echo ($option_color_type == 'swatch') ? 'checked="checked"' : ''?> /><?php _e('Color swatch', 'web-to-print-online-designer'); ?>
                    <?php endif; ?>
                    <div class="nbdesigner-container-table nbdesigner-opt-inner nbd-independence nbdesigner-option-color-type-setting" style="display: <?php echo ($option_color_type == 'setting') ? 'block' : 'none'?>">
                        <table class="nbdesigner-option-color-setting nbd_pricing_table">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <?php foreach ($designer_setting as $key => $value) : ?>
                                    <td><?php echo $value['orientation_name'];?></td>
                                    <?php endforeach; ?>
                                    <td><a href="#" class="button-secondary" id="nbdesigner-add-color-setting">Add</a></td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $color_setting = (isset($option['color']['setting'])) ? $option['color']['setting'] : array();
                                $color_setting_name = (isset($option['color']['setting']['name'])) ? $option['color']['setting']['name'] : array();
                            ?>
                            <?php foreach ($color_setting_name as $key => $value):?>
                                <tr>
                                    <td>
                                        <input type="text" name="_nbdesigner_option[color][setting][name][]" value="<?php echo $value;?>">
                                    </td>
<!--                                    --><?php //echo '<pre>'; print_r($color_setting); echo '</pre>'; echo __FILE__; die(); ?>
                                    <?php foreach ($designer_setting as $keyD => $valueD) : ?>
                                        <?php $slugD = ($valueD['slug_nbdesigner'] !== '') ? $valueD['slug_nbdesigner'] : sanitize_title($valueD['orientation_name']); ?>
                                        <?php $src = wp_get_attachment_image_src($color_setting[$slugD]['image_id'][$key], 'full', ''); ?>
                                        <td>
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="_nbdesigner_option[color][setting][<?php echo $slugD; ?>][hex][]" value="<?php echo $color_setting[$slugD]['hex'][$key]; ?>" class="nbdesigner-option-color-setting-select" />
                                                    </td>

                                                    <td>
                                                        <?php if (is_array($src)) : ?>
                                                            <img src="<?php echo $src[0];?>" width="30px" alt="Product" class="nbdesigner-color-setting-add-image" data-designer="<?php echo $slugD;?>">
                                                            <input type="hidden" name="_nbdesigner_option[color][setting][<?php echo $slugD; ?>][image_id][]" value="<?php echo $color_setting[$slugD]['image_id'][$key]?>">
                                                        <?php else: ?>
                                                            <a class="button nbdesigner-button nbdesigner-color-setting-add-image" data-designer="<?php echo $slugD;?>">Add image</a>
                                                            <input type="hidden" name="_nbdesigner_option[color][setting][<?php echo $slugD; ?>][image_id][]" value="0">
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    <?php endforeach; ?>

                                    <td><a href="#" class="nbdesigner-remove-color-setting">×</a></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <?php if ($product->is_type('variable')) : ?>
                    <?php
                    $attributes = $product->get_variation_attributes();
                    $arrAttr = array();
                    foreach ($attributes as $keyAttr =>$attribute) {
                        $arrTerms = array();
                        foreach ($attribute as $value) {
                            $tmp = array();
                            $tmp['name'] = $value;
                            $tmp['slug'] = $value;
                            $arrTerms[$value] = $tmp;
                        }
                        $arrAttr[$keyAttr] = $arrTerms;
                    }
                    $attsSwatch = (!empty($option['color']['swatch'])) ? $option['color']['swatch'] : array();
                    if (empty($attsSwatch) || !isset($attsSwatch)) {
                        $attsSwatch = [];
                        foreach ($arrAttr as $keyAtt => $attribute) {
                            $tmpAtt = [];
                            foreach ($attribute as $keyValue => $value) {
                                $tmpValue = [];
                                $tmpValue['slug'] = $value['slug'];
                                $tmpValue['name'] = $value['name'];
                                foreach ($designer_setting as $keyDesign => $designer) {
                                    $tmpDesigner = [];
                                    $slugDesigner = ($designer['slug_nbdesigner'] !== '') ? $designer['slug_nbdesigner'] : sanitize_title($designer['orientation_name']);

                                    $tmpDesigner['color'] = '';
                                    $tmpDesigner['image_id'] = 0;

                                    $tmpValue[$slugDesigner] = $tmpDesigner;
                                }
                                $tmpAtt[$keyValue] = $tmpValue;
                            }
                            $attsSwatch[$keyAtt] = $tmpAtt;
                        }
                    }
                    ?>
                    <div class="nbdesigner-container-table nbdesigner-opt-inner nbd-independence nbdesigner-option-color-type-swatch" style="display: <?php echo ($option_color_type == 'swatch') ? 'block' : 'none'?>">
                        <div class="nbdesigner-option-color-swatch-dropdown" style="margin-bottom: 20px">
                            <strong>Choose Form Values</strong>
                            <select class="nbdesigner-color-swatch-attribute" name="nbdesigner-color-swatch-attribute" data-current="">
                                <option value="" selected="selected"></option>
                                <?php foreach ($attributes as $key => $value):?>
                                    <?php $name = wc_attribute_label($key); ?>
                                    <option value="<?php echo $key; ?>"><?php echo $name;?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <table class="nbdesigner-option-color-swatch nbd_pricing_table" style="display: none">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <?php foreach ($designer_setting as $keyDesign => $designer): ?>
                                        <td><?php echo $designer['orientation_name'];?></td>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <?php
                            foreach ($attsSwatch as $keyAtt => $values):
                            ?>
                            <tbody class="<?php echo $keyAtt;?>" style="display: none">
                                <?php foreach ($values as $key => $value): ?>
                                    <tr>
                                        <td>
                                            <span><?php echo $value['name']?></span>
                                            <input type="hidden" name="_nbdesigner_option[color][swatch][<?php echo $keyAtt; ?>][<?php echo $value['slug']?>][slug]" value="<?php echo $value['slug'];?>">
                                            <input type="hidden" name="_nbdesigner_option[color][swatch][<?php echo $keyAtt; ?>][<?php echo $value['slug']?>][name]" value="<?php echo $value['name'];?>">
                                        </td>
                                        <?php foreach ($designer_setting as $keyDesign => $designer): ?>
                                            <?php
                                                $slugDesigner = ($designer['slug_nbdesigner'] !== '') ? $designer['slug_nbdesigner'] : sanitize_title($designer['orientation_name']);
                                                $src = wp_get_attachment_image_src($value[$slugDesigner]['image_id'], 'full', '');
                                            ?>
                                            <td>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <td><input type="text" name="_nbdesigner_option[color][swatch][<?php echo $keyAtt; ?>][<?php echo $value['slug']?>][<?php echo $slugDesigner;?>][color]" value="<?php echo $value[$slugDesigner]['color'];?>" class="nbdesigner-option-color-select" /></td>
                                                            <td>
                                                                <?php if ($value[$slugDesigner]['image_id']): ?>
                                                                    <img src="<?php echo $src[0];?>" width="30px" alt="Product" class="nbdesigner-color-add-image" data-designer="<?php echo $slugDesigner;?>" data-slug="<?php echo $value['slug'];?>">
                                                                    <input type="hidden" name="_nbdesigner_option[color][swatch][<?php echo $keyAtt; ?>][<?php echo $value['slug']?>][<?php echo $slugDesigner;?>][image_id]" value="<?php echo $value[$slugDesigner]['image_id'];?>">
                                                                <?php else: ?>
                                                                    <a class="button nbdesigner-button nbdesigner-color-add-image" data-slug="<?php echo $value['slug'];?>" data-designer="<?php echo $slugDesigner;?>">Add image</a>
                                                                    <input type="hidden" name="_nbdesigner_option[color][swatch][<?php echo $keyAtt; ?>][<?php echo $value['slug']?>][<?php echo $slugDesigner;?>][image_id]" value="0">
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- End option color -->

                <!-- Option size -->
                <div class="nbdesigner-opt-inner">
                    <label class="nbdesigner-option-label"><?php echo _e('Option size', 'web-to-print-online-designer'); ?></label>
                    <?php
                    $option_size = isset($option['size']['show']) ? $option['size']['show'] : 0;
                    $option_size_type = isset($option['size']['type']) ? $option['size']['type'] : 'setting';
                    ?>

                    <input name="_nbdesigner_option[size][show]" value="1" type="radio" <?php checked( $option_size, 1); ?> /><?php _e('Yes', 'web-to-print-online-designer'); ?>
                    <input name="_nbdesigner_option[size][show]" value="0" type="radio" <?php checked( $option_size,0); ?> /><?php _e('No', 'web-to-print-online-designer'); ?>
                </div>

                <div class="nbdesigner-opt-inner nbd-independence nbdesigner-option-size-type" style="display: <?php echo ($option_size == 0) ? 'none' : 'block';?>" >
                    <label class="nbdesigner-option-label"><?php echo _e('Size Type', 'web-to-print-online-designer'); ?> <?php echo wc_help_tip( __( 'Require enable "Allow user define demension"', 'web-to-print-online-designer' ) ); ?></label>
                    <input name="_nbdesigner_option[size][type]" value="setting" type="radio" <?php echo ($option_size_type == 'setting') ? 'checked="checked"' : ''?>  /><?php _e('Setting size', 'web-to-print-online-designer'); ?>
                    <?php if ($product->is_type('variable')) : ?>
                        <input name="_nbdesigner_option[size][type]" value="swatch" type="radio" <?php echo ($option_size_type == 'swatch') ? 'checked="checked"' : ''?> /><?php _e('Size swatch', 'web-to-print-online-designer'); ?>
                    <?php endif; ?>

                    <?php
                    $size_setting = (isset($option['size']['setting'])) ? $option['size']['setting'] : array();
                    $size_setting_name = (isset($option['size']['setting']['name'])) ? $option['size']['setting']['name'] : array();
                    ?>
                    <div class="nbdesigner-container-table nbdesigner-opt-inner nbdesigner-option-size-type-setting" style="display: <?php echo ($option_size_type == 'setting') ? 'block' : 'none'?>">
                        <table class="nbdesigner-option-size-setting nbd_pricing_table">
                            <thead>
                            <tr>
                                <td>Name</td>
                                <?php foreach ($designer_setting as $key => $value) : ?>
                                    <td><?php echo $value['orientation_name'];?> (unit:px)</td>
                                <?php endforeach; ?>
                                <td><a href="#" class="button-secondary" id="nbdesigner-add-size-setting">Add</a></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($size_setting_name as $key => $value):?>
                                <tr>
                                    <td>
                                        <input type="text" name="_nbdesigner_option[size][setting][name][]" style="max-width: 120px" value="<?php echo $value;?>">
                                    </td>
                                    <?php foreach ($designer_setting as $keyD => $valueD) : ?>
                                        <?php $slugD = ($valueD['slug_nbdesigner'] !== '') ? $valueD['slug_nbdesigner'] : sanitize_title($valueD['orientation_name']); ?>
                                        <td>
                                            <table>
                                                <tbody>
                                                <input type="hidden" name="_nbdesigner_option[size][setting][<?php echo $slugD; ?>][width_pro][]" value="<?php echo $color_setting[$slugD]['width_pro'][$key]; ?>"/>
                                                <input type="hidden" name="_nbdesigner_option[size][setting][<?php echo $slugD; ?>][height_pro][]" value="<?php echo $color_setting[$slugD]['height_pro'][$key]; ?>"/>
                                                <tr>
                                                    <td>
                                                        <div class="nbdesigner-td-option-size">
                                                            <span>width</span>
                                                            <input type="number" min="0" name="_nbdesigner_option[size][setting][<?php echo $slugD; ?>][width_d][]" value="<?php echo $size_setting[$slugD]['width_d'][$key]; ?>"/>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="nbdesigner-td-option-size">
                                                            <span>height</span>
                                                            <input type="number" min="0" name="_nbdesigner_option[size][setting][<?php echo $slugD; ?>][height_d][]" value="<?php echo $size_setting[$slugD]['height_d'][$key]; ?>"/>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="nbdesigner-td-option-size">
                                                            <span>Top</span>
                                                            <input type="number" min="0" name="_nbdesigner_option[size][setting][<?php echo $slugD; ?>][top_d][]" value="<?php echo $size_setting[$slugD]['top_d'][$key]; ?>"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="nbdesigner-td-option-size">
                                                            <span>Left</span>
                                                            <input type="number" min="0" name="_nbdesigner_option[size][setting][<?php echo $slugD; ?>][left_d][]" value="<?php echo $size_setting[$slugD]['left_d'][$key]; ?>"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    <?php endforeach; ?>

                                    <td><a href="#" class="nbdesigner-remove-size-setting">×</a></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($product->is_type('variable')) : ?>

                    <?php
                        $attsSizeSwatch = (!empty($option['size']['swatch'])) ? $option['size']['swatch'] : array();
                        if (empty($attsSizeSwatch) || !isset($attsSizeSwatch)) {
                        $attsSizeSwatch = [];
                        foreach ($arrAttr as $keyAtt => $attribute) {
                            $tmpAtt = [];
                            foreach ($attribute as $keyValue => $value) {
                                $tmpValue = [];
                                $tmpValue['slug'] = $value['slug'];
                                $tmpValue['name'] = $value['name'];
                                foreach ($designer_setting as $keyDesign => $designer) {
                                    $tmpDesigner = [];
                                    $slugDesigner = ($designer['slug_nbdesigner'] !== '') ? $designer['slug_nbdesigner'] : sanitize_title($designer['orientation_name']);
                                    $tmpDesigner['width_pro'] = $designer['product_width'];
                                    $tmpDesigner['height_pro'] = $designer['product_height'];
                                    $tmpDesigner['width_d'] = $designer['img_src_width'];
                                    $tmpDesigner['height_d'] = $designer['img_src_height'];
                                    $tmpDesigner['left_d'] = $designer['img_src_left'];
                                    $tmpDesigner['top_d'] = $designer['img_src_top'];

                                    $tmpValue[$slugDesigner] = $tmpDesigner;
                                }
                                $tmpAtt[$keyValue] = $tmpValue;
                            }
                            $attsSizeSwatch[$keyAtt] = $tmpAtt;
                        }
                    }
                    ?>
                    <div class="nbdesigner-container-table nbdesigner-opt-inner nbd-independence nbdesigner-option-size-type-swatch" style="display: <?php echo ($option_size_type == 'swatch') ? 'block' : 'none'?>">
                        <div class="nbdesigner-option-size-swatch-dropdown" style="margin-bottom: 20px">
                            <strong>Choose Form Values</strong>
                            <select class="nbdesigner-size-swatch-attribute" name="nbdesigner-size-swatch-attribute" data-current="">
                                <option value="" selected="selected"></option>
                                <?php foreach ($attributes as $key => $value):?>
                                    <?php $name = wc_attribute_label($key); ?>
                                    <option value="<?php echo $key; ?>"><?php echo $name;?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <table class="nbdesigner-option-size-swatch nbd_pricing_table" style="display: none">
                            <thead>
                            <tr>
                                <td>Name</td>
                                <?php foreach ($designer_setting as $keyDesign => $designer): ?>
                                    <td><?php echo $designer['orientation_name'];?></td>
                                <?php endforeach; ?>
                            </tr>
                            </thead>
                            <?php
                            foreach ($attsSizeSwatch as $keyAtt => $values):
                                ?>
                                <tbody class="<?php echo $keyAtt;?>" style="display: none">
                                <?php foreach ($values as $key => $value): ?>
                                    <tr>
                                        <td>
                                            <span><?php echo $value['name']?></span>
                                            <input type="hidden" name="_nbdesigner_option[size][swatch][<?php echo $keyAtt; ?>][<?php echo $value['slug']?>][slug]" value="<?php echo $value['slug'];?>">
                                            <input type="hidden" name="_nbdesigner_option[size][swatch][<?php echo $keyAtt; ?>][<?php echo $value['slug']?>][name]" value="<?php echo $value['name'];?>">
                                        </td>
                                        <?php foreach ($designer_setting as $keyDesign => $designer): ?>
                                            <?php
                                            $slugDesigner = ($designer['slug_nbdesigner'] !== '') ? $designer['slug_nbdesigner'] : sanitize_title($designer['orientation_name']);
                                            ?>
                                            <td>
                                                <table>
                                                    <tbody>
                                                    <input type="hidden" name="_nbdesigner_option[size][swatch][<?php echo $keyAtt; ?>][<?php echo $value['slug']?>][<?php echo $slugDesigner;?>][width_pro]" value="<?php echo $value[$slugDesigner]['width_pro']; ?>"/>
                                                    <input type="hidden" name="_nbdesigner_option[size][swatch][<?php echo $keyAtt; ?>][<?php echo $value['slug']?>][<?php echo $slugDesigner;?>][height_pro]" value="<?php echo $value[$slugDesigner]['height_pro']; ?>"/>
                                                    <tr>
                                                        <td>
                                                            <div class="nbdesigner-td-option-size">
                                                                <span>width</span>
                                                                <input type="number" min="0" name="_nbdesigner_option[size][swatch][<?php echo $keyAtt; ?>][<?php echo $value['slug']?>][<?php echo $slugDesigner;?>][width_d]" value="<?php echo $value[$slugDesigner]['width_d']; ?>"/>
                                                                <span style="margin-left: 5px">px</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="nbdesigner-td-option-size">
                                                                <span>height</span>
                                                                <input type="number" min="0" name="_nbdesigner_option[size][swatch][<?php echo $keyAtt; ?>][<?php echo $value['slug']?>][<?php echo $slugDesigner;?>][height_d]" value="<?php echo $value[$slugDesigner]['height_d']; ?>"/>
                                                                <span style="margin-left: 5px">px</span>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="nbdesigner-td-option-size">
                                                                <span>Top</span>
                                                                <input type="number" min="0" name="_nbdesigner_option[size][swatch][<?php echo $keyAtt; ?>][<?php echo $value['slug']?>][<?php echo $slugDesigner;?>][top_d]" value="<?php echo $value[$slugDesigner]['top_d']; ?>"/>
                                                                <span style="margin-left: 5px">px</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="nbdesigner-td-option-size">
                                                                <span>Left</span>
                                                                <input type="number" min="0" name="_nbdesigner_option[size][swatch][<?php echo $keyAtt; ?>][<?php echo $value['slug']?>][<?php echo $slugDesigner;?>][left_d]" value="<?php echo $value[$slugDesigner]['left_d']; ?>"/>
                                                                <span style="margin-left: 5px">px</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- End option size -->
            </div>
        </div>
        <div id="nbd-upload-design" class="nbd-options-tab" style="padding: 10px;">
            <div class="nbdr-opt-inner">
                <label for="_nbdesigner_allow_upload" class="nbdesigner-option-label"><?php echo _e('Allowed file types', 'web-to-print-online-designer'); ?></label>
                <input type="text" id="_nbdesigner_allow_upload" name="_designer_upload[allow_type]" value="<?php echo $upload_setting['allow_type']; ?>" class="regular-text"/>
                <p style="padding-left: 200px; font-style: italic; "><?php _e('Extensions seperated by a comma. Don not use dots or spaces. Example: <code>jpg,bmp,pdf,ps,ai,iddd</code>', 'web-to-print-online-designer'); ?></p>
            </div>      
            <div class="nbdr-opt-inner">
                <label for="_nbdesigner_disallow_upload" class="nbdesigner-option-label"><?php echo _e('Disallowed file types', 'web-to-print-online-designer'); ?></label>
                <input type="text" id="_nbdesigner_disallow_upload" name="_designer_upload[disallow_type]" value="<?php echo $upload_setting['disallow_type']; ?>" class="regular-text"/>
                <p style="padding-left: 200px; font-style: italic; "><?php _e('Extensions seperated by a comma. Don not use dots or spaces. Example: <code>png,gif</code>', 'web-to-print-online-designer'); ?></p>
            </div>              
            <div class="nbdr-opt-inner">
                <label for="_nbdesigner_number_upload" class="nbdesigner-option-label"><?php echo _e('Number of uploads', 'web-to-print-online-designer'); ?></label>
                <input type="number" step="any" class="short nbdesigner-short-input" id="_nbd_number_upload" name="_designer_upload[number]" value="<?php echo $upload_setting['number']; ?>"/>
            </div>  
            <div class="nbdesigner-opt-inner">
                <label for="_nbdesigner_min_size_upload" class="nbdesigner-option-label"><?php echo _e('Min size', 'web-to-print-online-designer'); ?></label>
                <input type="number" step="any" class="short nbdesigner-short-input" id="_nbdesigner_min_size_upload" name="_designer_upload[minsize]" value="<?php echo $upload_setting['minsize']; ?>"/>&nbsp;MB
            </div>  
            <div class="nbdesigner-opt-inner">
                <label for="_nbdesigner_max_size_upload" class="nbdesigner-option-label"><?php echo _e('Max size', 'web-to-print-online-designer'); ?></label>
                <input type="number" step="any" class="short nbdesigner-short-input" id="_nbdesigner_max_size_upload" name="_designer_upload[maxsize]" value="<?php echo $upload_setting['maxsize']; ?>"/>&nbsp;MB
            </div> 
            <div class="nbdesigner-opt-inner">
                <label for="_nbd_mindpi_upload" class="nbdesigner-option-label"><?php echo _e('Min. resolution DPI for JPG image', 'web-to-print-online-designer'); ?></label>
                <input type="number" step="any" class="short nbdesigner-short-input" id="_nbd_mindpi_upload" name="_designer_upload[mindpi]" value="<?php echo $upload_setting['mindpi']; ?>"/>
            </div>
        </div>
    </div>    
</div>

<script type="text/javascript">

    jQuery(document).ready( function($) {
        $('.nbd-tabber').click(function() {
            var t = $(this),
                s = $('.nbd-tabber.selected');

            s.removeClass("selected");
            t.addClass("selected");
            $(s.data('target')).fadeOut(0);
            $(t.data('target')).fadeIn(200);
        });
        var direction = "<?php if(is_rtl()) echo 'right'; else echo 'left'; ?>";
        var options = {
            "content":"<h3>" + "<?php _e('Notice', 'web-to-print-online-designer'); ?>" + "<\/h3>" +
            "<p>" + "<?php _e('Bellow values must in range from 0 to 500px', 'web-to-print-online-designer'); ?>" + "<\/p>" +
            "<p>" + "<?php _e('There are relative position of design area in bounding box.', 'web-to-print-online-designer'); ?>" + "<\/p>" +
            "<p><img style='max-width: 100%;' src='"+"<?php echo NBDESIGNER_PLUGIN_URL .'assets/images/bounding-box.png'; ?>"+"' /><br /><a href='"+"<?php echo NBDESIGNER_PLUGIN_URL .'assets/images/bounding-box.png'; ?>"+"' target='_blank'>" + "<?php  _e('See detail', 'web-to-print-online-designer'); ?>" + "</a></p>",
            "position": {"edge":direction, "align":"center"}
        };
        if ( ! options ) return;
        options = $.extend( options, {
            close: function() {
                //to do
            }
        });
        $('.nbdesign-config-tooltip').first().pointer( options );
        $('.nbdesign-config-tooltip').first().on('click', function(){
            $(this).pointer("open")
        });
        var size_options = {
            "content" : "<h3>" + "<?php _e('Notice', 'web-to-print-online-designer'); ?>" + "<\/h3>" +
            "<p>"+"<?php _e('Please upload background image with aspect ratio', 'web-to-print-online-designer'); ?>"+": W<sub>p</sub>&timesH<sub>p</sub>.</p>" +
            "<p>" + "<?php _e('Make sure setting', 'web-to-print-online-designer'); ?>" + " <span style='font-weight: bold; background: #b8dce8;'>" + "<?php _e('Product size', 'web-to-print-online-designer'); ?>" + "</span> " + "<?php _e('must always be the top priority!', 'web-to-print-online-designer'); ?>" + "</p>" +
            "<p>" + "<?php _e('You have two order setting options', 'web-to-print-online-designer'); ?>" +
            ": <br /><strong>1</strong> - <span style='font-weight: bold; background: #b8dce8;'>" + "<?php _e('Product size', 'web-to-print-online-designer'); ?>" + "</span> →"+
            " <span style='font-weight: bold; background: #dddacd;'>" + "<?php _e('Design area size', 'web-to-print-online-designer'); ?>" + "</span> "+
            " (<span style='font-weight: bold; background: #f0c6f6;'>" + "<?php _e('Relative position', 'web-to-print-online-designer'); ?>" + "</span> "+"<?php _e('will automatic update', 'web-to-print-online-designer'); ?>"+")" +
            "<br /><strong>2</strong> - <span style='font-weight: bold; background: #b8dce8;'>" + "<?php _e('Product size', 'web-to-print-online-designer'); ?>" + "</span> →"+
            " <span style='font-weight: bold; background: #f0c6f6;'>" + "<?php _e('Relative position', 'web-to-print-online-designer'); ?>" + "</span> → "+
            "<?php _e('click', 'web-to-print-online-designer'); ?>" + "<span class='dashicons dashicons-update'></span> "+"<?php _e('to update', 'web-to-print-online-designer'); ?>"+" <span style='font-weight: bold; background: #f0c6f6;'>" + "<?php _e('Design area size', 'web-to-print-online-designer'); ?>" + "</span>"+
            "</p>",
            "position": {"edge":direction, "align":"center"}
        };
        $('.nbdesign-config-size-tooltip').first().pointer( size_options );
        $('.nbdesign-config-size-tooltip').first().on('click', function(){
            $(this).pointer("open")
        });
        var da_option = {
            "content" : "<h3>" + "<?php _e('Notice', 'web-to-print-online-designer'); ?>" + "<\/h3>" +
            "<p>"+"<?php _e('After change bellow', 'web-to-print-online-designer'); ?>"+" <span style='background: #dddacd; font-weight: bold;'>"+"<?php _e('values', 'web-to-print-online-designer'); ?>"+"</span>, "+"<span style='background: #f0c6f6; font-weight: bold;'>"+"<?php _e('relative position', 'web-to-print-online-designer'); ?>"+"</span> "+"<?php _e('of design area in bounding box will automatic update.', 'web-to-print-online-designer'); ?>"+"</p>" +
            "<p>" + "<?php _e('Notice', 'web-to-print-online-designer'); ?>" + ": W<sub>p</sub> &gt;= W<sub>d</sub> + L<sub>d</sub>" +
            " | H<sub>p</sub> &gt;= H<sub>d</sub> + T<sub>d</sub>" +
            "<br />"+"<?php _e('If color labels change to ', 'web-to-print-online-designer'); ?>"+"<span style='color: red'>"+"<?php _e('red', 'web-to-print-online-designer'); ?>"+"</span>, "+"<?php _e('check values again.', 'web-to-print-online-designer'); ?>"+"</p>" +
            "<p>"+"<?php _e('There', 'web-to-print-online-designer'); ?>"+" <span style='background: #dddacd; font-weight: bold;'>"+"<?php _e('values', 'web-to-print-online-designer'); ?>"+"</span> "+"<?php _e('will decide dimensions of output images.', 'web-to-print-online-designer'); ?>"+"</p>" +
            "<p>"+"<?php _e('If you modify', 'web-to-print-online-designer'); ?>"+" <span style='background: #f0c6f6; font-weight: bold;'>"+"<?php _e('relative position', 'web-to-print-online-designer'); ?>"+"</span>, "+"<?php _e('click button', 'web-to-print-online-designer'); ?>"+" <span class='dashicons dashicons-update'></span> "+"<?php _e('to update', 'web-to-print-online-designer'); ?>"+"<span style='background: #dddacd; font-weight: bold;'> "+"<?php _e('Design area.', 'web-to-print-online-designer'); ?>"+"</span>"+"</p>" ,
            "position": {"edge":direction, "align":"center"}
        };
        $('.nbdesign-config-realsize-tooltip').first().pointer( da_option );
        $('.nbdesign-config-realsize-tooltip').first().on('click', function(){
            $(this).pointer("open")
        });

        // Option color
        $('input[name="_nbdesigner_option[color][show]"]').on('change', function () {
            if ($(this).val() == '1') {
                $('.nbdesigner-option-color-type').show();
            }else {
                $('.nbdesigner-option-color-type').hide();
            }
        });

        $('.nbdesigner-option-color-setting-select').wpColorPicker({});
        $('.nbdesigner-color-setting-add-image').unbind('click').on('click', function (e) {
            var slugDesigner = $(this).attr('data-designer');
            addImage($(this), e, slugDesigner);
        });

        $('input[name="_nbdesigner_option[color][type]"]').on('change', function () {
            if ($(this).val() == 'setting') {
                $('.nbdesigner-option-color-type-setting').show();
                $('.nbdesigner-option-color-type-swatch').hide();
            }else {
                $('.nbdesigner-option-color-type-setting').hide();
                $('.nbdesigner-option-color-type-swatch').show();
            }
        });
        $('#nbdesigner-add-color-setting').on('click', function (e) {
            e.preventDefault();
            var designers = <?php echo json_encode($designer_setting);?>;
            var $trItem = $('<tr></tr>');
            var $tdAction = $('<td></td>');
            var $tdName = $('<td></td>');

            itemName = '<input type="text" name="_nbdesigner_option[color][setting][name][]" value="" placeholder="name">';
            itemAction = '<a href="#" class="nbdesigner-remove-color-setting">×</a>';
            $itemAction = $(itemAction);
            $tdName.append(itemName);
            $trItem.append($tdName);
            $.each(designers, function (i, val) {
                var $tmpTable = $('<table><tbody><tr></tr></tbody></table>');
                var $tdItemColor = $('<td></td>');
                var $tdItemImage = $('<td></td>');
                var $tdDesigner = $('<td></td>');

                var itemColor = '<input type="text" name="_nbdesigner_option[color][setting]['+ val.slug_nbdesigner +'][hex][]" value="" class="nbdesigner-option-color-setting-select" />';
                var itemImage = '<a class="button nbdesigner-button nbdesigner-color-setting-add-image" data-designer="'+ val.slug_nbdesigner +'">Add image</a>' +
                    '<input type="hidden" name="_nbdesigner_option[color][setting]['+ val.slug_nbdesigner +'][image_id][]" value="0">';
                var $itemColor = $(itemColor);
                var $itemImage = $(itemImage);
                $tdItemColor.append($itemColor);
                $tdItemImage.append($itemImage);
                $tmpTable.append($tdItemColor);
                $tmpTable.append($tdItemImage);
                $tdDesigner.append($tmpTable);
                $trItem.append($tdDesigner);

                $itemColor.wpColorPicker({});
                $itemImage.unbind('click').on('click', function (e) {
                    addImage($(this), e, val.slug_nbdesigner);
                });
            });

            $tdAction.append($itemAction);
            $trItem.append($tdAction);
            $('.nbdesigner-option-color-setting > tbody').append($trItem);

            $itemAction.on('click', function () {
                $(this).closest('tr').remove();
                return false;
            });
            return false;
        });

        $('.nbdesigner-remove-color-setting').on('click', function () {
            $(this).closest('tr').remove();
            return false;
        });
        function addImage(eClick, e, slugDesigner) {
            var $td = eClick.closest('td');
            var sefl = eClick, itemImage = '';
            var image = null;
            var upload;
            if (upload) {
                upload.open();
                return;
            }
            var index = $(e).data('index'),

                upload = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image',
                    },
                    multiple: false
                });
            upload.on('select', function () {
                image = upload.state().get('selection').first().toJSON();
                $td.empty();
                itemImage = '<img src="' + image.url + '" width="30px" alt="Product" class="nbdesigner-color-setting-add-image">' +
                    '<input type="hidden" name="_nbdesigner_option[color][setting]['+ slugDesigner +'][image_id][]" value="'+ image.id +'">';
                var $itemImage = $(itemImage);
                $td.append($itemImage);
                sefl.remove();
                $itemImage.on('click', function (e) {
                    addImage($(this), e, slugDesigner);
                });
            });
            upload.open();
        }
        function addImageSwatch(eClick, e, attr, slug, slugDesigner) {
            var $td = eClick.closest('td');
            var sefl = eClick, itemImage = '';
            var image = null;
            var upload;
            if (upload) {
                upload.open();
                return;
            }
            var index = $(e).data('index'),

                upload = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image',
                    },
                    multiple: false
                });
            upload.on('select', function () {
                image = upload.state().get('selection').first().toJSON();
                $td.empty();
                itemImage = '<img src="' + image.url + '" width="30px" alt="Product" class="nbdesigner-color-add-image" data-slug="'+ slug +'">' +
                    '<input type="hidden" name="_nbdesigner_option[color][swatch]['+ attr +'][' + slug + ']['+ slugDesigner +'][image_id]" value="'+ image.id +'">';
                var $itemImage = $(itemImage);
                $td.append($itemImage);
                sefl.remove();
                $itemImage.on('click', function (e) {
                    addImageSwatch($(this), e, attr, slug, slugDesigner);
                });

            });
            upload.open();
        }
        // dropdown color swatch
        $('.nbdesigner-color-swatch-attribute').on('change', function () {
            var $table = $('.nbdesigner-option-color-swatch');
            var select = $(this).val();
            var tbody = '<tbody class="'+ select +'"></tbody>';
            if (select == '') {
                $table.hide();
                return;
            }else {
                $table.show();
            }
            $tbody = $(tbody);
            if ($table.find('> tbody').hasClass(select)) {
                $table.find('> tbody').hide();
                var $attSelect = $table.find('> tbody.' + select);
                $attSelect.show();
                $attSelect.find('.nbdesigner-color-add-image').each(function (i) {
                    $(this).unbind('click').on('click', function (e) {
                        var slug = $(this).attr('data-slug');
                        var slugDesigner = $(this).attr('data-designer');
                        addImageSwatch($(this), e, select, slug, slugDesigner);
                    });
                });
                $('.nbdesigner-option-color-select').wpColorPicker({});
            }

        });

        // Option size
        $('input[name="_nbdesigner_option[size][show]"]').on('change', function () {
            if ($(this).val() == '1') {
                $('.nbdesigner-option-size-type').show();
            } else {
                $('.nbdesigner-option-size-type').hide();
            }
        });

        $('input[name="_nbdesigner_option[size][type]"]').on('change', function () {
            if ($(this).val() == 'setting') {
                $('.nbdesigner-option-size-type-setting').show();
                $('.nbdesigner-option-size-type-swatch').hide();
            }else {
                $('.nbdesigner-option-size-type-setting').hide();
                $('.nbdesigner-option-size-type-swatch').show();
            }
        });

        $('.nbdesigner-remove-size-setting').on('click', function () {
            $(this).closest('tr').remove();
            return false;
        });

        $('#nbdesigner-add-size-setting').on('click', function (e) {

            var designers = <?php echo json_encode($designer_setting);?>;

            var item = '<tr></tr>';
            var $item = $(item);
            var itemName = '<td><input type="text" name="_nbdesigner_option[size][setting][name][]" style="max-width: 120px" value="" placeholder="name"></td>';
            var itemAction = '<td><a href="#" class="nbdesigner-remove-size-setting">×</a></td>';
            $item.append(itemName);
            $.each(designers, function (i, val) {
                var tmpWidthPro = '<input type="hidden" name="_nbdesigner_option[size][setting][' + val.slug_nbdesigner + '][width_pro][]" value=""/>';
                var tmpHeightPro = '<input type="hidden" name="_nbdesigner_option[size][setting][' + val.slug_nbdesigner + '][width_pro][]" value=""/>';
                var tmpTrD1 = '<tr>' +
                        '<td>' +
                            '<div class="nbdesigner-td-option-size">' +
                                '<span>width</span>' +
                                '<input type="number" min="0" name="_nbdesigner_option[size][setting]['+ val.slug_nbdesigner +'][width_d][]" value=""/>' +
                            '</div>' +
                        '</td>' +
                        '<td>' +
                            '<div class="nbdesigner-td-option-size">' +
                                '<span>height</span>' +
                                '<input type="number" min="0" name="_nbdesigner_option[size][setting]['+ val.slug_nbdesigner +'][height_d][]" value=""/>' +
                            '</div>' +
                        '</td>' +
                    '</tr>';
                var tmptrD2 = '<tr>' +
                        '<td>' +
                            '<div class="nbdesigner-td-option-size">' +
                                '<span>Top</span>' +
                                '<input type="number" min="0" name="_nbdesigner_option[size][setting]['+ val.slug_nbdesigner +'][top_d][]" value=""/>' +
                            '</div>' +
                        '</td>' +
                        '<td>' +
                            '<div class="nbdesigner-td-option-size">' +
                                '<span>Left</span>' +
                                '<input type="number" min="0" name="_nbdesigner_option[size][setting]['+ val.slug_nbdesigner +'][left_d][]" value=""/>' +
                            '</div>' +
                        '</td>' +
                    '</tr>';

                var tmpSize = '<td>' +
                        '<table>' +
                            '<tbody>' + tmpWidthPro + tmpHeightPro + tmpTrD1 + tmptrD2 + '</tbody>' +
                        '</table>' +
                    '</td>';
                $item.append(tmpSize);
            });

            $item.append(itemAction);
            $('.nbdesigner-option-size-setting > tbody').append($item);

            $('.nbdesigner-remove-size-setting').on('click', function () {
                $(this).closest('tr').remove();
                return false;
            });

            return false;
        });

        var $table = $('.nbdesigner-option-size-swatch');
        $('.nbdesigner-size-swatch-attribute').on('change', function () {
            var select = $(this).val();
            var tbody = '<tbody class="'+ select +'"></tbody>';
            if (select == '') {
                $table.hide();
                return;
            }else {
                $table.show();
            }
            $tbody = $(tbody);
            if ($('.nbdesigner-option-size-swatch > tbody').hasClass(select)) {
                $('.nbdesigner-option-size-swatch > tbody').hide();
                $('.nbdesigner-option-size-swatch').find('> tbody.' + select).show();
            }
        });
    });
</script>