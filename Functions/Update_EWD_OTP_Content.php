<?php
/* This file is the action handler. The appropriate function is then called based 
*  on the action that's been selected by the user. The functions themselves are all
* stored either in Prepare_Data_For_Insertion.php or Update_Admin_Databases.php */

function Update_EWD_OTP_Content() {
global $ewd_otp_message;
if (isset($_GET['Action'])) {
				switch ($_GET['Action']) {
    				case "UpdateStatuses":
        				$ewd_otp_message = Update_EWD_OTP_Statuses();
								break;
						case "DeleteStatus":
        				$ewd_otp_message = Delete_EWD_OTP_Status($_GET['Status']);
								break;
						case "UpdateOptions":
        				$ewd_otp_message = Update_EWD_OTP_Options();
								break;
						case "AddOrderSpreadsheet":
        				$ewd_otp_message = Add_Orders_From_Spreadsheet();
								break;
						case "UpdateEmailSettings":
        				$ewd_otp_message = Update_EWD_OTP_Email_Settings();
								break;
						case "AddOrder":
						case "EditOrder":
        				$ewd_otp_message = Add_Edit_EWD_OTP_Order();
								break;
						case "DeleteOrder":
        				$ewd_otp_message = Delete_EWD_OTP_Order($_POST['Order_ID']);
								break;
						case "MassAction":
        				$ewd_otp_message = Mass_EWD_OTP_Action();
								break;
						default:
								$ewd_otp_message = __("The form has not worked correctly. Please contact the plugin developer.", 'EWD_OTP');
								break;
				}
		}
}

?>