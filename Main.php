<?php
/*
Plugin Name: Order Tracking Plugin
Plugin URI: http://www.EtoileWebDesign.com/order-tracking-plugin/
Description: A plugin that lets visitors place and track order numbers, as well as to check the status of the orders
Author: Tim Ruse
Author URI: http://www.EtoileWebDesign.com/
Text Domain: EWD_OTP
Version: 0.3
*/

global $EWD_OTP_db_version;
global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
global $wpdb;
global $message;
global $Full_Version;
$EWD_OTP_orders_table_name = $wpdb->prefix . "EWD_OTP_Orders";
$EWD_OTP_order_statuses_table_name = $wpdb->prefix . "EWD_OTP_Order_Statuses";
$EWD_OTP_db_version = "0.2";

define('WP_DEBUG', true);
$wpdb->show_errors();

/* When plugin is activated */
register_activation_hook(__FILE__,'Install_EWD_OTP');
register_activation_hook(__FILE__,'EWD_OTP_Default_Statuses');

/* When plugin is deactivation*/
register_deactivation_hook( __FILE__, 'Remove_EWD_OTP' );

/* Creates the admin menu for the contests plugin */
if ( is_admin() ){
	  add_action('admin_menu', 'EWD_OTP_Plugin_Menu');
		add_action('admin_head', 'EWD_OTP_Admin_Options');
		add_action('admin_init', 'Add_EWD_OTP_Scripts');
		add_action('widgets_init', 'Update_EWD_OTP_Content');
}

function EWD_OTP_Default_Statuses() {
		$StatusString = get_option("EWD_OTP_Statuses");
		if ($StatusString == "") {update_option("EWD_OTP_Statuses", "Received,Processed,Shipped,Completed");}
}

function Remove_EWD_OTP() {
  	/* Deletes the database field */
		delete_option('EWD_OTP_db_version');
}


/* Admin Page setup */
function EWD_OTP_Plugin_Menu() {
		add_menu_page('Order Tracking Plugin', 'Order Tracking', 'administrator', 'EWD-OTP-options', 'EWD_OTP_Output_Options',null , '50.8');
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
		}
}

add_action( 'wp_enqueue_scripts', 'EWD_OTP_Add_Stylesheet' );
function EWD_OTP_Add_Stylesheet() {
    wp_register_style( 'ewd-otp-style', plugins_url('css/otp-styles.css', __FILE__) );
		wp_register_style( 'yahoo-pure-buttons', plugins_url('css/pure-buttons.css', __FILE__) );
		wp_register_style( 'yahoo-pure-forms', plugins_url('css/pure-forms.css', __FILE__) );
		wp_register_style( 'yahoo-pure-forms-nr', plugins_url('css/pure-forms-nr.css', __FILE__) );
		wp_register_style( 'yahoo-pure-grids', plugins_url('css/pure-grids.css', __FILE__) );
		wp_register_style( 'yahoo-pure-grids-nr', plugins_url('css/pure-grids-nr.css', __FILE__) );
    wp_enqueue_style( 'ewd-otp-style' );
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

$Full_Version = get_option("EWD_OTP_Full_Version");

/*if (isset($_POST['Upgrade_To_Full'])) {
	  add_action('admin_init', 'Upgrade_To_Full');
}*/

include "Functions/EWD_OTP_Output_Options.php";
include "Functions/Install_EWD_OTP.php";
include "Functions/Prepare_Data_For_Insertion.php";
include "Functions/Process_Ajax.php";
include "Functions/Update_Admin_Databases.php";
include "Functions/Update_EWD_OTP_Content.php";
include "Functions/Update_EWD_OTP_Tables.php";

include "Shortcodes/InsertTrackingForm.php";

// Updates the OTP database when required
if (get_option('EWD_OTP_db_version') != $EWD_OTP_db_version) {
	  Update_EWD_OTP_Tables();
}

?>