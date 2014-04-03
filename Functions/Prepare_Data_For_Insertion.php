<?php
function Add_Edit_EWD_OTP_Order() {
		global $wpdb, $EWD_OTP_orders_table_name;
		
		$Order_ID = $_POST['Order_ID'];
		$Order_Name = $_POST['Order_Name'];
		$Order_Number = $_POST['Order_Number'];
		$Order_Status = $_POST['Order_Status'];
		$Order_Display = $_POST['Order_Display'];
		$Order_Status_Updated = date("Y-m-d H:i:s"); 

		if (!isset($error)) {
				// Pass the data to the appropriate function in Update_Admin_Databases.php to create the product 
				if ($_POST['action'] == "Add_Order") {
					  $user_update = Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Status, $Order_Display, $Order_Status_Updated);
				}
				// Pass the data to the appropriate function in Update_Admin_Databases.php to edit the product 
				else {
						$user_update = Edit_EWD_OTP_Order($Order_ID, $Order_Name, $Order_Number, $Order_Status, $Order_Display, $Order_Status_Updated);
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
