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

jQuery(document).ready(function() {
	SetMessageDeleteHandlers();

	jQuery('.ewd-otp-add-email').on('click', function(event) {
		var ID = jQuery(this).data('nextid');

		var HTML = "<tr id='ewd-otp-email-message-" + ID + "'>";
		HTML += "<td><a class='ewd-otp-delete-message' data-reminderID='" + ID + "'>Delete</a></td>";
		HTML += "<td><input type='text' name='Email_Message_" + ID + "_Name'></td>";
		HTML += "<td><textarea name='Email_Message_" + ID + "_Body'></textarea></td>";
		HTML += "</tr>";

		//jQuery('table > tr#ewd-uasp-add-reminder').before(HTML);
		jQuery('#ewd-otp-email-messages-table tr:last').before(HTML);

		ID++;
		jQuery(this).data('nextid', ID); //updates but doesn't show in DOM

		SetMessageDeleteHandlers();

		event.preventDefault();
	});
});

function SetMessageDeleteHandlers() {
	jQuery('.ewd-otp-delete-message').on('click', function(event) {
		var ID = jQuery(this).data('messagenumber');
		var tr = jQuery('#ewd-otp-email-message-'+ID);

		tr.fadeOut(400, function(){
            tr.remove();
        });

		event.preventDefault();
	});
}