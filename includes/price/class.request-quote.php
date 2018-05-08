<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if(!class_exists('NBD_REQUEST_QUOTE')){
    class NBD_REQUEST_QUOTE {
        protected static $instance;
        protected $_data = array();
        public function __construct() {
            $this->_data['raq_order_status'] = array(
                'wc-ywraq-new',
                'wc-ywraq-pending',
                'wc-ywraq-expired',
                'wc-ywraq-rejected',
                'wc-ywraq-accepted'
            );
        }
	public static function instance() {
            if ( is_null( self::$instance ) ) {
                    self::$instance = new self();
            }
            return self::$instance;
	}  
        public function init(){ 
            
        }       
    }
}
$nbd_request_quote = NBD_REQUEST_QUOTE::instance();
$nbd_request_quote->init();