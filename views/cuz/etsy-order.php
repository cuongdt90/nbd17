<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<div id="poststuff">
    <h2><?php _e('Helpdesk', 'web-to-print-online-designer'); ?></h2>
    <div>
        <div class="postbox">
            <h2 style="border-bottom: 1px solid #ddd;"><?php _e('Helpdesk additional content', 'web-to-print-online-designer'); ?></h2>
            <div class="inside" style="width: 500px;">
                <form method="post">
                <?php
                    $content = nbdesigner_get_option('nbdesigner_classic_helpdesk');
                    $editor_id = 'nbd_helpdesk_editor';
                    if( isset($_POST['helpdesk']) ){
                        $content = $_POST['nbd_helpdesk_editor'];
                        $result = update_option('nbdesigner_classic_helpdesk', $content);
                        if($result) echo '<div class="notice notice-success"><p><strong>' . __('Saved success!', 'web-to-print-online-designer') . '</strong></p></div>';
                    }
                    $content = stripslashes($content);
                    wp_editor( $content, $editor_id ); 
                ?>
                    <input style="margin: 15px 0" type="submit" name="helpdesk" class="button button-primary button-large" value="<?php _e('Save', 'web-to-print-online-designer'); ?>"/>
                </form>
            </div>
        </div>
    </div>
    <hr />
    <h2><?php _e('Etsy order', 'web-to-print-online-designer'); ?></h2>
    <div>
        <div class="postbox">
            <h2 style="border-bottom: 1px solid #ddd;"><?php _e('Create design link for Etsy order', 'web-to-print-online-designer'); ?></h2>
            <div class="inside">
                <form method="post">
                    <table>
                        <tbody>
                            <tr>
                                <td><label for="order_number"><b><?php _e('Order number', 'web-to-print-online-designer'); ?></b></label></td>
                                <td><input value="<?php echo $order_number; ?>" type="text" id="order_number" name="order_number" value=""/></td>
                            </tr>
                            <tr>
                                <td><label for="product_id"><b><?php _e('Product ID', 'web-to-print-online-designer'); ?></b></label></td>
                                <td>
                                    <input value="<?php echo $product_id; ?>" type="text" id="product_id" name="product_id" value="" />
                                    <br/><?php _e('Assign above order with a Woocommerce SIMPLE product', 'web-to-print-online-designer'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="link_redirect"><b><?php _e('Redirect link', 'web-to-print-online-designer'); ?></b></label></td>
                                <td>
                                    <input placeholder="<?php echo home_url('/'); ?>" style="width: 500px;" type="text" id="link_redirect" name="link_redirect" value="<?php echo $link_redirect; ?>"/>
                                    <br/><?php _e('Redirect link after the customer complete design', 'web-to-print-online-designer'); ?>
                                </td>
                            </tr>                            
                            <tr>
                                <td colspan="2">
                                    <input style="margin-top: 15px;" type="submit" name="etsy_order" class="button button-primary button-large" value="<?php _e('Create link', 'web-to-print-online-designer'); ?>"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <div style="margin-top: 15px;">
                    <?php if( $start_design_link != '' ): ?>
                    <input type="text" value="<?php echo $start_design_link; ?>" id="start_design_link"><button class="button" onclick="copyLink()"><?php _e('Copy link', 'web-to-print-online-designer'); ?></button>
                    <?php endif; ?>
                </div>                
            </div>
        </div>
    </div>
    <div>
        <div class="postbox">   
            <h2 style="border-bottom: 1px solid #ddd;"><?php _e('List Etsy order', 'web-to-print-online-designer'); ?></h2>
            <div class="inside">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
                    <?php
                        $etsy_orders->prepare_items();
                        $etsy_orders->display();
                    ?>
                    </form>
                </div>
            </div>
        </div>
    </div>            
</div>
<script type="text/javascript">
    function copyLink(){
        var copyText = document.getElementById("start_design_link");
        copyText.select();
        document.execCommand("copy");  
    }
    jQuery(document).ready(function(){
        
    });
</script>
