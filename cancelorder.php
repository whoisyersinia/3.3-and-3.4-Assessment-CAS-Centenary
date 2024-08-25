<?php
require_once 'vendor/autoload.php';
require_once('./includes/connectlocal.inc');
require_once('./includes/basehead.html');

session_start();

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_SESSION['login'])) {
	if ($_SESSION['admin'] == 0) {
		http_response_code(403);
		header("Location: /CAS Centenary/errordocs/403.html");
		die();
	}
} else {
	http_response_code(403);
	header("Location: /CAS Centenary/errordocs/403.html");
	die();
}

if (isset($_GET['id'])) {
	//check if order exists 
	$id = $_GET['id'];

	$q = "SELECT * FROM `order` WHERE (`id` = '$id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	while ($row = mysqli_fetch_assoc($r)) {
		$user_id = $row['user_id'];
		$order_id = $row['id'];
		$total_price = $row['total'];
		$cart_id = $row['cart_id'];
	}

	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /errordocs/404.html");
		die();
	}

	// update order to paid
	$q = "UPDATE `order` SET `status` = 'canceled' WHERE `id` = '$id'";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	// add back to stock
	$q = "SELECT cart_item.quantity, product.stock, product.id FROM `cart_item` LEFT JOIN `product` ON cart_item.product_id = product.id WHERE cart_item.cart_id = '$cart_id'";
	$result = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	while ($row = mysqli_fetch_array($result)) {
		$quantity = $row['quantity'];
		$stock = $row['stock'];
		$product_id = $row['id'];
		$new_stock = $stock + $quantity;
		$q = "UPDATE `product` SET `stock` = '$new_stock' WHERE `id` = '$product_id'";
		$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
	}


	$q = "SELECT * FROM `user` WHERE (`id` = '$user_id')";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
	while ($row = mysqli_fetch_assoc($r)) {
		$e = $row['email'];
		$u = $row['username'];
	}

	$mail = new PHPMailer();
	$mail->isSMTP();

	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "tls";
	$mail->Port = 587;
	$mail->Username = 'anicus.noreply@gmail.com';
	$mail->Password = 'ydgq aauu ihkg foyw';
	$mail->AddEmbeddedImage('images/100 anniversary cas.png', 'logo');


	$mail->setFrom('anicus.noreply@gmail.com', 'CAS 100');
	$mail->addAddress($e, $u);

	$mail->Subject = 'Your order has been canceled!';

	$mail->isHTML(true);

	$mailContent =
		"	
			<h1>Order Canceled!</h1>
			<p>Your order has been canceled due to unforseen circumstances. Please call us for more information!</p>
			<p>$u, here is your receipt!</p>
			<br>
			<h4>Your order:</h4>
			<p>Order ID: #$order_id</p>
			<p>Total Price: $$total_price.00</p>
			<br>
			<p>Christchurch Adventist School</p>
			<p>15 Grants Road, Papanui, Christchurch, New Zealand, 8052.</p>
			<img src='cid:logo' alt='logo'>
			";
	$mail->Body = $mailContent;

	if ($mail->send()) {
		header("Location: order.php?s=cancel'");
	} else {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
} else {
	ob_end_clean();
	header("Location: index.php");
	exit();
}
