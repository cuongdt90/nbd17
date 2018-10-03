<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<!DOCTYPE html>
<?php
    $hide_on_mobile = nbdesigner_get_option('nbdesigner_disable_on_smartphones');
    $lang_code = str_replace('-', '_', get_locale());
    $locale = substr($lang_code, 0, 2);
    $product_id = (isset($_GET['product_id']) &&  $_GET['product_id'] != '') ? absint($_GET['product_id']) : 0;
    $variation_id = (isset($_GET['variation_id']) &&  $_GET['variation_id'] != '') ? absint($_GET['variation_id']) : nbd_get_default_variation_id( $product_id ); 
    $default_font = nbd_get_default_font();
    $_default_font = str_replace(" ", "+", json_decode($default_font)->alias);
    $_product = wc_get_product( $product_id );
    $product_type = $_product->get_type();  
    $task = (isset($_GET['task']) &&  $_GET['task'] != '') ? $_GET['task'] : 'new';
    $task2 = (isset($_GET['task2']) &&  $_GET['task2'] != '') ? $_GET['task2'] : '';    
    $ui_mode = is_nbd_design_page() ? 2 : 1;/*1: iframe popup, 2: custom page, 3: studio*/
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
    $option_id = get_post_meta($product_id, '_nbo_option_id', true);
    $show_nbo_option =  (($option_id || $product_type == 'variable') && $ui_mode == 2 && $task == 'new' ) ? true : false;
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
        <link href='https://fonts.googleapis.com/css?family=<?php echo $_default_font; ?>:400,400i,700,700i' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Poppins:400,400i,700,700i' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i' rel='stylesheet' type='text/css'>
        <link type="text/css" href="<?php echo NBDESIGNER_PLUGIN_URL .'assets/css/bootstrap.min.css'; ?>" rel="stylesheet" media="all"/>
<!--        <link type="text/css" href="<?php echo NBDESIGNER_PLUGIN_URL .'assets/css/bundle.css'; ?>" rel="stylesheet" media="all"/>-->
        <link type="text/css" href="<?php echo NBDESIGNER_PLUGIN_URL .'assets/css/tooltipster.bundle.min.css'; ?>" rel="stylesheet" media="all"/>
        <link type="text/css" href="<?php echo NBDESIGNER_PLUGIN_URL .'assets/css/perfect-scrollbar.min.css'; ?>" rel="stylesheet" media="all">
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
        <style type="text/css">
            .stage-background, .design-zone, .stage-grid, .bounding-layers, .stage-snapLines, .stage-overlay, .stage-guideline {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
            .stage-background, .stage-grid, .bounding-layers, .stage-snapLines, .stage-overlay, .stage-guideline {
                pointer-events: none;
            }
            .nbd-stages .stage {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }
            .stage.hidden {
                opacity: 0;
                z-index: 0;
                -webkit-transform: translate3d(0, -100%, 0);
                transform: translate3d(0, -100%, 0);
            }  
            .nbd-stages .stage .page-toolbar .page-main ul li.disabled {
                opacity: .3;
                pointer-events: none;
            }  
            .bounding-layers-inner,
            .stage-snapLines-inner {
                position: relative;
                width: 100%;
                height: 100%;
            }
            .bounding-rect {
                position: absolute;
                display: inline-block;
                visibility: hidden;
                top: -20px;
                left: -20px;
                width: 10px;
                height: 10px;
                border: 1px dashed #ddd;
                transform-origin: 0% 0%;
            }
            .nbd-sidebar #tab-typography .tab-main .typography-body .typography-item {
                cursor: pointer;
            }
            .text-heading {
                font-size: 40px;
                font-weight: 700;        
            }
            .text-sub-heading {
                font-size: 24px;
                font-weight: 500;        
            } 
            .text-heading, .text-sub-heading, .text-body {
                color: #4F5467;
                cursor: pointer;
                display: block;
            }

            .nbd-input {
                border: none;
            }
            .nbd-sidebar #tab-photo .result-loaded .content-items div[data-type=image-upload] .form-upload i {
                vertical-align: middle;
                margin-right: 5px;     
                color: #404762;
            }
            .nbd-sidebar #tab-photo .result-loaded .content-items div[data-type=image-upload] .form-upload   {
                border: 2px dashed #fff;
                padding: 30px 10px;        
            } 
            .nbd-sidebar #tab-photo .result-loaded .content-items div[data-type=image-upload] .form-upload i:before,
            .nbd-sidebar #tab-photo .result-loaded .content-items div[data-type=image-upload] .form-upload{
                color: #404762;
                font-weight: bold;
            }
            .layer-coordinates {
                position: absolute;
                display: inline-block;
                font-size: 9px;
                font-family: monospace;
                color: #404762;   
                visibility: hidden;
                transform: translate(calc(-100% - 10px), calc(-100% + 5px));
                text-shadow: 1px 1px #fff;
            }
            .layer-angle {
                position: absolute;
                display: inline-block;
                font-family: monospace;
                color: #404762;   
                visibility: hidden;
                text-shadow: 1px 1px #fff;        
            }
            .layer-angle span {
                font-size: 9px !important;
                display: inline-block;
            }
            .snapline {
                position: absolute;
            }
            .h-snapline {
                top: -9999px;
                left: -20px;
                width: calc(100% + 40px);
                height: 3px !important;
                background-image: linear-gradient(to right,rgba(214,96,96,.95) 1px,transparent 1px);
                background-size: 2px 1px;
                background-repeat: repeat-x;     
            }
            .v-snapline {
                left: -9999px;
                top: -20px;
                height: calc(100% + 40px);
                width: 3px!important;
                background-image: linear-gradient(to bottom,rgba(214,96,96,.95) 1px,transparent 1px);
                background-size: 1px 2px;
                background-repeat: repeat-y;
            }   
            .nbd-main-menu button.menu-item.disabled, .nbd-main-menu li.menu-item.disabled {
                pointer-events: none;
                opacity: 0.3;
            }
            .nbd-disabled {
                pointer-events: none;
                opacity: 0.3;
            }
            .color-palette-add {
                position: relative;
            }
            .color-palette-add:after {
                position: absolute;
                top: 0;
                left:0;
                width: 40px;
                height: 40px;  
                display: inline-block;
                line-height: 40px;
                content: "\e908";
                text-align: center;
                color: #404762;
                font-family: online-design!important;
                font-size: 20px;
                text-shadow: 1px 1px 1px #fff;
            }
            .nbd-text-color-picker {
                position: absolute; 
                left: 40px; 
                top: 50px;
                -webkit-transform: scale(.8);
                -ms-transform: scale(.8);
                transform: scale(.8); 
                visibility: hidden;
                opacity: 0;
                -webkit-transition: all .3s;
                -moz-transition: all .3s;        
                transition: all .3s; 
                -webkit-box-shadow: 1px 0 15px rgba(0,0,0,.2);    
                box-shadow: 1px 0 15px rgba(0,0,0,.2);    
                background-color: #fff;
                overflow: hidden;
            }
            .nbd-text-color-picker.active {
                opacity: 1;
                visibility: visible;
                -webkit-transform: scale(1);
                -ms-transform: scale(1);
                transform: scale(1);        
            }
            .nbd-color-palette {
                opacity: 0;
                display: block !important;
                visibility: hidden;
                -webkit-transform: scale(0.8);
                -ms-transform: scale(0.8);
                transform: scale(0.8);  
                -webkit-transition: all .4s;
                -moz-transition: all .4s;        
                transition: all .4s;         
            }
            .nbd-color-palette-inner .nbd-perfect-scroll{
                max-height: 185px;
            }
            .nbd-color-palette.show {
                opacity: 1;
                visibility: visible;
                -webkit-transform: scale(1);
                -ms-transform: scale(1);
                transform: scale(1);           
            }    
            .nbd-sp.sp-container {
                box-shadow: none;
            }
            .nbd-text-color-picker .nbd-button {
                margin-top: 0;
                margin-left: 11px;
                margin-bottom: 10px;        
            }
            .nbd-workspace .main {
                overflow: hidden;
            }
            .tab-main .loading-photo {
                position: absolute;
                z-index: 99;
                left: 50%;
                -webkit-transform: translateX(-50%);
                -ms-transform: translateX(-50%);
                transform: translateX(-50%);
            }    
            .nbd-sidebar #tab-typography .tab-main .typography-body .typography-item {
                opacity: 0;
                -webkit-transition: all 0.4s;
                -moz-transition: all 0.4s;
                -ms-transition: all 0.4s;
                transition: all 0.4s;
            }
            .nbd-sidebar #tab-typography .tab-main .typography-body .typography-item.in-view {
                opacity: 1;
            }
            .nbd-sidebar #tab-typography .tab-main .typography-body .typography-item img {
                background: none;
            }
            .popup-share.nbd-popup .overlay-main {
                background: rgba(255,255,255,0.85);
            }
            .nbd-tool-lock {
                top: 50px;
            }
            .nbd-toolbar .toolbar-text .nbd-main-menu.menu-left .menu-item .sub-menu>div#toolbar-font-size-dropdown {
                max-height: 240px;
            } 
            .nbd-toolbar .toolbar-text .nbd-main-menu.menu-right .sub-menu ul li.selected {
                background-color: rgba(158,158,158,.2);
            }
            .design-wrap {
                position: absolute;
            }
            .nbd-toasts .toast {
                -webkit-box-shadow: 0 5px 5px -3px rgba(0,0,0,.2), 0 8px 10px 1px rgba(0,0,0,.14), 0 3px 14px 2px rgba(0,0,0,.12);
                box-shadow: 0 5px 5px -3px rgba(0,0,0,.2), 0 8px 10px 1px rgba(0,0,0,.14), 0 3px 14px 2px rgba(0,0,0,.12);
            }
            .nbd-context-menu .main-context .contexts .context-item i {
                width: 21px;
            }
            .nbd-context-menu .main-context .contexts .context-item i sub{
                right: 5px;
            }
            .nbd-context-menu .main-context .contexts .context-item.active i {
                color: red;
            }            
            @keyframes timeline {
                0% {
                    background-position: -350px 0;
                }
                100% {
                    background-position: 400px 0;
                }
            }
            .font-loading {
                animation: timeline;
                animation-duration: 1s;
                animation-timing-function: linear;
                animation-iteration-count: infinite;
                background: linear-gradient(to right, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
                background-size: 800px auto;
                background-position: 100px 0;
                pointer-events: none;
                opacity: 0.7;
            }
            .group-font li {
                cursor: pointer;
            }
            .nbd-main-menu .sub-menu li span.font-name-wrap {
                line-height: 40px;
                width: 100%;
                display: flex;
                justify-content: space-between;
            }
            .nbd-main-menu .sub-menu li span.font-name {
                margin-right: 10px;
                font-size: 18px;
            }
            .nbd-main-menu .sub-menu li .font-selected {
                line-height: 40px;
                margin-left: 5px;
                color: #404762;
            }
            .toolbar-font-search i.icon-nbd-clear {
                position: absolute;
                right: 15px;
                top: 10px;
                width: 24px;
                height: 33px;
                line-height: 33px;
                cursor: pointer;
            }
            .clipart-wrap .clipart-item,
            .mansory-wrap .mansory-item {
                visibility: visible !important; 
                width: 33.33%;
                padding: 2px;
                opacity: 0;
                z-index: 3;
                cursor: pointer;
            }
            .mansory-wrap{
                margin-top: 15px;
            }
            .clipart-wrap .clipart-item img {
                border: 4px solid rgba(64, 71, 98, 0.08);
                background: #d0d6dd;
                width: 100%;
                min-height: 30px;
            }
            .mansory-wrap .mansory-item.in-view,
            .clipart-wrap .clipart-item.in-view {
                opacity: 1;
            }
            .mansory-wrap .mansory-item .photo-desc {
                position: absolute;
                opacity: 0;
                visibility: hidden;
                -webkit-transform: translateY(50%);
                -ms-transform: translateY(50%);
                transform: translateY(50%);
                -webkit-transition: all .2s;
                transition: all .2s;
                bottom: 2px;
                left: 2px;
                padding: 2px 10px;
                display: block;
                width: -webkit-calc(100% - 4px);
                width: calc(100% - 4px);
                text-align: left;
                background: rgba(0,0,0,.3);
                color: #fff;
                font-size: 10px;        
            }
            .mansory-wrap .mansory-item:hover .photo-desc {
                opacity: 1;
                visibility: visible;
                -webkit-transform: translateY(0);
                -ms-transform: translateY(0);
                transform: translateY(0);        
            }
            .mansory-wrap .mansory-item 
            .nbd-sidebar #tab-svg .cliparts-category {
                margin-top: 70px;
                padding: 0px 10px 10px;        
            }
            .nbd-perfect-scroll {
                position: relative;
                overflow: hidden;        
            }
            .nbd-onload {
                pointer-events: none;
                opacity: 0.7;
            }
            .nbd-color-picker-preview {
                width: 24px;
                height: 24px;
                border-radius: 4px;
                display: inline-block;
                box-shadow: rgba(0, 0, 0, 0.15) 1px 1px 6px inset, rgba(255, 255, 255, 0.25) -1px -1px 0px inset;        
            }
            .nbd-toolbar .main-toolbar .tool-path li.menu-item.item-color-fill {
                margin: 0;
                padding: 2px;
            }
            .nbd-sidebar #tab-photo .nbd-items-dropdown .main-items .items .item[data-type="pixabay"] .main-item .item-icon {
                padding: 10px 20px;
            }
            .nbd-sidebar #tab-photo .nbd-items-dropdown .main-items .items .item[data-type="pixabay"] .main-item .item-icon i {
                font-size: 60px;
            }
            .nbd-sidebar .nbd-items-dropdown .result-loaded .nbdesigner-gallery .nbdesigner-item .photo-desc {
                font-size: 10px;
            }
            .nbd-sidebar #tab-photo .nbd-items-dropdown .loading-photo {
                width: 40px;
                height: 40px;
                position: unset;
                margin-left: 50%;
                margin-top: 20px;        
            }
            .nbd-sidebar .nbd-items-dropdown .info-support {
                left: unset;
            }
            .nbd-sidebar .nbd-items-dropdown .info-support i.close-result-loaded {
                right: 0;
            }
            .nbd-sidebar .nbd-items-dropdown .info-support i, .nbd-sidebar .nbd-items-dropdown .info-support span {
                background: #404762;
            }    
            #tab-photo .ps-scrollbar-x-rail {
                display: none;
            }
            .nbd-sidebar .tabs-content .nbd-search input {
                border: 1px solid #404762;
            }
            .type-instagram.button-login {
                display: flex;
                margin: auto;
                -webkit-box-pack: center;
                -webkit-justify-content: center;
                -ms-flex-pack: center;
                justify-content: center;
                -webkit-box-align: center;
                -webkit-align-items: center;
                -ms-flex-align: center;
                align-items: center;        
            }
            .type-instagram.button-login .icon-nbd {
                color: #fff;
                vertical-align: middle;
                font-size: 20px;
                margin-right: 5px;        
            }
            .type-instagram.button-login span {
                color: #fff;
            }
            .popup-term .head {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 10px;        
            }
            .form-control:focus {
                border-color: rgba(64, 71, 98, 1);
                outline: 0;
                box-shadow: none;
            }    
            .nbd-dnd-file {
                cursor: pointer;
            }
            .nbd-dnd-file.highlight {
                border: 2px dashed rgba(64, 71, 98, 1) !important;
            }
            .nbd-sidebar .tab-scroll{
                -ms-overflow-style:none;
            }
            .nbd-onloading {
                pointer-events: none;
            }  
            .nbd-stages .stage {
                padding: 40px 50px 50px;
                overflow: hidden;
                height: 100%;
                width: 100%;
                position: absolute;
                display: block;
                text-align: center;
                box-sizing: border-box;
            }  
            .nbd-toolbar-zoom {
                bottom: 15px;
            }
            .nbd-toolbar-zoom .zoomer-toolbar .nbd-main-menu {
                box-shadow: 0 1px 3px 0 rgba(0,0,0,.2), 0 1px 1px 0 rgba(0,0,0,.14), 0 2px 1px -1px rgba(0,0,0,.12); 
            }
            .bleed-line, .safe-line {
                box-sizing: border-box;
                position: absolute;
            }
            .bleed-line {
                border: 1px solid red;
            }
            .safe-line {
                border: 1px solid green;
            }   
            .fullScreenMode .design-zone {
                pointer-events: none;
            }
            .fullScreenMode .page-toolbar {
                display: none;
            }
            .fullScreenMode .stage{
                padding: 0;
            }
            .nbd-sidebar #tab-element .main-items .item[data-type=draw] .item-icon i {
                color: #404762;
            }   
            .nbd-sidebar #tab-layer .inner-tab-layer .menu-layer .menu-item.active {
                border: 1px solid #404762;
            }
            .sortable-placeholder {
                border: 3px dashed #aaa;
                height: 50px;
                display: flex;
                margin: 4px;
            }
            .nbd-toolbar .toolbar-text .nbd-main-menu.menu-left .menu-item .toolbar-bottom span {
                line-height: 24px;
            }
            .nbd-sidebar #tab-element .nbd-items-dropdown .content-items .content-item.type-qrcode .main-input input {
                padding: 10px;
            }
            .nbd-hiden {
                visibility: hidden;
            }
            .main-qrcode svg{
                transform: scale(2) translateY(25%);
            }
            .main-qrcode svg path{
                fill: #404762;
            }
            .tab-scroll .ps__scrollbar-x-rail {
                display: none;
            }
            .main-color-palette {
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                -webkit-flex-wrap: wrap;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                -webkit-box-pack: start;
                -webkit-justify-content: flex-start;
                -ms-flex-pack: start;
                justify-content: flex-start;
            }    
            .main-color-palette li {
                list-style: none;
                cursor: pointer;
                width: 40px;
                height: 40px;
                -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,.05), inset -1px -1px 0 rgba(0,0,0,.05);
                box-shadow: inset 1px 1px 0 rgba(0,0,0,.05), inset -1px -1px 0 rgba(0,0,0,.05);
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                color: transparent;
                background-color: currentColor;
                display: inline-block;
            }    
            .nbd-sidebar #tab-product-template #tab-template {
                padding: 0;
            }
            [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
              display: none !important;
            }
            .fullScreenMode .nbd-stages {
                width: 100%;
                background: #000;
            }
            .fullScreenMode .nbd-stages .ps__scrollbar-x-rail,
            .fullScreenMode .nbd-stages .ps__scrollbar-y-rail {
                display: none;
            }
            .fullscreen-stage-nav {
                position: absolute;
                bottom: 40px;
                right: 40px;
                display: none;
            }
            .fullScreenMode .fullscreen-stage-nav {
                display: inline-block;
            }
            .nbd-templates {
                
            }
            .nbd-templates .item .item-img {
                height: auto;
                text-align: center;
            }
            .nbd-templates .item .main-item.global .item-img {
                position: absolute;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;                
            }
            .nbd-templates .item .item-img img {
                vertical-align: top;
                -webkit-transition: all 0.4s;
                -moz-transition: all 0.4s;
                transition: all 0.4s;                
            }
            .nbd-templates .items .item .main-item {
                cursor: pointer;
                -webkit-transition: all 0.4s;
                -moz-transition: all 0.4s;
                transition: all 0.4s;
            }  
            .nbd-templates .items .item .main-item.global {
                position: relative;
                width: 100%;
                padding-top: 100%;                 
            }
            .nbd-templates .items .item .main-item.image-onload {                
                animation: timeline;
                animation-duration: 1s;
                animation-timing-function: linear;
                animation-iteration-count: infinite;
                background: linear-gradient(to right, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
                background-size: 800px auto;
                background-position: 100px 0;
                pointer-events: none;
                opacity: 0.7;                  
            }
            .nbd-templates .items .item .main-item.image-onload img {
                opacity: 0;
            }
            .nbd-templates .items .item .main-item:hover img {
                -webkit-box-shadow: 0 3px 5px -1px rgba(0,0,0,.2), 0 5px 8px 0 rgba(0,0,0,.14), 0 1px 14px 0 rgba(0,0,0,.12);
                box-shadow: 0 3px 5px -1px rgba(0,0,0,.2), 0 5px 8px 0 rgba(0,0,0,.14), 0 1px 14px 0 rgba(0,0,0,.12);
            }            
            .nbd-templates .items .item {
                width: 50%;
                box-sizing: border-box;
                display: inline-block;
                padding: 5px;
            }
            .nbd-mode-1 .nbd-main-bar .logo {
                visibility: hidden;
                width: 0;
            }
            .nbd-popup.popup-share .main-popup .body .share-btn .nbd-button:focus,
            .nbd-popup.popup-share .main-popup .body .share-btn .nbd-button:hover {
                color: #fff;
                text-decoration: none;
            }
            .nbd-sidebar #tab-element .nbd-items-dropdown .content-items .content-item.type-draw .brush .nbd-sub-dropdown ul li.active {
                background-color: #404762;
            }
            .nbd-sidebar #tab-element .nbd-items-dropdown .content-items .content-item.type-draw .brush .nbd-sub-dropdown ul li.active span {
                color: #fff;
            }
            .default-palette .first-left {
                border-top-left-radius: 4px;
            }
            .default-palette .first-right {
                border-top-right-radius: 4px;
            }
            .default-palette .last-left {
                border-bottom-left-radius: 4px;
            }
            .default-palette .last-right {
                border-bottom-right-radius: 4px;
            }   
            .nbd-signal .signal-logo {
                opacity: 0.7;
            }    
            .nbd-sidebar #tab-element .nbd-items-dropdown {
                margin-top: 0;
            }
            .nbd-warning {
                position: absolute;
                top: 60px;                
            }
            .nbd-warning .main-warning {
                box-shadow: 0 5px 5px -3px rgba(0,0,0,.2), 0 8px 10px 1px rgba(0,0,0,.14), 0 3px 14px 2px rgba(0,0,0,.12);
                background: #404762;
                -webkit-transform: unset;
                transform: unset;
            }
            .nbd-warning .main-warning i,
            .nbd-warning .main-warning span {
                color: #fff;
            }
            .nbd-tip {
                position: fixed;
                -webkit-border-radius: 2px;
                border-radius: 2px;
                -webkit-box-shadow: 1px 0 10px rgba(0,0,0,.15);
                box-shadow: 1px 0 10px rgba(0,0,0,.15);
                top: 110px;
                right: 0;
                background: #fff;
                display: flex;
                max-width: 265px;
                -webkit-transition: all 1s;
                -moz-transition: all 1s;
                transition: all 1s;
                transform: translateX(calc(100% - 3px));
                border-left: 3px solid #404762;
                cursor: pointer;                
            }
            .nbd-tip:hover {
                transform: translateX(calc(100% - 70px));
                border-left: none;
            }
            .tip-icon {
                width: 70px;
                padding: 10px;    
                display: flex;
                flex-direction: column;
                justify-content: center;                
            }
            .tip-icon svg{
                width: 50px;
                height: 50px;
            }
            .tip-content p {
                font-size: 12px;
                margin: 0;
            }
            .nbd-tip.nbd-show {
                z-index: 99999999;
                border-left: none;
                transform: translateX(0);
            }
            .tip-content-inner {
                position: relative;
                padding: 10px 10px 10px 0;
            }
            .nbd-tip .icon-nbd-clear {
                cursor: pointer;
                position: absolute;
                font-size: 20px;
                top: 0;
                right: 17px;
            }
            .nbd-sidebar #tab-photo .result-loaded .content-items div[data-type=image-upload] .form-upload i {
                cursor: pointer;
            }
            .nbd-round {
                border-radius: 50%;
                overflow: hidden;
            }
            .nbd-mode-1 .nbd-main-bar .menu-mobile.icon-nbd-menu {
                padding-left: 45px;
            }
            .nbd-sidebar #tab-product-template .tab-main {
                margin-top: 10px;
                height: calc(100% - 10px);
            }    
            .nbd-template-head{
                margin: 0;
                padding: 10px;
                text-align: left;
                font-size: 23px;                
            }
            .tab-scroll .ps__scrollbar-y-rail {
                display: none;
            }
            .nbd-main-bar .logo img {
                min-width: 40px;
                max-width: 140px;
                max-height: 40px;
                width: unset;
            }       
            .nbd-popup.popup-share .main-popup .body .share-with ul.socials li.social {
                opacity: 0.5;
            } 
            .nbd-popup.popup-share .main-popup .body .share-with ul.socials li.social.active {
                opacity: 1;
            }
            .nbd-color-palette .nbd-color-palette-inner .main-color-palette li:hover {
                -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,.05), inset -1px -1px 0 rgba(0,0,0,.05);
                box-shadow: inset 1px 1px 0 rgba(0,0,0,.05), inset -1px -1px 0 rgba(0,0,0,.05);
            } 
            .nbd-sidebar #tab-layer .inner-tab-layer .menu-layer .menu-item.active {
                border: 2px solid #0e9dde;
            }   
            .nbd-load-page {
                width: 100%;
                height: 100%;                
            }
            .nbd-toolbar .toolbar-text .nbd-main-menu.menu-left .menu-item.item-font-size .sub-menu ul li {
                cursor: pointer;
            }
            .nbd-global-color-palette {
                top: 110px;
                left: 50%;
                margin-left: -110px;
                z-index: 10000002;
            }
            .nbd-global-color-palette.nbd-color-palette .nbd-color-palette-inner:before,
            .nbd-global-color-palette.nbd-color-palette .nbd-color-palette-inner:after {
                display: none !important;
            }
            .nbd-main-bar .logo{
                color: #404762;
            }
            .logo-without-image {
                border: 2px solid #404762;
                border-radius: 4px;
                padding: 5px;
            }
            @media screen and (min-width: 768px) {
                .nbd-stages .stage .page-toolbar {
                    top: 50%;                
                }
            }
            .nbd-stages .stage .stage-main.nbd-without-shadow {
                -webkit-box-shadow: none !important;
                box-shadow: none !important;
            }
            @media screen and (max-width: 767px) {
                .safari .nbd-workspace .main {
                    height: -webkit-calc(100vh - 164px);
                    height: calc(100vh - 164px);
                } 
                .nbd-global-color-palette {
                    margin-left: 0;
                }
                .nbd-toolbar .toolbar-common .nbd-main-menu li.menu-item.active > i {
                    color: #404762;
                }
                .nbd-toolbar .toolbar-text .nbd-main-menu.menu-left .menu-item .toolbar-input {
                    width: 50px;
                }
                .nbd-toolbar .toolbar-text .nbd-main-menu.menu-left .menu-item .toolbar-bottom {
                    padding: 0px 10px;
                }
                .nbd-stages .stage {
                    padding: 10px;
                    padding-bottom: 60px;
                }
                .nbd-stages .stage .stage-main {
                    margin: 0;
                }
                .nbd-stages .stage .page-toolbar {
                    bottom: -44px;
                }
                .nbd-tip {
                    display: none;
                }  
                .nbd-main-bar ul.menu-left .item-view>.sub-menu {
                    -webkit-transform: translateX(-40%);
                    -moz-transform: translateX(-40%);
                    transform: translateX(-40%);
                }
                .nbd-popup.nb-show {
                    z-index: 999999999999;
                }
                .android .nbd-workspace .main {
                    height: -webkit-calc(100vh - 192px);
                    height: calc(100vh - 192px);                    
                }
                .nbd-mode-1 .nbd-main-bar .menu-mobile.icon-nbd-clear {
                    padding-left: 45px;
                }   
                .android input[name="search"]:focus {
                    top: 70px;
                    left: 10px;
                    width: calc(100% - 20px);
                    position: fixed;
                    z-index: 100000004;
                }
            }
        </style>  
        <?php if( $show_nbo_option ): ?>
        <style>
            div.quick-view {
                overflow: hidden;
                zoom: 1;
            }
            div.quick-view .product:before,
            div.quick-view .product:after {
                content: " ";
                display: table;
            }
            div.quick-view .product:after {
                clear: both;
            }
            div.quick-view div.quick-view-image {
                margin: 0;
                width: 38% !important;
                float: left;
                box-sizing: border-box;
            }
            div.quick-view div.quick-view-image img {
                display: block;
                margin: 0 0 20px;
                border: 1px solid #eee;
                width: 100%;
                height: auto;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2);
                -webkit-box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2);
                -moz-box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2);
                padding: 8px;
                background: #fff;
                -moz-border-radius: 4px;
                -webkit-border-radius: 4px;
                border-radius: 4px;                
            }
            div.quick-view div.quick-view-image a.button {
                display: block;
                text-align: center;
                padding: 1em;
                margin: 0;
            }
            div.quick-view div.quick-view-content {
                overflow: auto;
                width: 56%;
                float: right;
            }
            .post-type-archive-product .pp_woocommerce_quick_view .pp_description,
            .tax-product_cat .pp_woocommerce_quick_view .pp_description,
            .post-type-archive-product .pp_woocommerce_quick_view .pp_social,
            .tax-product_cat .pp_woocommerce_quick_view .pp_social,
            .post-type-archive-product .pp_woocommerce_quick_view .pp_close,
            .tax-product_cat .pp_woocommerce_quick_view .pp_close {
                display: none !important;
            }
            .post-type-archive-product .pp_content,
            .tax-product_cat .pp_content {
                overflow: auto;
                height: auto !important;
            }
            .quick-view-button span {
                margin-right: .875em;
                display: inline-block;
                width: 1em;
                height: 1em;
                background: #000;
                position: relative;
                border-radius: 65% 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }
            .quick-view-button span:before,
            .quick-view-button span:after {
                content: "";
                position: absolute;
                display: block;
                top: 50%;
                left: 50%;
                border-radius: 100%;
            }
            .quick-view-button span:before {
                height: .5em;
                width: .5em;
                background: #fff;
                margin-top: -0.25em;
                margin-left: -0.25em;
            }
            .quick-view-button span:after {
                height: .25em;
                width: .25em;
                background: #000;
                margin-top: -0.125em;
                margin-left: -0.125em;
            }
            .quick-view-detail-button {
                font-size: 100%;
                margin: 0;
                line-height: 1em;
                text-align: center;
                cursor: pointer;
                position: relative;
                font-family: inherit;
                text-decoration: none;
                overflow: visible;
                padding: 6px 10px;
                font-weight: bold;
                -webkit-border-radius: 2px;
                border-radius: 2px;
                left: auto;
                text-shadow: 0 1px 0 #ffffff;
                color: #5e5e5e;
                text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
                border: 1px solid #c7c0c7;
                background: #f7f6f7;
                background: -webkit-gradient(linear, left top, left bottom, from(#f7f6f7), to(#dfdbdf));
                background: -webkit-linear-gradient(#f7f6f7, #dfdbdf);
                background: -moz-linear-gradient(center top, #f7f6f7 0%, #dfdbdf 100%);
                background: -moz-gradient(center top, #f7f6f7 0%, #dfdbdf 100%);
                white-space: nowrap;
                display: block;
                -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.075), inset 0 1px 0 rgba(255, 255, 255, 0.3), 0 1px 2px rgba(0, 0, 0, 0.1);
                -moz-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.075), inset 0 1px 0 rgba(255, 255, 255, 0.3), 0 1px 2px rgba(0, 0, 0, 0.1);
                box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.075), inset 0 1px 0 rgba(255, 255, 255, 0.3), 0 1px 2px rgba(0, 0, 0, 0.1);
            }
            .quick-view-button span {
                display: none;
            }
            div.quick-view div.quick-view-image a.button {
                border: 0;
                background: none;
                background-color: #404762;
                border-color: #43454b;
                color: #fff;
                cursor: pointer;
                padding: 0.6180469716em 1.41575em;
                text-decoration: none;
                font-weight: 600;
                text-shadow: none;
                display: inline-block;
                outline: none;
                -webkit-appearance: none;
                border-radius: 2px;
                box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.3);
                line-height: inherit;
                display: block; 
            }    
            div.quick-view .quantity .screen-reader-text {
                margin-right: 15px;
            }
            div.quick-view .input-text.qty {
                padding: 0.418047em;
                background-color: #f2f2f2;
                color: #43454b;
                outline: 0;
                border: 0;
                -webkit-appearance: none;
                box-sizing: border-box;
                font-weight: 400;
                box-shadow: inset 0 1px 1px rgba(0,0,0,.125);
                width: 4.235801032em;
                text-align: center;      
                height: 36px;
            }
            div.quick-view table td, div.quick-view table th{
                padding: 1em 1.41575em;
                text-align: left;              
            }
            div.quick-view table th{
                background-color: #f8f8f8;
            }
            div.quick-view table  td {
                background-color: #fdfdfd;
            }    
            div.quick-view table tr:nth-child(2n) td {
                background-color: #fbfbfb;
            }            
            div.quick-view h1.product_title {
                margin: 0;
                font-size: 2em;                
            }
            div.quick-view table .label {
                color: #404762;
                font-size: 100%;                
            }
            div.quick-view .single_add_to_cart_button, div.quick-view .reset_variations {
                color: #fff;
                background: #404762;
                display: inline-block;
                position: relative;
                min-height: 36px;
                min-width: 88px;
                line-height: 36px;
                vertical-align: middle;
                -webkit-box-align: center;
                -webkit-align-items: center;
                -ms-flex-align: center;
                align-items: center;
                -webkit-border-radius: 2px;
                border-radius: 2px;
                box-sizing: border-box;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                outline: 0;
                border: 0;
                padding: 0 12px;
                margin: 0px 8px;
                white-space: nowrap;
                text-transform: uppercase;
                font-weight: 500;
                font-size: 14px;
                font-style: inherit;
                font-variant: inherit;
                font-family: inherit;
                text-decoration: none;
                overflow: hidden;
                text-align: center;
                -webkit-transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1);
                -webkit-transition: background-color .4s cubic-bezier(.25,.8,.25,1),-webkit-box-shadow .4s cubic-bezier(.25,.8,.25,1);
                transition: background-color .4s cubic-bezier(.25,.8,.25,1),-webkit-box-shadow .4s cubic-bezier(.25,.8,.25,1);
                transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1);
                transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1),-webkit-box-shadow .4s cubic-bezier(.25,.8,.25,1);                
            }
            div.quick-view .variations select {
                border: 1px solid #EEE;
                height: 36px;
                padding: 3px 36px 3px 8px;
                background-color: transparent;
                line-height: 100%;
                outline: 0;
                background-image: url(<?php echo NBDESIGNER_PLUGIN_URL.'assets/images/arrow.png'; ?>);
                background-position: right;
                background-repeat: no-repeat;
                position: relative;
                cursor: pointer;
                -webkit-appearance: none;
                -moz-appearance: none;
            }
            div.quick-view .nbd-swatch-wrap .nbd-field-content {
                font-size: 14px;
            }
            #nbo-options-wrap {
                -webkit-transition: all .3s;
                -moz-transition: all .3s;        
                transition: all .3s; 
            }
            .nbd-swatch-wrap input[type="radio"]:checked + label:after {
                top: 9px !important;
                left: 13px !important;             
            }
            div.quick-view .variations {
                margin-bottom: 15px;
            }
            div.quick-view .variations td {
                display: table-cell;
                vertical-align: middle;                
            }
            .nbo-summary-title, .nbo-table-pricing-title {
                margin-top: 15px;
            }
            .nbd-field-input-wrap input[type="number"] {
                height: 36px;
            }
            .nbd-field-content input[type="range"] {
                border: none;
            }
            .nbo-disable {
                pointer-events: none;
            }
            .popup-nbo-options .nbd-button:hover {
                color: #fff;
                text-decoration: none;
            }
            .nbd-popup.popup-nbo-options .icon-nbd-clear {
                display: none;
            }
            .nbo-apply {
                float: right;
                margin-right: 0;
            }
            .nbd-popup.popup-nbo-options:after {
                content: '';
                clear: both;
            }
            .woocommerce-variation-price {
                margin-bottom: 15px;
            }
            .price del {
                opacity: 0.5;
            }
            ins .woocommerce-Price-amount {
                margin-left: 10px;
            }
            .nbo-summary-table {
                margin-bottom: 10px;
            }
            .nbo-dimension {
                width: 7em !important;
            }
            div.quick-view .quantity {
                display: inline-block;
            }
            div.quick-view .single_variation_wrap{
                padding-bottom: 15px;
            }
            .item-nbo-options span{
                border: 2px solid #ef5350;
                line-height: 32px;
                display: inline-block;
                padding: 0 14px;
                box-sizing: border-box;
                border-radius: 18px;
                color: #ef5350 !important;
            }
            @media only screen and (max-width: 768px) {
                div.quick-view div.quick-view-image,
                div.quick-view div.quick-view-content {
                    float: none !important;
                    width: 100% !important;
                    position: unset;
                }
                div.quick-view h1.product_title {
                    margin-top: 15px;
                }
            }            
        </style>
        <?php endif; ?>
        <?php 
            $enableColor = nbdesigner_get_option('nbdesigner_show_all_color'); 
            $enable_upload_multiple = nbdesigner_get_option('nbdesigner_upload_multiple_images'); 
            $design_type = (isset($_GET['design_type']) &&  $_GET['design_type'] != '') ? $_GET['design_type'] : '';
            $nbd_item_key = (isset($_GET['nbd_item_key']) &&  $_GET['nbd_item_key'] != '') ? $_GET['nbd_item_key'] : '';
            $nbu_item_key = (isset($_GET['nbu_item_key']) &&  $_GET['nbu_item_key'] != '') ? $_GET['nbu_item_key'] : '';
            $cart_item_key = (isset($_GET['cik']) &&  $_GET['cik'] != '') ? $_GET['cik'] : '';
            $reference = (isset($_GET['reference']) &&  $_GET['reference'] != '') ? $_GET['reference'] : ''; 
            
            $redirect_url = (isset($_GET['rd']) &&  $_GET['rd'] != '') ? $_GET['rd'] : (($task == 'new' && $ui_mode == 2) ? wc_get_cart_url() : '');
            $_enable_upload = get_post_meta($product_id, '_nbdesigner_enable_upload', true);  
            $_enable_upload_without_design = get_post_meta($product_id, '_nbdesigner_enable_upload_without_design', true);  
            $enable_upload = $_enable_upload ? 2 : 1;
            $enable_upload_without_design = $_enable_upload_without_design ? 2 : 1;
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
                if ( class_exists( 'SitePress' ) ) {
                    global $sitepress;
                    if($sitepress){
                        $wpml_language_negotiation_type = $sitepress->get_setting('language_negotiation_type');
                        if( $wpml_language_negotiation_type == 2 ){
                            $is_wpml = 1;
                            $font_url = str_replace(untrailingslashit(get_option('home')), untrailingslashit(icl_get_home_url()), $font_url);
                        }
                    }
                }
            };
            $fbID = nbdesigner_get_option('nbdesigner_facebook_app_id');
            $templates = nbd_get_resource_templates($product_id, $variation_id);
            $total_template = nbd_count_total_template( $product_id, $variation_id );
            $product_data = nbd_get_product_info( $product_id, $variation_id, $nbd_item_key, $task, $task2, $reference, false, $cart_item_key );
            
            $link_get_options = add_query_arg(
                urlencode_deep( array(
                    'wc-api'  => 'NBO_Quick_View',
                    'product' => $product_id
                ) ),
                home_url( '/' )
            );
            if( count($_REQUEST) ){
                foreach ($_REQUEST as $key => $value){
                    if (strpos($key, 'attribute_') === 0) {
                        $link_get_options .= '&'.$key.'='.$value;
                    }		
                }
            }
            if( isset($_GET['cik']) && $_GET['cik'] != '' ){
                $link_get_options .= '&nbo_cart_item_key=' . $_GET['cik'];
                if( $task2 != '' ){
                    $link_edit_option = add_query_arg(
                       array(
                           'nbo_cart_item_key'  => $_GET['cik']
                       ),
                       wc_get_product( $variation_id > 0 ? $variation_id : $product_id )->get_permalink()     
                    );
                    $link_edit_option = wp_nonce_url( $link_edit_option, 'nbo-edit' );
                }                
            }
        ?>
        <script type="text/javascript">
            var NBDESIGNCONFIG = {
                lang_code   :   "<?php echo $lang_code; ?>",
                lang_rtl    :   "<?php if(is_rtl()){ echo 'rtl'; } else {  echo 'ltr';  } ?>",
                is_mobile   :   "<?php echo wp_is_mobile(); ?>",
                ui_mode   :   "<?php echo $ui_mode; ?>",
                show_variation   :   "<?php echo $show_variation; ?>",
                show_nbo_option   :   "<?php echo $show_nbo_option; ?>",
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
                //login_url   :   "<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ).'?nbd_redirect=1'; ?>",
                list_file_upload    :   <?php echo json_encode($list_file_upload); ?>,
                product_data  :   <?php echo json_encode($product_data); ?>,
                fonts: <?php echo nbd_get_fonts(); ?>,
                subsets: <?php echo json_encode(nbd_font_subsets()); ?>,
                fbID: "<?php echo $fbID; ?>",
                nbd_create_own_page: "<?php echo getUrlPageNBD('create'); ?>",
                link_get_options: "<?php echo $link_get_options; ?>",
                enable_dropbox: false,
                default_font: <?php echo $default_font; ?>,
                templates: <?php echo json_encode($templates); ?>,
                nbdlangs: {
                        cliparts: "<?php _e('Cliparts', 'web-to-print-online-designer'); ?>",
                        alert_upload_term: "<?php _e('Please accept the upload term conditions', 'web-to-print-online-designer'); ?>",
                        path: "<?php _e('Vector', 'web-to-print-online-designer'); ?>",
                        image: "<?php _e('Image', 'web-to-print-online-designer'); ?>",
                        rect: "<?php _e('Rectangle', 'web-to-print-online-designer'); ?>",
                        triangle: "<?php _e('Triangle', 'web-to-print-online-designer'); ?>",
                        line: "<?php _e('Line', 'web-to-print-online-designer'); ?>",
                        polygon: "<?php _e('Polygon', 'web-to-print-online-designer'); ?>",
                        circle: "<?php _e('Circle', 'web-to-print-online-designer'); ?>",
                        ellipse: "<?php _e('Ellipse', 'web-to-print-online-designer'); ?>",
                        group: "<?php _e('Group', 'web-to-print-online-designer'); ?>"
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
            <?php if( isset($product_data['option']['use_all_color']) ): ?>
                NBDESIGNCONFIG['nbdesigner_show_all_color'] = "<?php echo $product_data['option']['use_all_color'] == 1 ? 'yes' : 'no'; ?>";
            <?php endif; ?>
            <?php 
            if( isset($product_data['option']['color_cats']) ):
                $cats = $product_data['option']['color_cats'];
                $colors = Nbdesigner_IO::read_json_setting(NBDESIGNER_DATA_DIR . '/colors.json');
                $colors = array_filter($colors, function ($val) use ($cats){
                    $check = false;
                    if( sizeof($val->cat) == 0 ){
                        if( in_array('0', $cats) ) $check = true;
                    }else{
                        $intercept = array_intersect($val->cat, $cats);
                        if( count($intercept) == count($val->cat) )  $check = true;
                    }
                    return $check;
                });
                $list_color = [];
                foreach( $colors as $color ){
                    $list_color[] = $color->hex;
                }
                $list_color = array_unique($list_color);
            ?>
            var  colorPalette = [], row = [], __colorPalette = [], color = '';
                <?php foreach($list_color as $cindex => $color): ?>
                    color = "<?php echo $color; ?>";
                    row.push(color);
                    <?php if( $cindex % 10 == 9 ): ?>
                        colorPalette.push(row);
                        row = [];                    
                    <?php endif; ?>
                    __colorPalette.push(color);
                <?php endforeach; ?>
            <?php elseif( isset($product_data['option']['list_color']) ): ?>
            var  colorPalette = [], row = [], __colorPalette = [], color = '';
                <?php foreach($product_data['option']['list_color'] as $cindex => $color): ?>
                    color = "<?php echo $color['code']; ?>";
                    row.push(color);
                    <?php if( $cindex % 10 == 9 ): ?>
                        colorPalette.push(row);
                        row = [];                    
                    <?php endif; ?>
                    __colorPalette.push(color);
                <?php endforeach; ?>
            <?php else: ?>
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
            <?php endif; ?> 
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
                        <div class="main <?php echo (wp_is_mobile()) ? 'active' : ''; ?>">
                            <?php include 'modern/toolbar.php'; ?>
                            <?php include 'modern/stages.php';?>
                            <?php include 'modern/toolbar-zoom.php';?>
                            <?php include 'modern/warning.php'?>
                            <?php include 'modern/context-menu.php'?>
                            <?php //include 'modern/signal.php'?>
                            <?php include 'modern/loading-workflow.php';?>
                        </div>
                        <?php //include 'modern/toollock.php';?>
                    </div>
                </div>	
            </div>
            <?php include 'modern/popup.php';?>
            <?php include 'modern/toasts.php';?>
            <?php include 'modern/tip.php';?>
            <?php include 'modern/color-palette.php';?>
        </div>
        <?php include 'modern/loading-page.php';?>
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
        <script type='text/javascript' src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/libs/angular-1.6.9.min.js'; ?>"></script>
        <?php endif; ?>
        <script type="text/javascript" src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/js/bundle-modern.min.js'; ?>"></script>
        <!-- NBO  -->
        <?php if( $show_nbo_option ): ?>
        <?php wc_get_template( 'single-product/add-to-cart/variation.php' ) ?>;
        <script type="text/javascript">
            <?php
                $wc_add_to_cart_params = array(
                    'wc_ajax_url'                      => WC_AJAX::get_endpoint( '%%endpoint%%' ),
                    'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'woocommerce' ),
                    'i18n_make_a_selection_text'       => esc_attr__( 'Please select some product options before adding this product to your cart.', 'woocommerce' ),
                    'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' )
                );
                $nbds_frontend = array(
                    'currency_format_num_decimals'  =>  wc_get_price_decimals(),
                    'currency_format_symbol'  =>  html_entity_decode( (string) get_woocommerce_currency_symbol(), ENT_QUOTES, 'UTF-8'),
                    'currency_format_decimal_sep'  =>  stripslashes( wc_get_price_decimal_separator() ),
                    'currency_format_thousand_sep'  =>  stripslashes( wc_get_price_thousand_separator() ),
                    'currency_format'  =>  esc_attr( str_replace( array( '%1$s', '%2$s' ), array( '%s', '%v' ), get_woocommerce_price_format()) ),
                    'nbdesigner_hide_add_cart_until_form_filled'  =>  nbdesigner_get_option('nbdesigner_hide_add_cart_until_form_filled')
                );
            ?>
            var wc_add_to_cart_variation_params = <?php echo json_encode($wc_add_to_cart_params); ?>;
            var nbds_frontend = <?php echo json_encode($nbds_frontend); ?>;
            window.wp = window.wp || {};
            wp.template = _.memoize(function ( id ) {
                var compiled,
                options = {
                    evaluate:    /<#([\s\S]+?)#>/g,
                    interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
                    escape:      /\{\{([^\}]+?)\}\}(?!\})/g,
                    variable:    'data'
                };
                return function ( data ) {
                    compiled = compiled || _.template( $( '#tmpl-' + id ).html(),  options );
                    return compiled( data );
                };
            });            
        </script>
        <script type='text/javascript' src="<?php echo WC()->plugin_url().'/assets/js/accounting/accounting.min.js'; ?>"></script>
        <script type='text/javascript' src="<?php echo WC()->plugin_url().'/assets/js/frontend/add-to-cart.min.js'; ?>"></script>
        <script type='text/javascript' src="<?php echo WC()->plugin_url().'/assets/js/frontend/add-to-cart-variation.min.js'; ?>"></script>
        <?php endif; ?>
        <!-- End. NBO  -->
        <script type="text/javascript" src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/js/designer-modern.min.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/js/app-modern.min.js'; ?>"></script>
    </body>
</html>
<?php endif; endif;?>