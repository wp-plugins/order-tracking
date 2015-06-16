<?php 
$StatusString = get_option("EWD_OTP_Statuses");
$LocationsString = get_option("EWD_OTP_Locations"); 
$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_ID='%d'", $_GET['Order_ID']));
$Customers = $wpdb->get_results("SELECT * FROM $EWD_OTP_customers");
$Sales_Reps = $wpdb->get_results("SELECT * FROM $EWD_OTP_sales_reps");

if ($Sales_Rep_Only == "Yes") {
	$Current_User = wp_get_current_user();
	$Sql = "SELECT Sales_Rep_ID FROM $EWD_OTP_sales_reps WHERE Sales_Rep_WP_ID='" . $Current_User->ID . "'";
	$Sales_Rep_ID = $wpdb->get_var($Sql);
}
?>

<div id="col-left">
<div class="col-wrap">

<div class="form-wrap">
<h2><?php _e("Edit Order", 'EWD_OTP') ?></h2>
<!-- Form to edit an order -->
<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&Action=EWD_OTP_EditOrder&DisplayPage=Orders" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Edit_Order" />
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>
<input type='hidden' name='Order_ID' value='<?php echo $Order->Order_ID; ?>'>
<div class="form-field form-required">
	<label for="Order_Name"><?php _e("Name", 'EWD_OTP') ?></label>
	<input name="Order_Name" id="Order_Name" type="text" value="<?php echo stripslashes($Order->Order_Name); ?>" size="60" />
	<p><?php _e("The name of the order your users will see.", 'EWD_OTP') ?></p>
</div>
<div class="form-field">
	<label for="Order_Number"><?php _e("Order Number", 'EWD_OTP') ?></label>
	<input type='text' name="Order_Number" id="Order_Number" value="<?php echo stripslashes($Order->Order_Number); ?>" />
	<p><?php _e("The number that visitors will search to find the order.", 'EWD_OTP') ?></p>
</div>
<div class="form-field">
	<label for="Order_Email"><?php _e("Order Email", 'EWD_OTP') ?></label>
	<input type='text' name="Order_Email" id="Order_Email" value="<?php echo stripslashes($Order->Order_Email); ?>" />
	<p><?php _e("The e-mail address to send order updates to, if you have selected that option.", 'EWD_OTP') ?></p>
</div>
<div>
		<label for="Order_Status"><?php _e("Order Status", 'EWD_OTP') ?></label>
		<select name="Order_Status" id="Order_Status" />
		<?php $Statuses = explode(",", $StatusString);
					foreach ($Statuses as $Status) { ?>
					<option value='<?php echo $Status; ?>' <?php if ($Order->Order_Status == $Status) {echo "selected='selected'";} ?>><?php echo $Status; ?></option>
		<?php } ?>
		</select>
		<p><?php _e("The status that visitors will see if they enter the order number.", 'EWD_OTP') ?></p>
</div>
<div>
		<label for="Order_Location"><?php _e("Order Location", 'EWD_OTP') ?></label>
		<select name="Order_Location" id="Order_Location" />
		<?php $Locations = explode(",", $LocationsString);
			foreach ($Locations as $Location) { ?>
			<option value='<?php echo $Location; ?>' <?php if ($Order->Order_Location == $Location) {echo "selected='selected'";} ?>><?php echo $Location; ?></option>
		<?php } ?>
		</select>
		<p><?php _e("The location that visitors will see if they enter the order number.", 'EWD_OTP') ?></p>
</div>
<div>
		<label for="Customer_ID"><?php _e("Customer", 'EWD_OTP') ?></label>
		<select name="Customer_ID" id="Customer_ID" />
		<option value='0'>None</option>
		<?php foreach ($Customers as $Customer) { ?>
					<option value='<?php echo $Customer->Customer_ID; ?>' <?php if ($Order->Customer_ID == $Customer->Customer_ID) {echo "selected='selected'";} ?>><?php echo $Customer->Customer_Name; ?></option>
		<?php } ?>
		</select>
		<p><?php _e("The customer that this order is associated with.", 'EWD_OTP') ?></p>
</div>
<?php 
	if ($Sales_Rep_Only == "Yes") {
		echo "<input type='hidden' name='Sales_Rep_ID' value='" . $Sales_Rep_ID . "' />";
	}
	else {
?>
<div>
		<label for="Sales_Rep_ID"><?php _e("Sales Rep", 'EWD_OTP') ?></label>
		<select name="Sales_Rep_ID" id="Sales_Rep_ID" />
		<option value='0'>None</option>
		<?php foreach ($Sales_Reps as $Sales_Rep) { ?>
					<option value='<?php echo $Sales_Rep->Sales_Rep_ID; ?>' <?php if ($Order->Sales_Rep_ID == $Sales_Rep->Sales_Rep_ID) {echo "selected='selected'";} ?>><?php echo $Sales_Rep->Sales_Rep_First_Name . " " . $Sales_Rep->Sales_Rep_Last_Name; ?></option>
		<?php } ?>
		</select>
		<p><?php _e("The sales rep that this order is associated with.", 'EWD_OTP') ?></p>
</div>
<?php } ?>
<div class="form-field">
	<label for="Order_Notes_Public"><?php _e("Public Order Notes", 'EWD_OTP') ?></label>
	<input type='text' name="Order_Notes_Public" id="Order_Notes_Public" value="<?php echo stripslashes($Order->Order_Notes_Public); ?>" />
	<p><?php _e("The notes that visitors will see if they enter the order number, and you've included 'Notes' on the options page.", 'EWD_OTP') ?></p>
</div>
<div class="form-field">
	<label for="Order_Notes_Private"><?php _e("Private Order Notes", 'EWD_OTP') ?></label>
	<input type='text' name="Order_Notes_Private" id="Order_Notes_Private" value="<?php echo stripslashes($Order->Order_Notes_Private); ?>" />
	<p><?php _e("The notes about an order visible only to admins.", 'EWD_OTP') ?></p>
</div>
<div class="form-field">
	<label for="Order_Customer_Notes"><?php _e("Customer Order Notes", 'EWD_OTP') ?></label>
	<input type='text' name="Order_Customer_Notes" id="Order_Customer_Notes" value="<?php echo stripslashes($Order->Order_Customer_Notes); ?>" />
	<p><?php _e("The notes about an order posted by the customer from the front-end.", 'EWD_OTP') ?></p>
</div>
<div>
		<label for="Order_Display"><?php _e("Show in Admin Table?", 'EWD_OTP') ?></label>
		<input type='radio' name="Order_Display" value="Yes" <?php if ($Order->Order_Display == "Yes") {echo "checked";} ?>>Yes<br/>
		<input type='radio' name="Order_Display" value="No" <?php if ($Order->Order_Display == "No") {echo "checked";} ?>>No<br/>
		<p><?php _e("Should this order appear in the orders table in the admin area?", 'EWD_OTP') ?></p>
</div>

<?php
						
						$Sql = "SELECT * FROM $EWD_OTP_fields_table_name ";
						$Fields = $wpdb->get_results($Sql);
						$MetaValues = $wpdb->get_results($wpdb->prepare("SELECT Field_ID, Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d", $_GET['Order_ID']));
						foreach ($Fields as $Field) {
								$Value = "";
								if (is_array($MetaValues)) {
									  foreach ($MetaValues as $Meta) {
												if ($Field->Field_ID == $Meta->Field_ID) {$Value = $Meta->Meta_Value;}
										}
								}
								$ReturnString .= "<tr><th><label for='" . $Field->Field_Name . "'>" . $Field->Field_Name . ":</label></th>";
								if ($Field->Field_Type == "text" or $Field->Field_Type == "mediumint") {
					  			  $ReturnString .= "<td><input name='" . $Field->Field_Name . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-text-input' type='text' value='" . $Value . "' /></td>";
								}
								elseif ($Field->Field_Type == "textarea") {
										$ReturnString .= "<td><textarea name='" . $Field->Field_Name . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-textarea'>" . $Value . "</textarea></td>";
								} 
								elseif ($Field->Field_Type == "select") { 
										$Options = explode(",", $Field->Field_Values);
										$ReturnString .= "<td><select name='" . $Field->Field_Name . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-select'>";
			 							foreach ($Options as $Option) {
												$ReturnString .= "<option value='" . $Option . "' ";
												if (trim($Option) == trim($Value)) {$ReturnString .= "selected='selected'";}
												$ReturnString .= ">" . $Option . "</option>";
										}
										$ReturnString .= "</select></td>";
								} 
								elseif ($Field->Field_Type == "radio") {
										$Counter = 0;
										$Options = explode(",", $Field->Field_Values);
										$ReturnString .= "<td>";
										foreach ($Options as $Option) {
												if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
												$ReturnString .= "<input type='radio' name='" . $Field->Field_Name . "' value='" . $Option . "' class='ewd-otp-radio' ";
												if (trim($Option) == trim($Value)) {$ReturnString .= "checked";}
												$ReturnString .= ">" . $Option;
												$Counter++;
										} 
										$ReturnString .= "</td>";
								} 
								elseif ($Field->Field_Type == "checkbox") {
  									$Counter = 0;
										$Options = explode(",", $Field->Field_Values);
										$Values = explode(",", $Value);
										$ReturnString .= "<td>";
										foreach ($Options as $Option) {
												if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
												$ReturnString .= "<input type='checkbox' name='" . $Field->Field_Name . "[]' value='" . $Option . "' class='ewd-otp-checkbox' ";
												if (in_array($Option, $Values)) {$ReturnString .= "checked";}
												$ReturnString .= ">" . $Option . "</br>";
												$Counter++;
										}
										$ReturnString .= "</td>";
								}
								elseif ($Field->Field_Type == "file") {
										$ReturnString .= "<td><input name='" . $Field->Field_Name . "' class='ewd-otp-file-input' type='file' value='" . $Value . "' /><br />";
										$ReturnString .= "Current File: " . $Value . "</td>";
								}
								elseif ($Field->Field_Type == "date") {
										$ReturnString .= "<td><input name='" . $Field->Field_Name . "' class='ewd-otp-date-input' type='date' value='" . $Value . "' /></td>";
								} 
								elseif ($Field->Field_Type == "datetime") {
										$ReturnString .= "<td><input name='" . $Field->Field_Name . "' class='ewd-otp-datetime-input' type='datetime-local' value='" . $Value . "' /></td>";
  							}
						}
						echo $ReturnString;
						?>
						
<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Edit Order', 'EWD_OTP') ?>"  /></p></form>

</div>

<br class="clear" />
</div>
</div><!-- /col-left -->
