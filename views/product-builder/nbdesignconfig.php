<?php
$hide_on_mobile = nbdesigner_get_option('nbdesigner_disable_on_smartphones');
$lang_code = str_replace('-', '_', get_locale());
$locale = substr($lang_code, 0, 2);
$product_id = (isset($_GET['product_id']) &&  $_GET['product_id'] != '') ? absint($_GET['product_id']) : 0;
$variation_id = (isset($_GET['variation_id']) &&  $_GET['variation_id'] != '') ? absint($_GET['variation_id']) : nbd_get_default_variation_id( $product_id );

$lang_code = str_replace('-', '_', get_locale());
$product_id = get_the_ID();
$task = (isset($_GET['task']) &&  $_GET['task'] != '') ? $_GET['task'] : 'new';
$nbd_item_key = (isset($_GET['nbd_item_pb_key_']) &&  $_GET['nbd_item_pb_key_'] != '') ? $_GET['nbd_item_pb_key_'] : '';
$cart_item_key = (isset($_GET['cik']) &&  $_GET['cik'] != '') ? $_GET['cik'] : '';
$ui_mode = is_nbd_design_page() ? 2 : 1;/*1: iframe popup, 2: custom page, 3: studio*/
$redirect_url = (isset($_GET['rd']) &&  $_GET['rd'] != '') ? $_GET['rd'] : (($task == 'new' && $ui_mode == 2) ? wc_get_cart_url() : '');
$_product = wc_get_product( $product_id );
$product_type = $_product->get_type();
$show_variation = ( (!isset($_GET['variation_id']) || $_GET['variation_id'] == '') && $product_type == 'variable' && $ui_mode == 2 && $task == 'new' ) ? 1 : 0;
$variation_id = 0;
$home_url = $icl_home_url = untrailingslashit(get_option('home'));
$is_wpml = 0;
$font_url = NBDESIGNER_FONT_URL;
if ( function_exists( 'icl_get_home_url' ) ) {
    $icl_home_url = untrailingslashit(icl_get_home_url());
    $is_wpml = 1;
    $font_url = str_replace(untrailingslashit(get_option('home')), untrailingslashit(icl_get_home_url()), $font_url);
}

$fbID = nbdesigner_get_option('nbdesigner_facebook_app_id');
?>

<script type="text/javascript">
    var NBDESIGNCONFIG = {
        lang_code   :   "<?php echo $lang_code; ?>",
        lang_rtl    :   "<?php if(is_rtl()){ echo 'rtl'; } else {  echo 'ltr';  } ?>",
        is_mobile   :   "<?php echo wp_is_mobile(); ?>",
        ui_mode   :   "<?php echo $ui_mode; ?>",
        stage_dimension :   {'width' : 500, 'height' : 500},
        is_designer :  <?php if(current_user_can('edit_nbd_template')) echo 1; else echo 0; ?>,
        assets_url  :   "<?php echo NBDESIGNER_PLUGIN_URL . 'assets/'; ?>",
        plg_url  :   "<?php echo NBDESIGNER_PLUGIN_URL; ?>",
        ajax_url    : "<?php echo admin_url('admin-ajax.php'); ?>",
        nonce   :   "<?php echo wp_create_nonce('save-design'); ?>",
        nonce_get   :   "<?php echo wp_create_nonce('nbdesigner-get-data'); ?>",
        cart_url    :   "<?php echo esc_url( wc_get_cart_url() ); ?>",
        task    :   "<?php echo $task; ?>",
        product_id  :   "<?php echo $product_id; ?>",
        product_type  :   "<?php echo $product_type; ?>",
        redirect_url    :   "<?php echo $redirect_url; ?>",
        nbd_item_key    :   "<?php echo $nbd_item_key; ?>",
        cart_item_key    :   "<?php echo $cart_item_key; ?>",
        home_url    :   "<?php echo $home_url; ?>",
        icl_home_url    :   "<?php echo $icl_home_url; ?>",
        is_logged    :   <?php echo nbd_user_logged_in(); ?>,
        is_wpml	:	<?php echo $is_wpml; ?>,
        login_url   :   "<?php echo esc_url( wp_login_url( getUrlPageNBD('redirect') ) ); ?>",
        product_data  :   <?php echo json_encode(nbd_get_product_builder_info( $product_id, $variation_id, $nbd_item_key, $task)); ?>,
        templates: <?php echo json_encode(nbd_get_resource_templates($product_id, $variation_id)); ?>,
        nbdlangs: {
            alert_upload_term: "<?php _e('Please accept the upload term conditions', 'web-to-print-online-designer'); ?>"
        }
    };
    <?php if($ui_mode == 1): ?>
    nbd_window = window.parent;
    <?php else: ?>
    nbd_window = window;
    <?php endif; ?>
    var NBDESIGNLANG = <?php echo json_encode(nbd_get_language( $lang_code ));  ?>
</script>
