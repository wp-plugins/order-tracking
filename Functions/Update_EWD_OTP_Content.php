<?php
/* This file is the action handler. The appropriate function is then called based 
*  on the action that's been selected by the user. The functions themselves are all
* stored either in Prepare_Data_For_Insertion.php or Update_Admin_Databases.php */

function Update_EWD_OTP_Content() {
global $ewd_otp_message;
if (isset($_GET['Action'])) {
				switch ($_GET['Action']) {
    				case "EWD_OTP_UpdateStatuses":
        				$ewd_otp_message = Update_EWD_OTP_Statuses();
								break;
						case "EWD_OTP_DeleteStatus":
        				$ewd_otp_message = Delete_EWD_OTP_Status($_GET['Status']);
								break;
						case "EWD_OTP_UpdateOptions":
        				$ewd_otp_message = Update_EWD_OTP_Options();
								break;
						case "EWD_OTP_AddOrderSpreadsheet":
        				$ewd_otp_message = Add_Orders_From_Spreadsheet();
								break;
						case "EWD_OTP_UpdateEmailSettings":
        				$ewd_otp_message = Update_EWD_OTP_Email_Settings();
								break;
						case "EWD_OTP_AddOrder":
						case "EWD_OTP_EditOrder":
        				$ewd_otp_message = Add_Edit_EWD_OTP_Order();
								break;
						case "EWD_OTP_DeleteOrder":
        				$ewd_otp_message = Delete_EWD_OTP_Order($_POST['Order_ID']);
								break;
						case "EWD_OTP_MassAction":
        				$ewd_otp_message = Mass_EWD_OTP_Action();
								break;
						default:
								$ewd_otp_message = __("The form has not worked correctly. Please contact the plugin developer.", 'EWD_OTP');
								break;
				}
		}
}

?>