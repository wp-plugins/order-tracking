<?php
function EWD_OTP_Return_Results($TrackingNumber, $Fields = array(), $Email = '', $notes_submit = '') {
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name;
		
	$Order_Information_String = get_option("EWD_OTP_Order_Information");
	$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");
	$Order_Information = explode(",", $Order_Information_String);
	$Localize_Date_Time = get_option("EWD_OTP_Localize_Date_Time");

	//Calculate how many blank columns are in the status table
	$Status_Column_Size = 5;
	if (in_array("Order_Status", $Order_Information)) {$Status_Column_Size--;}
	if (in_array("Order_Location", $Order_Information)) {$Status_Column_Size--;}
	if (in_array("Order_Updated", $Order_Information)) {$Status_Column_Size--;}

		
	if ($Email_Confirmation == "Auto_Entered") {$Email = do_shortcode($Email);}
		
	if ($Email_Confirmation == "Order_Email" or $Email_Confirmation == "Auto_Entered") {
		if (strpos($Email, "@") !== false and strpos($Email, ".") !== false) {
			$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s' and Order_Email LIKE '%s'", $TrackingNumber, '%' . $Email . '%'));
		}
		else {
			$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s' and Order_Email='%s'", $TrackingNumber, $Email));
		}
	}
	else {$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s'", $TrackingNumber));}
	if (isset($Order->Order_ID)) {$Statuses = $wpdb->get_results($wpdb->prepare("SELECT Order_Status, Order_Location, Order_Status_Created FROM $EWD_OTP_order_statuses_table_name WHERE Order_ID='%s' ORDER BY Order_Status_Created ASC", $Order->Order_ID));}

	if ($wpdb->num_rows == 0) {
		$ReturnString .= "<div class='pure-u-1'>";
		if ($Email_Confirmation == "Order_Email") {$ReturnString .= __("There are no order statuses for tracking number: ", 'EWD_OTP') . $TrackingNumber . " and e-mail: " . $Email . ".<br />";}
		else {$ReturnString .= __("There are no order statuses for tracking number: ", 'EWD_OTP') . $TrackingNumber . ".<br />";}
		$ReturnString .= "</div>";
	}
	else {					
		if (in_array("Order_Graphic", $Order_Information)) {
			$ReturnString .= "<div class='ewd-otp-status-graphic pure-u-1'>";
			$ReturnString .= EWD_OTP_Display_Graph($_POST['Tracking_Number']);
			$ReturnString .= "</div>";
			$ReturnString .= "<div class='ewd-otp-clear'></div>";
		}
		if (in_array("Order_Number", $Order_Information)) {
			if (array_key_exists ("Order Number", $Fields)) {$Number_Label = $Fields['Order Number'];}
			else {$Number_Label = __("Order Number", 'EWD_OTP');}
			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-order-number-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Number_Label . ":";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-number' class='ewd-otp-order-content pure-u-7-8'>";
			$ReturnString .= "<div class='ewd-otp-bottom-align'>" . $Order->Order_Number . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}
		if (in_array("Order_Name", $Order_Information)) {
			if (array_key_exists("Order Name", $Fields)) {$Name_Label = $Fields['Order Name'];}
			else {$Name_Label = __("Order Name", 'EWD_OTP');}
			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-order-name-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Name_Label . ":";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-name' class='ewd-otp-order-content pure-u-7-8'>";
			$ReturnString .= "<div class='ewd-otp-bottom-align'>" . $Order->Order_Name . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}
		if (in_array("Order_Notes", $Order_Information)) {
			if (array_key_exists("Order Notes", $Fields)) {$Notes_Label = $Fields['Order Notes'];}
			else {$Notes_Label = __("Order Notes", 'EWD_OTP');}
			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-order-notes-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Notes_Label . ":";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-notes' class='ewd-otp-order-content pure-u-7-8'>";
			$ReturnString .= "<div class='ewd-otp-bottom-align'>" . stripslashes_deep($Order->Order_Notes_Public) . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}
		if (in_array("Customer_Notes", $Order_Information)) {
			if (array_key_exists("Customer Notes", $Fields)) {$Customers_Label = $Fields['Customer Notes'];}
			else {$Customers_Label = __("Customer Notes", 'EWD_OTP');}
			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-customer-notes-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Customers_Label . ":";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-notes' class='ewd-otp-order-content pure-u-7-8'>";
			$ReturnString .= "<div class='ewd-otp-bottom-align'>" . stripslashes_deep($Order->Order_Customer_Notes) . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}

		$Sql = "SELECT * FROM $EWD_OTP_fields_table_name";
		$Custom_Fields = $wpdb->get_results($Sql);
		foreach ($Custom_Fields as $Custom_Field) {
			if (in_array($Custom_Field->Field_ID, $Order_Information)) {
				$MetaValue = $wpdb->get_row($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order->Order_ID, $Custom_Field->Field_ID));
				if (array_key_exists($Custom_Field->Field_Name, $Fields)) {$Field_Label = $Fields[$Custom_Field->Field_Name];}
				else {$Field_Label = $Custom_Field->Field_Name;}
				$ReturnString .= "<div id='ewd-otp-order-" . $Custom_Field->Field_ID . "-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
				$ReturnString .= $Field_Label . ":";
				$ReturnString .= "</div>";
				$ReturnString .= "<div id='ewd-otp-order-" . $Custom_Field->Field_ID . "' class='ewd-otp-order-content pure-u-7-8'>";
				if ($Custom_Field->Field_Type == "file") {$ReturnString .= "<div class='ewd-otp-bottom-align'>";
					$ReturnString .= "<a href='" . site_url("/wp-content/uploads/order-tracking-uploads/") . $MetaValue->Meta_Value . "' download>";
					$ReturnString .= $MetaValue->Meta_Value . "</a></div>";
				}
				else {$ReturnString .= "<div class='ewd-otp-bottom-align'>" . stripslashes_deep($MetaValue->Meta_Value) . "</div>";}
				$ReturnString .= "</div>";
			}
		}
		$ReturnString .= "<div class='ewd-otp-status-label'>";
		if (in_array("Order_Status", $Order_Information)) {
			if (array_key_exists("Order Status", $Fields)) {$Status_Label = $Fields['Order Status'];}
			else {$Status_Label = __("Order Status", 'EWD_OTP');}
			$ReturnString .= "<div id='ewd-otp-status-header' class='ewd-otp-status-message pure-u-1-5 mt-12 mb-6 ewd-otp-bold'>";
			$ReturnString .= $Status_Label;
			$ReturnString .= "</div>";
		}
		if (in_array("Order_Location", $Order_Information)) {
			if (array_key_exists("Order Location", $Fields)) {$Location_Label = $Fields['Order Location'];}
			else {$Location_Label = __("Order Location", 'EWD_OTP');}
			$ReturnString .= "<div id='ewd-otp-location-header' class='ewd-otp-status-location pure-u-1-5 mt-12 mb-6 ewd-otp-bold'>";
			$ReturnString .= $Location_Label;
			$ReturnString .= "</div>";
		}
		if (in_array("Order_Updated", $Order_Information)) {
			if (array_key_exists("Order Updated", $Fields)) {$Updated_Label = $Fields['Order Updated'];}
			else {$Updated_Label = __("Order Updated", 'EWD_OTP');}
			$ReturnString .= "<div id='ewd-otp-date-header' class='ewd-otp-status-time pure-u-1-5 mt-12 mb-6 ewd-otp-bold'>";
			$ReturnString .= $Updated_Label;
			$ReturnString .= "</div>";
		}
		$ReturnString .= "</div>";
		if (in_array("Order_Status", $Order_Information) or in_array("Order_Updated", $Order_Information)) {
			foreach ($Statuses as $Status) {
				$ReturnString .= "<div class='ewd-otp-label-values'>";
				if (in_array("Order_Status", $Order_Information)) {
					$ReturnString .= "<div class='ewd-otp-status-message pure-u-1-5'>";
					$ReturnString .= $Status->Order_Status;
					$ReturnString .= "</div>";
				}
				if (in_array("Order_Location", $Order_Information)) {
					$ReturnString .= "<div class='ewd-otp-status-time pure-u-1-5'>";
					$ReturnString .= $Status->Order_Location;
					$ReturnString .= "</div>";
				}
				if (in_array("Order_Updated", $Order_Information)) {
					$ReturnString .= "<div class='ewd-otp-status-time pure-u-1-5'>";
					if ($Localize_Date_Time == "European") {$ReturnString .= date("d-m-Y H:i:s", strtotime($Status->Order_Status_Created));}
					else {$ReturnString .= $Status->Order_Status_Created;}
					$ReturnString .= "</div>";
				}
				$ReturnString .= "</div>";
			}
		}
		if (in_array("Customer_Notes", $Order_Information)) {
			if (array_key_exists("Customer Notes", $Fields)) {$Customers_Label = $Fields['Order Status'];}
			else {$Customers_Label = __("Customer Notes", 'EWD_OTP');}
			$ReturnString .= "<div id='ewd-otp-customer-notes' class='ewd-otp-status-message pure-u-1 mt-12 mb-6 ewd-otp-bold'>";
			$ReturnString .= $Customers_Label . ": ";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-customer-notes' class='ewd-otp-status-message pure-u-1-5 mb-6 ewd-otp-bold'>";
			$ReturnString .= __("Note:", "EWD_OTP");
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-customer-notes' class='ewd-otp-status-message pure-u-4-5 mb-6'>"; 
			$ReturnString .= "<form action='#' method='post' class='pure-form pure-form-aligned'>";
			$ReturnString .= "<input type='hidden' name='CN_Order_Number' value='" . $TrackingNumber . "' />";
			$ReturnString .= "<input type='hidden' name='Tracking_Number' value='" . $TrackingNumber . "' />";
			if ($Email != "") {$ReturnString .= "<input type='hidden' name='Order_Email' value='" . $Email . "' />";}
			$ReturnString .= "<textarea name='Customer_Notes'>" . $Order->Order_Customer_Notes . "</textarea>";
			$ReturnString .= "<input type='submit' name='Notes_Submit' value='" . $notes_submit . "' />";
			$ReturnString .= "</form>";
			$ReturnString .= "</div>";
		}
	}
	return $ReturnString;
}

function EWD_OTP_Return_Customer_Results($Customer_ID, $Fields = array(), $Customer_Email = '') {
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $EWD_OTP_customers;
		
	$Order_Information_String = get_option("EWD_OTP_Order_Information");
	$Customer_Confirmation = get_option("EWD_OTP_Customer_Confirmation");
	$Order_Information = explode(",", $Order_Information_String);
	$Localize_Date_Time = get_option("EWD_OTP_Localize_Date_Time");
	$Cut_Off_Days = get_option("EWD_OTP_Cut_Off_Days");
		
	if ($Customer_Confirmation == "Auto_Entered") {$Customer_Email = do_shortcode($Customer_Email);}
		
	if ($Customer_Confirmation == "Order_Email" or $Customer_Confirmation == "Auto_Entered") {
		$Customer = $wpdb->get_results($wpdb->prepare("SELECT Customer_ID FROM $EWD_OTP_customers WHERE Customer_ID='%d' and Customer_Email='%s'", $Customer_ID, $Customer_Email));
		if ($wpdb->num_rows == 0) {
			$ReturnString = "There is no customer with the ID " . $Customer_ID . " and an e-mail of " . $Customer_Email;
			return $Returnstring;
		}
	}
	
	$Start = ($Page) * 50;
	$CutOffDate = date("Y-m-d H:i:s", time()-(60*60*24*$Cut_Off_Days));
		
	$Orders = $wpdb->get_results($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Customer_ID='%d' AND Order_Status_Updated>'%s' ORDER BY Order_Status_Updated LIMIT %d, 100", $Customer_ID, $CutOffDate, $Start));
		
	$Counter = 0;
	$ReturnString .= "</div>";
	$ReturnString .= "<table>";
	$ReturnString .= "<tr>";
	if (in_array("Order_Number", $Order_Information)) {
		if (in_array("Order Number", $Fields)) {$Number_Label = $Fields['Order Number'];}
		else {$Number_Label = __("Order Number", 'EWD_OTP');}
		$ReturnString .= "<th>";
		$ReturnString .= $Number_Label . ":";
		$ReturnString .= "</th>";
	}
	if (in_array("Order_Name", $Order_Information)) {
		if (in_array("Order Name", $Fields)) {$Name_Label = $Fields['Order Name'];}
		else {$Name_Label = __("Order Name", 'EWD_OTP');}
		$ReturnString .= "<th>";
		$ReturnString .= $Name_Label . ":";
		$ReturnString .= "</th>";
	}
	if (in_array("Order_Notes", $Order_Information)) {
		if (in_array("Order Notes", $Fields)) {$Notes_Label = $Fields['Order Notes'];}
		else {$Notes_Label = __("Order Notes", 'EWD_OTP');}
		$ReturnString .= "<th>";
		$ReturnString .= $Notes_Label . ":";
		$ReturnString .= "</th>";
	}
	if (in_array("Customer_Name", $Order_Information)) {
		$CustomerName = $wpdb->get_var ($wpdb->prepare("SELECT Customer_Name FROM $EWD_OTP_customers WHERE Customer_ID=%d", $Order->Customer_ID));
		if (in_array("Customer Name", $Fields)) {$Notes_Label = $Fields['Customer Name'];}
		else {$Notes_Label = __("Customer Name", 'EWD_OTP');}
		$ReturnString .= "<th>";
		$ReturnString .= $Notes_Label . ":";
		$ReturnString .= "</th>";
	}
	$Sql = "SELECT * FROM $EWD_OTP_fields_table_name";
	$Custom_Fields = $wpdb->get_results($Sql);
	foreach ($Custom_Fields as $Custom_Field) {
		if (in_array($Custom_Field->Field_ID, $Order_Information)) {
			$MetaValue = $wpdb->get_results($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order->Order_ID, $Custom_Field->Field_ID));
			$ReturnString .= "<th>";
			$ReturnString .= $Custom_Field->Field_Name . ":";
			$ReturnString .= "</th>";
		}
	}
	if (in_array("Order_Status", $Order_Information)) {
		if (in_array("Order Status", $Fields)) {$Status_Label = $Fields['Order Status'];}
		else {$Status_Label = __("Order Status", 'EWD_OTP');}
		$ReturnString .= "<th>";
		$ReturnString .= $Status_Label;
		$ReturnString .= "</th>";
	}
	if (in_array("Order_Updated", $Order_Information)) {
		if (in_array("Order Updated", $Fields)) {$Updated_Label = $Fields['Order Updated'];}
		else {$Updated_Label = __("Order Updated", 'EWD_OTP');}
		$ReturnString .= "<th>";
		$ReturnString .= $Updated_Label;
		$ReturnString .= "</th>";
	}
	$ReturnString .= "</tr>";

	foreach ($Orders as $Order) {
		if ($Counter >= 50) {break;}
		if (isset($Order->Order_ID)) {$Status = $wpdb->get_row($wpdb->prepare("SELECT Order_Status, Order_Status_Created FROM $EWD_OTP_order_statuses_table_name WHERE Order_ID='%s' AND Order_Status_Created='%s' ORDER BY Order_Status_Created ASC", $Order->Order_ID, $Order->Order_Status_Updated));}

		$ReturnString .= "<tr>";
		if ($wpdb->num_rows == 0) {
			$ReturnString .= "<div class='pure-u-1'>";
			if ($Email_Confirmation == "Order_Email") {$ReturnString .= __("There are no order statuses for tracking number: ", 'EWD_OTP') . $TrackingNumber . " and e-mail: " . $Email . ".<br />";}
			else {$ReturnString .= __("There are no order statuses for tracking number: ", 'EWD_OTP') . $TrackingNumber . ".<br />";}
			$ReturnString .= "</div>";
		}
		else {					
			if (in_array("Order_Number", $Order_Information)) {
				$ReturnString .= "<td>";
				$ReturnString .= $Order->Order_Number;
				$ReturnString .= "</td>";
			}
			if (in_array("Order_Name", $Order_Information)) {
				$ReturnString .= "<td>";
				$ReturnString .= $Order->Order_Name;
				$ReturnString .= "</td>";
			}
			if (in_array("Order_Notes", $Order_Information)) {
				$ReturnString .= "<td>";
				$ReturnString .= $Order->Order_Notes_Public;
				$ReturnString .= "</td>";
			}
			if (in_array("Customer_Name", $Order_Information)) {
				$CustomerName = $wpdb->get_var ($wpdb->prepare("SELECT Customer_Name FROM $EWD_OTP_customers WHERE Customer_ID=%d", $Order->Customer_ID));
				$ReturnString .= "<td>";
				$ReturnString .= $CustomerName;
				$ReturnString .= "</td>";
			}
			$Sql = "SELECT * FROM $EWD_OTP_fields_table_name";
			$Custom_Fields = $wpdb->get_results($Sql);
			foreach ($Custom_Fields as $Custom_Field) {
				if (in_array($Custom_Field->Field_ID, $Order_Information)) {
					$MetaValue = $wpdb->get_row($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order->Order_ID, $Custom_Field->Field_ID));
					$ReturnString .= "<td>";
					if ($Custom_Field->Field_Type == "file") {
						$ReturnString .= "<a href='" . site_url("/wp-content/uploads/order-tracking-uploads/") . $MetaValue->Meta_Value . "' download>";
						$ReturnString .= $MetaValue->Meta_Value . "</a>";
					}
					else {$ReturnString .= $MetaValue->Meta_Value;}
					$ReturnString .= "</td>";
				}
			}
			if (in_array("Order_Status", $Order_Information) or in_array("Order_Updated", $Order_Information)) {
				//foreach ($Statuses as $Status) {
				if (in_array("Order_Status", $Order_Information)) {
					$ReturnString .= "<td>";
					$ReturnString .= $Status->Order_Status;
					$ReturnString .= "</td>";
				}
				if (in_array("Order_Updated", $Order_Information)) {
					$ReturnString .= "<td>";
					$ReturnString .= $Status->Order_Status_Created;
					$ReturnString .= "</td>";
				}
				//}
			}
		}
		$ReturnString .= "</tr>";
	}
	$ReturnString .= "</table>";
	$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
		
	if ($Counter >= 50) {
		$ReturnString .= "<div class='pure-u-4-5'>";
		$ReturnString .= "<form action='#' method='post'>";
		$Returnstring .= "<input type='hidden' name='Customer_ID' value='" . $Customer_ID . "'>";
		$Returnstring .= "<input type='hidden' name='Customer_Email' value='" . $Customer_Email . "'>";
		$ReturnString .= "<input type='hidden' name='Page' value='" . $Page . "'>";
		$ReturnString .= "<input type='submit' name='Customer_Submit' value='Next Page'>";
		$ReturnString .= "</div>";
	}
		
	return $ReturnString;
}

function EWD_OTP_Return_Sales_Rep_Results($Sales_Rep_ID, $Fields = array(), $Sales_Rep_Email = '') {
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $EWD_OTP_sales_reps;
		
	$Order_Information_String = get_option("EWD_OTP_Order_Information");
	$Sales_Rep_Confirmation = get_option("EWD_OTP_Sales_Rep_Confirmation");
	$Order_Information = explode(",", $Order_Information_String);
	$Localize_Date_Time = get_option("EWD_OTP_Localize_Date_Time");
	$Cut_Off_Days = get_option("EWD_OTP_Cut_Off_Days");
		
	if ($Sales_Rep_Confirmation == "Auto_Entered") {$Sales_Rep_Email = do_shortcode($Sales_Rep_Email);}
		
	if ($Sales_Rep_Confirmation == "Order_Email" or $Sales_Rep_Confirmation == "Auto_Entered") {
		$Sales_Rep = $wpdb->get_results($wpdb->prepare("SELECT Sales_Rep_ID FROM $EWD_OTP_sales_reps WHERE Sales_Rep_ID='%d' and Sales_Rep_Email='%s'", $Sales_Rep_ID, $Sales_Rep_Email));
		if ($wpdb->num_rows == 0) {
			$ReturnString = "There is no sales rep with the ID " . $Sales_Rep_ID . " and an e-mail of " . $Sales_Rep_Email;
			return $Returnstring;
		}
	}
	
	$Start = ($Page) * 50;
	$CutOffDate = date("Y-m-d H:i:s", time()-(60*60*24*$Cut_Off_Days));
		
	$Orders = $wpdb->get_results($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Sales_Rep_ID='%d' AND Order_Status_Updated>'%s' ORDER BY Order_Status_Updated LIMIT %d, 100", $Sales_Rep_ID, $CutOffDate, $Start));
		
	$Counter = 0;
	$ReturnString .= "</div>";
	$ReturnString .= "<table>";
	$ReturnString .= "<tr>";
	if (in_array("Order_Number", $Order_Information)) {
		if (in_array("Order Number", $Fields)) {$Number_Label = $Fields['Order Number'];}
		else {$Number_Label = __("Order Number", 'EWD_OTP');}
		$ReturnString .= "<th>";
		$ReturnString .= $Number_Label . ":";
		$ReturnString .= "</th>";
	}
	if (in_array("Order_Name", $Order_Information)) {
		if (in_array("Order Name", $Fields)) {$Name_Label = $Fields['Order Name'];}
		else {$Name_Label = __("Order Name", 'EWD_OTP');}
		$ReturnString .= "<th>";
		$ReturnString .= $Name_Label . ":";
		$ReturnString .= "</th>";
	}
	if (in_array("Order_Notes", $Order_Information)) {
		if (in_array("Order Notes", $Fields)) {$Notes_Label = $Fields['Order Notes'];}
		else {$Notes_Label = __("Order Notes", 'EWD_OTP');}
		$ReturnString .= "<th>";
		$ReturnString .= $Notes_Label . ":";
		$ReturnString .= "</th>";
	}
	if (in_array("Customer_Name", $Order_Information)) {
		$CustomerName = $wpdb->get_var ($wpdb->prepare("SELECT Customer_Name FROM $EWD_OTP_customers WHERE Customer_ID=%d", $Order->Customer_ID));
		if (in_array("Customer Name", $Fields)) {$Notes_Label = $Fields['Customer Name'];}
		else {$Notes_Label = __("Customer Name", 'EWD_OTP');}
		$ReturnString .= "<th>";
		$ReturnString .= $Notes_Label . ":";
		$ReturnString .= "</th>";
	}
	$Sql = "SELECT * FROM $EWD_OTP_fields_table_name";
	$Custom_Fields = $wpdb->get_results($Sql);
	foreach ($Custom_Fields as $Custom_Field) {
		if (in_array($Custom_Field->Field_ID, $Order_Information)) {
			$MetaValue = $wpdb->get_results($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order->Order_ID, $Custom_Field->Field_ID));
			$ReturnString .= "<th>";
			$ReturnString .= $Custom_Field->Field_Name . ":";
			$ReturnString .= "</th>";
		}
	}
	if (in_array("Order_Status", $Order_Information)) {
		if (in_array("Order Status", $Fields)) {$Status_Label = $Fields['Order Status'];}
		else {$Status_Label = __("Order Status", 'EWD_OTP');}
		$ReturnString .= "<th>";
		$ReturnString .= $Status_Label;
		$ReturnString .= "</th>";
	}
	if (in_array("Order_Updated", $Order_Information)) {
		if (in_array("Order Updated", $Fields)) {$Updated_Label = $Fields['Order Updated'];}
		else {$Updated_Label = __("Order Updated", 'EWD_OTP');}
		$ReturnString .= "<th>";
		$ReturnString .= $Updated_Label;
		$ReturnString .= "</th>";
	}
	$ReturnString .= "</tr>";

	foreach ($Orders as $Order) {
		if ($Counter >= 50) {break;}
		if (isset($Order->Order_ID)) {$Status = $wpdb->get_row($wpdb->prepare("SELECT Order_Status, Order_Status_Created FROM $EWD_OTP_order_statuses_table_name WHERE Order_ID='%s' AND Order_Status_Created='%s' ORDER BY Order_Status_Created ASC", $Order->Order_ID, $Order->Order_Status_Updated));}

		$ReturnString .= "<tr>";
		if ($wpdb->num_rows == 0) {
			$ReturnString .= "<div class='pure-u-1'>";
			if ($Email_Confirmation == "Order_Email") {$ReturnString .= __("There are no order statuses for tracking number: ", 'EWD_OTP') . $TrackingNumber . " and e-mail: " . $Email . ".<br />";}
			else {$ReturnString .= __("There are no order statuses for tracking number: ", 'EWD_OTP') . $TrackingNumber . ".<br />";}
			$ReturnString .= "</div>";
		}
		else {					
			if (in_array("Order_Number", $Order_Information)) {
				$ReturnString .= "<td>";
				$ReturnString .= $Order->Order_Number;
				$ReturnString .= "</td>";
			}
			if (in_array("Order_Name", $Order_Information)) {
				$ReturnString .= "<td>";
				$ReturnString .= $Order->Order_Name;
				$ReturnString .= "</td>";
			}
			if (in_array("Order_Notes", $Order_Information)) {
				$ReturnString .= "<td>";
				$ReturnString .= $Order->Order_Notes_Public;
				$ReturnString .= "</td>";
			}
			if (in_array("Customer_Name", $Order_Information)) {
				$CustomerName = $wpdb->get_var ($wpdb->prepare("SELECT Customer_Name FROM $EWD_OTP_customers WHERE Customer_ID=%d", $Order->Customer_ID));
				$ReturnString .= "<td>";
				$ReturnString .= $CustomerName;
				$ReturnString .= "</td>";
			}
			$Sql = "SELECT * FROM $EWD_OTP_fields_table_name";
			$Custom_Fields = $wpdb->get_results($Sql);
			foreach ($Custom_Fields as $Custom_Field) {
				if (in_array($Custom_Field->Field_ID, $Order_Information)) {
					$MetaValue = $wpdb->get_row($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order->Order_ID, $Custom_Field->Field_ID));
					$ReturnString .= "<td>";
					if ($Custom_Field->Field_Type == "file") {
						$ReturnString .= "<a href='" . site_url("/wp-content/uploads/order-tracking-uploads/") . $MetaValue->Meta_Value . "' download>";
						$ReturnString .= $MetaValue->Meta_Value . "</a>";
					}
					else {$ReturnString .= $MetaValue->Meta_Value;}
					$ReturnString .= "</td>";
				}
			}
			if (in_array("Order_Status", $Order_Information) or in_array("Order_Updated", $Order_Information)) {
				//foreach ($Statuses as $Status) {
				if (in_array("Order_Status", $Order_Information)) {
					$ReturnString .= "<td>";
					$ReturnString .= $Status->Order_Status;
					$ReturnString .= "</td>";
				}
				if (in_array("Order_Updated", $Order_Information)) {
					$ReturnString .= "<td>";
					$ReturnString .= $Status->Order_Status_Created;
					$ReturnString .= "</td>";
				}
				//}
			}
		}
		$ReturnString .= "</tr>";
	}
	$ReturnString .= "</table>";
	$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
		
	if ($Counter >= 50) {
		$ReturnString .= "<div class='pure-u-4-5'>";
		$ReturnString .= "<form action='#' method='post'>";
		$Returnstring .= "<input type='hidden' name='Customer_ID' value='" . $Customer_ID . "'>";
		$Returnstring .= "<input type='hidden' name='Customer_Email' value='" . $Customer_Email . "'>";
		$ReturnString .= "<input type='hidden' name='Page' value='" . $Page . "'>";
		$ReturnString .= "<input type='submit' name='Customer_Submit' value='Next Page'>";
		$ReturnString .= "</div>";
	}
		
	return $ReturnString;
}
?>