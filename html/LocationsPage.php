<?php if ($EWD_OTP_Full_Version == "Yes") { 
	$LocationsString = get_option("EWD_OTP_Locations");
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>Locations</h2>

	<table class="wp-list-table widefat tags sorttable location-list">
	<thead>
		<tr>
			<th><?php _e("Delete", 'EWD_OTP') ?></th>
			<th><?php _e("Location", 'EWD_OTP') ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th><?php _e("Delete", 'EWD_OTP') ?></th>
			<th><?php _e("Location", 'EWD_OTP') ?></th>
		</tr>
	</tfoot>
			
	<?php 
	$Locations = explode(",", $LocationsString);
	foreach ($Locations as $key => $Location) { ?>
		<tr id="list-item-<?php echo $key; ?>" class="list-item">
			<input type='hidden' name='location[]' value='<?php echo $Locations[$key]; ?>' />
			<td class="location-delete"><a href="admin.php?page=EWD-OTP-options&Action=EWD_OTP_DeleteLocation&DisplayPage=Locations&Location=<?php echo $Locations[$key]; ?>"><?php _e("Delete", 'EWD_OTP') ?></a></td>
			<td class="location"><?php echo $Locations[$key]; ?></td>
		</tr>	
	<?php } ?>
	
	</table>	

	<h3>Add New Location:</h3>
	<form method="post" action="admin.php?page=EWD-OTP-options&DisplayPage=Locations&Action=EWD_OTP_UpdateLocations">
		<div class="form-field form-required">
			<label for="Location"><?php _e("New Location", 'EWD_OTP') ?></label>
			<input name="location[]" id="Location" type="text" size="60" />
			<p><?php _e("The name of the location you'd like to add.", 'EWD_OTP') ?></p>
		</div>
	
		<p class="submit"><input type="submit" name="Statuses_Submit" id="submit" class="button button-primary" value="Add Location"  /></p>
	</form>

</div>

<?php } else { ?>
<div class="Info-Div">
		<h2><?php _e("Full Version Required!", 'EWD_OTP') ?></h2>
		<div class="upcp-full-version-explanation">
				<?php _e("The full version of Order Tracking is required to use custom fields.", "UPCP");?><a href="http://www.etoilewebdesign.com/order-tracking/"><?php _e(" Please upgrade to unlock this page!", 'EWD_OTP'); ?></a>
		</div>
</div>
<?php } ?>