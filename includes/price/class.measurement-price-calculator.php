<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<?php
if(!class_exists('Nbdesigner_Measurement_Price_Calculator')){
    class Nbdesigner_Measurement_Price_Calculator {
        protected static $instance;
        public function __construct() {
            //todo something
        }
        public function init(){
            add_action('nbd_after_option_product_design', array($this, 'price_option'), 10, 2);
            if( nbdesigner_get_option('nbdesigner_position_pricing_in_detail_page') == '1' ){
                add_filter( 'woocommerce_product_tabs', array($this, 'pricing_product_tab') );
            }
            add_action('nbd_after_single_product_design_section', array($this, 'table_price_option'), 10, 2);
        }
	public static function instance() {
            if ( is_null( self::$instance ) ) {
                    self::$instance = new self();
            }
            return self::$instance;
	}
        public function price_option( $post_id, $option ){
            include_once(NBDESIGNER_PLUGIN_DIR . 'views/price-options.php');            
        }
        public function table_price_option( $post_id, $option ){
            ob_start();
            nbdesigner_get_template('single-product/price-options.php', array('post_id' => $post_id, 'option' => $option));  
            echo ob_get_clean();
        }        
        public function pricing_product_tab( $tabs ){
            global $product;
            $pid = $product->get_id();
            $option = unserialize(get_post_meta($pid, '_nbdesigner_option', true));  
            if( isset($option['price_base_quantity']) && $option['price_base_quantity'] == 1 ){
                $tabs['nbd_pricing'] = array(
                    'title'    => __( 'Pricing', 'web-to-print-online-designer' ),
                    'priority' => 90,
                    'callback' => array($this, 'nbd_pricing_product_tab')
                );
            }
            return $tabs;            
        }
        public function nbd_pricing_product_tab(){
            global $product;
            $option = unserialize(get_post_meta($product->get_id(), '_nbdesigner_option', true));
            if( isset($option['price_base_quantity']) && $option['price_base_quantity'] == 1 ){
                $prices =  $option['price_base_quantity_prices'];
                ob_start();
                nbdesigner_get_template('single-product/pricing-table-tab.php', array('prices' => $prices));  
                echo ob_get_clean();                
            }
        }
    }
}
$nbd_price_calculator = Nbdesigner_Measurement_Price_Calculator::instance();
$nbd_price_calculator->init();