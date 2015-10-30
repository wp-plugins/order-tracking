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

function EWD_OTP_ResizeImage() {
	var GraphicDiv = jQuery('.ewd-otp-status-graphic');

	if (GraphicDiv.hasClass('ewd-otp-Default') || GraphicDiv.hasClass('ewd-otp-Streamlined') || GraphicDiv.hasClass('ewd-otp-Sleek')) {
		var imgEmpty = jQuery('.ewd-otp-empty-display > img');
		var imgFull = jQuery('.ewd-otp-full-display > img');
		imgFull.width(imgEmpty.width());
		if (jQuery(window).width() > 600) {var divHeight = Math.max(imgEmpty.height(), 150);}
		jQuery('.ewd-otp-status-graphic').height(divHeight);
	}
} 
jQuery(window).resize(EWD_OTP_ResizeImage);
jQuery(document).ready(EWD_OTP_ResizeImage);
