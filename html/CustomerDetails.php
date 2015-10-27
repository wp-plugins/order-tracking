<?php $Customer = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_customers WHERE Customer_ID ='%d'", $_GET['Customer_ID'])); ?>
		
<div class="OptionTab ActiveTab" id="EditCustomer">
				
		<div id="col-left">
		<div class="col-wrap">
		<div class="form-wrap CustomerDetail">
				<a href="admin.php?page=EWD-OTP-options&DisplayPage=Customers" class="NoUnderline">&#171; <?php _e("Back", 'EWD_OTP') ?></a>
				<h3><?php echo __("Edit ", 'EWD_OTP') . $Customer->Customer_Name . __(" (Customer ID: ", 'EWD_OTP') . $Customer->Customer_ID . ")"; ?></h3>
				<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&Action=EWD_OTP_EditCustomer&DisplayPage=Customers" class="validate" enctype="multipart/form-data">
				<input type="hidden" name="action" value="Edit_Customers" />
				<input type="hidden" name="Customer_ID" value="<?php echo $Customer->Customer_ID; ?>" />
				<?php wp_nonce_field(); ?>
				<?php wp_referer_field(); ?>
				<div class="form-field">
						<label for="Customer_Name"><?php _e("Name", 'UPCP') ?></label>
						<input name="Customer_Name" id="Customer_Name" type="text" value="<?php echo $Customer->Customer_Name;?>" size="60" />
						<p><?php _e("The name of the customer.", 'EWD_OTP') ?></p>
				</div>
				<div class="form-field">
						<label for="Customer_Email"><?php _e("Email", 'UPCP') ?></label>
						<input name="Customer_Email" id="Customer_Email" type="text" value="<?php echo $Customer->Customer_Email;?>" size="60" />
						<p><?php _e("The email address of the customer.", 'EWD_OTP') ?></p>
				</div>
				<div class="form-field">
						<label for="Sales_Rep_ID"><?php _e("Sales Rep ID", 'EWD_OTP') ?></label>
						<input name="Sales_Rep_ID" id="Sales_Rep_ID" type="text" value="<?php echo $Customer->Sales_Rep_ID;?>" size="60" />
						<p><?php _e("The sales rep's ID for this customer.", 'EWD_OTP') ?></p>
				</div>
				<div class="form-field">
					<label for="Customer_WP_ID"><?php _e("Customer WP Username:", 'EWD_OTP') ?></label>
					<select name="Customer_WP_ID" id="Customer_WP_ID">
					<option value=""></option>
					<?php 
						$Blog_ID = get_current_blog_id();
						$Users = get_users( 'blog_id=' . $Blog_ID ); 
						foreach ($Users as $User) {
							echo "<option value='" . $User->ID . "' ";
							if ($User->ID == $Customer->Customer_WP_ID) {echo "selected='selected'";}
							echo " >" . $User->display_name . "</option>";
						} 
					?>
					</select>
					<p><?php _e("What WordPress user, if any, is assigned to this customer?", 'EWD_OTP') ?></p>
				</div>
				<div class="form-field">
					<label for="Customer_FEUP_ID"><?php _e("Customer FEUP Username:", 'EWD_OTP') ?></label>
					<select name="Customer_FEUP_ID" id="Customer_FEUP_ID">
					<option value=""></option>
					<?php 
						if (function_exists("EWD_FEUP_Get_All_Users")) {$Users = EWD_FEUP_Get_All_Users();}
						else {$Users = array();}
						foreach ($Users as $User) {
							echo "<option value='" . $User->Get_User_ID() . "' ";
							if ($User->Get_User_ID() == $Customer->Customer_FEUP_ID) {echo "selected='selected'";}
							echo " >" . $User->Get_Username() . "</option>";
						} 
					?>
					</select>
					<p><?php _e("What FEUP user, if any, is assigned to this customer? For more information on FEUP users:", 'EWD_OTP') ?><a href="https://wordpress.org/plugins/front-end-only-users/">https://wordpress.org/plugins/front-end-only-users/</a></p>
				</div>
				<?php
						
						$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Customers'";
						$Fields = $wpdb->get_results($Sql);
						$MetaValues = $wpdb->get_results($wpdb->prepare("SELECT Field_ID, Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Customer_ID=%d", $_GET['Customer_ID']));
						unset($ReturnString);
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

				<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'EWD_OTP') ?>" /></p>
				</form>
		</div>
		</div>
		</div>
			
</div>
