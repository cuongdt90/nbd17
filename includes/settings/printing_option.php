<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if( !class_exists('Nbdesigner_Printing_Options') ) {    
    class Nbdesigner_Printing_Options{
        public static function get_options() {
            return apply_filters('nbdesigner_printing_options_settings', array(
                'general' => array(
                    array(
                        'title' => __( 'Hide Add to cart button until all required options are chosen', 'web-to-print-online-designer'),
                        'id' 		=> 'nbdesigner_hide_add_cart_until_form_filled',
                        'description' 	=> __('Check this to show the add to cart button only when all required options are filled.', 'web-to-print-online-designer'),
                        'default'	=> 'no',
                        'type' 		=> 'radio',
                        'options'   => array(
                            'yes' => __('Yes', 'web-to-print-online-designer'),
                            'no' => __('No', 'web-to-print-online-designer')
                        )                      
                    )                    
                ),                
                'cart' => array(
                    array(
                        'title' => __( 'Turn off persistent cart', 'web-to-print-online-designer'),
                        'id' 		=> 'nbdesigner_turn_off_persistent_cart',
                        'description' 	=> __('Enable this if the product has a lot of options.', 'web-to-print-online-designer'),
                        'default'	=> 'no',
                        'type' 		=> 'radio',
                        'options'   => array(
                            'yes' => __('Yes', 'web-to-print-online-designer'),
                            'no' => __('No', 'web-to-print-online-designer')
                        )                      
                    ),
                    array(
                        'title' => __( 'Clear cart button', 'web-to-print-online-designer'),
                        'id' 		=> 'nbdesigner_enable_clear_cart_button',
                        'description' 	=> __('Enables or disables the clear cart button.', 'web-to-print-online-designer'),
                        'default'	=> 'no',
                        'type' 		=> 'radio',
                        'options'   => array(
                            'yes' => __('Yes', 'web-to-print-online-designer'),
                            'no' => __('No', 'web-to-print-online-designer')
                        )                      
                    )                    
                )               
            ));
        }
    }
}