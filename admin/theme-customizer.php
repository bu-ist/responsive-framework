<?php
function burf_customize_register($wp_customize){

	/* Custom Control: Radio */
   	class BURF_Customize_Radio extends WP_Customize_Control {
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
	
	
	/* Custom Control: Colors */
   	class BURF_Customize_Colors extends WP_Customize_Control {
	    public function render_content() {
	    
	    	wp_enqueue_script("iris");
			
			$colorString = get_option("burf_setting_colors");
			$colors = explode(",", $colorString);
			$choices = $this->choices;
			$isPalette = false;
			
			
	        foreach($choices as $key=>$choice){
	        	if(strtoupper($choice) == strtoupper($colorString)){
		        	$isPalette = true;
	        	}
	        	
	        }
	        ?>
	        
	        <ul <?php if(!$isPalette){ echo("style='display:none;'");} ?> id="<?php echo($this->id); ?>" >
	        <?php
	        	foreach($choices as $key=>$choice){
	        	?>
		        	<li>
		        		<input id="<?php echo($this->id . '_' . $key);?>" type="radio" name="<?php echo($this->id); ?>" value="<?php echo($choice); ?>">
		        		<label for="<?php echo($this->id . '_' . $key);?>"> <?php echo($key); ?></label>
		        	</li>
		        <?php
	        	}
	        ?>
	        	
	        </ul>
	        <ul id="burf_section_custom" <?php if($isPalette){ echo("style='display:none;'");} ?>>
	        	<li>
	        		<span class="customize-control-title">Page Headings</span>
	        		<a class="wp-color-result" tabindex="0" title="Select Color" style="background-color: <?php echo($colors[0]); ?>"></a>
	        		<input id="custom_one" name="custom_one" type="text" class='color-picker' value="<?php echo($colors[0]); ?>" />
	        		<a class="wp-color-close">Close</a>
	        	</li>
	        	<li>
	        		<span class="customize-control-title">Body Copy</span>
	        		<a class="wp-color-result" tabindex="0" title="Select Color" style="background-color: <?php echo($colors[1]); ?>"></a>
	        		<input id="custom_two" name="custom_two" type="text" class='color-picker' value="<?php echo($colors[1]); ?>" />
	        		<a class="wp-color-close">Close</a>
	        	</li>
	        	<li>
	        		<span class="customize-control-title">Links</span>
	        		<a class="wp-color-result" tabindex="0" title="Select Color" style="background-color: <?php echo($colors[2]); ?>"></a>
	        		<input id="custom_three" name="custom_three" type="text" class='color-picker' value="<?php echo($colors[2]); ?>" />
	        		<a class="wp-color-close">Close</a>
	        	</li>
	        	<li>
	        		<span class="customize-control-title">Accent Text</span>
	        		<a class="wp-color-result" tabindex="0" title="Select Color" style="background-color: <?php echo($colors[3]); ?>"></a>
	        		<input id="custom_four" name="custom_four" type="text" class='color-picker' value="<?php echo($colors[3]); ?>" />
	        		<a class="wp-color-close">Close</a>
	        	</li>
	        </ul>
	        
	        <a <?php if(!$isPalette){ echo("style='display:none;'");} ?> id="advanced-color" href="#">Advanced Options</a>
	        <a <?php if($isPalette){ echo("style='display:none;'");} ?> id="basic-color" href="#">Color Palettes</a>
	        
	        <input id="hiddenColor" name="hiddenColor" <?php $this->link(); ?> type="hidden" />
	        
	        
	        <?php
				
	    }
	}
   
   
   /* Custom Control: Backgrounds */
   	class BURF_Customize_Background extends WP_Customize_Control {
	    public function render_content() {
	        ?>
	        <div class="toggle">
	        	<div class="active">Color</div>
	        	<div>Image</div>
	        </div>
	        
	        <div class="color">
	        	<a class="wp-color-result" tabindex="0" title="Select Color" style="background-color: <?php echo($colors[0]); ?>"></a>
	        	<input id="bg_color" name="bg_color" type="text" class='color-picker-open' value="<?php echo($colors[0]); ?>" />
	        </div>
	        
	        <div class="image">


	        </div>
	        
	        
				Image upload
				Repeat (none, tile, horiz, vert)
				Position (left, right, center)
				Attachment (fixed, scroll)
	        
	        
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
	    //'priority' => 120,
	));
 
		/* Setting: Layout */ 
	    $wp_customize->add_setting('burf_setting_layout', array(
	        'default'        => '',
	        'capability'     => 'edit_theme_options',
	        'type'           => 'option',
	 
	    ));
 
		/* Control: Layout Select*/ 
		$wp_customize->add_control( new BURF_Customize_Radio( $wp_customize, 'burf_section_layout', array(
            'label' => 'Layout Picker Setting',
            'section' => 'burf_section_layout',
            'settings' => 'burf_setting_layout',
            'type'     => 'radio',
	        'choices'    => array(
	            'branding' => 'Site Branding Top',
	            'navbar' => 'Navigation Bar Top',
	            'sidenav' => 'Side Navigation'
	        )
        )));
        
        
    /* Section: Font Options  */ 
	$wp_customize->add_section('burf_section_fonts', array(
	    'title'    => __('Font Options', 'burf'),
	    //'priority' => 120,
	));
 
		/* Setting: Fonts */ 
	    $wp_customize->add_setting('burf_setting_fonts', array(
	        'default'        => '',
	        'capability'     => 'edit_theme_options',
	        'type'           => 'option',
	 
	    ));
 
		/* Control: Fonts Select*/ 
		$wp_customize->add_control( new BURF_Customize_Radio( $wp_customize, 'burf_section_fonts', array(
            'label' => 'Font Picker Setting',
            'section' => 'burf_section_fonts',
            'settings' => 'burf_setting_fonts',
            'type'     => 'radio',
	        'choices'    => array(
	            'f1' => 'BentonSansBold,Helvetica',
	            'f2' => 'BentonSansBook,Chronicle',
	            'f3' => 'CapitaBold,Helvetica',
	            'f4' => 'ChronicleDeckBold,Helvetica',
	            'f5' => 'CapitaBold,Helvetica'
	            
	        )
        )));
        
        
	/* Section: Color Options  */ 
    $wp_customize->add_section('burf_section_colors', array(
        'title'    => __('Text Color Options', 'burf'),
        //'priority' => 120,
    ));
 
		/* Setting: Colors */ 
	    $wp_customize->add_setting('burf_setting_colors', array(
	        'default'        => '',
	        'capability'     => 'edit_theme_options',
	        'type'           => 'option',
	 
	    ));
 
		/* Control: Colors Select */ 
		$wp_customize->add_control( new BURF_Customize_Colors( $wp_customize, 'burf_section_colors', array(
            'label' => 'Color Picker Setting',
            'section' => 'burf_section_colors',
            'settings' => 'burf_setting_colors',
            'type'     => 'radio',
	        'choices'    => array(
            	'option1' => '#000000,#CC0000,#5399C7,#B0B0B0',
	            'option2' => '#295E72,#3EA1BB,#87C6D5,#A6D3DF',
	            'option3' => '#934548,#6FA899,#F3E5D4,#F2BC4F',
	            'option4' => '#261514,#A6330A,#D96806,#BFBFBD',
	            'option5' => '#3D3B41,#BAAB80,#F8F0B3,#685F5F',
	            'option6' => '#8AAE45,#DA3A47,#2A2A2A,#D2D89B'
            )
	            
	    )));
	
	/* Section: Background Options  */ 
    $wp_customize->add_section('burf_section_background', array(
        'title'    => __('Background Options', 'burf'),
        //'priority' => 120,
    ));
 
		/* Setting: Background */ 
	    $wp_customize->add_setting('burf_setting_background', array(
	        'default'        => '',
	        'capability'     => 'edit_theme_options',
	        'type'           => 'option',
	 
	    ));
 
		/* Control: Colors Select */ 
		$wp_customize->add_control( new BURF_Customize_Background( $wp_customize, 'burf_section_background', array(
            'label' => 'Background Setting',
            'section' => 'burf_section_background',
            'settings' => 'burf_setting_background',
            'type'     => 'radio',
	        /*
'choices'    => array(
            	'option1' => '#000000,#CC0000,#5399C7,#B0B0B0',
	            'option2' => '#295E72,#3EA1BB,#87C6D5,#A6D3DF',
	            'option3' => '#934548,#6FA899,#F3E5D4,#F2BC4F',
	            'option4' => '#261514,#A6330A,#D96806,#BFBFBD',
	            'option5' => '#3D3B41,#BAAB80,#F8F0B3,#685F5F',
	            'option6' => '#8AAE45,#DA3A47,#2A2A2A,#D2D89B'
            )
*/
	            
	    )));
	    $wp_customize->add_control(
	       new WP_Customize_Image_Control(
	           $wp_customize,
	           'logo',
	           array(
	               'label'      => __( 'Upload a logo', 'theme_name' ),
	               'section'    => 'burf_section_background',
	               'settings'   => 'burf_setting_background'
	           )
	       )
	   );
	    
       
/*
 $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'burf_section_colors1', array(
				'section'    => 'burf_section_colors',
				'settings'   => 'burf_setting_colors',
		)));
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'burf_section_colors2', array(
				'section'    => 'burf_section_colors',
				'settings'   => 'burf_setting_colors',
		)));
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'burf_section_colors3', array(
				'section'    => 'burf_section_colors',
				'settings'   => 'burf_setting_colors',
		)));
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'burf_section_colors4', array(
				'section'    => 'burf_section_colors',
				'settings'   => 'burf_setting_colors',
		)));
*/

		

        
        
 
/*
 
		
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
*/
}
 
add_action('customize_register', 'burf_customize_register');




function burf_customize_css(){
	$colors = explode(",", get_option("burf_setting_colors"));
    ?>
         <style type="text/css">
             h1,h2,h3,h4,h5,h6 { color: <?php echo($colors[0]); ?> }
             p { color: <?php echo($colors[1]); ?> }
             a { color: <?php echo($colors[2]); ?> }
             strong { color: <?php echo($colors[3]); ?> }
         </style>
    <?php
}
add_action( 'wp_head', 'burf_customize_css');



?>