<?php
/**
 * Class-rcps-customizer-checkbox-multiple.php
 *
 * @link http://justintadlock.com/archives/2015/05/26/multiple-checkbox-customizer-control
 *
 * @package Recipes WordPress Theme
 */

/**
 * Multiple checkbox customize control class.
 */
class Rcps_Customizer_Checkbox_Multiple extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'checkbox-multiple';

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'rcps-customize-controls', trailingslashit( get_template_directory_uri() ) . 'js/customize-controls.js', array( 'jquery' ), RCPS_THEME_VERSION, false );
	}

	/**
	 * Displays the control content.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}
		?>

		<?php if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>

		<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>

		<?php $multi_values = ! is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

		<ul>
			<?php foreach ( $this->choices as $value => $label ) : ?>

				<li>
					<label>
						<input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values, true ) ); ?> class="rcps-multiple-input-checkbox" />
						<?php echo esc_html( $label ); ?>
					</label>
				</li>

			<?php endforeach; ?>
		</ul>

		<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
		<?php
	}
}
