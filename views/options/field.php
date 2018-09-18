<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-field-wrap" ng-repeat="(fieldIndex, field) in options.fields">
    <div class="nbd-nav">
        <div ng-dblclick="toggleExpandField($index, $event)" style="cursor: pointer;" title="<?php _e('Double click to expand option', 'web-to-print-online-designer') ?>">
            <ul nbd-tab ng-class="field.isExpand ? '' : 'left'" class="nbd-tab-nav">
                <li class="nbd-field-tab active" data-target="tab-general"><?php _e('General', 'web-to-print-online-designer') ?></li>
                <li class="nbd-field-tab" data-target="tab-conditional"><?php _e('Conditinal', 'web-to-print-online-designer') ?></li>
                <li class="nbd-field-tab" data-target="tab-appearance"><?php _e('Appearance', 'web-to-print-online-designer') ?></li>
                <li ng-if="field.is_nbd" class="nbd-field-tab" data-target="tab-online-design"><?php _e('Online design', 'web-to-print-online-designer') ?></li>
            </ul>
            <input ng-hide="true" ng-model="field.id" name="options[fields][{{fieldIndex}}][id]"/>
            <span class="nbd-field-name" ng-class="field.isExpand ? '' : 'left'"><span>{{field.general.title.value}}</span></span>
            <span class="nbdesigner-right field-action">
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
                    <div><label><b>{{field.general.title.title}}</b></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div>
                        <input type="text" name="options[fields][{{fieldIndex}}][general][title]" ng-model="field.general.title.value">
                    </div>
                </div>
            </div>
            <div class="nbd-field-info">
                <div class="nbd-field-info-1">
                    <div><label><b>{{field.general.description.title}}</b></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div>
                        <textarea name="options[fields][{{fieldIndex}}][general][description]" ng-model="field.general.description.value"></textarea>
                    </div>
                </div>
            </div> 
            <div class="nbd-field-info">
                <div class="nbd-field-info-1">
                    <div><label><b>{{field.general.data_type.title}}</b></label></div>
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
                    <div><label><b>{{field.general.input_type.title}}</b></label></div>
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
                    <div><label><b>{{field.general.input_option.title}}</b></label></div>
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
                    <div><label><b>{{field.general.enabled.title}}</b> <nbd-tip data-tip="{{field.general.enabled.description}}" ></nbd-tip></label></div>
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
                    <div><label><b>{{field.general.required.title}}</b> <nbd-tip data-tip="{{field.general.required.description}}" ></nbd-tip></label></div>
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
                    <div><label><b>{{field.general.price_type.title}}</b> <nbd-tip data-tip="{{field.general.price_type.description}}" ></nbd-tip></label></div>
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
                    <div><label><b>{{field.general.depend_quantity.title}}</b></label></div>
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
                    <div><label><b>{{field.general.price.title}}</b> <nbd-tip data-tip="{{field.general.price.description}}" ></nbd-tip></label></div>
                </div>
                <div class="nbd-field-info-2">
                    <div>
                        <input type="number" name="options[fields][{{fieldIndex}}][general][price]" ng-model="field.general.price.value">
                    </div>
                </div>
            </div> 
            <div class="nbd-field-info" ng-show="check_depend(field.general, field.general.price_breaks)">
                <div class="nbd-field-info-1">
                    <div><label><b>{{field.general.price_breaks.title}}</b></label></div>
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
                    <div><label><b>{{field.general.attributes.title}}</b> <nbd-tip data-tip="{{field.general.attributes.description}}" ></nbd-tip></label></div>
                </div>  
                <div class="nbd-field-info-2">
                    <div>
                        <div ng-repeat="(opIndex, op) in field.general.attributes.options" class="nbd-attribute-wrap">
                            <div class="nbd-attribute-img-wrap">
                                <div><?php _e('Preview type', 'web-to-print-online-designer'); ?></div>
                                <div>
                                    <select ng-model="op.preview_type" style="width: 110px;" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][preview_type]">
                                        <option value="i"><?php _e('Image', 'web-to-print-online-designer'); ?></option>
                                        <option value="c"><?php _e('Color', 'web-to-print-online-designer'); ?></option>                                                                    
                                    </select>   
                                </div>
                                <div class="nbd-attribute-img-inner" ng-show="op.preview_type == 'i'">
                                    <span class="dashicons dashicons-no remove-attribute-img" ng-click="remove_attribute_image(fieldIndex, $index)"></span>
                                    <input ng-hide="true" ng-model="op.image" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][image]"/>
                                    <img ng-click="set_attribute_image(fieldIndex, $index)" ng-src="{{op.image != 0 ? op.image_url : '<?php echo NBDESIGNER_ASSETS_URL . 'images/placeholder.png' ?>'}}" />
                                </div>
                                <div class="nbd-attribute-color-inner" ng-show="op.preview_type == 'c'">
                                    <div class="nbd-attribute-color-pre" ng-style="{'background': op.color}"></div>
                                    <input type="text" name="options[fields][{{fieldIndex}}][general][attributes][options][{{$index}}][color]" ng-model="op.color" class="nbd-color-picker" nbd-color-picker/>
                                </div>    
                            </div>    
                            <div class="nbd-attribute-content-wrap">
                                <div><?php _e('Title', 'web-to-print-online-designer'); ?></div>
                                <div class="nbd-attribute-name">
                                    <input type="text" value="{{op.name}}" ng-model="op.name" name="options[fields][{{fieldIndex}}][general][attributes][options][{{opIndex}}][name]"/>
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
                            <div class="nbd-attribute-action"><a class="button nbd-mini-btn"  ng-click="remove_attribute(fieldIndex, 'attributes', $index)" title="<?php _e('Delete', 'web-to-print-online-designer'); ?>"><span class="dashicons dashicons-no-alt"></span></a></div>
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
        <div class="tab-online-design nbd-field-content" ng-if="field.is_nbd">
            <ng-include src="field.nbd_template"></ng-include>
        </div>
    </div>
</div>
<div><a class="button" ng-click="add_field()"><span class="dashicons dashicons-plus"></span> <?php _e('Add Field', 'web-to-print-online-designer'); ?></a></div>
<script type="text/ng-template" id="nbd.page">
    page
</script>
<script type="text/ng-template" id="nbd.color">
    color
</script>
<script type="text/ng-template" id="nbd.size">
    size
</script>
<script type="text/ng-template" id="nbd.dpi">
    dpi
</script>
<script type="text/ng-template" id="nbd.area">
    area
</script>
<script type="text/ng-template" id="nbd.orientation">
    orientation
</script>