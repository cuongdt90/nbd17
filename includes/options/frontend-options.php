<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if(!class_exists('NBD_FRONTEND_PRINTING_OPTIONS')){
    class NBD_FRONTEND_PRINTING_OPTIONS {
        protected static $instance;
	public static function instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }
            return self::$instance;
	}
        public function init(){
            add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'show_option_fields' ) );
        }
        public function show_option_fields(){
            $id = 1;
            $_options = $this->get_option($id);
            if($_options){
                $options = unserialize($_options['fields']);
                nbdesigner_get_template('single-product/option-builder.php', array(
                    'options'   =>  $options
                ));
                $bulk_variation_form = ob_get_clean();                      
                echo $bulk_variation_form;
            }
        }
        public function get_option( $id ){
            global $wpdb;
            $sql = "SELECT * FROM {$wpdb->prefix}nbdesigner_options";
            $sql .= " WHERE id = " . esc_sql($id);
            $result = $wpdb->get_results($sql, 'ARRAY_A');
            return count($result[0]) ? $result[0] : false;
        }        
        public function calculate_price($product, $option){
            //todo
        }
    }
}
$nbd_fontend_printing_options = NBD_FRONTEND_PRINTING_OPTIONS::instance();
$nbd_fontend_printing_options->init();