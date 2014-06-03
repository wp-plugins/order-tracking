<?php
function Add_Edit_EWD_OTP_Order() {
		global $wpdb, $EWD_OTP_orders_table_name;
		
		$Order_Email = get_option("EWD_OTP_Order_Email");
		
		$Order_ID = $_POST['Order_ID'];
		$Order_Name = $_POST['Order_Name'];
		$Order_Number = $_POST['Order_Number'];
		$Order_Status = $_POST['Order_Status'];
		$Order_Notes_Public = $_POST['Order_Notes_Public'];
		$Order_Notes_Private = $_POST['Order_Notes_Private'];
		$Order_Email_Address = $_POST['Order_Email'];
		$Order_Display = $_POST['Order_Display'];
		$Order_Status_Updated = date("Y-m-d H:i:s"); 

		if (!isset($error)) {
				// Pass the data to the appropriate function in Update_Admin_Databases.php to create the product 
				if ($_POST['action'] == "Add_Order") {
					  $user_update = Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Email_Address, $Order_Status, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated);
						if (($Order_Email == "Change" or $Order_Email == "Creation") and $Order_Email_Address != "") {EWD_OTP_Send_Email($Order_Email_Address, $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, "Yes");}
				}
				// Pass the data to the appropriate function in Update_Admin_Databases.php to edit the product 
				else {
						$user_update = Edit_EWD_OTP_Order($Order_ID, $Order_Name, $Order_Number, $Order_Email_Address, $Order_Status, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated);
						if ($Order_Email == "Change" and $Order_Email_Address != "") {EWD_OTP_Send_Email($Order_Email_Address, $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated);}
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

function EWD_OTP_Send_Email($Order_Email, $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Created = "No") {
		$Admin_Email = get_option("EWD_OTP_Admin_Email");
		$Encrypted_Admin_Password = get_option("EWD_OTP_Admin_Password");
		$SMTP_Mail_Server = get_option("EWD_OTP_SMTP_Mail_Server");
		$Message_Body = get_option("EWD_OTP_Message_Body");
		
		$key = 'EWD_OTP';
		$Admin_Password = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($Encrypted_Admin_Password), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
		
		$Message_Body = str_replace("[order-number]", $Order_Number, $Message_Body);
		$Message_Body = str_replace("[order-status]", $Order_Status, $Message_Body);
		$Message_Body = str_replace("[order-notes]", $Order_Notes_Public, $Message_Body);
		$Message_Body = str_replace("[order-time]", $Order_Status_Updated, $Message_Body);
		
		if ($SMTP_Mail_Server != "") {
				require_once(EWD_OTP_CD_PLUGIN_PATH . '/PHPMailer/class.phpmailer.php');
				$mail = new PHPMailer(true);
				try {
  					$mail->CharSet = 'UTF-8';
						$mail->IsSMTP();
  					$mail->Host = $SMTP_Mail_Server;
  					$mail->SMTPAuth = true;
  					$mail->Username = $Admin_Email;
  					$mail->Password = $Admin_Password;
  					$mail->WordWrap = 0;
  					$mail->AddCustomHeader('X-Mailer: EWD_OTP v1.0');
  					$mail->SetFrom($Admin_Email);
  					$mail->AddAddress($Order_Email);
  					$mail->Subject = "Order Update";
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
		$Orders = $_POST['Orders_Bulk'];
		$Status = $_POST['action'];
		$Update_Time = date("Y-m-d H:i:s");
		
		if (is_array($Orders)) {
				foreach ($Orders as $Order) {
						if ($Order != "") {
								Update_EWD_OTP_Order_Status($Order, $Status, $Update_Time);
						}
				}
		}
		
		$update = __("Orders have been successfully hidden.", 'EWD_OTP');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

?>
