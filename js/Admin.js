/* Used to show and hide the admin tabs for otp */
function ShowTab(TabName) {
		jQuery(".OptionTab").each(function() {
				jQuery(this).addClass("HiddenTab");
				jQuery(this).removeClass("ActiveTab");
		});
		jQuery("#"+TabName).removeClass("HiddenTab");
		jQuery("#"+TabName).addClass("ActiveTab");
		
		jQuery(".nav-tab").each(function() {
				jQuery(this).removeClass("nav-tab-active");
		});
		jQuery("#"+TabName+"_Menu").addClass("nav-tab-active");
}

function ShowMoreOptions() {
	jQuery(".otp-email-advanced-settings").toggle();
	jQuery(".otp-email-toggle-show").toggle();
	jQuery(".otp-email-toggle-hide").toggle();

	return false;
}

function ShowOptionTab(TabName) {
	jQuery(".otp-option-set").each(function() {
		jQuery(this).addClass("otp-hidden");
	});
	jQuery("#"+TabName).removeClass("otp-hidden");
	
	// var activeContentHeight = jQuery("#"+TabName).innerHeight();
	// jQuery(".otp-options-page-tabbed-content").animate({
	// 	'height':activeContentHeight
	// 	}, 500);
	// jQuery(".otp-options-page-tabbed-content").height(activeContentHeight);

	jQuery(".options-subnav-tab").each(function() {
		jQuery(this).removeClass("options-subnav-tab-active");
	});
	jQuery("#"+TabName+"_Menu").addClass("options-subnav-tab-active");
}