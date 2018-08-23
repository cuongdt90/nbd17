<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if(!class_exists('NBD_FRONTEND_PRINTING_OPTIONS')){
    class NBD_FRONTEND_PRINTING_OPTIONS {
        protected static $instance;
        public $is_edit_mode = FALSE;
        /** Holds the cart key when editing a product in the cart **/
        public $cart_edit_key = NULL;
        /** Edit option in cart helper **/
        public $new_add_to_cart_key = FALSE;
        public function __construct() {
            if ( isset( $_REQUEST['nbo_cart_item_key'] ) && $_REQUEST['nbo_cart_item_key'] != '' ){
                $this->is_edit_mode = true;
                $this->cart_edit_key = $_REQUEST['nbo_cart_item_key'];
            }
        }
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
            
            /* Edit cart item */
            // handle customer input as order item meta
            add_filter( 'woocommerce_get_item_data', array( $this, 'get_item_data' ), 10, 2 );
            // Alters add to cart text when editing a product
            add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'add_to_cart_text' ), 9999, 1 );     
            // Remove product from cart when editing a product
            add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'remove_previous_product_from_cart' ), 99999, 6 );            
            // Alters the cart item key when editing a product
            add_action( 'woocommerce_add_to_cart', array( $this, 'add_to_cart' ), 10, 6 );
            // Change quantity value when editing a cart item
            add_filter( 'woocommerce_quantity_input_args', array( $this, 'quantity_input_args' ), 9999, 2 );
            // Redirect to cart when updating information for a cart item
            add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'add_to_cart_redirect' ), 9999, 1 );
            // Calculate totals on remove from cart/update
            //add_action( 'woocommerce_before_calculate_totals', array( $this, 'on_calculate_totals' ), 1, 1 );
            add_action( 'woocommerce_cart_loaded_from_session', array( $this, 're_calculate_price' ), 1, 1 );
            // Add meta to order
            add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'order_line_item' ), 50, 3 );
            
            // Alter the product thumbnail in cart
            add_filter( 'woocommerce_cart_item_thumbnail', array( $this, 'cart_item_thumbnail' ), 50, 2 );     
            
            /** Adds options to the array of items/products of an order **/
            add_filter( 'woocommerce_order_get_items', array( $this, 'order_get_items' ), 10, 2 );            
            
            // Add item data to the cart
            add_filter( 'woocommerce_add_cart_item_data', array( $this, 'add_cart_item_data' ), 10, 4 );
            
            // persist the cart item data, and set the item price (when needed) first, before any other plugins
            add_filter( 'woocommerce_get_cart_item_from_session', array( $this, 'get_cart_item_from_session' ), 1, 2 ); 

            // on add to cart set the price when needed, and do it first, before any other plugins
            add_filter( 'woocommerce_add_cart_item', array($this, 'set_product_prices'), 1, 1 );   

            // Adds edit link on product title in cart
            add_filter( 'woocommerce_cart_item_name', array( $this, 'cart_item_name' ), 50, 3 );
            
        }
        public function order_line_item( $item, $cart_item_key, $values ){
            if ( isset( $values['nbo_meta'] ) ) {
                foreach ($values['nbo_meta']['option_price']['fields'] as $field) {
                    $price = floatval($field['price']) >= 0 ? '+' . wc_price($field['price']) : wc_price($field['price']);
                    $item->add_meta_data( $field['name'], $field['value_name']. '&nbsp;&nbsp;' .$price );
                }
                $item->add_meta_data( __('Quantity Discount', 'web-to-print-online-designer'), '-' . wc_price($values['nbo_meta']['option_price']['discount_price']) );
            
                $item->add_meta_data('_nbo_option_price', $values['nbo_meta']['option_price']);
                $item->add_meta_data('_nbo_field', $values['nbo_meta']['field']);
                $item->add_meta_data('_nbo_options', $values['nbo_meta']['options']);
                $item->add_meta_data('_nbo_original_price', $values['nbo_meta']['original_price']);
            }
        }
        public function order_get_items( $items = array(), $order = FALSE ){

            return $items;
        }
        public function cart_item_thumbnail( $image = "", $cart_item = array() ){
            if( isset($cart_item['nbo_meta']) && $cart_item['nbo_meta']['option_price']['cart_image'] != '' ){
                $size = 'shop_thumbnail';
                $dimensions = wc_get_image_size( $size );              
                $image = '<img src="'.$cart_item['nbo_meta']['option_price']['cart_image']
                        . '" width="' . esc_attr( $dimensions['width'] )
                        . '" height="' . esc_attr( $dimensions['height'] )
                        . '" class="nbo-thumbnail woocommerce-placeholder wp-post-image" />';
            }
            return $image;
        }
        public function re_calculate_price( $cart ){
            foreach ( $cart->cart_contents as $cart_item_key => $cart_item ) {
                if( isset($cart_item['nbo_meta']) ){
                    //$product = $cart_item['data'];
                    $variation_id = $cart_item['variation_id'];
                    $variation_id = $cart_item['product_id'];
                    $product = $variation_id ? wc_get_product( $variation_id ) : wc_get_product( $product_id );
                    $options = $cart_item['nbo_meta']['options'];
                    $fields = $cart_item['nbo_meta']['field'];
                    $original_price = $this->format_price( $product->get_price('edit') );
                    $quantity = $cart_item['quantity'];
                    $option_price = $this->option_processing( $options, $original_price, $fields, $quantity );
                    $adjusted_price = $this->format_price($original_price + $option_price['total_price'] - $option_price['discount_price']);
                    
                    WC()->cart->cart_contents[ $cart_item_key ]['nbo_meta']['option_price'] = $option_price;
                    WC()->cart->cart_contents[ $cart_item_key ]['nbo_meta']['price'] = $adjusted_price;
                    WC()->cart->cart_contents[ $cart_item_key ]['data']->set_price( $adjusted_price );                    
                }
            }
        }
        public function remove_previous_product_from_cart( $passed, $product_id, $qty, $variation_id = '', $variations = array(), $cart_item_data = array() ){
            if ( $this->cart_edit_key ) {
                $cart_item_key = $this->cart_edit_key;
                if ( isset( $this->new_add_to_cart_key ) ) {
                    if ( $this->new_add_to_cart_key == $cart_item_key && isset( $_POST['quantity'] ) ) {
                        WC()->cart->set_quantity( $this->new_add_to_cart_key, $_POST['quantity'], TRUE );
                    } else {
                        WC()->cart->remove_cart_item( $cart_item_key );
                        unset( WC()->cart->removed_cart_contents[ $cart_item_key ] );
                    }
                }
            }
            return $passed;
        }
        public function add_to_cart_redirect( $url = "" ){
            if ( empty( $_REQUEST['add-to-cart'] ) || !is_numeric( $_REQUEST['add-to-cart'] ) ) {
                return $url;
            }  
            if ( $this->cart_edit_key ) {
                $url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : WC()->cart->get_cart_url();
            }
            return $url;
        }
        public function quantity_input_args( $args = "", $product = "" ){
            if ( $this->cart_edit_key ) {
                $cart_item_key = $this->cart_edit_key;
                $cart_item = WC()->cart->get_cart_item( $cart_item_key );
                if ( isset( $cart_item["quantity"] ) ) {
                        $args["input_value"] = $cart_item["quantity"];
                }
            }
            return $args;
        }
        public function add_to_cart_text($var){
            if( $this->is_edit_mode ){
                return esc_attr__( 'Update cart', 'woocommerce' );
            }
            return $var;
        }
        public function add_to_cart( $cart_item_key = "", $product_id = "", $quantity = "", $variation_id = "", $variation = "", $cart_item_data = "" ){
            if ( $this->cart_edit_key ) {
                $this->new_add_to_cart_key = $cart_item_key;
            }else{
                if (is_array($cart_item_data) && isset($cart_item_data['nbo_meta'])) {
                    $cart_contents = WC()->cart->cart_contents;
                    if (
                        is_array($cart_contents) &&
                        isset($cart_contents[$cart_item_key]) &&
                        !empty($cart_contents[$cart_item_key]) &&
                        !isset($cart_contents[$cart_item_key]['nbo_cart_item_key'])) {
                        WC()->cart->cart_contents[$cart_item_key]['nbo_cart_item_key'] = $cart_item_key;
                    }
                }
            }
        }
        public function cart_item_name($title = "", $cart_item = array(), $cart_item_key = ""){
            if ( !(is_cart() || is_checkout()) ){
                return $title;
            }
            if ( !isset( $cart_item['nbo_meta'] ) ) {
                return $title;
            }
            $product = $cart_item['data'];
            $link = add_query_arg(
                array(
                    'nbo_cart_item_key'  => $cart_item_key,
                )
                , $product->get_permalink( $cart_item ) ); 
            $link = wp_nonce_url( $link, 'nbo-edit' );
            $title .= '<p><a href="' . $link . '" class="nbo-cart-edit-options">' . __( 'Edit options', 'web-to-print-online-designer' ) . '</a></p>';
            return $title;
        }
        public function get_item_data( $item_data, $cart_item ){
            if ( isset( $cart_item['nbo_meta'] ) ) {
                foreach ($cart_item['nbo_meta']['option_price']['fields'] as $field) {
                    $price = floatval($field['price']) >= 0 ? '+' . wc_price($field['price']) : wc_price($field['price']);
                    $item_data[] = array(
                        'name' => $field['name'],
                        'display' => $field['value_name']. '&nbsp;&nbsp;' .$price,
                        'hidden' => false                        
                    );
                }
                $item_data[] = array(
                    'name' => __('Quantity Discount', 'web-to-print-online-designer'),
                    'display' => '-' . wc_price($cart_item['nbo_meta']['option_price']['discount_price']),
                    'hidden' => false                        
                );                
            }
            return $item_data;
        }
        public function get_cart_item_from_session( $cart_item, $values ){
            if ( isset( $values['nbo_meta'] ) ) {
                $cart_item['nbo_meta'] = $values['nbo_meta'];
                // set the product price (if needed)
                $cart_item = $this->set_product_prices( $cart_item );
            }
            return $cart_item;            
        }
        public function add_cart_item_data( $cart_item_data, $product_id, $variation_id, $quantity ){
            $post_data = $_POST;
            $option_id = $this->get_product_option($product_id);
            if( isset($post_data['nbd-field']) ){
                $options = $this->get_option($option_id);
                $product = $variation_id ? wc_get_product( $variation_id ) : wc_get_product( $product_id );
                $original_price = $this->format_price( $product->get_price('edit') );
                $option_price = $this->option_processing( $options, $original_price, $post_data['nbd-field'], $quantity );
                $cart_item_data['nbo_meta']['option_price'] = $option_price;
                $cart_item_data['nbo_meta']['field'] = $post_data['nbd-field'];
                $cart_item_data['nbo_meta']['options'] = $options;
                $cart_item_data['nbo_meta']['original_price'] = $original_price;
                $cart_item_data['nbo_meta']['price'] = $this->format_price($original_price + $option_price['total_price'] - $option_price['discount_price']);
            }
            return $cart_item_data;
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
        public function get_field_by_id( $option_fields, $field_id ){
            foreach($option_fields['fields'] as $key => $field){
                if( $field['id'] == $field_id ) return $field;
            }
        }
        public function option_processing( $options, $original_price, $fields, $quantity ){
            $option_fields = unserialize($options['fields']);
            $quantity_break = $this->get_quantity_break( $option_fields, $quantity );
            $xfactor = 1;
            $total_price = 0;
            $discount_price = 0;
            $_fields = array();
            $cart_image = '';
            foreach($fields as $key => $val){
                $origin_field = $this->get_field_by_id( $option_fields, $key );
                $_fields[$key] = array(
                    'name'  =>  $origin_field['general']['title'],
                    'val'   =>  $val,
                    'value_name'   =>  $val
                );                
                if( $origin_field['general']['data_type'] == 'i' ){
                    if($origin_field['general']['depend_quantity'] == 'n'){
                        $factor = $origin_field['general']['price'];
                    }else{
                        if( $quantity_break['index'] == 0 && $quantity_break['oparator'] == 'lt' ){
                            $factor = '';
                        }else{
                            $factor = $origin_field['general']['price_breaks'][$quantity_break['index']];
                        }
                    }
                }else{
                    $option = $origin_field['general']['attributes']['options'][$val];
                    $_fields[$key]['value_name'] = $option['name'];
                    if($origin_field['general']['depend_quantity'] == 'n'){
                        $factor = $option['price'][0];
                    }else{
                        if( $quantity_break['index'] == 0 && $quantity_break['oparator'] == 'lt' ){
                            $factor = '';
                        }else{
                            $factor = $option['price'][$quantity_break['index']];
                        }
                    }
                    if($origin_field['appearance']['change_image_product'] == 'y' && $option['preview_type'] == 'i'){
                        $image = wp_get_attachment_image_src( $option['image'], 'thumbnail' );
                        if($image){
                            $cart_image = $image[0];
                        }else{
                            $cart_image = wp_get_attachment_url($option['image']);
                        }
                    }
                }
                $factor = floatval($factor);
                $_fields[$key]['is_pp'] = 0;
                switch ($origin_field['general']['price_type']){
                    case 'f':
                        $_fields[$key]['price'] = $factor;
                        $total_price += $factor;
                        break;
                    case 'p':
                        $_fields[$key]['price'] = $original_price * $factor / 100;
                        $total_price += $original_price * $factor / 100;
                        break;    
                    case 'p+':
                        $_fields[$key]['price'] = $factor / 100;
                        $_fields[$key]['is_pp'] = 1;
                        $xfactor *= (1 + $factor / 100);
                        break;
                    case 'c':
                        $_fields[$key]['price'] = $factor * absint( $val );
                        $total_price = $factor * absint( $val );
                        break;       
                }
            }
            $total_price += ( ($original_price + $total_price ) * ($xfactor - 1 ) );
            foreach($_fields as $key => $val){
                if( $_fields[$key]['is_pp'] == 1 ) {
                    $_fields[$key]['price'] = $_fields[$key]['price'] * ($original_price + $total_price ) / ( $_fields[$key]['price'] + 1 );
                }
            }
            if( $quantity_break['index'] == 0 && $quantity_break['oparator'] == 'lt' ){
                $qty_factor = '';
            }else{
                $qty_factor = $option_fields['quantity_breaks'][$quantity_break['index']]['dis'];
            }
            $qty_factor = floatval($qty_factor);
            $discount_price = $option_fields['quantity_discount_type'] == 'f' ? $qty_factor : ($original_price + $total_price ) * $qty_factor / 100;
            return array(
                'total_price' =>  $total_price,
                'discount_price' =>  $discount_price,
                'fields'    => $_fields,
                'cart_image'    =>  $cart_image
            );
        }
        public function get_quantity_break( $options, $quantity ){
            $quantity_break = array('index' =>  0, 'oparator' => 'gt');
            $quantity_breaks = array();          
            foreach( $options['quantity_breaks'] as $break ){
                $quantity_breaks[] = absint($break['val']);
            }
            foreach($quantity_breaks as $key => $break){
                if( count( $quantity_breaks ) == 1 && $key == 0 && $quantity < $break){
                    $quantity_break = array('index' =>  0, 'oparator' => 'lt');
                }
                if( $quantity >= $break && $key < ( count( $quantity_breaks ) - 1 ) ){
                    $quantity_break = array('index' =>  $key, 'oparator' => 'bw');
                }
                if( $key == ( count( $quantity_breaks ) - 1 ) && $quantity >= $break){
                    $quantity_break = array('index' =>  $key, 'oparator' => 'gt');
                }               
            }
              
            return $quantity_break;
        }
        public function set_product_prices( $cart_item ){
            if ( isset( $cart_item['nbo_meta'] )){
                $new_price = (float) $cart_item['nbo_meta']['price'];
                $cart_item['data']->set_price( $new_price );
            }
            return $cart_item;
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
            $option_id = $this->get_product_option($product_id);
            if($option_id){
                $_options = $this->get_option($option_id);
                if($_options){
                    $options = unserialize($_options['fields']);
                    foreach ($options['fields'] as $key => $field){
                        if($field['appearance']['change_image_product'] == 'y'){
                            foreach ($field['general']['attributes']['options'] as $op_index => $option ){
                                $attachment_id = absint($option['image']);
                                if( $attachment_id != 0 && $option['preview_type'] == 'i' ){
                                    $image_link = wp_get_attachment_url($attachment_id);
                                    $attachment_object = get_post( $attachment_id );
                                    $full_src = wp_get_attachment_image_src( $attachment_id, 'large' );
                                    $image_title = get_the_title( $attachment_id );
                                    $image_alt = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', TRUE ) ) );
                                    $image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $attachment_id, 'shop_single' ) : FALSE;
                                    $image_sizes = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $attachment_id, 'shop_single' ) : FALSE;
                                    $image_caption = $attachment_object->post_excerpt;                                    
                                    $options['fields'][$key]['general']['attributes']['options'][$op_index] = array_replace_recursive($options['fields'][$key]['general']['attributes']['options'][$op_index], array(
                                        'imagep'    =>  'y',
                                        'image_link'    => $image_link,
                                        'image_title'   => $image_title,
                                        'image_alt'     => $image_alt,
                                        'image_srcset'  => $image_srcset,
                                        'image_sizes'   => $image_sizes,
                                        'image_caption' => $image_caption,
                                        'full_src'      => $full_src[0],
                                        'full_src_w'    => $full_src[1],
                                        'full_src_h'    => $full_src[2]
                                        
                                    ));
                                }else{
                                    $options['fields'][$key]['general']['attributes']['options'][$op_index]['imagep'] = 'n';
                                }
                            }   
                        }
                    }
                    $product = wc_get_product($product_id);
                    $type = $product->get_type();
                    $variations = array();
                    $form_values = array();
                    $cart_item_key = '';
                    if( isset($_POST['nbd-field']) ){
                        $form_values = $_POST['nbd-field'];
                    }else if( isset($_GET['nbo_cart_item_key']) && $_GET['nbo_cart_item_key'] != '' ){
                        $cart_item_key = $_GET['nbo_cart_item_key'];
                        $cart_item = WC()->cart->get_cart_item( $cart_item_key );
                        if( isset($cart_item['nbo_meta']) ){
                            $form_values = $cart_item['nbo_meta']['field'];
                        }
                    }
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
                        'product_id'  =>   $product_id,
                        'options'   =>  $options,
                        'type'  => $type,
                        'price'  =>  $product->get_price(),
                        'is_sold_individually'  =>  $product->is_sold_individually(),
                        'variations'  => json_encode( (array) $variations ),
                        'form_values'  => $form_values,
                        'cart_item_key'  => $cart_item_key
                    ));
                    $bulk_variation_form = ob_get_clean();
                    echo $bulk_variation_form;
                }
            }
        }
        public function get_product_option($product_id){
            $option_id = get_post_meta($product_id, '_nbo_option_id', true);
            //todo option category
            return $option_id;
        }
        public function get_option( $id ){
            global $wpdb;
            $sql = "SELECT * FROM {$wpdb->prefix}nbdesigner_options";
            $sql .= " WHERE id = " . esc_sql($id);
            $result = $wpdb->get_results($sql, 'ARRAY_A');
            return count($result[0]) ? $result[0] : false;
        }
    }
}
$nbd_fontend_printing_options = NBD_FRONTEND_PRINTING_OPTIONS::instance();
$nbd_fontend_printing_options->init();