<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if(!class_exists('NBD_CUSTOMIZE')){
    class NBD_CUSTOMIZE {
        protected static $instance;
        public static function instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }
            return self::$instance;
		}
        public function init(){	
            add_action('nbd_after_option_product_design', array($this, 'product_design_setting'), 10, 2);
        }
        public function product_design_setting( $post_id, $option ){
            include_once(NBDESIGNER_PLUGIN_DIR . 'views/cuz/product-settings.php');
        }
    }
}
$nbd_cuz = NBD_CUSTOMIZE::instance();
$nbd_cuz->init();

