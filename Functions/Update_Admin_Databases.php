<?php
/* The file contains all of the functions which make changes to the OTP tables */

/* Adds a single new order to the OTP database */
function Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Email, $Order_Status, $Order_Location, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID, $WooCommerce_ID = 0) {
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name;
		
	$wpdb->insert( $EWD_OTP_orders_table_name, 
		array( 'Order_Name' => $Order_Name,
			'Order_Number' => $Order_Number,
			'Order_Status' => $Order_Status,
			'Order_Location' => $Order_Location,
			'Order_Notes_Public' => $Order_Notes_Public,
			'Order_Notes_Private' => $Order_Notes_Private,
			'Order_Email' => $Order_Email,
			'Order_Display' => $Order_Display,
			'Customer_ID' => $Customer_ID,
			'Sales_Rep_ID' => $Sales_Rep_ID,
			'WooCommerce_ID' => $WooCommerce_ID,
			'Order_Status_Updated' => $Order_Status_Updated)
	);
		
	$Order_ID = $wpdb->insert_id;
		
	$wpdb->insert( $EWD_OTP_order_statuses_table_name, 
		array( 'Order_ID' => $Order_ID,
			'Order_Status' => $Order_Status,
			'Order_Location' => $Order_Location,
			'Order_Status_Created' => $Order_Status_Updated)
	);
					 
	//Add the custom fields to the meta table
	$Fields = $wpdb->get_results("SELECT Field_ID, Field_Name, Field_Values, Field_Type FROM $EWD_OTP_fields_table_name");
	if (is_array($Fields)) {
		foreach ($Fields as $Field) {
			$FieldName = str_replace(" ", "_", $Field->Field_Name);
			if (isset($_POST[$FieldName]) or isset($_FILES[$FieldName])) {
				// If it's a file, pass back to Prepare_Data_For_Insertion.php to upload the file and get the name
				if ($Field->Field_Type == "file") {
					$File_Upload_Return = EWD_OTP_Handle_File_Upload($FieldName);
					if ($File_Upload_Return['Success'] == "No") {return $File_Upload_Return['Data'];}
					elseif ($File_Upload_Return['Success'] == "N/A") {$NoFile = "Yes";}
					else {$Value = $File_Upload_Return['Data'];}
				}
				else {
					$Value = trim($_POST[$FieldName]);
					$Options = explode(",", $Field->Field_Values);
					if (sizeOf($Options) > 0 and $Options[0] != "") {
						array_walk($Options, create_function('&$val', '$val = trim($val);'));
						$InArray = in_array($Value, $Options);
					}
				}		
				if (!isset($InArray) or $InArray) {
					if ($NoFile != "Yes") {
						$wpdb->insert($EWD_OTP_fields_meta_table_name,
						array( 'Field_ID' => $Field->Field_ID,
							'Order_ID' => $Order_ID,
							'Meta_Value' => $Value)
						);
					}
				}
				elseif ($InArray == false) {$CustomFieldError = __(" One or more custom field values were incorrect.", 'EWD_OTP');}
				unset($InArray);
				unset($NoFile);
			}
		}	
	}
		
	$update = __("Order has been successfully created.", 'EWD_OTP');
	return $update;
}

/* Edits a single order with a given ID in the OTP database */
function Edit_EWD_OTP_Order($Order_ID, $Order_Name, $Order_Number, $Order_Email, $Order_Status, $Order_Location, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID) {
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name;
	
	$wpdb->update( $EWD_OTP_orders_table_name, 
		array( 'Order_Name' => $Order_Name,
			'Order_Number' => $Order_Number,
			'Order_Status' => $Order_Status,
			'Order_Location' => $Order_Location,
			'Order_Notes_Public' => $Order_Notes_Public,
			'Order_Notes_Private' => $Order_Notes_Private,
			'Order_Email' => $Order_Email,
			'Order_Display' => $Order_Display,
			'Customer_ID' => $Customer_ID,
			'Sales_Rep_ID' => $Sales_Rep_ID,
			'Order_Status_Updated' => $Order_Status_Updated),
		array( 'Order_ID' => $Order_ID)
	);
	
	$Status = $wpdb->get_row($wpdb->prepare("SELECT Order_Status, Order_Location FROM $EWD_OTP_order_statuses_table_name WHERE Order_ID='%d' ORDER BY Order_Status_Created DESC", $Order_ID));
	if ($Status->Order_Location != $Order_Location or $Status->Order_Status != $Order_Status) {
		$wpdb->insert( $EWD_OTP_order_statuses_table_name, 
			array( 'Order_ID' => $Order_ID,
				'Order_Status' => $Order_Status,
				'Order_Location' => $Order_Location,
				'Order_Status_Created' => $Order_Status_Updated)
		);
	}
	
					 
	// Delete the custom field values for the given Order_ID
	$File_Fields = $wpdb->get_results("SELECT Field_ID FROM $EWD_OTP_fields_table_name WHERE Field_Type='file'");
	foreach ($File_Fields as $File_Field) {$File_Field_IDs .= $File_Field->Field_ID . ",";}
	$Sql = "DELETE FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID='" . $Order_ID . "'";
	if (strlen($File_Field_IDs) > 0) {$Sql .= " AND Field_ID NOT IN (" . substr($File_Field_IDs, 0, -1) . ")";}
	$wpdb->query($Sql);
		
	//Add the custom fields to the meta table
	$Fields = $wpdb->get_results("SELECT Field_ID, Field_Name, Field_Values, Field_Type FROM $EWD_OTP_fields_table_name");
	if (is_array($Fields)) {
		foreach ($Fields as $Field) {
			$FieldName = str_replace(" ", "_", $Field->Field_Name);
			if (isset($_POST[$FieldName]) or isset($_FILES[$FieldName])) {
				// If it's a file, pass back to Prepare_Data_For_Insertion.php to upload the file and get the name
				if ($Field->Field_Type == "file") {
					if ($_FILES[$FieldName]['name'] != "") {
						$wpdb->delete($EWD_OTP_fields_meta_table_name, array('Order_ID' => $Order_ID, 'Field_ID' => $Field->Field_ID));
						$File_Upload_Return = EWD_OTP_Handle_File_Upload($FieldName);
						if ($File_Upload_Return['Success'] == "No") {return $File_Upload_Return['Data'];}
						elseif ($File_Upload_Return['Success'] == "N/A") {$NoFile = "Yes";}
						else {$Value = $File_Upload_Return['Data'];}
					}
					else {$NoFile = "Yes";}
				}
				else {
					$Value = trim($_POST[$FieldName]);
					$Options = explode(",", $Field->Field_Values);
					if (sizeOf($Options) > 0 and $Options[0] != "") {
						array_walk($Options, create_function('&$val', '$val = trim($val);'));
						$InArray = in_array($Value, $Options);
					}
				}
				if (!isset($InArray) or $InArray) {
					if ($NoFile != "Yes") {
						$wpdb->insert($EWD_OTP_fields_meta_table_name,
							array( 'Field_ID' => $Field->Field_ID,
								'Order_ID' => $Order_ID,
								'Meta_Value' => $Value)
						);
					}
				}
				elseif ($InArray == false) {$CustomFieldError = __(" One or more custom field values were incorrect.", 'UPCP');}
				unset($InArray);
				unset($NoFile);
			}
		}
	}
		
	$update = __("Order has been successfully edited.", 'EWD_OTP');
	return $update;
}

function Update_EWD_OTP_Order_Status($Order_ID, $Order_Status, $Order_Status_Updated) {
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
	$wpdb->update( $EWD_OTP_orders_table_name, 
		array( 'Order_Status' => $Order_Status,
			'Order_Location' => $Order_Location,
			'Order_Status_Updated' => $Order_Status_Updated),
		array( 'Order_ID' => $Order_ID)
	);
	$wpdb->insert( $EWD_OTP_order_statuses_table_name, 
		array( 'Order_ID' => $Order_ID,
			'Order_Status' => $Order_Status,
			'Order_Location' => $Order_Location,
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
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_meta_table_name;
		
	$wpdb->delete(
		$EWD_OTP_orders_table_name,
		array('Order_ID' => $Order_ID)
	);
	$wpdb->delete(
		$EWD_OTP_order_statuses_table_name,
		array('Order_ID' => $Order_ID)
	);
	$wpdb->delete(
		$EWD_OTP_fields_meta_table_name,
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
	global $EWD_OTP_fields_table_name;
	global $EWD_OTP_fields_meta_table_name;
    global $EWD_OTP_customers;

		
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
		
	$Allowable_Custom_Fields = array();
	//List of fields that can be accepted via upload
	$Allowed_Fields = array ("Name" => "Order_Name", "Number" => "Order_Number", "Order Status" => "Order_Status", "Display" => "Order_Display", "Notes Public" => "Order_Notes_Public", "Notes Private" => "Order_Notes_Private", "Email" => "Order_Email", "Show in Admin Table" => "Order_Display");
	$Custom_Fields_From_DB = $wpdb->get_results("SELECT Field_ID, Field_Name, Field_Values, Field_Type FROM $EWD_OTP_fields_table_name");
	if (is_array($Custom_Fields_From_DB)) {
		foreach ($Custom_Fields_From_DB as $Custom_Field_From_DB) {
			$Allowable_Custom_Fields[$Custom_Field_From_DB->Field_Name] = $Custom_Field_From_DB->Field_Name;
			$Field_IDs[$Custom_Field_From_DB->Field_Name] = $Custom_Field_From_DB->Field_ID;
		}
	}
		
	// Get column names
	$highestColumn = $sheet->getHighestColumn();
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);	
	for ($column = 0; $column < $highestColumnIndex; $column++) {
		$Titles[$column] = trim($sheet->getCellByColumnAndRow($column, 1)->getValue());
	}

	// Make sure all columns are acceptable based on the acceptable fields above
	foreach ($Titles as $key => $Title) {
		if ($Title != "" and !array_key_exists($Title, $Allowed_Fields) and !array_key_exists($Title, $Allowable_Custom_Fields)) {
			$Error = __("You have a column which is not recognized: ", 'EWD_OTP') . $Title . __(". <br>Please make sure that the column names match the order field labels exactly (without the word order).", 'EWD_OTP');
			$user_update = array("Message_Type" => "Error", "Message" => $Error);
			return $user_update;
		}
		if ($Title == "") {
			$Error = __("You have a blank column that has been edited.<br>Please delete that column and re-upload your spreadsheet.", 'EWD_OTP');
			$user_update = array("Message_Type" => "Error", "Message" => $Error);
			return $user_update;
		}
		if (array_key_exists($Title, $Allowable_Custom_Fields)) {
			$Custom_Fields[$key] = $Title;
			unset($Titles[$key]);
		}
	}
	if (!is_array($Custom_Fields)) {$Custom_Fields = array();}
		
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
		if (!array_key_exists($column, $Custom_Fields)) {$Fields[] = $Allowed_Fields[$Titles[$column]];}
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
			if (!array_key_exists($Col_Index, $Custom_Fields)) {$Values[] = esc_sql($Value);}
			if (isset($Status_Column) and $Status_Column == $Col_Index) {$Status = $Value;}
			if (isset($Number_Column) and $Number_Column == $Col_Index) {$Number = $Value;}
			if (array_key_exists($Col_Index, $Custom_Fields)) {
				$Custom_Fields_To_Insert[$Custom_Fields[$Col_Index]] = $Value;
			}
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
				EWD_OTP_Send_Email($Order->Order_Email, $Order->Order_Number, $Order->Order_Status, $Order->Order_Notes_Public, $Order->Order_Status_Updated, $Order->Order_Name);
			}
		}
		else {
			$wpdb->query($wpdb->prepare("INSERT INTO $EWD_OTP_orders_table_name (" . $FieldsString . ", Order_Status_Updated) VALUES ('" . $ValuesString . "','%s')", $Date));
			$Order_ID = $wpdb->insert_id;
			$Order = $wpdb->get_row("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_ID='" . $Order_ID . "'");
			if (($Order_Email == "Change" or $Order_Email == "Creation") and $Order->Order_Email != "") {
				EWD_OTP_Send_Email($Order->Order_Email, $Order->Order_Number, $Order->Order_Status, $Order->Order_Notes_Public, $Order->Order_Status_Update, $Order->Order_Name, "Yes");
			}
		}
				
		if (($Order_Email == "Change" or $Order_Email == "Creation") and $Order_Email_Address != "") {}
				
		if (isset($Status)) {
			$wpdb->query($wpdb->prepare("INSERT INTO $EWD_OTP_order_statuses_table_name (Order_ID, Order_Status, Order_Status_Created) VALUES (%d, %s, %s)", $Order_ID, $Status, $Date));
		}

		if (is_array($Custom_Fields_To_Insert)) {
			foreach ($Custom_Fields_To_Insert as $Field => $Value) {
				$Trimmed_Field = trim($Field);
				$Field_ID = $Field_IDs[$Trimmed_Field];
				$wpdb->query($wpdb->prepare("INSERT INTO $EWD_OTP_fields_meta_table_name (Field_ID, Order_ID, Meta_Value) VALUES (%d, %d, %s)", $Field_ID, $Order_ID, $Value));
			}
		}

		unset($Status);
		unset($Number);
		unset($Order_ID);
		unset($Values);
		unset($ValuesString);
		unset($UpdateString);
		unset($Custom_Fields_To_Insert);
	}

	return __("Orders added successfully.", 'EWD_OTP');
}

function Update_EWD_OTP_Statuses() {
	$OriginalStatusString = get_option("EWD_OTP_Statuses") . ",";
	echo $OriginalStatusString . "<br>";
	$OriginalPercentageString = get_option("EWD_OTP_Percentages") . ",";

	foreach ($_POST['status'] as $key => $stat) {
		if ($stat != "") {
			$OriginalStatusString .= stripslashes($stat) . ",";
			$OriginalPercentageString .= $_POST['status_percentages'][$key] . ",";
		}
	}
		
	$OriginalStatusString = substr($OriginalStatusString, 0, -1);
	$OriginalPercentageString = substr($OriginalPercentageString, 0, -1);
		
	//Turn the statuses and percentages into arrays, so that they can be ordered by percentage
	$Statuses = explode(",", $OriginalStatusString);
	$Percentages = explode(",", $OriginalPercentageString);
		
	asort($Percentages);
	foreach ($Percentages as $key => $Percent) {
		$PercentageString .= $Percent . ",";
		$StatusString .= $Statuses[$key] . ",";
	}
		
	$StatusString = substr($StatusString, 0, -1);
	$PercentageString = substr($PercentageString, 0, -1);
	echo $StatusString . "<br>";
	update_option("EWD_OTP_Statuses", $StatusString);
	update_option("EWD_OTP_Percentages", $PercentageString);
		
	$update = __("Statuses have been successfully updated.", 'EWD_OTP');
	return $update;
}

function Delete_EWD_OTP_Status($Status) {
	$OriginalStatusString = get_option("EWD_OTP_Statuses");
	$OriginalPercentageString = get_option("EWD_OTP_Percentages");
	
	$Status = stripslashes(urldecode($Status));

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
		
	$update = __("Status has been successfully deleted.", 'EWD_OTP');
	return $update;
}

function Update_EWD_OTP_Location() {
	$LocationString = get_option("EWD_OTP_Locations") . ",";
	
	foreach ($_POST['location'] as $key => $Loc) {
		if ($Loc != "") {
			$LocationString .= $Loc . ",";
		}
	}
		
	$LocationString = substr($LocationString, 0, -1);
		
	update_option("EWD_OTP_Locations", $LocationString);
		
	$update = __("Locations have been successfully updated.", 'EWD_OTP');
	return $update;
}

function Delete_EWD_OTP_Location($Location) {
	$OriginalLocationString = get_option("EWD_OTP_Locations");
		
	$Locations = explode(",", $OriginalLocationString);
		
	foreach ($Locations as $key => $Loc) {
		if ($Loc != $Location) {
			$LocationsString .= $Loc . ",";
		}
	}
		
	$LocationsString = substr($LocationsString, 0, -1);
		
	update_option("EWD_OTP_Locations", $LocationsString);
		
	$update = __("Location has been successfully deleted.", 'EWD_OTP');
	return $update;
}

/* Adds a single new custom field to the EWD_OTP database */
function Add_EWD_OTP_Custom_Field($Field_Name, $Field_Slug, $Field_Type, $Field_Description, $Field_Values, $Field_Front_End_Display) {
	global $wpdb;
	global $EWD_OTP_fields_table_name;
	$Date = date("Y-m-d H:i:s");
	global $EWD_OTP_Full_Version;
		
	if ($EWD_OTP_Full_Version != "Yes") {exit();}		
	$wpdb->insert($EWD_OTP_fields_table_name,
		array( 'Field_Name' => $Field_Name,
			'Field_Slug' => $Field_Slug,
			'Field_Type' => $Field_Type,
			'Field_Description' => $Field_Description,
			'Field_Values' => $Field_Values,
			'Field_Front_End_Display' => $Field_Front_End_Display,
			'Field_Date_Created' => $Date)
	);
	$update = __("Field has been successfully created.", 'EWD_OTP');
	return $update;
}

/* Edits a single custom field with a given ID in the EWD_OTP database */
function  Edit_EWD_OTP_Custom_Field($Field_ID, $Field_Name, $Field_Slug, $Field_Type, $Field_Description, $Field_Values, $Field_Front_End_Display) {
	global $wpdb;
	global $EWD_OTP_fields_table_name;
	global $EWD_OTP_Full_Version;
	
	if ($EWD_OTP_Full_Version != "Yes") {exit();}		
	$wpdb->update(
		$EWD_OTP_fields_table_name,
		array( 'Field_Name' => $Field_Name,
			'Field_Slug' => $Field_Slug,
			'Field_Type' => $Field_Type,
			'Field_Description' => $Field_Description,
			'Field_Values' => $Field_Values,
			'Field_Front_End_Display' => $Field_Front_End_Display),
		array( 'Field_ID' => $Field_ID)
	);
	$update = __("Field has been successfully edited.", 'EWD_OTP');
	return $update;
}

/* Deletes a single tag with a given ID in the EWD_OTP database, and then eliminates 
*  all of the occurrences of that tag from the tagged items table.  */
function Delete_EWD_OTP_Custom_Field($Field_ID) {
	global $wpdb;
	global $EWD_OTP_fields_table_name;
	global $EWD_OTP_Full_Version;
		
	if ($EWD_OTP_Full_Version != "Yes") {exit();}		
	$wpdb->delete(
		$EWD_OTP_fields_table_name,
		array('Field_ID' => $Field_ID)
	);
					
	$update = __("Field has been successfully deleted.", 'EWD_OTP');
	return $update;
}

function Add_EWD_OTP_Sales_Rep($Sales_Rep_First_Name, $Sales_Rep_Last_Name, $Sales_Rep_WP_ID, $Sales_Rep_Created) {
	global $wpdb;
	global $EWD_OTP_sales_reps;
		
	$wpdb->insert( $EWD_OTP_sales_reps, 
		array( 'Sales_Rep_First_Name' => $Sales_Rep_First_Name,
			'Sales_Rep_Last_Name' => $Sales_Rep_Last_Name,
			'Sales_Rep_WP_ID' => $Sales_Rep_WP_ID,
			'Sales_Rep_Created' => $Sales_Rep_Created)
	);
		
	$update = __("Sales Rep has been successfully created.", 'EWD_OTP');
	return $update;
}

/* Edits a single order with a given ID in the OTP database */
function Edit_EWD_OTP_Sales_Rep($Sales_Rep_ID, $Sales_Rep_First_Name, $Sales_Rep_Last_Name, $Sales_Rep_WP_ID) {
	global $wpdb;
	global $EWD_OTP_sales_reps;
		
	$wpdb->update( $EWD_OTP_sales_reps, 
		array( 'Sales_Rep_First_Name' => $Sales_Rep_First_Name,
			'Sales_Rep_Last_Name' => $Sales_Rep_Last_Name,
			'Sales_Rep_WP_ID' => $Sales_Rep_WP_ID),
		array( 'Sales_Rep_ID' => $Sales_Rep_ID)
	); 
		
	$update = __("Sales Rep has been successfully edited.", 'EWD_OTP');
	return $update;
}

function Delete_EWD_OTP_Sales_Rep($Sales_Rep_ID) {
	global $wpdb;
	global $EWD_OTP_sales_reps;
			
	$wpdb->delete(
		$EWD_OTP_sales_reps,
		array('Sales_Rep_ID' => $Sales_Rep_ID)
	);			

	$update = __("Sales Rep has been successfully deleted.", 'EWD_OTP');
	return $update;
}

function Add_EWD_OTP_Customer($Customer_Name, $Customer_Email, $Sales_Rep_ID, $Customer_Created) {
	global $wpdb;
	global $EWD_OTP_customers;
		
	$wpdb->insert( $EWD_OTP_customers, 
		array( 'Customer_Name' => $Customer_Name,
			'Customer_Email' => $Customer_Email,
			'Sales_Rep_ID' => $Sales_Rep_ID,
			'Customer_Created' => $Customer_Created)
	);
		
	$update = __("Customer has been successfully created.", 'EWD_OTP');
	return $update;
}

/* Edits a single order with a given ID in the OTP database */
function Edit_EWD_OTP_Customer($Customer_ID, $Customer_Name, $Customer_Email, $Sales_Rep_ID) {
	global $wpdb;
	global $EWD_OTP_customers;
		
	$wpdb->update( $EWD_OTP_customers, 
		array( 'Customer_Name' => $Customer_Name,
			'Customer_Email' => $Customer_Email,
			'Sales_Rep_ID' => $Sales_Rep_ID),
		array( 'Customer_ID' => $Customer_ID)
	); 
		
	$update = __("Customer has been successfully edited.", 'EWD_OTP');
	return $update;
}

function Delete_EWD_OTP_Customer($Customer_ID) {
	global $wpdb;
	global $EWD_OTP_customers;
			
	$wpdb->delete(
		$EWD_OTP_customers,
		array('Customer_ID' => $Customer_ID)
	);

	$update = __("Customer has been successfully deleted.", 'EWD_OTP');
	return $update;
}

function Update_EWD_OTP_Customer_Note($Tracking_Number, $Note) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;
		
	$wpdb->update( $EWD_OTP_orders_table_name, 
		array( 'Order_Customer_Notes' => $Note),
		array( 'Order_Number' => $Tracking_Number)
	); 
		
	$update = __("Note has been successfully edited.", 'EWD_OTP');
	return $update;
}

function Update_EWD_OTP_Options() {
	global $EWD_OTP_Full_Version;

	$Custom_CSS = $_POST['custom_css'];
	$AJAX_Reload = $_POST['ajax_reload'];
	$New_Window = $_POST['new_window'];
	$Order_Information_Array = $_POST['order_information'];
	$Order_Information = implode(",", $Order_Information_Array);
	$Order_Email = $_POST['order_email'];
	$Email_Confirmation = $_POST['email_confirmation'];
	$Form_Instructions = $_POST['form_instructions'];
	$Timezone = $_POST['timezone'];
	$Localize_Date_Time = $_POST['localize_date_time'];
	$Access_Role = $_POST['access_role'];
	$WooCommerce_Integration = $_POST['woocommerce_integration'];
	$Display_Graphic = $_POST['display_graphic'];
	$Mobile_Stylesheet = $_POST['mobile_stylesheet'];
		
	$Custom_CSS = stripslashes_deep($Custom_CSS);
	$AJAX_Reload = stripslashes_deep($AJAX_Reload);
	$New_Window = stripslashes_deep($New_Window);
	$Order_Information = stripslashes_deep($Order_Information);
	$Order_Email = stripslashes_deep($Order_Email);
	$Email_Confirmation = stripslashes_deep($Email_Confirmation);
	$Form_Instructions = stripslashes_deep($Form_Instructions);
	$Timezone = stripslashes_deep($Timezone);
	$Localize_Date_Time = stripslashes_deep($Localize_Date_Time);
		
	update_option('EWD_OTP_Custom_CSS', $Custom_CSS);
	update_option('EWD_OTP_AJAX_Reload', $AJAX_Reload);
	update_option('EWD_OTP_New_Window', $New_Window);
	update_option('EWD_OTP_Order_Information', $Order_Information);
	update_option('EWD_OTP_Order_Email', $Order_Email);
	update_option("EWD_OTP_Email_Confirmation", $Email_Confirmation);
	update_option('EWD_OTP_Form_Instructions', $Form_Instructions);
	update_option('EWD_OTP_Timezone', $Timezone);
	update_option('EWD_OTP_Localize_Date_Time', $Localize_Date_Time);

	if ($EWD_OTP_Full_Version == "Yes") {update_option('EWD_OTP_Access_Role', $Access_Role);}
	if ($EWD_OTP_Full_Version == "Yes") {update_option('EWD_OTP_WooCommerce_Integration', $WooCommerce_Integration);}
	if ($EWD_OTP_Full_Version == "Yes") {update_option('EWD_OTP_Display_Graphic', $Display_Graphic);}
	if ($EWD_OTP_Full_Version == "Yes") {update_option('EWD_OTP_Mobile_Stylesheet', $Mobile_Stylesheet);}
}

function Update_EWD_OTP_Email_Settings() {
	$Admin_Email = $_POST['admin_email'];
	$From_Name = $_POST['from_name'];
	$Message_Body = $_POST['message_body'];
	$Subject_Line = $_POST['subject_line'];
	$Tracking_Page = $_POST['tracking_page'];
	$SMTP_Mail_Server = $_POST['smtp_mail_server'];
	$Use_SMTP = $_POST['use_smtp'];
	$Port = $_POST['port'];
	$Username = $_POST['username'];
	$Admin_Password = $_POST['admin_password'];
	$Encryption_Type = $_POST['encryption_type'];
		
	$Admin_Email = stripslashes_deep($Admin_Email);
	$From_Name = stripslashes_deep($From_Name);
	$Message_Body = stripslashes_deep($Message_Body);
	$Subject_Line = stripslashes_deep($Subject_Line);
	$Tracking_Page = stripslashes_deep($Tracking_Page);
	$SMTP_Mail_Server = stripslashes_deep($SMTP_Mail_Server);
	$Use_SMTP = stripslashes_deep($Use_SMTP);
	$Port = stripslashes_deep($Port);
	$Username = stripslashes_deep($Username);
	$Admin_Password = stripslashes_deep($Admin_Password);
	$Encryption_Type = stripslashes_deep($Encryption_Type);
		
	$key = 'EWD_OTP';
	if (function_exists('mcrypt_decrypt')) {$Encrypted_Admin_Password = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $Admin_Password, MCRYPT_MODE_CBC, md5(md5($key))));}
	else {$Encrypted_Admin_Password = $Admin_Password;}
		
	update_option('EWD_OTP_Admin_Email', $Admin_Email);
	update_option('EWD_OTP_From_Name', $From_Name);
	update_option('EWD_OTP_Message_Body', $Message_Body);
	update_option('EWD_OTP_Subject_Line', $Subject_Line);
	update_option('EWD_OTP_Tracking_Page', $Tracking_Page);
	update_option('EWD_OTP_SMTP_Mail_Server', $SMTP_Mail_Server);
	update_option('EWD_OTP_Use_SMTP', $Use_SMTP);
	update_option('EWD_OTP_Port', $Port);
	update_option('EWD_OTP_Username', $Username);
	update_option('EWD_OTP_Admin_Password', $Encrypted_Admin_Password);
	update_option('EWD_OTP_Encryption_Type', $Encryption_Type);
}
?>