<?php $SalesRep = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_sales_reps WHERE Sales_Rep_ID ='%d'", $_GET['Sales_Rep_ID'])); ?>
		
<div class="OptionTab ActiveTab" id="EditSalesRep">
				
		<div id="col-left">
		<div class="col-wrap">
		<div class="form-wrap SalesRepDetail">
				<a href="admin.php?page=EWD-OTP-options&DisplayPage=SalesReps" class="NoUnderline">&#171; <?php _e("Back", 'EWD_OTP') ?></a>
				<h3><?php echo __("Edit ", 'EWD_OTP') . $SalesRep->Sales_Rep_First_Name . " " . $SalesRep->Sales_Rep_Last_Name . __(" (Sales Rep ID: ", 'EWD_OTP') . $SalesRep->Sales_Rep_ID . ")"; ?></h3>
				<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&Action=EWD_OTP_EditSalesRep&DisplayPage=SalesReps" class="validate" enctype="multipart/form-data">
				<input type="hidden" name="action" value="Edit_Sales_Rep" />
				<input type="hidden" name="Sales_Rep_ID" value="<?php echo $SalesRep->Sales_Rep_ID; ?>" />
				<?php wp_nonce_field(); ?>
				<?php wp_referer_field(); ?>
				<div class="form-field">
						<label for="Sales_Rep_First_Name"><?php _e("First Name", 'UPCP') ?></label>
						<input name="Sales_Rep_First_Name" id="Sales_Rep_First_Name" type="text" value="<?php echo $SalesRep->Sales_Rep_First_Name;?>" size="60" />
						<p><?php _e("The first name of the sales rep.", 'EWD_OTP') ?></p>
				</div>
				<div class="form-field">
						<label for="Sales_Rep_Last_Name"><?php _e("Last Name", 'EWD_OTP') ?></label>
						<input name="Sales_Rep_Last_Name" id="Sales_Rep_Last_Name" type="text" value="<?php echo $SalesRep->Sales_Rep_Last_Name;?>" size="60" />
						<p><?php _e("The last name of the sales rep.", 'EWD_OTP') ?></p>
				</div>
				<div class="form-field">
					<label for="Sales_Rep_WP_ID"><?php _e("Sales Rep WP Username:", 'EWD_OTP') ?></label>
					<select name="Sales_Rep_WP_ID" id="Sales_Rep_WP_ID">
					<option value=""></option>
					<?php 
						$Blog_ID = get_current_blog_id();
						$Users = get_users( 'blog_id=' . $Blog_ID ); 
						foreach ($Users as $User) {
							echo "<option value='" . $User->ID . "' ";
							if ($User->ID == $SalesRep->Sales_Rep_WP_ID) {echo "selected='selected'";}
							echo " >" . $User->display_name . "</option>";
						} 
					?>
					</select>
					<p><?php _e("What WordPress user should be able to update the orders assigned to this Sales Rep?", 'EWD_OTP') ?></p>
				</div>

				<?php
						
						$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Sales_Reps'";
						$Fields = $wpdb->get_results($Sql);
						$MetaValues = $wpdb->get_results($wpdb->prepare("SELECT Field_ID, Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Sales_Rep_ID=%d", $_GET['Sales_Rep_ID']));
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
