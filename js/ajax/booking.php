<?php
require_once('../../../../../wp-load.php');

if ($_POST) {
	//////////////////////////////////////////////////////
	// SET FIELDS ////////////////////////////////////////
	//////////////////////////////////////////////////////

	// First name
	if (isset($_POST['first_name'])) { $booking_data['first_name'] = $_POST['first_name']; }

	// Email
	if (isset($_POST['email'])) { $booking_data['email'] = $_POST['email']; }

	// Phone
	if (isset($_POST['phone'])) { $booking_data['phone'] = $_POST['phone']; }
	// msg
	if (isset($_POST['msg'])) { $booking_data['msg'] = $_POST['msg']; }


	///////////////////////////////////////

	// Cart
	if (isset($_POST['cart'])) {
		$cart = $_POST['cart'];
		$cart = str_replace('\\', '', $cart);
		$cart = json_decode($cart);
		$booking_data['cart'] = json_encode($cart);
	}
	//////////////////////////////////////////////////

	//// PRICE

	$cart_price = get_cart_price($cart);
	$full_cart_price = $cart_price;

	$booking_data['cart_price'] = $cart_price;
	//////////////////////////////////////////////////////
	// insert to DB //////////////////////////////////////
	//////////////////////////////////////////////////////

	$types_arr = array();
	foreach (array_keys($booking_data) as $key) {
		switch ($key) {
			case 'cart_price':array_push($types_arr,'%d'); break;
			default:array_push($types_arr,'%s'); break;
		}
	}
	
	global $wpdb;
    $wpdb->insert('ct_shop_bookings', $booking_data, $types_arr);
    $order_id = $wpdb->insert_id;

} // Если переданы данные

	    $js_json['data'] = $data;
	    $js_json['order_id'] = $order_id;
	    $js_json['user_email'] = $booking_data['email'];

// return JS JSON data

print_r(json_encode($js_json));

sendNotification();
