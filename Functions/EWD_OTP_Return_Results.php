<?php
function EWD_OTP_Return_Results($TrackingNumber, $Fields = array(), $Email = '') {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name;
		
		$Order_Information_String = get_option("EWD_OTP_Order_Information");
		$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");
		$Order_Information = explode(",", $Order_Information_String);
		
		if ($Email_Confirmation == "Auto_Entered") {$Email = do_shortcode($Email);}
		
		if ($Email_Confirmation == "Order_Email" or $Email_Confirmation == "Auto_Entered") {$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s' and Order_Email='%s'", $TrackingNumber, $Email));}
		else {$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s'", $TrackingNumber));}
		if (isset($Order->Order_ID)) {$Statuses = $wpdb->get_results($wpdb->prepare("SELECT Order_Status, Order_Status_Created FROM $EWD_OTP_order_statuses_table_name WHERE Order_ID='%s' ORDER BY Order_Status_Created ASC", $Order->Order_ID));}

		if ($wpdb->num_rows == 0) {
				$ReturnString .= "<div class='pure-u-1'>";
				if ($Email_Confirmation == "Order_Email") {$ReturnString .= __("There are no order statuses for tracking number: ", 'EWD_OTP') . $TrackingNumber . " and e-mail: " . $Email . ".<br />";}
				else {$ReturnString .= __("There are no order statuses for tracking number: ", 'EWD_OTP') . $TrackingNumber . ".<br />";}
				$ReturnString .= "</div>";
		}
		else {					
				if (in_array("Order_Graphic", $Order_Information)) {
						$ReturnString .= "<div class='ewd-otp-status-graphic pure-u-1'>";
						$ReturnString .= "<img src='" . plugins_url() . "/order-tracking/Functions/DisplayGraph.php?OrderNumber=" . $TrackingNumber . "' alt='OTP-Graph' id='ewd-otp-graph /'>";
						$ReturnString .= "</div>";
						$ReturnString .= "<div class='ewd-otp-clear'></div>";
				}
				if (in_array("Order_Number", $Order_Information)) {
						if (in_array("Order Number", $Fields)) {$Number_Label = $Fields['Order Number'];}
						else {$Number_Label = __("Order Number", 'EWD_OTP');}
						$ReturnString .= "<div id='ewd-otp-order-number-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
						$ReturnString .= $Number_Label . ":";
						$ReturnString .= "</div>";
						$ReturnString .= "<div id='ewd-otp-order-number' class='ewd-otp-order-content pure-u-7-8'>";
						$ReturnString .= $Order->Order_Number;
						$ReturnString .= "</div>";
				}
				if (in_array("Order_Name", $Order_Information)) {
					  if (in_array("Order Name", $Fields)) {$Name_Label = $Fields['Order Name'];}
						else {$Name_Label = __("Order Name", 'EWD_OTP');}
						$ReturnString .= "<div id='ewd-otp-order-name-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
						$ReturnString .= $Name_Label . ":";
						$ReturnString .= "</div>";
						$ReturnString .= "<div id='ewd-otp-order-name' class='ewd-otp-order-content pure-u-7-8'>";
						$ReturnString .= $Order->Order_Name;
						$ReturnString .= "</div>";
				}
				if (in_array("Order_Notes", $Order_Information)) {
					  if (in_array("Order Notes", $Fields)) {$Notes_Label = $Fields['Order Notes'];}
						else {$Notes_Label = __("Order Notes", 'EWD_OTP');}
						$ReturnString .= "<div id='ewd-otp-order-notes-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
						$ReturnString .= $Notes_Label . ":";
						$ReturnString .= "</div>";
						$ReturnString .= "<div id='ewd-otp-order-notes' class='ewd-otp-order-content pure-u-7-8'>";
						$ReturnString .= $Order->Order_Notes_Public;
						$ReturnString .= "</div>";
				}
				$Sql = "SELECT * FROM $EWD_OTP_fields_table_name";
				$Custom_Fields = $wpdb->get_results($Sql);
				foreach ($Custom_Fields as $Custom_Field) {
				 		if (in_array($Custom_Field->Field_ID, $Order_Information)) {
							  $MetaValue = $wpdb->get_results($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order->Order_ID, $Custom_Field->Field_ID));
								if (in_array($Custom_Field->Field_Name, $Fields)) {$Status_Label = $Fields[$Custom_Field->Field_Name];}
								else {$Status_Label = $Custom_Field->Field_Name;}
								$ReturnString .= "<div id='ewd-otp-order-" . $Custom_Field->Field_ID . "-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
								$ReturnString .= $Name_Label . ":";
								$ReturnString .= "</div>";
								$ReturnString .= "<div id='ewd-otp-order-" . $Custom_Field->Field_ID . "' class='ewd-otp-order-content pure-u-7-8'>";
								$ReturnString .= $MetaValue->Meta_Value;
								$ReturnString .= "</div>";
						}
				}
				if (in_array("Order_Status", $Order_Information)) {
						if (in_array("Order Status", $Fields)) {$Status_Label = $Fields['Order Status'];}
						else {$Status_Label = __("Order Status", 'EWD_OTP');}
						$ReturnString .= "<div id='ewd-otp-status-header' class='ewd-otp-status-message pure-u-1-5 mt-12 mb-6 ewd-otp-bold'>";
						$ReturnString .= $Status_Label;
						$ReturnString .= "</div>";
				}
				if (in_array("Order_Updated", $Order_Information)) {
						if (in_array("Order Updated", $Fields)) {$Updated_Label = $Fields['Order Updated'];}
						else {$Updated_Label = __("Order Updated", 'EWD_OTP');}
						$ReturnString .= "<div id='ewd-otp-date-header' class='ewd-otp-status-time pure-u-1-5 mt-12 mb-6 ewd-otp-bold'>";
						$ReturnString .= $Updated_Label;
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