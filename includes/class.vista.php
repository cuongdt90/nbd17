<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if(!class_exists('NBDESIGNER_VISTA_LAYOUT')) {
    class NBDESIGNER_VISTA_LAYOUT{
        protected static $instance;
        protected $isDesign = false;

        public function __construct(){
            //TODO
        }
        public static function instance(){
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }
        public function init(){
            $this->frontend_enqueue_scripts();
            add_action('woocommerce_before_single_product', array(&$this, 'before_product_container'), 1);
        }
        public function before_product_container(){
            $pid = get_the_ID();
            if (is_nbdesigner_product($pid)) {
                add_action('woocommerce_before_single_product_summary', array(&$this, 'design_editor'), 1);
                remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
            }
        }
        public function frontend_enqueue_scripts(){
            add_action('wp_enqueue_scripts', function() {
                $js_libs = array(
                    'jquery-ui' => array(
                        'link' => NBDESIGNER_PLUGIN_URL . 'assets/libs/jquery-ui.min.js',
                        'version'   => NBDESIGNER_VERSION,
                        'depends'  => array('jquery'),
                        'in_footer' => true
                    ),
                    'nbd-vista' => array(
                        'link' => NBDESIGNER_ASSETS_URL .'vista/assets/js/vista.js',
                        'version'   => NBDESIGNER_VERSION,
                        'depends'  => array('jquery'),
                        'in_footer' => true
                    ),
                    'app-vista' => array(
                        'link'  => NBDESIGNER_ASSETS_URL.'vista/assets/js/app-vista.min.js',
                        'version'   => NBDESIGNER_VERSION,
                        'depends'  => array('jquery', 'nbd-vista', 'bundle-vista'),
                        'in_footer' => true
                    ),
                    'bundle-vista' => array(
                        'link' => NBDESIGNER_ASSETS_URL.'vista/assets/js/bundle-vista.min.js',
                        'version'   => NBDESIGNER_VERSION,
                        'depends'  => array('jquery', 'underscore', 'angularjs'),
                        'in_footer' => true
                    )
                );
                $css_libs = array(
                    'vista' => array(
                        'link'  => NBDESIGNER_ASSETS_URL.'vista/assets/css/vista.css',
                        'version'   => NBDESIGNER_VERSION,
                        'depends'  =>  array()
                    ),
                    'vista-rtl' => array(
                        'link' => NBDESIGNER_ASSETS_URL.'vista/assets/css/vista-rtl.css',
                        'version'   => NBDESIGNER_VERSION,
                        'depends'  =>  array()
                    ),

                );
                foreach ($js_libs as $key => $js){
                    wp_register_script($key, $js['link'], $js['depends'], $js['version'],$js['in_footer']);
                }
                foreach ($css_libs as $key => $css){
                    wp_register_style($key, $css['link'], $css['depends'], $css['version']);
                }
                if( is_singular( 'product' ) ){
                    wp_enqueue_style( 'vista');
    //
    //                    wp_enqueue_script('jquery-ui');
    //                    if(nbdesigner_get_option('nbdesigner_enable_angular_js') == 'yes'){
    //                        wp_enqueue_script(array('angularjs'));
    //                    }
//                    wp_enqueue_script('angularjs');
//                    wp_enqueue_script('bundle-vista');
//                    wp_enqueue_script('nbd-vista');
                    wp_enqueue_script('app-vista');
                    if (is_rtl()) {
                        wp_enqueue_style('vista-rtl');
                    }
                }
            });
        }
        public function design_editor(){
            include(NBDESIGNER_PLUGIN_DIR . 'views/vista/vista.php');
        }
    }
}
$nbd_vista = NBDESIGNER_VISTA_LAYOUT::instance();
$nbd_vista->init();