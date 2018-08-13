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
            add_action('add_meta_boxes', array($this, 'add_meta_boxes'), 30);
            add_action('save_post', array($this, 'save_product_option'));
        }
        public function save_product_option($post_id){
            if (!isset($_POST['nbo_box_nonce']) || !wp_verify_nonce($_POST['nbo_box_nonce'], 'nbo_box')
                || !(current_user_can('administrator') || current_user_can('shop_manager'))) {
                return $post_id;
            }
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }
            if ('page' == $_POST['post_type']) {
                if (!current_user_can('edit_page', $post_id)) {
                    return $post_id;
                }
            } else {
                if (!current_user_can('edit_post', $post_id)) {
                    return $post_id;
                }
            }
            $enable = $_POST['_nbo_enable']; 
            update_post_meta($post_id, '_nbo_enable', $enable);
        }
        public function add_meta_boxes(){
            add_meta_box('nbo_print_option', __('Print option', 'web-to-print-online-designer'), array($this, 'meta_box'), 'product', 'normal', 'high');
        }        
        public function meta_box(){
            $post_id = get_the_ID();
            $enable = get_post_meta($post_id, '_nbo_enable', true);
            $option_id = get_post_meta($post_id, '_nbo_option_id', true);
            $option_id = $option_id ? $option_id : 0;
            $link_edit_option = add_query_arg(array(
                    'product_id' => $post_id, 
                    'action' => 'edit',
                    'paged' => 1,
                    'id' => $option_id
                ),
                admin_url('admin.php?page=nbd_printing_options'));
            ?>
            <div id="nbo-wraper">
                <?php wp_nonce_field('nbo_box', 'nbo_box_nonce'); ?>
                <div>
                    <p>
                        <input type="hidden" value="0" name="_nbo_enable"/>
                        <label style="width: 150px; display: inline-block; margin-right: 10px;" for="_nbo_enable"><?php _e('Enable Print option', 'web-to-print-online-designer'); ?></label>
                        <input type="checkbox" value="1" name="_nbo_enable" id="_nbo_enable" <?php checked($enable); ?> class="short" />
                    </p>
                    <p>
                        <a class="button" href="<?php echo $link_edit_option; ?>" target="_blank">
                            <?php if( $option_id != 0 ){ _e('Edit option', 'web-to-print-online-designer'); }else{ _e('Create option', 'web-to-print-online-designer'); }; ?>
                        </a>
                    </p>
                </div>
            </div>
            <?php
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
                wp_register_script('nbd_options', NBDESIGNER_JS_URL . 'admin-options.js', array('jquery', 'jquery-ui-resizable', 'jquery-ui-draggable', 'jquery-ui-autocomplete', 'wp-color-picker', 'angularjs'), NBDESIGNER_VERSION);             
                wp_localize_script('nbd_options', 'nbd_options', array(
                    'nbd_options_lang' => nbd_option_i18n()
                ));   
                wp_enqueue_style(array('wp-jquery-ui-dialog', 'wp-color-picker', 'nbd_options'));
                wp_enqueue_script(array('wpdialogs', 'nbd_options'));   	
            }
        }
        public function printing_options(){ 
            if( isset( $_GET['action'] ) ){
                $paged = get_query_var('paged', 1);
                $message = array('content'  =>  '');
                if( $_GET['action'] == 'delete' ){
                    wp_redirect(esc_url_raw(add_query_arg(array('paged' => $paged), admin_url('admin.php?page=nbd_printing_options'))));
                }else{
                    $id = (isset( $_REQUEST['id'] ) && absint($_REQUEST['id']) > 0 ) ? absint($_REQUEST['id']) : 0;
                    if( isset( $_POST['save'] ) ){
                        $result = $this->save_option();
                        if($result['status']){
                            $message = array(
                                'flag'  =>  'success',
                                'content'   =>  __('Option updated.', 'web-to-print-online-designer')
                            );
                            if( $id == 0 ){
                                $id = $result['id'];
                                wp_redirect(esc_url_raw(add_query_arg(array(
                                        'paged' => 1,
                                        'action'    =>  'edit',
                                        'id'    =>  $id
                                    ), admin_url('admin.php?page=nbd_printing_options'))));
                            }
                        }else{
                            $message = array(
                                'flag'  =>  'error',
                                'content'   =>  ''
                            );                
                        }
                    }
                    $_options = ($id > 0) ? $this->get_option($id) : false;//$_options = false;
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
                    foreach ( $options["fields"] as $f_index => $field ){
                        if($field["conditional"]['enable'] == 'n'){
                            $options["fields"][$f_index]["conditional"]['depend'] = $this->build_config_conditional_depend();
                            $options["fields"][$f_index]["conditional"]['logic'] = $this->build_config_conditional_logic();
                            $options["fields"][$f_index]["conditional"]['show'] = $this->build_config_conditional_show();
                        }
                    }
                    $default_field = $this->default_config_field();                      
                    $product_id = ($_options && isset($_options['product_ids'])) ? absint($_options['product_ids']) : 0;
                    if( isset($_GET['product_id']) && absint($_GET['product_id']) > 0 ){
                        $product_id = absint($_GET['product_id']);
                        if( !$_options ){
                            $product = wc_get_product($product_id);
                            $options['title'] = $product->get_title() . __(' - Option', 'web-to-print-online-designer');
                        }
                    }
                    include_once(NBDESIGNER_PLUGIN_DIR . 'views/options/edit-option.php');
                }
            }else{
                require_once NBDESIGNER_PLUGIN_DIR . 'includes/options/fields-list-table.php';
                $nbd_options = new NBD_Options_List_Table();              
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
//            $nonce = esc_attr($_REQUEST['_wpnonce']);
//            if (!wp_verify_nonce($nonce, 'nbd_options_nonce')) {
//                wp_redirect( esc_url(admin_url('admin.php?page=nbd_printing_options')) );
//                exit;
//            }
            $id = absint($_REQUEST['id']);
            $modified_date = new DateTime();
            $arr = array(
                'title' =>  $_POST['title'],
                'modified'  => $modified_date->format('Y-m-d H:i:s'),
                'fields'    => serialize($_POST['options'])
            );
            $is_product_option = false;
            if( isset($_POST['product_ids']) && absint($_POST['product_ids']) > 0 ) {
                $arr['product_ids'] = absint($_POST['product_ids']);
                $is_product_option = true;
            }
            $arr['fields'] = serialize( $this->validate_option($_POST['options']) );
            global $wpdb;
            $date = new DateTime();
            if( $id > 0 ){
                $arr['modified'] = $date->format('Y-m-d H:i:s');
                $arr['modified_by'] = wp_get_current_user()->ID;
                $result = $wpdb->update("{$wpdb->prefix}nbdesigner_options", $arr, array( 'id' => $id) );
            }else{
                $arr['created'] = $date->format('Y-m-d H:i:s');
                $arr['created_by'] = wp_get_current_user()->ID;
                $result = $wpdb->insert("{$wpdb->prefix}nbdesigner_options", $arr);
                $id = $result ?  $wpdb->insert_id : 0;
            }
            if( $result && $is_product_option ){
                update_post_meta(absint($_POST['product_ids']), '_nbo_option_id', $id);
            }
            return array(
                'status' =>  $result,
                'id'    =>  $id
            );
        }
        private function validate_option( $options ){
            foreach ( $options["fields"] as $f_index => $field ){
                $array_price_type = array('f', 'p', 'p+', 'c' );
                if( !in_array($field["general"]['price_type'], $array_price_type) ){
                    $options["fields"][$f_index]["general"]['price_type'] = $field["general"]['data_type'] == 'i' ? 'c' : 'f';
                }
                if( isset( $field["conditional"]['depend'] ) ){
                    foreach( $field["conditional"]['depend'] as $d_index => $depend ){
                        if( ($depend['operator'] == 'i' || $depend['operator'] == 'n') && $depend['val'] == '? string: ?' ){
                            unset($options["fields"][$f_index]["conditional"]['depend'][$d_index]);
                        }
                    }
                }
            }
            return $options;
        }
        public function get_option($id){
            global $wpdb;
            $sql = "SELECT * FROM {$wpdb->prefix}nbdesigner_options";
            $sql .= " WHERE id = " . esc_sql($id);
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
                $field = array_replace_recursive($this->default_field(), $field);
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
                'id'    =>  'f' . round(microtime(true) * 1000),
                'general' => array(
                    'title' =>  null,
                    'description' =>  null,
                    'data_type' =>  null,
                    'input_type' =>  null,
                    'input_option' =>  null,
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
                'title' => __( 'Option', 'web-to-print-online-designer'),
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
        public function build_config_general_input_type( $value = null ){
            if (is_null($value)) $value = 't';
            return array(
                'title' => __( 'Input type', 'web-to-print-online-designer'),
                'description'   =>  '',
                'value'	=> $value,
                'type' 		=> 'dropdown',
                'depend'    =>  array(
                    array(
                        'field' =>  'data_type',
                        'operator' =>  '=',
                        'value' =>  'i'
                    )                    
                ),
                'options' =>    array(
                    array(
                        'key'   =>  't',
                        'text'   =>  __( 'Text', 'web-to-print-online-designer')
                    ),
                    array(
                        'key'   =>  'n',
                        'text'   =>  __( 'Number', 'web-to-print-online-designer')
                    ),
                    array(
                        'key'   =>  'r',
                        'text'   =>  __( 'Number range', 'web-to-print-online-designer')
                    )                    
                )               
            );            
        }
        public function build_config_general_input_option( $value = null ){
            if (is_null($value)){$value = array(
                'min'   =>  1,
                'max'   =>  100,
                'step'   =>  1
            );}
            return array(
                'title' => __( 'Input option', 'web-to-print-online-designer'),
                'description'   =>  '',
                'value'	=> $value,
                'type' 		=> 'dropdown',
                'depend'    =>  array(
                    array(
                        'field' =>  'input_type',
                        'operator' =>  '#',
                        'value' =>  't'
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
                'description'   =>  __( 'Choose whether the option is required or not.' ),
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
                'description'   =>  __( 'Here you can choose how the price is calculated. Depending on the field there various types you can choose.' ),
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
                        'text'   =>  __( 'Current value * price', 'web-to-print-online-designer'),
                        'depend'    => array(
                            'field' =>  'data_type',
                            'operator' =>  '=',
                            'value' =>  'i'                             
                        )
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
                'title' => __( 'Additional Price', 'web-to-print-online-designer'),
                'description'   =>  __( 'Enter the price for this field or leave it blank for no price.' ),
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
                    'product_image' =>  '',
                    'product_image_url' =>  '',
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
                if( isset($option['product_image']) && absint($option['product_image']) != 0 ){
                    $options[$key]['product_image_url'] = wp_get_attachment_url( absint($option['product_image']) );
                }else{
                    $options[$key]['product_image_url'] = NBDESIGNER_ASSETS_URL . 'images/placeholder.png';
                }
            }           
            return array(  
                'title' => __( 'Attributes', 'web-to-print-online-designer'),
                'description'   =>  __( 'Attributes let you define extra product data, such as size or color.'),                                     
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
                        'key'   =>  's',
                        'text'   =>  __( 'Swatch', 'web-to-print-online-designer')
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