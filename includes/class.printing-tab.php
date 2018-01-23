<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<?php
if(!class_exists('Nbdesigner_Printing_Tab')){
    class Nbdesigner_Printing_Tab {
        protected static $instance;
        public function __construct() {
            //todo something
        }
        public function init(){
            //add_filter( 'woocommerce_product_tabs', array($this, 'woo_reorder_tabs' ), 98 );
        }
        public function woo_reorder_tabs( $tabs ){
            if( isset($tabs['reviews']) ) $tabs['reviews']['priority'] = 5;			
            if( isset($tabs['description']) ) $tabs['description']['priority'] = 10;			
            if( isset($tabs['additional_information']) ) $tabs['additional_information']['priority'] = 15;	
            return $tabs;            
        }
	public static function instance() {
            if ( is_null( self::$instance ) ) {
                    self::$instance = new self();
            }
            return self::$instance;
	}        
    }
}
$nbd_pricing_tab = Nbdesigner_Printing_Tab::instance();
$nbd_pricing_tab->init();