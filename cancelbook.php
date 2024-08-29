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

	$q = "SELECT * FROM `rsvp` WHERE (`id` = '$id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	while ($row = mysqli_fetch_assoc($r)) {
		$user_id = $row['user_id'];
		$booking_id = $row['id'];
		$event_id = $row['event_id'];
	}

	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /errordocs/404.html");
		die();
	}

	// update order to paid
	$q = "UPDATE `rsvp` SET `status` = 'canceled' WHERE `id` = '$id'";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	$q = "SELECT * FROM `user` WHERE (`id` = '$user_id')";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
	while ($row = mysqli_fetch_assoc($r)) {
		$e = $row['email'];
		$u = $row['username'];
	}

	$q = "SELECT * FROM `event` WHERE (`id` = '$event_id')";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
	while ($row = mysqli_fetch_assoc($r)) {
		$event_name = $row['name'];
		$desc = $row['desc'];
		$start = $row['time_begin'];
		$end = $row['time_end'];
	}

	$start = new DateTime($start);
	$start = $start->format('jS F Y\, h:i:s A');

	$end = new DateTime($end);
	$end = $end->format('jS F Y\, h:i:s A');

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

	$mail->Subject = 'Your Booking has been Cancelled!';

	$mail->isHTML(true);

	$mailContent =
		"	
			<h1>Your Booking has been Cancelled!</h1>
			<p>
			<br>
			<h4>Your order:</h4>
			<p>Booking ID: #$booking_id</p>
			<h5>Event: $event_name</h5>
			<p>$desc</p>
			<p>$start - $end</p>
			
			<br>
			<p>Christchurch Adventist School</p>
			<p>15 Grants Road, Papanui, Christchurch, New Zealand, 8052.</p>
			<img src='cid:logo' alt='logo'>
			";
	$mail->Body = $mailContent;

	if ($mail->send()) {
		header("Location: event.php?s=cancel");
	} else {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
} else {
	ob_end_clean();
	header("Location: index.php");
	exit();
}
