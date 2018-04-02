<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
class NBD_Admin_Setup_Wizard {
    private $step = '';
    private $steps = array();
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menus' ) );
        add_action( 'admin_init', array( $this, 'setup_wizard' ) );        
    }
    public function admin_menus() {
        add_dashboard_page( '', '', 'manage_options', 'nbd-setup', '' );
    }
    public function setup_wizard() {
        if ( empty( $_GET['page'] ) || 'nbd-setup' !== $_GET['page'] ) {
            return;
        }
        $default_steps = array(
            'general_setup' => array(
                'name'    => __( 'General setup', 'web-to-print-online-designer' ),
                'view'    => array( $this, 'nbd_setup_general_setup' ),
                'handler' => array( $this, 'nbd_setup_general_setup_save' ),
            ),
            'data'     => array(
                'name'    => __( 'NBD Data', 'web-to-print-online-designer' ),
                'view'    => array( $this, 'nbd_setup_data' ),
                'handler' => array( $this, 'nbd_setup_data_save' ),
            ),
            'overview'     => array(
                'name'    => __( 'Overview', 'web-to-print-online-designer' ),
                'view'    => array( $this, 'nbd_setup_overview' ),
                'handler' => '',
            )            
        );
        $this->steps = $default_steps;
        $this->step  = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );
        
        wp_enqueue_style('nbd-setup', NBDESIGNER_CSS_URL . 'nbd-setup.css', array('dashicons', 'install'), NBDESIGNER_VERSION);
        wp_register_script('nbd-setup', NBDESIGNER_JS_URL . 'nbd-setup.js', array('jquery'), NBDESIGNER_VERSION);
        
        if ( ! empty( $_POST['save_step'] ) && isset( $this->steps[ $this->step ]['handler'] ) ) {
            call_user_func( $this->steps[ $this->step ]['handler'], $this );
        }
        
        ob_start();
        $this->setup_wizard_header();
        $this->setup_wizard_steps();
        $this->setup_wizard_content();
        $this->setup_wizard_footer();        
        exit;
    }
    public function get_next_step_link( $step = '' ) {
        if ( ! $step ) {
            $step = $this->step;
        }
        $keys = array_keys( $this->steps );
        if ( end( $keys ) === $step ) {
            return admin_url();
        }
        $step_index = array_search( $step, $keys, true );
        if ( false === $step_index ) {
            return '';
        }
        return add_query_arg( 'step', $keys[ $step_index + 1 ], remove_query_arg( 'activate_error' ) );
    }    
    public function setup_wizard_steps() {
        $output_steps = $this->steps;
        ?>
        <ol class="nbd-setup-steps">
            <?php foreach ( $output_steps as $step_key => $step ) : ?>
                <li class="
                    <?php
                    if ( $step_key === $this->step ) {
                        echo 'active';
                    } elseif ( array_search( $this->step, array_keys( $this->steps ), true ) > array_search( $step_key, array_keys( $this->steps ), true ) ) {
                        echo 'done';
                    }
                    ?>
                "><?php echo esc_html( $step['name'] ); ?></li>
            <?php endforeach; ?>
        </ol>
        <?php
    }    
    public function setup_wizard_header() {
        ?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        <head>
                <meta name="viewport" content="width=device-width" />
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title><?php esc_html_e( 'NBDesigner &rsaquo; Setup Wizard', 'web-to-print-online-designer' ); ?></title>
                <?php wp_print_scripts( 'nbd-setup' ); ?>
                <?php do_action( 'admin_print_styles' ); ?>
                <?php do_action( 'admin_head' ); ?>
        </head>
        <body class="nbd-setup wp-core-ui">
            <h1 id="nbd-logo"><a href="http://netbaseteam.com/"><img src="<?php echo NBDESIGNER_PLUGIN_URL; ?>/assets/images/nbd.png" alt="NBDesigner" /></a></h1>
        <?php
    } 
    public function setup_wizard_footer() {
        ?>
                <a class="nbd-return-to-dashboard" href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'Return to your dashboard', 'web-to-print-online-designer' ); ?></a>
            </body>
        </html>
        <?php
    } 
    public function setup_wizard_content() {
        echo '<div class="nbd-setup-content">';
        if ( ! empty( $this->steps[ $this->step ]['view'] ) ) {
            call_user_func( $this->steps[ $this->step ]['view'], $this );
        }
        echo '</div>';
    }   
    public function nbd_setup_general_setup(){
        $dimension_unit = nbdesigner_get_option('nbdesigner_dimensions_unit');
        ?>
        <h1><?php esc_html_e( 'General', 'web-to-print-online-designer' ); ?></h1>  
        <form method="post" class="general-step">
            <div class="nbd-setup-shipping-unit">
                <p>
                    <label for="weight_unit">
                        <?php
                            printf( wp_kses(
                                    __( '<strong>Dimension unit</strong>—used to calculate design area.', 'web-to-print-online-designer' ),
                                    array( 'strong' => array() )
                            ) );
                        ?>
                    </label>
                </p>
                <select id="weight_unit" name="weight_unit" class="wc-enhanced-select">
                    <option value="cm" <?php selected( $dimension_unit, 'cm' ); ?>><?php esc_html_e( 'cm', 'web-to-print-online-designer' ); ?></option>
                    <option value="in" <?php selected( $dimension_unit, 'in' ); ?>><?php esc_html_e( 'in', 'web-to-print-online-designer' ); ?></option>
                    <option value="mm" <?php selected( $dimension_unit, 'mm' ); ?>><?php esc_html_e( 'mm', 'web-to-print-online-designer' ); ?></option>
                </select>
            </div>  
            <p class="nbd-setup-actions step">
                <button type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Continue', 'web-to-print-online-designer' ); ?>" name="save_step"><?php esc_html_e( 'Continue', 'web-to-print-online-designer' ); ?></button>
                <?php wp_nonce_field( 'nbd-setup' ); ?>
            </p>            
        </form>
        <?php            
    }
    public function nbd_setup_general_setup_save(){
        wp_safe_redirect( esc_url_raw( $this->get_next_step_link() ) );
        exit;
    }
    public function nbd_setup_data(){
        echo 'data';
    }
}
new NBD_Admin_Setup_Wizard();
