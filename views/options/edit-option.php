<?php if (!defined('ABSPATH')) exit; ?>
<?php
    $link = add_query_arg(array(
            'paged'    => $_GET['paged'],
            '_wpnonce'    => $_GET['_wpnonce']
        ), admin_url('admin.php?page=nbd_printing_options')); 
    $link_update = add_query_arg(array(
            'action' => 'update',
            'id'  =>  $options['id'],
        ), admin_url('admin.php?page=nbd_printing_options')); 
    $link_delete = add_query_arg(array(
            'action' => 'delete'
        ), $link);  
    wp_enqueue_media();
?>
<script type="text/javascript">
    var NBDOPTIONS = <?php echo json_encode($options); ?>;
</script>
<div class="wrap">
    <h2>
        <?php _e('Edit Global Options', 'web-to-print-online-designer'); ?>
    </h2>
</div>    
<div class="message">
    <?php if( $message['content'] != '' ){
        $message = nbd_custom_notices($message['flag'], $message['content']);
        echo $message;
    } ?>
</div>
<div class="wrap" ng-app="optionApp" ng-cloak>
    <div ng-controller="optionCtrl">
        <form name="post" action="" method="post" id="post">
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">
                        <div id="titlediv">
                            <div id="titlewrap">
                                <label class="screen-reader-text" id="title-prompt-text" for="title">Enter title here</label>
                                <input type="text" name="post_title" size="30" value="<?php echo $options['title']; ?>" id="title" autocomplete="off">
                            </div>
                        </div>
                    </div>  
                    <div id="postbox-container-1" class="postbox-container">
                        <div id="submitdiv" class="postbox ">
                            <h2 class="hndle ui-sortable-handle"><span><?php _e('Publish', 'web-to-print-online-designer'); ?></span></h2>
                            <div class="inside">
                                <div class="submitbox" id="submitpost">
                                    <div id="minor-publishing">
                                        <div id="misc-publishing-actions">
                                            <div class="misc-pub-section misc-pub-priority" id="priority">
                                                <?php _e('Priority', 'web-to-print-online-designer'); ?>
                                                <input type="number" value="<?php echo $options['priority']; ?>" maxlength="3"
                                                       id="tm_meta_priority" name="option[priority]" class="meta-priority" min="1"
                                                       step="1"/>                                    
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>   
                                    <div id="major-publishing-actions">
                                        <div id="delete-action">
                                            <a class="submitdelete deletion"
                                               href="<?php echo $link_delete; ?>"><?php _e('Move to Trash', 'web-to-print-online-designer'); ?></a>                                 
                                        </div>   
                                        <div id="publishing-action">
                                            <input name="save" type="submit" class="button button-primary button-large" id="publish"
                                                accesskey="p" value="<?php esc_attr_e( 'Update' ) ?>"/>                                        
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                    </div>
                    <div id="postbox-container-2" class="postbox-container">
                        <div class="postbox">
                            <div class="inside">
                                <div class="nbd-option-actions">
                                    <a class="button-primary"><span class="dashicons dashicons-plus"></span> <?php _e('Add section', 'web-to-print-online-designer'); ?></a>
                                    <span class="nbdesigner-right">
                                        <a class="button-primary"><span class="dashicons dashicons-migrate nbd-r180"></span> <?php _e('Import CSV', 'web-to-print-online-designer'); ?></a>
                                        <a class="button-primary"><span class="dashicons dashicons-migrate"></span> <?php _e('Export CSV', 'web-to-print-online-designer'); ?></a>
                                    </span>
                                </div> 
                            </div>    
                        </div>                    
                        <div class="postbox nbd-fields-wrap"> 
                            <h2><?php _e('Printing fields', 'web-to-print-online-designer'); ?></h2>
                            <div class="inside">
                                <div class="nbd-fields-picker">
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-editor-textcolor"></span> <?php _e('Text box', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-marker"></span> <?php _e('Radio', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-yes"></span> <?php _e('Check box', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-menu"></span></span> <?php _e('Dropdown', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-admin-settings"></span> <?php _e('Ranger slider', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-art"></span> <?php _e('Color swatch', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-grid-view"></span> <?php _e('Price matrix', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-calendar-alt"></span></span> <?php _e('Date time', 'web-to-print-online-designer'); ?></a>
                                </div> 
                            </div>    
                        </div>
                        <div class="postbox"> 
                            <h2><?php _e('Printing options buider', 'web-to-print-online-designer'); ?></h2>
                            <div class="inside">
                                <div class="nbd-fields-builder">
                                    <div class="section-container">
                                        <p class="section-title"><input class="nbd-ip-readonly" value="<?php _e('Quantity', 'web-to-print-online-designer'); ?>" readonly=""></p>
                                        <div class="nbd-section-wrap">
                                            <div class="nbd-field-info">
                                                <div class="nbd-field-info-1">
                                                    <label><b><?php _e('Replace default quantity input', 'web-to-print-online-designer'); ?></b></label>
                                                </div>  
                                                <div class="nbd-field-info-2">
                                                    <select name="options[quantity_enable]" ng-model="options.quantity_enable">
                                                        <option value="y"><?php _e('Yes', 'web-to-print-online-designer'); ?></option>
                                                        <option value="n"><?php _e('No', 'web-to-print-online-designer'); ?></option>
                                                    </select>
                                                </div>                                                    
                                            </div>      
                                            <div class="nbd-field-info" ng-show="options.quantity_enable == 'y'">
                                                <div class="nbd-field-info-1">
                                                    <label><b><?php _e('Display type', 'web-to-print-online-designer'); ?></b></label>
                                                </div>  
                                                <div class="nbd-field-info-2">
                                                    <select name="options[quantity_type]" ng-model="options.quantity_type">
                                                        <option value="i"><?php _e('Input', 'web-to-print-online-designer'); ?></option>
                                                        <option value="r"><?php _e('Ranger slider', 'web-to-print-online-designer'); ?></option>
                                                        <option value="s"><?php _e('Select box', 'web-to-print-online-designer'); ?></option>
                                                    </select>
                                                </div>      
                                            </div>   
                                            <div class="nbd-field-info" ng-show="options.quantity_type == 'r' && options.quantity_enable == 'y'">
                                                <div class="nbd-field-info-1">
                                                    <p><label><b><?php _e('Step value', 'web-to-print-online-designer'); ?></b><span class="woocommerce-help-tip" data-tip="<?php _e('Enter the step for the handle.', 'web-to-print-online-designer'); ?>" ></span></label></p>                                              
                                                </div>  
                                                <div class="nbd-field-info-2">
                                                    <div class="nbd-table-wrap" style="overflow: hidden;">
                                                        <table class="nbd-table">
                                                            <tr>
                                                                <th><?php _e('Min', 'web-to-print-online-designer'); ?></th>
                                                                <th><?php _e('Max', 'web-to-print-online-designer'); ?></th>
                                                                <th><?php _e('Step', 'web-to-print-online-designer'); ?></th>
                                                            </tr>   
                                                            <tr>
                                                                <td><input type="number" class="nbd-short-ip" ng-model="options.quantity_min" ng-min="1"/></td>
                                                                <td><input type="number" class="nbd-short-ip" ng-model="options.quantity_max" ng-min="1"/></td>
                                                                <td><input type="number" class="nbd-short-ip" ng-model="options.quantity_step" ng-min="1"/></td>
                                                            </tr>
                                                        </table>
                                                    </div>    
                                                </div>      
                                            </div>                                              
                                            <div class="nbd-field-info">
                                                <div class="nbd-field-info-1">
                                                    <label><b><?php _e('Discount type base on quantity breaks', 'web-to-print-online-designer'); ?></b></label>
                                                </div>  
                                                <div class="nbd-field-info-2">
                                                    <select name="options[quantity_discount_type]" ng-model="options.quantity_discount_type">
                                                        <option value="f"><?php _e('Fixed', 'web-to-print-online-designer'); ?></option>
                                                        <option value="p"><?php _e('Percentage', 'web-to-print-online-designer'); ?></option>
                                                    </select>
                                                </div>      
                                            </div>                                                                                       
                                            <div class="nbd-field-info">
                                                <div class="nbd-field-info-1">
                                                    <label><b><?php _e('Quantity breaks', 'web-to-print-online-designer'); ?></b></label>
                                                </div>  
                                                <div class="nbd-field-info-2">
                                                    <div class="nbd-table-wrap" style="overflow: hidden;">
                                                        <table class="nbd-table">
                                                            <tr>
                                                                <th><?php _e('Break', 'web-to-print-online-designer'); ?></th>
                                                                <th><?php _e('Discount', 'web-to-print-online-designer'); ?> ( {{options.quantity_discount_type == 'f' ? '-' : '-%'}} / <?php _e('item', 'web-to-print-online-designer'); ?>)</th>
                                                                <th><?php _e('Action', 'web-to-print-online-designer'); ?></th>
                                                            </tr>
                                                            <tr ng-repeat="break in options.quantity_breaks">
                                                                <td><input type="number" class="nbd-short-ip" ng-model="break.val" ng-min="1"/></td>
                                                                <td><input class="nbd-short-ip" type="number" ng-model="break.dis"/></td>
                                                                <td><a class="button nbd-mini-btn"  ng-click="remove_price_break($index)" title="<?php _e('Delete', 'web-to-print-online-designer'); ?>"><span class="dashicons dashicons-no-alt"></span></a></td>
                                                            </tr>
                                                        </table>
                                                    </div>   
                                                    <div style="margin-top: 5px;">
                                                        <a class="button" ng-click="add_price_break()"><span class="dashicons dashicons-plus"></span> <?php _e('Add more', 'web-to-print-online-designer'); ?></a>
                                                    </div>                                                    
                                                </div>      
                                            </div>   
                                        </div>      
                                    </div>
                                    <div class="section-container">
                                        <p class="section-title"><input class="nbd-ip-readonly" value="<?php _e('Sides/Pages', 'web-to-print-online-designer'); ?>" readonly=""></p>
                                        <div class="nbd-section-wrap">
                                            <div class="nbd-field-info"> 
                                                <div class="nbd-field-info-1">
                                                    <label><b><?php _e('Enabled', 'web-to-print-online-designer'); ?></b> <span class="woocommerce-help-tip" data-tip="<?php _e('Choose whether the option is enabled or not.', 'web-to-print-online-designer'); ?>" ></span></label>
                                                </div>  
                                                <div class="nbd-field-info-2">
                                                    <select name="options[side][enable]" ng-model="options.side.enable">
                                                        <option value="y"><?php _e('Yes', 'web-to-print-online-designer'); ?></option>
                                                        <option value="n"><?php _e('No', 'web-to-print-online-designer'); ?></option>
                                                    </select>
                                                </div>                                                    
                                            </div>
                                            <div class="nbd-field-wrap" ng-show="options.side.enable == 'y'" style="margin-bottom: 0;">
                                                <div class="nbd-nav">
                                                    <div>
                                                        <ul>
                                                            <li class="nbd-field-tab active" data-target="tab-general"><?php _e('General', 'web-to-print-online-designer') ?></li>
                                                            <li class="nbd-field-tab" data-target="tab-opdesign"><?php _e('Design setting', 'web-to-print-online-designer') ?></li>
                                                            <li class="nbd-field-tab" data-target="tab-appearance"><?php _e('Appearance', 'web-to-print-online-designer') ?></li>
                                                        </ul>                                                    
                                                    </div>  
                                                    <div class="clear"></div>                                                    
                                                </div>
                                                <div>
                                                    <div class="tab-general nbd-field-content active">
                                                        <div class="nbd-field-info">
                                                            <div class="nbd-field-info-1">
                                                                <label>
                                                                    <b><?php _e('Price type', 'web-to-print-online-designer'); ?></b>
                                                                    <span class="woocommerce-help-tip" data-tip="<?php _e('1- Fixed amount: This is an flat increase or decrease added to the product price. 2- Percent of the original price: This is a percentage increase or decrease of the initial product price. 3- Percent of the original price + options: This is a percentage increase or decrease of the initial product price plus all of the other options that are not of this type. 4- Current value * price: This will multiply field value by the Price you set.', 'web-to-print-online-designer'); ?>" ></span>
                                                                </label>
                                                            </div>  
                                                            <div class="nbd-field-info-2">
                                                                <select name="options[price_type]" ng-model="options.side.price_type">
                                                                    <option value="f"><?php _e('Fixed amount ', 'web-to-print-online-designer'); ?></option>
                                                                    <option value="p"><?php _e('Percent of the original price', 'web-to-print-online-designer'); ?></option>
                                                                    <option value="p+"><?php _e('Percent of the original price + options', 'web-to-print-online-designer'); ?></option>
                                                                    <option value="c"><?php _e('Current value * price', 'web-to-print-online-designer'); ?></option>
                                                                </select>
                                                            </div>      
                                                        </div>
                                                        <div class="nbd-field-info"> 
                                                            <div class="nbd-field-info-1">
                                                                <label><b><?php _e('Depend quantity breaks', 'web-to-print-online-designer'); ?></b></label>
                                                            </div>  
                                                            <div class="nbd-field-info-2">
                                                                <select name="options[side][depend_quantity]" ng-model="options.side.depend_quantity">
                                                                    <option value="y"><?php _e('Yes', 'web-to-print-online-designer'); ?></option>
                                                                    <option value="n"><?php _e('No', 'web-to-print-online-designer'); ?></option>
                                                                </select>
                                                            </div> 
                                                        </div>                                              
                                                        <div class="nbd-field-info"> 
                                                            <div class="nbd-field-info-1">
                                                                <label><b><?php _e('Dynamic number of sides / pages', 'web-to-print-online-designer'); ?></b></label>
                                                            </div>  
                                                            <div class="nbd-field-info-2">
                                                                <select name="options[side][dynamic]" ng-model="options.side.dynamic">
                                                                    <option value="y"><?php _e('Yes', 'web-to-print-online-designer'); ?></option>
                                                                    <option value="n"><?php _e('No', 'web-to-print-online-designer'); ?></option>
                                                                </select>
                                                            </div>
                                                        </div>      
                                                        <div class="nbd-field-info"> 
                                                            <div class="nbd-field-info-1">
                                                                <label><b><?php _e('Number of sides / pages', 'web-to-print-online-designer'); ?></b></label>
                                                            </div>  
                                                            <div class="nbd-field-info-2">
                                                                <div class="nbd-table-wrap" style="overflow: hidden;">
                                                                    <div class="nbd-table-wrap">
                                                                        <table class="nbd-table">
                                                                            <tr ng-show="options.quantity_breaks.length > 1 && options.side.depend_quantity == 'y'">
                                                                                <th></th>
                                                                                <th></th>
                                                                                <th ng-repeat="break in options.quantity_breaks">{{break.val}}</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th><?php _e('Actions', 'web-to-print-online-designer'); ?></th>
                                                                                <th><?php _e('Side name', 'web-to-print-online-designer'); ?></th>
                                                                                <th ng-repeat="break in options.quantity_breaks" ng-hide="options.side.depend_quantity != 'y' && $index > 0"><?php _e('Price', 'web-to-print-online-designer'); ?></th>
                                                                            </tr>                                                                
                                                                            <tr ng-repeat="op in options.side.options">
                                                                                <td>
                                                                                    <div style="display: flex;">
                                                                                        <a style="margin-right: 3px;" class="button nbd-mini-btn"  title="<?php _e('Delete', 'web-to-print-online-designer'); ?>"><span class="dashicons dashicons-no-alt"></span></a>
                                                                                    </div>    
                                                                                </td>
                                                                                <td>
                                                                                    <input class="nbd-medium-ip" type="text" ng-model="op.name"/>
                                                                                </td>
                                                                                <td ng-repeat="break in options.quantity_breaks" ng-hide="options.side.depend_quantity != 'y' && $index > 0">
                                                                                    <input class="nbd-short-ip" type="number" ng-model="op.price[$index]"/>
                                                                                </td>                                                                            
                                                                            </tr>
                                                                        </table>
                                                                    </div>     
                                                                </div>
                                                                <div style="margin-top: 5px;"><a class="button" title="<?php _e('Add more', 'web-to-print-online-designer'); ?>"><span class="dashicons dashicons-plus"></span> <?php _e('Add more', 'web-to-print-online-designer'); ?></a></div>
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                    <div class="tab-opdesign nbd-field-content">
                                                        opdesign
                                                    </div>
                                                    <div class="tab-appearance nbd-field-content">
                                                        appearance
                                                    </div>                                                
                                                </div>  
                                            </div>     
                                        </div>        
                                    </div>    
                                    <div class="nbd-field-wrap" ng-repeat="field in options.fields" ng-init="fieldIndex = $index">
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
                                            <div class="nbd-field-info" ng-repeat="(key, data) in field.general">
                                                <div class="nbd-field-info-1" ng-show="check_depend(field.general, data)">
                                                    <div><label><b>{{data.title}}</b> <span ng-if="data.description != ''" class="woocommerce-help-tip" data-tip="{{data.description}}" ></span></label></div>
                                                </div> 
                                                <div class="nbd-field-info-2" ng-show="check_depend(field.general, data)">
                                                    <div ng-if="data.type == 'text' || data.type == 'number'">
                                                        <input type="{{data.type == 'text' ? 'text' : 'number'}}" name="options[fields][{{fieldIndex}}][general][{{key}}]" ng-model="data.value">
                                                    </div>                                                  
                                                    <div ng-if="data.type == 'textarea'">
                                                        <textarea name="options[fields][{{fieldIndex}}][general][{{key}}]" ng-model="data.value"></textarea>
                                                    </div>
                                                    <div ng-if="data.type == 'radio'">
                                                        <div ng-repeat="op in data.options"><label><input type="radio" name="options[fields][{{fieldIndex}}][general][{{key}}]" ng-model="data.value" ng-value="op.key"> {{op.text}}</label></div>
                                                    </div> 
                                                    <div ng-if="data.type == 'dropdown'">
                                                        <select name="options[fields][{{fieldIndex}}][general][{{key}}]" ng-model="data.value">
                                                            <option ng-repeat="op in data.options" value="{{op.key}}">{{op.text}}</option>
                                                        </select>        
                                                    </div>    
                                                    <div ng-if="data.type == 'dropdown_group'">
                                                        <select name="options[fields][{{fieldIndex}}][general][{{key}}]" ng-model="data.value">
                                                            <optgroup ng-repeat="gr in data.options" label={{gr.title}}>
                                                                <option ng-repeat="op in gr.value" value="{{op.key}}">{{op.text}}</option>
                                                            </optgroup>
                                                        </select>        
                                                    </div>  
                                                    <div ng-if="data.type == 'single_quantity_depend'">
                                                        <div class="nbd-table-wrap">
                                                            <table class="nbd-table">
                                                                <tr>
                                                                    <th ng-repeat="break in options.quantity_breaks">{{break.val}}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td ng-repeat="break in options.quantity_breaks">
                                                                        <input class="nbd-short-ip" type="number" ng-model="data.value[$index]" name="options[fields][{{fieldIndex}}][general][{{key}}][]" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>     
                                                    </div>
                                                    <div ng-if="data.type == 'attributes'">
                                                        <div ng-repeat="op in field.general.attributes.options" class="nbd-attribute-wrap">
                                                            <div class="nbd-attribute-img-wrap">
                                                                <div><?php _e('Preview type', 'web-to-print-online-designer'); ?></div>
                                                                <div>
                                                                    <select ng-model="op.preview_type" style="width: inherit;" name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{$index}}][preview_type]">
                                                                        <option value="i"><?php _e('Image', 'web-to-print-online-designer'); ?></option>
                                                                        <option value="c"><?php _e('Color', 'web-to-print-online-designer'); ?></option>                                                                    
                                                                    </select>   
                                                                </div>
                                                                <div class="nbd-attribute-img-inner" ng-show="op.preview_type == 'i'">
                                                                    <span class="dashicons dashicons-no remove-attribute-img" ng-click="remove_attribute_image(fieldIndex, $index)"></span>
                                                                    <input type="hidden" ng-model="op.image" name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{$index}}][image]"/>
                                                                    <img ng-click="set_attribute_image(fieldIndex, $index)" ng-src="{{op.image ? op.image_url : '<?php echo NBDESIGNER_ASSETS_URL . 'images/placeholder.png' ?>'}}" />
                                                                </div>
                                                                <div class="nbd-attribute-color-inner" ng-show="op.preview_type == 'c'">
                                                                    <div class="nbd-attribute-color-pre" ng-style="{'background': op.color}"></div>
                                                                    <input type="text" name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{$index}}][color]" ng-model="op.color" class="nbd-color-picker" nbd-color-picker/>
                                                                </div>    
                                                            </div>    
                                                            <div class="nbd-attribute-content-wrap">
                                                                <div><?php _e('Title', 'web-to-print-online-designer'); ?></div>
                                                                <div class="nbd-attribute-name">
                                                                    <input type="text" value="{{op.name}}" ng-model="op.name" name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{$index}}][name]"/>
                                                                    <label><input type="checkbox" name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{$index}}][selected]" ng-checked="op.selected" ng-click="seleted_attribute(fieldIndex, key, $index)"/> <?php _e('Selected', 'web-to-print-online-designer'); ?></label>
                                                                </div>
                                                                <div class="nbd-margin-10"></div>
                                                                <div ng-show="field.general.depend_quantity.value != 'y'">
                                                                    <div><?php _e('Price', 'web-to-print-online-designer'); ?></div>
                                                                    <div>
                                                                        <input name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{$index}}][price][]" class="nbd-short-ip" type="number" ng-model="op.price[0]"/>
                                                                    </div>
                                                                </div>
                                                                <div class="nbd-table-wrap" ng-show="field.general.depend_quantity.value == 'y'" >
                                                                    <table class="nbd-table">
                                                                        <tr>
                                                                            <th><?php _e('Quantity', 'web-to-print-online-designer'); ?></th>
                                                                            <th ng-repeat="break in options.quantity_breaks">{{break.val}}</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php _e('Price', 'web-to-print-online-designer'); ?></td>
                                                                            <td ng-repeat="break in options.quantity_breaks">
                                                                                <input name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{$index}}][price][]" class="nbd-short-ip" type="number" ng-model="op.price[$index]"/>
                                                                            </td>
                                                                        </tr>                                                                        
                                                                    </table>
                                                                </div> 
                                                            </div> 
                                                            <div class="nbd-attribute-action"><a class="button nbd-mini-btn"  ng-click="remove_attribute(fieldIndex, key, $index)" title="<?php _e('Delete', 'web-to-print-online-designer'); ?>"><span class="dashicons dashicons-no-alt"></span> <?php _e('Delete', 'web-to-print-online-designer'); ?></a></div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div><a class="button" ng-click="add_attribute(fieldIndex, key)"><span class="dashicons dashicons-plus"></span> <?php _e('Add attribute', 'web-to-print-online-designer'); ?></a></div>
                                                    </div>                                                    
                                                </div>    
                                            </div>    
                                        </div>
                                        <div class="tab-conditional nbd-field-content">
                                            <div class="nbd-field-info">
                                                <div class="nbd-field-info-1">
                                                    <div><b><?php _e('Field Conditional Logic', 'web-to-print-online-designer'); ?></b> <?php echo wc_help_tip( __('Enable conditional logic for showing or hiding this field.', 'web-to-print-online-designer'), true ); ?></div>
                                                </div>  
                                                <div class="nbd-field-info-2">
                                                    <div>
                                                        <select ng-model="field.conditional.enable" style="width: 100px;" name="options[fields][{{fieldIndex}}][conditional][enable]">
                                                            <option value="n"><?php _e('No', 'web-to-print-online-designer'); ?></option>
                                                            <option value="y"><?php _e('Yes', 'web-to-print-online-designer'); ?></option>
                                                        </select>
                                                    </div>
                                                    <div style="margin-top: 10px;" ng-show="field.conditional.enable == 'y'">
                                                        <select ng-model="field.conditional.show" style="width: inherit;" name="options[fields][{{fieldIndex}}][conditional][show]">
                                                            <option value="y"><?php _e('Show', 'web-to-print-online-designer'); ?></option>
                                                            <option value="n"><?php _e('Hide', 'web-to-print-online-designer'); ?></option>
                                                        </select>
                                                        <?php _e('this field if', 'web-to-print-online-designer'); ?>
                                                        <select ng-model="field.conditional.logic" style="width: inherit;" name="options[fields][{{fieldIndex}}][conditional][logic]">
                                                            <option value="a"><?php _e('all', 'web-to-print-online-designer'); ?></option>
                                                            <option value="o"><?php _e('any', 'web-to-print-online-designer'); ?></option>
                                                        </select>  
                                                        <?php _e('of these rules match:', 'web-to-print-online-designer'); ?>
                                                    </div>
                                                    <div>
                                                        
                                                    </div>    
                                                </div>  
                                            </div>     
                                        </div>
                                        <div class="tab-appearance nbd-field-content">
                                            <div class="nbd-field-info" ng-repeat="(key, data) in field.appearance">
                                                <div class="nbd-field-info-1" ng-show="check_depend(field.appearance, data)">
                                                    <div><label><b>{{data.title}}</b> <span ng-if="data.description != ''" class="woocommerce-help-tip" data-tip="{{data.description}}" ></span></label></div>
                                                </div> 
                                                <div class="nbd-field-info-2" ng-show="check_depend(field.appearance, data)">
                                                    <div ng-if="data.type == 'dropdown'">
                                                        <select name="options[fields][{{fieldIndex}}][appearance][{{key}}]" ng-model="data.value">
                                                            <option ng-repeat="op in data.options" value="{{op.key}}">{{op.text}}</option>
                                                        </select>        
                                                    </div>    
                                                    <div ng-if="data.type == 'dropdown_group'">
                                                        <select name="options[fields][{{fieldIndex}}][appearance][{{key}}]" ng-model="data.value">
                                                            <optgroup ng-repeat="gr in data.options" label={{gr.title}}>
                                                                <option ng-repeat="op in gr.value" value="{{op.key}}">{{op.text}}</option>
                                                            </optgroup>
                                                        </select>        
                                                    </div>                                                      
                                                </div>
                                            </div>     
                                        </div>                                        
                                    </div>   
                                </div>
                            </div>    
                        </div>                    
                    </div>                
                </div>
            </div>
        </form> 
        <div class="debug" ng-click="debug()">
            <span class="dashicons dashicons-hammer"></span>
        </div>
        <div class="frontend-prview" ng-class="previewWide ? 'wide' : ''">
            <div class="frontend-prview-header">
                <?php _e('Frontend Preview', 'web-to-print-online-designer'); ?>
                <span class="nbdesigner-right" style="margin-top: -4px;">
                    <span class="dashicons dashicons-editor-expand" ng-show="!previewWide" ng-click="previewWide = !previewWide"></span>
                    <span class="dashicons dashicons-editor-contract" ng-show="previewWide" ng-click="previewWide = !previewWide"></span>
                    <span class="dashicons dashicons-arrow-up" ng-show="!showPreview" ng-click="showPreview = !showPreview"></span>
                    <span class="dashicons dashicons-arrow-down" ng-show="showPreview" ng-click="showPreview = !showPreview"></span>
                </span>
            </div>
            <div ng-show="showPreview" class="frontend-prview-content">
                <!-- show field -->
                <div class="nbd-quantity preview-wrap">
                    <div><b><?php _e('Quantity', 'web-to-print-online-designer'); ?></b></div>
                    <div ng-show="options.quantity_type == 'i'">
                        <input type="number" string-to-number name="nbd-quantity" ng-model="options.quantity_value"/>
                    </div>
                    <div ng-show="options.quantity_type == 'r'">
                        <input name="nbd-quantity" string-to-number type="range" min="{{options.quantity_min}}" max="{{options.quantity_max}}" step="{{options.quantity_step}}" ng-model="options.quantity_value">
                    </div>
                    <div ng-show="options.quantity_type == 's'">
                        <span ng-repeat="break in options.quantity_breaks" class="nbd-quantity-r">
                            <input id="nbd-quantity_{{$index}}" name="nbd-quantity-r" type="radio" ng-model="options.quantity_value" value="{{break.val}}"/>
                            <label for="nbd-quantity_{{$index}}">{{break.val}}</label>
                        </span>
                    </div>
                </div>
            </div>
        </div>        
    </div>    
</div>