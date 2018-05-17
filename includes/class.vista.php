<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if(!class_exists('Nbdesigner_Vista')) {
    class Nbdesigner_Vista
    {
        protected static $instance;

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

                    'materialize' => array(
                        'cdn-link' => 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js',
                        'link'  => NBDESIGNER_ASSETS_URL.'vista/assets/js/materialize.min.js',
                        'version'   => '1.0.0-beta',
                        'depends'  => array()
                    ),
                );
                $css_libs = array(
                    'vista' => array(
                        'link'  => NBDESIGNER_ASSETS_URL.'vista/assets/css/vista.css',
                        'version'   => '1.1.3',
                        'depends'  =>  array()
                    ),
                );
                foreach ($js_libs as $key => $js){
                    $link = ( NBDESIGNER_MODE_DEV ) ? $js['link'] : $js['cdn-link'];
                    wp_register_script($key, $link, $js['depends'], $js['version']);
                }
                foreach ($css_libs as $key => $css){
                    $link = ( NBDESIGNER_MODE_DEV ) ? $css['link'] : $css['cdn-link'];
                    wp_register_style($key, $link, $css['depends'], $css['version']);
                }
                wp_enqueue_style( 'vista', '' );
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