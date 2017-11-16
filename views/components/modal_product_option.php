<?php if (!defined('ABSPATH')) exit; 
$_product = wc_get_product( $product_id );
if($_product->is_type( 'variable' )){
    $attributes = $_product->get_variation_attributes();
    $available_variations = $_product->get_available_variations();
    $selected_attributes = $_product->get_default_attributes();
    $attribute_keys = array_keys( $attributes );

?>
<div class="modal fade" id="dg-product-option">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding-bottom: 15px;">
                <b>{{(langs['CHOOSE_VARIATION']) ? langs['CHOOSE_VARIATION'] : "Choose variation"}}</b>
                <button style="margin-top: 0;" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>						
            </div>
            <div class="modal-body" style="padding: 15px;">
                <form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $_product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>">

                    <table class="variations" cellspacing="0">
                        <tbody>
                            <?php foreach ($attributes as $attribute_name => $options) : ?>
                                <tr>
                                    <td class="label"><label for="<?php echo sanitize_title($attribute_name); ?>"><?php echo wc_attribute_label($attribute_name); ?></label></td>
                                    <td class="value">
                                        <?php
                                        $selected = isset($_REQUEST['attribute_' . sanitize_title($attribute_name)]) ? wc_clean(stripslashes(urldecode($_REQUEST['attribute_' . sanitize_title($attribute_name)]))) : $_product->get_variation_default_attribute($attribute_name);
                                        wc_dropdown_variation_attribute_options(array('options' => $options, 'attribute' => $attribute_name, 'product' => $_product, 'selected' => $selected));
                                        echo end($attribute_keys) === $attribute_name ? apply_filters('woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__('Clear', 'woocommerce') . '</a>') : '';
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <input type="hidden" name="variation_id" class="variation_id" value="0" />
                </form>    
            </div>
        </div>
    </div>
</div>
<?php  }  ?>