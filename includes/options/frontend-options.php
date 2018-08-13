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
            add_filter( 'nbd_js_object', array($this, 'nbd_js_object') );
            add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
            
            // Add item data to the cart
            add_filter( 'woocommerce_add_cart_item_data', array( $this, 'add_cart_item_data' ), 50, 4 );
        }
        public function add_cart_item_data( $cart_item_data, $product_id, $variation_id, $quantity ){
            $post_data = $_POST;
            if( isset($post_data['nbd-field']) ){
                
            }
        }
        public function nbd_js_object( $args ){
            $args['currency_format_num_decimals'] = wc_get_price_decimals();
            $args['currency_format_symbol'] =get_woocommerce_currency_symbol();
            $args['currency_format_decimal_sep'] = stripslashes( wc_get_price_decimal_separator() );
            $args['currency_format_thousand_sep'] = stripslashes( wc_get_price_thousand_separator() );
            $args['currency_format'] = esc_attr( str_replace( array( '%1$s', '%2$s' ), array( '%s', '%v' ), get_woocommerce_price_format()) );
            return $args;
        }
        public function wp_enqueue_scripts(){
            wp_register_script('angularjs', NBDESIGNER_PLUGIN_URL . 'assets/libs/angular-1.6.9.min.js', array('jquery'), '1.6.9');
            wp_enqueue_script(array('angularjs'));
        }
        public function show_option_fields(){
            $product_id = get_the_ID();
            $option_id = get_post_meta($product_id, '_nbo_option_id', true);
            if($option_id){
                $_options = $this->get_option($option_id);
                if($_options){
                    $options = unserialize($_options['fields']);
                    $product = wc_get_product($product_id);
                    $type = $product->get_type();
                    $variations = array();
                    if( $type == 'variable' ){
                        $all = get_posts( array(
                            'post_parent' => $product_id,
                            'post_type'   => 'product_variation',
                            'orderby'     => array( 'menu_order' => 'ASC', 'ID' => 'ASC' ),
                            'post_status' => 'publish',
                            'numberposts' => -1,
                        ));
                        foreach ( $all as $child ) {
                            $vid = $child->ID;
                            $variation = wc_get_product( $vid );
                            $variations[$vid] = $variation->get_price();
                        }
                    }
                    nbdesigner_get_template('single-product/option-builder.php', array(
                        'options'   =>  $options,
                        'type'  => $type,
                        'price'  =>  $product->get_price(),
                        'is_sold_individually'  =>  $product->is_sold_individually(),
                        'variations'  => json_encode( (array) $variations )
                    ));
                    $bulk_variation_form = ob_get_clean();
                    echo $bulk_variation_form;
                }
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