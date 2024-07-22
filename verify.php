<?php
require_once('./includes/connectlocal.inc');
require_once('./includes/basehead.html');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if (
	isset($_GET['x'], $_GET['y'])
	&& filter_var($_GET['x'], FILTER_VALIDATE_EMAIL) && (strlen($_GET['y']) == 32)
) {
	// check if user's activation link is expired
	date_default_timezone_set("Pacific/Auckland");
	$now = time();
	$date_now = date('Y-m-d H:i:s', $now);
	$q = "SELECT * FROM `user` WHERE (`email` ='" . mysqli_real_escape_string($conn, $_GET['x']) . "' AND `token` ='" . mysqli_real_escape_string($conn, $_GET['y']) . "')";

	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	while ($row = mysqli_fetch_assoc($r)) {
		$exp_date = $row['activation_expiry'];
		$u = $row['username'];
		$e = $row['email'];
		$t = $row['token'];
		$activated = $row['activated'];
	}

	if ($activated == 1) {
		ob_end_clean();
		header("Location: index.php");
		exit();
	}


	$a = md5(uniqid(rand(), true));
	$url = 'activation.php?e=' . urlencode($e) . '&a=' . $a . '&u=' . $u;

	if ($t != $_GET['y']) {
		$b = "<h5 class='text-warning'>Your token is invalid, <a class='a-link text-warning' href='$url'>click here</a> to resend the activation link!</h5>";
		header("refresh:59;url=index.php");
	}

	if ($date_now > $exp_date) {
		$b = "<h5 class='text-warning'>Your token has expired, <a class='a-link text-warning' href='$url'>click here</a> to resend the activation link!</h5>";

		header("refresh:59;url=index.php");
	} else {
		//update if user has same email and token as the link
		$q = "UPDATE `user` SET `activated` = 1, `activated_at` = '$date_now' WHERE (`email` ='" . mysqli_real_escape_string($conn, $_GET['x']) . "' AND `token` ='" . mysqli_real_escape_string($conn, $_GET['y']) . "') LIMIT 1";

		$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));


		if (mysqli_affected_rows($conn) == 1) {
			$b = "<h5 class='text-primary'>Your account has been activated! Please <a class='a-link text-success' href='login.php'>log in.</a></h5>";
			header("refresh:59;url=index.php");
		} else {
			$b = "<h5 class='text-warning'>An error has occured, <a class='a-link text-warning' href='$url'>click here</a> to resend the activation link.</h5>";
			header("refresh:59;url=index.php");
		}

		mysqli_close($conn);
	}
} else {
	ob_end_clean();
	header("Location: index.php");
	exit();
}
?>


<title>Verify</title>

<body>
	<div class="container-fluid bg-light vh-100 w-100 d-flex justify-content-center align-content-center">
		<main class="text-center w-auto m-auto">
			<a href="index.php">
				<img src="./images/logo.svg" alt="logo" class="p-4">
			</a>
			<?php
			echo $b;
			?>
			<div>Redirecting back in <span class="fw-bold" id="time">59</span> second(s)!</div>
		</main>
	</div>

</body>
<?php
include('footer.php');
?>

</html>