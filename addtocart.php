<?php
require_once('./includes/basehead.html');
require_once('./includes/connectlocal.inc');

if (isset($_GET['id'])) {
	//check if anime exists 
	$id = $_GET['id'];

	$q = "SELECT * FROM `product` WHERE (`id` = '$id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));


	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /errordocs/404.html");
		die();
	}

	while ($row = mysqli_fetch_assoc($r)) {
		$id = $row['id'];
		$na = $row['name'];
		$pr = $row['price'];
		$st = $row['stock'];
		$pic = $row['image'];
		$des = $row['desc'];
	}
}

if (isset($_GET['qty'])) {
	//get quantity
	$quantity = $_GET['qty'];
}


session_start();
// check if user has a cart
// check if user is logged in
if (!isset($_SESSION['login'])) {
	header("Location: login.php?s=req");
} else {
	$user_id = $_SESSION['id'];
}
$query = "SELECT * FROM `cart` WHERE (`user_id` = '$user_id')";
$result =  mysqli_query($conn, $query);

date_default_timezone_set("Pacific/Auckland");
$now = time();
$datetime = date("Y-m-d H:i:s", $now);
if (mysqli_num_rows($r) == 0) {
	// create cart
	$q = "INSERT INTO `cart` (`user_id`, `created_at`, `modified_at`) VALUES ('$user_id', '$datetime', '$datetime')";
	var_dump($q);
	$r =  mysqli_query($conn, $q);
}
// select user cart
$_SESSION['cart'] = mysqli_fetch_array($result, MYSQLI_ASSOC);


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

mysqli_close($conn);
