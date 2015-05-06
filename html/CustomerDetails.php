<?php $Customer = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_customers WHERE Customer_ID ='%d'", $_GET['Customer_ID'])); ?>
		
<div class="OptionTab ActiveTab" id="EditCustomer">
				
		<div id="col-left">
		<div class="col-wrap">
		<div class="form-wrap CustomerDetail">
				<a href="admin.php?page=EWD-OTP-options&DisplayPage=Customers" class="NoUnderline">&#171; <?php _e("Back", 'EWD_OTP') ?></a>
				<h3>Edit <?php echo $Customer->Customer_Name;?></h3>
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

				<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'EWD_OTP') ?>" /></p>
				</form>
		</div>
		</div>
		</div>
			
</div>
