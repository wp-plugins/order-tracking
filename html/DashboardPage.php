<?php 
$StatusString = get_option("EWD_OTP_Statuses");
$Statuses = explode(",", $StatusString);

$Order_Information_String = get_option("EWD_OTP_Order_Information");
$Order_Information = explode(",", $Order_Information_String);

?>
<!-- Upgrade to pro link box -->
<?php if ($EWD_OTP_Full_Version != "Yes") { ?>
<div id="side-sortables" class="metabox-holder ">
<div id="upcp_pro" class="postbox " >
		<div class="handlediv" title="Click to toggle"></div><h3 class='hndle'><span><?php _e("Full Version", 'EWD_OTP') ?></span></h3>
		<div class="inside">
				<ul><li><a href="http://www.etoilewebdesign.com/order-tracking/"><?php _e("Upgrade to the full version ", "EWD_OTP"); ?></a><?php _e("to take advantage of all the available features of the Order Tracking for Wordpress!", 'EWD_OTP'); ?></li>
				<div class="full-version-form-div">
						<form action="admin.php?page=EWD-OTP-options" method="post">
								<div class="form-field form-required">
										<label for="Product_Key"><?php _e("Product Key", 'EWD_OTP') ?></label>
										<input name="Key" type="text" value="" size="40" />
								</div>							
								<input type="submit" name="EWD_OTP_Upgrade_To_Full" value="<?php _e('Upgrade', 'EWD_OTP') ?>">
						</form>
				</div>
		</div>
</div>
</div>
<?php } ?>

<?php if (get_option("EWD_OTP_Update_Flag") == "Yes" or get_option("EWD_OTP_Install_Flag") == "Yes") {?>
					<div id="side-sortables" class="metabox-holder ">
							<div id="upcp_pro" class="postbox " >
									<div class="handlediv" title="Click to toggle"></div>
									<h3 class='hndle'><span><?php _e("Thank You!", 'EWD_OTP') ?></span></h3>
							 		<div class="inside">
											<?php /*if (get_option("EWD_OTP_Install_Flag") == "Yes") { ?><ul><li><?php _e("Thanks for installing the Ultimate Product Catalogue Plugin.", 'EWD_OTP'); ?><br> <a href='https://www.youtube.com/channel/UCZPuaoetCJB1vZOmpnMxJNw'><?php _e("Subscribe to our YouTube channel ", 'EWD_OTP'); ?></a> <?php _e("for tutorial videos on this and our other plugins!", 'EWD_OTP');?> </li></ul>
											<?php } else { ?><ul><li><?php _e("Thanks for upgrading to version 2.4.21!", 'EWD_OTP'); ?><br> <a href='https://www.youtube.com/channel/UCZPuaoetCJB1vZOmpnMxJNw'><?php _e("Subscribe to our YouTube channel ", 'EWD_OTP'); ?></a> <?php _e("for tutorial videos on this and our other plugins!", 'EWD_OTP');?> </li></ul><?php } */?>
											
											<?php /*if (get_option("EWD_OTP_Install_Flag") == "Yes") { ?><ul><li><?php _e("Thanks for installing the Ultimate Product Catalogue Plugin.", 'EWD_OTP'); ?><br> <a href='http://www.facebook.com/EtoileWebDesign'><?php _e("Follow us on Facebook", 'EWD_OTP'); ?></a> <?php _e("to suggest new features or hear about upcoming ones!", 'EWD_OTP');?> </li></ul>
											<?php } else { ?><ul><li><?php _e("Thanks for upgrading to version 2.2.9!", 'EWD_OTP'); ?><br> <a href='http://www.facebook.com/EtoileWebDesign'><?php _e("Follow us on Facebook", 'EWD_OTP'); ?></a> <?php _e("to suggest new features or hear about upcoming ones!", 'EWD_OTP');?> </li></ul><?php } */?>
											
											<?php  if (get_option("EWD_OTP_Install_Flag") == "Yes") { ?><ul><li><?php _e("Thanks for installing Order Tracking.", 'EWD_OTP'); ?><br> <a href='http://www.facebook.com/EtoileWebDesign'><?php _e("Follow us on Facebook", 'EWD_OTP'); ?></a> <?php _e("to suggest new features or hear about upcoming ones!", 'EWD_OTP');?>  </li></ul>
											<?php } else { ?><ul><li><?php _e("Thanks for upgrading to version 2.2.3!", 'EWD_OTP'); ?><br> <a href='http://wordpress.org/support/view/plugin-reviews/order-tracking'><?php _e("Please rate our plugin", 'EWD_OTP'); ?></a> <?php _e("if you find Order Tracking useful!", 'EWD_OTP');?> </li></ul><?php } ?>
											
											<?php /*if (get_option("EWD_OTP_Install_Flag") == "Yes") { ?><ul><li><?php _e("Thanks for installing the Ultimate Product Catalogue Plugin.", 'EWD_OTP'); ?><br> <a href='http://www.facebook.com/EtoileWebDesign'><?php _e("Follow us on Facebook", 'EWD_OTP'); ?></a> <?php _e("to suggest new features or hear about upcoming ones!", 'EWD_OTP');?>  </li></ul>
											<?php } else { ?><ul><li><?php _e("Thanks for upgrading to version 2.3.9!", 'EWD_OTP'); ?><br> <a href='http://wordpress.org/support/topic/error-hunt'><?php _e("Please let us know about any small display/functionality errors. ", 'EWD_OTP'); ?></a> <?php _e("We've noticed a couple, and would like to eliminate as many as possible.", 'EWD_OTP');?> </li></ul><?php } */?>
											
											<?php /* if (get_option("EWD_OTP_Install_Flag") == "Yes") { ?><ul><li><?php _e("Thanks for installing the Ultimate Product Catalogue Plugin.", 'EWD_OTP'); ?><br> <a href='https://www.youtube.com/channel/UCZPuaoetCJB1vZOmpnMxJNw'><?php _e("Check out our YouTube channel ", 'EWD_OTP'); ?></a> <?php _e("for tutorial videos on this and our other plugins!", 'EWD_OTP');?> </li></ul>
											<?php } elseif ($Full_Version == "Yes") { ?><ul><li><?php _e("Thanks for upgrading to version 2.4!", 'EWD_OTP'); ?><br> <a href='http://www.facebook.com/EtoileWebDesign'><?php _e("Follow us on Facebook", 'EWD_OTP'); ?></a> <?php _e("to suggest new features or hear about upcoming ones!", 'EWD_OTP');?> </li></ul>
											<?php } else { ?><ul><li><?php _e("Thanks for upgrading to version 2.4!", 'EWD_OTP'); ?><br> <?php _e("Love the plugin but don't need the premium version? Help us speed up product support and development by donating. Thanks for using the plugin!", 'EWD_OTP');?>
																	 <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
																	 <input type="hidden" name="cmd" value="_s-xclick">
																	 <input type="hidden" name="hosted_button_id" value="AQLMJFJ62GEFJ">
																	 <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
																	 <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
																	 </form>
																	 </li></ul>
											<?php } */ ?>

									</div>
							</div>
					</div>
		<?php  
		update_option('EWD_OTP_Update_Flag', "No");
		update_option('EWD_OTP_Install_Flag', "No"); 
	} 
?>

<div id="col-right">
<div class="col-wrap">
<?php echo get_option('plugin_error'); ?>
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>

<?php 
			if (isset($_GET['Page'])) {$Page = $_GET['Page'];}
			else {$Page = 1;}
			
			$Sql = "SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Display='Yes' ";
				if (isset($_GET['OrderBy']) and $_GET['DisplayPage'] == "Dashboard") {$Sql .= "ORDER BY " . $_GET['OrderBy'] . " " . $_GET['Order'] . " ";}
				else {$Sql .= "ORDER BY Order_Number ";}
				$Sql .= "LIMIT " . ($Page - 1)*20 . ",20";
				$myrows = $wpdb->get_results($Sql);
				$TotalOrders = $wpdb->get_results("SELECT Order_ID FROM $EWD_OTP_orders_table_name WHERE Order_Display='Yes'");
				$Number_of_Pages = ceil($wpdb->num_rows/20);
				$Current_Page_With_Order_By = "admin.php?page=EWD-OTP-options&DisplayPage=Dashboard";
				if (isset($_GET['OrderBy'])) {$Current_Page_With_Order_By .= "&OrderBy=" .$_GET['OrderBy'] . "&Order=" . $_GET['Order'];}?>

<form action="admin.php?page=EWD-OTP-options&Action=EWD_OTP_MassAction" method="post">    
<div class="tablenav top">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'EWD_OTP') ?></option>
						<?php foreach ($Statuses as $Status) {echo "<option value='" . $Status . "'>" . $Status  . "</option>";} ?>
						<option value='hide'><?php _e("Hide Order", 'EWD_OTP') ?></option>
						<option value='delete'><?php _e("Delete", 'EWD_OTP') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'EWD_OTP') ?>"  />
		</div>
		<div class='tablenav-pages <?php if ($Number_of_Pages == 1) {echo "one-page";} ?>'>
				<span class="displaying-num"><?php echo $wpdb->num_rows; ?> <?php _e("items", 'EWD_OTP') ?></span>
				<span class='pagination-links'>
						<a class='first-page <?php if ($Page == 1) {echo "disabled";} ?>' title='Go to the first page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=1'>&laquo;</a>
						<a class='prev-page <?php if ($Page <= 1) {echo "disabled";} ?>' title='Go to the previous page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page-1;?>'>&lsaquo;</a>
						<span class="paging-input"><?php echo $Page; ?> <?php _e("of", 'EWD_OTP') ?> <span class='total-pages'><?php echo $Number_of_Pages; ?></span></span>
						<a class='next-page <?php if ($Page >= $Number_of_Pages) {echo "disabled";} ?>' title='Go to the next page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page+1;?>'>&rsaquo;</a>
						<a class='last-page <?php if ($Page == $Number_of_Pages) {echo "disabled";} ?>' title='Go to the last page' href='<?php echo $Current_Page_With_Order_By . "&Page=" . $Number_of_Pages; ?>'>&raquo;</a>
				</span>
		</div>
</div>

<table class="wp-list-table widefat fixed tags sorttable" cellspacing="0">
		<thead>
		<tr>
			<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
				<input type="checkbox" /></th><th scope='col' id='field-name' class='manage-column column-name sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Number" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Number&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Number&Order=ASC'>";} 
				?>
					<span><?php _e("Order Number", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='type' class='manage-column column-type sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Name&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Name&Order=ASC'>";} 
				?>
					<span><?php _e("Name", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status&Order=ASC'>";} 
				?>
					<span><?php _e("Status", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<?php if (in_array("Customer_Notes", $Order_Information)) { ?>
				<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
					<?php 
						if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Customer_Notes&Order=DESC'>";}
						else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Customer_Notes&Order=ASC'>";} 
					?>
						<span><?php _e("Customer Notes", 'EWD_OTP') ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
			<?php } ?>
			<th scope='col' id='required' class='manage-column column-users sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status_Updated" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status_Updated&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status_Updated&Order=ASC'>";} 
				?>
					<span><?php _e("Updated", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
				<input type="checkbox" /></th><th scope='col' id='field-name' class='manage-column column-name sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Number" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Number&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Number&Order=ASC'>";} 
				?>
					<span><?php _e("Order Number", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='type' class='manage-column column-type sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Name&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Name&Order=ASC'>";} 
				?>
					<span><?php _e("Name", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status&Order=ASC'>";} 
				?>
					<span><?php _e("Status", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<?php if (in_array("Customer_Notes", $Order_Information)) { ?>
				<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
					<?php 
						if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Customer_Notes&Order=DESC'>";}
						else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Customer_Notes&Order=ASC'>";} 
					?>
						<span><?php _e("Customer Notes", 'EWD_OTP') ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
			<?php } ?>
			<th scope='col' id='required' class='manage-column column-users sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status_Updated" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status_Updated&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status_Updated&Order=ASC'>";} 
				?>
					<span><?php _e("Updated", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
		</tr>
	</tfoot>

	<tbody id="the-list" class='list:tag'>
		
		 <?php
				if ($myrows) { 
	  			  foreach ($myrows as $Order) {
								echo "<tr id='Order" . $Order->Order_ID ."'>";
								echo "<th scope='row' class='check-column'>";
								echo "<input type='checkbox' name='Orders_Bulk[]' value='" . $Order->Order_ID ."' />";
								echo "</th>";
								echo "<td class='name column-name'>";
								echo "<strong>";
								echo "<a class='row-title' href='admin.php?page=EWD-OTP-options&Action=EWD_OTP_Order_Details&Selected=Order&Order_ID=" . $Order->Order_ID ."' title='Edit " . $Order->Order_Number . "'>" . $Order->Order_Number . "</a></strong>";
								echo "<br />";
								echo "<div class='row-actions'>";
								echo "<span class='delete'>";
								echo "<a class='delete-tag' href='admin.php?page=EWD-OTP-options&Action=EWD_OTP_HideOrder&DisplayPage=Dashboard&Order_ID=" . $Order->Order_ID ."'>" . __("Hide", 'EWD_OTP') . "</a>";
		 						echo "</span>";
								echo "</div>";
								echo "<div class='hidden' id='inline_" . $Order->Order_ID ."'>";
								echo "<div class='number'>" . stripslashes($Order->Order_Number) . "</div>";
								echo "</div>";
								echo "</td>";
								echo "<td class='name column-name'>" . stripslashes($Order->Order_Name) . "</td>";
								echo "<td class='status column-status'>" . stripslashes($Order->Order_Status) . "</td>";
								if (in_array("Customer_Notes", $Order_Information)) {echo "<td class='customer-notes column-notes'>" . stripslashes($Order->Order_Customer_Notes) . "</td>";}
								echo "<td class='updated column-updated'>" . stripslashes($Order->Order_Status_Updated) . "</td>";
								echo "</tr>";
						}
				}
		?>

	</tbody>
</table>

<div class="tablenav bottom">
		<div class="alignleft actions">
				<!--<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'EWD_OTP') ?></option>
						<?php foreach ($Statuses as $Status) {echo "<option value='" . $Status . "'>" . $Status  . "</option>";} ?>
						<option value='hide'><?php _e("Hide Order", 'EWD_OTP') ?></option>
						<option value='delete'><?php _e("Delete", 'EWD_OTP') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'EWD_OTP') ?>"  />-->
		</div>
		<div class='tablenav-pages <?php if ($Number_of_Pages == 1) {echo "one-page";} ?>'>
				<span class="displaying-num"><?php echo $wpdb->num_rows; ?> <?php _e("items", 'EWD_OTP') ?></span>
				<span class='pagination-links'>
						<a class='first-page <?php if ($Page == 1) {echo "disabled";} ?>' title='Go to the first page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=1'>&laquo;</a>
						<a class='prev-page <?php if ($Page <= 1) {echo "disabled";} ?>' title='Go to the previous page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page-1;?>'>&lsaquo;</a>
						<span class="paging-input"><?php echo $Page; ?> <?php _e("of", 'EWD_OTP') ?> <span class='total-pages'><?php echo $Number_of_Pages; ?></span></span>
						<a class='next-page <?php if ($Page >= $Number_of_Pages) {echo "disabled";} ?>' title='Go to the next page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page+1;?>'>&rsaquo;</a>
						<a class='last-page <?php if ($Page == $Number_of_Pages) {echo "disabled";} ?>' title='Go to the last page' href='<?php echo $Current_Page_With_Order_By . "&Page=" . $Number_of_Pages; ?>'>&raquo;</a>
				</span>
		</div>
		<br class="clear" />
</div>
</form>

<br class="clear" />
</div>
</div>