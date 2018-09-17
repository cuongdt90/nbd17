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
            add_action('nbd_menu', array($this, 'manage_color_menu'), 1000);
            add_action('nbd_after_option_product_design', array($this, 'product_design_setting'), 10, 2);
            $this->ajax();
        }
        public function ajax(){
            $ajax_events = array(
                'nbd_add_color_group'   =>  false,
                'nbd_add_color'   =>  false
            );
            foreach ($ajax_events as $ajax_event => $nopriv) {
                add_action('wp_ajax_' . $ajax_event, array($this, $ajax_event));
                if ($nopriv) {
                    // NBDesigner AJAX can be used for frontend ajax requests
                    add_action('wp_ajax_nopriv_' . $ajax_event, array($this, $ajax_event));
                }
            }
        }
        public function nbd_add_color_group(){
            
        }
        public function nbd_add_color(){
            
        }
        public function manage_color_menu(){
            add_submenu_page(
                'nbdesigner', __('NB  manage color', 'web-to-print-online-designer'), __('Manage color', 'web-to-print-online-designer'), 'manage_nbd_tool', 'manage_color', 'manage_color'
            );  
        }
        public function manage_color(){
            include_once(NBDESIGNER_PLUGIN_DIR . 'views/cuz/manage-color.php');
        }
        public function product_design_setting( $post_id, $option ){
            include_once(NBDESIGNER_PLUGIN_DIR . 'views/cuz/product-settings.php');
        }
    }
}
$nbd_cuz = NBD_CUSTOMIZE::instance();
$nbd_cuz->init();

