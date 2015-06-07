<?php
class EWD_OTP_Tracking_Form_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'ewd_otp_tracking_form_widget', // Base ID
			__('Order Tracking Form', 'EWD_OTP'), // Name
			array( 'description' => __( 'Insert an order tracking form', 'EWD_OTP' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		/*if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo __( 'Hello, World!', 'EWD_OTP' );*/
		echo do_shortcode("[tracking-form order_form_title='". $instance['order_form_title'] . "' order_field_text='" . $instance['order_field_text'] . "' email_field_text='" . $instance['email_field_text'] . "' order_instructions='" . $instance['order_instructions'] . "' submit_text='" . $instance['submit_text'] . "']");
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$order_form_title = ! empty( $instance['order_form_title'] ) ? $instance['order_form_title'] : __( 'Form Title', 'EWD_OTP' );
		$order_field_text = ! empty( $instance['order_field_text'] ) ? $instance['order_field_text'] : __( 'Field Text', 'EWD_OTP' );
		$email_field_text = ! empty( $instance['email_field_text'] ) ? $instance['email_field_text'] : __( 'Email Text', 'EWD_OTP' );
		$order_instructions = ! empty( $instance['order_instructions'] ) ? $instance['order_instructions'] : __( 'Form Instructions', 'EWD_OTP' );
		$submit_text = ! empty( $instance['submit_text'] ) ? $instance['submit_text'] : __( 'Submit Text', 'EWD_OTP' );

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'order_form_title' ); ?>"><?php _e( 'Form Title:', 'EWD_OTP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'order_form_title' ); ?>" name="<?php echo $this->get_field_name( 'order_form_title' ); ?>" type="text" value="<?php echo esc_attr( $order_form_title ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'order_field_text' ); ?>"><?php _e( 'Field Text:', 'EWD_OTP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'order_field_text' ); ?>" name="<?php echo $this->get_field_name( 'order_field_text' ); ?>" type="text" value="<?php echo esc_attr( $order_field_text ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'email_field_text' ); ?>"><?php _e( 'Email Text:', 'EWD_OTP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'email_field_text' ); ?>" name="<?php echo $this->get_field_name( 'email_field_text' ); ?>" type="text" value="<?php echo esc_attr( $email_field_text ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'order_instructions' ); ?>"><?php _e( 'Form Instructions:', 'EWD_OTP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'order_instructions' ); ?>" name="<?php echo $this->get_field_name( 'order_instructions' ); ?>" type="text" value="<?php echo esc_attr( $order_instructions ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'submit_text' ); ?>"><?php _e( 'Submit Text:', 'EWD_OTP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'submit_text' ); ?>" name="<?php echo $this->get_field_name( 'submit_text' ); ?>" type="text" value="<?php echo esc_attr( $submit_text ); ?>">
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['order_form_title'] = ( ! empty( $new_instance['order_form_title'] ) ) ? strip_tags( $new_instance['order_form_title'] ) : '';
		$instance['order_field_text'] = ( ! empty( $new_instance['order_field_text'] ) ) ? strip_tags( $new_instance['order_field_text'] ) : '';
		$instance['email_field_text'] = ( ! empty( $new_instance['email_field_text'] ) ) ? strip_tags( $new_instance['email_field_text'] ) : '';
		$instance['order_instructions'] = ( ! empty( $new_instance['order_instructions'] ) ) ? strip_tags( $new_instance['order_instructions'] ) : '';
		$instance['submit_text'] = ( ! empty( $new_instance['submit_text'] ) ) ? strip_tags( $new_instance['submit_text'] ) : '';

		return $instance;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("EWD_OTP_Tracking_Form_Widget");'));

?>