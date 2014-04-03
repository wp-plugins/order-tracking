<?php 
		$StatusString = get_option("EWD_OTP_Statuses");
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div><h2>Settings</h2>

<form method="post" action="admin.php?page=EWD-OTP-options&DisplayPage=Options&Action=UpdateOptions">
<table class="form-table">
<tr>
<th scope="row"></th>
<td>Status</td>
</tr>

<?php 
$Statuses = explode(",", $StatusString);
foreach ($Statuses as $Status) { ?>
<tr>
<th scope="row"><a href='admin.php?page=EWD-OTP-options&DisplayPage=Options&Action=DeleteOption&Status=<?php echo $Status ?>'>Delete</a></th>
<td>
	<legend class="screen-reader-text"><label title='Status'><?php echo $Status; ?></label></legend>
	<?php echo $Status; ?>
	<input type='hidden' name='status[]' value='<?php echo $Status; ?>' /><br />
</td></tr>
<?php } ?>

<tr>
<th scope="row">New Status:</th>
<td>
	<legend class="screen-reader-text"><label title='Status'>New Status</label></legend>
	<input type='text' name='status[]' value='' /><br />
	<p>The name of the status you'd like to add.</p>
</td></tr>
</table>


<p class="submit"><input type="submit" name="Options_Submit" id="submit" class="button button-primary" value="Save Changes"  /></p></form>

</div>