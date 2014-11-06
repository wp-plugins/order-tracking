<?php 
function EWD_OTP_SetUpdateOptions() {
		update_option('EWD_OTP_Update_Flag', "Yes");
}

add_filter('upgrader_pre_install', 'EWD_OTP_SetUpdateOptions', 10, 2);

 ?>