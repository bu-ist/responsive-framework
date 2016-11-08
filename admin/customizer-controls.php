<?php
/**
 * Custom classes for use with the Theme Customizer.
 */

if ( class_exists( 'WP_Customize_Control' ) ) :

/**
 * Multiple checkbox group control.
 *
 * @see http://justintadlock.com/archives/2015/05/26/multiple-checkbox-customizer-control
 */
class BURF_Customize_Checkbox_Group extends WP_Customize_Control {

	public $type = 'burf-checkbox-group';

	/**
	 * Displays the control content.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function render_content() {

		if ( empty( $this->choices ) )
			return; ?>

		<?php if ( !empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>

		<?php if ( !empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
		<?php endif; ?>

		<?php $multi_values = ! is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

		<ul>
			<?php foreach ( $this->choices as $value => $label ) : ?>
				<li>
					<label>
						<input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> />
						<?php echo esc_html( $label ); ?>
					</label>
				</li>
			<?php endforeach; ?>
		</ul>

		<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
	<?php }
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
