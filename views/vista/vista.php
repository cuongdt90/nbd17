<?php

$hide_on_mobile = nbdesigner_get_option('nbdesigner_disable_on_smartphones');
$lang_code = str_replace('-', '_', get_locale());
$locale = substr($lang_code, 0, 2);
$product_id = (isset($_GET['product_id']) &&  $_GET['product_id'] != '') ? absint($_GET['product_id']) : 0;
$variation_id = (isset($_GET['variation_id']) &&  $_GET['variation_id'] != '') ? absint($_GET['variation_id']) : nbd_get_default_variation_id( $product_id );
$default_font = nbd_get_default_font();
$_default_font = str_replace(" ", "+", json_decode($default_font)->alias);


$lang_code = str_replace('-', '_', get_locale());
$product_id = get_the_ID();
$enableColor = nbdesigner_get_option('nbdesigner_show_all_color');
$enable_upload_multiple = nbdesigner_get_option('nbdesigner_upload_multiple_images');
$task = (isset($_GET['task']) &&  $_GET['task'] != '') ? $_GET['task'] : 'new';
$task2 = (isset($_GET['task2']) &&  $_GET['task2'] != '') ? $_GET['task2'] : '';
$design_type = (isset($_GET['design_type']) &&  $_GET['design_type'] != '') ? $_GET['design_type'] : '';
$nbd_item_key = (isset($_GET['nbd_item_key']) &&  $_GET['nbd_item_key'] != '') ? $_GET['nbd_item_key'] : '';
$nbu_item_key = (isset($_GET['nbu_item_key']) &&  $_GET['nbu_item_key'] != '') ? $_GET['nbu_item_key'] : '';
$cart_item_key = (isset($_GET['cik']) &&  $_GET['cik'] != '') ? $_GET['cik'] : '';
$reference = (isset($_GET['reference']) &&  $_GET['reference'] != '') ? $_GET['reference'] : '';
$ui_mode = is_nbd_design_page() ? 2 : 1;/*1: iframe popup, 2: custom page, 3: studio*/
$redirect_url = (isset($_GET['rd']) &&  $_GET['rd'] != '') ? $_GET['rd'] : (($task == 'new' && $ui_mode == 2) ? wc_get_cart_url() : '');
$_enable_upload = get_post_meta($product_id, '_nbdesigner_enable_upload', true);
$_enable_upload_without_design = get_post_meta($product_id, '_nbdesigner_enable_upload_without_design', true);
$enable_upload = $_enable_upload ? 2 : 1;
$enable_upload_without_design = $_enable_upload_without_design ? 2 : 1;
$_product = wc_get_product( $product_id );
$product_type = $_product->get_type();
$show_variation = ( (!isset($_GET['variation_id']) || $_GET['variation_id'] == '') && $product_type == 'variable' && $ui_mode == 2 && $task == 'new' ) ? 1 : 0;
if( $task == 'reup' ){
    $list_file_upload = nbd_get_upload_files_from_session( $nbu_item_key );
}else {
    $list_file_upload = '';
}
$variation_id = 0;
$home_url = $icl_home_url = untrailingslashit(get_option('home'));
$is_wpml = 0;
$font_url = NBDESIGNER_FONT_URL;
if ( function_exists( 'icl_get_home_url' ) ) {
    $icl_home_url = untrailingslashit(icl_get_home_url());
    $is_wpml = 1;
    $font_url = str_replace(untrailingslashit(get_option('home')), untrailingslashit(icl_get_home_url()), $font_url);
}
?>
<script type="text/javascript">
    var NBDESIGNCONFIG = {
        lang_code   :   "<?php echo $lang_code; ?>",
        lang_rtl    :   "<?php if(is_rtl()){ echo 'rtl'; } else {  echo 'ltr';  } ?>",
        is_mobile   :   "<?php echo wp_is_mobile(); ?>",
        ui_mode   :   "<?php echo $ui_mode; ?>",
        show_variation   :   "<?php echo $show_variation; ?>",
        enable_upload   :   "<?php echo $enable_upload; ?>",
        enable_upload_without_design   :   "<?php echo $enable_upload_without_design; ?>",
        stage_dimension :   {'width' : 500, 'height' : 500},
        nbd_content_url    :   "<?php echo NBDESIGNER_DATA_URL; ?>",
        font_url    :   "<?php echo $font_url; ?>",
        art_url    :   "<?php echo NBDESIGNER_ART_URL; ?>",
        is_designer :  <?php if(current_user_can('edit_nbd_template')) echo 1; else echo 0; ?>,
        assets_url  :   "<?php echo NBDESIGNER_PLUGIN_URL . 'assets/'; ?>",
        plg_url  :   "<?php echo NBDESIGNER_PLUGIN_URL; ?>",
        ajax_url    : "<?php echo admin_url('admin-ajax.php'); ?>",
        nonce   :   "<?php echo wp_create_nonce('save-design'); ?>",
        nonce_get   :   "<?php echo wp_create_nonce('nbdesigner-get-data'); ?>",
        instagram_redirect_uri    : "<?php echo NBDESIGNER_PLUGIN_URL.'includes/auth-instagram.php'; ?>",
        dropbox_redirect_uri    : "<?php echo NBDESIGNER_PLUGIN_URL.'includes/auth-dropbox.php'; ?>",
        cart_url    :   "<?php echo esc_url( wc_get_cart_url() ); ?>",
        task    :   "<?php echo $task; ?>",
        task2    :   "<?php echo $task2; ?>",
        design_type    :   "<?php echo $design_type; ?>",
        product_id  :   "<?php echo $product_id; ?>",
        variation_id  :   "<?php echo $variation_id; ?>",
        product_type  :   "<?php echo $product_type; ?>",
        redirect_url    :   "<?php echo $redirect_url; ?>",
        nbd_item_key    :   "<?php echo $nbd_item_key; ?>",
        nbu_item_key    :   "<?php echo $nbu_item_key; ?>",
        cart_item_key    :   "<?php echo $cart_item_key; ?>",
        home_url    :   "<?php echo $home_url; ?>",
        icl_home_url    :   "<?php echo $icl_home_url; ?>",
        is_logged    :   <?php echo nbd_user_logged_in(); ?>,
        is_wpml	:	<?php echo $is_wpml; ?>,
        enable_upload_multiple	:   "<?php echo $enable_upload_multiple; ?>",
        login_url   :   "<?php echo esc_url( wp_login_url( getUrlPageNBD('redirect') ) ); ?>",
        list_file_upload    :   <?php echo json_encode($list_file_upload); ?>,
        product_data  :   <?php echo json_encode(nbd_get_product_info( $product_id, $variation_id, $nbd_item_key, $task, $task2, $reference )); ?>,
        fonts: <?php echo nbd_get_fonts(); ?>,
        subsets: <?php echo json_encode(nbd_font_subsets()); ?>,
        fbID: "<?php echo $fbID; ?>",
        nbd_create_own_page: "<?php echo getUrlPageNBD('create'); ?>",
        enable_dropbox: false,
        default_font: <?php echo $default_font; ?>,
        templates: <?php echo json_encode(nbd_get_resorce_templates($product_id, $variation_id)); ?>,
        nbdlangs: {
            alert_upload_term: "<?php _e('Please accept the upload term conditions', 'web-to-print-online-designer'); ?>"
        }
    };
    NBDESIGNCONFIG['default_variation_id'] = NBDESIGNCONFIG['variation_id'];
    <?php
    $settings = nbdesigner_get_all_frontend_setting();
    foreach ($settings as $key => $val):
    if(is_numeric($val)):
    ?>
    NBDESIGNCONFIG['<?php echo $key; ?>'] = <?php echo $val; ?>;
    <?php else: ?>
    NBDESIGNCONFIG['<?php echo $key; ?>'] = "<?php echo $val; ?>";
    <?php endif; ?>
    <?php endforeach; ?>
    var _colors = NBDESIGNCONFIG['nbdesigner_hex_names'].split(','),
        colorPalette = [], row = [];
    __colorPalette = [];
    for(var i=0; i < _colors.length; ++i) {
        var color = _colors[i].split(':')[0];
        row.push(color);
        if(i % 10 == 9){
            colorPalette.push(row);
            row = [];
        }
        __colorPalette.push(color);
    }
    row.push(NBDESIGNCONFIG['nbdesigner_default_color']);
    colorPalette.push(row);
    <?php if($ui_mode == 1): ?>
    nbd_window = window.parent;
    <?php else: ?>
    nbd_window = window;
    <?php endif; ?>
    var NBDESIGNLANG = <?php echo json_encode(nbd_get_language( $lang_code ));  ?>
</script>

<div ng-app="nbd-app" class="nbd-mode-vista <?php echo (is_rtl()) ? 'nbd-rlt' : ''?>">
    <div ng-controller="designCtrl" ng-cloak>
        <div id="design-container">
            <div class="container-fluid" id="designer-controller">
                <div class="nbd-vista">
                    <div class="main-vista">
                        <?php include "toolbar.php";?>
                        <div class="v-workspace">
                            <?php include "sidebar.php";?>
                            <?php include "layout.php";?>
                            <?php include "warning.php"; ?>
                            <?php include "toasts.php";?>
                            <?php include "toollock.php";?>
                        </div>
                    </div>
                    <?php include 'popup.php';?>
                    <?php include 'context-menu.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
