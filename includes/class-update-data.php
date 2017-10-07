<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class NBD_Update_Data{
    public static function update_vatiation_config_v180(){
        if (!wp_verify_nonce($_POST['_nbdesigner_cupdate_product'], 'nbdesigner-update-product') || !current_user_can('administrator')) {
            die('Security error');
        }         
        $args_query = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'meta_key' => '_nbdesigner_enable',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page'=> -1,
            'meta_query' => array(
                array(
                    'key' => '_nbdesigner_enable',
                    'value' => 1,
                )
            )
        ); 
        $posts = get_posts($args_query);  
        $result = array('flag' => 1);
        if(is_array($posts)){    
            foreach ($posts as $post){
                $pid = get_wpml_original_id( $post->ID );
                $product = wc_get_product( $pid );    
                if( $pid != $post->ID ) continue;
                if( $product->is_type( 'variable' ) ) { 
                    $variations = $product->get_available_variations( false );
                    foreach ($variations as $variation){
                        $vid = $variation['variation_id'];
                        $designer_enable = get_post_meta($vid, '_nbdesigner_enable'.$vid, true);
                        $_designer_enable = get_post_meta($vid, '_nbdesigner_variation_enable'.$vid, true);
                        if( $_designer_enable ) continue;
                        $designer_setting = unserialize(get_post_meta($vid, '_designer_setting'.$vid, true));
                        if( $designer_enable ) {
                            update_post_meta($vid, '_designer_variation_setting', serialize($designer_setting));
                            update_post_meta($vid, '_nbdesigner_variation_enable', $designer_enable);
                        }
                    }
                }                  
            }
        }
        echo json_encode($result);
        wp_die();        
    }
}