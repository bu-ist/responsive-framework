<?php

function burf_customize_register($wp_customize){
    
    $wp_customize->add_section('burf_color_scheme', array(
        'title'    => __('Color Scheme', 'burf'),
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
        'label'      => __('H1 Color', 'burf'),
        'section'    => 'burf_color_scheme',
        'settings'   => 'burf_color',
    ));
 
	//  =============================
    //  = Radio Input               =
    //  =============================
    $wp_customize->add_setting('burf_navPosition', array(
        'default'        => 'middle',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
 
    $wp_customize->add_control('burf_color_scheme', array(
        'label'      => __('Nav Position', 'burf'),
        'section'    => 'burf_color_scheme',
        'settings'   => 'burf_navPosition',
        'type'       => 'radio',
        'choices'    => array(
            'top' => 'Top',
            'middle' => 'Middle',
            'bottom' => 'Bottom',
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