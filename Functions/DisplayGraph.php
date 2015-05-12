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
		
	/*$TotalLength = 365;
	
	$XStart = 85;
	$YStart = 42;
	$YEnd = 70;
	
	if ($CurrentPercent == 100) {$image = imagecreatefrompng(plugin_dir_path( __FILE__ ) . "../images/Arrow_Full.png");}
	else {
			$image = imagecreatefrompng(plugin_dir_path( __FILE__ ) . "../images/Arrow.png");
			
			$turqoise = imagecolorallocate($image, 99, 198, 174);
			
			$CurrentLength = ($TotalLength / 100) * $CurrentPercent;
			
			$XEnd = $XStart + $CurrentLength;
			$XStatus = round(min(($TotalLength+$XStart-($TotalLength/3)), max(($XStart+($TotalLength/3)), $XEnd)),0);
			
			imagefilledrectangle($image, $XStart, $YStart, $XEnd, $YEnd, $turqoise);
	}
	//$image = @imagecreate(600, 140) or die("Cannot Initialize new GD image stream");
	
	imagealphablending($image, false);
	$transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
	imagefill($image, 0, 0, $transparent);
	imagesavealpha($image,true);
	imagealphablending($image, true);
	
	$black = imagecolorallocate($image, 0, 0, 0);
	
	imagestring($image, 5, $XStart-20, $YEnd+40, $StartingStatus, $black);
	imagestring($image, 5, $XEnd+35, $YEnd+40, $EndingStatus, $black);
	if ($CurrentPercent != 100) {imagestring($image, 5, $XStatus, $YEnd+40, $CurrentStatus, $black);}
  	imagepng($image);
	imagedestroy($image);
	*/

	$DisplayLength = round($CurrentPercent / 100, 1) * 10;

	$ReturnString .= "<div class='ewd-otp-empty-display empty-graphic-" . $Display_Graphic . "'></div>";
	$ReturnString .= "<div class='ewd-otp-full-display full-graphic-" . $Display_Graphic . " ewd-otp-display-length-" . $DisplayLength . "'></div>";
	$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-initial-status'>" . $StartingStatus . "</div>";
	$ReturnString .= "<div class='ewd-otp-display-status ewd-otp-current-status-length-" . $DisplayLength . "' id='ewd-otp-current-status'>" . $CurrentStatus . "</div>";
	$ReturnString .= "<div class='ewd-otp-display-status' id='ewd-otp-ending-status'>" . $EndingStatus . "</div>";

	return $ReturnString;
}

?>
