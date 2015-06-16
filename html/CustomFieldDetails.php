<?php $Field = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_ID ='%d'", $_GET['Field_ID'])); ?>
		
		<div class="OptionTab ActiveTab" id="EditCustomField">
				
				<div id="col-left">
				<div class="col-wrap">
				<div class="form-wrap TagDetail">
						<a href="admin.php?page=EWD-OTP-options&DisplayPage=CustomFields" class="NoUnderline">&#171; <?php _e("Back", 'EWD_OTP') ?></a>
						<h3>Edit <?php echo $Field->Field_Name;?></h3>
						<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&Action=EWD_OTP_EditCustomField&DisplayPage=CustomFields" class="validate" enctype="multipart/form-data">
						<input type="hidden" name="action" value="Edit_Custom_Field" />
						<input type="hidden" name="Field_ID" value="<?php echo $Field->Field_ID; ?>" />
						<?php wp_nonce_field(); ?>
						<?php wp_referer_field(); ?>
						<div class="form-field form-required">
								<label for="Field_Name"><?php _e("Name", 'EWD_OTP') ?></label>
								<input name="Field_Name" id="Field_Name" type="text" value="<?php echo $Field->Field_Name;?>" size="60" />
								<p><?php _e("The name of the field you will see.", 'EWD_OTP') ?></p>
						</div>
						<div class="form-field form-required">
								<label for="Field_Slug"><?php _e("Slug", 'EWD_OTP') ?></label>
								<input name="Field_Slug" id="Field_Slug" type="text" value="<?php echo $Field->Field_Slug;?>" size="60" />
								<p><?php _e("An all-lowercase name that will be used to insert the field.", 'EWD_OTP') ?></p>
						</div>
						<div class="form-field">
								<label for="Field_Type"><?php _e("Type", 'EWD_OTP') ?></label>
								<select name="Field_Type" id="Field_Type">
										<option value='text' <?php if ($Field->Field_Type == "text") {echo "selected=selected";} ?>><?php _e("Short Text", 'EWD_OTP') ?></option>
										<option value='mediumint' <?php if ($Field->Field_Type == "mediumint") {echo "selected=selected";} ?>><?php _e("Integer", 'EWD_OTP') ?></option>
										<option value='select' <?php if ($Field->Field_Type == "select") {echo "selected=selected";} ?>><?php _e("Select Box", 'EWD_OTP') ?></option>
										<option value='radio' <?php if ($Field->Field_Type == "radio") {echo "selected=selected";} ?>><?php _e("Radio Button", 'EWD_OTP') ?></option>
										<option value='checkbox' <?php if ($Field->Field_Type == "checkbox") {echo "selected=selected";} ?>><?php _e("Checkbox", 'EWD_OTP') ?></option>
										<option value='textarea' <?php if ($Field->Field_Type == "textarea") {echo "selected=selected";} ?>><?php _e("Text Area", 'EWD_OTP') ?></option>
										<option value='file' <?php if ($Field->Field_Type == "file") {echo "selected=selected";} ?>><?php _e("File", 'EWD_OTP') ?></option>
										<option value='date' <?php if ($Field->Field_Type == "date") {echo "selected=selected";} ?>><?php _e("Date", 'EWD_OTP') ?></option>
										<option value='datetime' <?php if ($Field->Field_Type == "datetime") {echo "selected=selected";} ?>><?php _e("Date/Time", 'EWD_OTP') ?></option>
								</select>
								<p><?php _e("The input method for the field and type of data that the field will hold.", 'EWD_OTP') ?></p>
						</div>
						<div class="form-field">
								<label for="Field_Description"><?php _e("Description", 'EWD_OTP') ?></label>
								<textarea name="Field_Description" id="Field_Description" rows="2" cols="40"><?php echo $Field->Field_Description;?></textarea>
								<p><?php _e("The description of the field, which you will see as the instruction for the field.", 'EWD_OTP') ?></p>
						</div>
						<div class="form-field">
								<label for="Field_Values"><?php _e("Input Values", 'EWD_OTP') ?></label>
								<input name="Field_Values" id="Field_Values" type="text" value="<?php echo $Field->Field_Values;?>"  size="60" />
								<p><?php _e("A comma-separated list of acceptable input values for this field. These values will be the options for select, checkbox, and radio inputs. All values will be accepted if left blank.", 'EWD_OTP') ?></p>
						</div>
						<div class="form-field">
								<label for="Field_Front_End_Display"><?php _e("Customer Order Display", 'EWD_OTP') ?></label>
								<select name="Field_Front_End_Display" id="Field_Front_End_Display">
										<option value='No' <?php if ($Field->Field_Front_End_Display == "No") {echo "selected=selected";} ?>><?php _e("No", 'EWD_OTP') ?></option>
										<option value='Yes' <?php if ($Field->Field_Front_End_Display == "Yes") {echo "selected=selected";} ?>><?php _e("Yes", 'EWD_OTP') ?></option>
								</select>
								<p><?php _e("If you're using the customer order form, should this field be displayed on it? (Use 'Input Values' above to restrict inputs)", 'EWD_OTP') ?></p>
						</div>

						<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'EWD_OTP') ?>"  /></p>
						</form>
				</div>
				</div>
				</div>
		</div>
