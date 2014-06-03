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
		$Order_Information_String = get_option("EWD_OTP_Order_Information");
		$Order_Information = explode(",", $Order_Information_String);
		
		$ReturnString = "";
		
		// Get the attributes passed by the shortcode, and store them in new variables for processing
		extract( shortcode_atts( array(
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
			  $Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s'", $_POST['Tracking_Number']));
				$Statuses = $wpdb->get_results($wpdb->prepare("SELECT Order_Status, Order_Status_Created FROM $EWD_OTP_order_statuses_table_name WHERE Order_ID='%s' ORDER BY Order_Status_Created ASC", $Order->Order_ID));
				
				if ($wpdb->num_rows == 0) {
					  $user_message .= __("There are no order statuses for tracking number: ", 'EWD_OTP') . $_POST['Tracking_Number'] . ".<br />";
				}
				else {
						$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
						$ReturnString .= "<div class='pure-u-1'><h3>" . __("Order Information", 'EWD_OTP') . "</h3></div>";
						if (in_array("Order_Number", $Order_Information)) {
							  $ReturnString .= "<div id='ewd-otp-order-number-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
								$ReturnString .= __("Order Number", 'EWD_OTP') . ":";
								$ReturnString .= "</div>";
							  $ReturnString .= "<div id='ewd-otp-order-number' class='ewd-otp-order-content pure-u-7-8'>";
								$ReturnString .= $Order->Order_Number;
								$ReturnString .= "</div>";
						}
						if (in_array("Order_Name", $Order_Information)) {
							  $ReturnString .= "<div id='ewd-otp-order-name-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
								$ReturnString .= __("Order Name", 'EWD_OTP') . ":";
								$ReturnString .= "</div>";
								$ReturnString .= "<div id='ewd-otp-order-name' class='ewd-otp-order-content pure-u-7-8'>";
								$ReturnString .= $Order->Order_Name;
								$ReturnString .= "</div>";
						}
						if (in_array("Order_Notes", $Order_Information)) {
							  $ReturnString .= "<div id='ewd-otp-order-notes-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
								$ReturnString .= __("Order Notes", 'EWD_OTP') . ":";
								$ReturnString .= "</div>";
								$ReturnString .= "<div id='ewd-otp-order-notes' class='ewd-otp-order-content pure-u-7-8'>";
								$ReturnString .= $Order->Order_Notes_Public;
								$ReturnString .= "</div>";
						}
						if (in_array("Order_Status", $Order_Information)) {
							  $ReturnString .= "<div id='ewd-otp-status-header' class='ewd-otp-status-message pure-u-1-5 mt-12 mb-6 ewd-otp-bold'>";
								$ReturnString .= __("Status", 'EWD_OTP');
								$ReturnString .= "</div>";
						}
						if (in_array("Order_Updated", $Order_Information)) {
							  $ReturnString .= "<div id='ewd-otp-date-header' class='ewd-otp-status-time pure-u-1-5 mt-12 mb-6 ewd-otp-bold'>";
								$ReturnString .= __("Date/Time", 'EWD_OTP');
								$ReturnString .= "</div>";
						}
						if (in_array("Order_Status", $Order_Information) and in_array("Order_Updated", $Order_Information)) {$ReturnString .= "<div class='pure-u-3-5'></div>";}
						elseif (in_array("Order_Status", $Order_Information) or in_array("Order_Updated", $Order_Information)) {$ReturnString .= "<div class='pure-u-4-5'></div>";}
						else {$ReturnString .= "<div class='pure-u-1'></div>";}
						if (in_array("Order_Status", $Order_Information) or in_array("Order_Updated", $Order_Information)) {
							  foreach ($Statuses as $Status) {
										if (in_array("Order_Status", $Order_Information)) {
									  	  $ReturnString .= "<div class='ewd-otp-status-message pure-u-1-5'>";
												$ReturnString .= $Status->Order_Status;
												$ReturnString .= "</div>";
										}
										if (in_array("Order_Updated", $Order_Information)) {
									  	  $ReturnString .= "<div class='ewd-otp-status-time pure-u-1-5'>";
												$ReturnString .= $Status->Order_Status_Created;
												$ReturnString .= "</div>";
										}
										if (in_array("Order_Status", $Order_Information) and in_array("Order_Updated", $Order_Information)) {$ReturnString .= "<div class='pure-u-3-5'></div>";}
										else {$ReturnString .= "<div class='pure-u-4-5'></div>";}
								}
						}
						$ReturnString .= "</div>";
				}
		}
		
		//Put in the tracking form
		$ReturnString .= "<div id='ewd-otp-tracking-form-div' class='mt-12'>";
		$ReturnString .= "<h3>" . __("Track an Order", 'EWD_OTP') . "</h3>";
		$ReturnString .= "<div class='ewd-otp-message mb-6'>";
		$ReturnString .= $user_message;
		$ReturnString .= __("Enter the order number you would like to track in the form below.", 'EWD_OTP');
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
