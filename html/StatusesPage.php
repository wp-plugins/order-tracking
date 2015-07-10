<?php 
	$StatusString = get_option("EWD_OTP_Statuses");
	$PercentageString = get_option("EWD_OTP_Percentages");
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>Statuses</h2>

	<table class="wp-list-table widefat tags sorttable status-list">
	<thead>
		<tr>
			<th><?php _e("Delete", 'EWD_OTP') ?></th>
			<th><?php _e("Status", 'EWD_OTP') ?></th>
			<th><?php _e("Percentage Complete", 'EWD_OTP') ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th><?php _e("Delete", 'EWD_OTP') ?></th>
			<th><?php _e("Status", 'EWD_OTP') ?></th>
			<th><?php _e("Percentage Complete", 'EWD_OTP') ?></th>
		</tr>
	</tfoot>
			
	<?php 
	$Statuses = explode(",", $StatusString);
	$Percentages = explode(",", $PercentageString);
	foreach ($Statuses as $key => $Status) { ?>
		<tr id="list-item-<?php echo $key; ?>" class="list-item">
			<input type='hidden' name='status[]' value='<?php echo $Statuses[$key]; ?>' />
			<input type='hidden' name='status_percentages[]' value='<?php echo $Percentages[$key]; ?>' />
			<td class="status-delete"><a href="admin.php?page=EWD-OTP-options&Action=EWD_OTP_DeleteStatus&DisplayPage=Statuses&Status=<?php echo urlencode($Statuses[$key]); ?>"><?php _e("Delete", 'EWD_OTP') ?></a></td>
			<td class="status"><?php echo $Statuses[$key]; ?></td>
			<td class="status-completed"><?php echo $Percentages[$key]; ?></td>
		</tr>	
	<?php } ?>
	
	</table>	

	<h3>Add New Status:</h3>
	<form method="post" action="admin.php?page=EWD-OTP-options&DisplayPage=Statuses&Action=EWD_OTP_UpdateStatuses">
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
	
		<p class="submit"><input type="submit" name="Statuses_Submit" id="submit" class="button button-primary" value="Add Status"  /></p>
	</form>

</div>