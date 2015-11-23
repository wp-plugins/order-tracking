<?php
function EWD_OTP_Display_Graph($OrderNumber) {

	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
	$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s'", $OrderNumber));
	
	$Display_Graphic = get_option("EWD_OTP_Display_Graphic");

	$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
	
	if (!is_array($Statuses_Array)) {$Statuses_Array = array();}
	foreach ($Statuses_Array as $Status_Array_Item) {if ($Status_Array_Item['Internal'] != "Yes") {$Filtered_Statuses_Array[] = $Status_Array_Item;}}
	foreach ($Filtered_Statuses_Array as $key => $Status_Array_Item) {
		if ($Order->Order_Status == $Status_Array_Item['Status']) {$CurrentStatus = $Status_Array_Item['Status']; $CurrentPercent = $Status_Array_Item['Percentage'];}
		elseif ($key == 0) {$StartingStatus = $Status_Array_Item['Status']; $StartingPercent = $Status_Array_Item['Percentage'];}
		elseif (($key+1) == sizeOf($Filtered_Statuses_Array)) {$EndingStatus = $Status_Array_Item['Status']; $EndingPercent = $Status_Array_Item['Percentage'];}
	}
		
	$Browser = get_user_browser();
	 
	if ($Browser == "ie") {
	     	$DisplayLength = round($CurrentPercent / 100, 1) * 10;
		$ReturnString .= "<div class='ie-ewd-otp-empty-display ie-empty-graphic-" . $Display_Graphic . "'></div>";
	 		$ReturnString .= "<div class='ie-ewd-otp-full-display ie-full-graphic-" . $Display_Graphic . " ie-ewd-otp-display-length-" . $DisplayLength . "'></div>";
	 		$ReturnString .= "<div class='ie-ewd-otp-display-status' id='ie-ewd-otp-initial-status'>" . $StartingStatus . "</div>";
		$ReturnString .= "<div class='ie-ewd-otp-display-status ie-ewd-otp-current-status-length-" . $DisplayLength . "' id='ie-ewd-otp-current-status'>" . $CurrentStatus . "</div>";
		$ReturnString .= "<div class='ie-ewd-otp-display-status' id='ie-ewd-otp-ending-status'>" . $EndingStatus . "</div>";
	} else {
		if (($Display_Graphic == "Default") or ($Display_Graphic == "Streamlined") or ($Display_Graphic == "Sleek")) {  
			$DisplayLength = round($CurrentPercent / 100, 1) * 10;
			$ReturnString .= "<div class='ewd-otp-empty-display'>";
			$ReturnString .= "<img src='" . EWD_OTP_CD_PLUGIN_URL . "images/" . $Display_Graphic .".png' style='width: 100%'/></div>";
			$ReturnString .= "<div class='ewd-otp-full-display' style='width:" . $CurrentPercent . "%'>";
	 		$ReturnString .= "<img src='" . EWD_OTP_CD_PLUGIN_URL ."images/" . $Display_Graphic ."_Full.png' style='width: 100%; max-width: initial;'/></div>";
			$ReturnString .= "</div>";
			$ReturnString .= "<div class='ewd-otp-statuses'>";
			$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-initial-status'>" . $StartingStatus . "</div>";
	    	$ReturnString .= "<div class='ewd-otp-display-status ewd-otp-current-status-length-" . $DisplayLength . "' id='ewd-otp-current-status'>" . $CurrentStatus . "</div>";
	    	$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-ending-status'>" . $EndingStatus . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "<div class='ewd-otp-clear'></div>";
		} else {
			if ($StartingStatus == $CurrentStatus or $EndingStatus == $CurrentStatus) {
				$ReturnString .= "<div id='ewd-otp-progressbar-" . $Display_Graphic . "'><div class='" . $Display_Graphic . "' style='width: " . $CurrentPercent . "%'></div></div>";
				$ReturnString .= "<div class='ewd-otp-statuses'>";
				$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-initial-status'>" . $StartingStatus . "</div>";
				$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-ending-status'>" . $EndingStatus . "</div>";
				$ReturnString .= "</div>";
			} else if ($CurrentPercent >= 75 && $EndingStatus != $CurrentStatus) {
				$ReturnString .= "<div id='ewd-otp-progressbar-" . $Display_Graphic . "'><div class='" . $Display_Graphic . "' style='width: " . $CurrentPercent . "%'></div></div>";
				$ReturnString .= "<div class='ewd-otp-statuses'>";
				$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-initial-status'>" . $StartingStatus . "</div>";
				$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-current-status' style='margin-left: 55%'> " . $CurrentStatus . "</div>";
				$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-ending-status'>" . $EndingStatus . "</div>";
				$ReturnString .= "</div>";
			} else if ($CurrentPercent <= 25) {
				$ReturnString .= "<div id='ewd-otp-progressbar-" . $Display_Graphic . "'><div class='" . $Display_Graphic . "' style='width: " . $CurrentPercent . "%'></div></div>";
				$ReturnString .= "<div class='ewd-otp-statuses'>";
				$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-initial-status'>" . $StartingStatus . "</div>";
				$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-current-status' style='margin-left: 5%'> " . $CurrentStatus . "</div>";
				$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-ending-status'>" . $EndingStatus . "</div>";
				$ReturnString .= "</div>";
			} else {
				$ReturnString .= "<div id='ewd-otp-progressbar-" . $Display_Graphic . "'><div class='" . $Display_Graphic . "' style='width: " . $CurrentPercent . "%'></div></div>";
				$ReturnString .= "<div class='ewd-otp-statuses'>";
				$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-initial-status'>" . $StartingStatus . "</div>";
				$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-current-status' style='margin-left: " . ($CurrentPercent-20) . "%'> " . $CurrentStatus . "</div>";
				$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-ending-status'>" . $EndingStatus . "</div>";
				$ReturnString .= "</div>";
			}
		}
	}

	return $ReturnString;
}

function get_user_browser() {
	$u_agent = $_SERVER['HTTP_USER_AGENT'];
	$ub = '';
	if(preg_match('/MSIE/i',$u_agent))
	{
		$ub = "ie";
	}
	elseif(preg_match('/Firefox/i',$u_agent))
	{
		$ub = "firefox";
	}
	elseif(preg_match('/Safari/i',$u_agent))
	{
		$ub = "safari";
	}
	elseif(preg_match('/Chrome/i',$u_agent))
	{
		$ub = "chrome";
	}
	elseif(preg_match('/Flock/i',$u_agent))
	{
		$ub = "flock";
	}
	elseif(preg_match('/Opera/i',$u_agent))
	{
		$ub = "opera";
	}

    return $ub;
}

?>
