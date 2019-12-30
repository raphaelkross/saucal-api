<?php
/**
 * Widget
 *
 * @package SauCalAPI
 */

namespace SauCalAPI\Widget;

/**
 * Adds SAUCAL API Widget
 */
class SauCalAPI_Widget extends \WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(
			'saucalapi_widget',
			esc_html__( 'SAU/CAL API', 'saucal-api' ),
			array( 'description' => esc_html__( 'SAU/CAL API Widget', 'saucal-api' ) )
		);
	}

	/**
	 * Display widget output.
	 *
	 * @param array     $args The arguments.
	 * @param WP_Widget $instance The instance.
	 */
	public function widget( $args, $instance ) {
		$allowed_tags = [
			'div' => [
				'id'    => [],
				'class' => [],
			],
		];

		echo wp_kses( $args['before_widget'], $allowed_tags );
		?>

		<div class="saucal-user-settings"><div class="loader"><?php esc_html_e( 'Loading Settings...', 'saucal-api' ); ?></div></div>

		<?php
		echo wp_kses( $args['after_widget'], $allowed_tags );
	}

	/**
	 * The Form at Dashboard.
	 *
	 * @param WP_Widget $instance The instance.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'SAU/CAL API Widget', 'saucal-api' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'saucal-api' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * Update data method.
	 *
	 * @param WP_Widget $new_instance The new instance.
	 * @param WP_Widget $old_instance The old instance.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = [];

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				default:
					$instance[ $widget_field['id'] ] = ( ! empty( $new_instance[ $widget_field['id'] ] ) ) ? wp_strip_all_tags( $new_instance[ $widget_field['id'] ] ) : '';
			}
		}
		return $instance;
	}
}

/**
 * Register the widget.
 */
function register_widget() {
	\register_widget( __NAMESPACE__ . '\SauCalAPI_Widget' );
}
add_action( 'widgets_init', __NAMESPACE__ . '\register_widget' );
