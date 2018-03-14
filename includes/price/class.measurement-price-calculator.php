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
            add_filter( 'woocommerce_add_cart_item_data', array( $this, 'add_cart_item_data' ), 10, 3 );
            // on add to cart set the price when needed, and do it first, before any other plugins
            add_filter( 'woocommerce_add_cart_item', array($this, 'set_product_prices'), 1, 1 );  
            // persist the cart item data, and set the item price (when needed) first, before any other plugins
            add_filter( 'woocommerce_get_cart_item_from_session', array( $this, 'get_cart_item_from_session' ), 1, 2 );  
            // handle customer input as order item meta
            add_filter( 'woocommerce_get_item_data', array( $this, 'display_product_data_in_cart' ), 10, 2 );     
            if(is_woo_v3() ){
                add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'set_order_item_meta' ), 10, 3 );
            }else{
                add_action( 'woocommerce_add_order_item_meta', array( $this, 'add_order_item_meta' ), 10, 2 );
            }
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
        public function calculator_price( $option, $config ){
            $price_base_area = $option['price_base_area_prices'];
            $num_side = count( $config->product );
            $width = (float)$config->custom_dimension->width;
            $height = (float)$config->custom_dimension->height;
            $area = $width * $height;
            $price_per_unit = $price_base_area["price"][0] != '' ? (float)$price_base_area["price"][0] : 0;
            foreach ( $price_base_area["start"] as $key => $start ){
                $start = $start != '' ? (float)$start : 1;
                $end = $price_base_area["end"][$key] != '' ? (float)$price_base_area["end"][$key] : 0;
                if( $start <= $area && ( $area <= $end || $end == 0 ) ){
                    $price_per_unit = $price_base_area["price"][$key] != '' ? (float)$price_base_area["price"][$key] : 0;
                    $price_per_unit = $this->format_price( $price_per_unit );
                    break;
                }
                if( $key == ( count( $price_base_area["end"] ) - 1 ) && $area > $end ){
                    $price_per_unit = $price_base_area["price"][$key] != '' ? (float)$price_base_area["price"][$key] : 0;
                    $price_per_unit = $this->format_price( $price_per_unit );                    
                }
            }
            return $this->format_price( $num_side * $area * $price_per_unit );
        }
        public function format_price( $price ){
            $decimal_separator = stripslashes( wc_get_price_decimal_separator() );
            $thousand_separator = stripslashes( wc_get_price_thousand_separator() );
            $num_decimals = wc_get_price_decimals();
            $price = str_replace($decimal_separator, '.', $price);
            $price = str_replace($thousand_separator, '', $price);
            $price = round($price, $num_decimals);
            return $price;
        }
        public function set_product_prices( $cart_item ){
            if ( isset( $cart_item['nbd_item_meta_data']['_price'] )){
                $measurement = (float) $cart_item['nbd_item_meta_data']['_price'];
                $cart_item['data']->set_price( $measurement );
            }          
            return $cart_item;
        }  
        public function add_cart_item_data(  $cart_item_data, $product_id, $variation_id  ){
            $nbd_item_cart_key = ($variation_id > 0) ? $product_id . '_' . $variation_id : $product_id;
            $nbd_session = WC()->session->get('nbd_item_key_'.$nbd_item_cart_key);            
            if(isset($nbd_session)){
                $option = unserialize(get_post_meta($product_id, '_nbdesigner_option', true));
                if(isset($option['price_base_area']) && $option['price_base_area'] == 1){
                    $path = NBDESIGNER_CUSTOMER_DIR . '/' . $nbd_session;
                    $config = json_decode(file_get_contents($path . '/config.json'));
                    if( isset( $config->custom_dimension ) ){
                        $price = $this->calculator_price( $option, $config );
                        $cart_item_data['nbd_item_meta_data']['_price'] = $price;  
                        $cart_item_data['nbd_item_meta_data']['_num_side'] = count( $config->product );  
                        $cart_item_data['nbd_item_meta_data']['_custom_dimension_width'] = $config->custom_dimension->width;  
                        $cart_item_data['nbd_item_meta_data']['_custom_dimension_height'] = $config->custom_dimension->height;  
                    }
                }

            } 
            return $cart_item_data;
        }
	public function get_cart_item_from_session( $cart_item, $values ) {
            if ( isset( $values['nbd_item_meta_data'] ) ) {
                $cart_item['nbd_item_meta_data'] = $values['nbd_item_meta_data'];
                // set the product price (if needed)
                $cart_item = $this->set_product_prices( $cart_item );
            }
            return $cart_item;
	}     
        public function display_product_data_in_cart( $data, $item ){
            if ( isset( $item['nbd_item_meta_data'] ) ) {
                $display_data = $this->humanize_cart_item_data($item, $item['nbd_item_meta_data']);
                foreach ($display_data as $name => $value) {
                    $data[] = array(
                        'name' => $name,
                        'display' => $value,
                        'hidden' => false,
                    );
                }
            }
            return $data;
        }
        public function humanize_cart_item_data( $item, $cart_item_data ){
            $new_cart_item_data = array();
            $new_cart_item_data[ __('Number of side', 'web-to-print-online-designer') ] = $cart_item_data['_num_side'];
            $new_cart_item_data[ __('Size', 'web-to-print-online-designer') ] = $cart_item_data['_custom_dimension_width'] . 'x' . $cart_item_data['_custom_dimension_height'] . ' ('. nbdesigner_get_option('nbdesigner_dimensions_unit') .')';
            return $new_cart_item_data;
        }
        public function set_order_item_meta( $item, $cart_item_key, $values ){
            if ( isset( $values['nbd_item_meta_data'] ) ) {
                $display_data = $this->humanize_cart_item_data( $values, $values['nbd_item_meta_data'] );
                foreach ( $display_data as $name => $value ) {
                    $item->add_meta_data( $name, $value );
                }                
            }
        }
        public function add_order_item_meta( $item_id, $values ){
            if ( isset( $values['nbd_item_meta_data'] ) ) {
                $display_data = $this->humanize_cart_item_data( $values, $values['nbd_item_meta_data'] );
                foreach ( $display_data as $name => $value ) {
                    wc_add_order_item_meta( $item_id, $name, $value );
                }
            }
        }
    }
}
$nbd_price_calculator = Nbdesigner_Measurement_Price_Calculator::instance();
$nbd_price_calculator->init();