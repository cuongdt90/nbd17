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
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,400i,700,700i' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Poppins:400,100,300italic,300' rel='stylesheet' type='text/css'>
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
                max-height: 200px;        
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
            }
            .nbd-templates .items .item .main-item {
                border: 1px solid #ebebeb;
                cursor: pointer;
            }            
            .nbd-templates .items .item {
                width: 50%;
                box-sizing: border-box;
                display: inline-block;
                padding: 10px;
            }    
            .nbd-mode-1 .nbd-main-bar .logo {
                visibility: hidden;
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
            @media screen and (max-width: 767px) {
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
            }
        </style>        
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
            };
            $fbID = nbdesigner_get_option('nbdesigner_facebook_app_id');            
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
                default_font: <?php echo nbd_get_default_font(); ?>,
                templates: <?php echo json_encode(nbd_get_resorce_templates($product_id, $variation_id)); ?>
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
                        <div class="main <?php echo (wp_is_mobile()) ? 'active' : ''; ?>">
                            <?php include 'modern/toolbar.php'; ?>
                            <?php include 'modern/stages.php';?>
                            <?php include 'modern/toolbar-zoom.php';?>
                            <?php include 'modern/context-menu.php'?>
                            <?php include 'modern/signal.php'?>
                            <?php include 'modern/loading-workflow.php';?>
                        </div>
                        <?php include 'modern/toollock.php';?>
                    </div>
                </div>	
            </div>
            <?php include 'modern/popup.php';?>
            <?php include 'modern/toasts.php';?>            
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
        <script type='text/javascript' src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/libs/angular.min.js'; ?>"></script>
        <?php endif; ?>
        <script type="text/javascript" src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/js/app-modern.min.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/js/bundle-modern.unmin.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/js/add-to-cart-variation.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/js/designer-modern.min.js'; ?>"></script>

    </body>
</html>
<?php endif; endif;?>