<?php 
	$Admin_Email = get_option("EWD_OTP_Admin_Email");
	$From_Name = get_option("EWD_OTP_From_Name");
	$Username = get_option("EWD_OTP_Username");
	$Encrypted_Admin_Password = get_option("EWD_OTP_Admin_Password");
	$Port = get_option("EWD_OTP_Port");
	$Use_SMTP = get_option("EWD_OTP_Use_SMTP");
	$SMTP_Mail_Server = get_option("EWD_OTP_SMTP_Mail_Server");
	$Encryption_Type = get_option("EWD_OTP_Encryption_Type");
	$Message_Body = get_option("EWD_OTP_Message_Body");
    $Subject_Line = get_option("EWD_OTP_Subject_Line"); 
    $Tracking_Page = get_option("EWD_OTP_Tracking_Page");
		
	$key = 'EWD_OTP';
	if (function_exists('mcrypt_decrypt')) {$Admin_Password = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($Encrypted_Admin_Password), MCRYPT_MODE_CBC, md5(md5($key))), "\0");}
	else {$Admin_Password = $Encrypted_Admin_Password;}
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div><h2>Email Settings</h2>

<form method="post" action="admin.php?page=EWD-OTP-options&DisplayPage=Emails&Action=EWD_OTP_UpdateEmailSettings">
<table class="form-table">
<tr>
<th scope="row">"Send-From" Email Address</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Email Address</span></legend>
	<label title='Email Address'><input type='text' name='admin_email' value='<?php echo $Admin_Email; ?>' /> </label><br />
	<p>The email address that order messages should be sent from to users.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">"Send-From" Name</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Email Address</span></legend>
	<label title='Email Address'><input type='text' name='from_name' value='<?php echo $From_Name; ?>' /> </label><br />
	<p>The name on the e-mail account that order messages should be sent from to users.</p>
	</fieldset>
</td>
</tr>

<tr>
<th scope="row">Subject Line</th>
<td>
    <fieldset><legend class="screen-reader-text"><span>Subject Line</span></legend>
    <label title='Subject Line'><input type='text' name='subject_line' value='<?php echo $Subject_Line; ?>' /> </label><br />
    <p>The subject line for your e-mails.</p>
    </fieldset>
</td>
</tr>

<tr>
<th scope="row">Message Body</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Message Body</span></legend>
	<label title='Message Body'></label><textarea class='ewd-otp-textarea' name='message_body'> <?php echo $Message_Body; ?></textarea><br />
	<p>What should be in the messages sent to users? You can put [order-name], [order-number], [order-status], [order-notes] and [order-time] into the message, to include current order name, order number, order status, public order notes or the time the order was updated.</p>
	<p>You can also use [tracking-link], [customer-name], [sales-rep] or the slug of a customer field enclosed in square brackets to include those fields in the e-mail.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Order Tracking URL</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Order Tracking URL</span></legend>
	<label title='Tracking URL'><input type='text' name='tracking_page' value='<?php echo $Tracking_Page; ?>' /> </label><br />
	<p>The URL of your tracking page, required if you want to include a tracking link in your message body.</p>
	</fieldset>
</td>
</tr>
</table>
<h3>SMTP Mail Settings</h3>
<table class="form-table">
<tr>
<th scope="row">Use SMTP</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Use SMTP</span></legend>
	<label title='Yes'><input type='radio' name='use_smtp' value='Yes' <?php if($Use_SMTP == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label>
	<label title='No'><input type='radio' name='use_smtp' value='No' <?php if($Use_SMTP == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
	<p>Should SMTP be used to send order e-mails?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">SMTP Mail Server Address</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>SMTP Mail Server Address</span></legend>
	<label title='Mail Server'><input type='text' name='smtp_mail_server' value='<?php echo $SMTP_Mail_Server; ?>' /> </label><br />
	<p>The server that should be connected to for SMTP e-mail, if you're using SMTP to send your e-mails.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">SMTP Port</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>SMTP Port</span></legend>
	<label title='Port'><input type='text' name='port' value='<?php echo $Port; ?>' /> </label><br />
	<p>The port that should be used to send e-mail.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">SMTP Username</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>SMTP Username</span></legend>
	<label title='Username'><input type='text' name='username' value='<?php echo $Username; ?>' /> </label><br />
	<p>The username for your email account, if you'd like to use SMTP to send your e-mails.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">SMTP Mail Password</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>SMTP Mail Password</span></legend>
	<label title='Email Password'><input type='password' name='admin_password' value='<?php echo $Admin_Password; ?>' /> </label><br />
	<p>The password for your email account, if you'd like to use SMTP to send your e-mails.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Encryption Type</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Encryption Type</span></legend>
	<label title='SSL'><input type='radio' name='encryption_type' value='ssl' <?php if($Encryption_Type == "ssl") {echo "checked='checked'";} ?> /> <span>SSL</span></label>
	<label title='TSL'><input type='radio' name='encryption_type' value='tsl' <?php if($Encryption_Type == "tsl") {echo "checked='checked'";} ?> /> <span>TSL</span></label><br />
	<p>What ecryption type should be used to send order e-mails?</p>
	</fieldset>
</td>
</tr>
</table>


<p class="submit"><input type="submit" name="Options_Submit" id="submit" class="button button-primary" value="Save Changes"  /></p></form>

</div>