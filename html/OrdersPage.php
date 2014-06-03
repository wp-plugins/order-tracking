<?php $StatusString = get_option("EWD_OTP_Statuses"); ?>
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
				$num_rows = $wpdb->num_rows; 
				$Number_of_Pages = ceil($wpdb->num_rows/20);
				$Current_Page_With_Order_By = "admin.php?page=EWD-OTP-options&DisplayPage=Dashboard";
				if (isset($_GET['OrderBy'])) {$Current_Page_With_Order_By .= "&OrderBy=" .$_GET['OrderBy'] . "&Order=" . $_GET['Order'];}?>

<form action="admin.php?page=EWD-OTP-options&Action=MassAction" method="post">    
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
										<?php if ($_GET['OrderBy'] == "Order_Number" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Number&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Number&Order=ASC'>";} ?>
											  <span><?php _e("Order Number", 'EWD_OTP') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='type' class='manage-column column-type sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Order_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Name&Order=ASC'>";} ?>
											  <span><?php _e("Name", 'EWD_OTP') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status&Order=ASC'>";} ?>
											  <span><?php _e("Status", 'EWD_OTP') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='required' class='manage-column column-users sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Order_Status_Updated" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status_Updated&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status_Updated&Order=ASC'>";} ?>
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
										<?php if ($_GET['OrderBy'] == "Order_Number" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Number&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Number&Order=ASC'>";} ?>
											  <span><?php _e("Order Number", 'EWD_OTP') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='type' class='manage-column column-type sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Order_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Name&Order=ASC'>";} ?>
											  <span><?php _e("Name", 'EWD_OTP') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status&Order=ASC'>";} ?>
											  <span><?php _e("Status", 'EWD_OTP') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='required' class='manage-column column-users sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Order_Status_Updated" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status_Updated&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Dashboard&OrderBy=Order_Status_Updated&Order=ASC'>";} ?>
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
								echo "<a class='row-title' href='admin.php?page=EWD-OTP-options&Action=Order_Details&Selected=Order&Order_ID=" . $Order->Order_ID ."' title='Edit " . $Order->Order_Number . "'>" . $Order->Order_Number . "</a></strong>";
								echo "<br />";
								echo "<div class='row-actions'>";
								echo "<span class='delete'>";
								echo "<a class='delete-tag' href='admin.php?page=EWD-OTP-options&Action=HideOrder&DisplayPage=Dashboard&Order_ID=" . $Order->Order_ID ."'>" . __("Hide", 'EWD_OTP') . "</a>";
		 						echo "</span>";
								echo "</div>";
								echo "<div class='hidden' id='inline_" . $Order->Order_ID ."'>";
								echo "<div class='number'>" . $Order->Order_Number . "</div>";
								echo "</div>";
								echo "</td>";
								echo "<td class='description column-name'>" . $Order->Order_Name . "</td>";
								echo "<td class='description column-status'>" . $Order->Order_Status . "</td>";
								echo "<td class='users column-updated'>" . $Order->Order_Status_Updated . "</td>";
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
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'EWD_OTP') ?>"  />
				-->
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

<div id="col-left">
<div class="col-wrap">

<div class="form-wrap">
<h2><?php _e("Add New Order", 'EWD_OTP') ?></h2>
<!-- Form to create a new order -->
<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&Action=AddOrder&DisplayPage=Orders" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Add_Order" />
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>
<div class="form-field form-required">
	<label for="Order_Name"><?php _e("Name", 'EWD_OTP') ?></label>
	<input name="Order_Name" id="Order_Name" type="text" value="" size="60" />
	<p><?php _e("The name of the order your users will see.", 'EWD_OTP') ?></p>
</div>
<div class="form-field">
	<label for="Order_Number"><?php _e("Order Number", 'EWD_OTP') ?></label>
	<input name="Order_Number" id="Order_Number" />
	<p><?php _e("The number that visitors will search to find the order.", 'EWD_OTP') ?></p>
</div>
<div class="form-field">
	<label for="Order_Email"><?php _e("Order Email", 'EWD_OTP') ?></label>
	<input type='text' name="Order_Email" id="Order_Email" />
	<p><?php _e("The e-mail address to send order updates to, if you have selected that option.", 'EWD_OTP') ?></p>
</div>
<div>
		<label for="Order_Status"><?php _e("Order Status", 'EWD_OTP') ?></label>
		<select name="Order_Status" id="Order_Status" />
		<?php $Statuses = explode(",", $StatusString);
					foreach ($Statuses as $Status) { ?>
					<option value='<?php echo $Status; ?>'><?php echo $Status; ?></option>
		<?php } ?>
		</select>
		<p><?php _e("The status that visitors will see if they enter the order number.", 'EWD_OTP') ?></p>
</div>
<div>
		<label for="Order_Notes_Public"><?php _e("Public Order Notes", 'EWD_OTP') ?></label>
		<input name="Order_Notes_Public" id="Order_Notes_Public" />
		<p><?php _e("The notes that visitors will see if they enter the order number, and you've included 'Notes' on the options page.", 'EWD_OTP') ?></p>
</div>
<div>
		<label for="Order_Notes_Private"><?php _e("Private Order Notes", 'EWD_OTP') ?></label>
		<input name="Order_Notes_Private" id="Order_Notes_Private" />
		<p><?php _e("The notes about an order visible only to admins.", 'EWD_OTP') ?></p>
</div>
<div>
		<label for="Order_Display"><?php _e("Show in Admin Table?", 'EWD_OTP') ?></label>
		<input type='radio' name="Order_Display" value="Yes" checked>Yes<br/>
		<input type='radio' name="Order_Display" value="No">No<br/>
		<p><?php _e("Should this order appear in the orders table in the admin area?", 'EWD_OTP') ?></p>
</div>

<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Add New Order', 'EWD_OTP') ?>"  /></p></form>

</div>

<br class="clear" />
</div>
</div><!-- /col-left -->
