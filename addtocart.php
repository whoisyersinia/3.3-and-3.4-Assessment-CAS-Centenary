<?php
require_once('./includes/basehead.html');
require_once('./includes/connectlocal.inc');
session_start();
ob_start();

$user_id = $_SESSION['id'];

if (isset($_GET['id'], $_GET['qty'])) {
	//check if item exists 
	$id = $_GET['id'];
	$quantity = $_GET['qty'];


	$q = "SELECT * FROM `product` WHERE (`id` = '$id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));


	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /CAS Centenary/errordocs/404.html");
		die();
	}

	while ($row = mysqli_fetch_assoc($r)) {
		$id = $row['id'];
		$na = $row['name'];
		$pr = $row['price'];
		$st = $row['stock'];
		$pic = $row['image'];
		$des = $row['desc'];
		$lim = $row['limit_per_customer'];
	}
} else {
	http_response_code(404);
	header("Location: /CAS Centenary/errordocs/404.html");
	die();
}


date_default_timezone_set("Pacific/Auckland");
$now = time();
$datetime = date("Y-m-d H:i:s", $now);

// check if item already in cart
$q = "SELECT * FROM `cart_item` WHERE (`cart_id` = '" . $_SESSION['cart']['id'] . "' AND `product_id` = '$id')";
$r =  mysqli_query($conn, $q);
if (mysqli_num_rows($r) > 0) {
	// update quantity
	$row = mysqli_fetch_assoc($r);
	$quantity = $row['quantity'] + $quantity;
	$q = "UPDATE `cart_item` SET `quantity` = '$quantity', `modified_at` = '$datetime' WHERE (`cart_id` = '" . $_SESSION['cart']['id'] . "' AND `product_id` = '$id')";
	$r =  mysqli_query($conn, $q);
} else {
	// add to cart
	$quantity = $_POST['quantity'];
	$q = "INSERT INTO `cart_item` (`cart_id`, `product_id`, `quantity`, `created_at`, `modified_at`) VALUES ('" . $_SESSION['cart']['id'] . "', '$id', '$quantity', '$datetime', '$datetime')";
	$r =  mysqli_query($conn, $q);
}

$cart_id = $_SESSION['cart']['id'];

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
