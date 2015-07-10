<?php 
	$Custom_CSS = get_option("EWD_OTP_Custom_CSS");
	$AJAX_Reload = get_option("EWD_OTP_AJAX_Reload");
	$New_Window = get_option("EWD_OTP_New_Window");
	$Order_Information_String = get_option("EWD_OTP_Order_Information");
	$Order_Information = explode(",", $Order_Information_String);
	$Form_Instructions = get_option("EWD_OTP_Form_Instructions");
	$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");
	$Timezone = get_option("EWD_OTP_Timezone");
	$Localize_Date_Time = get_option("EWD_OTP_Localize_Date_Time");
	$Order_Email = get_option("EWD_OTP_Order_Email");
	$Access_Role = get_option("EWD_OTP_Access_Role");
	$WooCommerce_Integration = get_option("EWD_OTP_WooCommerce_Integration");
	$Display_Graphic = get_option("EWD_OTP_Display_Graphic");
	$Mobile_Stylesheet = get_option("EWD_OTP_Mobile_Stylesheet");

?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div><h2>Settings</h2>

<form method="post" action="admin.php?page=EWD-OTP-options&DisplayPage=Options&Action=EWD_OTP_UpdateOptions">
<table class="form-table">
<tr>
<th scope="row">Custom CSS</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Custom CSS</span></legend>
	<label title='Custom CSS'></label><textarea class='ewd-otp-textarea' name='custom_css'> <?php echo $Custom_CSS; ?></textarea><br />
	<p>You can add custom CSS styles for your order form in the box above.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Order Information Displayed</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Order Information Displayed</span></legend>
	<label title='Order Number'><input type='checkbox' name='order_information[]' value='Order_Number' <?php if(in_array("Order_Number", $Order_Information)) {echo "checked='checked'";} ?> /> <span>Order Number</span></label><br />
	<label title='Name'><input type='checkbox' name='order_information[]' value='Order_Name' <?php if(in_array("Order_Name", $Order_Information)) {echo "checked='checked'";} ?> /> <span>Name</span></label><br />
	<label title='Status'><input type='checkbox' name='order_information[]' value='Order_Status' <?php if(in_array("Order_Status", $Order_Information)) {echo "checked='checked'";} ?> /> <span>Status</span></label><br />
	<label title='Location'><input type='checkbox' name='order_information[]' value='Order_Location' <?php if(in_array("Order_Location", $Order_Information)) {echo "checked='checked'";} ?> /> <span>Location</span></label><br />
	<label title='Update Date'><input type='checkbox' name='order_information[]' value='Order_Updated' <?php if(in_array("Order_Updated", $Order_Information)) {echo "checked='checked'";} ?> /> <span>Updated Date</span></label><br />
	<label title='Notes'><input type='checkbox' name='order_information[]' value='Order_Notes' <?php if(in_array("Order_Notes", $Order_Information)) {echo "checked='checked'";} ?> /> <span>Notes</span></label><br />
	<label title='Customer_Notes'><input type='checkbox' name='order_information[]' value='Customer_Notes' <?php if(in_array("Customer_Notes", $Order_Information)) {echo "checked='checked'";} ?> /> <span>Customer Notes</span></label><br />
	<label title='Graphic'><input type='checkbox' name='order_information[]' value='Order_Graphic' <?php if(in_array("Order_Graphic", $Order_Information)) {echo "checked='checked'";} ?> /> <span>Status Graphic</span></label><br />
	<?php  
		$Sql = "SELECT * FROM $EWD_OTP_fields_table_name";
		$Fields = $wpdb->get_results($Sql);
		foreach ($Fields as $Field) {
			echo "<label title='" . $Field->Field_ID . "'><input type='checkbox' name='order_information[]' value='" . $Field->Field_ID . "'";
			if (in_array($Field->Field_ID, $Order_Information)) {echo "checked='checked'";}
			echo "/> <span>" . $Field->Field_Name . "</span></label><br />";
		}
	?>
	<p>Select what information should be displayed for each order.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Order Form Instructions</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Order Form Instructions</span></legend>
	<label title='Form Instructions'></label><textarea class='ewd-otp-textarea' name='form_instructions'> <?php echo $Form_Instructions; ?></textarea><br />
	<p>The instructions that will display above the order form.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Set Timezone</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Set Timezone</span></legend>
	<label title='Timezone'></label><select name='timezone'> 
			<option value="Pacific/Midway"<?php if($Timezone == "Pacific/Midway") {echo " selected=selected";} ?>>(GMT-11:00) Midway Island, Samoa</option>
			<option value="America/Adak"<?php if($Timezone == "America/Adak") {echo " selected=selected";} ?>>(GMT-10:00) Hawaii-Aleutian</option>
			<option value="Etc/GMT+10"<?php if($Timezone == "Etc/GMT+10") {echo " selected=selected";} ?>>(GMT-10:00) Hawaii</option>
			<option value="Pacific/Marquesas"<?php if($Timezone == "Pacific/Marquesas") {echo " selected=selected";} ?>>(GMT-09:30) Marquesas Islands</option>
			<option value="Pacific/Gambier"<?php if($Timezone == "Pacific/Gambier") {echo " selected=selected";} ?>>(GMT-09:00) Gambier Islands</option>
			<option value="America/Anchorage"<?php if($Timezone == "America/Anchorage") {echo " selected=selected";} ?>>(GMT-09:00) Alaska</option>
			<option value="America/Ensenada"<?php if($Timezone == "America/Ensenada") {echo " selected=selected";} ?>>(GMT-08:00) Tijuana, Baja California</option>
			<option value="Etc/GMT+8"<?php if($Timezone == "Etc/GMT+8") {echo " selected=selected";} ?>>(GMT-08:00) Pitcairn Islands</option>
			<option value="America/Los_Angeles"<?php if($Timezone == "America/Los_Angeles") {echo " selected=selected";} ?>>(GMT-08:00) Pacific Time (US & Canada)</option>
			<option value="America/Denver"<?php if($Timezone == "America/Denver") {echo " selected=selected";} ?>>(GMT-07:00) Mountain Time (US & Canada)</option>
			<option value="America/Chihuahua"<?php if($Timezone == "America/Chihuahua") {echo " selected=selected";} ?>>(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
			<option value="America/Dawson_Creek"<?php if($Timezone == "America/Dawson_Creek") {echo " selected=selected";} ?>>(GMT-07:00) Arizona</option>
			<option value="America/Belize"<?php if($Timezone == "America/Belize") {echo " selected=selected";} ?>>(GMT-06:00) Saskatchewan, Central America</option>
			<option value="America/Cancun"<?php if($Timezone == "America/Cancun") {echo " selected=selected";} ?>>(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
			<option value="Chile/EasterIsland"<?php if($Timezone == "Chile/EasterIsland") {echo " selected=selected";} ?>>(GMT-06:00) Easter Island</option>
			<option value="America/Chicago"<?php if($Timezone == "America/Chicago") {echo " selected=selected";} ?>>(GMT-06:00) Central Time (US & Canada)</option>
			<option value="America/New_York"<?php if($Timezone == "America/New_York") {echo " selected=selected";} ?>>(GMT-05:00) Eastern Time (US & Canada)</option>
			<option value="America/Havana"<?php if($Timezone == "America/Havana") {echo " selected=selected";} ?>>(GMT-05:00) Cuba</option>
			<option value="America/Bogota"<?php if($Timezone == "America/Bogota") {echo " selected=selected";} ?>>(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
			<option value="America/Caracas"<?php if($Timezone == "America/Caracas") {echo " selected=selected";} ?>>(GMT-04:30) Caracas</option>
			<option value="America/Santiago"<?php if($Timezone == "America/Santiago") {echo " selected=selected";} ?>>(GMT-04:00) Santiago</option>
			<option value="America/La_Paz"<?php if($Timezone == "America/La_Paz") {echo " selected=selected";} ?>>(GMT-04:00) La Paz</option>
			<option value="Atlantic/Stanley"<?php if($Timezone == "Atlantic/Stanley") {echo " selected=selected";} ?>>(GMT-04:00) Faukland Islands</option>
			<option value="America/Campo_Grande"<?php if($Timezone == "America/Campo_Grande") {echo " selected=selected";} ?>>(GMT-04:00) Brazil</option>
			<option value="America/Goose_Bay"<?php if($Timezone == "America/Goose_Bay") {echo " selected=selected";} ?>>(GMT-04:00) Atlantic Time (Goose Bay)</option>
			<option value="America/Glace_Bay"<?php if($Timezone == "America/Glace_Bay") {echo " selected=selected";} ?>>(GMT-04:00) Atlantic Time (Canada)</option>
			<option value="America/St_Johns"<?php if($Timezone == "America/St_Johns") {echo " selected=selected";} ?>>(GMT-03:30) Newfoundland</option>
			<option value="America/Araguaina"<?php if($Timezone == "America/Araguaina") {echo " selected=selected";} ?>>(GMT-03:00) UTC-3</option>
			<option value="America/Montevideo"<?php if($Timezone == "America/Montevideo") {echo " selected=selected";} ?>>(GMT-03:00) Montevideo</option>
			<option value="America/Miquelon"<?php if($Timezone == "America/Miquelon") {echo " selected=selected";} ?>>(GMT-03:00) Miquelon, St. Pierre</option>
			<option value="America/Godthab"<?php if($Timezone == "America/Godthab") {echo " selected=selected";} ?>>(GMT-03:00) Greenland</option>
			<option value="America/Argentina/Buenos_Aires"<?php if($Timezone == "America/Argentina/Buenos_Aires") {echo " selected=selected";} ?>>(GMT-03:00) Buenos Aires</option>
			<option value="America/Sao_Paulo"<?php if($Timezone == "America/Sao_Paulo") {echo " selected=selected";} ?>>(GMT-03:00) Brasilia</option>
			<option value="America/Noronha"<?php if($Timezone == "America/Noronha") {echo " selected=selected";} ?>>(GMT-02:00) Mid-Atlantic</option>
			<option value="Atlantic/Cape_Verde"<?php if($Timezone == "Atlantic/Cape_Verde") {echo " selected=selected";} ?>>(GMT-01:00) Cape Verde Is.</option>
			<option value="Atlantic/Azores"<?php if($Timezone == "Atlantic/Azores") {echo " selected=selected";} ?>>(GMT-01:00) Azores</option>
			<option value="Europe/Belfast"<?php if($Timezone == "Europe/Belfast") {echo " selected=selected";} ?>>(GMT) Greenwich Mean Time : Belfast</option>
			<option value="Europe/Dublin"<?php if($Timezone == "Europe/Dublin") {echo " selected=selected";} ?>>(GMT) Greenwich Mean Time : Dublin</option>
			<option value="Europe/Lisbon"<?php if($Timezone == "Europe/Lisbon") {echo " selected=selected";} ?>>(GMT) Greenwich Mean Time : Lisbon</option>
			<option value="Europe/London"<?php if($Timezone == "Europe/London") {echo " selected=selected";} ?>>(GMT) Greenwich Mean Time : London</option>
			<option value="Africa/Abidjan"<?php if($Timezone == "Africa/Abidjan") {echo " selected=selected";} ?>>(GMT) Monrovia, Reykjavik</option>
			<option value="Europe/Amsterdam"<?php if($Timezone == "Europe/Amsterdam") {echo " selected=selected";} ?>>(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
			<option value="Europe/Belgrade"<?php if($Timezone == "Europe/Belgrade") {echo " selected=selected";} ?>>(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
			<option value="Europe/Brussels"<?php if($Timezone == "Europe/Brussels") {echo " selected=selected";} ?>>(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
			<option value="Africa/Algiers"<?php if($Timezone == "Africa/Algiers") {echo " selected=selected";} ?>>(GMT+01:00) West Central Africa</option>
			<option value="Africa/Windhoek"<?php if($Timezone == "Africa/Windhoek") {echo " selected=selected";} ?>>(GMT+01:00) Windhoek</option>
			<option value="Asia/Beirut"<?php if($Timezone == "Asia/Beirut") {echo " selected=selected";} ?>>(GMT+02:00) Beirut</option>
			<option value="Africa/Cairo"<?php if($Timezone == "Africa/Cairo") {echo " selected=selected";} ?>>(GMT+02:00) Cairo</option>
			<option value="Asia/Gaza"<?php if($Timezone == "Asia/Gaza") {echo " selected=selected";} ?>>(GMT+02:00) Gaza</option>
			<option value="Africa/Blantyre"<?php if($Timezone == "Africa/Blantyre") {echo " selected=selected";} ?>>(GMT+02:00) Harare, Pretoria</option>
			<option value="Asia/Jerusalem"<?php if($Timezone == "Asia/Jerusalem") {echo " selected=selected";} ?>>(GMT+02:00) Jerusalem</option>
			<option value="Europe/Minsk"<?php if($Timezone == "Europe/Minsk") {echo " selected=selected";} ?>>(GMT+02:00) Minsk</option>
  		<option value="Asia/Damascus"<?php if($Timezone == "Asia/Damascus") {echo " selected=selected";} ?>>(GMT+02:00) Syria</option>
			<option value="Europe/Moscow"<?php if($Timezone == "Europe/Moscow") {echo " selected=selected";} ?>>(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
			<option value="Africa/Addis_Ababa"<?php if($Timezone == "Africa/Addis_Ababa") {echo " selected=selected";} ?>>(GMT+03:00) Nairobi</option>
			<option value="Asia/Tehran"<?php if($Timezone == "Asia/Tehran") {echo " selected=selected";} ?>>(GMT+03:30) Tehran</option>
			<option value="Asia/Dubai"<?php if($Timezone == "Asia/Dubai") {echo " selected=selected";} ?>>(GMT+04:00) Abu Dhabi, Muscat</option>
			<option value="Asia/Yerevan"<?php if($Timezone == "Asia/Yerevan") {echo " selected=selected";} ?>>(GMT+04:00) Yerevan</option>
			<option value="Asia/Kabul"<?php if($Timezone == "Asia/Kabul") {echo " selected=selected";} ?>>(GMT+04:30) Kabul</option>
			<option value="Asia/Yekaterinburg"<?php if($Timezone == "Asia/Yekaterinburg") {echo " selected=selected";} ?>>(GMT+05:00) Ekaterinburg</option>
			<option value="Asia/Tashkent"<?php if($Timezone == "Asia/Tashkent") {echo " selected=selected";} ?>>(GMT+05:00) Tashkent</option>
			<option value="Asia/Kolkata"<?php if($Timezone == "Asia/Kolkata") {echo " selected=selected";} ?>>(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
			<option value="Asia/Katmandu"<?php if($Timezone == "Asia/Katmandu") {echo " selected=selected";} ?>>(GMT+05:45) Kathmandu</option>
			<option value="Asia/Dhaka"<?php if($Timezone == "Asia/Dhaka") {echo " selected=selected";} ?>>(GMT+06:00) Astana, Dhaka</option>
			<option value="Asia/Novosibirsk"<?php if($Timezone == "Asia/Novosibirsk") {echo " selected=selected";} ?>>(GMT+06:00) Novosibirsk</option>
			<option value="Asia/Rangoon"<?php if($Timezone == "Asia/Rangoon") {echo " selected=selected";} ?>>(GMT+06:30) Yangon (Rangoon)</option>
			<option value="Asia/Bangkok"<?php if($Timezone == "Asia/Bangkok") {echo " selected=selected";} ?>>(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
			<option value="Asia/Krasnoyarsk"<?php if($Timezone == "Asia/Krasnoyarsk") {echo " selected=selected";} ?>>(GMT+07:00) Krasnoyarsk</option>
			<option value="Asia/Hong_Kong"<?php if($Timezone == "Asia/Hong_Kong") {echo " selected=selected";} ?>>(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
			<option value="Asia/Irkutsk"<?php if($Timezone == "Asia/Irkutsk") {echo " selected=selected";} ?>>(GMT+08:00) Irkutsk, Ulaan Bataar</option>
			<option value="Australia/Perth"<?php if($Timezone == "Australia/Perth") {echo " selected=selected";} ?>>(GMT+08:00) Perth</option>
			<option value="Australia/Eucla"<?php if($Timezone == "Australia/Eucla") {echo " selected=selected";} ?>>(GMT+08:45) Eucla</option>
			<option value="Asia/Tokyo"<?php if($Timezone == "Asia/Tokyo") {echo " selected=selected";} ?>>(GMT+09:00) Osaka, Sapporo, Tokyo</option>
			<option value="Asia/Seoul"<?php if($Timezone == "Asia/Seoul") {echo " selected=selected";} ?>>(GMT+09:00) Seoul</option>
			<option value="Asia/Yakutsk"<?php if($Timezone == "Asia/Yakutsk") {echo " selected=selected";} ?>>(GMT+09:00) Yakutsk</option>
			<option value="Australia/Adelaide"<?php if($Timezone == "Australia/Adelaide") {echo " selected=selected";} ?>>(GMT+09:30) Adelaide</option>
			<option value="Australia/Darwin"<?php if($Timezone == "Australia/Darwin") {echo " selected=selected";} ?>>(GMT+09:30) Darwin</option>
			<option value="Australia/Brisbane"<?php if($Timezone == "Australia/Brisbane") {echo " selected=selected";} ?>>(GMT+10:00) Brisbane</option>
			<option value="Australia/Hobart"<?php if($Timezone == "Australia/Hobart") {echo " selected=selected";} ?>>(GMT+10:00) Hobart</option>
			<option value="Asia/Vladivostok"<?php if($Timezone == "Asia/Vladivostok") {echo " selected=selected";} ?>>(GMT+10:00) Vladivostok</option>
			<option value="Australia/Lord_Howe"<?php if($Timezone == "Australia/Lord_Howe") {echo " selected=selected";} ?>>(GMT+10:30) Lord Howe Island</option>
			<option value="Etc/GMT-11"<?php if($Timezone == "Etc/GMT-11") {echo " selected=selected";} ?>>(GMT+11:00) Solomon Is., New Caledonia</option>
			<option value="Asia/Magadan"<?php if($Timezone == "Asia/Magadan") {echo " selected=selected";} ?>>(GMT+11:00) Magadan</option>
			<option value="Pacific/Norfolk"<?php if($Timezone == "Pacific/Norfolk") {echo " selected=selected";} ?>>(GMT+11:30) Norfolk Island</option>
			<option value="Asia/Anadyr"<?php if($Timezone == "Asia/Anadyr") {echo " selected=selected";} ?>>(GMT+12:00) Anadyr, Kamchatka</option>
			<option value="Pacific/Auckland"<?php if($Timezone == "Pacific/Auckland") {echo " selected=selected";} ?>>(GMT+12:00) Auckland, Wellington</option>
			<option value="Etc/GMT-12"<?php if($Timezone == "Etc/GMT-12") {echo " selected=selected";} ?>>(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
			<option value="Pacific/Chatham"<?php if($Timezone == "Pacific/Chatham") {echo " selected=selected";} ?>>(GMT+12:45) Chatham Islands</option>
			<option value="Pacific/Tongatapu"<?php if($Timezone == "Pacific/Tongatapu") {echo " selected=selected";} ?>>(GMT+13:00) Nuku'alofa</option>
			<option value="Pacific/Kiritimati"<?php if($Timezone == "Pacific/Kiritimati") {echo " selected=selected";} ?>>(GMT+14:00) Kiritimati</option>
	</select>
	<p>How often should e-mails be sent to customers about the status of their orders?</p>
	</fieldset>
</td>
</tr>

<tr>
<th scope="row">Date/Time Format</th>
<td>
  <fieldset><legend class="screen-reader-text"><span>Date/Time Format</span></legend>
  <label title='Localize Date & Time settings'></label><select name='localize_date_time'>
		<option value="North_American" <?php if($Localize_Date_Time == "North_American") {echo " selected=selected";} ?>>North American (YY-DD-MM)</option>
    <option value="European" <?php if($Localize_Date_Time == "European") {echo " selected=selected";} ?> >European (DD-MM-YY)</option>
	</select>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Order E-mail Frequency</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Order E-mail Frequency</span></legend>
	<label title='On Change'><input type='radio' name='order_email' value='Change' <?php if($Order_Email == "Change") {echo "checked='checked'";} ?> /> <span>On Change</span></label><br />
	<label title='On Creation'><input type='radio' name='order_email' value='Creation' <?php if($Order_Email == "Creation") {echo "checked='checked'";} ?> /> <span>On Creation</span></label><br />
	<label title='Never'><input type='radio' name='order_email' value='Never' <?php if($Order_Email == "Never") {echo "checked='checked'";} ?> /> <span>Never</span></label><br />
	<p>How often should e-mails be sent to customers about the status of their orders?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">AJAX Reloads</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>AJAX Reloads</span></legend>
	<label title='Yes'><input type='radio' name='ajax_reload' value='Yes' <?php if($AJAX_Reload == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
	<label title='No'><input type='radio' name='ajax_reload' value='No' <?php if($AJAX_Reload == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
	<p>Should search results use AJAX to display without reloading the page?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">New Window for Results</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>New Window for Results</span></legend>
	<label title='Yes'><input type='radio' name='new_window' value='Yes' <?php if($New_Window == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
	<label title='No'><input type='radio' name='new_window' value='No' <?php if($New_Window == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
	<p>Should search results display in a new window or open in the same one? (Doesn't work with AJAX reloads)</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Order E-mail Confirmation</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Order E-mail Confirmation</span></legend>
	<label title='User Entered'><input type='radio' name='email_confirmation' value='Order_Email' <?php if($Email_Confirmation == "Order_Email") {echo "checked='checked'";} ?> /> <span>User Entered</span></label><br />
	<label title='Auto Entered'><input type='radio' name='email_confirmation' value='Auto_Entered' <?php if($Email_Confirmation == "Auto_Entered") {echo "checked='checked'";} ?> /> <span>Auto Entered (via attribute)</span></label><br />
	<label title='No'><input type='radio' name='email_confirmation' value='None' <?php if($Email_Confirmation == "None") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
	<p>Do visitors need to also enter the e-mail address associated with an order to be able to view order information?</p>
	</fieldset>
</td>
</tr>
</table>

<h3>Premium Options</h3>
<table class="form-table">
<tr>
<th scope="row">Set Access Role</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Set Access Role</span></legend>
	<label title='Access Role'></label><select name='access_role' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>> 
		<option value="administrator"<?php if($Access_Role == "administrator") {echo " selected=selected";} ?>>Administrator</option>
		<option value="delete_others_pages"<?php if($Access_Role == "delete_others_pages") {echo " selected=selected";} ?>>Editor</option>
		<option value="delete_published_posts"<?php if($Access_Role == "delete_published_posts") {echo " selected=selected";} ?>>Author</option>
		<option value="delete_posts"<?php if($Access_Role == "delete_posts") {echo " selected=selected";} ?>>Contributor</option>
		<option value="read"<?php if($Access_Role == "read") {echo " selected=selected";} ?>>Subscriber</option>
	</select>
	<p>How often should e-mails be sent to customers about the status of their orders?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">WooCommerce Integration</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>WooCommerce Integration</span></legend>
	<label title='Yes'><input type='radio' name='woocommerce_integration' value='Yes' <?php if($WooCommerce_Integration == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
	<label title='No'><input type='radio' name='woocommerce_integration' value='No' <?php if($WooCommerce_Integration == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	<p>Should WooCommerce orders be automatically created inside of the Order Tracking plugin? (Only works for new orders)</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Order Tracking Graphic</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Order Tracking Graphic</span></legend>
	<!--Unresponsive-->
	<label title='Default'><input type='radio' name='display_graphic' value='Default' <?php if($Display_Graphic == "Default") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Default</span></label><br />
	<label title='Streamlined'><input type='radio' name='display_graphic' value='Streamlined' <?php if($Display_Graphic == "Streamlined") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Streamlined</span></label><br />
	<label title='Sleek'><input type='radio' name='display_graphic' value='Sleek' <?php if($Display_Graphic == "Sleek") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Sleek</span></label><br />
	<!--<label title='Narrow'><input type='radio' name='display_graphic' value='Narrow' <?php if($Display_Graphic == "Narrow") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Narrow</span></label><br />-->
	<!--Reponsive-->
	<label title='Minimalist (Responsive)'><input type='radio' name='display_graphic' value='Minimalist' <?php if($Display_Graphic == "Minimalist") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Minimalist</span></label><br />
	<label title='Round (Reponsive)'><input type='radio' name='display_graphic' value='Round' <?php if($Display_Graphic == "Round") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Round</span></label><br />
	<p>Which tracking graphic should be displayed, if the graphic is being used for your orders.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Mobile Stylesheet</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Mobile Stylesheet</span></legend>
	<label title='Yes'><input type='radio' name='mobile_stylesheet' value='Yes' <?php if($Mobile_Stylesheet == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
	<label title='No'><input type='radio' name='mobile_stylesheet' value='No' <?php if($Mobile_Stylesheet == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	<p>Should the mobile stylesheet for the plugin be included, so that the tracking form better fits mobile device screens?</p>
	</fieldset>
</td>
</tr>
</table>


<p class="submit"><input type="submit" name="Options_Submit" id="submit" class="button button-primary" value="Save Changes"  /></p></form>

</div>