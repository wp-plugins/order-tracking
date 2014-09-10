<?php
/* The file contains all of the functions which make changes to the OTP tables */

/* Adds a single new order to the OTP database */
function Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Email, $Order_Status, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated) {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$wpdb->insert( $EWD_OTP_orders_table_name, 
						array( 'Order_Name' => $Order_Name,
									 'Order_Number' => $Order_Number,
									 'Order_Status' => $Order_Status,
									 'Order_Notes_Public' => $Order_Notes_Public,
									 'Order_Notes_Private' => $Order_Notes_Private,
									 'Order_Email' => $Order_Email,
									 'Order_Display' => $Order_Display,
									 'Order_Status_Updated' => $Order_Status_Updated)
					 );
		$wpdb->insert( $EWD_OTP_order_statuses_table_name, 
						array( 'Order_ID' => $wpdb->insert_id,
									 'Order_Status' => $Order_Status,
									 'Order_Status_Created' => $Order_Status_Updated)
					 );
		$update = __("Order has been successfully created.", 'EWD_OTP');
		return $update;
}

/* Edits a single order with a given ID in the OTP database */
function Edit_EWD_OTP_Order($Order_ID, $Order_Name, $Order_Number, $Order_Email, $Order_Status, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated) {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$wpdb->update( $EWD_OTP_orders_table_name, 
						array( 'Order_Name' => $Order_Name,
									 'Order_Number' => $Order_Number,
									 'Order_Status' => $Order_Status,
									 'Order_Notes_Public' => $Order_Notes_Public,
									 'Order_Notes_Private' => $Order_Notes_Private,
									 'Order_Email' => $Order_Email,
									 'Order_Display' => $Order_Display,
									 'Order_Status_Updated' => $Order_Status_Updated),
					 	array( 'Order_ID' => $Order_ID)
					 );
		$wpdb->insert( $EWD_OTP_order_statuses_table_name, 
						array( 'Order_ID' => $Order_ID,
									 'Order_Status' => $Order_Status,
									 'Order_Status_Created' => $Order_Status_Updated)
					 );
		$update = __("Order has been successfully edited.", 'EWD_OTP');
		return $update;
}

function Update_EWD_OTP_Order_Status($Order_ID, $Order_Status, $Order_Status_Updated) {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$wpdb->update( $EWD_OTP_orders_table_name, 
						array( 'Order_Status' => $Order_Status,
									 'Order_Status_Updated' => $Order_Status_Updated),
					 	array( 'Order_ID' => $Order_ID)
					 );
		$wpdb->insert( $EWD_OTP_order_statuses_table_name, 
						array( 'Order_ID' => $Order_ID,
									 'Order_Status' => $Order_Status,
									 'Order_Status_Created' => $Order_Status_Updated)
					 );
		$update = __("Order status has been successfully edited.", 'EWD_OTP');
		return $update;
}

function Hide_EWD_OTP_Order($Order_ID) {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$wpdb->update( $EWD_OTP_orders_table_name, 
						array( 'Order_Display' => "No"),
					 	array( 'Order_ID' => $Order_ID)
					 );

		$update = __("Order has been successfully hidden.", 'EWD_OTP');
		return $update;
}

/* Deletes a single prder with a given ID in the OTP database */
function Delete_EWD_OTP_Order($Order_ID) {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$wpdb->delete(
						$EWD_OTP_orders_table_name,
						array('Order_ID' => $Order_ID)
					);
		$wpdb->delete(
						$EWD_OTP_order_statuses_table_name,
						array('Order_ID' => $Order_ID)
					);

		$update = __("Order has been successfully deleted.", 'EWD_OTP');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $update;
}

/* Adds multiple new orders inputted via a spreadsheet uploaded to the top form 
*  on the left-hand side of the orders' page to the OTP database */
function Add_EWD_OTP_Orders_From_Spreadsheet($Excel_File_Name) {
		global $wpdb;
		global $EWD_OTP_orders_table_name;
		global $EWD_OTP_order_statuses_table_name;
		
		$Order_Email = get_option("EWD_OTP_Order_Email");
		
		$Excel_URL = '../wp-content/plugins/order-tracking/order-sheets/' . $Excel_File_Name;
		
		// Uses the PHPExcel class to simplify the file parsing process
		include_once('../wp-content/plugins/order-tracking/PHPExcel/Classes/PHPExcel.php');
		
		// Build the workbook object out of the uploaded spredsheet
		$inputFileType = PHPExcel_IOFactory::identify($Excel_URL);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objWorkBook = $objReader->load($Excel_URL);
		
		// Create a worksheet object out of the product sheet in the workbook
		$sheet = $objWorkBook->getActiveSheet();
		
		//List of fields that can be accepted via upload
		$Allowed_Fields = array ("Name" => "Order_Name", "Number" => "Order_Number", "Status" => "Order_Status", "Display" => "Order_Display", "Public Notes" => "Order_Notes_Public", "Private Notes" => "Order_Notes_Private", "Email" => "Order_Email");
		
		// Get column names
		$highestColumn = $sheet->getHighestColumn();
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);	
		for ($column = 0; $column < $highestColumnIndex; $column++) {
				$Titles[$column] = trim($sheet->getCellByColumnAndRow($column, 1)->getValue());
		}

		// Make sure all columns are acceptable based on the acceptable fields above
		foreach ($Titles as $Title) {
				if ($Title != "" and !array_key_exists($Title, $Allowed_Fields)) {
					  $Error = __("You have a column which is not recognized: ", 'EWD_OTP') . $Title . __(". <br>Please make sure that the column names match the order field labels exactly (without the word order).", 'EWD_OTP');
						$user_update = array("Message_Type" => "Error", "Message" => $Error);
						return $user_update;
				}
				if ($Title == "") {
					  $Error = __("You have a blank column that has been edited.<br>Please delete that column and re-upload your spreadsheet.", 'EWD_OTP');
						$user_update = array("Message_Type" => "Error", "Message" => $Error);
						return $user_update;
				}
		}
		
		// Put the spreadsheet data into a multi-dimensional array to facilitate processing
		$highestRow = $sheet->getHighestRow();
		for ($row = 2; $row <= $highestRow; $row++) {
				for ($column = 0; $column < $highestColumnIndex; $column++) {
						$Data[$row][$column] = $sheet->getCellByColumnAndRow($column, $row)->getValue();
				}
		}

		// Creates an array of the field names which are going to be inserted into the database
		// and then turns that array into a string so that it can be used in the query
		for ($column = 0; $column < $highestColumnIndex; $column++) {
				$Fields[] = $Allowed_Fields[$Titles[$column]];
				if ($Allowed_Fields[$Titles[$column]] == "Order_Status") {$Status_Column = $column;}
				if ($Allowed_Fields[$Titles[$column]] == "Order_Number") {$Number_Column = $column;}
		}
		$FieldsString = implode(",", $Fields);
		
		$Date = date("Y-m-d H:i:s");

		// Create the query to insert the products one at a time into the database and then run it
		foreach ($Data as $Order) {
				
				// Create an array of the values that are being inserted for each order,
				// edit if it's a current order, otherwise add it
				foreach ($Order as $Col_Index => $Value) {
						$Values[] = esc_sql($Value);
						if (isset($Status_Column) and $Status_Column == $Col_Index) {$Status = $Value;}
						if (isset($Number_Column) and $Number_Column == $Col_Index) {$Number = $Value;}
				}
				$ValuesString = implode("','", $Values);
				if (isset($Number)) {
					  $Order_ID = $wpdb->get_row($wpdb->prepare("SELECT Order_ID FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s'", $Number));
				}

				if ($Order_ID->Order_ID != "") {
					  foreach ($Values as $key => $value) {$UpdateString .= $Fields[$key] . "='" . $value . "', ";}
						$wpdb->query($wpdb->prepare("UPDATE $EWD_OTP_orders_table_name SET " . $UpdateString . " Order_Status_Updated='%s' WHERE Order_ID='%d'", $Date, $Order_ID->Order_ID));
						$Order = $wpdb->get_row("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_ID='" . $Order_ID->Order_ID . "'");
						if ($Order_Email == "Change" and $Order->Order_Email != "") {
							  EWD_OTP_Send_Email($Order->Order_Email, $Order->Order_Number, $Order->Order_Status, $Order->Order_Notes_Public, $Order->Order_Status_Updated);
						}
				}
				else {
						$wpdb->query($wpdb->prepare("INSERT INTO $EWD_OTP_orders_table_name (" . $FieldsString . ", Order_Status_Updated) VALUES ('" . $ValuesString . "','%s')", $Date));
						$Order_ID = $wpdb->insert_id;
						$Order = $wpdb->get_row("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_ID='" . $Order_ID . "'");
						if (($Order_Email == "Change" or $Order_Email == "Creation") and $Order->Order_Email != "") {
							  EWD_OTP_Send_Email($Order->Order_Email, $Order->Order_Number, $Order->Order_Status, $Order->Order_Notes_Public, $Order->Order_Status_Updated, "Yes");
						}
				}
				
				if (($Order_Email == "Change" or $Order_Email == "Creation") and $Order_Email_Address != "") {}
				
				if (isset($Status)) {
						$wpdb->query($wpdb->prepare("INSERT INTO $EWD_OTP_order_statuses_table_name (Order_ID, Order_Status, Order_Status_Created) VALUES (%d, %s, %s)", $Order_ID, $Status, $Date));
				}

				unset($Status);
				unset($Number);
				unset($Order_ID);
				unset($Values);
				unset($ValuesString);
				unset($UpdateString);
		}

		return __("Orders added successfully.", 'EWD_OTP');
}

function Update_EWD_OTP_Statuses() {
		foreach ($_POST['status'] as $key => $stat) {
				if ($stat != "") {
					  $StatusStringOriginal .= $stat . ",";
						$PercentageStringOriginal .= $_POST['status_percentages'][$key] . ",";
				}
		}
		
		$StatusStringOriginal = substr($StatusStringOriginal, 0, -1);
		$PercentageStringOriginal = substr($PercentageStringOriginal, 0, -1);
		
		//Turn the statuses and percentages into arrays, so that they can be ordered by percentage
		$Statuses = explode(",", $StatusStringOriginal);
		$Percentages = explode(",", $PercentageStringOriginal);
		
		asort($Percentages);
		foreach ($Percentages as $key => $Percent) {
				$PercentageString .= $Percent . ",";
				$StatusString .= $Statuses[$key] . ",";
		}
		
		$StatusString = substr($StatusString, 0, -1);
		$PercentageString = substr($PercentageString, 0, -1);
		
		update_option("EWD_OTP_Statuses", $StatusString);
		update_option("EWD_OTP_Percentages", $PercentageString);
		
		$update = __("Options have been successfully updated.", 'EWD_OTP');
		return $update;
}

function Delete_EWD_OTP_Status($Status) {
		$OriginalStatusString = get_option("EWD_OTP_Statuses");
		$OriginalPercentageString = get_option("EWD_OTP_Percentages");
		
		$Statuses = explode(",", $OriginalStatusString);
		$Percentages = explode(",", $OriginalPercentageString);
		
		foreach ($Statuses as $key => $stat) {
				if ($stat != $Status) {
					  $StatusString .= $stat . ",";
						$PercentageString .= $Percentages[$key] . ",";
				}
		}
		
		$StatusString = substr($StatusString, 0, -1);
		$PercentageString = substr($PercentageString, 0, -1);
		
		update_option("EWD_OTP_Statuses", $StatusString);
		update_option("EWD_OTP_Percentages", $PercentageString);
		
		$update = __("Option has been successfully deleted.", 'EWD_OTP');
		return $update;
}

function Update_EWD_OTP_Options() {
		$Custom_CSS = $_POST['custom_css'];
		$AJAX_Reload = $_POST['ajax_reload'];
		$New_Window = $_POST['new_window'];
		$Order_Information_Array = $_POST['order_information'];
		$Order_Information = implode(",", $Order_Information_Array);
		$Order_Email = $_POST['order_email'];
		$Email_Confirmation = $_POST['email_confirmation'];
		$Form_Instructions = $_POST['form_instructions'];
		$Timezone = $_POST['timezone'];
		
		$Custom_CSS = stripslashes_deep($Custom_CSS);
		$AJAX_Reload = stripslashes_deep($AJAX_Reload);
		$New_Window = stripslashes_deep($New_Window);
		$Order_Information = stripslashes_deep($Order_Information);
		$Order_Email = stripslashes_deep($Order_Email);
		$Email_Confirmation = stripslashes_deep($Email_Confirmation);
		$Form_Instructions = stripslashes_deep($Form_Instructions);
		$Timezone = stripslashes_deep($Timezone);
		
		update_option('EWD_OTP_Custom_CSS', $Custom_CSS);
		update_option('EWD_OTP_AJAX_Reload', $AJAX_Reload);
		update_option('EWD_OTP_New_Window', $New_Window);
		update_option('EWD_OTP_Order_Information', $Order_Information);
		update_option('EWD_OTP_Order_Email', $Order_Email);
		update_option("EWD_OTP_Email_Confirmation", $Email_Confirmation);
		update_option('EWD_OTP_Form_Instructions', $Form_Instructions);
		update_option('EWD_OTP_Timezone', $Timezone);
}

function Update_EWD_OTP_Email_Settings() {
		$Admin_Email = $_POST['admin_email'];
		$Message_Body = $_POST['message_body'];
		$SMTP_Mail_Server = $_POST['smtp_mail_server'];
		$Admin_Password = $_POST['admin_password'];
		
		$Admin_Email = stripslashes_deep($Admin_Email);
		$Message_Body = stripslashes_deep($Message_Body);
		$SMTP_Mail_Server = stripslashes_deep($SMTP_Mail_Server);
		$Admin_Password = stripslashes_deep($Admin_Password);
		
		$key = 'EWD_OTP';
		$Encrypted_Admin_Password = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $Admin_Password, MCRYPT_MODE_CBC, md5(md5($key))));
		
		update_option('EWD_OTP_Admin_Email', $Admin_Email);
		update_option('EWD_OTP_Message_Body', $Message_Body);
		update_option('EWD_OTP_SMTP_Mail_Server', $SMTP_Mail_Server);
		update_option('EWD_OTP_Admin_Password', $Encrypted_Admin_Password);
}
?>