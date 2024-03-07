<?php

add_ux_builder_shortcode('tab', array(
    'type' => 'container',
    'name' => __('Tab Panel'),
    'template' => flatsome_ux_builder_template('tab.html'),
    'info' => '{{ title }}',
    'require' => array('tabgroup'),
    'hidden' => true,
    'wrap' => false,

    'options' => array(

        'title' => array(
            'type' => 'textfield',
            'heading' => __('Title'),
            'default' => __('Tab Title'),
            'auto_focus' => true,
        ),
        'img' => array(
            'type' => 'image',
            'heading' => 'Icon',
            'value' => '',
        ),
        'img_hover' => array(
            'type' => 'image',
            'heading' => 'Icon hover',
            'value' => '',
        ),
        'inline_svg' => array(
            'type' => 'checkbox',
            'heading' => 'Inline SVG',
            'default' => 'true',
        ),
    ),
));
