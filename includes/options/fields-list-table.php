<?php if (!defined('ABSPATH')) exit;
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class NBD_Options_List_Table extends WP_List_Table {
    public function __construct() {
        parent::__construct(array(
            'singular' => __('Printing option', 'web-to-print-online-designer'), 
            'plural' => __('Printing options', 'web-to-print-online-designer'), 
            'ajax' => false 
        ));
    }
    public function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        /** Process bulk action */
        $this->process_bulk_action();
        $per_page = $this->get_items_per_page('options_per_page', 10);
        $current_page = $this->get_pagenum();
        $total_items = self::record_count();
        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page //WE have to determine how many items to show on a page
        ));
        $this->items = self::get_options($per_page, $current_page);
    }  
    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />',            
            'title' => __('Title', 'web-to-print-online-designer'),
            'priority' => __('Priority', 'web-to-print-online-designer'),
            'created' => __('Created', 'web-to-print-online-designer')
        );
        return $columns;
    }    
    public function get_sortable_columns() {
        $sortable_columns = array(
            'priority' => array('priority', true),
            'created' => array('created_date', true)
        );
        return $sortable_columns;
    }
    public static function record_count() {
        global $wpdb;
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}nbdesigner_options";
        //filter
        return $wpdb->get_var($sql);
    }
    public function get_options($per_page = 5, $page_number = 1){
        global $wpdb;
        $sql = "SELECT * FROM {$wpdb->prefix}nbdesigner_options";
        $sql .= " LIMIT $per_page";
        $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;
        $result = $wpdb->get_results($sql, 'ARRAY_A');    
        return $result;        
    }
    public function process_bulk_action() {
        if ('delete' === $this->current_action()) {    
            $nonce = esc_attr($_REQUEST['_wpnonce']);
            if (!wp_verify_nonce($nonce, 'nbdesigner_template_nonce')) {
                die('Go get a life script kiddies');
            }            
            //deleete option
            wp_redirect(esc_url_raw(add_query_arg(array('paged' => $this->get_pagenum()), admin_url('admin.php?page=nbdesigner_options'))));
            exit;
        }  
    }
    public function get_bulk_actions() {
        $actions = array(            
            'bulk-delete' => __('Delete', 'web-to-print-online-designer'),
        );
        return $actions;
    }    
    public function no_items() {
        _e( 'No options avaliable.', 'web-to-print-online-designer');
    }    
    function column_title($item) {
        $title = $item['title'];
        $_nonce = wp_create_nonce('nbd_options_nonce');
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&id=%s&paged=%s&_wpnonce=%s">'.__('Edit', 'web-to-print-online-designer').'</a>', esc_attr($_REQUEST['page']), 'edit', absint($item['id']), $this->get_pagenum(), $_nonce)
        );
        return $title . $this->row_actions($actions);
    }
    function column_priority($item){
        if($item['priority']){
            return '<span class="primary">&#9733;</span>';
        }else{
            return '<span>&#9734;</span>';
        }     
    }   
    function column_default($item, $column_name){
        return $item[$column_name];
    }   
    function column_cb($item) {
        return sprintf( '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id'] );
    }    
    function extra_tablenav( $which ) {
        
    }
    function save_option(){
        ob_start();
        var_dump($_POST);
        error_log(ob_get_clean());
    }
}