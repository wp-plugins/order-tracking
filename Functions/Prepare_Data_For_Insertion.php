<?php
function Add_Edit_EWD_OTP_Order() {
		global $wpdb, $EWD_OTP_orders_table_name, $EWD_OTP_customers;
		
		$Order_Email = get_option("EWD_OTP_Order_Email");
		$Timezone = get_option("EWD_OTP_Timezone");
		date_default_timezone_set($Timezone);

		$Order_ID = $_POST['Order_ID'];
		$Order_Name = $_POST['Order_Name'];
		$Order_Number = $_POST['Order_Number'];
		$Order_Status = $_POST['Order_Status'];
		$Order_Location = $_POST['Order_Location'];
		$Order_Notes_Public = $_POST['Order_Notes_Public'];
		$Order_Notes_Private = $_POST['Order_Notes_Private'];
		$Order_Email_Address = $_POST['Order_Email'];
		$Order_Display = $_POST['Order_Display'];
		$Customer_ID = $_POST['Customer_ID'];
		$Sales_Rep_ID = $_POST['Sales_Rep_ID'];
		$Order_Status_Updated = date("Y-m-d H:i:s"); 

		if (!isset($error)) {
				// Pass the data to the appropriate function in Update_Admin_Databases.php to create the product 
				if ($_POST['action'] == "Add_Order") {
					  $user_update = Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Email_Address, $Order_Status, $Order_Location, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID);
						if (($Order_Email == "Change" or $Order_Email == "Creation") and $Order_Email_Address != "") {EWD_OTP_Send_Email($Order_Email_Address, $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Order_Name, "Yes");}
				}
				// Pass the data to the appropriate function in Update_Admin_Databases.php to edit the product 
				else {
						$user_update = Edit_EWD_OTP_Order($Order_ID, $Order_Name, $Order_Number, $Order_Email_Address, $Order_Status, $Order_Location, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID);
						if ($Order_Email == "Change" and $Order_Email_Address != "") {EWD_OTP_Send_Email($Order_Email_Address, $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Order_Name);}
				}
				$user_update = array("Message_Type" => "Update", "Message" => $user_update);
				return $user_update;
		}
		// Return any error that might have occurred 
		else {
				$output_error = array("Message_Type" => "Error", "Message" => $error);
				return $output_error;
		}
}

function EWD_OTP_Save_Customer_Note() {
	$Tracking_Number = $_POST['CN_Order_Number'];
	$Note = sanitize_text_field(stripslashes_deep($_POST['Customer_Notes']));

	$user_update = Update_EWD_OTP_Customer_Note($Tracking_Number, $Note);

	return $user_update;
}

function EWD_OTP_Save_Customer_Order($Success_Message, $Order_Status = "", $Order_Location = "") {
	$Order_Name = sanitize_text_field(stripslashes_deep($_POST['Order_Name']));
	$Order_Email_Address = sanitize_text_field(stripslashes_deep($_POST['Order_Email_Address']));
	$Note = sanitize_text_field(stripslashes_deep($_POST['Customer_Notes']));

	$Order_Number = __('Order', 'EWD_OTP') . EWD_OTP_RandomString(5);

	$Order_Notes_Public = "";
	$Order_Notes_Private = "";
	$Order_Display = "Yes";
	$Order_Status_Updated = date("Y-m-d H:i:s"); 
	$Customer_ID = 0;
	$Sales_Rep_ID = 0;

	$message = Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Email_Address, $Order_Status, $Order_Location, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID);

	if ($message == __("Order has been successfully created.", 'EWD_OTP')) {
		Update_EWD_OTP_Customer_Note($Order_Number, $Note);
		$user_update['Message_Type'] = "Update";
		$user_update['Message'] = $Success_Message . $Order_Number;
	}

	return $user_update;
}

function Add_Edit_EWD_OTP_Sales_Rep() {
		global $wpdb, $EWD_OTP_sales_reps;

		$Sales_Rep_ID = $_POST['Sales_Rep_ID'];
		$Sales_Rep_First_Name = $_POST['Sales_Rep_First_Name'];
		$Sales_Rep_Last_Name = $_POST['Sales_Rep_Last_Name'];
		$Sales_Rep_WP_ID = $_POST['Sales_Rep_WP_ID'];
		$Sales_Rep_Created = date("Y-m-d H:i:s"); 

		if (!isset($error)) {
				// Pass the data to the appropriate function in Update_Admin_Databases.php to create the product 
				if ($_POST['action'] == "Add_Sales_Rep") {
					  $user_update = Add_EWD_OTP_Sales_Rep($Sales_Rep_First_Name, $Sales_Rep_Last_Name, $Sales_Rep_WP_ID, $Sales_Rep_Created);
				}
				// Pass the data to the appropriate function in Update_Admin_Databases.php to edit the product 
				else {
						$user_update = Edit_EWD_OTP_Sales_Rep($Sales_Rep_ID, $Sales_Rep_First_Name, $Sales_Rep_Last_Name, $Sales_Rep_WP_ID);
				}
				$user_update = array("Message_Type" => "Update", "Message" => $user_update);
				return $user_update;
		}
		// Return any error that might have occurred 
		else {
				$output_error = array("Message_Type" => "Error", "Message" => $error);
				return $output_error;
		}
}

function Add_Edit_EWD_OTP_Customer() {
		global $wpdb, $EWD_OTP_customers;

		$Customer_ID = $_POST['Customer_ID'];
		$Customer_Name = $_POST['Customer_Name'];
		$Customer_Email = $_POST['Customer_Email'];
		$Sales_Rep_ID = $_POST['Sales_Rep_ID'];
		$Customer_Created = date("Y-m-d H:i:s"); 

		if (!isset($error)) {
				// Pass the data to the appropriate function in Update_Admin_Databases.php to create the product 
				if ($_POST['action'] == "Add_Customer") {
					  $user_update = Add_EWD_OTP_Customer($Customer_Name, $Customer_Email, $Sales_Rep_ID, $Customer_Created);
				}
				// Pass the data to the appropriate function in Update_Admin_Databases.php to edit the product 
				else {
						$user_update = Edit_EWD_OTP_Customer($Customer_ID, $Customer_Name, $Customer_Email, $Sales_Rep_ID);
				}
				$user_update = array("Message_Type" => "Update", "Message" => $user_update);
				return $user_update;
		}
		// Return any error that might have occurred 
		else {
				$output_error = array("Message_Type" => "Error", "Message" => $error);
				return $output_error;
		}
}

function EWD_OTP_Send_Email($Order_Email, $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Order_Name, $Created = "No") {
	global $wpdb, $EWD_OTP_orders_table_name, $EWD_OTP_customers, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $EWD_OTP_sales_reps;
		
	$Admin_Email = get_option("EWD_OTP_Admin_Email");
	$From_Name = get_option("EWD_OTP_From_Name");
	$Username = get_option("EWD_OTP_Username");
	$Encrypted_Admin_Password = get_option("EWD_OTP_Admin_Password");
	$Port = get_option("EWD_OTP_Port");
	$Use_SMTP = get_option("EWD_OTP_Use_SMTP");
	$SMTP_Mail_Server = get_option("EWD_OTP_SMTP_Mail_Server");
	$Encryption_Type = get_option("EWD_OTP_Encryption_Type");
	$Message_Body = get_option("EWD_OTP_Message_Body");
    $Subject_Line = get_option("EWD_OTP_Subject_Line"); 
    $Tracking_Page = get_option("EWD_OTP_Tracking_Page");
		
	$key = 'EWD_OTP';
	$Admin_Password = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($Encrypted_Admin_Password), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	if ($Port == "") {$Port= '25';}
	if ($Encryption_Type == "") {$Encryption_Type = "ssl";}
	if ($From_Name == "") {$From_Name = $Admin_Email;}

	$Order_Info = $wpdb->get_row($wpdb->prepare("SELECT Order_ID, Customer_ID, Sales_Rep_ID FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s'", $Order_Number));
	$Customer_Name = $wpdb->get_var($wpdb->prepare("SELECT Customer_Name FROM $EWD_OTP_customers WHERE Customer_ID='%d'", $Order_Info->Customer_ID));
	$Sales_Rep = $wpdb->get_row($wpdb->prepare("SELECT Sales_Rep_First_Name, Sales_Rep_Last_Name FROM $EWD_OTP_sales_reps WHERE Sales_Rep_ID='%d'", $Order_Info->Sales_Rep_ID));
	$Sales_Rep_Name = $Sales_Rep->Sales_Rep_First_Name . " " . $Sales_Rep->Sales_Rep_Last_Name;
	$Tracking_Link = $Tracking_Page . "?Tracking_Number=" . $Order_Number . "&Order_Email=" . $Order_Email;

	$Message_Body = str_replace("[order-number]", $Order_Number, $Message_Body);
	$Message_Body = str_replace("[order-status]", $Order_Status, $Message_Body);
	$Message_Body = str_replace("[order-notes]", $Order_Notes_Public, $Message_Body);
	$Message_Body = str_replace("[order-time]", $Order_Status_Updated, $Message_Body);
    $Message_Body = str_replace("[order-name]", $Order_Name, $Message_Body);
    $Message_Body = str_replace("[customer-name]", $Customer_Name, $Message_Body);
	$Message_Body = str_replace("[sales-rep]", $Sales_Rep_Name, $Message_Body);
	$Message_Body = str_replace("[tracking-link]", $Tracking_Link, $Message_Body);
		
	$Order_Metas = $wpdb->get_results($wpdb->prepare("SELECT Field_ID, Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID='%d'", $Order_Info->Order_ID));
	foreach ($Order_Metas as $Order_Meta) {
		$Field_Slug = $wpdb->get_var($wpdb->prepare("SELECT Field_Slug FROM $EWD_OTP_fields_table_name WHERE Field_ID='%d'", $Order_Meta->Field_ID));
		$Message_Body = str_replace("[" . $Field_Slug . "]", $Order_Meta->Meta_Value, $Message_Body);
	}
	
	$Emails = explode(",", $Order_Email);
	foreach ($Emails as $Email) {
		if ($SMTP_Mail_Server != "") {
			require_once(EWD_OTP_CD_PLUGIN_PATH . '/PHPMailer/class.phpmailer.php');
			$mail = new PHPMailer(true);
			try {
  				$mail->CharSet = 'UTF-8';
				if ($Use_SMTP != "No") {
					$mail->IsSMTP();
					$mail->SMTPAuth = true;
					$mail->Username = $Username;
  					$mail->Password = $Admin_Password; 
				}
  				$mail->Host = $SMTP_Mail_Server;
  				$mail->Port = $Port;
  				$mail->WordWrap = 0;
  				$mail->AddCustomHeader('X-Mailer: EWD_OTP v1.0');
  				$mail->SetFrom($Admin_Email, $From_Name);
  				$mail->AddAddress($Email);
  				$mail->Subject = $Subject_Line;
				$mail->Body = $Message_Body;
				$mail->isHTML(true);
  				//$mail->AltBody = $Text;
  				
				if (!$mail->Send()) {
					//echo "Email not sent.<br>";
    				//echo $mail->ErrorInfo;
  				} else {
    				//echo "Email sent.<br>";
  				}
			} catch (phpmailerException $e) {
    		 	//echo "FAIL:\n";
    			//echo $e->errorMessage(); // from PHPMailer
			} catch (Exception $e) {
    			//echo "FAIL:\n";
    			//echo $e->getMessage(); // from anything else!
			}		
			}
		else {
			$headers = 'From: ' . $Admin_Email . "\r\n" .
    					'Reply-To: ' . $Admin_Email . "\r\n" .
    					'X-Mailer: PHP/' . phpversion();
			$Mail_Success = mail($Order_Email, "Order Update", $Message_Body, $headers);
		}
	}
}

/* Prepare the data to add multiple products from a spreadsheet */
function Add_Orders_From_Spreadsheet() {
		
		/* Test if there is an error with the uploaded spreadsheet and return that error if there is */
		if (!empty($_FILES['Orders_Spreadsheet']['error']))
		{
				switch($_FILES['Orders_Spreadsheet']['error'])
				{

				case '1':
						$error = __('The uploaded file exceeds the upload_max_filesize directive in php.ini', 'EWD_OTP');
						break;
				case '2':
						$error = __('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', 'EWD_OTP');
						break;
				case '3':
						$error = __('The uploaded file was only partially uploaded', 'EWD_OTP');
						break;
				case '4':
						$error = __('No file was uploaded.', 'EWD_OTP');
						break;

				case '6':
						$error = __('Missing a temporary folder', 'EWD_OTP');
						break;
				case '7':
						$error = __('Failed to write file to disk', 'EWD_OTP');
						break;
				case '8':
						$error = __('File upload stopped by extension', 'EWD_OTP');
						break;
				case '999':
						default:
						$error = __('No error code avaiable', 'EWD_OTP');
				}
		}
		/* Make sure that the file exists */ 	 	
		elseif (empty($_FILES['Orders_Spreadsheet']['tmp_name']) || $_FILES['Orders_Spreadsheet']['tmp_name'] == 'none') {
				$error = __('No file was uploaded here..', 'EWD_OTP');
		}
		/* Move the file and store the URL to pass it onwards*/ 	 	
		else {				 
				 	  $msg .= $_FILES['Orders_Spreadsheet']['name'];
						//for security reason, we force to remove all uploaded file
						$target_path = ABSPATH . "wp-content/plugins/order-tracking/order-sheets/";
						//plugins_url("order-tracking/product-sheets/");

						$target_path = $target_path . basename( $_FILES['Orders_Spreadsheet']['name']); 

						if (!move_uploaded_file($_FILES['Orders_Spreadsheet']['tmp_name'], $target_path)) {
						//if (!$upload = wp_upload_bits($_FILES["Item_Image"]["name"], null, file_get_contents($_FILES["Item_Image"]["tmp_name"]))) {
				 			  $error .= "There was an error uploading the file, please try again!";
						}
						else {
				 				$Excel_File_Name = basename( $_FILES['Orders_Spreadsheet']['name']);
						}	
		}

		/* Pass the data to the appropriate function in Update_Admin_Databases.php to create the products */
		if (!isset($error)) {
				$user_update = Add_EWD_OTP_Orders_From_Spreadsheet($Excel_File_Name);
				return $user_update;
		}
		else {
				$output_error = array("Message_Type" => "Error", "Message" => $error);
				return $output_error;
		}
}

function Mass_EWD_OTP_Action() {
		if (isset($_POST['action'])) {
				switch ($_POST['action']) {
						case "hide":
        				$message = Mass_Hide_EWD_OTP_Orders();
								break;
						case "delete":
        				$message = Mass_Delete_EWD_OTP_Orders();
								break;
						case "-1":
								break;
						default:
								$message = Mass_Status_EWD_OTP_Orders();
								break;
				}
		}
}

function Mass_Delete_EWD_OTP_Orders() {
		$Orders = $_POST['Orders_Bulk'];
		
		if (is_array($Orders)) {
				foreach ($Orders as $Order) {
						if ($Order != "") {
								Delete_EWD_OTP_Order($Order);
						}
				}
		}
		
		$update = __("Orders have been successfully deleted.", 'EWD_OTP');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

function Mass_Delete_EWD_OTP_Sales_Reps() {
		$SalesReps = $_POST['Reps_Bulk'];
		
		if (is_array($SalesReps)) {
				foreach ($SalesReps as $SalesRep) {
						if ($SalesRep != "") {
								Delete_EWD_OTP_Sales_Rep($SalesRep);
						}
				}
		}
		
		$update = __("Sales Reps have been successfully deleted.", 'EWD_OTP');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

function Mass_Delete_EWD_OTP_Customers() {
		$Customers = $_POST['Customers_Bulk'];
		
		if (is_array($Customers)) {
				foreach ($Customers as $Customer) {
						if ($Customer != "") {
								Delete_EWD_OTP_Customer($Customer);
						}
				}
		}
		
		$update = __("Customers have been successfully deleted.", 'EWD_OTP');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

function Mass_Hide_EWD_OTP_Orders() {
		$Orders = $_POST['Orders_Bulk'];
		
		if (is_array($Orders)) {
				foreach ($Orders as $Order) {
						if ($Order != "") {
								Hide_EWD_OTP_Order($Order);
						}
				}
		}
		
		$update = __("Orders have been successfully hidden.", 'EWD_OTP');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

function Mass_Status_EWD_OTP_Orders() {
		global $wpdb, $EWD_OTP_orders_table_name;
		$Order_Email = get_option("EWD_OTP_Order_Email");
		
		$Timezone = get_option("EWD_OTP_Timezone");
		date_default_timezone_set($Timezone);
		
		$Orders = $_POST['Orders_Bulk'];
		$Status = $_POST['action'];
		$Update_Time = date("Y-m-d H:i:s");
		
		if (is_array($Orders)) {
				foreach ($Orders as $Order) {
						if ($Order != "") {
								Update_EWD_OTP_Order_Status($Order, $Status, $Update_Time);
								$Order_Info = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_ID='%d'", $Order));
								if ($Order_Email == "Change" and $Order_Info->Order_Email != "") {EWD_OTP_Send_Email($Order_Info->Order_Email, $Order_Info->Order_Number, $Order_Info->Order_Status, $Order_Info->Order_Notes_Public, $Order_Info->Order_Status_Updated, $Order_Info->Order_Name);}
						}
				}
		}
		
		$update = __("Orders have been successfully hidden.", 'EWD_OTP');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

function Add_Edit_EWD_OTP_Custom_Field() {
		/* Process the $_POST data where neccessary before storage */
		$Field_Name = stripslashes_deep($_POST['Field_Name']);
		$Field_Slug = stripslashes_deep($_POST['Field_Slug']);
		$Field_Type = stripslashes_deep($_POST['Field_Type']);
		$Field_Description = stripslashes_deep($_POST['Field_Description']);
		$Field_Values = stripslashes_deep($_POST['Field_Values']);
		$Field_Front_End_Display = stripslashes_deep($_POST['Field_Front_End_Display']);
		$Field_ID = $_POST['Field_ID'];

		if (!isset($error)) {
				/* Pass the data to the appropriate function in Update_Admin_Databases.php to create the custom field */
				if ($_POST['action'] == "Add_Custom_Field") {
					  $user_update = Add_EWD_OTP_Custom_Field($Field_Name, $Field_Slug, $Field_Type, $Field_Description, $Field_Values, $Field_Front_End_Display);
				}
				/* Pass the data to the appropriate function in Update_Admin_Databases.php to edit the custom field */
				else {
						$user_update = Edit_EWD_OTP_Custom_Field($Field_ID, $Field_Name, $Field_Slug, $Field_Type, $Field_Description, $Field_Values, $Field_Front_End_Display);
				}
				$user_update = array("Message_Type" => "Update", "Message" => $user_update);
				return $user_update;
		}
		else {
				$output_error = array("Message_Type" => "Error", "Message" => $error);
				return $output_error;
		}
}

function Mass_Delete_EWD_OTP_Custom_Fields() {
		$Fields = $_POST['Fields_Bulk'];
		
		if (is_array($Fields)) {
				foreach ($Fields as $Field) {
						if ($Field != "") {
								Delete_EWD_OTP_Custom_Field($Field);
						}
				}
		}
		
		$update = __("Field(s) have been successfully deleted.", 'UPCP');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

function EWD_OTP_Handle_File_Upload($Field_Name) {
		
		/* Test if there is an error with the uploaded file and return that error if there is */
		if (!empty($_FILES[$Field_Name]['error']))
		{
				switch($_FILES[$Field_Name]['error'])
				{

				case '1':
						$error = __('The uploaded file exceeds the upload_max_filesize directive in php.ini', 'EWD_OTP');
						break;
				case '2':
						$error = __('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', 'EWD_OTP');
						break;
				case '3':
						$error = __('The uploaded file was only partially uploaded', 'EWD_OTP');
						break;
				case '4':
						$error = __('No file was uploaded.', 'EWD_OTP');
						break;

				case '6':
						$error = __('Missing a temporary folder', 'EWD_OTP');
						break;
				case '7':
						$error = __('Failed to write file to disk', 'EWD_OTP');
						break;
				case '8':
						$error = __('File upload stopped by extension', 'EWD_OTP');
						break;
				case '999':
						default:
						$error = __('No error code avaiable', 'EWD_OTP');
				}
		}
		/* Make sure that the file exists */ 	 	
		elseif (empty($_FILES[$Field_Name]['tmp_name']) || $_FILES[$Field_Name]['tmp_name'] == 'none') {
				$error = __('No file was uploaded here..', 'EWD_OTP');
		}
		/* Move the file and store the URL to pass it onwards*/ 	 	
		else {				 
				 	  $msg .= $_FILES[$Field_Name]['name'];
						//for security reason, we force to remove all uploaded file
						$target_path = ABSPATH . 'wp-content/uploads/order-tracking-uploads/';
						
						//create the uploads directory if it doesn't exist
						if (!file_exists($target_path)) {
							  mkdir($target_path, 0777, true);
						}

						$target_path = $target_path . basename( $_FILES[$Field_Name]['name']); 

						if (!move_uploaded_file($_FILES[$Field_Name]['tmp_name'], $target_path)) {
						//if (!$upload = wp_upload_bits($_FILES["Item_Image"]["name"], null, file_get_contents($_FILES["Item_Image"]["tmp_name"]))) {
				 			  $error .= "There was an error uploading the file, please try again!";
						}
						else {
				 				$User_Upload_File_Name = basename( $_FILES[$Field_Name]['name']);
						}	
		}
		
		/* Return the file name, or the error that was generated. */
		if (isset($error) and $error == __('No file was uploaded.', 'EWD_OTP')) {
			  $Return['Success'] = "N/A";
				$Return['Data'] = __('No file was uploaded.', 'EWD_OTP');
		}
		elseif (!isset($error)) {
				$Return['Success'] = "Yes";
				$Return['Data'] = $User_Upload_File_Name;
		}
		else {
				$Return['Success'] = "No";
				$Return['Data'] = $error;
		}
		return $Return;
}

function EWD_OTP_Delete_All_Orders() {
		global $wpdb;
		global $EWD_OTP_orders_table_name;
		$Orders = $wpdb->get_results("SELECT Order_ID FROM $EWD_OTP_orders_table_name");
		
		if (is_array($Orders)) {
				foreach ($Orders as $Order) {
						if ($Order->Order_ID != "") {
								Delete_EWD_OTP_Order($Order->Order_ID);
						}
				}
		}
		
		$update = __("Orders have been successfully deleted.", 'EWD_OTP');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

function EWD_OTP_RandomString($CharLength = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $CharLength; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

?>
