<?php

global $floatcart_settings;

// General Settings section
$floatcart_settings[] = array(
    'section_id' => 'general',
    'section_title' => 'Settings',
    'section_description' => 'You can change the look and feel of Floating Cart here',
    'section_order' => 5,
    'fields' => array(
        array(
            'id' => 'enable_floating_cart',
            'title' => 'Turn on Floating Cart',
            'desc' => '',
            'type' => 'radio',
            'std' => 'no',
            'choices' => array(
                'yes' => 'Yes',
                'no' => 'No'
            )
        ),
        array(
            'id' => 'show_button_text',
            'title' => 'Show Button Text',
            'desc' => '',
            'type' => 'radio',
            'std' => 'yes',
            'choices' => array(
                'yes' => 'Yes',
                'no' => 'No'
            )
        ),        
        array(
            'id' => 'button_text',
            'title' => 'Button Text',
            'desc' => '',
            'type' => 'text',
            'std' => 'View Cart'
        ),
        array(
            'id' => 'show_cart_total_item',
            'title' => 'Show Cart Total Item',
            'desc' => '',
            'type' => 'radio',
            'std' => 'yes',
            'choices' => array(
                'yes' => 'Yes',
                'no' => 'No'
            )
        ),
        array(
            'id' => 'show_cart_total_amount',
            'title' => 'Show Cart Total Amount',
            'desc' => '',
            'type' => 'radio',
            'std' => 'yes',
            'choices' => array(
                'yes' => 'Yes',
                'no' => 'No'
            )
        ),
        array(
            'id' => 'button_color_predefined',
            'title' => 'Select the Button Color',
            'desc' => '',
            'type' => 'select',
            'std' => 'grey',
            'choices' => array(
                'grey' => 'Grey',
                'blue' => 'Blue',
                'lightblue' => 'Light Blue',
                'green' => 'Green',
                'red' => 'Red',
                'yellow' => 'Yellow',
                'black' => 'Black'
            )
        ),
        array(
            'id' => 'button_position',
            'title' => 'Button Position',
            'desc' => '',
            'type' => 'radio',
            'std' => 'top-right',
            'choices' => array(
                'top-left' => 'Top Left',
                'top-right' => 'Top Right',
                'middle-left' => 'Middle Left',
                'middle-right' => 'Middle Right',
                'bottom-left' => 'Bottom Left',
                'bottom-right' => 'Bottom Right'
            )
        )
    )
);

?>