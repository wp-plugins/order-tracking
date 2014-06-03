<?php
/* This file is the action handler. The appropriate function is then called based 
*  on the action that's been selected by the user. The functions themselves are all
* stored either in Prepare_Data_For_Insertion.php or Update_Admin_Databases.php */

function Update_EWD_OTP_Content() {
global $ewd_otp_message;
if (isset($_GET['Action'])) {
				switch ($_GET['Action']) {
    				case "UpdateStatuses":
        				$message = Update_EWD_OTP_Statuses();
								break;
						case "DeleteStatus":
        				$message = Delete_EWD_OTP_Status($_GET['Status']);
								break;
						case "UpdateOptions":
        				$message = Update_EWD_OTP_Options();
								break;
						case "UpdateEmailSettings":
        				$message = Update_EWD_OTP_Email_Settings();
								break;
						case "AddOrder":
						case "EditOrder":
        				$message = Add_Edit_EWD_OTP_Order();
								break;
						case "DeleteOrder":
        				$message = Delete_EWD_OTP_Order($_POST['Order_ID']);
								break;
						case "MassAction":
        				$message = Mass_EWD_OTP_Action();
								break;
						default:
								$message = __("The form has not worked correctly. Please contact the plugin developer.", 'EWD_OTP');
								break;
				}
		}
}

?>