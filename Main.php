<?php
/*
Plugin Name: Order Tracking Plugin
Plugin URI: http://www.EtoileWebDesign.com/order-tracking/
Description: A plugin that lets visitors track an order's status by putting in its numbers, as well as send out order e-mail updates
Author: Étoile Web Design
Author URI: http://www.EtoileWebDesign.com/order-tracking/
Terms and Conditions: http://www.etoilewebdesign.com/plugin-terms-and-conditions/
Text Domain: EWD_OTP
Version: 2.2.3
*/

global $EWD_OTP_db_version;
global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $EWD_OTP_sales_reps, $EWD_OTP_customers;
global $wpdb;
global $ewd_otp_message;
global $EWD_OTP_Full_Version;
global $Sales_Rep_Only;
$EWD_OTP_orders_table_name = $wpdb->prefix . "EWD_OTP_Orders";
$EWD_OTP_order_statuses_table_name = $wpdb->prefix . "EWD_OTP_Order_Statuses";
$EWD_OTP_sales_reps = $wpdb->prefix . "EWD_OTP_Sales_Reps";
$EWD_OTP_customers = $wpdb->prefix . "EWD_OTP_Customers";
$EWD_OTP_fields_table_name = $wpdb->prefix . "EWD_OTP_Custom_Fields";
$EWD_OTP_fields_meta_table_name = $wpdb->prefix . "EWD_OTP_Fields_Meta";
$EWD_OTP_db_version = "2.2.3";

define( 'EWD_OTP_CD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'EWD_OTP_CD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/* define('WP_DEBUG', true);
$wpdb->show_errors();  */

/* When plugin is activated */
register_activation_hook(__FILE__,'Install_EWD_OTP');
register_activation_hook(__FILE__,'EWD_OTP_Default_Statuses');

/* When plugin is deactivation*/
register_deactivation_hook( __FILE__, 'Remove_EWD_OTP' );

/* Creates the admin menu for the contests plugin */
if ( is_admin() ){
	add_action('admin_menu', 'EWD_OTP_Plugin_Menu');
	add_action('admin_menu', 'EWD_OTP_Sales_Rep_Menu');
	add_action('admin_head', 'EWD_OTP_Admin_Options');
	add_action('admin_init', 'Add_EWD_OTP_Scripts');
	add_action('widgets_init', 'Update_EWD_OTP_Content');
	add_action('admin_notices', 'EWD_OTP_Error_Notices');
}

function EWD_OTP_Default_Statuses() {
	$StatusString = get_option("EWD_OTP_Statuses");
	if ($StatusString == "") {
		update_option("EWD_OTP_Statuses", "Received,Processed,Shipped,Completed");
		update_option("EWD_OTP_Percentages", "25,50,75,100");
	}
}

function Remove_EWD_OTP() {
  	/* Deletes the database field */
	delete_option('EWD_OTP_db_version');
}


/* Admin Page setup */
function EWD_OTP_Plugin_Menu() {
	$Access_Role = get_option("EWD_OTP_Access_Role");

	if ($Access_Role == "") {$Access_Role = "administrator";}
	add_menu_page('Order Tracking Plugin', 'Order Tracking', $Access_Role, 'EWD-OTP-options', 'EWD_OTP_Output_Options',null , '50.8');
}

function EWD_OTP_Sales_Rep_Menu() {
	global $wpdb, $EWD_OTP_sales_reps;

	$Current_User = wp_get_current_user();
	$Sql = "SELECT Sales_Rep_ID FROM $EWD_OTP_sales_reps WHERE Sales_Rep_WP_ID='" . $Current_User->ID . "'";
	$Sales_Rep_ID = $wpdb->get_var($Sql);

	if ($Sales_Rep_ID != "") {add_menu_page('Order Tracking Plugin', 'Order Tracking', 'read', 'EWD-OTP-options', 'EWD_OTP_Output_Sales_Rep_Options', null, '50.8');}
}

/* Add localization support */
function EWD_OTP_localization_setup() {
		load_plugin_textdomain('EWD_OTP', false, dirname(plugin_basename(__FILE__)) . '/lang/');
}
add_action('after_setup_theme', 'EWD_OTP_localization_setup');

// Add settings link on plugin page
function EWD_OTP_plugin_settings_link($links) { 
  $settings_link = '<a href="admin.php?page=EWD-OTP-options">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'EWD_OTP_plugin_settings_link' );

function Add_EWD_OTP_Scripts() {
	if (isset($_GET['page']) && $_GET['page'] == 'EWD-OTP-options') {
		$url_one = plugins_url("order-tracking/js/Admin.js");
		wp_enqueue_script('PageSwitch', $url_one, array('jquery'));
		$url_two = plugins_url("order-tracking/js/jquery.confirm.min.js");
		wp_enqueue_script('EWD_OTP_Confirmation', $url_two, array('jquery'));
		$url_three = plugins_url("order-tracking/js/bootstrap.min.js");
		wp_enqueue_script('EWD_OTP_Bootstrap', $url_three, array('jquery'));
		$url_four = plugins_url("order-tracking/js/ewd-otp-image.js");
		wp_enqueue_script('resizeImage', $url_four, array('jquery'));
	}
}

$AJAX_Reload = get_option("EWD_OTP_AJAX_Reload");
if ($AJAX_Reload == "Yes") {
	add_action( 'wp_enqueue_scripts', 'Add_EWD_OTP_FrontEnd_Scripts' );
}
function Add_EWD_OTP_FrontEnd_Scripts() {
	wp_enqueue_script('ewd-otp-js', plugins_url( '/js/ewd-otp-js.js' , __FILE__ ), array( 'jquery' ));
}


add_action( 'wp_enqueue_scripts', 'EWD_OTP_Add_Stylesheet' );
function EWD_OTP_Add_Stylesheet() {
    $Mobile_Stylesheet = get_option("EWD_OTP_Mobile_Stylesheet");

    wp_register_style( 'ewd-otp-style', plugins_url('css/otp-styles.css', __FILE__) );
    if ($Mobile_Stylesheet == "Yes") {wp_register_style( 'ewd-otp-style-mobile', plugins_url('css/otp-styles-mobile.css', __FILE__) );}
	wp_register_style( 'yahoo-pure-buttons', plugins_url('css/pure-buttons.css', __FILE__) );
	wp_register_style( 'yahoo-pure-forms', plugins_url('css/pure-forms.css', __FILE__) );
	wp_register_style( 'yahoo-pure-forms-nr', plugins_url('css/pure-forms-nr.css', __FILE__) );
	wp_register_style( 'yahoo-pure-grids', plugins_url('css/pure-grids.css', __FILE__) );
	wp_register_style( 'yahoo-pure-grids-nr', plugins_url('css/pure-grids-nr.css', __FILE__) );
    wp_enqueue_style( 'ewd-otp-style' );
    if ($Mobile_Stylesheet == "Yes") {wp_enqueue_style( 'ewd-otp-style-mobile' );}
	wp_enqueue_style( 'yahoo-pure-buttons' );
	wp_enqueue_style( 'yahoo-pure-forms' );
	wp_enqueue_style( 'yahoo-pure-forms-nr' );
	wp_enqueue_style( 'yahoo-pure-grids' );
	wp_enqueue_style( 'yahoo-pure-grids-nr' );
}


function EWD_OTP_Admin_Options() {
	$url = plugins_url("order-tracking/css/Admin.css");
	echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}

add_action('activated_plugin','save_otp_error');
function save_otp_error(){
	update_option('plugin_error',  ob_get_contents());
	file_put_contents("Error.txt", ob_get_contents());
}

$EWD_OTP_Full_Version = get_option("EWD_OTP_Full_Version");

if (isset($_POST['EWD_OTP_Upgrade_To_Full'])) {
	add_action('admin_init', 'EWD_OTP_Upgrade_To_Full');
}

include "Functions/DisplayGraph.php";
include "Functions/Error_Notices.php";
include "Functions/EWD_OTP_Export_To_Excel.php";
include "Functions/EWD_OTP_Output_Options.php";
include "Functions/EWD_OTP_Return_Results.php";
include "Functions/EWD_OTP_Widgets.php";
include "Functions/EWD_OTP_Woo_Commerce_Integration.php";
include "Functions/FrontEndAjaxUrl.php";
include "Functions/Full_Upgrade.php";
include "Functions/Install_EWD_OTP.php";
include "Functions/Prepare_Data_For_Insertion.php";
include "Functions/Process_Ajax.php";
include "Functions/Update_Admin_Databases.php";
include "Functions/Update_EWD_OTP_Content.php";
include "Functions/Update_EWD_OTP_Tables.php";
include "Functions/Version_Upgrade.php";

include "Shortcodes/InsertCustomerForm.php";
include "Shortcodes/InsertCustomerOrderForm.php";
include "Shortcodes/InsertSalesRepForm.php";
include "Shortcodes/InsertTrackingForm.php";

// Updates the OTP database when required
if (get_option('EWD_OTP_db_version') != $EWD_OTP_db_version) {
	Update_EWD_OTP_Tables();
}


?>