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
                wp_enqueue_style(array('wp-jquery-ui-dialog', 'angularjs', 'nbd_options'));
                wp_enqueue_script(array('wpdialogs', 'nbd_options'));   	
            }
        }
        public function printing_options(){
            require_once NBDESIGNER_PLUGIN_DIR . 'includes/options/fields-list-table.php';
            $nbd_options = new NBD_Options_List_Table();   
            $options = array(
                'id'    =>   1,
                'title' =>  'Business Card Printing',
                'priority' =>  10,
                'product_ids'   =>  array('642'),
                'quantity_type' => 'r',
                'quantity_discount_type' => 'p',
                'quantity_min' => '',
                'quantity_max' => '',
                'quantity_step' => 1,
                'quantity_breaks' => array(
                    array('val' =>  1, 'dis'    =>  1),
                    array('val' =>  10, 'dis'    =>  2),
                    array('val' =>  20, 'dis'    =>  3),
                    array('val' =>  50, 'dis'    =>  4)
                ),
                'fields' => array(
                    0   =>    array(
                        'title' =>  'Section 1',
                        'fields'    => array(
                            0   =>  array(
                                'general' => array(
                                    array(
                                        'title' => __( 'Title', 'web-to-print-online-designer'),
                                        'field' => 'title',
                                        'description'   =>  '',
                                        'class' => '',
                                        'css'         => 'background: red',
                                        'value'	=> 'Title',
                                        'type' 		=> 'text'
                                    ),  
                                    array(
                                        'title' => __( 'Description', 'web-to-print-online-designer'),
                                        'field' => 'description',
                                        'class' => '',
                                        'description'   =>  '',
                                        'css'         => '',
                                        'value'	=> 'Description',
                                        'type' 		=> 'textarea'
                                    ),     
                                    array(
                                        'title' => __( 'Data type', 'web-to-print-online-designer'),
                                        'field' => 'type',
                                        'class' => '',
                                        'description'   =>  '',
                                        'css'         => '',
                                        'value'	=> 'n',
                                        'type' 		=> 'dropdown_group',
                                        'options' =>    array(
                                            array(
                                                'title' =>  __( 'Single attribute', 'web-to-print-online-designer'),
                                                'value' => array(
                                                    array(
                                                        'key'   =>  't',
                                                        'text'   =>  __( 'Text', 'web-to-print-online-designer')
                                                    ),
                                                    array(
                                                        'key'   =>  'n',
                                                        'text'   =>  __( 'Number', 'web-to-print-online-designer')
                                                    ),
                                                    array(
                                                        'key'   =>  'e',
                                                        'text'   =>  __( 'Email', 'web-to-print-online-designer')
                                                    ) 
                                                )
                                            ),
                                            array(
                                                'title' =>  __( 'Multiple attributes', 'web-to-print-online-designer'),
                                                'value' => array(
                                                    array(
                                                        'key'   =>  'c',
                                                        'text'   =>  __( 'Color', 'web-to-print-online-designer')
                                                    ),
                                                    array(
                                                        'key'   =>  'n1',
                                                        'text'   =>  __( 'Number', 'web-to-print-online-designer')
                                                    ),
                                                    array(
                                                        'key'   =>  'e1',
                                                        'text'   =>  __( 'Email', 'web-to-print-online-designer')
                                                    ) 
                                                )
                                            )
                                        )
                                    ),                     
                                    array(
                                        'title' => __( 'Enabled', 'web-to-print-online-designer'),
                                        'field' => 'enabled',
                                        'class' => '',
                                        'description'   =>  'Choose whether the option is enabled or not.',
                                        'css'         => '',
                                        'value'	=> 'y',
                                        'type' 		=> 'radio',
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
                                    ),   
                                    array(
                                        'title' => __( 'Required', 'web-to-print-online-designer'),
                                        'field' => 'required',
                                        'class' => '',
                                        'description'   =>  'Choose whether the option is enabled or not.',
                                        'css'         => '',
                                        'value'	=> 'n',
                                        'type' 		=> 'radio',
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
                                    ), 
                                    array(
                                        'title' => __( 'Price type', 'web-to-print-online-designer'),
                                        'field' => 'price_type',
                                        'class' => '',
                                        'description'   =>  '',
                                        'css'         => '',
                                        'value'	=> 'd',
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
                                            ), 
                                            array(
                                                'key'   =>  'd',
                                                'text'   =>  __( 'Price depend quantity', 'web-to-print-online-designer')
                                            )
                                        )
                                    ),                      
                                    array(
                                        'title' => __( 'Price', 'web-to-print-online-designer'),
                                        'field' => 'price',
                                        'description'   =>  'Enter the price for this field or leave it blank for no price.',
                                        'class' => '',
                                        'css'         => '',
                                        'value'	=> '',
                                        'depend'    =>  array(
                                            'field' =>  'price_type',
                                            'operator' =>  '#',
                                            'value' =>  'd'
                                        ),                                        
                                        'type' 		=> 'number'
                                    ),                                     
                                    array(
                                        'title' => __( 'Sale Price', 'web-to-print-online-designer'),
                                        'field' => 'sale_price',
                                        'description'   =>  'Enter the sale price for this field or leave it blankto use the default price.',
                                        'class' => '',
                                        'css'         => '',
                                        'value'	=> '',
                                        'depend'    =>  array(
                                            'field' =>  'price_type',
                                            'operator' =>  '#',
                                            'value' =>  'd'
                                        ),                                           
                                        'type' 		=> 'number'
                                    ),
                                    array(
                                        'title' => __( 'Price depend quantity breaks', 'web-to-print-online-designer'),
                                        'field' => 'price_breaks',
                                        'depend'    =>  array(
                                            'field' =>  'price_type',
                                            'operator' =>  '=',
                                            'value' =>  'd'
                                        ),
                                        'description'   =>  '',
                                        'class' => '',
                                        'css'         => '',
                                        'value'	=> array(10,9,8),
                                        'type' 		=> 'single_quantity_depend'                                        
                                    ),
                                    array(
                                        'title' => __( 'Attributes', 'web-to-print-online-designer'),
                                        'field' => 'attributes',
                                        'description'   =>  'Attributes let you define extra product data, such as size or color.',
                                        'class' => '',
                                        'css'         => '',
                                        'value'	=> 'Cutting options',                                       
                                        'type' 		=> 'attributes',
                                        'options' =>    array(
                                            array(
                                                'text'  => 'No Lamination',
                                                'value'	=> array(10,9,8),
                                            ),
                                            array(
                                                'text'  => 'Matt',
                                                'value' =>  array()
                                            ),
                                            array(
                                                'text'  => 'Gloss',
                                                'value'	=> array(10,9,8),
                                            ),
                                            array(
                                                'text'  => 'Anti Graffiti',
                                                'value' =>  array()
                                            )                                           
                                        )
                                    ),                                     
                                ),
                                'conditional' => array(
                
                                ),
                                'appearance' => array(
                                    'display_type'  => 'r'
                                )                                        
                            )                           
                        )
                    )                    
                )
            );            
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
    }
}
function nbd_option_i18n(){
    return array(
        
    );
}
$nbd_printing_options = NBD_ADMIN_PRINTING_OPTIONS::instance();
$nbd_printing_options->init();