<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if( !class_exists('Nbdesigner_Appearance_Settings') ) {
    class Nbdesigner_Appearance_Settings {
        public static function get_options() {
            return apply_filters('nbdesigner_appearance_settings', array(
                'product' => array( 
                    array(
                        'title' => __('Show design tool', 'web-to-print-online-designer'),
                        'id' => 'nbdesigner_page_design_tool',
                        'default' => '1',
                        'description' => __( 'Show design tool in product detail page or open new page', 'web-to-print-online-designer'),
                        'type' => 'radio',
                        'options' => array(
                            '1' => __('In product detail page', 'web-to-print-online-designer'),
                            '2' => __('Open new page', 'web-to-print-online-designer')
                        )
                    ),     
                    array(
                        'title' => __('Auto add to cart and redirect', 'web-to-print-online-designer'),
                        'id' => 'nbdesigner_auto_add_cart_in_detail_page',
                        'description' => __( 'Auto add to cart and redirect to cart page after save design in product detail page, depend option "Show design tool: In product detail page".', 'web-to-print-online-designer'),
                        'default'	=> 'no',
                        'type' 		=> 'radio',
                        'options'   => array(
                            'yes' => __('Yes', 'web-to-print-online-designer'),
                            'no' => __('No', 'web-to-print-online-designer')
                        ) 
                    ),                    
                    array(
                        'title' => __('Position of button design', 'web-to-print-online-designer'),
                        'id' => 'nbdesigner_position_button_product_detail',
                        'default' => '1',
                        'description' => __( 'The position of the product button designer in the product page', 'web-to-print-online-designer'),
                        'type' => 'radio',
                        'options' => array(
                            '1' => __('Before add to cart button and after variantions option', 'web-to-print-online-designer'),
                            '2' => __('Before variantions option', 'web-to-print-online-designer'),
                            '3' => __('After add to cart button', 'web-to-print-online-designer'),
                            '4' => __('Custom Hook, <code>echo do_shortcode( \'[nbdesigner_button]\' );</code> in product page', 'web-to-print-online-designer')
                        )
                    ), 
                    array(
                        'title' => __( 'Class for "Start design" button in product page', 'web-to-print-online-designer'),
                        'description' 		=> __( 'Enter your class to show "Start design" button with your style.', 'web-to-print-online-designer'),
                        'id' 		=> 'nbdesigner_class_design_button_detail',
                        'class'         => 'regular-text',
                        'default'	=> '',
                        'type' 		=> 'text',
                        'placeholder'   => 'nbd-btn'
                    ),     
                    array(
                        'title' => __('Hide button Add to cart before complete design', 'web-to-print-online-designer'),
                        'id' => 'nbdesigner_hide_button_cart_in_detail_page',
                        'description' => __( 'Only show button Add to cart after customer complete they design.', 'web-to-print-online-designer'),
                        'default'	=> 'no',
                        'type' 		=> 'radio',
                        'options'   => array(
                            'yes' => __('Yes', 'web-to-print-online-designer'),
                            'no' => __('No', 'web-to-print-online-designer')
                        ) 
                    ),
//                    array(
//                        'title' => __('Show table pricing', 'web-to-print-online-designer'),
//                        'id' => 'nbdesigner_position_pricing_in_detail_page',
//                        'description' => __( 'Choose position to show table pricing.', 'web-to-print-online-designer'),
//                        'default'	=> '1',
//                        'type' 		=> 'radio',
//                        'options'   => array(
//                            '1' => __('Pricing tab', 'web-to-print-online-designer'),
//                            '2' => __('Short description', 'web-to-print-online-designer')
//                        ) 
//                    ),
//                    array(
//                        'title' => __('Table pricing description', 'web-to-print-online-designer'),
//                        'id' => 'nbdesigner_quantity_pricing_description',
//                        'description' => __( 'Choose position to show table pricing.', 'web-to-print-online-designer'),
//                        'default'	=> 'Table pricing description',
//                        'type' 		=> 'textarea',
//                        'description'      => __('HTML Tags Supported', 'web-to-print-online-designer'),
//                        'css'         => 'width: 50em; height: 15em;'
//                    )                     
                ),
                'category' => array( 
                    array(
                        'title' => __('Position of button in the catalog', 'web-to-print-online-designer'),
                        'id' => 'nbdesigner_position_button_in_catalog',
                        'default' => '1',
                        'description' => __( 'The position of the button in the catalog listing.', 'web-to-print-online-designer'),
                        'type' => 'radio',
                        'options' => array(
                            '1' => __('Replace Add-to-Cart button', 'web-to-print-online-designer'),
                            '2' => __('End of catalog item', 'web-to-print-online-designer'),
                            '3' => __('Do not show', 'web-to-print-online-designer')
                        )
                    ),  
                    array(
                        'title' => __( 'Class for "Start design" button in catalog page', 'web-to-print-online-designer'),
                        'description' 		=> __( 'Enter your class to show "Start design" button with your style.', 'web-to-print-online-designer'),
                        'id' 		=> 'nbdesigner_class_design_button_catalog',
                        'class'         => 'regular-text',
                        'default'	=> '',
                        'type' 		=> 'text',
                        'placeholder'   => 'nbd-btn'
                    ),                   
                    
                ),
                'cart-checkout-order' => array( 
                    array(
                        'title' => __( 'Show customer design in cart, checkout page', 'web-to-print-online-designer'),
                        'id' 		=> 'nbdesigner_show_in_cart',
                        'description' 	=> __('Show the thumbnail of the customized product in the cart, checkout page.', 'web-to-print-online-designer'),
                        'default'	=> 'yes',
                        'type' 		=> 'radio',
                        'options'   => array(
                            'yes' => __('Yes', 'web-to-print-online-designer'),
                            'no' => __('No', 'web-to-print-online-designer')
                        )                        
                    ),
                    array(
                        'title' => __( 'Show customer design in order', 'web-to-print-online-designer'),
                        'id' 		=> 'nbdesigner_show_in_order',
                        'description' 	=> __('Show the thumbnail of the customized product in the order.', 'web-to-print-online-designer'),
                        'default'	=> 'yes',
                        'type' 		=> 'radio',
                        'options'   => array(
                            'yes' => __('Yes', 'web-to-print-online-designer'),
                            'no' => __('No', 'web-to-print-online-designer')
                        )                        
                    ),                  
                    
                ),
                'misc' => array( 
                   
                    
                )               
            ));
        }
    }
}
