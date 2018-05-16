<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if(!class_exists('NBD_ADMIN_PRINTING_OPTIONS')){
    class NBD_ADMIN_PRINTING_OPTIONS {
        protected static $instance;
        public function __construct() {
            //todo something
        }
	public static function instance() {
            if ( is_null( self::$instance ) ) {
                    self::$instance = new self();
            }
            return self::$instance;
	}        
        public function init(){
            add_action('nbd_menu', array($this, 'tab_menu'));   
            add_action('nbd_create_tables', array($this, 'create_options_table'));  
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 30, 1);
            add_action( 'init', array( $this, 'create_taxonomy' ), 0);
            add_action('init', array( $this, 'create_custom_post_type'));
        }
        public function tab_menu(){
            if(current_user_can('manage_nbd_tool')){  
                $options_hook = add_submenu_page(
                    'nbdesigner', 'Printing Options', 'Printing Options', 'manage_nbd_tool', 'nbd_printing_options', array($this, 'printing_options')
                );
                $options_hook_category = add_submenu_page(
                    'nbdesigner', 'Category', 'Category', 'manage_nbd_tool', 'edit-tags.php?taxonomy=category&post_type=clipart'
                );
                add_action( "load-$options_hook", array( $this, 'screen_option' ));
            }             
        }
        public function create_options_table(){
            global $wpdb;
            $collate = '';
            if ( $wpdb->has_cap( 'collation' ) ) {
                $collate = $wpdb->get_charset_collate();
            } 
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            if (NBDESIGNER_VERSION != get_option("nbdesigner_version_plugin")) {        
                $tables =  "
CREATE TABLE {$wpdb->prefix}nbdesigner_options ( 
 id bigint(20) unsigned NOT NULL auto_increment,
 title text NOT NULL,
 priority  TINYINT(1) NOT NULL default 0, 
 product_ids text NULL, 
 product_cats text NULL,  
 enabled_roles text NULL,  
 disabled_roles text NULL,  
 created datetime NOT NULL default '0000-00-00 00:00:00',
 modified datetime NOT NULL default '0000-00-00 00:00:00', 
 created_by BIGINT(20) NULL, 
 modified_by BIGINT(20) NULL,  
 fields longtext,
 PRIMARY KEY  (id)
) $collate; 
                ";
                @dbDelta($tables);                
            }    
        }
        public function admin_enqueue_scripts( $hook ){
            if( $hook == 'nbdesigner_page_nbd_printing_options' ){
                wp_register_style('nbd_options', NBDESIGNER_CSS_URL . 'admin-options.css', array('wp-color-picker'), NBDESIGNER_VERSION);
                wp_register_script('angularjs', NBDESIGNER_PLUGIN_URL . 'assets/libs/angular-1.6.9.min.js', array('jquery'), '1.6.9');                   
                wp_register_script('nbd_options', NBDESIGNER_JS_URL . 'admin-options.js', array('jquery', 'jquery-ui-resizable', 'jquery-ui-draggable', 'jquery-ui-autocomplete', 'wp-color-picker', 'angularjs'), NBDESIGNER_VERSION);             
                wp_localize_script('nbd_options', 'nbd_options', array(
                    'nbd_options_lang' => nbd_option_i18n()
                ));   
                wp_enqueue_style(array('wp-jquery-ui-dialog', 'wp-color-picker', 'nbd_options'));
                wp_enqueue_script(array('wpdialogs', 'nbd_options'));   	
            }
        }
        public function printing_options(){ 
            require_once NBDESIGNER_PLUGIN_DIR . 'includes/options/fields-list-table.php';
            $nbd_options = new NBD_Options_List_Table();       
            if( isset( $_GET['action'] ) ){    
                if( $_GET['action'] == 'delete' ){
                    wp_redirect(esc_url_raw(add_query_arg(array('paged' => 1), admin_url('admin.php?page=nbd_printing_options'))));
                }else{
                    if( isset( $_POST['save'] ) ){
                        $this->save_option();
                    }                    
                    $_options = $this->get_option();//$_options = false;
                    if($_options){
                        $options = $this->build_options( unserialize($_options['fields']) );
                        $options['id'] = $_options['id'];
                        $options['title'] = $_options['title'];
                        $options['priority'] = $_options['priority'];                   
                    }else{
                        $options = $this->build_options();
                        $options['id'] = 0;
                        $options['title'] = '';
                        $options['priority'] = 1;                     
                    }
                    $default_field = $this->default_config_field();                      
                    $message = array(
                        'content' =>    'success',
                        'flag'  =>  'success'
                    );
                    include_once(NBDESIGNER_PLUGIN_DIR . 'views/options/edit-option.php');
                }
            }else{
                include_once(NBDESIGNER_PLUGIN_DIR . 'views/options/options-list-table.php');
            }
        }
        public function create_taxonomy(){

            $labels = array(
                'name'              => _x( 'category', 'taxonomy general name', 'web-to-print-online-designer' ),
                'singular_name'     => _x( 'category', 'taxonomy singular name', 'web-to-print-online-designer' ),
                'search_items'      => __( 'Search category', 'web-to-print-online-designer' ),
                'all_items'         => __( 'All category', 'web-to-print-online-designer' ),
                'parent_item'       => __( 'Parent category', 'web-to-print-online-designer' ),
                'parent_item_colon' => __( 'Parent category:', 'web-to-print-online-designer' ),
                'edit_item'         => __( 'Edit category', 'web-to-print-online-designer' ),
                'update_item'       => __( 'Update category', 'web-to-print-online-designer' ),
                'add_new_item'      => __( 'Add New category', 'web-to-print-online-designer' ),
                'new_item_name'     => __( 'New category Name', 'web-to-print-online-designer' ),
                'menu_name'         => __( 'category', 'web-to-print-online-designer' ),
            );
            $args = array(
                'labels' => $labels,
                'description' => __( 'category for cliparts', 'web-to-print-online-designer' ),
                'hierarchical' => false,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'show_in_rest' => false,
                'show_tagcloud' => true,
                'show_in_quick_edit' => true,
                'show_admin_column' => true,
            );
            register_taxonomy( 'category', array('clipart'), $args );

        }
        public function create_custom_post_type(){

            $labels = array(
                'name' => __( 'cliparts', 'Post Type General Name', 'web-to-print-online-designer' ),
                'singular_name' => __( 'clipart', 'Post Type Singular Name', 'web-to-print-online-designer' ),
                'menu_name' => __( 'cliparts', 'web-to-print-online-designer' ),
                'name_admin_bar' => __( 'clipart', 'web-to-print-online-designer' ),
                'archives' => __( 'clipart Archives', 'web-to-print-online-designer' ),
                'attributes' => __( 'clipart Attributes', 'web-to-print-online-designer' ),
                'parent_item_colon' => __( 'Parent clipart:', 'web-to-print-online-designer' ),
                'all_items' => __( 'All cliparts', 'web-to-print-online-designer' ),
                'add_new_item' => __( 'Add New clipart', 'web-to-print-online-designer' ),
                'add_new' => __( 'Add New', 'web-to-print-online-designer' ),
                'new_item' => __( 'New clipart', 'web-to-print-online-designer' ),
                'edit_item' => __( 'Edit clipart', 'web-to-print-online-designer' ),
                'update_item' => __( 'Update clipart', 'web-to-print-online-designer' ),
                'view_item' => __( 'View clipart', 'web-to-print-online-designer' ),
                'view_items' => __( 'View cliparts', 'web-to-print-online-designer' ),
                'search_items' => __( 'Search clipart', 'web-to-print-online-designer' ),
                'not_found' => __( 'Not found', 'web-to-print-online-designer' ),
                'not_found_in_trash' => __( 'Not found in Trash', 'web-to-print-online-designer' ),
                'featured_image' => __( 'Featured Image', 'web-to-print-online-designer' ),
                'set_featured_image' => __( 'Set featured image', 'web-to-print-online-designer' ),
                'remove_featured_image' => __( 'Remove featured image', 'web-to-print-online-designer' ),
                'use_featured_image' => __( 'Use as featured image', 'web-to-print-online-designer' ),
                'insert_into_item' => __( 'Insert into clipart', 'web-to-print-online-designer' ),
                'uploaded_to_this_item' => __( 'Uploaded to this clipart', 'web-to-print-online-designer' ),
                'items_list' => __( 'cliparts list', 'web-to-print-online-designer' ),
                'items_list_navigation' => __( 'cliparts list navigation', 'web-to-print-online-designer' ),
                'filter_items_list' => __( 'Filter cliparts list', 'web-to-print-online-designer' ),
            );
            $args = array(
                'label' => __( 'clipart', 'web-to-print-online-designer' ),
                'description' => __( 'custom post type', 'web-to-print-online-designer' ),
                'labels' => $labels,
                'menu_icon' => '',
                'supports' => array(),
                'taxonomies' => array(),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => false,
                'menu_position' => 5,
                'show_in_admin_bar' => false,
                'show_in_nav_menus' => false,
                'can_export' => true,
                'has_archive' => true,
                'hierarchical' => false,
                'exclude_from_search' => false,
                'show_in_rest' => true,
                'publicly_queryable' => true,
                'capability_type' => 'post',
            );
            register_post_type( 'clipart', $args );
        }
        public function screen_option(){
            if( !isset($_GET['action']) ){
                $option = 'per_page';
                $args   = array(
                    'label'   => __('Printing Options', 'web-to-print-online-designer'),
                    'default' => 10,
                    'option'  => 'options_per_page'
                );
                add_screen_option( $option, $args );
            }
        }
        public function save_option(){
            $nonce = esc_attr($_REQUEST['_wpnonce']);
            if (!wp_verify_nonce($nonce, 'nbd_options_nonce')) {
                die('Go get a life script kiddies');
            }
            $id = absint($_REQUEST['id']);
            $modified_date = new DateTime();
            $arr = array(
                'title' =>  $_POST['title'],
                'modified'  => $modified_date->format('Y-m-d H:i:s'),
                'fields'    => serialize($_POST['options'])
            );
            global $wpdb;
            $wpdb->update("{$wpdb->prefix}nbdesigner_options", $arr, array( 'id' => $id) );            
        }
        public function get_option(){
            global $wpdb;
            $sql = "SELECT * FROM {$wpdb->prefix}nbdesigner_options";
            $sql .= " WHERE id = " . esc_sql($_REQUEST['id']);
            $result = $wpdb->get_results($sql, 'ARRAY_A');
            return count($result[0]) ? $result[0] : false;
        }
        public function delete_options(){

        }
        public function build_options( $options = null ){
            if( is_null($options) ){
                $options = array(
                    'quantity_type' => 'r',
                    'quantity_discount_type' => 'p',
                    'quantity_min' => 1,
                    'quantity_max' => '',
                    'quantity_step' => 1,
                    'quantity_enable' => 'y', 
                    'side' => array(
                        'enable'    =>  'n',
                        'dynamic'    =>  'n',
                        'price_type'    =>  'f',
                        'depend_quantity'   =>  'y',
                        'options' =>  array(
                            array(
                                'name'  =>  '',
                                'side'  =>  1,
                                'price' =>  array()
                            )                       
                        )
                    ),
                    'quantity_breaks' => array(
                        array('val' =>  1, 'dis'    =>  '')
                    ),  
                    'fields'    => array(
                        0   =>  $this->default_field()                          
                    )                    
                );
            }
            foreach( $options['fields'] as $f_key => $field ){
                foreach ($field as $tab =>  $data){
                    if( $tab != 'id' ){
                        foreach ($data as $key => $f){
                            $funcname = "build_config_".$tab.'_'.$key;
                            $options['fields'][$f_key][$tab][$key] = $this->$funcname($f);                     
                        }
                    }
                }
            }
            return $options;
        }
        public function default_field(){
            return array(
                'id'    =>  round(microtime(true) * 1000),
                'general' => array(
                    'title' =>  null,
                    'description' =>  null,
                    'data_type' =>  null,
                    'enabled' =>  null,
                    'required' =>  null,
                    'price_type' =>  null,
                    'depend_quantity' =>  null,
                    'price' =>  null,
                    'price_breaks' =>  null,
                    'attributes' =>  null
                ),
                'conditional' => array(
                    'enable'    =>  'n',
                    'show'    =>  'y',
                    'logic'    =>  'a',
                    'depend'    =>  null
                ),
                'appearance' => array(
                    'display_type' =>  null,
                    'change_image_product' =>  null,
                    'quantity_selector' =>  null
                )                            
            ); 
        }
        public function default_config_field(){
            $field = $this->default_field();
            foreach ($field as $tab =>  $data){
                if( $tab != 'id' ){
                    foreach ($data as $key => $f){
                        $funcname = "build_config_".$tab.'_'.$key;
                        $field[$tab][$key] = $this->$funcname($f);                     
                    }
                }
            }
            return $field;
        }
        public function build_config_general_title( $value = null ){
            if (is_null($value)) $value = __( 'Title', 'web-to-print-online-designer');
            return array(
                'title' => __( 'Title', 'web-to-print-online-designer'),
                'description'   =>  '',
                'value'	=> $value,
                'type'  => 'text'              
            );
        }
        public function build_config_general_description( $value = null ){
            if (is_null($value)) $value = __( 'Description', 'web-to-print-online-designer');
            return array(
                'title' => __( 'Description', 'web-to-print-online-designer'),
                'description'   =>  '',
                'value'	=> $value,
                'type'  => 'textarea'              
            );            
        }
        public function build_config_general_data_type( $value = null ){
            if (is_null($value)) $value = 'm';
            return array(
                'title' => __( 'Data type', 'web-to-print-online-designer'),
                'description'   =>  '',
                'value'	=> $value,
                'type' 		=> 'dropdown',
                'options' =>    array(
                    array(
                        'key'   =>  'i',
                        'text'   =>  __( 'Custom input', 'web-to-print-online-designer')
                    ),
                    array(
                        'key'   =>  'm',
                        'text'   =>  __( 'Multiple options', 'web-to-print-online-designer')
                    )
                )               
            );            
        } 
        public function build_config_general_enabled( $value = null ){
            if (is_null($value)) $value = 'y';
            return array(
                'title' => __( 'Enabled', 'web-to-print-online-designer'),
                'description'   =>  'Choose whether the option is enabled or not.',
                'value'	=> $value,
                'type' 		=> 'dropdown',
                'options' =>    array(
                    array(
                        'key'   =>  'y',
                        'text'   =>  __( 'Yes', 'web-to-print-online-designer')
                    ),
                    array(
                        'key'   =>  'n',
                        'text'   =>  __( 'No', 'web-to-print-online-designer')
                    )
                )               
            );            
        }
        public function build_config_general_required( $value = null ){
            if (is_null($value)) $value = 'n';
            return array(
                'title' => __( 'Required', 'web-to-print-online-designer'),
                'description'   =>  'Choose whether the option is required or not.',
                'value'	=> $value,
                'type' 		=> 'dropdown',
                'options' =>    array(
                    array(
                        'key'   =>  'y',
                        'text'   =>  __( 'Yes', 'web-to-print-online-designer')
                    ),
                    array(
                        'key'   =>  'n',
                        'text'   =>  __( 'No', 'web-to-print-online-designer')
                    )
                )               
            );            
        } 
        public function build_config_general_price_type( $value = null ){
            if (is_null($value)) $value = 'f';
            return array(
                'title' => __( 'Price type', 'web-to-print-online-designer'),
                'description'   =>  'Here you can choose how the price is calculated. Depending on the field there various types you can choose.',
                'value'	=> $value,
                'type' 		=> 'dropdown',
                'options' =>    array(
                    array(
                        'key'   =>  'f',
                        'text'   =>  __( 'Fixed amount', 'web-to-print-online-designer')
                    ),
                    array(
                        'key'   =>  'p',
                        'text'   =>  __( 'Percent of the original price', 'web-to-print-online-designer')
                    ),
                    array(
                        'key'   =>  'p+',
                        'text'   =>  __( 'Percent of the original price + options', 'web-to-print-online-designer')
                    ),
                    array(
                        'key'   =>  'c',
                        'text'   =>  __( 'Current value * price', 'web-to-print-online-designer')
                    )
                )               
            );            
        }
        public function build_config_general_depend_quantity( $value = null ){
            if (is_null($value)) $value = 'y';
            return array(
                'title' => __( 'Depend quantity breaks', 'web-to-print-online-designer'),
                'description'   =>  '',
                'value'	=> $value,
                'type' 		=> 'dropdown',
                'options' =>    array(
                    array(
                        'key'   =>  'y',
                        'text'   =>  __( 'Yes', 'web-to-print-online-designer')
                    ),
                    array(
                        'key'   =>  'n',
                        'text'   =>  __( 'No', 'web-to-print-online-designer')
                    )
                )               
            );            
        }    
        public function build_config_general_price( $value = null ){
            if (is_null($value)) $value = '';
            return array(
                'title' => __( 'Price', 'web-to-print-online-designer'),
                'description'   =>  'Enter the price for this field or leave it blank for no price.',
                'value'	=> $value,
                'depend'    =>  array(
                    array(
                        'field' =>  'depend_quantity',
                        'operator' =>  '#',
                        'value' =>  'y'
                    ),
                    array(
                        'field' =>  'data_type',
                        'operator' =>  '=',
                        'value' =>  'i'
                    )                                 
                ),                                        
                'type'  => 'number'                
            );
        }
        public function build_config_general_price_breaks( $value = null ){
            if (is_null($value)) $value = array();
            return array(  
                'title' => __( 'Price depend quantity breaks', 'web-to-print-online-designer'),
                'depend'    =>  array(
                    array(
                        'field' =>  'depend_quantity',
                        'operator' =>  '=',
                        'value' =>  'y'
                    ),
                    array(
                        'field' =>  'data_type',
                        'operator' =>  '=',
                        'value' =>  'i'
                    )                                    
                ),
                'description'   =>  '',
                'value'	=> $value,
                'type'  => 'single_quantity_depend'                  
            );
        }     
        public function build_config_general_attributes( $attributes = null ){
            if (is_null($attributes)){ $options = array(
                0 => array(
                    'name'  => '',
                    'price'	=> array(),
                    'selected'  =>  0,
                    'preview_type'  =>  'i',
                    'image' =>  0,
                    'image_url' =>  '',
                    'color' =>  '#ffffff'                
                )
            );} else {
                $options = $attributes['options'];
            };             
            foreach( $options as $key => $option){                 
                if( absint($option['image']) != 0 ){
                    $options[$key]['image_url'] = wp_get_attachment_url( absint($option['image']) );
                }else{
                    $options[$key]['image_url'] = NBDESIGNER_ASSETS_URL . 'images/placeholder.png';
                }
            }           
            return array(  
                'title' => __( 'Attributes', 'web-to-print-online-designer'),
                'description'   =>  'Attributes let you define extra product data, such as size or color.',                                     
                'type' 		=> 'attributes',
                'depend'    =>  array(
                    array(
                        'field' =>  'data_type',
                        'operator' =>  '=',
                        'value' =>  'm'                                        
                    )
                ), 
                'options'   => $options 
            );
        }
        public function build_config_appearance_display_type( $value = null ){
            if (is_null($value)) $value = 'd';
            return array(  
                'title' => __( 'Display type', 'web-to-print-online-designer'),
                'description'   =>  '',
                'value'	=> $value,
                'type' 		=> 'dropdown',
                'options' =>    array(
                    array(
                        'key'   =>  'd',
                        'text'   =>  __( 'Dropdown', 'web-to-print-online-designer')
                    ),
                    array(
                        'key'   =>  'r',
                        'text'   =>  __( 'Radio button', 'web-to-print-online-designer')
                    ),
                    array(
                        'key'   =>  'l',
                        'text'   =>  __( 'Label', 'web-to-print-online-designer')
                    )                                    
                ) 			
            );
        }    
        public function build_config_appearance_change_image_product( $value = null ){
            if (is_null($value)) $value = 'n';
            return array(  
                'title' => __( 'Changes product image', 'web-to-print-online-designer'),
                'description'   =>  __('Choose whether to change the product image.', 'web-to-print-online-designer'),
                'type' 		=> 'dropdown',
                'value'	=> $value,
                'options' =>    array(
                    array(
                        'key'   =>  'y',
                        'text'   =>  __( 'Yes', 'web-to-print-online-designer')
                    ),
                    array(
                        'key'   =>  'n',
                        'text'   =>  __( 'No', 'web-to-print-online-designer')
                    )
                )			
            );
        }  
        public function build_config_appearance_quantity_selector( $value = null ){
            if (is_null($value)) $value = 'n';
            return array(  
                'title' => __( 'Quantity selector', 'web-to-print-online-designer'),
                'description'   =>  __('This will show a quantity selector for this option.', 'web-to-print-online-designer'),
                'type' 		=> 'dropdown',
                'value'	=> $value,
                'options' =>    array(
                    array(
                        'key'   =>  'y',
                        'text'   =>  __( 'Yes', 'web-to-print-online-designer')
                    ),
                    array(
                        'key'   =>  'n',
                        'text'   =>  __( 'No', 'web-to-print-online-designer')
                    )
                )  			
            );
        }
        public function build_config_conditional_enable( $value = null ){
            if (is_null($value)) $value = 'n';
            return $value;
        }
        public function build_config_conditional_show( $value = null ){
            if (is_null($value)) $value = 'n';
            return $value;
        } 
        public function build_config_conditional_logic( $value = null ){
            if (is_null($value)) $value = 'a';
            return $value;
        } 
        public function build_config_conditional_depend( $value = null ){
            if (is_null($value)) $value = array(
                0   =>  array(
                    'id'    => '',
                    'operator'  =>  'i',
                    'val'   =>  ''
                )
            );
            return $value;
        }         
    }
}
function nbd_option_i18n(){
    return array(
        
    );
}
$nbd_printing_options = NBD_ADMIN_PRINTING_OPTIONS::instance();
$nbd_printing_options->init();