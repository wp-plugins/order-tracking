<?php /* if ($Full_Version == "Yes") { ?>
<div id="col-right">
<div class="col-wrap">

<!-- Display a list of the segments which have already been created -->
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>

<?php 
			if (isset($_GET['Page'])) {$Page = $_GET['Page'];}
			else {$Page = 1;}
			
			$Sql = "SELECT * FROM $EWD_OTP_adv_segments_table_name ";
				if (isset($_GET['OrderBy']) and $_GET['DisplayPage'] == "Advanced") {$Sql .= "ORDER BY " . $_GET['OrderBy'] . " " . $_GET['Order'] . " ";}
				else {$Sql .= "ORDER BY Segment_Start_Date ";}
				$Sql .= "LIMIT " . ($Page - 1)*20 . ",20";
				$myrows = $wpdb->get_results($Sql);
				$TotalSegements = $wpdb->get_results("SELECT Segment_ID FROM $EWD_OTP_adv_segments_table_name");
				$num_rows = $wpdb->num_rows; 
				$Number_of_Pages = ceil($wpdb->num_rows/20);
				$Current_Page_With_Order_By = "admin.php?page=EWD-OTP-options&DisplayPage=Advanced";
				if (isset($_GET['OrderBy'])) {$Current_Page_With_Order_By .= "&OrderBy=" .$_GET['OrderBy'] . "&Order=" . $_GET['Order'];}?>

<form action="admin.php?page=EWD-OTP-options&Action=MassDeleteSegments&DisplayPage=Advanced" method="post"> 
<div class="tablenav top">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'EWD_OTP')?></option>
						<option value='delete'><?php _e("Delete", 'EWD_OTP') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="Apply"  />
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
								<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Segment_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Advanced&OrderBy=Segment_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Advanced&OrderBy=Segment_Name&Order=ASC'>";} ?>
											  <span><?php _e("Name", 'EWD_OTP') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Segment_Start_Date" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Advanced&OrderBy=Segment_Start_Date&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Advanced&OrderBy=Segment_Start_Date&Order=ASC'>";} ?>
											  <span><?php _e("Start Date", 'EWD_OTP') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='requirements' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Segment_End_Date" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Advanced&OrderBy=Segment_End_Date&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Advanced&OrderBy=Segment_End_Date&Order=ASC'>";} ?>
											  <span><?php _e("End Date", 'EWD_OTP') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
				</tr>
		</thead>

		<tfoot>
				<tr>
						<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
								<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Segment_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Advanced&OrderBy=Segment_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Advanced&OrderBy=Segment_Name&Order=ASC'>";} ?>
											  <span><?php _e("Name", 'EWD_OTP') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Segment_Start_Date" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Advanced&OrderBy=Segment_Start_Date&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Advanced&OrderBy=Segment_Start_Date&Order=ASC'>";} ?>
											  <span><?php _e("Start Date", 'EWD_OTP') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='requirements' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Segment_End_Date" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Advanced&OrderBy=Segment_End_Date&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Advanced&OrderBy=Segment_End_Date&Order=ASC'>";} ?>
											  <span><?php _e("End Date", 'EWD_OTP') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
				</tr>
		</tfoot>

	<tbody id="the-list" class='list:tag'>
		
		 <?php
				if ($myrows) { 
	  			  foreach ($myrows as $Segment) {
								echo "<tr id='Item" . $Segment->Segment_ID ."'>";
								echo "<th scope='row' class='check-column'>";
								echo "<input type='checkbox' name='Segments_Bulk[]' value='" . $Segment->Segment_ID ."' />";
								echo "</th>";
								echo "<td class='name column-name'>";
								echo "<strong>" . $Segment->Segment_Name . "</strong>";
								echo "<br />";
								echo "<div class='row-actions'>";
								//echo "<span class='edit'>";
								//echo "<a href='admin.php?page=EWD-OTP-options&Action=Tag_Details&Selected=Tag&Tag_ID=" . $Tag->Tag_ID ."'>Edit</a>";
		 						//echo " | </span>";
								echo "<span class='delete'>";
								echo "<a class='delete-tag' href='admin.php?page=EWD-OTP-options&Action=DeleteSegment&DisplayPage=Advanced&Segment_ID=" . $Segment->Segment_ID ."'>" . __("Delete", 'EWD_OTP') . "</a>";
		 						echo "</span>";
								echo "</div>";
								echo "<div class='hidden' id='inline_" . $Segment->Segment_ID ."'>";
								echo "<div class='name'>" . $Segment->Segment_Name . "</div>";
								echo "</div>";
								echo "</td>";
								echo "<td class='description column-start-date'>" . $Segment->Segment_Start_Date . "</td>";
								echo "<td class='description column-end-date'>" . $Segment->Segment_End_Date . "</td>";
								echo "</tr>";
						}
				}
		?>

	</tbody>
</table>

<div class="tablenav bottom">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'EWD_OTP') ?></option>
						<option value='MassDelete'><?php _e("Delete", 'EWD_OTP') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'EWD_OTP')?>"  />
		</div>
		<div class='tablenav-pages <?php if ($Number_of_Pages == 1) {echo "one-page";} ?>'>
				<span class="displaying-num"><?php echo $wpdb->num_rows; ?> <?php _e("items", 'EWD_OTP') ?></span>
				<span class='pagination-links'>
						<a class='first-page <?php if ($Page == 1) {echo "disabled";} ?>' title='Go to the first page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=1'>&laquo;</a>
						<a class='prev-page <?php if ($Page <= 1) {echo "disabled";} ?>' title='Go to the previous page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page-1;?>'>&lsaquo;</a>
						<span class="paging-input"><?php echo $Page; ?> <?php _e("of", 'EWD_OTP') ?> <span class='total-pages'><?php echo $Number_of_Pages; ?></span></span>
						<a class='next-page <?php if ($Page >= $Number_of_Pages) {_e("disabled", "EWD_OTP");} ?>' title='Go to the next page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page+1;?>'>&rsaquo;</a>
						<a class='last-page <?php if ($Page == $Number_of_Pages) {_e("disabled", "EWD_OTP");} ?>' title='Go to the last page' href='<?php echo $Current_Page_With_Order_By . "&Page=" . $Number_of_Pages; ?>'>&raquo;</a>
				</span>
		</div>
		<br class="clear" />
</div>
</form>

<br class="clear" />
</div>
</div>

<!-- Form to create a new tag -->
<div id="col-left">
<div class="col-wrap">

<div class="form-wrap">
<h3><?php _e("Add a New Tag", 'EWD_OTP') ?></h3>
<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&Action=AddSegment&DisplayPage=Advanced" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Add_Segment" />
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>
<div class="form-field form-required">
	<label for="Segment_Name"><?php _e("Name", 'EWD_OTP')?></label>
	<input name="Segment_Name" id="Segment_Name" type="text" value="" size="60" />
	<p><?php _e("The name of the segment for your own purposes.", 'EWD_OTP') ?></p>
</div>
<div class="form-field">
	<label for="Segment_Start_Date"><?php _e("Start Date", 'EWD_OTP') ?></label>
	<input name="Segment_Start_Date" id="Segment_Start_Date" type="text" value="" size="60" />
	<p><?php _e("The start date of the segment. The correct format is yyyy-mm-dd.", 'EWD_OTP') ?></p>
</div>
<div class="form-field">
	<label for="Segment_End_Date"><?php _e("End Date", 'EWD_OTP') ?></label>
	<input name="Segment_End_Date" id="Segment_End_Date" type="text" value="" size="60">
	<p><?php _e("The end date of the segment. The correct format is yyyy-mm-dd.", 'EWD_OTP') ?></p>
</div>

<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Add New Segment', 'EWD_OTP') ?>"  /></p></form></div>
<br class="clear" />
</div>
</div>


	<!--<form method="get" action=""><table style="display: none"><tbody id="inlineedit">
		<tr id="inline-edit" class="inline-edit-row" style="display: none"><td colspan="4" class="colspanchange">

			<fieldset><div class="inline-edit-col">
				<h4>Quick Edit</h4>

				<label>
					<span class="title">Name</span>
					<span class="input-text-wrap"><input type="text" name="name" class="ptitle" value="" /></span>
				</label>
					<label>
					<span class="title">Slug</span>
					<span class="input-text-wrap"><input type="text" name="slug" class="ptitle" value="" /></span>
				</label>
				</div></fieldset>
	
		<p class="inline-edit-save submit">
			<a accesskey="c" href="#inline-edit" title="Cancel" class="cancel button-secondary alignleft">Cancel</a>
						<a accesskey="s" href="#inline-edit" title="Update Level" class="save button-primary alignright">Update Level</a>
			<img class="waiting" style="display:none;" src="<?php echo ABSPATH . 'wp-admin/images/wpspin_light.gif'?>" alt="" />
			<span class="error" style="display:none;"></span>
			<input type="hidden" id="_inline_edit" name="_inline_edit" value="fb59c3f3d1" />			<input type="hidden" name="taxonomy" value="wmlevel" />
			<input type="hidden" name="post_type" value="post" />
			<br class="clear" />
		</p>
		</td></tr>
		</tbody></table></form>-->
		
<!--</div>-->
<?php /* ?> } else { ?>
<div class="Info-Div">
		<h2><?php _e("Full Version Required!", 'EWD_OTP') ?></h2>
		<div class="upcp-full-version-explanation">
				<?php _e("The full version of the Ultimate Product Catalogue Plugin is required to use tags.", "EWD_OTP");?><a href="http://www.etoilewebdesign.com/ultimate-product-catalogue-plugin/"><?php _e(" Please upgrade to unlock this page!", 'EWD_OTP'); ?></a>
		</div>
</div>
<?php } */?>	