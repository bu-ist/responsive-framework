<?php
/**
 * Custom classes for use with the Theme Customizer.
 */

if ( class_exists( 'WP_Customize_Control' ) ) :

/**
 * Section heading control.
 */
class BURF_Section_Heading extends WP_Customize_Control {
	public $type = 'heading';
	public $label = '';

	public function render_content() {
		?>
		<h4 class="customize-control-title"><?php echo esc_html( $this->label ); ?></h4>
		<?php
	}
}

/**
 * Radio button control.
 */
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

/**
 * Color selection control.
 */
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

/**
 * Background color control.
 */
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

/**
 * Text area control.
 */
class BURF_Customize_Textarea extends WP_Customize_Control {
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

endif;
