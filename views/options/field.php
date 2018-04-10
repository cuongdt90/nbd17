<?php if (!defined('ABSPATH')) exit; ?>
<div class="nbd-field-wrap" ng-repeat="(fieldIndex, field) in options.fields">
    <div class="nbd-nav">
        <div>
            <ul nbd-tab ng-class="field.isExpand ? '' : 'left'" class="nbd-tab-nav">
                <li class="nbd-field-tab active" data-target="tab-general"><?php _e('General', 'web-to-print-online-designer') ?></li>
                <li class="nbd-field-tab" data-target="tab-conditional"><?php _e('Conditinal', 'web-to-print-online-designer') ?></li>
                <li class="nbd-field-tab" data-target="tab-appearance"><?php _e('Appearance', 'web-to-print-online-designer') ?></li>
            </ul>
            <input ng-hide="true" ng-model="field.id" name="options[fields][{{fieldIndex}}][id]"/>
            <span class="nbd-field-name" ng-class="field.isExpand ? '' : 'left'"><span>{{field.general.title.value}}</span> - {{field.id}}</span>
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
            <div class="nbd-field-info" ng-repeat="(key, data) in field.general">
                <div class="nbd-field-info-1" ng-show="check_depend(field.general, data)">
                    <div><label><b>{{data.title}}</b> <nbd-tip ng-if="data.description != ''" data-tip="{{data.description}}" ></nbd-tip></label></div>
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
                                        <input class="nbd-short-ip" type="text" ng-model="data.value[$index]" name="options[fields][{{fieldIndex}}][general][{{key}}][{{$index}}]" />
                                    </td>
                                </tr>
                            </table>
                        </div>     
                    </div>
                    <div ng-if="data.type == 'attributes'">
                        <div ng-repeat="(opIndex, op) in field.general.attributes.options" class="nbd-attribute-wrap">
                            <div class="nbd-attribute-img-wrap">
                                <div><?php _e('Preview type', 'web-to-print-online-designer'); ?></div>
                                <div>
                                    <select ng-model="op.preview_type" style="width: inherit;" name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{opIndex}}][preview_type]">
                                        <option value="i"><?php _e('Image', 'web-to-print-online-designer'); ?></option>
                                        <option value="c"><?php _e('Color', 'web-to-print-online-designer'); ?></option>                                                                    
                                    </select>   
                                </div>
                                <div class="nbd-attribute-img-inner" ng-show="op.preview_type == 'i'">
                                    <span class="dashicons dashicons-no remove-attribute-img" ng-click="remove_attribute_image(fieldIndex, $index)"></span>
                                    <input ng-hide="true" ng-model="op.image" name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{opIndex}}][image]"/>
                                    <img ng-click="set_attribute_image(fieldIndex, $index)" ng-src="{{op.image != 0 ? op.image_url : '<?php echo NBDESIGNER_ASSETS_URL . 'images/placeholder.png' ?>'}}" />
                                </div>
                                <div class="nbd-attribute-color-inner" ng-show="op.preview_type == 'c'">
                                    <div class="nbd-attribute-color-pre" ng-style="{'background': op.color}"></div>
                                    <input type="text" name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{$index}}][color]" ng-model="op.color" class="nbd-color-picker" nbd-color-picker/>
                                </div>    
                            </div>    
                            <div class="nbd-attribute-content-wrap">
                                <div><?php _e('Title', 'web-to-print-online-designer'); ?></div>
                                <div class="nbd-attribute-name">
                                    <input type="text" value="{{op.name}}" ng-model="op.name" name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{opIndex}}][name]"/>
                                    <label><input type="checkbox" name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{$index}}][selected]" ng-checked="op.selected" ng-click="seleted_attribute(fieldIndex, key, $index)"/> <?php _e('Selected', 'web-to-print-online-designer'); ?></label>
                                </div>
                                <div class="nbd-margin-10"></div>
                                <div ng-show="field.general.depend_quantity.value != 'y'">
                                    <div><?php _e('Price', 'web-to-print-online-designer'); ?></div>
                                    <div>
                                        <input name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{opIndex}}][price][0]" class="nbd-short-ip" type="text" ng-model="op.price[0]"/>
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
                                                <input name="options[fields][{{fieldIndex}}][general][{{key}}][options][{{opIndex}}][price][{{$index}}]" class="nbd-short-ip" type="text" ng-model="op.price[$index]"/>
                                            </td>
                                        </tr>                                                                        
                                    </table>
                                </div> 
                            </div> 
                            <div class="nbd-attribute-action"><a class="button nbd-mini-btn"  ng-click="remove_attribute(fieldIndex, key, $index)" title="<?php _e('Delete', 'web-to-print-online-designer'); ?>"><span class="dashicons dashicons-no-alt"></span></a></div>
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
                    <div><b><?php _e('Field Conditional Logic', 'web-to-print-online-designer'); ?></b> <nbd-tip data-tip="<?php _e('Enable conditional logic for showing or hiding this field.', 'web-to-print-online-designer'); ?>"></nbd-tip></div>
                </div>  
                <div class="nbd-field-info-2">
                    <div>
                        <select ng-model="field.conditional.enable" style="width: 100px;" name="options[fields][{{fieldIndex}}][conditional][enable]">
                            <option value="n"><?php _e('No', 'web-to-print-online-designer'); ?></option>
                            <option value="y"><?php _e('Yes', 'web-to-print-online-designer'); ?></option>
                        </select>
                    </div>
                    <div ng-show="field.conditional.enable == 'y'">
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
                                <select ng-model="con.id" style="width: 200px;">
                                    <option ng-repeat="cf in options.fields | filter: { id: '!' + field.id }" value="{{cf.id}}">{{cf.general.title.value}}</option>
                                </select>
                                <select ng-model="con.operator" style="width: 100px;">
                                    <option value="i"><?php _e('is', 'web-to-print-online-designer'); ?></option>
                                    <option value="n"><?php _e('is not', 'web-to-print-online-designer'); ?></option>
                                </select>
                                <select ng-model="con.val" ng-show="vf.id == con.id" ng-repeat="vf in options.fields | filter: {id: con.id}"  style="width: 200px;">
                                    <option ng-repeat="vop in vf.general.attributes.options" value="{{$index}}">{{vop.name}}</option>
                                </select> 
                            </div>
                        </div>
                    </div>    
                </div>  
            </div>     
        </div>
        <div class="tab-appearance nbd-field-content">
            <div class="nbd-field-info" ng-repeat="(key, data) in field.appearance">
                <div class="nbd-field-info-1" ng-show="check_depend(field.appearance, data)">
                    <div><label><b>{{data.title}}</b> <nbd-tip ng-if="data.description != ''" data-tip="{{data.description}}" ></nbd-tip></label></div>
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
<div><a class="button" ng-click="add_field()"><span class="dashicons dashicons-plus"></span> <?php _e('Add Field', 'web-to-print-online-designer'); ?></a></div>