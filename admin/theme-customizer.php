<?php

// Child themes don't support Customizer.
if ( is_child_theme() ) {
	return;
}

/* - - - - - - - - - - - - - - - - -
  Admin CSS & JS
- - - - - - - - - - - - - - - - - */
function custom_admin_styles() {
	wp_register_style( 'admin-stylesheet', get_template_directory_uri() . '/admin/admin.css', '' );
	wp_register_script( 'theme-customizer', get_template_directory_uri() . '/admin/theme-customizer.js' );

	wp_enqueue_style( 'admin-stylesheet' );
	wp_enqueue_script( 'theme-customizer' );
}

add_action( 'admin_enqueue_scripts', 'custom_admin_styles' );
add_action( 'customize_controls_enqueue_scripts', 'custom_admin_styles' );

/* - - - - - - - - - - - - - - - - -
  Body_Class (For Customizer)
  - - - - - - - - - - - - - - - - - */
function browser_body_class( $classes = '' ) {
	$font_palette = get_option( 'burf_setting_fonts' );
	$layout_setting = get_option( 'burf_setting_layout' );

	if ( $font_palette ) {
		$classes[] = $font_palette;
	}
	if ( $layout_setting ) {
		$classes[] = $layout_setting;
	}

	return $classes;
}

add_filter( 'body_class', 'browser_body_class' );

function burf_customize_register( $wp_customize ) {

	/* Custom Control: Radio */
	class BURF_Customize_Radio extends WP_Customize_Control {
		public function render_content() {
			?>
			<ul id="<?php echo $this->id; ?>">
			<span class="customize-control-title"><?php echo $this->label; ?></span>
			<?php foreach ( $this->choices as $key => $choice ) { ?>
				<li>
					<input <?php $this->link(); ?> id="<?php echo $this->id . '_' . $key; ?>" type="radio" name="<?php echo $this->id; ?>" value="<?php echo $key; ?>">
					<label for="<?php echo $this->id . '_' . $key; ?>"> <?php echo $choice; ?></label>
				</li>
			<?php } ?>
			</ul>
			<?php
		}
	}

	/* Custom Control: Colors */
	class BURF_Customize_Colors extends WP_Customize_Control {
		public function render_content() {

			wp_enqueue_script( 'iris' );

			$color_string = get_option( 'burf_setting_colors' );
			$colors = explode( ',', $color_string );
			$choices = $this->choices;
			$is_palette = false;

			foreach ( $choices as $key => $choice ) {
				if ( strtoupper( $choice ) == strtoupper( $color_string ) ) {
					$is_palette = true;
				}
			}
			?>

			<ul <?php if ( ! $is_palette ) { echo "style='display:none;'";} ?> id="<?php echo $this->id; ?>" >
			<?php
			foreach ( $choices as $key => $choice ) { ?>
				<li>
					<input id="<?php echo $this->id . '_' . $key; ?>" type="radio" name="<?php echo $this->id; ?>" value="<?php echo $choice; ?>">
					<label for="<?php echo $this->id . '_' . $key; ?>"> <?php echo $key; ?></label>
				</li>
			<?php } ?>

			</ul>
			<ul id="burf_section_custom" <?php if ( $is_palette ) { echo "style='display:none;'";} ?>>
				<li>
					<span class="customize-control-title">Page Headings</span>
					<a class="wp-color-result" tabindex="0" title="Select Color" style="background-color: <?php echo $colors[0]; ?>"></a>
					<input id="custom_one" name="custom_one" type="text" class="color-picker" value="<?php echo $colors[0]; ?>" />
					<a class="wp-color-close">Close</a>
				</li>
				<li>
					<span class="customize-control-title">Body Copy</span>
					<a class="wp-color-result" tabindex="0" title="Select Color" style="background-color: <?php echo $colors[1]; ?>"></a>
					<input id="custom_two" name="custom_two" type="text" class="color-picker" value="<?php echo $colors[1]; ?>" />
					<a class="wp-color-close">Close</a>
				</li>
				<li>
					<span class="customize-control-title">Links</span>
					<a class="wp-color-result" tabindex="0" title="Select Color" style="background-color: <?php echo $colors[2]; ?>"></a>
					<input id="custom_three" name="custom_three" type="text" class="color-picker" value="<?php echo $colors[2]; ?>" />
					<a class="wp-color-close">Close</a>
				</li>
				<li>
					<span class="customize-control-title">Accent Text</span>
					<a class="wp-color-result" tabindex="0" title="Select Color" style="background-color: <?php echo $colors[3]; ?>"></a>
					<input id="custom_four" name="custom_four" type="text" class="color-picker" value="<?php echo $colors[3]; ?>" />
					<a class="wp-color-close">Close</a>
				</li>
			</ul>

			<a <?php if ( ! $is_palette ) { echo 'style="display: none;"';} ?> id="advanced-color" href="#">Advanced Options</a>
			<a <?php if ( $is_palette ) { echo "style='display:none;'";} ?> id="basic-color" href="#">Color Palettes</a>

			<input id="hiddenColor" name="hiddenColor" <?php $this->link(); ?> type="hidden" />
			<?php
		}
	}

	/* Custom Control: Background Color */
	class BURF_Customize_Background_Color extends WP_Customize_Control {
		public function render_content() {
			?>
			<div id="bg-toggle">
				<div id="bg-toggle-color" class="active">Color</div>
				<div id="bg-toggle-image">Image</div>
			</div>

			<div id="bg-color" class="open">
				<a class="wp-color-result" tabindex="0" title="Select Color" style="background-color: <?php echo get_option( 'burf_setting_background_color' ); ?>"></a>
				<input <?php $this->link(); ?> id="bg_color" name="bg_color" type="text" class='color-picker-open' value="<?php echo get_option( 'burf_setting_background_color' ); ?>" />
			</div>
			<?php
		}
	}

	/* Custom Control: Textarea */
	class Example_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() {
			?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
		}
	}

	/* Section: Layout Options  */
	$wp_customize->add_section( 'burf_section_layout', array(
			'title' => __( 'Layout Options', 'burf' ),
			//'priority' => 120,
		) );

	/* Setting: Layout */
	$wp_customize->add_setting( 'burf_setting_layout', array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

	/* Control: Layout Select*/
	$wp_customize->add_control( new BURF_Customize_Radio( $wp_customize, 'burf_section_layout', array(
				'section'        => 'burf_section_layout',
				'settings'       => 'burf_setting_layout',
				'type'           => 'radio',
				'choices' => array(
					'l-branding' => 'Site Branding Top',
					'l-navbar'   => 'Navigation Bar Top',
					'l-sidenav'  => 'Side Navigation',
					'l-nonav'    => 'No Navigation',
				)
			) ) );

	/* Section: Font Options  */
	$wp_customize->add_section( 'burf_section_fonts', array(
			'title'    => __( 'Font Options', 'burf' ),
			//'priority' => 120,
		) );

	/* Setting: Fonts */
	$wp_customize->add_setting( 'burf_setting_fonts', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'option',
		) );

	/* Control: Fonts Select*/
	$wp_customize->add_control( new BURF_Customize_Radio( $wp_customize, 'burf_section_fonts', array(
				'label'    => 'Font Picker Setting',
				'section'  => 'burf_section_fonts',
				'settings' => 'burf_setting_fonts',
				'type'     => 'radio',
				'choices' => array(
					'f1'   => 'Capita,Benton',
					'f2'   => 'Benton,Benton',
					'f3'   => 'Benton,Capita',
					'f4'   => 'Pressura,Benton',
					'f5'   => 'Stag,Benton',
				)
			) ) );

	/* Section: Color Options  */
	$wp_customize->add_section( 'burf_section_colors', array(
			'title'    => __( 'Text Color Options', 'burf' ),
			//'priority' => 120,
		) );

	/* Setting: Colors */
	$wp_customize->add_setting( 'burf_setting_colors', array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

	/* Control: Colors Select */
	$wp_customize->add_control( new BURF_Customize_Colors( $wp_customize, 'burf_section_colors', array(
				'label'       => 'Color Picker Setting',
				'section'     => 'burf_section_colors',
				'settings'    => 'burf_setting_colors',
				'type'        => 'radio',
				'choices' => array(
					'option1' => '#000000,#606060,#cc0000,#4a97a7',
					'option2' => '#000000,#414141,#0095e2,#f59a23',
					'option3' => '#4699d3,#000000,#e98900,#4699d3',
					'option4' => '#a6330a,#261514,#f77300,#aaaaaa',
					'option5' => '#cc0000,#685f5f,#cc0000,#685f5f',
					'option6' => '#ffffff,#909090,#0095e2,#f59a23',
				)
			) ) );

	/* Section: Background Options  */
	$wp_customize->add_section( 'burf_section_background', array(
			'title'    => __( 'Background Options', 'burf' ),
			//'priority' => 120,
		) );

	/* Setting: Background Color */
	$wp_customize->add_setting( 'burf_setting_background_color', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'option',
		) );

	/* Control: Colors Select */
	$wp_customize->add_control( new BURF_Customize_Background_Color( $wp_customize, 'burf_section_background_colors', array(
				'label'    => 'Background Setting',
				'section'  => 'burf_section_background',
				'settings' => 'burf_setting_background_color',
				'type'     => 'radio',
			) ) );

	/* Setting: Background Image */
	$wp_customize->add_setting( 'burf_setting_background_image', array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

	/* Control: Background Image Upload */
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'background', array(
				'label'      => __( 'Upload an image', 'burf' ),
				'section'    => 'burf_section_background',
				'settings'   => 'burf_setting_background_image',
			) ) );

	/* Setting: Background Image: Repeat */
	$wp_customize->add_setting( 'burf_setting_background_repeat', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'option',
		) );

	/* Setting: Background Image: Position */
	$wp_customize->add_setting( 'burf_setting_background_position', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'option',
		) );

	/* Setting: Background Image: Attachment */
	$wp_customize->add_setting( 'burf_setting_background_attachment', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'option',
		) );

	/* Control: Background Image Option: Repeat */
	$wp_customize->add_control(
		new BURF_Customize_Radio( $wp_customize, 'burf_background_repeat', array(
				'label'         => __( 'Background Repeat', 'burf' ),
				'section'       => 'burf_section_background',
				'settings'      => 'burf_setting_background_repeat',
				'choices' => array(
					'no-repeat' => 'None',
					'repeat'    => 'Tile',
					'repeat-x'  => 'Repeat Horizonally',
					'repeat-y'  => 'Repeat Vertically',
				) ) )
		);

	/* Control: Background Image Option: Position */
	$wp_customize->add_control(
		new BURF_Customize_Radio( $wp_customize, 'burf_background_position', array(
				'label'      => __( 'Background Position', 'burf' ),
				'section'    => 'burf_section_background',
				'settings'   => 'burf_setting_background_position',
				'choices' => array(
					'left'   => 'Left',
					'right'  => 'Right',
					'center' => 'Center',
				) ) )
		);

	/* Control: Background Image Option: Attachment */
	$wp_customize->add_control(
		new BURF_Customize_Radio( $wp_customize, 'burf_background_attachment', array(
				'label'      => __( 'Background Attachment', 'burf' ),
				'section'    => 'burf_section_background',
				'settings'   => 'burf_setting_background_attachment',
				'choices' => array(
					'fixed'  => 'Fixed',
					'scroll' => 'Scroll',
				) ) )
	);

	/* Section: Footer Options  */
	$wp_customize->add_section( 'burf_section_footer', array(
			'title' => __( 'Footer Options', 'burf' ),
			//'priority' => 120,
		) );

	/* Setting: Footer Contact Info */
	$wp_customize->add_setting( 'burf_setting_footer_contact', array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

	/* Control: Footer Contact Info  */
	$wp_customize->add_control( new Example_Customize_Textarea_Control( $wp_customize, 'burf_section_footer', array(
				'label'    => 'Contact Information',
				'section'  => 'burf_section_footer',
				'settings' => 'burf_setting_footer_contact',
				'type'     => 'textarea',
				'priority' => 1,
			) ) );

	/* Settings: Footer Contact Social Links */
	$wp_customize->add_setting( 'burf_setting_footer_social_fb', array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );
	$wp_customize->add_setting( 'burf_setting_footer_social_tw', array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );
	$wp_customize->add_setting( 'burf_setting_footer_social_ig', array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );
	$wp_customize->add_setting( 'burf_setting_footer_social_yt', array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );
	$wp_customize->add_setting( 'burf_setting_footer_social_li', array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

	/* Controls: Footer Social Links */
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'burf_section_footer_social_links_fb', array(
				'label'    => 'Facebook Link',
				'section'  => 'burf_section_footer',
				'settings' => 'burf_setting_footer_social_fb',
				'type'     => 'text',
			) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'burf_section_footer_social_links_tw', array(
				'label'    => 'Twitter Link',
				'section'  => 'burf_section_footer',
				'settings' => 'burf_setting_footer_social_tw',
				'type'     => 'text',
			) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'burf_section_footer_social_links_ig', array(
				'label'    => 'Instagram Link',
				'section'  => 'burf_section_footer',
				'settings' => 'burf_setting_footer_social_ig',
				'type'     => 'text',
			) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'burf_section_footer_social_links_yt', array(
				'label'    => 'YouTube Link',
				'section'  => 'burf_section_footer',
				'settings' => 'burf_setting_footer_social_yt',
				'type'     => 'text',
			) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'burf_section_footer_social_links_li', array(
				'label'    => 'LinkedIn Link',
				'section'  => 'burf_section_footer',
				'settings' => 'burf_setting_footer_social_li',
				'type'     => 'text',
			) ) );

}

add_action( 'customize_register', 'burf_customize_register' );

function burf_customize_css() {
	$colors = explode( ',', get_option( 'burf_setting_colors' ) );
	$bg_color = get_option( 'burf_setting_background_color' );
	$bg_image = get_option( 'burf_setting_background_image' );
	$bg_repeat = get_option( 'burf_setting_background_repeat' );
	$bg_position = get_option( 'burf_setting_background_position' );
	$bg_attachment = get_option( 'burf_setting_background_attachment' );
	?>
	<style type="text/css">
		 /* heading colors */
		 h1,h2,h3,h4,h5,h6,
		 #right-content-area h1,
		 #right-content-area h1 a {
			color: <?php echo $colors[0]; ?>
		 }

		 /* accent text colors */
		 strong,
		 #right-content-area h3,
		 #right-content-area h3 a,
		 #right-content-area a .day,
		 #bottom-content-area h3,
		 #bottom-content-area h3 a,
		 ul > li:before,
		 ol > li:before { color: <?php echo $colors[3]; ?> }

		 .default .date { background-color: <?php echo $colors[3]; ?> }

		 /* general text colors */
		 body, p, li,
		 #right-content-area a,
		 #bottom-content-area a { color: <?php echo $colors[1]; ?> }

		 /* anchor colors */
		 a, .comment-counter a strong { color: <?php echo $colors[2]; ?> }

		 /* page background color */
		 #page_wrapper {
			background-color: <?php echo $bg_color; ?>;
			background-image: url(<?php echo $bg_image; ?>);
			background-repeat: <?php echo $bg_repeat; ?>;
			background-position: top <?php echo $bg_position; ?>;
			background-attachment: <?php echo $bg_attachment; ?>;
		 }
	</style>
	<?php
}

add_action( 'wp_head', 'burf_customize_css' );
