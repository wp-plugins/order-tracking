<?php $SalesRep = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_sales_reps WHERE Sales_Rep_ID ='%d'", $_GET['Sales_Rep_ID'])); ?>
		
<div class="OptionTab ActiveTab" id="EditSalesRep">
				
		<div id="col-left">
		<div class="col-wrap">
		<div class="form-wrap SalesRepDetail">
				<a href="admin.php?page=EWD-OTP-options&DisplayPage=SalesReps" class="NoUnderline">&#171; <?php _e("Back", 'EWD_OTP') ?></a>
				<h3>Edit <?php echo $SalesRep->Sales_Rep_First_Name . " " . $SalesRep->Sales_Rep_Last_Name; ?></h3>
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

				<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'EWD_OTP') ?>" /></p>
				</form>
		</div>
		</div>
		</div>
			
</div>
