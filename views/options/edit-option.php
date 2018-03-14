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
                                            <div class="nbd-field-info" ng-show="options.quantity_type == 'r'">
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
                                                    <label><b><?php _e('Discount type base on breaks', 'web-to-print-online-designer'); ?></b></label>
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
                                                    <label><b><?php _e('Breaks', 'web-to-print-online-designer'); ?></b></label>
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
                                    <div class="section-container" ng-repeat="section in options.fields" ng-init="sectionIndex = $index">
                                        <p class="section-title"><input name="options[fields][{{$index}}][title]" ng-model="section.title"/></p>
                                        <div class="nbd-section-wrap">
                                            <div><a class="button" ng-click="prepend_field()"><span class="dashicons dashicons-plus"></span> <?php _e('Add field', 'web-to-print-online-designer'); ?></a></div>
                                            <div class="nbd-field-wrap" ng-repeat="field in section.fields" ng-init="fieldIndex = $index">
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
                                                    <div class="nbd-field-info" ng-class="data.class" ng-repeat="data in field.general">
                                                        <div class="nbd-field-info-1" ng-show="check_depend(field.general, data)">
                                                            <p><label><b>{{data.title}}</b> <span ng-if="data.description != ''" class="woocommerce-help-tip" data-tip="{{data.description}}" ></span></label></p>
                                                        </div>      
                                                        <div class="nbd-field-info-2" ng-show="check_depend(field.general, data)">
                                                            <div ng-if="data.type == 'text' || data.type == 'number'">
                                                                <input type="{{data.type == 'text' ? 'text' : 'number'}}" name="options[fields][{{sectionIndex}}][fields][{{fieldIndex}}][general][{{data.field}}]" ng-model="data.value" ng-style="data.css">
                                                            </div>  
                                                            <div ng-if="data.type == 'textarea'">
                                                                <textarea name="options[fields][{{sectionIndex}}][fields][{{fieldIndex}}][general][{{data.field}}]" ng-model="data.value" ng-style="data.css"></textarea>
                                                            </div>
                                                            <div ng-if="data.type == 'radio'">
                                                                <p ng-repeat="op in data.options"><label><input type="radio" name="options[fields][{{sectionIndex}}][fields][{{fieldIndex}}][general][{{data.field}}]" ng-model="data.value" ng-value="op.key"> {{op.text}}</label></p>
                                                            </div>     
                                                            <div ng-if="data.type == 'dropdown'">
                                                                <select name="options[fields][{{sectionIndex}}][fields][{{fieldIndex}}][general][{{data.field}}]" ng-model="data.value">
                                                                    <option ng-repeat="op in data.options" value="{{op.key}}">{{op.text}}</option>
                                                                </select>        
                                                            </div>    
                                                            <div ng-if="data.type == 'dropdown_group'">
                                                                <select name="options[fields][{{sectionIndex}}][fields][{{fieldIndex}}][general][{{data.field}}]" ng-model="data.value">
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
                                                                                <input class="nbd-short-ip" type="number" ng-model="data.value[$index]"/>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>     
                                                            </div>    
                                                            <div ng-if="data.type == 'attributes'">
                                                                <div class="nbd-table-wrap">
                                                                    <table class="nbd-table">
                                                                        <tr ng-show="options.quantity_breaks.length > 1">
                                                                            <th></th>
                                                                            <th ng-repeat="break in options.quantity_breaks">{{break.val}}</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><?php _e('Atribute name', 'web-to-print-online-designer'); ?></th>
                                                                            <th ng-repeat="break in options.quantity_breaks"><?php _e('Price', 'web-to-print-online-designer'); ?></th>
                                                                        </tr>                                                                        
                                                                        <tr ng-repeat="op in data.options">
                                                                            <td>
                                                                                <input class="nbd-medium-ip" type="text" ng-model="op.text"/>
                                                                            </td>
                                                                            <td ng-repeat="break in options.quantity_breaks">
                                                                                <input class="nbd-short-ip" type="number" ng-model="op.value[$index]"/>
                                                                            </td>                                                                            
                                                                        </tr>
                                                                    </table>
                                                                </div> 
                                                            </div>
                                                        </div>                                                        
                                                    </div>    
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
                                                    <div class="nbd-field-info">
                                                        <div class="nbd-field-info-1">
                                                            <label><b><?php _e('Display type', 'web-to-print-online-designer'); ?></b></label>
                                                        </div>  
                                                        <div class="nbd-field-info-2">
                                                            <select name="options[fields][{{sectionIndex}}][fields][{{fieldIndex}}][appearance][display_type]" ng-model="field.appearance.display_type">
                                                                <optgroup label="<?php _e('Single attribute', 'web-to-print-online-designer'); ?>">
                                                                    <option value="n"><?php _e('Input number', 'web-to-print-online-designer'); ?></option>
                                                                </optgroup>
                                                                <optgroup label="<?php _e('Multiple attributes', 'web-to-print-online-designer'); ?>">
                                                                    <option value="d"><?php _e('Dropdown', 'web-to-print-online-designer'); ?></option>
                                                                    <option value="r"><?php _e('Radio', 'web-to-print-online-designer'); ?></option>
                                                                    <option value="r"><?php _e('Check box', 'web-to-print-online-designer'); ?></option>
                                                                    <option value="i"><?php _e('Attribute name with input quantity', 'web-to-print-online-designer'); ?></option>
                                                                </optgroup>    
                                                            </select>
                                                        </div>      
                                                    </div>   
                                                </div>                                                  
                                            </div>
                                            <div><a class="button" ng-click="append_field()"><span class="dashicons dashicons-plus"></span> <?php _e('Add field', 'web-to-print-online-designer'); ?></a></div>
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
                <div class="preview-wrap">
                    
                </div>
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