jQuery(document).ready(function() {
		jQuery("#ewd-otp-tracking-form").submit(function( event ) {
				event.preventDefault();
				EWD_OTP_Ajax_Reload();
		});
});


function EWD_OTP_Ajax_Reload() {
		var OrderNumber = jQuery('#ewd-otp-tracking-number').val();
		var FieldLabels = jQuery('#ewd-otp-field-labels').val();
		var OrderEmail = jQuery('#ewd-otp-email').val();
		jQuery('.ewd-otp-ajax-results').html('<h3>Retrieving results...</h3>');
		
		var data = 'Tracking_Number=' + OrderNumber + '&Field_Labels=' + FieldLabels + '&Order_Email=' + OrderEmail + '&action=ewd_otp_update_orders';
		jQuery.post(ajaxurl, data, function(response) {
				response = response.substring(0, response.length - 1);
				jQuery('.ewd-otp-ajax-results').html(response);
		});
}