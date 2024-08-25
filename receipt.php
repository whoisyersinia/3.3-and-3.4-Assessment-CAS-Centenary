<?php
require_once 'vendor/autoload.php';
require_once('./includes/connectlocal.inc');
require_once('./includes/basehead.html');

session_start();

use PHPMailer\PHPMailer\PHPMailer;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_GET['id'], $_GET['order_id'])) {
	$id = $_GET['id'];
	$current_userid = $_SESSION['id'];
	$order_id = $_GET['order_id'];
	$u = $_SESSION['username'];

	if ($current_userid !== $id) {
		http_response_code(403);
		header("Location: /CAS Centenary/errordocs/403.html");
		die();
	}
	//check if user exists if not 404 error
	$q = "SELECT * FROM `user` WHERE (`id` = '$id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));


	if ($_GET['id'] == " ") {
		ob_end_clean();
		header("Location: index.php");
		exit();
	}

	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /CAS Centenary/errordocs/404.html");
		die();
	}

	//get user email
	while ($row = mysqli_fetch_assoc($r)) {
		$e = $row['email'];
	}

	// get order
	$q = "SELECT * FROM `order` WHERE (`id` = '$order_id' AND `user_id` = '$id')";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /CAS Centenary/errordocs/404.html");
		die();
	}

	while ($row = mysqli_fetch_assoc($r)) {
		$order_id = $row['id'];
		$cart_id = $row['cart_id'];
		$total_price = $row['total'];
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

	$mail->Subject = 'Receipt for your order at CAS';

	$mail->isHTML(true);

	$mailContent =
		"	
			<h1>Thank you for Ordering!</h1>
			<p>$u, here is your receipt!</p>
			<br>
			<h4>Your order:</h4>
			<p>Order ID: #$order_id</p>
			<p>Total Price: $$total_price.00</p>
			<p>Thank you for shopping with us!</p>
			<p>Please present your receipt at the CAS reception to proceed with final payment!</p>
			<br>
			<p>Christchurch Adventist School</p>
			<p>15 Grants Road, Papanui, Christchurch, New Zealand, 8052.</p>
			<img src='cid:logo' alt='logo'>
			";
	$mail->Body = $mailContent;

	if ($mail->send()) {
		$url = 'confirmation.php?id=' . $id . '&order_id=' . $order_id;
		header("Location: $url");
	} else {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
} else {
	ob_end_clean();
	header("Location: index.php");
	exit();
}
