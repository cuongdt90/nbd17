<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<div id="poststuff">
    <div class="postbox">
        <h2 style="border-bottom: 1px solid #ddd;"><?php _e('Create design link for Etsy order', 'web-to-print-online-designer'); ?></h2>
        <div class="inside">
            <table>
                <tbody>
                    <tr>
                        <td><label for="order_number"><b><?php _e('Order number', 'web-to-print-online-designer'); ?></b></label></td>
                        <td><input id="order_number" /></td>
                    </tr>
                    <tr>
                        <td><label for="product_id"><b><?php _e('Product ID', 'web-to-print-online-designer'); ?></b></label></td>
                        <td><input id="product_id" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" class="button button-primary button-large" value="<?php _e('Create link', 'web-to-print-online-designer'); ?>"/>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        
    });
</script>
