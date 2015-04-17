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
	$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");
	
	$ReturnString = "";
		
	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
		 		'order_form_title' => __('Track an Order', 'EWD_OTP'),
				'order_field_text' => __('Order Number', 'EWD_OTP'),
				'email_field_text' => __('Order E-mail Address', 'EWD_OTP'),
				'email_field_shortcode' => '',
				'email_field_shortcode_attribute' => '',
				'email_field_attribute_value' => '',
				'order_instructions' => __('Enter the order number you would like to track in the form below.', 'EWD_OTP'),
				'field_names' => '',
				'submit_text' => __('Track', 'EWD_OTP'),
				'notes_submit' => __('Add Note', 'EWD_OTP')),
		$atts
		)
	);
		
	if (isset($_POST['Notes_Submit'])) {EWD_OTP_Save_Customer_Note();}
	
	if ($order_instructions != "Enter the order number you would like to track in the form below." or $Order_Instructions == "") {$Order_Instructions = $order_instructions;}
		
	$ReturnString .= "<style type='text/css'>";
	$ReturnString .= $Custom_CSS;
	$ReturnString .= "</style>";
		
	$Fields = array();
	$Field_Names_Array = explode(",", $field_names);
	foreach ($Field_Names_Array as $Field_Name) {
		$Field_Name_Key = trim(substr($Field_Name, 0, strpos($Field_Name, "=")));
		$Field_Name_Value = trim(substr($Field_Name, strpos($Field_Name, "=")+5));
		$Fields[$Field_Name_Key] = $Field_Name_Value;
	}
		
	//If there's a tracking number that's already been submitted, display the results
	if (isset($_REQUEST['Tracking_Number'])) {
		$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
		$ReturnString .= "<div class='pure-u-1'><h3>" . __("Order Information", 'EWD_OTP') . "</h3></div>";
		$ReturnString .= EWD_OTP_Return_Results($_REQUEST['Tracking_Number'], $Fields, $_REQUEST['Order_Email'], $notes_submit);
		$ReturnString .= "</div>";
	}
		
	if ($AJAX_Reload == "Yes") {
		$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
		$ReturnString .= "<div class='pure-u-1'><h3>" . __("Order Information", 'EWD_OTP') . "</h3></div>";
		$ReturnString .= "<div class='ewd-otp-ajax-results'></div>";
		$ReturnString .= "</div>";
	}
		
	//Put in the tracking form
	$ReturnString .= "<div id='ewd-otp-tracking-form-div' class='mt-12'>";
	$ReturnString .= "<h3>" . $order_form_title . "</h3>";
	$ReturnString .= "<div class='ewd-otp-message mb-6'>";
	$ReturnString .= $user_message;
	$ReturnString .= $Order_Instructions;
	$ReturnString .= "</div>";
	if ($New_Window == "Yes") {$ReturnString .= "<form action='#' method='post' target='_blank' id='ewd-otp-tracking-form' class='pure-form pure-form-aligned'>";}
	else {$ReturnString .= "<form action='#' method='post' id='ewd-otp-tracking-form' class='pure-form pure-form-aligned'>";}
	$ReturnString .= "<input type='hidden' name='ewd-otp-action' value='track' />";
	$ReturnString .= "<input type='hidden' id='ewd-otp-field-labels' name='field-labels' value='" . $field_names . "' />";
	$ReturnString .= "<div class='pure-control-group'>";
	$ReturnString .= "<label for='Order_Number' id='ewd-otp-order-number-div' class='ewd-otp-field-label ewd-otp-bold'>" . $order_field_text . ": </label>";
	$ReturnString .= "<input type='text' class='ewd-otp-text-input' id='ewd-otp-tracking-number' name='Tracking_Number' placeholder='" . $order_field_text . "...'>";
	$ReturnString .= "</div>";
	if ($Email_Confirmation == "Order_Email") {
		$ReturnString .= "<div class='pure-control-group'>";
		$ReturnString .= "<label for='Order_Email' id='ewd-otp-order-number-div' class='ewd-otp-field-label ewd-otp-bold'>" . $email_field_text . ": </label>";
		$ReturnString .= "<input type='email' class='ewd-otp-text-input' id='ewd-otp-email' name='Order_Email' placeholder='" . $email_field_text . "...'>";
		$ReturnString .= "</div>";
	}
	if ($Email_Confirmation == "Auto_Entered") {
		$ReturnString .= "<input type='hidden' class='ewd-otp-text-input' id='ewd-otp-email' name='Order_Email' value='[" . $email_field_shortcode . " " . $email_field_shortcode_attribute . "=" . $email_field_attribute_value . "]'>";
	}
	$ReturnString .= "<div class='pure-control-group'>";
	$ReturnString .= "<label for='Submit'></label><input type='submit' class='ewd-otp-submit pure-button pure-button-primary' name='Login_Submit' value='" . $submit_text . "'>";
	$ReturnString .= "</div>";
	$ReturnString .= "</form>";
	$ReturnString .= "</div>";
		
	return $ReturnString;
}
add_shortcode("tracking-form", "Insert_Tracking_Form");
