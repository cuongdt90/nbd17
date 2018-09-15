<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="nbo-bulk-variation-wrap nbo-table-wrap">
    <p><b><?php _e('Bulk form', 'web-to-print-online-designer'); ?></b></p>
    <table class="nbo-bulk-variation">
        <thead>
            <tr>
                <th class="check-column" ng-click="select_all_variation( $event )">
                    <input type="checkbox" class="nbo-bulk-checkbox" >
                </th>
            <?php 
                foreach($options["bulk_fields"] as $key => $bulk_index): 
                   $field = $options["fields"][$bulk_index]; 
            ?>
                <th><?php echo $field['general']['title']; ?> <?php if( $field['general']['required'] == 'y' ): ?><span class="nbd-required">*</span><?php endif; ?></th>
            <?php endforeach; ?>
                <th><?php _e('Quantity', 'web-to-print-online-designer'); ?> <span class="nbd-required">*</span></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="checkbox" class="nbo-bulk-checkbox" ></td>
            <?php 
                foreach($options["bulk_fields"] as $key => $bulk_index): 
                    $field = $options["fields"][$bulk_index];
            ?>
                <td>
                    <?php 
                        if($field['general']['data_type'] == 'i'): 
                        $input_type = $field['general']['input_type'] == 't' ? 'text' : 'number';
                    ?>
                    <input name="nbb-fields[<?php echo $field['id']; ?>][]" type="<?php echo $input_type; ?>"/>
                    <?php else: ?>
                    <select name="nbb-fields[<?php echo $field['id']; ?>][]" class="nbd-dropdown">
                        <?php foreach ($field['general']['attributes']["options"] as $key => $attr): ?>
                        <option value="<?php echo $key; ?>" <?php selected( isset($attr['selected']) ? $attr['selected'] : 'off', 'on' ); ?>><?php echo $attr['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>
                <td><input name="nbb-qty-fields[]" type="number" min="1" step="1" value="" required="" style="width: 4em" pattern="[0-9]*"/></td>
            </tr>            
        </tbody>
        <tfoot>
            <tr>
                <th colspan="<?php echo count($options["bulk_fields"]) + 2; ?>" style="text-align: left;">
                    <button ng-click="add_vairaion($event)" type="button" class="button button-primary nbd-setting-table-add-rule"><?php _e( 'Add Variation', 'web-to-print-online-designer' ); ?></button>
                    <button ng-click="delete_vairaions($event)" type="button" class="button button-secondary nbd-setting-table-delete-rules"><?php _e( 'Delete Selected', 'web-to-print-online-designer' ); ?></button>
                </th>
            </tr>            
        </tfoot>        
    </table>
</div>