<?php 
		$Custom_CSS = get_option("EWD_OTP_Custom_CSS");
		$AJAX_Reload = get_option("EWD_OTP_AJAX_Reload");
		$New_Window = get_option("EWD_OTP_New_Window");
		$Order_Information_String = get_option("EWD_OTP_Order_Information");
		$Order_Information = explode(",", $Order_Information_String);
		$Order_Email = get_option("EWD_OTP_Order_Email");
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div><h2>Settings</h2>

<form method="post" action="admin.php?page=EWD-OTP-options&DisplayPage=Options&Action=UpdateOptions">
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
	<label title='Update Date'><input type='checkbox' name='order_information[]' value='Order_Updated' <?php if(in_array("Order_Updated", $Order_Information)) {echo "checked='checked'";} ?> /> <span>Updated Date</span></label><br />
	<label title='Notes'><input type='checkbox' name='order_information[]' value='Order_Notes' <?php if(in_array("Order_Notes", $Order_Information)) {echo "checked='checked'";} ?> /> <span>Notes</span></label><br />
	<label title='Graphic'><input type='checkbox' name='order_information[]' value='Order_Graphic' <?php if(in_array("Order_Graphic", $Order_Information)) {echo "checked='checked'";} ?> /> <span>Status Graphic</span></label><br />
	<p>Select what information should be displayed for each order.</p>
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
	<p>Should search results display in a new window or open in the same one? (Doesn't work with AJAX reloads)</p>
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
</table>


<p class="submit"><input type="submit" name="Options_Submit" id="submit" class="button button-primary" value="Save Changes"  /></p></form>

</div>