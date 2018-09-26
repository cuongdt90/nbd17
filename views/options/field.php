<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-field-wrap" ng-repeat="(fieldIndex, field) in options.fields">
    <div class="nbd-nav">
        <div ng-dblclick="toggleExpandField($index, $event)" style="cursor: pointer;" title="<?php _e('Double click to expand option', 'web-to-print-online-designer') ?>">
            <ul nbd-tab ng-class="field.isExpand ? '' : 'left'" class="nbd-tab-nav">
                <li class="nbd-field-tab active" data-target="tab-general"><?php _e('General', 'web-to-print-online-designer') ?></li>
                <li class="nbd-field-tab" data-target="tab-conditional"><?php _e('Conditinal', 'web-to-print-online-designer') ?></li>
                <li class="nbd-field-tab" data-target="tab-appearance"><?php _e('Appearance', 'web-to-print-online-designer') ?></li>
                <li ng-if="field.nbd_type" class="nbd-field-tab" data-target="tab-online-design"><?php _e('Online design', 'web-to-print-online-designer') ?></li>
            </ul>
            <input ng-hide="true" ng-model="field.id" name="options[fields][{{fieldIndex}}][id]"/>
            <span class="nbd-field-name" ng-class="field.isExpand ? '' : 'left'"><span>{{field.general.title.value}}</span></span>
            <span class="nbdesigner-right field-action">
                <span class="nbo-sort-group">
                    <span ng-click="sort_field($index, 'up')" class="dashicons dashicons-arrow-up nbo-sort-up nbo-sort" title="<?php _e('Up', 'web-to-print-online-designer') ?>"></span>
                    <span ng-click="sort_field($index, 'down')" class="dashicons dashicons-arrow-down nbo-sort-down nbo-sort" title="<?php _e('Down', 'web-to-print-online-designer') ?>"></span>
                </span>
                <a class="nbd-field-btn nbd-mini-btn button" ng-click="delete_field($index)" title="<?php _e('Delete', 'web-to-print-online-designer'); ?>"><span class="dashicons dashicons-no-alt"></span></a>
                <a class="nbd-field-btn nbd-mini-btn button" ng-click="copy_field($index)" title="<?php _e('Copy', 'web-to-print-online-designer'); ?>"><span class="dashicons dashicons-admin-page"></span></a>
                <a class="nbd-field-btn nbd-mini-btn button" ng-click="toggleExpandField($index, $event)" title="<?php _e('Expand', 'web-to-print-online-designer'); ?>"><span ng-show="!field.isExpand" class="dashicons dashicons-arrow-down"></span><span ng-show="field.isExpand" class="dashicons dashicons-arrow-up"></span></a>
            </span>    
        </div>   
        <div class="clear"></div>
    </div>
    <div ng-show="field.isExpand">
        <div class="tab-general nbd-field-content active">
            <div class="nbd-field-info">
                <div class="nbd-field-info-1">
                    <div><label><b><?php _e('Option name', 'web-to-print-online-designer'); ?></b></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div>
                        <input required type="text" name="options[fields][{{fieldIndex}}][general][title]" ng-model="field.general.title.value">
                    </div>
                </div>
            </div>
            <div class="nbd-field-info">
                <div class="nbd-field-info-1">
                    <div><label><b><?php _e('Description', 'web-to-print-online-designer'); ?></b></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div>
                        <textarea name="options[fields][{{fieldIndex}}][general][description]" ng-model="field.general.description.value"></textarea>
                    </div>
                </div>
            </div> 
            <div class="nbd-field-info" ng-show="check_depend(field.general, field.general.data_type)">
                <div class="nbd-field-info-1">
                    <div><label><b><?php _e('Data type', 'web-to-print-online-designer'); ?></b></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div>
                        <select name="options[fields][{{fieldIndex}}][general][data_type]" ng-model="field.general.data_type.value" ng-change="update_price_type(fieldIndex)" >
                            <option ng-repeat="op in field.general.data_type.options" value="{{op.key}}">{{op.text}}</option>
                        </select>                        
                    </div>
                </div>
            </div>
            <div class="nbd-field-info" ng-show="check_depend(field.general, field.general.input_type)">
                <div class="nbd-field-info-1">
                    <div><label><b><?php _e('Input type', 'web-to-print-online-designer'); ?></b></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div>
                        <select name="options[fields][{{fieldIndex}}][general][input_type]" ng-model="field.general.input_type.value" ng-change="update_price_type(fieldIndex)" >
                            <option ng-repeat="op in field.general.input_type.options" value="{{op.key}}">{{op.text}}</option>
                        </select>                        
                    </div>
                </div>
            </div> 
            <div class="nbd-field-info" ng-show="check_depend(field.general, field.general.input_option)">
                <div class="nbd-field-info-1">
                    <div><label><b><?php _e('Input option', 'web-to-print-online-designer'); ?></b></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div>
                        <table class="nbd-table">
                            <tr>
                                <th><?php _e('Min', 'web-to-print-online-designer'); ?></th>
                                <th><?php _e('Max', 'web-to-print-online-designer'); ?></th>
                                <th><?php _e('Step', 'web-to-print-online-designer'); ?></th>
                            </tr>
                            <tr>
                                <td>
                                    <input class="nbd-short-ip" type="text" string-to-number ng-model="field.general.input_option.value.min" name="options[fields][{{fieldIndex}}][general][input_option][min]"/>
                                </td>
                                <td>
                                    <input class="nbd-short-ip" type="text" string-to-number ng-model="field.general.input_option.value.max" name="options[fields][{{fieldIndex}}][general][input_option][max]"/>
                                </td>
                                <td>
                                    <input class="nbd-short-ip" type="text" string-to-number ng-model="field.general.input_option.value.step" name="options[fields][{{fieldIndex}}][general][input_option][step]"/>
                                </td>                                
                            </tr>
                        </table>
                    </div>
                </div>
            </div>            
            <div class="nbd-field-info">
                <div class="nbd-field-info-1">
                    <div><label><b><?php _e('Enabled', 'web-to-print-online-designer'); ?></b> <nbd-tip data-tip="<?php _e('Choose whether the option is enabled or not.', 'web-to-print-online-designer'); ?>" ></nbd-tip></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div>
                        <select name="options[fields][{{fieldIndex}}][general][enabled]" ng-model="field.general.enabled.value">
                            <option ng-repeat="op in field.general.enabled.options" value="{{op.key}}">{{op.text}}</option>
                        </select>                        
                    </div>
                </div>
            </div>   
            <div class="nbd-field-info">
                <div class="nbd-field-info-1">
                    <div><label><b><?php _e('Required', 'web-to-print-online-designer'); ?></b> <nbd-tip data-tip="<?php _e('Choose whether the option is required or not.', 'web-to-print-online-designer'); ?>" ></nbd-tip></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div>
                        <select name="options[fields][{{fieldIndex}}][general][required]" ng-model="field.general.required.value">
                            <option ng-repeat="op in field.general.required.options" value="{{op.key}}">{{op.text}}</option>
                        </select>                        
                    </div>
                </div>
            </div>
            <div class="nbd-field-info">
                <div class="nbd-field-info-1">
                    <div><label><b><?php _e('Price type', 'web-to-print-online-designer'); ?></b> <nbd-tip data-tip="<?php _e('Here you can choose how the price is calculated. Depending on the field there various types you can choose.', 'web-to-print-online-designer'); ?>" ></nbd-tip></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div>
                        <select name="options[fields][{{fieldIndex}}][general][price_type]" ng-model="field.general.price_type.value">
                            <option ng-repeat="op in field.general.price_type.options" ng-if="check_option_depend(fieldIndex, op.depend)" value="{{op.key}}">{{op.text}}</option>
                        </select>                        
                    </div>
                </div>
            </div> 
            <div class="nbd-field-info">
                <div class="nbd-field-info-1">
                    <div><label><b><?php _e('Depend quantity breaks', 'web-to-print-online-designer'); ?></b></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div>
                        <select name="options[fields][{{fieldIndex}}][general][depend_quantity]" ng-model="field.general.depend_quantity.value">
                            <option ng-repeat="op in field.general.depend_quantity.options" value="{{op.key}}">{{op.text}}</option>
                        </select>                        
                    </div>
                </div>
            </div>            
            <div class="nbd-field-info" ng-show="check_depend(field.general, field.general.price)">
                <div class="nbd-field-info-1">
                    <div><label><b><?php _e('Additional Price', 'web-to-print-online-designer'); ?></b> <nbd-tip data-tip="<?php _e('Enter the price for this field or leave it blank for no price.', 'web-to-print-online-designer'); ?>" ></nbd-tip></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div>
                        <input type="number" name="options[fields][{{fieldIndex}}][general][price]" ng-model="field.general.price.value">
                    </div>
                </div>
            </div> 
            <div class="nbd-field-info" ng-show="check_depend(field.general, field.general.price_breaks)">
                <div class="nbd-field-info-1">
                    <div><label><b><?php _e('Price depend quantity breaks', 'web-to-print-online-designer'); ?></b></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div class="nbd-table-wrap">
                        <table class="nbd-table">
                            <tr>
                                <th><?php _e('Quantity break', 'web-to-print-online-designer'); ?></th>
                                <th ng-repeat="break in options.quantity_breaks">{{break.val}}</th>
                            </tr>
                            <tr>
                                <td><?php _e('Additional Price', 'web-to-print-online-designer'); ?></td>
                                <td ng-repeat="break in options.quantity_breaks">
                                    <input class="nbd-short-ip" type="text" ng-model="field.general.price_breaks.value[$index]" name="options[fields][{{fieldIndex}}][general][price_breaks][{{$index}}]" />
                                </td>
                            </tr>
                        </table>                        
                    </div>
                </div>
            </div>  
            <div class="nbd-field-info" ng-show="check_depend(field.general, field.general.attributes)">
                <div class="nbd-field-info-1">
                    <div><label><b><?php _e('Attributes', 'web-to-print-online-designer'); ?></b> <nbd-tip data-tip="<?php _e('Attributes let you define extra product data, such as size or color.', 'web-to-print-online-designer'); ?>" ></nbd-tip></label></div>
                </div>  
                <div class="nbd-field-info-2">
                    <div>
                        <div ng-repeat="(opIndex, op) in field.general.attributes.options" class="nbd-attribute-wrap">
                            <div class="nbd-attribute-img-wrap">
                                <div><?php _e('Swatch type', 'web-to-print-online-designer'); ?> <sup class="nbs-sup-des">1</sup></div>
                                <div>
                                    <select ng-model="op.preview_type" style="width: 110px;" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][preview_type]">
                                        <option value="i"><?php _e('Image', 'web-to-print-online-designer'); ?></option>
                                        <option value="c"><?php _e('Color', 'web-to-print-online-designer'); ?></option>                                                                    
                                    </select>   
                                </div>
                                <div class="nbd-attribute-img-inner" ng-show="op.preview_type == 'i'">
                                    <span class="dashicons dashicons-no remove-attribute-img" ng-click="remove_attribute_image(fieldIndex, $index, 'image', 'image_url')"></span>
                                    <input ng-hide="true" ng-model="op.image" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][image]"/>
                                    <img title="<?php _e('Click to change image', 'web-to-print-online-designer'); ?>" ng-click="set_attribute_image(fieldIndex, $index, 'image', 'image_url')" ng-src="{{op.image != 0 ? op.image_url : '<?php echo NBDESIGNER_ASSETS_URL . 'images/placeholder.png' ?>'}}" />
                                </div>
                                <div class="nbd-attribute-color-inner" ng-show="op.preview_type == 'c'">
                                    <input type="text" name="options[fields][{{fieldIndex}}][general][attributes][options][{{$index}}][color]" ng-model="op.color" class="nbd-color-picker" nbd-color-picker="op.color"/>
                                </div>
                                <div ng-if="field.appearance.change_image_product.value == 'y'">
                                    <div><?php _e('Product image', 'web-to-print-online-designer'); ?>  <sup class="nbs-sup-des">2</sup></div>
                                    <div class="nbd-attribute-img-inner">
                                        <span class="dashicons dashicons-no remove-attribute-img" ng-click="remove_attribute_image(fieldIndex, $index, 'product_image', 'product_image_url')"></span>
                                        <input ng-hide="true" ng-model="op.product_image" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][product_image]"/>
                                        <img title="<?php _e('Click to change image', 'web-to-print-online-designer'); ?>" ng-click="set_attribute_image(fieldIndex, $index, 'product_image', 'product_image_url')" ng-src="{{op.product_image_url ? op.product_image_url : '<?php echo NBDESIGNER_ASSETS_URL . 'images/placeholder.png' ?>'}}" />
                                    </div>
                                </div>
                            </div>    
                            <div class="nbd-attribute-content-wrap">
                                <div><?php _e('Title', 'web-to-print-online-designer'); ?></div>
                                <div class="nbd-attribute-name">
                                    <input required type="text" value="{{op.name}}" ng-model="op.name" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][name]"/>
                                    <label><input type="checkbox" name="options[fields][{{fieldIndex}}][general][attributes][options][{{$index}}][selected]" ng-checked="op.selected" ng-click="seleted_attribute(fieldIndex, 'attributes', $index)"/> <?php _e('Selected', 'web-to-print-online-designer'); ?></label>
                                </div>
                                <div class="nbd-margin-10"></div>
                                <div ng-show="field.general.depend_quantity.value != 'y'">
                                    <div><?php _e('Additional Price', 'web-to-print-online-designer'); ?></div>
                                    <div>
                                        <input name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][price][0]" class="nbd-short-ip" type="text" ng-model="op.price[0]"/>
                                    </div>
                                </div>
                                <div class="nbd-table-wrap" ng-show="field.general.depend_quantity.value == 'y'" >
                                    <table class="nbd-table">
                                        <tr>
                                            <th><?php _e('Quantity break', 'web-to-print-online-designer'); ?></th>
                                            <th ng-repeat="break in options.quantity_breaks">{{break.val}}</th>
                                        </tr>
                                        <tr>
                                            <td><?php _e('Additional Price', 'web-to-print-online-designer'); ?></td>
                                            <td ng-repeat="break in options.quantity_breaks">
                                                <input name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][price][{{$index}}]" class="nbd-short-ip" type="text" ng-model="op.price[$index]"/>
                                            </td>
                                        </tr>                                                                        
                                    </table>
                                </div> 
                            </div> 
                            <div class="nbd-attribute-action">
                                <span class="nbo-sort-group">
                                    <span ng-click="sort_attribute(fieldIndex, $index, 'up')" class="dashicons dashicons-arrow-up nbo-sort-up nbo-sort" title="<?php _e('Up', 'web-to-print-online-designer') ?>"></span>
                                    <span ng-click="sort_attribute(fieldIndex, $index, 'down')" class="dashicons dashicons-arrow-down nbo-sort-down nbo-sort" title="<?php _e('Down', 'web-to-print-online-designer') ?>"></span>
                                </span>
                                <a class="button nbd-mini-btn"  ng-click="remove_attribute(fieldIndex, 'attributes', $index)" title="<?php _e('Delete', 'web-to-print-online-designer'); ?>"><span class="dashicons dashicons-no-alt"></span></a>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div><a class="button" ng-click="add_attribute(fieldIndex, 'attributes')"><span class="dashicons dashicons-plus"></span> <?php _e('Add attribute', 'web-to-print-online-designer'); ?></a></div>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-conditional nbd-field-content">
            <div class="nbd-field-info">
                <div class="nbd-field-info-1">
                    <div><b><?php _e('Field Conditional Logic', 'web-to-print-online-designer'); ?></b> <nbd-tip data-tip="<?php _e('Enable conditional logic for showing or hiding this field.', 'web-to-print-online-designer'); ?>"></nbd-tip></div>
                </div>  
                <div class="nbd-field-info-2">
                    <div>
                        <select ng-model="field.conditional.enable" style="width: 100px;" name="options[fields][{{fieldIndex}}][conditional][enable]">
                            <option value="n"><?php _e('No', 'web-to-print-online-designer'); ?></option>
                            <option value="y"><?php _e('Yes', 'web-to-print-online-designer'); ?></option>
                        </select>
                    </div>
                    <div ng-if="field.conditional.enable == 'y'">
                        <div style="margin-top: 10px;">
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
                        <div style="margin-top: 10px;">
                            <div ng-repeat="(cdIndex, con) in field.conditional.depend">
                                <select ng-model="con.id" style="width: 200px;" name="options[fields][{{fieldIndex}}][conditional][depend][{{cdIndex}}][id]">
                                    <option ng-repeat="cf in options.fields | filter: { id: '!' + field.id }" value="{{cf.id}}">{{cf.general.title.value}}</option>
                                </select>
                                <select ng-model="con.operator" style="width: 120px;" name="options[fields][{{fieldIndex}}][conditional][depend][{{cdIndex}}][operator]">
                                    <option value="i"><?php _e('is', 'web-to-print-online-designer'); ?></option>
                                    <option value="n"><?php _e('is not', 'web-to-print-online-designer'); ?></option>
                                    <option value="e"><?php _e('is empty', 'web-to-print-online-designer'); ?></option>
                                    <option value="ne"><?php _e('is not empty', 'web-to-print-online-designer'); ?></option>
                                </select>
                                <select ng-if="con.operator == 'i' || con.operator == 'n'" ng-model="con.val" ng-show="vf.id == con.id" ng-repeat="vf in options.fields | filter: {id: con.id}"  
                                    name="options[fields][{{fieldIndex}}][conditional][depend][{{cdIndex}}][val]" style="width: 200px;">
                                    <option ng-repeat="vop in vf.general.attributes.options" value="{{$index}}">{{vop.name}}</option>
                                </select> 
                                <a class="nbd-field-btn nbd-mini-btn button" ng-click="add_condition(fieldIndex)"><span class="dashicons dashicons-plus"></span></a>
                                <a class="nbd-field-btn nbd-mini-btn button" ng-click="delete_condition(fieldIndex, cdIndex)"><span class="dashicons dashicons-no-alt"></span></a>
                            </div>
                        </div>
                    </div>    
                </div>  
            </div>     
        </div>
        <div class="tab-appearance nbd-field-content">
            <div class="nbd-field-info" ng-repeat="(key, data) in field.appearance">
                <div class="nbd-field-info-1">
                    <div><label><b>{{data.title}}</b> <nbd-tip ng-if="data.description != ''" data-tip="{{data.description}}" ></nbd-tip></label></div>
                </div> 
                <div class="nbd-field-info-2">
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
        <div class="tab-online-design nbd-field-content" ng-if="field.nbd_type">
            <input ng-hide="true" name="options[fields][{{fieldIndex}}][nbd_type]" ng-model="field.nbd_type">
            <ng-include src="field.nbd_template"></ng-include>
        </div>
    </div>
</div>
<div><a class="button" ng-click="add_field()"><span class="dashicons dashicons-plus"></span> <?php _e('Add Field', 'web-to-print-online-designer'); ?></a></div>
<?php echo '<script type="text/ng-template" id="nbd.page">'; ?>
    <div class="nbd-field-info">
        <div class="nbd-field-info-1">
            <div><b><?php _e('Page display:', 'web-to-print-online-designer'); ?></b></div>
        </div>
        <div class="nbd-field-info-2">
            <select name="options[fields][{{fieldIndex}}][general][page_display]" ng-model="field.general.page_display">
                <option value="1"><?php _e('Each page on a design stage', 'web-to-print-online-designer'); ?></option>
                <option value="2"><?php _e('Two pages on a design stage', 'web-to-print-online-designer'); ?></option>
            </select>
        </div>
    </div>
    <div class="nbd-field-info">
        <div class="nbd-field-info-1">
            <div><b><?php _e('Exclude page', 'web-to-print-online-designer'); ?></b></div>
        </div>
        <div class="nbd-field-info-2">
            <select name="options[fields][{{fieldIndex}}][general][exclude_page]" ng-model="field.general.exclude_page">
                <option value="0"><?php _e('None', 'web-to-print-online-designer'); ?></option>
                <option value="2"><?php _e('Cover pages', 'web-to-print-online-designer'); ?></option>
            </select>
        </div>
    </div>
<?php echo '</script>'; ?>
<?php echo '<script type="text/ng-template" id="nbd.color">'; ?>
    <div class="nbd-field-info">
        <div class="nbd-field-info-1">
            <div><b><?php _e('Background type', 'web-to-print-online-designer'); ?></b></div>
        </div>
        <div class="nbd-field-info-2">
            <select name="options[fields][{{fieldIndex}}][general][attributes][bg_type]" ng-model="field.general.attributes.bg_type">
                <option value="i"><?php _e('Image', 'web-to-print-online-designer'); ?></option>
                <option value="c"><?php _e('Color', 'web-to-print-online-designer'); ?></option>
            </select>
        </div>
    </div>
    <div class="nbd-field-info">
        <div class="nbd-field-info-1">
            <div><b><?php _e('Number of sides', 'web-to-print-online-designer'); ?></b></div>
        </div>
        <div class="nbd-field-info-2">
            <input class="nbd-short-ip" name="options[fields][{{fieldIndex}}][general][attributes][number_of_sides]" string-to-number type="number" min="1" step="1" ng-model="field.general.attributes.number_of_sides" />
        </div>
    </div>
    <div class="nbd-field-info" ng-if="field.general.attributes.bg_type == 'c'">
        <div class="nbd-field-info-1">
            <div><b><?php _e('Backgrund sides', 'web-to-print-online-designer'); ?></b></div>
        </div>
        <div class="nbd-field-info-2">
            <div class="nbd-table-wrap">
                <table class="nbd-table" style="text-align: center;">
                    <tbody>
                        <tr ng-repeat="(opIndex, op) in field.general.attributes.options">
                            <th>{{op.name}}</th>
                            <td>
                                <input type="text" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][bg_color]" ng-model="op.bg_color" class="nbd-color-picker" nbd-color-picker="op.bg_color"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="nbd-field-info" ng-if="field.general.attributes.bg_type == 'i'">
        <div class="nbd-field-info-1">
            <div><b><?php _e('Sides background', 'web-to-print-online-designer'); ?></b></div>
        </div>
        <div class="nbd-field-info-2">
            <div class="nbd-table-wrap">
                <table class="nbd-table" style="text-align: center;">
                    <tbody>
                        <tr ng-repeat="(opIndex, op) in field.general.attributes.options">
                            <th>{{op.name}}</th>
                            <td ng-repeat="n in [] | range:field.general.attributes.number_of_sides">
                                <input ng-hide="true" ng-model="op.bg_image[n]" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][bg_image][{{n}}]"/>
                                <img class="bg_od_preview" title="<?php _e('Click to change image', 'web-to-print-online-designer'); ?>" ng-click="set_attribute_image(fieldIndex, opIndex, 'bg_image', 'bg_image_url', n)" ng-src="{{op.bg_image[n] != undefined ? op.bg_image_url[n] : '<?php echo NBDESIGNER_ASSETS_URL . 'images/placeholder.png' ?>'}}" />  
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php echo '</script>'; ?>
<?php echo '<script type="text/ng-template" id="nbd.size">'; ?>
    <div class="nbd-field-info">
        <div class="nbd-field-info-1">
            <div>
                <label>
                    <b><?php _e('Use a same online design config', 'web-to-print-online-designer'); ?></b>
                    <nbd-tip data-tip="<?php _e('All attributes have a same online design config ( product width, height, area design width, height, left, top ).', 'web-to-print-online-designer'); ?>" ></nbd-tip>
                </label>
            </div>
        </div>
        <div class="nbd-field-info-2">
            <select name="options[fields][{{fieldIndex}}][general][attributes][same_size]" ng-model="field.general.attributes.same_size">
                <option value="y"><?php _e('Yes', 'web-to-print-online-designer'); ?></option>
                <option value="n"><?php _e('No', 'web-to-print-online-designer'); ?></option>
            </select>
        </div>
    </div>
    <div class="nbd-field-info" ng-if="field.general.attributes.same_size == 'n'">
        <div><b><?php _e('Online design config:', 'web-to-print-online-designer'); ?></b></div>
        <div class="nbd-table-wrap">
            <table class="nbd-table" style="text-align: center;">
                <thead>
                    <tr>
                        <th></th>
                        <th><?php _e('Product width', 'web-to-print-online-designer'); ?></th>
                        <th><?php _e('Product height', 'web-to-print-online-designer'); ?></th>
                        <th><?php _e('Design width', 'web-to-print-online-designer'); ?></th>
                        <th><?php _e('Design height', 'web-to-print-online-designer'); ?></th>
                        <th><?php _e('Design top', 'web-to-print-online-designer'); ?></th>
                        <th><?php _e('Design left', 'web-to-print-online-designer'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="(opIndex, op) in field.general.attributes.options">
                        <th>{{op.name}}</th>
                        <td><input string-to-number required class="nbd-short-ip" ng-model="op.product_width" type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][product_width]" /></td>
                        <td><input string-to-number required class="nbd-short-ip" ng-model="op.product_height" type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][product_height]" /></td>
                        <td><input string-to-number required class="nbd-short-ip" ng-model="op.real_width" type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][real_width]" /></td>
                        <td><input string-to-number required class="nbd-short-ip" ng-model="op.real_height" type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][real_height]" /></td>
                        <td><input string-to-number required class="nbd-short-ip" ng-model="op.real_top" type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][real_top]" /></td>
                        <td><input string-to-number required class="nbd-short-ip" ng-model="op.real_left" type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][real_left]" /></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php echo '</script>'; ?>
<script type="text/ng-template" id="nbd.dpi">
</script>
<script type="text/ng-template" id="nbd.area">
</script>
<script type="text/ng-template" id="nbd.orientation">
</script>
<?php echo '<script type="text/ng-template" id="nbd.dimension">'; ?>
    <div class="nbd-field-info">
        <div class="nbd-field-info-1">
            <div><b><?php _e('Dimension range:', 'web-to-print-online-designer'); ?></b></div>
        </div>
        <div class="nbd-field-info-2">
            <table class="nbd-table">
                <thead>
                    <tr>
                        <th></th>
                        <th><?php _e('Min', 'web-to-print-online-designer'); ?></th>
                        <th><?php _e('Max', 'web-to-print-online-designer'); ?></th>
                        <th><?php _e('Step', 'web-to-print-online-designer'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th><?php _e('Width', 'web-to-print-online-designer'); ?></th>
                        <td><input string-to-number class="nbd-short-ip" ng-model="field.general.min_width" type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][min_width]" /></td>
                        <td><input string-to-number class="nbd-short-ip" ng-model="field.general.max_width" type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][max_width]" /></td>
                        <td><input string-to-number class="nbd-short-ip" ng-model="field.general.step_width" type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][step_width]" /></td>
                    </tr>
                    <tr>
                        <th><?php _e('Height', 'web-to-print-online-designer'); ?></th>
                        <td><input string-to-number class="nbd-short-ip" ng-model="field.general.min_height" type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][min_height]" /></td>
                        <td><input string-to-number class="nbd-short-ip" ng-model="field.general.max_height" type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][max_height]" /></td>
                        <td><input string-to-number class="nbd-short-ip" ng-model="field.general.step_height" type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][step_height]" /></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="nbd-field-info" style="margin-top: 10px;">
        <div class="nbd-field-info-1">
            <div>
                <label>
                    <b><?php _e('Enable measure price base on design area', 'web-to-print-online-designer'); ?></b>
                    <nbd-tip data-tip="<?php _e('Measure price base on design area.', 'web-to-print-online-designer'); ?>" ></nbd-tip>
                </label>
            </div>
        </div>
        <div class="nbd-field-info-2">
            <select name="options[fields][{{fieldIndex}}][general][mesure]" ng-model="field.general.mesure">
                <option value="y"><?php _e('Yes', 'web-to-print-online-designer'); ?></option>
                <option value="n"><?php _e('No', 'web-to-print-online-designer'); ?></option>
            </select>
        </div>
    </div>
    <div class="nbd-field-info" ng-if="field.general.mesure == 'y'">
        <div class="nbd-field-info-1">
            <div><b><?php _e('Price base on design area:', 'web-to-print-online-designer'); ?></b></div>
        </div>
        <div class="nbd-field-info-2">
            <table class="nbd-table nbo-measure-range">
                <thead>
                    <tr>
                        <th class="check-column">
                            <input class="nbo-measure-range-select-all" type="checkbox" ng-click="select_all_measurement_range(fieldIndex, $event)">
                        </th>
                        <th class="range-column" style="padding-right: 30px;">
                            <span class="column-title" data-text="<?php esc_attr_e( 'Measurement Range', 'web-to-print-online-designer' ); ?>"><?php _e( 'Measurement Range', 'web-to-print-online-designer' ); ?></span>
                            <nbd-tip data-tip="<?php _e( 'Configure the starting-ending range, inclusive, of measurements to match this rule.  The first matched rule will be used to determine the price.  The final rule can be defined without an ending range to match all measurements greater than or equal to its starting range.', 'web-to-print-online-designer'); ?>" ></nbd-tip>
                        </th>
                        <th class="price-column">
                            <span><?php echo _e('Price per Unit', 'web-to-print-online-designer'); ?> <?php echo ' ('.get_woocommerce_currency_symbol() . '/' . nbdesigner_get_option('nbdesigner_dimensions_unit').'<sup>2</sup>)'; ?></span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="(mrIndex, mr) in field.general.mesure_range">
                        <td>
                            <input type="checkbox" class="nbo-measure-range-checkbox" ng-model="mr[3]">
                        </td>                
                        <td>
                            <span>
                                <span class="nbd-table-price-label"><?php echo _e('From', 'web-to-print-online-designer'); ?></span>
                                <input string-to-number type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][mesure_range][{{mrIndex}}][0]" ng-model="mr[0]" class="nbd-short-ip">
                            </span>   
                            <span>
                                <span class="nbd-table-price-label" style="margin-left: 10px;"><?php echo _e('To', 'web-to-print-online-designer'); ?></span>
                                <input string-to-number type="number" min="0" step="any" name="options[fields][{{fieldIndex}}][general][mesure_range][{{mrIndex}}][1]" ng-model="mr[1]" class="nbd-short-ip">
                            </span>                       
                        </td>
                        <td>
                            <input string-to-number type="number" step="any" name="options[fields][{{fieldIndex}}][general][mesure_range][{{mrIndex}}][2]" ng-model="mr[2]" class="nbd-short-ip">
                        </td>                
                    </tr> 
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">
                            <button ng-click="add_measurement_range(fieldIndex)" style="float: left;" type="button" class="button button-primary nbd-pricing-table-add-rule"><?php _e( 'Add Rule', 'web-to-print-online-designer' ); ?></button>
                            <button ng-click="delete_measurement_ranges(fieldIndex, $event)" style="float: right;" type="button" class="button button-secondary nbd-pricing-table-delete-rules"><?php _e( 'Delete Selected', 'web-to-print-online-designer' ); ?></button>
                        </th>
                    </tr>
                </tfoot> 
            </table>
        </div>
    </div>
<?php echo '</script>'; ?>