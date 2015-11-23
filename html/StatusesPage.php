<?php 
	$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
	$Email_Messages_Array = get_option("EWD_OTP_Email_Messages_Array");
	if (!is_array($Statuses_Array)) {$Statuses_Array = array();}
	if (!is_array($Email_Messages_Array)) {$Email_Messages_Array = array();}
?>
<div class="wrap">
<form method="post" action="admin.php?page=EWD-OTP-options&DisplayPage=Statuses&Action=EWD_OTP_UpdateStatuses">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>Statuses</h2>

	<table class="wp-list-table widefat tags sorttable status-list">
	<thead>
		<tr>
			<th><?php _e("Delete", 'EWD_OTP') ?></th>
			<th><?php _e("Status", 'EWD_OTP') ?></th>
			<th><?php _e("Percentage Complete", 'EWD_OTP') ?></th>
			<th><?php _e("Email to Send", 'EWD_OTP') ?></th>
			<th><?php _e("Internal Status", 'EWD_OTP') ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th><?php _e("Delete", 'EWD_OTP') ?></th>
			<th><?php _e("Status", 'EWD_OTP') ?></th>
			<th><?php _e("Percentage Complete", 'EWD_OTP') ?></th>
			<th><?php _e("Email to Send", 'EWD_OTP') ?></th>
			<th><?php _e("Internal Status", 'EWD_OTP') ?></th>
		</tr>
	</tfoot>
			
	<?php 
	if (!is_array($Statuses_Array)) {$Statuses_Array = array();}
	foreach ($Statuses_Array as $Status_Array_Item) { ?>
		<tr id="list-item-<?php echo $key; ?>" class="list-item">
			<input type='hidden' name='status[]' value='<?php echo $Status_Array_Item['Status']; ?>' />
			<input type='hidden' name='status_percentages[]' value='<?php echo $Status_Array_Item['Percentage']; ?>' />
			<input type='hidden' name='status_messages[]' value='<?php echo urlencode($Status_Array_Item['Message']); ?>' />
			<input type='hidden' name='status_internals[]' value='<?php echo urlencode($Status_Array_Item['Internal']); ?>' />
			<td class="status-delete"><a href="admin.php?page=EWD-OTP-options&Action=EWD_OTP_DeleteStatus&DisplayPage=Statuses&Status=<?php echo urlencode($Status_Array_Item['Status']); ?>"><?php _e("Delete", 'EWD_OTP') ?></a></td>
			<td class="status"><?php echo $Status_Array_Item['Status']; ?></td>
			<td class="status-completed"><?php echo $Status_Array_Item['Percentage']; ?></td>
			<td class="status-message"><?php echo $Status_Array_Item['Message']; ?></td>
			<td class="status-internal"><?php echo $Status_Array_Item['Internal']; ?></td>
		</tr>	
	<?php } ?>
	
	</table>	

	<h3>Add New Status:</h3>
		<div class="form-field form-required">
			<label for="Status"><?php _e("New Status", 'EWD_OTP') ?></label>
			<input name="status[]" id="Status" type="text" size="60" />
			<p><?php _e("The name of the status you'd like to add.", 'EWD_OTP') ?></p>
		</div>
		<div class="form-field form-required">
			<label for="Status_Percentage"><?php _e("Percentage Complete", 'EWD_OTP') ?></label>
			<input name="status_percentages[]" id="Status_Percentage" type="text" size="60" />
			<p><?php _e("The percentage of the shipping process completed when this status is reached; used in the shipping graphic.", 'EWD_OTP') ?></p>
		</div>
		<div class="form-field form-required">
			<label for="Status_Message"><?php _e("Email to Send", 'EWD_OTP') ?></label>
			<select name="status_messages[]" id="Status_Message"/>
				<?php foreach ($Email_Messages_Array as $Email_Message_Item) { ?>
					<option value='<?php echo $Email_Message_Item['Name']; ?>'><?php echo $Email_Message_Item['Name']; ?></option>
				<?php } ?>
			</select>
			<p><?php _e("The message that is sent out when this status is selected, if the emailing frequency is set to 'On Change'.", 'EWD_OTP') ?></p>
		</div>
		<div class="form-field form-required">
			<label for="Status_Internal"><?php _e("Internal Status?", 'EWD_OTP') ?></label>
			<select name="status_internals[]" id="Status_Internal"/>
				<option value='No'>No</option>
				<option value='Yes'>Yes</option>
			</select>
			<p><?php _e("Should this status only be seen by admins and sales reps?", 'EWD_OTP') ?></p>
		</div>
	
		<p class="submit"><input type="submit" name="Statuses_Submit" id="submit" class="button button-primary" value="Add Status"  /></p>
	</form>

</div>