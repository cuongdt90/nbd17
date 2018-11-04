<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


if(!class_exists('Nbdesigner_Product_Builder')) {
    class Nbdesigner_Product_Builder
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
//            $this->before_product_container();
            add_action('wp_footer', array(&$this, 'nbd_modal_product_builder'), 1);
        }


        public function before_product_container()
        {
            $pid = get_the_ID();
            if (is_nbdesigner_product($pid)) {
//                add_action('woocommerce_before_single_product_summary', array(&$this, 'product_builder_html'), 1);
                add_action('woocommerce_before_add_to_cart_form', array(&$this, 'product_builder_html'), 1);
//                remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
            }

        }

        public function frontend_enqueue_scripts(){
            add_action('wp_enqueue_scripts', function() {
                $js_libs = array(

                    'product-builder' => array(
                        'link' => NBDESIGNER_ASSETS_URL.'js/app-product-builder.js',
                        'version'   => '1.0.0',
                        'depends'  => array('jquery', 'underscore', 'angular')
                    )

                );
                $css_libs = array(
                    'product-builder' => array(
                        'link'  => NBDESIGNER_ASSETS_URL.'css/app-product-builder.css',
                        'version'   => '1.0.0',
                        'depends'  =>  array()
                    ),
                );
                foreach ($js_libs as $key => $js){
                    $link = $js['link'];
                    wp_register_script($key, $link, $js['depends'], $js['version'],false);
                }
                foreach ($css_libs as $key => $css){
                    $link = $css['link'];
                    wp_register_style($key, $link, $css['depends'], $css['version']);
                }
                wp_enqueue_style( 'product-builder');
                wp_enqueue_script('product-builder');

            });
        }


        public function product_builder_html()
        {
            include(NBDESIGNER_PLUGIN_DIR . 'views/product-builder/start-design.php');
        }

        public function nbd_modal_product_builder()
        {
            include(NBDESIGNER_PLUGIN_DIR . 'views/product-builder/index.php');
        }
    }
}
$nbd_product_builder = Nbdesigner_Product_Builder::instance();
$nbd_product_builder->init();