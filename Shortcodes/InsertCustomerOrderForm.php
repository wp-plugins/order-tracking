<?php
/* The function that creates the HTML on the front-end, based on the parameters
* supplied in the customer-order shortcode */
function Insert_Customer_Order_Form($atts) {
	global $user_message;
	global $wpdb;
	global $EWD_OTP_fields_table_name;
		
	$Custom_CSS = get_option('EWD_OTP_Custom_CSS');
	$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");
	
	$ReturnString = "";
		
	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
		 		'order_status' => '',
		 		'order_location' => '',
		 		'success_message' => __('Thank you. Your order number is: "', 'EWD_OTP'),
		 		'customer_form_title' => __('Create an Order', 'EWD_OTP'),
				'customer_name_field_text' => __('Order Name', 'EWD_OTP'),
				'customer_email_field_text' => __('Order E-mail Address', 'EWD_OTP'),
				'customer_notes_field_text' => __('Customer Notes', 'EWD_OTP'),
				'customer_instructions' => __('Please fill out the form below to create an order.', 'EWD_OTP'),
				'submit_text' => __('Send Order', 'EWD_OTP')),
		$atts
		)
	);
		
	if (isset($_POST['Customer_Order_Submit'])) {$user_update = EWD_OTP_Save_Customer_Order($success_message, $order_status, $order_location);}

	$ReturnString .= "<style type='text/css'>";
	$ReturnString .= $Custom_CSS;
	$ReturnString .= "</style>";

	$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";

	if (isset($_POST['Customer_Order_Submit'])) {
		$ReturnString .= "<div class='ewd-otp-user-update ewd-otp-bold pure-u-1'>";
		$ReturnString .= $user_update['Message'];
		$ReturnString .= "</div>";
	}

	$ReturnString .= "<form id='customer_order' method='post' action='#'>";
	$ReturnString .= wp_nonce_field();
	$ReturnString .= wp_referer_field();

	$ReturnString .= "<div class='form-field'>";
	$ReturnString .= "<div id='ewd-otp-customer-order-name-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-5'>";
	$ReturnString .= $customer_name_field_text . ": ";
	$ReturnString .= "</div>";
	$ReturnString .= "<div id='ewd-otp-customer-order-email-label' class='pure-u-4-5'>";
	$ReturnString .= "<input name='Order_Name' id='Order_Name' type='text' value='' size='60' />";
	$ReturnString .= "</div>";
	$ReturnString .= "</div>";

	$ReturnString .= "<div class='form-field'>";
	$ReturnString .= "<div id='ewd-otp-customer-order-email-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-5'>";
	$ReturnString .= $customer_email_field_text . ": ";
	$ReturnString .= "</div>";
	$ReturnString .= "<div id='ewd-otp-customer-order-email-label' class='pure-u-4-5'>";
	$ReturnString .= "<input type='text' name='Order_Email_Address' id='Order_Email_Address' />";
	$ReturnString .= "</div>";
	$ReturnString .= "<div id='ewd-otp-customer-order-email-label' class='pure-u-1'>";
	$ReturnString .= "<p>" . __('The e-mail address to send order updates to, if the site administrator has selected that option.', 'EWD_OTP')  . "</p>";
	$ReturnString .= "</div>";
	$ReturnString .= "</div>";

	$ReturnString .= "<div id='ewd-otp-customer-notes-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-5'>";
	$ReturnString .= $customer_notes_field_text . ":";
	$ReturnString .= "</div>";
	$ReturnString .= "<div id='ewd-otp-order-notes' class='ewd-otp-order-content pure-u-4-5'>";
	$ReturnString .= "<textarea name='Customer_Notes'></textarea>";
	$ReturnString .= "</div>";

	$Sql = "SELECT * FROM $EWD_OTP_fields_table_name ";
	$myrows = $wpdb->get_results($Sql);
	$Value = "";
	if (is_array($Fields)) {
		foreach ($Fields as $Field) {
			if ($Field->Field_Front_End_Display == "Yes") {
				$ReturnString .= "<div class='ewd-otp-label ewd-otp-bold pure-u-1-5'><label for='" . $Field->Field_Name . "'>" . $Field->Field_Name . ":</label></div>";
				$ReturnString .= "<div id='ewd-otp-order-custom-field-" . $Field->Field_ID . "' class='ewd-otp-order-content pure-u-4-5'>";
				if ($Field->Field_Type == "text" or $Field->Field_Type == "mediumint") {
					  $ReturnString .= "<input name='" . $Field->Field_Name . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-input' type='text' value='" . $Value . "' />";
				}
				elseif ($Field->Field_Type == "textarea") {
						$ReturnString .= "<textarea name='" . $Field->Field_Name . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-textarea'>" . $Value . "</textarea>";
				} 
				elseif ($Field->Field_Type == "select") { 
						$Options = explode(",", $Field->Field_Values);
						$ReturnString .= "<select name='" . $Field->Field_Name . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-select '>";
						foreach ($Options as $Option) {
								$ReturnString .= "<option value='" . $Option . "' ";
								if (trim($Option) == trim($Value)) {$ReturnString .= "selected='selected'";}
								$ReturnString .= ">" . $Option . "</option>";
						}
						$ReturnString .= "</select>";
				} 
				elseif ($Field->Field_Type == "radio") {
						$Counter = 0;
						$Options = explode(",", $Field->Field_Values);
						foreach ($Options as $Option) {
								if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
								$ReturnString .= "<input type='radio' name='" . $Field->Field_Name . "' value='" . $Option . "' class='ewd-otp-radio' ";
								if (trim($Option) == trim($Value)) {$ReturnString .= "checked";}
								$ReturnString .= ">" . $Option;
								$Counter++;
						}
				} 
				elseif ($Field->Field_Type == "checkbox") {
		  			$Counter = 0;
						$Options = explode(",", $Field->Field_Values);
						$Values = explode(",", $Value);
						foreach ($Options as $Option) {
								if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
								$ReturnString .= "<input type='checkbox' name='" . $Field->Field_Name . "[]' value='" . $Option . "' class='ewd-otp-checkbox' ";
								if (in_array($Option, $Values)) {$ReturnString .= "checked";}
								$ReturnString .= ">" . $Option . "</br>";
								$Counter++;
						}
				}
				elseif ($Field->Field_Type == "file") {
						$ReturnString .= "<input name='" . $Field->Field_Name . "' class='ewd-otp-file-input' type='file' value='' />";
				}
				elseif ($Field->Field_Type == "date") {
						$ReturnString .= "<input name='" . $Field->Field_Name . "' class='ewd-otp-date-input' type='date' value='' />";
				} 
				elseif ($Field->Field_Type == "datetime") {
						$ReturnString .= "<input name='" . $Field->Field_Name . "' class='ewd-otp-datetime-input' type='datetime-local' value='' />";
		  		}
				$ReturnString .= " </div>";
				$ReturnString .= " </div>";
			}
		}
	}
	
	$ReturnString .= "<p class='submit'><input type='submit' name='Customer_Order_Submit' id='submit' class='button-primary' value='" . $submit_text . "'  /></p></form>";
	$ReturnString .= "</div>";

	return $ReturnString;
}
if ($EWD_OTP_Full_Version == "Yes") {add_shortcode("customer-order", "Insert_Customer_Order_Form");}

?>