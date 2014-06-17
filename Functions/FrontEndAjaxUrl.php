<?php
$AJAX_Reload = get_option("EWD_OTP_AJAX_Reload");

if ($AJAX_Reload == "Yes") {
	 add_action('wp_head','upcp_frontend_ajaxurl');
}


function upcp_frontend_ajaxurl() {
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
}
?>