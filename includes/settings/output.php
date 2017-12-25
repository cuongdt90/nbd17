<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if( !class_exists('Nbdesigner_Settings_Output') ) {    
    class Nbdesigner_Settings_Output{
        public static function get_options() {
            return apply_filters('nbdesigner_output_settings', array(
                'pdf-settings' => array(
                    array(
                        'title' => __( 'Allow download PDF before complete order', 'web-to-print-online-designer'),
                        'id' 		=> 'nbdesigner_enable_download_pdf_before',
                        'description' 	=> __('Allow the customer download PDF before complete order', 'web-to-print-online-designer'),
                        'default'	=> 'no',
                        'type' 		=> 'radio',
                        'options'   => array(
                            'yes' => __('Yes', 'web-to-print-online-designer'),
                            'no' => __('No', 'web-to-print-online-designer')
                        )                      
                    ),    
                    array(
                        'title' => __( 'Allow download PDF after complete order', 'web-to-print-online-designer'),
                        'id' 		=> 'nbdesigner_enable_download_pdf_after',
                        'description' 	=> __('Allow the customer download PDF after complete order without watermark', 'web-to-print-online-designer'),
                        'default'	=> 'no',
                        'type' 		=> 'radio',
                        'options'   => array(
                            'yes' => __('Yes', 'web-to-print-online-designer'),
                            'no' => __('No', 'web-to-print-online-designer')
                        )                      
                    ),                     
                    array(
                        'title' => __( 'PDF watermark', 'web-to-print-online-designer'),
                        'id' 		=> 'nbdesigner_enable_pdf_watermark',
                        'description' 	=> __('Enable watermark if allow customer download PDF before complete order', 'web-to-print-online-designer'),
                        'default'	=> 'yes',
                        'type' 		=> 'radio',
                        'options'   => array(
                            'yes' => __('Yes', 'web-to-print-online-designer'),
                            'no' => __('No', 'web-to-print-online-designer')
                        )                      
                    ),
                    array(
                        'title' => __( 'PDF watermark type', 'web-to-print-online-designer'),
                        'id' 		=> 'nbdesigner_pdf_watermark_type',
                        'default'	=> '1',
                        'type' 		=> 'radio',
                        'options' => array(
                            '1' => __('Image', 'web-to-print-online-designer'),
                            '2' => __('Text', 'web-to-print-online-designer')
                        )                     
                    ),
                    array(
                        'title' => __( 'PDF watermark image', 'web-to-print-online-designer'),
                        'id' 		=> 'nbdesigner_pdf_watermark_image',
                        'description' 	=> __('Choose a watermark image', 'web-to-print-online-designer'),
                        'default'	=> '',
                        'type' 		=> 'nbd-media'                      
                    ),
                    array(
                        'title' => __( 'PDF watermark text', 'web-to-print-online-designer'),
                        'description' 		=> __( 'Branded watermark text', 'web-to-print-online-designer'),
                        'id' 		=> 'nbdesigner_pdf_watermark_text',
                        'class'         => 'regular-text',
                        'default'	=> get_bloginfo('name'),
                        'type' 		=> 'text'
                    ),                      
                )
            ));
        }
    }
}