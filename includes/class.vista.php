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

                    'vista' => array(
                        'link'  => NBDESIGNER_ASSETS_URL.'vista/assets/js/vista.js',
                        'version'   => '1.0.0',
                        'depends'  => array('jquery')
                    ),
                );
                $css_libs = array(
                    'vista' => array(
                        'link'  => NBDESIGNER_ASSETS_URL.'vista/assets/css/vista.css',
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
                wp_enqueue_style( 'vista', '');
                wp_enqueue_script('vista');
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