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
            add_action('nbd_after_option_product_design', array($this, 'product_design_setting'), 10, 3);
            //add_filter('nbdesigner_appearance_settings', array($this, 'appearance_settings'), 10, 1);
            //add_filter('nbdesigner_default_frontend_settings', array($this, 'default_frontend_settings'), 10, 1);
            add_action('nbd_classic_helpdesk_nav', array($this, 'nbd_classic_helpdesk_nav'), 30);
            add_action('nbd_classic_helpdesk_content', array($this, 'nbd_classic_helpdesk_content'), 30);
            add_action('before_nbd_save_cart_design', array($this, 'before_nbd_save_cart_design'), 30, 1);
            add_action('after_nbd_save_cart_design', array($this, 'after_nbd_save_cart_design'), 30, 1);
            add_action('nbd_after_single_product_design_section', array($this, 'color_swatch'), 30, 2);
            add_action('nbd_save_customer_design_product_config', array($this, 'product_config'), 30, 3);
            add_filter('nbd_product_info', array($this, 'nbd_product_info'), 10, 1);
            $this->ajax();
        }
        public function before_nbd_save_cart_design( $post ){
            if( isset($post['task2']) && $post['task2'] == 'cuz' ){
                WC()->session->set('nbd_item_key_'.$post['product_id'], $post['nbd_item_key']);
                WC()->session->set('nbu_item_key_'.$post['product_id'], $post['nbu_item_key']);     
            }
        }
        public function after_nbd_save_cart_design( $post ){
            if( isset($post['task2']) && $post['task2'] == 'cuz' ){
                WC()->session->__unset('nbd_item_key_'.$post['product_id']);
                WC()->session->__unset('nbu_item_key_'.$post['product_id']);     
            }    
        }
        public function ajax(){
            $ajax_events = array(
                'nbdesigner_add_color_group'   =>  false,
                'nbdesigner_delete_color_group'   =>  false,
                'nbdesigner_delete_color'   =>  false
            );
            foreach ($ajax_events as $ajax_event => $nopriv) {
                add_action('wp_ajax_' . $ajax_event, array($this, $ajax_event));
                if ($nopriv) {
                    // NBDesigner AJAX can be used for frontend ajax requests
                    add_action('wp_ajax_nopriv_' . $ajax_event, array($this, $ajax_event));
                }
            }
        }
        public function nbd_classic_helpdesk_nav(){
            ?>
            <li><a href="#customize-help"><?php _e('Get start', 'web-to-print-online-designer'); ?></a></li>
            <?php
        }
        public function nbd_classic_helpdesk_content(){
            ?>
            <div id="customize-help">
                <?php echo stripslashes(nbdesigner_get_option('nbdesigner_classic_helpdesk')); ?>
            </div>
            <?php
        }
        public function appearance_settings( $options ){
            $options['editor'][] =  array(
                'title' => __('Helpdesk content', 'web-to-print-online-designer'),
                'id' => 'nbdesigner_classic_helpdesk',
                'description' => __( 'This content will replace default helpdesk in calssic layout.', 'web-to-print-online-designer'),
                'default'	=> '',
                'type' 		=> 'textarea',
                'class' 	=> 'nbd-tinymce',
                'layout' 	=> 'c'
            );
            return $options;
        }
        public function default_frontend_settings( $settings ){
            $settings['nbdesigner_classic_helpdesk'] = '';
            return $settings;
        }
        public function nbdesigner_add_color_group(){
            $data = array(
                'mes'   =>  __('You do not have permission to add/edit color category!', 'web-to-print-online-designer'),
                'flag'  => 0
            );
            if (!wp_verify_nonce($_POST['nonce'], 'nbdesigner_add_cat') || !current_user_can('manage_nbd_tool')) {
                wp_send_json($data);
                wp_die();
            }
            $path = NBDESIGNER_DATA_DIR . '/color_cat.json';
            $cat = array(
                'name' => sanitize_text_field($_POST['name']),
                'slug' => nbd_alias($_POST['name']),
                'id' => $_POST['id']
            );
            Nbdesigner_IO::update_json_setting($path, $cat, $cat['id']);
            $data['mes'] = __('Category has been added/edited successfully!', 'web-to-print-online-designer');
            $data['flag'] = 1;
            wp_send_json($data);
        }
        public function nbdesigner_delete_color_group(){
            $data = array(
                'mes'   =>  __('You do not have permission to delete color category!', 'web-to-print-online-designer'),
                'flag'  => 0
            );
            if (!wp_verify_nonce($_POST['nonce'], 'nbdesigner_add_cat') || !current_user_can('manage_nbd_tool')) {
                wp_send_json($data);
            }
            $path = NBDESIGNER_DATA_DIR . '/color_cat.json';
            $id = $_POST['id'];
            Nbdesigner_IO::delete_json_setting($path, $id, true);
            $color_path = NBDESIGNER_DATA_DIR . '/colors.json';
            Nbdesigner_IO::update_json_setting_depend($color_path, $id);
            $data['mes'] = __('Category has been delete successfully!', 'web-to-print-online-designer');
            $data['flag'] = 1;
            wp_send_json($data);
        }
        public function nbdesigner_delete_color(){
            $data = array(
                'mes'   =>  __('You do not have permission to delete clipart!', 'web-to-print-online-designer'),
                'flag'  => 0
            );
            if (!wp_verify_nonce($_POST['nonce'], 'nbdesigner_add_cat') || !current_user_can('manage_nbd_tool')) {
                wp_send_json($data);
            }
            $id = $_POST['id'];
            $path = NBDESIGNER_DATA_DIR . '/colors.json';
            Nbdesigner_IO::delete_json_setting($path, $id);
            $data['mes'] = __('color has been deleted successfully!', 'web-to-print-online-designer');
            $data['flag'] = 1;
            wp_send_json($data);
        }
        public function manage_color_menu(){
            add_submenu_page(
                'nbdesigner', __('NB manage color', 'web-to-print-online-designer'), __('Manage color', 'web-to-print-online-designer'), 'manage_nbd_tool', 'manage_color', array($this, 'manage_color')
            ); 
            add_submenu_page(
                'nbdesigner', __('NB Customize', 'web-to-print-online-designer'), __('Customize', 'web-to-print-online-designer'), 'manage_nbd_tool', 'etsy_order', array($this, 'etsy_order')
            ); 
        }
        public function etsy_order(){
            $order_number = $product_id = $start_design_link = '';
            $link_redirect = get_option('nbd_etsy_link_redirect');
            if( isset( $_POST['etsy_order'] ) ){
                $order_number = $_POST['order_number'];
                $product_id = $_POST['product_id'];
                $link_redirect = $link_redirect ? $link_redirect : home_url();
                //check order before create
                if( isset($_POST['link_redirect']) && $_POST['link_redirect'] != '' ){
                    $link_redirect = $_POST['link_redirect'];
                    update_option('nbd_etsy_link_redirect', $_POST['link_redirect']);
                }
                $orders = get_posts( array(
                    'numberposts' => 1,
                    'meta_key'    => '_etsy_order_number',
                    'meta_value'    => $order_number,
                    'post_type'   => wc_get_order_types(),
                    'post_status' => array_keys( wc_get_order_statuses() )
                ) ); 
                if( count($orders) ){
                    $order = wc_get_order($orders[0]->ID);
                    $items = $order->get_items();
                    reset($items);
                    $item_id = key($items);  
                    $order_product_id = $items[$item_id]->get_product_id();
                    if( $order_product_id == $product_id ){
                        $nbd_item_key = wc_get_order_item_meta($item_id, "_nbd");
                        $nbu_item_key = wc_get_order_item_meta($item_id, "_nbu");
                    }else{
                        $item_key = $this->make_etsy_order($order_number, $product_id);
                        $nbd_item_key = $item_key['nbd_item_key'];
                        $nbu_item_key = $item_key['nbu_item_key'];
                    }
                }else{
                    $item_key = $this->make_etsy_order($order_number, $product_id);
                    $nbd_item_key = $item_key['nbd_item_key'];
                    $nbu_item_key = $item_key['nbu_item_key'];
                }
                $start_design_link =  add_query_arg(
                    array(
                        'task2'  =>  'cuz',
                        'nbd_item_key'  =>  $nbd_item_key,
                        'nbu_item_key'  =>  $nbu_item_key,
                        'product_id'  =>  $product_id,
                        'rd'    =>  urlencode($link_redirect)), 
                    getUrlPageNBD('create'));
            }
            $etsy_orders = new Etsy_Order_List_Table();
            include_once(NBDESIGNER_PLUGIN_DIR . 'views/cuz/etsy-order.php');
        }
        public function make_etsy_order( $order_number, $product_id ){
            $customer_id = get_current_user_id();
            $order = wc_create_order( $args = array(
                'status'      => 'compelte',
                'customer_id'      => $customer_id
            ));
            $order_id = $order->get_id();
            $order->add_product( wc_get_product($product_id), 1);
            update_post_meta($order_id, '_etsy_order_number', $order_number);
            update_post_meta($order_id, '_nbd', 1);
            update_post_meta($order_id, '_nbu', 1);
            $nbd_item_key = substr(md5(uniqid()),0,5).rand(1,100).time();
            $nbu_item_key = substr(md5(uniqid()),0,5).rand(1,100).time();
            $items = $order->get_items();
            reset($items);
            $item_id = key($items);
            wc_add_order_item_meta($item_id, "_nbd", $nbd_item_key);
            wc_add_order_item_meta($item_id, "_nbu", $nbu_item_key);
            return array(
                'nbd_item_key' => $nbd_item_key,
                'nbu_item_key' => $nbu_item_key
            );
        }
        public function manage_color(){
            include_once(NBDESIGNER_PLUGIN_DIR . 'views/cuz/manage-color.php');
        }
        public function product_design_setting( $post_id, $option, $designer_setting ){
            include_once(NBDESIGNER_PLUGIN_DIR . 'views/cuz/product-settings.php');
        }
        public function color_swatch($pid, $option){
            if( isset($option['att_swatch']) ){
                $att_swatch = '#' . str_replace(' ', '-', strtolower($option['att_swatch']));
            ?>
            <script type="text/javascript">
                NBDESIGNERPRODUCT = NBDESIGNERPRODUCT || {};
                jQuery('<?php echo $att_swatch; ?>').on('change', function(){
                    NBDESIGNERPRODUCT.att_swatch = jQuery(this).val();
                });
                jQuery(document).ready(function(){
                    if(jQuery('<?php echo $att_swatch; ?>').val() != ''){
                        NBDESIGNERPRODUCT.att_swatch = jQuery(this).val();
                    }
                });
                window.addEventListener("message", receiveMessage, false);
                function receiveMessage(event){
                    if(typeof event.data == 'string'){                      
                        if( event.origin == window.location.origin && event.data.indexOf('change_nbd_swatch') > -1  ){
                            var data = event.data.split("---");console.log(data[1]);
                            jQuery('<?php echo $att_swatch; ?>').val(data[1]);
                            jQuery('<?php echo $att_swatch; ?>').trigger('change');
                        };
                    }
                };                
            </script>
            <?php }
        }
        public function nbd_product_info($data){
            if( isset($data['option']['att_swatch']) ){
                if(isset($data['option']['swatch_preview'])){
                    foreach ($data['option']['swatch_preview'] as $s_key => $swatch){
                        $data['option']['swatch_preview'][$s_key] = wp_get_attachment_thumb_url($swatch);
                    }
                }
                if(isset($data['option']['swatches'])){
                    foreach ($data['option']['swatches'] as $s_key => $swatch){
                        foreach ($data['product'] as $side_key => $side){
                            $data['option']['swatches'][$s_key][$side_key]['image'] = wp_get_attachment_url( $swatch[$side_key]['image'] );
                            $data['option']['swatches'][$s_key][$side_key]['color'] = $swatch[$side_key]['color'];
                        }
                    }
                }
            }
            return $data;
        }
        public function product_config($product_config, $product_option, $att_swatch){
            if( isset($data['option']['att_swatch']) && isset($data['option']['swatches'])){
                $swatch = $data['option']['swatches'][$att_swatch];
                foreach ($product_config as $side_key => $side){
                    $product_config[$side_key]['bg_color_value'] = wp_get_attachment_url($swatch['image']);
                    $product_config[$side_key]['img_src'] = $swatch['color'];
                }
            }
            return $product_config;
        }
    }
}
$nbd_cuz = NBD_CUSTOMIZE::instance();
$nbd_cuz->init();
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class Etsy_Order_List_Table extends WP_List_Table {
    public function __construct() {
        parent::__construct(array(
            'singular' => __('Order', 'web-to-print-online-designer'), 
            'plural' => __('Orders', 'web-to-print-online-designer'), 
            'ajax' => false 
        ));
    }
    public function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = self::record_count();
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => $per_page 
        ));
        $this->items = self::get_orders($per_page, $current_page);
    }
    public function get_orders($per_page = 10, $page_number = 1) {
        $orders = get_posts( array(
            'numberposts' => $per_page,
            'offset'         => $per_page * ( $page_number - 1 ),
            'meta_key'    => '_etsy_order_number',
            'post_type'   => wc_get_order_types(),
            'post_status' => array_keys( wc_get_order_statuses() ),
        ) );  
        return $orders;
    }  
    public static function record_count() {
        $orders = get_posts( array(
            'numberposts' => -1,
            'meta_key'    => '_etsy_order_number',
            'post_type'   => wc_get_order_types(),
            'post_status' => array_keys( wc_get_order_statuses() ),
        ) );
        return count($orders);
    }
    function column_default($item, $column_name){
        return $item[$column_name];
    }    
    function column_order($item){
        $etsy_order = get_post_meta($item->ID, '_etsy_order_number', true);
        $url = admin_url('post.php?post=' . absint( $item->ID ) . '&action=edit');
        return '<a href="' . $url . '#nbdesigner_order">#' .$item->ID. '</a> - <b>' . __('Etsy order number: ', 'web-to-print-online-designer').$etsy_order.'</b>';
    }
    function column_link($item){
        $order = wc_get_order($item->ID);
        $items = $order->get_items();
        reset($items);
        $item_id = key($items);
        $nbd_item_key = wc_get_order_item_meta($item_id, "_nbd");
        $nbu_item_key = wc_get_order_item_meta($item_id, "_nbu");
        $link_redirect = get_option('nbd_etsy_link_redirect');
        $link_redirect = $link_redirect ? $link_redirect : home_url();        
        $start_design_link =  add_query_arg(
            array(
                'task2'  =>  'cuz',
                'nbd_item_key'  =>  $nbd_item_key,
                'nbu_item_key'  =>  $nbu_item_key,
                'product_id'  =>  $items[$item_id]->get_product_id(),
                'rd'    =>  urlencode($link_redirect)), 
            getUrlPageNBD('create'));        
        return $start_design_link;
    }    
    function get_columns() {
        $columns = array(          
            'order' => __('Order', 'web-to-print-online-designer'),
            'link' => __('Start design link', 'web-to-print-online-designer')
        );
        return $columns;
    }
    
}
