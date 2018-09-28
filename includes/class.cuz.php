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
            add_action('nbd_after_option_product_design', array($this, 'product_design_setting'), 10, 2);
            $this->ajax();
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
                'nbdesigner', __('NB Etsy order', 'web-to-print-online-designer'), __('Etsy order', 'web-to-print-online-designer'), 'manage_nbd_tool', 'etsy_order', array($this, 'etsy_order')
            ); 
        }
        public function etsy_order(){
            include_once(NBDESIGNER_PLUGIN_DIR . 'views/cuz/etsy-order.php');
        }
        public function manage_color(){
            include_once(NBDESIGNER_PLUGIN_DIR . 'views/cuz/manage-color.php');
        }
        public function product_design_setting( $post_id, $option ){
            include_once(NBDESIGNER_PLUGIN_DIR . 'views/cuz/product-settings.php');
        }
    }
}
$nbd_cuz = NBD_CUSTOMIZE::instance();
$nbd_cuz->init();

