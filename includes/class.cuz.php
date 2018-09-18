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
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 30, 1);
            $this->ajax();
        }
        public function admin_enqueue_scripts($hook){
            if( $hook == 'nbdesigner_page_manage_color' ){
                wp_enqueue_style('nbdesigner_sweetalert_css', NBDESIGNER_CSS_URL . 'sweetalert.css');
                wp_enqueue_script( 'nbdesigner_sweetalert_js', NBDESIGNER_JS_URL . 'sweetalert.min.js' , array('jquery'));
            }
        }
        public function ajax(){
            $ajax_events = array(
                'nbd_add_color_group'   =>  false,
                'nbd_add_color'   =>  false,
                'nbdesigner_add_color_cat' => false,
                'nbdesigner_delete_color_cat' => false,
                'nbdesigner_delete_color' => false,
            );
            foreach ($ajax_events as $ajax_event => $nopriv) {
                add_action('wp_ajax_' . $ajax_event, array($this, $ajax_event));
                if ($nopriv) {
                    // NBDesigner AJAX can be used for frontend ajax requests
                    add_action('wp_ajax_nopriv_' . $ajax_event, array($this, $ajax_event));
                }
            }
        }
        public function nbdesigner_add_color_cat(){
            $data = array(
                'mes'   =>  __('You do not have permission to add/edit color category!', 'web-to-print-online-designer'),
                'flag'  => 0
            );
            if (!wp_verify_nonce($_POST['nonce'], 'nbdesigner_add_cat') || !current_user_can('edit_nbd_color')) {
                echo json_encode($data);
                wp_die();
            }
            $path = NBDESIGNER_DATA_DIR . '/color_cat.json';
            $cat = array(
                'name' => sanitize_text_field($_POST['name']),
                'slug' => nbd_alias($_POST['name']),
                'id' => $_POST['id']
            );

            $nbdesigner_plugin = new Nbdesigner_Plugin();
            $nbdesigner_plugin->nbdesigner_update_json_setting($path, $cat, $cat['id']);
            $data['mes'] = __('Category has been added/edited successfully!', 'web-to-print-online-designer');
            $data['flag'] = 1;
            echo json_encode($data);
            wp_die();

        }

        public function nbdesigner_delete_color_cat(){
            $data = array(
                'mes'   =>  __('You do not have permission to delete color category!', 'web-to-print-online-designer'),
                'flag'  => 0
            );

            if (!wp_verify_nonce($_POST['nonce'], 'nbdesigner_add_cat') || !current_user_can('delete_nbd_color')) {
                echo json_encode($data);
                wp_die();
            }

            $path = NBDESIGNER_DATA_DIR . '/color_cat.json';
            $id = $_POST['id'];
            $nbdesigner_plugin = new Nbdesigner_Plugin();
            $nbdesigner_plugin->nbdesigner_delete_json_setting($path, $id, true);
            $color_path = NBDESIGNER_DATA_DIR . '/colors.json';
            $nbdesigner_plugin->nbdesigner_update_json_setting_depend($color_path, $id);
            $data['mes'] = __('Category has been delete successfully!', 'web-to-print-online-designer');
            $data['flag'] = 1;
            echo json_encode($data);
            wp_die();
        }

        public function nbdesigner_delete_color(){
            $data = array(
                'mes'   =>  __('You do not have permission to delete clipart!', 'web-to-print-online-designer'),
                'flag'  => 0
            );

            if (!wp_verify_nonce($_POST['nonce'], 'nbdesigner_add_cat') || !current_user_can('delete_nbd_color')) {
                echo json_encode($data);
                wp_die();
            }

            $nbdesigner_plugin = new Nbdesigner_Plugin();
            $id = $_POST['id'];
            $path = NBDESIGNER_DATA_DIR . '/colors.json';
            $nbdesigner_plugin->nbdesigner_delete_json_setting($path, $id);
            $data['mes'] = __('color has been deleted successfully!', 'web-to-print-online-designer');
            $data['flag'] = 1;
            echo json_encode($data);
            wp_die();
        }
        public function nbd_add_color_group(){
            
        }
        public function nbd_add_color(){}
        public function manage_color_menu(){
            add_submenu_page(
                'nbdesigner', __('NB  manage color', 'web-to-print-online-designer'), __('Manage color', 'web-to-print-online-designer'), 'manage_nbd_tool', 'manage_color', array($this, 'manage_color')
            );
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

