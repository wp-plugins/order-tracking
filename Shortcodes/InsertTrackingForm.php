<?php 
/* The function that creates the HTML on the front-end, based on the parameters
* supplied in the product-catalog shortcode */
function Insert_Tracking_Form($atts) {
		global $user_message;
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$Custom_CSS = get_option('EWD_OTP_Custom_CSS');
		$New_Window = get_option("EWD_OTP_New_Window");
		$AJAX_Reload = get_option("EWD_OTP_AJAX_Reload");
		$Order_Instructions = get_option("EWD_OTP_Form_Instructions");
		
		$ReturnString = "";
		
		// Get the attributes passed by the shortcode, and store them in new variables for processing
		extract( shortcode_atts( array(
						 								 		'order_form_title' => __('Track an Order', 'EWD_OTP'),
																'order_field_text' => __('Order Number', 'EWD_OTP'),
																'submit_text' => __('Track', 'EWD_OTP')),
																$atts
														)
												);
		
		$ReturnString .= "<style type='text/css'>";
		$ReturnString .= $Custom_CSS;
		$ReturnString .= "</style>";
		
		//If there's a tracking number that's already been submitted, display the results
		if (isset($_POST['Tracking_Number'])) {
			  $ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
				$ReturnString .= "<div class='pure-u-1'><h3>" . __("Order Information", 'EWD_OTP') . "</h3></div>";
				$ReturnString .= EWD_OTP_Return_Results($_POST['Tracking_Number']);
				$ReturnString .= "</div>";
		}
		
		if ($AJAX_Reload == "Yes") {
			  $ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
				$ReturnString .= "<div class='pure-u-1'><h3>" . __("Order Information", 'EWD_OTP') . "</h3></div>";
				$ReturnString .= "<div class='ewd-otp-ajax-results'></div>";
				$ReturnString .= "</div>";
		}
		echo "Instructions: " . $order_instructions . "<br>";
		//Put in the tracking form
		$ReturnString .= "<div id='ewd-otp-tracking-form-div' class='mt-12'>";
		$ReturnString .= "<h3>" . $order_form_title . "</h3>";
		$ReturnString .= "<div class='ewd-otp-message mb-6'>";
		$ReturnString .= $user_message;
		$ReturnString .= $Order_Instructions;
		$ReturnString .= "</div>";
		if ($New_Window == "Yes") {$ReturnString .= "<form action='#' method='post' target='_blank' id='ewd-otp-tracking-form' class='pure-form pure-form-aligned'>";}
		else {$ReturnString .= "<form action='#' method='post' id='ewd-otp-tracking-form' class='pure-form pure-form-aligned'>";}
		$ReturnString .= "<input type='hidden' name='ewd-otp-action' value='track'>";
		$ReturnString .= "<div class='pure-control-group'>";
		$ReturnString .= "<label for='Order_Number' id='ewd-otp-order-number-div' class='ewd-otp-field-label ewd-otp-bold'>" . $order_field_text . ": </label>";
		$ReturnString .= "<input type='text' class='ewd-otp-text-input' name='Tracking_Number' placeholder='" . $order_field_text . "...'>";
		$ReturnString .= "</div>";
		$ReturnString .= "<div class='pure-control-group'>";
		$ReturnString .= "<label for='Submit'></label><input type='submit' class='ewd-otp-submit pure-button pure-button-primary' name='Login_Submit' value='" . $submit_text . "'>";
		$ReturnString .= "</div>";
		$ReturnString .= "</form>";
		$ReturnString .= "</div>";
		
		return $ReturnString;
}
add_shortcode("tracking-form", "Insert_Tracking_Form");
