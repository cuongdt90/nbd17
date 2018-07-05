<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if(!class_exists('Nbdesigner_Vista')) {
    class Nbdesigner_Vista
    {
        protected static $instance;
        protected $isDesign = false;

        public function __construct()
        {
            //TODO
        }

        public static function instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function init()
        {
            $this->frontend_enqueue_scripts();
            add_action('woocommerce_before_single_product', array(&$this, 'before_product_container'), 1);
        }

        public function before_product_container()
        {
            $pid = get_the_ID();
            if (is_nbdesigner_product($pid)) {
                add_action('woocommerce_before_single_product_summary', array(&$this, 'vista_html'), 1);
                remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
            }
        }

        public function frontend_enqueue_scripts(){
            add_action('wp_enqueue_scripts', function() {
                $js_libs = array(

                    'vista' => array(
                        'link'  => NBDESIGNER_ASSETS_URL.'vista/assets/js/vista.js',
                        'version'   => '1.0.0',
                        'depends'  => array('jquery')
                    ),
                    'angular' => array(
                        'link' => NBDESIGNER_PLUGIN_URL .'assets/libs/angular-1.6.9.min.js',
                        'version'   => '1.0.0',
                        'depends'  => array('jquery')
                    ),
                    'jquery-ui' => array(
                        'link' => NBDESIGNER_PLUGIN_URL . 'assets/libs/jquery-ui.min.js',
                        'version'   => '1.0.0',
                        'depends'  => array('jquery')
                    ),
                    'app-modern' => array(
                        'link' => NBDESIGNER_PLUGIN_URL .'assets/js/app-modern.min.js',
                        'version'   => '1.0.0',
                        'depends'  => array('jquery')
                    ),
                    'app-vista' => array(
                        'link'  => NBDESIGNER_ASSETS_URL.'vista/assets/js/app-vista.min.js',
                        'version'   => '1.0.0',
                        'depends'  => array('jquery')
                    ),
                    'bundle-vista' => array(
                        'link' => NBDESIGNER_ASSETS_URL.'vista/assets/js/bundle-vista.min.js',
//                        'link' => NBDESIGNER_PLUGIN_URL.'assets/js/bundle-modern.unmin.js',
                        'version'   => '1.0.0',
                        'depends'  => array('jquery', 'underscore', 'angular')
                    )

                );
                $css_libs = array(
                    'vista' => array(
                        'link'  => NBDESIGNER_ASSETS_URL.'vista/assets/css/vista.css',
                        'version'   => '1.0.0',
                        'depends'  =>  array()
                    ),
                    'vista-rtl' => array(
                        'link' => NBDESIGNER_ASSETS_URL.'vista/assets/css/vista-rtl.css',
                        'version'   => '1.0.0',
                        'depends'  =>  array()
                    ),

                );
                foreach ($js_libs as $key => $js){
                    $link = $js['link'];
                    wp_register_script($key, $link, $js['depends'], $js['version']);
                }
                foreach ($css_libs as $key => $css){
                    $link = $css['link'];
                    wp_register_style($key, $link, $css['depends'], $css['version']);
                }
                wp_enqueue_style( 'vista');
//                wp_enqueue_style( 'spectrum');

                wp_enqueue_script('jquery-ui');
                wp_enqueue_script('angular');
                wp_enqueue_script('bundle-vista');
                wp_enqueue_script('app-vista');
                wp_enqueue_script('add-to-cart');
                wp_enqueue_script('vista');

                if (is_rtl()) {
                    wp_enqueue_style('vista-rtl');
                }

            });
        }


        public function vista_html()
        {
            include(NBDESIGNER_PLUGIN_DIR . 'views/vista/vista.php');
        }
    }
}
$nbd_vista = Nbdesigner_Vista::instance();
$nbd_vista->init();