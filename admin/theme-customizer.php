<?php




function burf_customize_register($wp_customize){
   
   
   	class BURF_Customize_Layout extends WP_Customize_Control {
	    public $type = 'textarea';
	 
	    public function render_content() {
	        ?>
	        
	        <ul id="<?php echo($this->id); ?>">
	        <?php
	        	foreach($this->choices as $key=>$choice){
	        	?>
		        	<li>
		        		<input <?php $this->link(); ?> id="<?php echo($this->id . '_' . $key);?>" type="radio" name="<?php echo($this->id); ?>" value="<?php echo($key); ?>">
		        		<label for="<?php echo($this->id . '_' . $key);?>"> <?php echo($choice); ?></label>
		        	</li>
		        <?php
	        	}
	        ?>
	        </ul>
	        <?php
	    }
	}
   
   
    /* Section: Layout Options  */ 
    $wp_customize->add_section('burf_section_layout', array(
        'title'    => __('Layout Options', 'burf'),
        'priority' => 120,
    ));
 
		/* Setting: Layout */ 
	    $wp_customize->add_setting('burf_setting_layout', array(
	        'default'        => '',
	        'capability'     => 'edit_theme_options',
	        'type'           => 'option',
	 
	    ));
 
		/* Control: Layout Select*/ 
		$wp_customize->add_control( new BURF_Customize_Layout( $wp_customize, 'burf_section_layout', array(
            'label' => 'Layout Picker Setting',
            'section' => 'burf_section_layout',
            'settings' => 'burf_setting_layout',
	        'choices'    => array(
	            'branding' => 'Site Branding Top',
	            'navbar' => 'Navigation Bar Top',
	            'sidenav' => 'Side Navigation'
	        )
        )));
 
 
		
	//  =============================
    //  = Radio Input               =
    //  =============================
    $wp_customize->add_setting('burf_header_layout', array(
        'default'        => 'branding',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
 
    $wp_customize->add_control('burf_header_layout', array(
        'label'      => __('Pick your layout:', 'burf'),
        'section'    => 'burf_site_header',
        'settings'   => 'burf_header_layout',
        'type'       => 'radio',
        'choices'    => array(
            'branding' => 'Site Branding Top',
            'navbar' => 'Navigation Bar Top',
            'sidenav' => 'Side Navigation'
        ),
    ));
    
    $wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'link_color', 
		array(
			'label'      => __( 'Header Color', 'burf' ),
			'section'    => 'burf_site_header',
			'settings'   => 'burf_header_layout',
		) ) 
	);
	
	$wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'logo',
           array(
				'label'      => __( 'Upload a logo', 'theme_name' ),
				'section'    => 'burf_site_header',
				'settings'   => 'burf_header_layout',
				'context'    => 'your_setting_context' 
           )
       )
   );
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