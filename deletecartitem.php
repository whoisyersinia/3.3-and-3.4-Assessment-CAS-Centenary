<?php
require_once('./includes/basehead.html');
require_once('header.php');

session_start();

if (isset($_GET['id'])) {
	$product_id = $_GET['id'];
	$cart_id = $_SESSION['cart']['id'];
	$user_id = $_SESSION['id'];
	date_default_timezone_set("Pacific/Auckland");
	$now = time();
	$datetime = date("Y-m-d H:i:s", $now);

	// check if product exists
	$q = "SELECT * FROM `product` WHERE (`id` = '$product_id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /CAS Centenary/errordocs/404.html");
		die();
	}

	// check if cart exists
	$q = "SELECT * FROM `cart` WHERE (`id` = '$cart_id')";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /CAS Centenary/errordocs/404.html");
		die();
	}

	// check if cart item exists
	$q = "SELECT * FROM `cart_item` WHERE (`product_id` = '$product_id' AND `cart_id` = '$cart_id')";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /CAS Centenary/errordocs/404.html");
		die();
	} else { // delete item
		$q = "DELETE FROM `cart_item` WHERE (`product_id` = '$product_id' AND `cart_id` = '$cart_id')";
		$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
	}

	// update cart total price
	$q = "SELECT * FROM `product` 
	LEFT JOIN `cart_item` ON product.id = cart_item.product_id 
	LEFT JOIN `cart` ON cart.id = cart_item.cart_id
	WHERE cart_item.cart_id = '$cart_id'
	ORDER BY `cart_item`.`modified_at` DESC";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	$total_price = 0;

	while ($row = mysqli_fetch_array($r)) {
		$total_product_price = 0;
		$price = $row['price'];
		$qty = $row['quantity'];

		$total_product_price += $price * $qty;
		$total_price += $total_product_price;
	}
	$q = "UPDATE `cart` SET `total_price` = '$total_price', `modified_at` = '$datetime' WHERE (`id` = '$cart_id')";
	$r =  mysqli_query($conn, $q);
	mysqli_close($conn);
	header("Location: cart.php?id=$user_id");
	exit();
}
