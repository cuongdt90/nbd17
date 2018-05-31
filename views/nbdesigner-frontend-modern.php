<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<!DOCTYPE html>
<?php
    $hide_on_mobile = nbdesigner_get_option('nbdesigner_disable_on_smartphones');
    $lang_code = str_replace('-', '_', get_locale());
    $locale = substr($lang_code, 0, 2);
    $product_id = (isset($_GET['product_id']) &&  $_GET['product_id'] != '') ? absint($_GET['product_id']) : 0;
    $variation_id = (isset($_GET['variation_id']) &&  $_GET['variation_id'] != '') ? absint($_GET['variation_id']) : nbd_get_default_variation_id( $product_id ); 
    if( !nbd_is_product($product_id) ){
        echo sprintf('<p>%s, <a href="%s">%s</a></p>', 
                __('No product has been selected', 'web-to-print-online-designer'),
                esc_url( home_url( '/' ) ),
                __('Back', 'web-to-print-online-designer') );
        die();
    }
    if(wp_is_mobile() && $hide_on_mobile == 'yes'):      
    nbdesigner_get_template('mobile.php', array('lang_code' => $lang_code));    
    else: 
    if( !nbd_check_permission() ):
    nbdesigner_get_template('permission.php');    
    else:     
?>
<html lang="<?php echo $lang_code; ?>">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <title><?php echo get_bloginfo( 'name' ); ?> - Online Designer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=0.5, maximum-scale=1.0"/>
        <meta content="Online Designer - HTML5 Designer - Online Print Solution" name="description" />
        <meta content="Online Designer" name="keywords" />
        <meta content="Netbaseteam" name="author">
        
        <?php
            if( nbdesigner_get_option('nbdesigner_share_design') == 'yes' && isset( $_GET['nbd_share_id'] ) && $_GET['nbd_share_id'] != '' ):
                $folder = $_GET['nbd_share_id'];
                $path = NBDESIGNER_CUSTOMER_DIR . '/' . $folder ;
                $images = Nbdesigner_IO::get_list_images($path, 1);
                $product = wc_get_product( $variation_id ? $variation_id : $product_id );
                if( count($images) ){
                    $image_url = Nbdesigner_IO::wp_convert_path_to_url( reset($images) );            
                }      
                if( isset( $_GET['nbd_share_id'] ) && $_GET['nbd_share_id'] != '' ){
                    $url = add_query_arg(
                        array(
                            't'    => $_GET['t'], 
                            'product_id'    =>  $product_id,
                            'variation_id'   =>  $variation_id,
                            'reference'   =>  $_GET['nbd_share_id'],
                            'nbd_share_id'  =>  $_GET['nbd_share_id']),
                        getUrlPageNBD('create'));  
                }
        ?>
        <meta property="og:locale" content="<?php echo $lang_code; ?>">
        <meta property="og:type" content="article">
        <meta property="og:title" content="<?php echo $product->get_name(); ?>">
        <meta property="og:description" content="<?php echo get_bloginfo( 'description' ); ?>">        
        <meta property="og:url" content="<?php echo $url; ?>">
        <meta property="og:site_name" content="<?php echo get_bloginfo( 'name' ); ?>">
        <meta property="og:image" content="<?php echo $image_url; ?>" />
        <meta property="og:image:width" content="500">
        <meta property="og:image:height" content="400">
        <?php endif; ?>
        
        <link type="text/css" href="<?php echo NBDESIGNER_PLUGIN_URL .'assets/css/jquery-ui.min.css'; ?>" rel="stylesheet" media="all" />
        <link href='https://fonts.googleapis.com/css?family=Poppins:400,100,300italic,300' rel='stylesheet' type='text/css'>
        <link type="text/css" href="<?php echo NBDESIGNER_PLUGIN_URL .'assets/css/bootstrap.min.css'; ?>" rel="stylesheet" media="all"/>
        <link type="text/css" href="<?php echo NBDESIGNER_PLUGIN_URL .'assets/css/bundle.css'; ?>" rel="stylesheet" media="all"/>
        <link type="text/css" href="<?php echo NBDESIGNER_PLUGIN_URL .'assets/css/tooltipster.bundle.min.css'; ?>" rel="stylesheet" media="all"/>
        <link type="text/css" href="<?php echo NBDESIGNER_PLUGIN_URL .'assets/css/modern.css'; ?>" rel="stylesheet" media="all">
        <?php $custom_css_url = file_exists( NBDESIGNER_DATA_DIR . '/custom.css' ) ? NBDESIGNER_DATA_URL .'/custom.css' : NBDESIGNER_PLUGIN_URL .'assets/css/custom.css'; ?>
        <link type="text/css" href="<?php echo $custom_css_url; ?>" rel="stylesheet" media="all">
        <link type="text/css" href="<?php echo NBDESIGNER_PLUGIN_URL .'assets/css/spectrum.css'; ?>" rel="stylesheet" media="all">
        <?php if(is_rtl()): ?>
        <link type="text/css" href="<?php echo NBDESIGNER_PLUGIN_URL .'assets/css/modern-rtl.css'; ?>" rel="stylesheet" media="all">
        <?php endif; ?>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->	
        <?php 
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
                product_data  :   <?php echo json_encode(nbd_get_product_info( $product_id, $variation_id, $nbd_item_key, $task, $task2, $reference )); ?>
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
    </head>

    <body ng-app="nbd-app" class="nbd-mode-modern nbd-mode-<?php echo $ui_mode; ?> <?php echo (is_rtl()) ? 'nbd-modern-rtl' : '';?>">
        <div style="width: 100%; height: 100%;" ng-controller="designCtrl" ng-click="wraperClickHandle($event)" keypress ng-cloak>
            <div id="design-container">
                <div class="container-fluid" id="designer-controller">
                    <div class="nbd-navigations">
                        <?php include 'modern/main-bar.php';?>
                    </div>
                    <div class="nbd-workspace">
                        <?php include 'modern/sidebar.php';?>
                        <div class="main">
                            <?php include 'modern/toolbar.php'; ?>
                            <?php include 'modern/stages.php';?>
                            <?php include 'modern/toolbar-zoom.php';?>
                            <?php include 'modern/context-menu.php'?>
                            <div class="nbd-signal animated slideInUp">
                                <a target="_blank" href="https://cmsmart.net/wordpress-plugins/woocommerce-online-product-designer-plugin">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             width="20px" height="20px" viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
                                    <style type="text/css">
                                            .st0{fill:#C74A9B;}
                                            .st1{fill:#010101;}
                                            .st2{fill:#E3D443;}
                                            .st3{fill:#647DBE;}
                                            .st4{fill:#515567;}
                                    </style>
                                    <path class="st0" d="M10.6,13l0,2c2.2-0.3,3.9-2.1,4.3-4.3h-2C12.6,11.8,11.7,12.7,10.6,13z"/>
                                    <path class="st1" d="M14.9,9.3c0,0,0-0.1,0-0.1L14.9,9.3L14.9,9.3z"/>
                                    <path class="st2" d="M6.8,10.8h-2C5.2,13,7,14.7,9.2,15v-2C8,12.8,7.1,11.9,6.8,10.8z"/>
                                    <path class="st3" d="M9.2,6.9l0-1.9c-2.2,0.3-4,2.1-4.3,4.3l1.9,0C7,8.1,8,7.2,9.2,6.9z"/>
                                    <path class="st4" d="M14.9,9.2l0-5l0-2.6c-0.8-0.5-1.6-0.8-2.5-1l0,2.2l0,2.8C13.7,6.3,14.6,7.6,14.9,9.2z"/>
                                    <path class="st4" d="M12.4,8.1c0.3,0.3,0.4,0.7,0.5,1.2l2,0V9.2c-0.3-1.5-1.2-2.9-2.5-3.6c-0.5-0.3-1.1-0.5-1.7-0.6l0,2
                                            C11.3,7.1,11.9,7.6,12.4,8.1z"/>
                                    <path class="st4" d="M9.9,19.6c5.4,0,9.7-4.3,9.7-9.7c0-3.5-1.9-6.6-4.7-8.3l0,2.6c1.6,1.4,2.7,3.5,2.7,5.8c0,4-3,7.2-6.9,7.6
                                            c-0.2,0-0.5,0-0.7,0c-0.3,0-0.5,0-0.8,0c-3.8-0.4-6.8-3.6-6.8-7.6c0-4.1,3.3-7.5,7.4-7.6l0-2.1C4.5,0.3,0.3,4.6,0.3,9.9
                                            C0.2,15.3,4.6,19.6,9.9,19.6z"/>
                                    <rect x="9.9" y="4.4" transform="matrix(-1 -3.267878e-07 3.267878e-07 -1 19.8086 20.0035)" class="st4" width="0.1" height="11.1"/>
                                    <rect x="9.9" y="4.4" transform="matrix(3.267741e-07 -1 1 3.267741e-07 -9.740747e-02 19.906)" class="st4" width="0.1" height="11.1"/>
                                    </svg>     
                                    &copy;Netbase
                                </a>
                            </div>
                        </div>
                        <?php include 'modern/toollock.php';?>
                    </div>
                </div>	
            </div>
            <?php include 'modern/popup.php';?>
            <?php include 'modern/loading-page.php';?>
            <?php include 'modern/toasts.php';?>            
        </div>

        <?php if(!NBDESIGNER_MODE_DEV): ?>
        <script type='text/javascript' src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <?php else: ?>
        <script type='text/javascript' src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/libs/jquery.min.js'; ?>"></script>
        <?php endif; ?>
        <?php if(!NBDESIGNER_MODE_DEV): ?>
        <script type='text/javascript' src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
        <?php else: ?>
        <script type='text/javascript' src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/libs/jquery-ui.min.js'; ?>"></script>
        <?php endif; ?>
        <?php if(!NBDESIGNER_MODE_DEV): ?>
        <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
        <?php else: ?>
        <script type='text/javascript' src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/libs/angular.min.js'; ?>"></script>
        <?php endif; ?>
        <script type="text/javascript" src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/js/app-modern.min.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/js/bundle-modern.min.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/js/add-to-cart-variation.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/js/designer-modern.min.js'; ?>"></script>

    </body>
</html>
<?php endif; endif;?>