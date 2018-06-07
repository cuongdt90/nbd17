<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if(!class_exists('NBD_RESOURCE')){
    class NBD_RESOURCE {
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
            if (is_admin()) {
                $this->ajax();
            }
        }   
        public function ajax(){
            $ajax_events = array(
                'nbd_get_resource'    =>  true
            );
            foreach ($ajax_events as $ajax_event => $nopriv) {
                add_action('wp_ajax_' . $ajax_event, array($this, $ajax_event));
                if ($nopriv) {
                    add_action('wp_ajax_nopriv_' . $ajax_event, array($this, $ajax_event));
                }
            }        
        }
        public function nbd_get_resource(){
            $flag = 0;
            if (!wp_verify_nonce($_REQUEST['nonce'], 'nbdesigner-get-data')) {
                //todo something
            }else{     
                $rq_type = $_REQUEST['type'];
                $data = array();
                switch ($rq_type) {
                    case 'typography':
                        $path = NBDESIGNER_PLUGIN_DIR . '/data/typography/typography.json';
                        if(file_exists($path) ) $data = json_decode( file_get_contents($path) );
                        break;  
                    case 'clipart':
                        $path_cat = NBDESIGNER_DATA_DIR . '/art_cat.json';
                        $path_art = NBDESIGNER_DATA_DIR . '/arts.json'; 
                        $data['cat'] = $data['arts'] = array();
                        $data['cat'] = file_exists($path_cat) ? json_decode(file_get_contents($path_cat)) : array();
                        $data['arts'] = file_exists($path_art) ? json_decode(file_get_contents($path_art)) : array();                     
                        break;
                }
                $flag = 1;
            }
            wp_send_json(
                array( 
                    'flag' =>  $flag, 
                    'data'  =>  $data
                )
            );        
            //echo $data;die();
        }
    }
}
$nbd_resource = NBD_RESOURCE::instance();
$nbd_resource->init();