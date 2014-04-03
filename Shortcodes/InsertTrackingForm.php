<?php 
/* The function that creates the HTML on the front-end, based on the parameters
* supplied in the product-catalog shortcode */
function Insert_Tracking_Form($atts) {
		global $user_message;
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$ReturnString = "";
		
		// Get the attributes passed by the shortcode, and store them in new variables for processing
		extract( shortcode_atts( array(
						 								 		'order_field_text' => __('Order Number', 'EWD_OTP'),
																'submit_text' => __('Track', 'EWD_OTP')),
																$atts
														)
												);
		
		//If there's a tracking number that's already been submitted, display the results
		if (isset($_POST['Tracking_Number'])) {
			  $ID = $wpdb->get_var($wpdb->prepare("SELECT Order_ID FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s'", $_POST['Tracking_Number']));
				$Statuses = $wpdb->get_results($wpdb->prepare("SELECT Order_Status, Order_Status_Created FROM $EWD_OTP_order_statuses_table_name WHERE Order_ID='%s' ORDER BY Order_Status_Created ASC", $ID));
				
				if ($wpdb->num_rows == 0) {
					  $user_message .= __("There are no order statuses for tracking number: ", 'EWD_OTP') . $_POST['Tracking_Number'] . ".<br />";
				}
				else {
						$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
						$ReturnString .= "<div class='ewd-otp-status-message pure-u-1-5 mb-6 ewd-otp-bold'>";
						$ReturnString .= __("Status", 'EWD_OTP');
						$ReturnString .= "</div>";
						$ReturnString .= "<div class='ewd-otp-status-time pure-u-1-5 mb-6 ewd-otp-bold'>";
						$ReturnString .= __("Date/Time", 'EWD_OTP');
						$ReturnString .= "</div>";
						$ReturnString .= "<div class='pure-u-3-5'></div>";
						foreach ($Statuses as $Status) {
								$ReturnString .= "<div class='ewd-otp-status-message pure-u-1-5'>";
								$ReturnString .= $Status->Order_Status;
								$ReturnString .= "</div>";
								$ReturnString .= "<div class='ewd-otp-status-time pure-u-1-5'>";
								$ReturnString .= $Status->Order_Status_Created;
								$ReturnString .= "</div>";
								$ReturnString .= "<div class='pure-u-3-5'></div>";
						}
						$ReturnString .= "</div>";
				}
		}
		
		//Put in the tracking form
		$ReturnString .= "<div id='ewd-otp-tracking-form-div'>";
		$ReturnString .= "<div class='ewd-otp-message mb-6'>";
		$ReturnString .= $user_message;
		$ReturnString .= __("Enter the order number you would like to track in the form below.", 'EWD_OTP');
		$ReturnString .= "</div>";
		$ReturnString .= "<form action='#' method='post' id='ewd-otp-tracking-form' class='pure-form pure-form-aligned'>";
		$ReturnString .= "<input type='hidden' name='ewd-otp-action' value='track'>";
		$ReturnString .= "<div class='pure-control-group'>";
		$ReturnString .= "<label for='Username' id='ewd-otp-login-username-div' class='ewd-otp-field-label'>" . $order_field_text . ": </label>";
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
