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

        public function vista_html()
        {
            include(NBDESIGNER_PLUGIN_DIR . 'views/vista/vista.php');
        }
    }
}
$nbd_vista = Nbdesigner_Vista::instance();
$nbd_vista->init();