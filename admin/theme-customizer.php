<?php

function burf_customize_register($wp_customize){
    
    $wp_customize->add_section('burf_site_header', array(
        'title'    => __('Site Header', 'burf'),
        'priority' => 120,
    ));
 
    //  =============================
    //  = Text Input                =
    //  =============================
    $wp_customize->add_setting('burf_color', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
 
    ));
 
    $wp_customize->add_control('burf_text_test', array(
        'label'      => __('Branding Color', 'burf'),
        'section'    => 'burf_site_header',
        'settings'   => 'burf_color',
    ));
 
	//  =============================
    //  = Radio Input               =
    //  =============================
    $wp_customize->add_setting('burf_header_layout', array(
        'default'        => 'branding',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
 
    $wp_customize->add_control('burf_header_layout', array(
        'label'      => __('What is on top?', 'burf'),
        'section'    => 'burf_site_header',
        'settings'   => 'burf_header_layout',
        'type'       => 'radio',
        'choices'    => array(
            'branding' => 'Site Branding',
            'navbar' => 'Navigation Bar'
        ),
    ));
}
 
add_action('customize_register', 'burf_customize_register');




function burf_customize_css(){
    ?>
         <style type="text/css">
             #siteName { color: <?php echo(get_option("burf_color")); ?> }
         </style>
    <?php
}
add_action( 'wp_head', 'burf_customize_css');



?>