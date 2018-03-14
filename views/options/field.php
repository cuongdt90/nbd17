<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-field-wrap">
    <div class="nbd-nav">
        <div>
            <ul>
                <li class="nbd-field-tab active" data-target="tab-general"><?php _e('General', 'web-to-print-online-designer') ?></li>
                <li class="nbd-field-tab" data-target="tab-conditional"><?php _e('Conditinal', 'web-to-print-online-designer') ?></li>
                <li class="nbd-field-tab" data-target="tab-appearance"><?php _e('Appearance', 'web-to-print-online-designer') ?></li>
            </ul>
            <span class="nbdesigner-right field-action">
                <a class="nbd-field-btn button" title="<?php _e('Delete', 'web-to-print-online-designer'); ?>"><span class="dashicons dashicons-trash"></span> <?php _e('Delete', 'web-to-print-online-designer'); ?></a>
                <a class="nbd-field-btn button" title="<?php _e('Copy', 'web-to-print-online-designer'); ?>"><span class="dashicons dashicons-admin-page"></span> <?php _e('Copy', 'web-to-print-online-designer'); ?></a>
                <a class="nbd-field-btn button" title="<?php _e('Expand', 'web-to-print-online-designer'); ?>"><span class="dashicons dashicons-image-flip-vertical"></span> <?php _e('Expand', 'web-to-print-online-designer'); ?></a>
            </span>
        </div>  
        <div class="clear"></div>
    </div>
    <div class="tab-general nbd-field-content active">
        <?php $this->render_tab_content($field, $section_key, $field_key, 'general'); ?>
    </div>
    <div class="tab-conditional nbd-field-content">  
        <div class="nbd-field-info">
            <div class="nbd-field-info-1">
                <label><?php _e('Conditional', 'web-to-print-online-designer'); ?></label>
            </div> 
            <div class="nbd-field-info-2">
                <select>
                    <option selected value="n"><?php _e('No', 'web-to-print-online-designer'); ?></option>
                    <option value="y"><?php _e('Yes', 'web-to-print-online-designer'); ?></option>
                </select>
            </div>
        </div>
        <div class="nbd-field-info">
            <select>
                <option selected value="s"><?php _e('Show', 'web-to-print-online-designer'); ?></option>
                <option value="h"><?php _e('Hide', 'web-to-print-online-designer'); ?></option>
            </select> 
            <?php _e('this field if', 'web-to-print-online-designer'); ?>
            <select>
                <option selected value="al"><?php _e('All', 'web-to-print-online-designer'); ?></option>
                <option value="an"><?php _e('Any', 'web-to-print-online-designer'); ?></option>
            </select> 
            <?php _e('of these rules match:', 'web-to-print-online-designer'); ?>            
        </div>
    </div>    
    <div class="tab-appearance nbd-field-content">
        Appearance
    </div>       
</div>