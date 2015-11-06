<?php 
define('EWD_OTP_STYLING_TITLE_FONT_DEFAULT', "");
define('EWD_OTP_STYLING_TITLE_FONT_SIZE_DEFAULT', "");
define('EWD_OTP_STYLING_TITLE_FONT_COLOR_DEFAULT', "");
define('EWD_OTP_STYLING_LABEL_FONT_DEFAULT', "");
define('EWD_OTP_STYLING_LABEL_FONT_SIZE_DEFAULT', "");
define('EWD_OTP_STYLING_LABEL_FONT_COLOR_DEFAULT', "");
define('EWD_OTP_STYLING_CONTENT_FONT_DEFAULT', "");
define('EWD_OTP_STYLING_CONTENT_FONT_SIZE_DEFAULT', "");
define('EWD_OTP_STYLING_CONTENT_FONT_COLOR_DEFAULT', "");
define('EWD_OTP_STYLING_TITLE_MARGIN_DEFAULT', "");
define('EWD_OTP_STYLING_TITLE_PADDING_DEFAULT', "");
define('EWD_OTP_STYLING_BODY_MARGIN_DEFAULT', "");
define('EWD_OTP_STYLING_BODY_PADDING_DEFAULT', "");
define('EWD_OTP_STYLING_BUTTON_FONT_COLOR_DEFAULT', "");
define('EWD_OTP_STYLING_BUTTON_BG_COLOR_DEFAULT', "");
define('EWD_OTP_STYLING_BUTTON_BORDER_DEFAULT', "");
define('EWD_OTP_STYLING_BUTTON_MARGIN_DEFAULT', "");
define('EWD_OTP_STYLING_BUTTON_PADDING_DEFAULT', "");

function EWD_OTP_Set_Default_Style_Values() {
	update_option("EWD_OTP_Styling_Title_Font", EWD_OTP_STYLING_TITLE_FONT_DEFAULT); 
	update_option("EWD_OTP_Styling_Title_Font_Size", EWD_OTP_STYLING_TITLE_FONT_SIZE_DEFAULT); 
	update_option("EWD_OTP_Styling_Title_Font_Color", EWD_OTP_STYLING_TITLE_FONT_COLOR_DEFAULT); 
	update_option("EWD_OTP_Styling_Label_Font", EWD_OTP_STYLING_LABEL_FONT_DEFAULT); 
	update_option("EWD_OTP_Styling_Label_Font_Size", EWD_OTP_STYLING_LABEL_FONT_SIZE_DEFAULT); 
	update_option("EWD_OTP_Styling_Label_Font_Color", EWD_OTP_STYLING_LABEL_FONT_COLOR_DEFAULT); 
	update_option("EWD_OTP_Styling_Content_Font", EWD_OTP_STYLING_CONTENT_FONT_DEFAULT); 
	update_option("EWD_OTP_Styling_Content_Font_Size", EWD_OTP_STYLING_CONTENT_FONT_SIZE_DEFAULT); 
	update_option("EWD_OTP_Styling_Content_Font_Color", EWD_OTP_STYLING_CONTENT_FONT_COLOR_DEFAULT); 
	update_option("EWD_OTP_Styling_Title_Margin", EWD_OTP_STYLING_TITLE_MARGIN_DEFAULT); 
	update_option("EWD_OTP_Styling_Title_Padding", EWD_OTP_STYLING_TITLE_PADDING_DEFAULT); 
	update_option("EWD_OTP_Styling_Body_Margin", EWD_OTP_STYLING_BODY_MARGIN_DEFAULT); 
	update_option("EWD_OTP_Styling_Body_Padding", EWD_OTP_STYLING_BODY_PADDING_DEFAULT); 
	update_option("EWD_OTP_Styling_Button_Font_Color", EWD_OTP_STYLING_BUTTON_FONT_COLOR_DEFAULT); 
	update_option("EWD_OTP_Styling_Button_Bg_Color", EWD_OTP_STYLING_BUTTON_BG_COLOR_DEFAULT); 
	update_option("EWD_OTP_Styling_Button_Border", EWD_OTP_STYLING_BUTTON_BORDER_DEFAULT); 
	update_option("EWD_OTP_Styling_Button_Margin", EWD_OTP_STYLING_BUTTON_MARGIN_DEFAULT); 
	update_option("EWD_OTP_Styling_Button_Padding", EWD_OTP_STYLING_BUTTON_PADDING_DEFAULT); 
	
	$update = __("Styles have been succesfully reset.", 'OTP');
	return $update;
}

function EWD_OTP_Add_Modified_Styles() {
	$StylesString .="h3.ewd-otp-main-title { ";
		if (get_option("EWD_OTP_Styling_Title_Font") != "") {$StylesString .= "font:" .  get_option("EWD_OTP_Styling_Title_Font") . " !important;";} 
		if (get_option("EWD_OTP_Styling_Title_Font_Size") != "") {$StylesString .="font-size:" . get_option("EWD_OTP_Styling_Title_Font_Size") . " !important;";} 
		if (get_option("EWD_OTP_Styling_Title_Font_Color") != "") {$StylesString .= "color:" . get_option("EWD_OTP_Styling_Title_Font_Color") . " !important;";} 
		if (get_option("EWD_OTP_Styling_Title_Margin") != "") {$StylesString .= "margin:" . get_option("EWD_OTP_Styling_Title_Margin") . " !important;";} 
		if (get_option("EWD_OTP_Styling_Title_Padding") != "") {$StylesString .= "padding:" . get_option("EWD_OTP_Styling_Title_Padding") . " !important;";} 
		$StylesString .="}\n";
	$StylesString .=".ewd-otp-order-label, .ewd-otp-status-label div { ";
		if (get_option("EWD_OTP_Styling_Label_Font") != "") {$StylesString .= "font:" .  get_option("EWD_OTP_Styling_Label_Font");} 
		if (get_option("EWD_OTP_Styling_Label_Font_Size") != "") {$StylesString .="font-size:" . get_option("EWD_OTP_Styling_Label_Font_Size") . ";";} 
		if (get_option("EWD_OTP_Styling_Label_Font_Color") != "") {$StylesString .= "color:" . get_option("EWD_OTP_Styling_Label_Font_Color") . ";";} 
		if (get_option("EWD_OTP_Styling_Body_Margin") != "") {$StylesString .= "margin:" . get_option("EWD_OTP_Styling_Body_Margin") . ";";} 
		if (get_option("EWD_OTP_Styling_Body_Padding") != "") {$StylesString .= "padding:" . get_option("EWD_OTP_Styling_Body_Padding") . ";";} 
			$StylesString .="}\n";
	$StylesString .=".ewd-otp-order-content div, .ewd-otp-status-label-content div { ";
		if (get_option("EWD_OTP_Styling_Content_Font") != "") {$StylesString .= "font:" .  get_option("EWD_OTP_Styling_Content_Font");} 
		if (get_option("EWD_OTP_Styling_Content_Font_Size") != "") {$StylesString .="font-size:" . get_option("EWD_OTP_Styling_Content_Font_Size") . ";";} 
		if (get_option("EWD_OTP_Styling_Content_Font_Color") != "") {$StylesString .= "color:" . get_option("EWD_OTP_Styling_Content_Font_Color") . ";";} 
		if (get_option("EWD_OTP_Styling_Body_Margin") != "") {$StylesString .= "margin:" . get_option("EWD_OTP_Styling_Body_Margin") . ";";} 
		if (get_option("EWD_OTP_Styling_Body_Padding") != "") {$StylesString .= "padding:" . get_option("EWD_OTP_Styling_Body_Padding") . ";";} 
		$StylesString .="}\n";
	$StylesString .=".ewd-otp-submit { ";
		if (get_option("EWD_OTP_Styling_Content_Font_Color") != "") {$StylesString .= "color:" . get_option("EWD_OTP_Styling_Content_Font_Color") . " !important;";} 
		if (get_option("EWD_OTP_Styling_Button_Bg_Color") != "") {$StylesString .= "background-color:" . get_option("EWD_OTP_Styling_Button_Bg_Color") . " !important;";} 
		if (get_option("EWD_OTP_Styling_Button_Border") != "") {$StylesString .= "border:" . get_option("EWD_OTP_Styling_Button_Border") . " !important;";} 
		if (get_option("EWD_OTP_Styling_Button_Margin") != "") {$StylesString .= "margin:" . get_option("EWD_OTP_Styling_Button_Margin") . " !important;";} 
		if (get_option("EWD_OTP_Styling_Button_Padding") != "") {$StylesString .= "padding:" . get_option("EWD_OTP_Styling_Button_Padding") . " !important;";} 
		$StylesString .="}\n";
return $StylesString;
}