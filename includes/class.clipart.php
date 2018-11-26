<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!class_exists('NBD_CLIPART')){
    class NBD_CLIPART
    {
        protected static $instance;
        private $initClipart = false;

        public static function instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function init()
        {
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 30, 1);
            add_action('init', array($this, 'nbdclipart_create_cpt'), 0);
//            add_action('init', array($this, 'create_categories_tax'));
            add_action('init', array($this, 'nbdclipart_create_category_tax'));
            // add meta box
            add_action('add_meta_boxes', array($this, 'nbdclipart_add_meta_box'));

            // save clipart - sau khi post saved
            add_action('save_post_nbdclipart', array($this, 'nbdclipart_save_post'));
            add_action('wp_insert_post_data', array($this, 'nbdclipart_insert_post'));

            // table list custom postype
            add_action('manage_edit-nbdclipart_columns', array($this, 'nbdclipart_columns'));
            add_action('manage_nbdclipart_posts_custom_column', array($this, 'nbdclipart_column'));

            // set uncategorized
            add_action('init', array($this, 'nbdclipart_set_default_term'));

            // Add row actions taxonomy category clipart.
            add_filter( 'clipart_category_row_actions', array( $this, 'nbdclipart_cat_row_actions' ), 10, 2 );

            // sortable
            add_filter( 'manage_edit-nbdclipart_sortable_columns', array( $this, 'nbdclipart_sortable_columns' ) );

            // filter dropdown clipart
            add_action('restrict_manage_posts', array($this, 'nbdclipart_manage_filter'));

            $this->ajax();

//            add_action('wp_loaded', array($this, 'nbdclipart_set_transient'));
        }

        public function nbdclipart_edit_term(){
            echo '<pre>'; print_r('aaaa'); echo '</pre>'; echo __FILE__; die();
        }

        public function nbdclipart_manage_filter( $post_type ){
            if ($post_type == 'nbdclipart') {

                global $wp_query;

                $args = array(
                    'option_select_text' => __( 'Filter by category', 'web-to-print-online-designer' ),
                    'pad_counts'         => 1,
                    'show_count'         => 1,
                    'hierarchical'       => 1,
                    'hide_empty'         => 1,
                    'show_uncategorized' => 1,
                    'orderby'            => 'name',
                    'selected'           => isset( $wp_query->query_vars['clipart_category'] ) ? $wp_query->query_vars['clipart_category']: '',
                    'menu_order'         => false,
                    'show_option_none'   => __( 'Select a category', 'web-to-print-online-designer' ),
                    'option_none_value'  => '',
                    'value_field'        => 'slug',
                    'taxonomy'           => 'clipart_category',
                    'name'               => 'clipart_category',
                    'class'              => 'dropdown_clipart_category',
                ) ;

                if ( 'order' === $args['orderby'] ) {
                    $args['menu_order'] = 'asc';
                    $args['orderby']    = 'name';
                }

                wp_dropdown_categories( $args );
            }
        }

        public function nbdclipart_sortable_columns($columns){
            return $columns;
        }

        /**
         * Adjust row actions.
         *
         * @param array $actions Array of actions.
         * @param object $term Term object.
         * @return array
         */
        public function nbdclipart_cat_row_actions($actions = array(), $term){
            $default_category_id = absint( get_option( 'default_clipart_cat', 0 ) );

            if ( $default_category_id == $term->term_id ) {
                unset($actions['delete']);
            }

            return $actions;
        }

        public function nbdclipart_set_default_term(){
            $default_category = (int)get_option('default_clipart_cat', 0);
            if (!$default_category || !term_exists($default_category,'clipart_category')) {
                $default_clipart_cat_id = 0;
                $default_clipart_cat_slug = sanitize_title( _x( 'Uncategorized', 'Default category slug', 'web-to-print-online-designer' ) );
                $default_clipart_cat      = get_term_by( 'slug', $default_clipart_cat_slug, 'clipart_category' );

                if ( $default_clipart_cat ) {
                    $default_clipart_cat_id = absint( $default_clipart_cat->term_taxonomy_id );
                } else {
                    $result = wp_insert_term( _x( 'Uncategorized', 'Default category slug', 'web-to-print-online-designer' ), 'clipart_category', array( 'slug' => $default_clipart_cat_slug ) );

                    if ( ! is_wp_error( $result ) && ! empty( $result['term_taxonomy_id'] ) ) {
                        $default_clipart_cat_id = absint( $result['term_taxonomy_id'] );
                    }
                }

                if ( $default_clipart_cat_id ) {
                    update_option( 'default_clipart_cat', $default_clipart_cat_id );
                }
            }
        }

        public function nbdclipart_insert_post($data, $postarr){
            if ($data['post_type'] == 'nbdclipart' && $data['post_name'] == '') {
                $totalPost = wp_count_posts('nbdclipart');
                $totalPost = (array)$totalPost;
                unset($totalPost['auto-draft']);
                $totalPost = array_sum($totalPost);

                $data['post_title'] = 'Clipart-' . $totalPost;
            }
            return $data;
        }

        public function nbdclipart_columns($columns)
        {
            $date = $columns['date'];
            unset($columns['date']);
//            unset($columns['title']);

            $columns["clipart"] = 'Clipart';
            $columns['category'] = 'Category';
            $columns['date'] = $date;

            return $columns;
        }

        public function nbdclipart_column($columns)
        {
            global $post;

            if ($columns == 'clipart') {
                $clipart_id = get_post_meta($post->ID, 'nbdclipart_id', true);
                $src = wp_get_attachment_image_src($clipart_id);
                $htmlClipart = '<img src="' . $src[0] . '" style="width:40px"/>';

                echo $htmlClipart;
            }
            if ($columns == 'category') {
                $categories = get_the_terms($post->ID, 'clipart_category');
                $htmlCat = '';
                foreach ($categories as $category) {
                    $htmlCat .= '<a href="' . admin_url('edit.php?clipart_category=' . $category->slug . '&post_type=nbdclipart') . '">' . $category->name . '</a>';
                    $htmlCat .= ' ,';
                }
                $htmlCat = substr($htmlCat, 0, -1);

                echo $htmlCat;
            }

        }

        public function nbdclipart_save_post($post_id)
        {

            $cats = wp_get_post_terms($post_id, 'clipart_category');
            if (empty($cats)) {
                $default_cat = get_option('default_clipart_cat');
                wp_set_post_terms($post_id, $default_cat, 'clipart_category', false);
            }

            if (!$this->initClipart) {
                $this->initClipart = true;
                $cliparts = (isset($_POST['nbdclipart'])) ? $_POST['nbdclipart'] : '';
                $arrCliparts = ($cliparts !== '') ? explode(',', $cliparts) : array();
                foreach ($arrCliparts as $key => $clipart) {

                    if ($key == 0) {
                        $src = wp_get_attachment_image_src($clipart, 'medium');
                        update_post_meta($post_id, 'nbdclipart_id', $clipart);
                        update_post_meta($post_id, 'nbdclipart_src', $src[0]);
                    } else {
                        $new_post = array(
                            'post_author' => $_POST['post_author'],
                            'post_status' => $_POST['post_status'],
                            'post_type' => $_POST['post_type'],
                            'comment_status' => $_POST['comment_status'],
                            'ping_status' => $_POST['ping_status'],
                            'post_password' => $_POST['post_password'],
                            'tax_input' => $_POST['tax_input']
                        );
                        $new_clipart = wp_insert_post($new_post, false);
                        if ($new_clipart) {
                            $src = wp_get_attachment_image_src($clipart, 'medium');
                            update_post_meta($new_clipart, 'nbdclipart_id', $clipart);
                            update_post_meta($new_clipart, 'nbdclipart_src', $src[0]);
                        }
                    }
                }

                // set transient
                $this->nbdclipart_set_transient();

                // redirect to list clipart
                if (count($arrCliparts) > 1) {
                    wp_redirect(admin_url('edit.php?post_type=nbdclipart'));
                    exit();
                }

            }
        }

        public function nbdclipart_add_meta_box()
        {
            add_meta_box("wp_custom_attachment", "chose / upload file", array($this, 'nbdclipart_meta_options'), "nbdclipart", "normal", "high");
        }

        public function nbdclipart_meta_options()
        {
            global $post;

            $nbdclipart_id = get_post_meta($post->ID, 'nbdclipart_id');
            $src = (isset($nbdclipart_id) && $nbdclipart_id !== '') ? wp_get_attachment_image_src($nbdclipart_id[0], 'medium') : '';
            wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_attachment_nonce');
            $html = '';
            $html .= '<p class="add_clipart_images hide-if-no-js">
                        <a href="#" id="set-nbdclipart">Add clipart</a>
                        <input type="hidden" id="nbdclipart-selected" name="nbdclipart">
		              </p>';

            $html .= '<div id="nbdclipart-gallery">';

            if (is_array($src)) {
                $html .= '<div class="nbdesigner_art_link"><img src="' . $src[0] . '" /></div>';
            }

            $html .= '</div>';

            echo $html;
            wp_enqueue_media();
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
                    clipartUploader.on('select', function () {
                        var attachment = clipartUploader.state().get('selection').toJSON(),
                            arrInput = [];
//                        $upload_button.siblings('input[type="text"]').val(attachment.url);
                        jQuery('#nbdclipart-gallery').empty();
                        jQuery.each(attachment, function (key, val) {
                            var item = '<div class="nbdesigner_art_link"><img src="' + val.url + '" /></div>';
                            jQuery('#nbdclipart-gallery').append(item);
                            arrInput.push(val.id);
                        });
                        jQuery('#nbdclipart-selected').val(arrInput);
                    });

                    //Open the uploader dialog
                    clipartUploader.open();
                });
            </script>
            <?php
        }

        public function admin_enqueue_scripts($hook)
        {
            if ($hook == 'nbdesigner_page_manage_color') {
                wp_enqueue_style('nbdesigner_sweetalert_css', NBDESIGNER_CSS_URL . 'sweetalert.css');
                wp_enqueue_script('nbdesigner_sweetalert_js', NBDESIGNER_JS_URL . 'sweetalert.min.js', array('jquery'));
            }
        }

        public function ajax()
        {
            $ajax_events = array(
                'nbd_add_color_group' => false,
                'nbd_add_color' => false,
            );
            foreach ($ajax_events as $ajax_event => $nopriv) {
                add_action('wp_ajax_' . $ajax_event, array($this, $ajax_event));
                if ($nopriv) {
                    // NBDesigner AJAX can be used for frontend ajax requests
                    add_action('wp_ajax_nopriv_' . $ajax_event, array($this, $ajax_event));
                }
            }
        }

        public function nbd_add_color_group()
        {

        }

        public function nbd_add_color()
        {
        }

        public function manage_clipart()
        {
            include_once(NBDESIGNER_PLUGIN_DIR . 'views/manage-clipart.php');
        }

        public function nbdclipart_create_cpt()
        {
            $args = array(
                'labels' => array(
                    'name' => __('NBD Clipart', 'web-to-print-online-designer'),
                    'singular_name' => __('nbd-clipart', 'web-to-print-online-designer'),
                    'menu_name' => __('NBD Clipart', 'web-to-print-online-designer'),
                    'name_admin_bar' => __('nbd-clipart', 'web-to-print-online-designer'),
                    'archives' => __('Clipart Archives', 'web-to-print-online-designer'),
                    'attributes' => __('Clipart Attributes', 'web-to-print-online-designer'),
                    'parent_item_colon' => __('Parent clipart:', 'web-to-print-online-designer'),
                    'all_items' => __('All clipart', 'web-to-print-online-designer'),
                    'add_new_item' => __('Add New Clipart', 'web-to-print-online-designer'),
                    'add_new' => __('Add New', 'web-to-print-online-designer'),
                    'new_item' => __('New clipart', 'web-to-print-online-designer'),
                    'edit_item' => __('Edit clipart', 'web-to-print-online-designer'),
                    'update_item' => __('Update clipart', 'web-to-print-online-designer'),
                    'view_item' => __('View clipart', 'web-to-print-online-designer'),
                    'view_items' => __('View Nbd Clipart', 'web-to-print-online-designer'),
                    'search_items' => __('Search clipart', 'web-to-print-online-designer'),
                    'not_found' => __('No clipart found', 'web-to-print-online-designer'),
                    'not_found_in_trash' => __('No clipart found in Trash', 'web-to-print-online-designer'),
                    'featured_image' => __('Clipart Image', 'web-to-print-online-designer'),
                    'set_featured_image' => __('Set clipart image', 'web-to-print-online-designer'),
                    'remove_featured_image' => __('Remove featured image', 'web-to-print-online-designer'),
                    'use_featured_image' => __('Use as featured image', 'web-to-print-online-designer'),
                    'insert_into_item' => __('Insert into clipart', 'web-to-print-online-designer'),
                    'uploaded_to_this_item' => __('Uploaded to this clipart', 'web-to-print-online-designer'),
                    'items_list' => __('Nbd Clipart list', 'web-to-print-online-designer'),
                    'items_list_navigation' => __('Nbd Clipart list navigation', 'web-to-print-online-designer'),
                    'filter_items_list' => __('Filter Nbd Clipart list', 'web-to-print-online-designer'),
                ),
                'label' => __('nbd-clipart', 'web-to-print-online-designer'),
                'description' => __('manage clipart of Nbdesigner ', 'web-to-print-online-designer'),
                'menu_icon' => 'dashicons-analytics',
//                'supports' => array('custom-fields','author'),
                'supports' => array(''),
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
            register_post_type('nbdclipart', $args);

        }

        public function nbdclipart_create_category_tax()
        {

            $args = array(
                'label' => __('Categories', 'web-to-print-online-designer'),
                'labels' => array(
                    'name' => __('Clipart categories', 'web-to-print-online-designer'),
                    'singular_name' => __('Category', 'web-to-print-online-designer'),
                    'search_items' => __('Search categories', 'web-to-print-online-designer'),
                    'all_items' => __('All categories', 'web-to-print-online-designer'),
                    'parent_item' => __('Parent category:', 'web-to-print-online-designer'),
                    'parent_item_colon' => __('Parent category:', 'web-to-print-online-designer'),
                    'edit_item' => __('Edit category', 'web-to-print-online-designer'),
                    'update_item' => __('Update category', 'web-to-print-online-designer'),
                    'add_new_item' => __('Add new category', 'web-to-print-online-designer'),
                    'new_item_name' => __('New category name', 'web-to-print-online-designer'),
                    'not_found' => __('No categories found', 'woocommerce'),
                    'menu_name' => __('Category', 'web-to-print-online-designer'),
                ),
                'description' => __('custom taxonomy for clipart', 'web-to-print-online-designer'),
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
                'rewrite' => array(
                    'slug' => 'clipart_category',
                    'with_front' => false,
                    'hierarchical' => true,
                ),
            );

            register_taxonomy('clipart_category', array('nbdclipart'), $args);

        }

        public function nbdclipart_set_transient(){

            $result_1 = false;
            $result_2 = false;

            // clipart
            $argc = array(
                'post_type'   => 'nbdclipart',
                'numberposts' => -1,
                'orderby'     => 'id',
                'order'  => 'asc'

            );
            $cliparts = get_posts($argc);
            $result_cliparts = [];
            foreach ($cliparts as $clipart){
                $tmp = array();
                $tmp['id'] = $clipart->ID;
                $tmp['title'] = $clipart->post_title;
                $tmp['name'] = $clipart->name;
                $tmp['status'] = $clipart->post_status;

                $attach_id = get_post_meta($clipart->ID, 'nbdclipart_id');
                $src = wp_get_attachment_image_src($attach_id[0], 'medium');
                $tmp['file'] = $src[0];

                $clipart_cats = wp_get_post_terms($clipart->ID, 'clipart_category');
                $tmp_cats = array();
                foreach ($clipart_cats as $cat) {
                    $tmp_cats[] = $cat->term_id;
                }
                $tmp['cat'] = $tmp_cats;
                $result_cliparts[] = $tmp;
            }
            $result_cliparts = json_encode($result_cliparts);
            $result_1 = set_transient('nbd_clipart', $result_cliparts);

            // clipart cat
            $argc = array(
                'taxonomy' => 'clipart_category',
                'hide_empty' => false,
            );
            $clipart_cats = get_terms($argc);
            $result_clipart_cat = array();
            foreach ($clipart_cats as $cat) {
                $tmp = array();
                $tmp['id'] = $cat->term_id;
                $tmp['name'] = $cat->name;
                $tmp['slug'] = $cat->slug;
                $tmp['parent'] = $cat->parent;

                $result_clipart_cat[] = $tmp;
            }
            $result_clipart_cat = json_encode($result_clipart_cat);
            $result_2 = set_transient('nbd_clipart_category', $result_clipart_cat);

            return $result_1 && $result_2;
        }

        public function nbdclipart_clear_transients(){
            global $wpdb;
            $sql = "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_nbd_clipart' OR option_name LIKE '_transient_timeout_nbd_clipart'";
            $wpdb->query( $sql );
        }

        public function nbdclipart_cat_clear_transients(){
            global $wpdb;
            $sql = "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_nbd_clipart_category' OR option_name LIKE '_transient_timeout_clipart_category'";
            $wpdb->query( $sql );
        }
    }
}
$nbd_clipart = NBD_CLIPART::instance();
$nbd_clipart->init();


