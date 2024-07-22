<?php
require_once 'vendor/autoload.php';
require_once('./includes/connectlocal.inc');
require_once('./includes/basehead.html');
define('BASE_URL', 'http://localhost/');

use PHPMailer\PHPMailer\PHPMailer;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if (
	isset($_GET['e'], $_GET['a'], $_GET['u'])
	&& filter_var($_GET['e'], FILTER_VALIDATE_EMAIL) && (strlen($_GET['a']) == 32)
) {
	$a = $_GET['a'];
	$u = $_GET['u'];
	$q = "SELECT * FROM `user` WHERE (`email` ='" . mysqli_real_escape_string($conn, $_GET['e']) . "')";

	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	while ($row = mysqli_fetch_assoc($r)) {
		$exp_date = $row['activation_expiry'];
		$e = $row['email'];
		$t = $row['token'];
		$activated = $row['email_confirmation'];
	}

	if ($activated == 1) {
		ob_end_clean();
		header("Location: index.php");
		exit();
	}

	if ($t != $a) {
		date_default_timezone_set("Pacific/Auckland");
		$now = time();
		$thirtyMinutes = $now + (30 * 60);
		$date_thirtyMinutes = date('Y-m-d H:i:s', $thirtyMinutes);

		$q = "UPDATE `user` SET `token` = '$a', `activation_expiry` = '$date_thirtyMinutes' WHERE (`email` ='" . mysqli_real_escape_string($conn, $_GET['e']) . "') LIMIT 1";

		$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
	}

	if (mysqli_affected_rows($conn) == 0) {
		die("An error has occuured!");
	}



	$mail = new PHPMailer();
	$mail->isSMTP();

	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "tls";
	$mail->Port = 587;
	$mail->Username = 'anicus.noreply@gmail.com';
	$mail->Password = 'lwtllspvcqknusgd';

	$mail->setFrom('anicus.noreply@gmail.com', 'Anicus');
	$mail->addAddress($e, $u);

	$mail->Subject = 'Activate your account';

	$mail->isHTML(true);

	$link = BASE_URL . 'CAS%20Centenary/verify.php?x=' . urldecode($e) . '&y=' . $a;

	$mailContent =
		"	<img src='https://www.mainlanduniforms.nz/c/103-medium_default/christchurch-adventist-school.jpg' alt='logo'>
			<h1>Activate your account</h1>
			<p>$u, Thank you for registering at CAS! To activate your account, click on this link:\n\n</p>
			<p>This link will expire in 30 minutes.<p>
			<p> $link </p>
			<p> If the link doesn't work, try copy and pasting the url to the search bar.</p>
			<br>
			<br>
			<p>Yours truly,</p>
			<p>Christchurch Adventist School</p>
			";
	$mail->Body = $mailContent;

	if ($mail->send()) {
		$url = 'success.php?a=' . $a;
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
