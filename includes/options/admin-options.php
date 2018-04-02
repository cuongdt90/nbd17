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
        }
        public function tab_menu(){
            if(current_user_can('manage_nbd_tool')){  
                $options_hook = add_submenu_page(
                    'nbdesigner', 'Printing Options', 'Printing Options', 'manage_nbd_tool', 'nbd_printing_options', array($this, 'printing_options')
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
            $options = $this->build_options(); 
            if( isset( $_GET['action'] ) ){
                if( $_GET['action'] == 'delete' ){
                    wp_redirect(esc_url_raw(add_query_arg(array('paged' => 1), admin_url('admin.php?page=nbd_printing_options'))));
                }else{
                    $message = array(
                        'content' =>    'success',
                        'flag'  =>  'success'
                    );
                    if( isset( $_POST['save'] ) ){
                        $this->save_option();
                    }
                    include_once(NBDESIGNER_PLUGIN_DIR . 'views/options/edit-option.php');
                }
            }else{
                include_once(NBDESIGNER_PLUGIN_DIR . 'views/options/options-list-table.php');
            }
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
ob_start();
var_dump($_POST);
error_log(ob_get_clean());
        }
        public function delete_options(){

        }
        public function build_options( $options = null ){
            if( is_null($options) ){
                $options = array(
                    'id'    =>   1,
                    'title' =>  'Business Card Printing',
                    'priority' =>  10,
                    'product_ids'   =>  array(),
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
                        0   =>  array(
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
                                
                            ),
                            'appearance' => array(
                                'display_type' =>  null,
                                'change_image_product' =>  null,
                                'quantity_selector' =>  null
                            )                            
                        )                           
                    )                    
                );
            }
            foreach( $options['fields'] as $f_key => $field ){
                foreach ($field as $tab =>  $data){
                    foreach ($data as $key => $f){
                        $funcname = "build_config_".$key;
                        $options['fields'][$f_key][$tab][$key] = $this->$funcname($f);                     
                    }
                }
            }
            return $options;
        }
        public function build_config_title( $value = null ){
            if (is_null($value)) $value = __( 'Title', 'web-to-print-online-designer');
            return array(
                'title' => __( 'Title', 'web-to-print-online-designer'),
                'description'   =>  '',
                'value'	=> $value,
                'type'  => 'text'              
            );
        }
        public function build_config_description( $value = null ){
            if (is_null($value)) $value = __( 'Description', 'web-to-print-online-designer');
            return array(
                'title' => __( 'Description', 'web-to-print-online-designer'),
                'description'   =>  '',
                'value'	=> $value,
                'type'  => 'textarea'              
            );            
        }
        public function build_config_data_type( $value = null ){
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
        public function build_config_enabled( $value = null ){
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
        public function build_config_required( $value = null ){
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
        public function build_config_price_type( $value = null ){
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
        public function build_config_depend_quantity( $value = null ){
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
        public function build_config_price( $value = null ){
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
        public function build_config_price_breaks( $value = null ){
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
        public function build_config_attributes( $options = null ){
            if (is_null($options)) $options = array(
                array(
                    'name'  => '',
                    'price'	=> array(),
                    'selected'  =>  0,
                    'preview_type'  =>  'i',
                    'image' =>  0,
                    'image_url' =>  '',
                    'color' =>  '#ffffff'                
                )
            );
            foreach($options as $key => $op){
                if( $op['image'] != 0 ){
                    $options[$key]['image_url'] = wp_get_attachment_url( absint($op['image']) );
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
        public function build_config_display_type( $value = null ){
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
        public function build_config_change_image_product( $value = null ){
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
        public function build_config_quantity_selector( $value = null ){
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
    }
}
function nbd_option_i18n(){
    return array(
        
    );
}
$nbd_printing_options = NBD_ADMIN_PRINTING_OPTIONS::instance();
$nbd_printing_options->init();