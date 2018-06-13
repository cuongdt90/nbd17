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
            $flag = 1;
            if (!wp_verify_nonce($_REQUEST['nonce'], 'nbdesigner-get-data')) {
                //todo something
            }else{     
                $rq_type = $_REQUEST['type'];
                $data = array();
                switch ($rq_type) {
                    case 'typography':
                        $path = $_REQUEST['task'] == 'typography' ? NBDESIGNER_PLUGIN_DIR . '/data/typography/typography.json' : NBDESIGNER_PLUGIN_DIR . '/data/typography/typo.json';
                        if(file_exists($path) ) $data = json_decode( file_get_contents($path) );
                        break;  
                    case 'clipart':
                        $path_cat = NBDESIGNER_DATA_DIR . '/art_cat.json';
                        $path_art = NBDESIGNER_DATA_DIR . '/arts.json'; 
                        $data['cat'] = $data['arts'] = array();
                        $data['cat'] = file_exists($path_cat) ? json_decode(file_get_contents($path_cat)) : array();
                        $data['arts'] = file_exists($path_art) ? json_decode(file_get_contents($path_art)) : array();                     
                        break;
                    case 'save_typography':
                        $path = NBDESIGNER_PLUGIN_DIR . 'data/typography/typo.json';
                        $folder = substr(md5(uniqid()),0,5).rand(1,100).time();
                        $store_path = NBDESIGNER_PLUGIN_DIR . 'data/typography/store/' . $folder;
                        if( !file_exists($store_path) ) wp_mkdir_p ($store_path);
                        $design_path = $store_path . '/design.json';
                        $used_font_path = $store_path . '/used_font.json';
                        $preview_path = $store_path . '/preview.png';
                        $list_typo = array();
                        if(file_exists($path) ) $list_typo = json_decode(file_get_contents ($path));
                        foreach ($_FILES as $key => $val) {
                            switch($key){
                                case 'design': 
                                    $full_name = $design_path;
                                    break;
                                case 'used_font': 
                                    $full_name = $used_font_path;
                                    break;     
                                case 'frame_0': 
                                    $full_name = $preview_path;
                                    break;                                
                            };
                            if ( !move_uploaded_file($val["tmp_name"],$full_name) ) {      
                                $flag = 0;
                            }                      
                        };
                        if( $flag ){
                            $id = isset($_REQUEST['id']) ? absint($_REQUEST['id'] - 1) : count($list_typo);
                            $new_typo = array(
                                'id' => $id,
                                'folder'    =>  $folder
                            );
                            $exist_id = -1;
                            foreach ($list_typo as $index => $typo){
                                if( $index == $id ){
                                    $exist_id = $index; break;
                                }
                            }
                            if($exist_id > -1){
                                $list_typo[$exist_id] = $new_typo;
                            }else{
                                $list_typo[] = $new_typo;
                            }
                            file_put_contents($path, json_encode($list_typo));
                            $data['typo'] = $list_typo;
                        }
                        break;
                    case 'google_font':
                        $all_gg_fonts = json_decode(file_get_contents(NBDESIGNER_PLUGIN_DIR. '/data/google-fonts-ttf.json'))->items;
                        $font_name = $_REQUEST['font_name'];
                        $subset = 'all';
                        $file = array('r' => 1);
                        $flag = 0;
                        foreach( $all_gg_fonts as $f ){
                            if( $font_name == $f->family || str_replace(" ","",$font_name) == $f->family ){
                                if( str_replace(" ","",$font_name) == $f->family ) $font_name = str_replace(" ","",$font_name);
                                $subset = $f->subsets[0];
                                if( isset($f->files->italic) ){
                                    $file['i'] = 1;
                                }
                                if( isset($f->files->{"700"}) ){
                                    $file['b'] = 1;
                                }
                                if( isset($f->files->{"700italic"}) ){
                                    $file['bi'] = 1;
                                }  
                                $flag = 1;
                                break;
                            }
                        }
                        $data = array(
                            "id"    =>  99,
                            "name"    =>  $font_name,
                            "alias"    =>  $font_name,
                            "type"   =>  "google", 
                            "subset"   =>  $subset, 
                            "file"   =>  $file, 
                            "cat" => array("99")
                        );
                        break;                         
                }
            }
            wp_send_json(
                array( 
                    'flag' =>  $flag, 
                    'data'  =>  $data
                )
            );
        }
    }
}
$nbd_resource = NBD_RESOURCE::instance();
$nbd_resource->init();