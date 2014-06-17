<?php
function EWD_OTP_Return_Results($TrackingNumber) {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$Order_Information_String = get_option("EWD_OTP_Order_Information");
		$Order_Information = explode(",", $Order_Information_String);
		
		$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s'", $TrackingNumber));
		$Statuses = $wpdb->get_results($wpdb->prepare("SELECT Order_Status, Order_Status_Created FROM $EWD_OTP_order_statuses_table_name WHERE Order_ID='%s' ORDER BY Order_Status_Created ASC", $Order->Order_ID));
		
		if ($wpdb->num_rows == 0) {
				$user_message .= __("There are no order statuses for tracking number: ", 'EWD_OTP') . $TrackingNumber . ".<br />";
		}
		else {					
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
		}
		return $ReturnString;
}

?>