<?php $StatusString = get_option("EWD_OTP_Statuses"); 
$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_ID='%d'", $_GET['Order_ID']));
?>

<div id="col-left">
<div class="col-wrap">

<div class="form-wrap">
<h2><?php _e("Edit Order", 'EWD_OTP') ?></h2>
<!-- Form to edit an order -->
<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&Action=EditOrder&DisplayPage=Orders" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Edit_Order" />
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>
<input type='hidden' name='Order_ID' value='<?php echo $Order->Order_ID; ?>'>
<div class="form-field form-required">
	<label for="Order_Name"><?php _e("Name", 'EWD_OTP') ?></label>
	<input name="Order_Name" id="Order_Name" type="text" value='<?php echo $Order->Order_Name; ?>' size="60" />
	<p><?php _e("The name of the order your users will see.", 'EWD_OTP') ?></p>
</div>
<div class="form-field">
	<label for="Order_Number"><?php _e("Order Number", 'EWD_OTP') ?></label>
	<input type='text' name="Order_Number" id="Order_Number" value='<?php echo $Order->Order_Number; ?>' />
	<p><?php _e("The number that visitors will search to find the order.", 'EWD_OTP') ?></p>
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
		<label for="Order_Display"><?php _e("Show in Admin Table?", 'EWD_OTP') ?></label>
		<input type='radio' name="Order_Display" value="Yes" <?php if ($Order->Order_Display == "Yes") {echo "checked";} ?>>Yes<br/>
		<input type='radio' name="Order_Display" value="No" <?php if ($Order->Order_Display == "No") {echo "checked";} ?>>No<br/>
		<p><?php _e("Should this order appear in the orders table in the admin area?", 'EWD_OTP') ?></p>
</div>

<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Edit Order', 'EWD_OTP') ?>"  /></p></form>

</div>

<br class="clear" />
</div>
</div><!-- /col-left -->
