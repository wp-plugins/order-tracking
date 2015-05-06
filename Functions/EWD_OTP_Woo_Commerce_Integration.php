<?php
$WooCommerce_Integration = get_option("EWD_OTP_WooCommerce_Integration");
if ($WooCommerce_Integration == "Yes") {
	add_action('woocommerce_checkout_order_processed', 'Add_WooCommerce_Order');
	add_action('woocommerce_order_status_changed', 'Update_WooCommerce_Order');
}

function Update_WooCommerce_Order($post_id, $old_status, $new_status) {
	global $wpdb, $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;

	$Order_Email = get_option("EWD_OTP_Order_Email");
	$Timezone = get_option("EWD_OTP_Timezone");
	date_default_timezone_set($Timezone);

	$Post_Type = get_post_type($post_id); 
	if ($Post_Type == "shop_order") {
		$Post_Status = get_post_status($post_id);
		$Order_Status = Return_WC_Order_Status($Post_Status);

		$Order = $wpdb->get_row($wpdb->prepare("SELECT Order_ID, Order_Status FROM $EWD_OTP_orders_table_name WHERE WooCommerce_ID='%d'", $post_id));
		$Order_ID = $Order->Order_ID;
		$Order_Status_Updated = date("Y-m-d H:i:s");

		if ($Order_Status != $Order->Order_Status and $Order_ID != "") {
			Update_EWD_OTP_Order_Status($Order_ID, $Order_Status, $Order_Status_Updated);
			if ($Order_Email == "Change" and $Order_Email[0]) {EWD_OTP_Send_Email($Order_Email[0], $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Order_Name);}
		}
	}

}

function Add_WooCommerce_Order($post_id) {
	global $wpdb, $EWD_OTP_customers;

	$Order_Email = get_option("EWD_OTP_Order_Email");
	$Timezone = get_option("EWD_OTP_Timezone");
	date_default_timezone_set($Timezone);

	$Post_Type = get_post_type($post_id); 
	if ($Post_Type == "shop_order") {
		$Post_Status = get_post_status($post_id);
		$Order_Status = Return_WC_Order_Status($Post_Status);

		$Order_Key = get_post_meta($post_id, "_order_key");
		$Order_Email = get_post_meta($post_id, "_billing_email");

		$Customer_First_Name = get_post_meta($post_id, "_billing_first_name");
		$Customer_Last_Name = get_post_meta($post_id, "_billing_last_name");
		$Customer_Name = $Customer_First_Name[0] . " " . $Customer_Last_Name[0];
		$Customer_ID = $wpdb->get_var($wpdb->prepare("SELECT Customer_ID FROM $EWD_OTP_customers WHERE Customer_Name='%s'", $Customer_Name));
		if ($Customer_ID == "") {$Customer_ID = 0;}

		$Order_Name = "WooCommerce Order #" . $post_id;
		$Order_Number = "WC_" . $post_id . "_" . substr($Order_Key[0], -4);

		$Order_Notes_Public = "";
		$Order_Notes_Private = "";
		$Order_Display = "Yes";
		$Order_Status_Updated = date("Y-m-d H:i:s");
		$Sales_Rep_ID = 0;

		Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Email[0], $Order_Status, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID, $post_id);
		if (($Order_Email == "Change" or $Order_Email == "Creation") and $Order_Email[0] != "") {EWD_OTP_Send_Email($Order_Email[0], $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Order_Name, "Yes");}
	}
}

function Return_WC_Order_Status($WC_Status) {
	switch ($WC_Status) {
		case 'wc-pending':
			$OTP_Status = "Pending Payment";
			break;
		case 'wc-processing':
			$OTP_Status = "Processing";
			break;
		case 'wc-on-hold':
			$OTP_Status = "On Hold";
			break;
		case 'wc-completed':
			$OTP_Status = "Completed";
			break;
		case 'wc-cancelled':
			$OTP_Status = "Cancelled";
			break;
		case 'wc-refunded':
			$OTP_Status = "Refunded";
			break;
		case 'wc-failed':
			$OTP_Status = "Failed";
			break;
		default:
			$OTP_Status = "";
			break;
	}

	return $OTP_Status;
}

?>