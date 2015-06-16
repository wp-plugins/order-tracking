<?php 
$StatusString = get_option("EWD_OTP_Statuses"); 
$LocationsString = get_option("EWD_OTP_Locations");

$Order_Information_String = get_option("EWD_OTP_Order_Information");
$Order_Information = explode(",", $Order_Information_String);

?>
<div id="col-right">
<div class="col-wrap">
<?php //echo get_option('plugin_error'); ?>
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>

<?php 
			$Customers = $wpdb->get_results("SELECT * FROM $EWD_OTP_customers");
			$Sales_Reps = $wpdb->get_results("SELECT * FROM $EWD_OTP_sales_reps");
			if ($Sales_Rep_Only == "Yes") {
				$Current_User = wp_get_current_user();
				$Sql = "SELECT Sales_Rep_ID FROM $EWD_OTP_sales_reps WHERE Sales_Rep_WP_ID='" . $Current_User->ID . "'";
				$Sales_Rep_ID = $wpdb->get_var($Sql);
			}
			
			if (isset($_GET['Page'])) {$Page = $_GET['Page'];}
			else {$Page = 1;}
			
			$Sql = "SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Display='Yes' ";
				if (isset($_POST['OrderNumber'])) {$Sql .= "AND Order_Number LIKE '%" . $_POST['OrderNumber'] . "%' ";}
				if ($Sales_Rep_Only == "Yes") {$Sql .= " AND Sales_Rep_ID='" . $Sales_Rep_ID . "'";}
				if (isset($_GET['OrderBy']) and $_GET['DisplayPage'] == "Dashboard") {$Sql .= "ORDER BY " . $_GET['OrderBy'] . " " . $_GET['Order'] . " ";}
				else {$Sql .= "ORDER BY Order_Number ";}
				$Sql .= "LIMIT " . ($Page - 1)*20 . ",20";
				$myrows = $wpdb->get_results($Sql);
				if ($Sales_Rep_Only == "Yes") {$TotalOrders = $wpdb->get_results("SELECT Order_ID FROM $EWD_OTP_orders_table_name WHERE Order_Display='Yes' AND Sales_Rep_ID='" . $Sales_Rep_ID . "'");}
				else {$TotalOrders = $wpdb->get_results("SELECT Order_ID FROM $EWD_OTP_orders_table_name WHERE Order_Display='Yes'");}
				$Number_of_Pages = ceil($wpdb->num_rows/20);
				$Current_Page_With_Order_By = "admin.php?page=EWD-OTP-options&DisplayPage=Orders";
				if (isset($_GET['OrderBy'])) {$Current_Page_With_Order_By .= "&OrderBy=" .$_GET['OrderBy'] . "&Order=" . $_GET['Order'];}?>

<form action="admin.php?page=EWD-OTP-options&DisplayPage=Orders&Action=EWD_OTP_MassAction" method="post">    
<p class="search-box">
	<label class="screen-reader-text" for="post-search-input">Search Orders:</label>
	<input type="search" id="post-search-input" name="OrderNumber" value="">
	<input type="submit" name="" id="search-submit" class="button" value="Search Orders">
</p>
<div class="tablenav top">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'EWD_OTP') ?></option>
						<?php foreach ($Statuses as $Status) {echo "<option value='" . $Status . "'>" . $Status  . "</option>";} ?>
						<option value='hide'><?php _e("Hide Order", 'EWD_OTP') ?></option>
						<option value='delete'><?php _e("Delete", 'EWD_OTP') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'EWD_OTP') ?>"  />
				<a class='confirm button-secondary action' href='admin.php?page=EWD-OTP-options&Action=EWD_OTP_DeleteAllOrders&DisplayPage=Orders'>Delete All Orders</a>
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
					if ($_GET['OrderBy'] == "Order_Number" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Number&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Number&Order=ASC'>";} 
				?>
					<span><?php _e("Order Number", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='type' class='manage-column column-type sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Name&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Name&Order=ASC'>";} 
				?>
					<span><?php _e("Name", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Status&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Status&Order=ASC'>";} 
				?>
					<span><?php _e("Status", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<?php if (in_array("Customer_Notes", $Order_Information)) { ?>
				<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
					<?php 
						if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Customer_Notes&Order=DESC'>";}
						else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Customer_Notes&Order=ASC'>";} 
					?>
						<span><?php _e("Customer Notes", 'EWD_OTP') ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
			<?php } ?>
			<th scope='col' id='required' class='manage-column column-users sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status_Updated" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Status_Updated&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Status_Updated&Order=ASC'>";} 
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
					if ($_GET['OrderBy'] == "Order_Number" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Number&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Number&Order=ASC'>";} 
				?>
					<span><?php _e("Order Number", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='type' class='manage-column column-type sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Name&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Name&Order=ASC'>";} 
				?>
					<span><?php _e("Name", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Status&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Status&Order=ASC'>";} 
				?>
					<span><?php _e("Status", 'EWD_OTP') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<?php if (in_array("Customer_Notes", $Order_Information)) { ?>
				<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
					<?php 
						if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Customer_Notes&Order=DESC'>";}
						else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Customer_Notes&Order=ASC'>";} 
					?>
						<span><?php _e("Customer Notes", 'EWD_OTP') ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
			<?php } ?>
			<th scope='col' id='required' class='manage-column column-users sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status_Updated" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Status_Updated&Order=DESC'>";}
					else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Status_Updated&Order=ASC'>";} 
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
								echo "<a class='delete-tag' href='admin.php?page=EWD-OTP-options&Action=EWD_OTP_HideOrder&DisplayPage=Orders&Order_ID=" . $Order->Order_ID ."'>" . __("Hide", 'EWD_OTP') . "</a>";
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
<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&Action=EWD_OTP_AddOrder&DisplayPage=Orders" class="validate" enctype="multipart/form-data">
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
		<label for="Order_Location"><?php _e("Order Location", 'EWD_OTP') ?></label>
		<select name="Order_Location" id="Order_Location" />
		<?php $Locations = explode(",", $LocationsString);
			foreach ($Locations as $Location) { ?>
			<option value='<?php echo $Location; ?>'><?php echo $Location; ?></option>
		<?php } ?>
		</select>
		<p><?php _e("The location that visitors will see if they enter the order number.", 'EWD_OTP') ?></p>
</div>
<div>
		<label for="Customer_ID"><?php _e("Customer", 'EWD_OTP') ?></label>
		<select name="Customer_ID" id="Customer_ID" />
		<option value='0'>None</option>
		<?php foreach ($Customers as $Customer) { ?>
			<option value='<?php echo $Customer->Customer_ID; ?>'><?php echo $Customer->Customer_Name; ?></option>
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
					<option value='<?php echo $Sales_Rep->Sales_Rep_ID; ?>'><?php echo $Sales_Rep->Sales_Rep_First_Name . " " . $Sales_Rep->Sales_Rep_Last_Name; ?></option>
		<?php } ?>
		</select>
		<p><?php _e("The sales rep that this order is associated with.", 'EWD_OTP') ?></p>
</div>
<?php } ?>
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

<?php
$Sql = "SELECT * FROM $EWD_OTP_fields_table_name ";
$Fields = $wpdb->get_results($Sql);
$Value = "";
foreach ($Fields as $Field) {
		$ReturnString .= "<div class='form-field'><label for='" . $Field->Field_Name . "'>" . $Field->Field_Name . ":</label>";
		if ($Field->Field_Type == "text" or $Field->Field_Type == "mediumint") {
			  $ReturnString .= "<input name='" . $Field->Field_Name . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-input' type='text' value='" . $Value . "' />";
		}
		elseif ($Field->Field_Type == "textarea") {
				$ReturnString .= "<textarea name='" . $Field->Field_Name . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-textarea'>" . $Value . "</textarea>";
		} 
		elseif ($Field->Field_Type == "select") { 
				$Options = explode(",", $Field->Field_Values);
				$ReturnString .= "<select name='" . $Field->Field_Name . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-select'>";
				foreach ($Options as $Option) {
						$ReturnString .= "<option value='" . $Option . "' ";
						if (trim($Option) == trim($Value)) {$ReturnString .= "selected='selected'";}
						$ReturnString .= ">" . $Option . "</option>";
				}
				$ReturnString .= "</select>";
		} 
		elseif ($Field->Field_Type == "radio") {
				$Counter = 0;
				$Options = explode(",", $Field->Field_Values);
				foreach ($Options as $Option) {
						if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
						$ReturnString .= "<input type='radio' name='" . $Field->Field_Name . "' value='" . $Option . "' class='ewd-otp-radio' ";
						if (trim($Option) == trim($Value)) {$ReturnString .= "checked";}
						$ReturnString .= ">" . $Option;
						$Counter++;
				}
		} 
		elseif ($Field->Field_Type == "checkbox") {
  			$Counter = 0;
				$Options = explode(",", $Field->Field_Values);
				$Values = explode(",", $Value);
				foreach ($Options as $Option) {
						if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
						$ReturnString .= "<input type='checkbox' name='" . $Field->Field_Name . "[]' value='" . $Option . "' class='ewd-otp-checkbox' ";
						if (in_array($Option, $Values)) {$ReturnString .= "checked";}
						$ReturnString .= ">" . $Option . "</br>";
						$Counter++;
				}
		}
		elseif ($Field->Field_Type == "file") {
				$ReturnString .= "<input name='" . $Field->Field_Name . "' class='ewd-otp-file-input' type='file' value='' />";
		}
		elseif ($Field->Field_Type == "date") {
				$ReturnString .= "<input name='" . $Field->Field_Name . "' class='ewd-otp-date-input' type='date' value='' />";
		} 
		elseif ($Field->Field_Type == "datetime") {
				$ReturnString .= "<input name='" . $Field->Field_Name . "' class='ewd-otp-datetime-input' type='datetime-local' value='' />";
  	}
		$ReturnString .= " </div>";
}
echo $ReturnString;

?>

<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Add New Order', 'EWD_OTP') ?>"  /></p></form>

<h3><?php _e("Add/Update Orders from Spreadsheet", 'EWD_OTP') ?></h3>
<?php if ($EWD_OTP_Full_Version == "Yes") { ?>
<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&Action=EWD_OTP_AddOrderSpreadsheet&DisplayPage=Orders" class="validate" enctype="multipart/form-data">
<div class="form-field form-required">
		<label for="Orders_Spreadsheet"><?php _e("Spreadhseet Containing Orders", 'EWD_OTP') ?></label>
		<input name="Orders_Spreadsheet" id="Orders_Spreadsheet" type="file" value=""/>
		<p><?php _e("The spreadsheet containing all of the orders you wish to add. Make sure that the column title names are the same as the field names for orders (ex: Name, Number, Status, etc.), and that any statuses are written exactly the same as they are online. To update an order, make sure the order numbers are exactly the same.", 'EWD_OTP') ?></p>
</div>
<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Add New Orders', 'EWD_OTP') ?>"  /></p>
</form>
<?php } else { ?>
<div class="Info-Div">
		<h2><?php _e("Full Version Required!", 'EWD_OTP') ?></h2>
		<div class="upcp-full-version-explanation">
				<?php _e("The full version of Order Tracking is required to use custom fields.", "EWD_OTP");?><a href="http://www.etoilewebdesign.com/order-tracking/"><?php _e(" Please upgrade to unlock this page!", 'EWD_OTP'); ?></a>
		</div>
</div>
<?php } ?>
</div>

<h3><?php _e("Export Orders to Spreadsheet", 'EWD_OTP') ?></h3>
<?php if ($EWD_OTP_Full_Version == "Yes") { ?>
<div class="wrap">

<form method="post" action="admin.php?page=EWD-OTP-options&Action=EWD_OTP_ExportToExcel">
<p><?php _e("Downloads all orders currently in the database to Excel", 'EWD_OTP') ?></p>
<p class="submit"><input type="submit" name="Export_Submit" id="submit" class="button button-primary" value="Export to Excel"  /></p>
</form>
</div>
<?php } else { ?>

<?php } ?>

<br class="clear" />
</div>
</div><!-- /col-left -->
