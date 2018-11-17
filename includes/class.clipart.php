<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!class_exists('NBD_CLIPART')){
    class NBD_CLIPART {
        protected static $instance;
        public static function instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }
            return self::$instance;
        }
        public function init(){
            add_action('nbd_menu', array($this, 'manage_clipart_menu'), 1000);
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 30, 1);
            add_action( 'init', array($this, 'create_nbdclipart_cpt'), 0 );
//            add_action('init', array($this, 'create_categories_tax'));
            add_action('init', array($this, 'create_nbdclipart_category_tax'));
            // add meta box
            add_action('add_meta_boxes', array($this, 'add_nbdclipart_meta_box'));
            // save metabox
            add_action('save_post_nbdclipart', array($this,'nbdclipart_save_post'));

            // add post_enctype
//            add_action('post_edit_form_tag', array($this,'add_post_enctype'));

            // custom category post

            // Filter arguments for registering a taxonomy
//            add_filter('register_taxonomy_args',array($this,'show_nbdclipart_categories', 10, 3));

            // Add custom metabox for clipart post
//            add_action('load-post.php', array($this, 'custom_load_clipart_post'));
//            add_action('load-post-new.php', array($this, 'custom_load_clipart_post'));

            $this->ajax();
        }

        public function custom_load_clipart_post()
        {
//            remove_meta_box('categorydiv', 'nbdclipart', 'side');
//            remove_meta_box('clipart_categorydiv', 'nbdclipart', 'side');
        }
        public function add_post_enctype()
        {
            echo 'enctype="multipart/form-data" autocomplete="off" encoding="multipart/form-data"';
        }
        public function nbdclipart_save_post()
        {
            $post_id = $_POST['post_ID'];
            if (isset($_FILES['svg'])) {
                $files = $_FILES['svg'];
                foreach ($files['name'] as $key => $value) {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );
                    $uploaded_file_name = basename($file['name']);
                    $allowed_file_types = array('svg', 'png', 'jpg', 'jpeg');
                    if (Nbdesigner_IO::checkFileType($uploaded_file_name, $allowed_file_types)) {
                        $upload_overrides = array('test_form' => false);
                        $uploaded_file = wp_handle_upload($file, $upload_overrides);

                        if (isset($uploaded_file['url'])) {
                            $new_path_art = Nbdesigner_IO::create_file_path(NBDESIGNER_ART_DIR, $uploaded_file_name);
                            $art['file'] = $uploaded_file['file'];
                            $art['url'] = $uploaded_file['url'];
                            $art['name'] = pathinfo($art['file'], PATHINFO_FILENAME);
                            if (!copy($art['file'], $new_path_art['full_path'])) {
                                $notice = apply_filters('nbdesigner_notices', nbd_custom_notices('error', __('Failed to copy.', 'web-to-print-online-designer')));
                            } else {
                                $art['file'] = $new_path_art['date_path'];
                                $art['url'] = $new_path_art['date_path'];
                            }
                            delete_post_meta($post_id,'nbdclipart');
                            add_post_meta($post_id, 'nbdclipart', $art['url']);
                            $notice = apply_filters('nbdesigner_notices', nbd_custom_notices('success', __('Your art has been saved.', 'web-to-print-online-designer')));
                        } else {
                            $notice = apply_filters('nbdesigner_notices', nbd_custom_notices('error', __('Error while upload art, please try again!', 'web-to-print-online-designer')));
                        }

                    }
                }

//                set_transient('nbd_clipart_' . $post_id, $post_id);

            }
//            global $post;
//            update_post_meta($post->ID, "function", $_POST["function"]);

        }
        public function add_nbdclipart_meta_box()
        {
            add_meta_box("wp_custom_attachment", "chose / upload file", array($this, 'nbdclipart_meta_options'), "nbdclipart", "normal", "high");
        }
        public function nbdclipart_meta_options()
        {
            global $post;
//            $cliparts = get_post_meta($post->ID,'nbdclipart');

            $theFILE=  get_post_meta($post->ID,'wp_custom_attachment',true);
            wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_attachment_nonce');
            $html = '';
//            $html = '<p class="description">';
//            $html .= 'Chose / Upload the File.';
//            if(count($theFILE)>0 && is_array($theFILE)){ $html.=" Uploaded File:".$theFILE[0]['url']; }
//            $html .= '</p>';
            $html .= '<p class="add_clipart_images hide-if-no-js">
                        <a href="#" id="set-nbdclipart">Add clipart</a>
                        <input type="hidden" id="nbdclipart-selected" name="nbdclipart[]">
		              </p>';

            $html .= '<div id="nbdclipart-gallery"></div>';

//            $html .= '<input id="wp_custom_attachment" title="select file" multiple="multiple" name="svg[]" size="25" type="file" value="" />';
//            $html .= '<div class="nbdclipart-thumb" style="margin-top: 20px">';
//
            echo $html;
            ?>
            <script type="text/javascript">
                jQuery('#set-nbdclipart').on('click', function (e) {
                    e.preventDefault();
                    var sefl = this;
                    var clipartUploader = wp.media.frames.file_frame = wp.media({
                        title: 'Choose Clipart',
                        button: {
                            text: 'Choose clipart'
                        },
                        multiple: true
                    });

                    //When a file is selected, grab the URL and set it as the text field's value
                    clipartUploader.on('select', function() {
                        var attachment = clipartUploader.state().get('selection').toJSON();
//                        $upload_button.siblings('input[type="text"]').val(attachment.url);
                        jQuery('#nbdclipart-gallery').empty();
                        jQuery.each(attachment, function (key, val) {
                            var item = '<div class="nbdesigner_art_link"><img src="' + val.url + '" /></div>'
                            jQuery('#nbdclipart-gallery').append(item);
                        });

                        
//                        console.log(attachment);
//                        debugger;
//                        jQuery('#nbdclipart-selected').val()
                    });

                    //Open the uploader dialog
                    clipartUploader.open();
                });
            </script>
            <?php
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
            );
            foreach ($ajax_events as $ajax_event => $nopriv) {
                add_action('wp_ajax_' . $ajax_event, array($this, $ajax_event));
                if ($nopriv) {
                    // NBDesigner AJAX can be used for frontend ajax requests
                    add_action('wp_ajax_nopriv_' . $ajax_event, array($this, $ajax_event));
                }
            }
        }

        public function nbd_add_color_group(){
            
        }
        public function nbd_add_color(){}
        public function manage_clipart_menu(){
            add_submenu_page(
                'nbdesigner', __('NB  manage clipart', 'web-to-print-online-designer'), __('Manage clipart', 'web-to-print-online-designer'), 'manage_nbd_tool', 'manage_clipart', array($this, 'manage_clipart')
            );
        }
        public function manage_clipart(){
            include_once(NBDESIGNER_PLUGIN_DIR . 'views/manage-clipart.php');
        }
        function create_nbdclipart_cpt() {
            $args = array(
                'labels' => array(
                    'name'                  => __( 'NBD Clipart', 'web-to-print-online-designer' ),
                    'singular_name'         => __( 'nbd-clipart', 'web-to-print-online-designer' ),
                    'menu_name'             => __( 'NBD Clipart', 'web-to-print-online-designer' ),
                    'name_admin_bar'        => __( 'nbd-clipart', 'web-to-print-online-designer' ),
                    'archives'              => __( 'Clipart Archives', 'web-to-print-online-designer' ),
                    'attributes'            => __( 'Clipart Attributes', 'web-to-print-online-designer' ),
                    'parent_item_colon'     => __( 'Parent clipart:', 'web-to-print-online-designer' ),
                    'all_items'             => __( 'All clipart', 'web-to-print-online-designer' ),
                    'add_new_item'          => __( 'Add New Clipart', 'web-to-print-online-designer' ),
                    'add_new'               => __( 'Add New', 'web-to-print-online-designer' ),
                    'new_item'              => __( 'New clipart', 'web-to-print-online-designer' ),
                    'edit_item'             => __( 'Edit clipart', 'web-to-print-online-designer' ),
                    'update_item'           => __( 'Update clipart', 'web-to-print-online-designer' ),
                    'view_item'             => __( 'View clipart', 'web-to-print-online-designer' ),
                    'view_items'            => __( 'View Nbd Clipart', 'web-to-print-online-designer' ),
                    'search_items'          => __( 'Search clipart', 'web-to-print-online-designer' ),
                    'not_found'             => __( 'No clipart found', 'web-to-print-online-designer' ),
                    'not_found_in_trash'    => __( 'No clipart found in Trash', 'web-to-print-online-designer' ),
                    'featured_image'        => __( 'Clipart Image', 'web-to-print-online-designer' ),
                    'set_featured_image'    => __( 'Set clipart image', 'web-to-print-online-designer' ),
                    'remove_featured_image' => __( 'Remove featured image', 'web-to-print-online-designer' ),
                    'use_featured_image'    => __( 'Use as featured image', 'web-to-print-online-designer' ),
                    'insert_into_item'      => __( 'Insert into clipart', 'web-to-print-online-designer' ),
                    'uploaded_to_this_item' => __( 'Uploaded to this clipart', 'web-to-print-online-designer' ),
                    'items_list'            => __( 'Nbd Clipart list', 'web-to-print-online-designer' ),
                    'items_list_navigation' => __( 'Nbd Clipart list navigation', 'web-to-print-online-designer' ),
                    'filter_items_list'     => __( 'Filter Nbd Clipart list', 'web-to-print-online-designer' ),
                ),
                'label' => __( 'nbd-clipart', 'web-to-print-online-designer' ),
                'description' => __( 'manage clipart of Nbdesigner ', 'web-to-print-online-designer' ),
                'menu_icon' => 'dashicons-analytics',
//                'supports' => array('custom-fields','author'),
                'supports' => array('title','thumbnail'),
                'taxonomies' => array('clipart_category'),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => false,
                'menu_position' => 1,
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => false,
                'can_export' => true,
                'has_archive' => true,
                'hierarchical' => true,
                'exclude_from_search' => false,
                'show_in_rest' => true,
                'publicly_queryable' => true,
                'capability_type' => 'post',
            );
            register_post_type( 'nbdclipart', $args );

        }
        function create_nbdclipart_category_tax() {

            $args = array(
                'label' => __( 'Categories', 'web-to-print-online-designer' ),
                'labels' => array(
                    'name'              => __( 'Clipart categories', 'web-to-print-online-designer' ),
                    'singular_name'     => __( 'Category', 'web-to-print-online-designer' ),
                    'search_items'      => __('Search categories', 'web-to-print-online-designer'),
                    'all_items'         => __('All categories', 'web-to-print-online-designer'),
                    'parent_item'       => __('Parent category:', 'web-to-print-online-designer'),
                    'parent_item_colon' => __('Parent category:', 'web-to-print-online-designer'),
                    'edit_item'         => __('Edit category', 'web-to-print-online-designer'),
                    'update_item'       => __('Update category', 'web-to-print-online-designer'),
                    'add_new_item'      => __('Add new category', 'web-to-print-online-designer'),
                    'new_item_name'     => __('New category name', 'web-to-print-online-designer'),
                    'not_found'         => __( 'No categories found', 'woocommerce' ),
                    'menu_name'         => __('Category', 'web-to-print-online-designer'),
                ),
                'description' => __( 'custom taxonomy for clipart', 'web-to-print-online-designer' ),
                'hierarchical' => true,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'show_in_menu' => false,
                'show_in_nav_menus' => true,
                'show_in_rest' => false,
                'show_tagcloud' => true,
                'show_in_quick_edit' => true,
                'show_admin_column' => false,
                'rewrite'          => array(
                    'slug'         => 'clipart_category',
                    'with_front'   => false,
                    'hierarchical' => true,
                ),
            );

            register_taxonomy( 'clipart_category', array('nbdclipart'), $args );

        }
    }
}
$nbd_clipart = NBD_CLIPART::instance();
$nbd_clipart->init();

