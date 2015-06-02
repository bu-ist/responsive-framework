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

endif;
