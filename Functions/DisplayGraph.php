<?php
function EWD_OTP_Display_Graph($OrderNumber) {

	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
	$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s'", $OrderNumber));
	
	$Display_Graphic = get_option("EWD_OTP_Display_Graphic");

	$StatusString = get_option("EWD_OTP_Statuses");
	$PercentageString = get_option("EWD_OTP_Percentages");
	$Statuses = explode(",", $StatusString);
	$Percentages = explode(",", $PercentageString);
	
	foreach ($Statuses as $key => $Status) {
		if ($Order->Order_Status == $Status) {$CurrentStatus = $Status; $CurrentPercent = $Percentages[$key];}
		elseif ($key == 0) {$StartingStatus = $Status; $StartingPercent = $Percentages[$key];}
		elseif (($key+1) == sizeOf($Statuses)) {$EndingStatus = $Status; $EndingPercent = $Percentages[$key];}
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
			$ReturnString .= "";
			$ReturnString .= "<div class='ewd-otp-empty-display'>";
			$ReturnString .= "<img src='" .$plugins_url ."/DevelopmentFour/wp-content/plugins/order-tracking/images/" . $Display_Graphic .".png' style='width: 100%'/></div>";
			$ReturnString .= "<div class='ewd-otp-full-display' style='width:" . $CurrentPercent . "%'>";
	 		$ReturnString .= "<img src='" .$plugins_url ."/DevelopmentFour/wp-content/plugins/order-tracking/images/" . $Display_Graphic ."_Full.png' style='width: 100%; max-width: initial;'/></div>";
			$ReturnString .= "</div>";
			$ReturnString .= "<div class='ewd-otp-statuses'>";
			$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-initial-status'>" . $StartingStatus . "</div>";
	    	$ReturnString .= "<div class='ewd-otp-display-status ewd-otp-current-status-length-" . $DisplayLength . "' id='ewd-otp-current-status'>" . $CurrentStatus . "</div>";
	    	$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-ending-status'>" . $EndingStatus . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "<script>";
			$ReturnString .= "function resizeImage() {";
	  		$ReturnString .= "var imgEmpty = jQuery('.ewd-otp-empty-display > img');";
	  		$ReturnString .= "var imgFull = jQuery('.ewd-otp-full-display > img');";
	  		$ReturnString .= "imgFull.width(imgEmpty.width());";
			$ReturnString .= "jQuery('.ewd-otp-status-graphic').height(imgEmpty.height());";
	  		$ReturnString .= "}";  
	    	$ReturnString .= "jQuery(window).resize(resizeImage);";
	    	$ReturnString .= "jQuery('.ewd-otp-empty-display > img').load(resizeImage);";
	  		$ReturnString .= "</script>";
		} else {
	  		$ReturnString .= "<div id='ewd-otp-progressbar-" . $Display_Graphic . "'><div class='" . $Display_Graphic . "' style='width: " . $CurrentPercent . "%'></div></div>";
	  		$ReturnString .= "<div class='ewd-otp-statuses'>";
	  		$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-initial-status'>" . $StartingStatus . "</div>";
	  		$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-current-status' style='margin-left: " . $CurrentPercent . "%'> " . $CurrentStatus . "</div>";
	  		$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-ending-status' style='margin-top: -20px'>" . $EndingStatus . "</div>";
	  		$ReturnString .= "</div>";
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
