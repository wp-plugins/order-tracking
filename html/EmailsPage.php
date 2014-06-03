<?php 
		$Admin_Email = get_option("EWD_OTP_Admin_Email");
		$Encrypted_Admin_Password = get_option("EWD_OTP_Admin_Password");
		$SMTP_Mail_Server = get_option("EWD_OTP_SMTP_Mail_Server");
		$Message_Body = get_option("EWD_OTP_Message_Body");
		
		$key = 'EWD_OTP';
		$Admin_Password = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($Encrypted_Admin_Password), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div><h2>Email Settings</h2>

<form method="post" action="admin.php?page=EWD-OTP-options&DisplayPage=Emails&Action=UpdateEmailSettings">
<table class="form-table">
<tr>
<th scope="row">"Send-From" Email Address</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Email Address</span></legend>
	<label title='Email Address'><input type='text' name='admin_email' value='<?php echo $Admin_Email; ?>' /> </label><br />
	<p>The email address that order messages should be sent from.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Message Body</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Message Body</span></legend>
	<label title='Message Body'></label><textarea class='ewd-otp-textarea' name='message_body'> <?php echo $Message_Body; ?></textarea><br />
	<p>What should be in the messages sent to users? You can put [order-number], [order-status], [order-notes] and [order-time] into the message, to include current order number, order status, public order notes or the time the order was updated.</p>
	</fieldset>
</td>
</tr>
<h3>SMTP Mail Settings</h3>
<tr>
<th scope="row">SMTP Mail Server Address</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>SMTP Mail Server Address</span></legend>
	<label title='Mail Server'><input type='text' name='smtp_mail_server' value='<?php echo $SMTP_Mail_Server; ?>' /> </label><br />
	<p>The server that should be connected to for SMTP e-mail, if you'd like to use SMTP to send your e-mails.</p>
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
</table>


<p class="submit"><input type="submit" name="Options_Submit" id="submit" class="button button-primary" value="Save Changes"  /></p></form>

</div>