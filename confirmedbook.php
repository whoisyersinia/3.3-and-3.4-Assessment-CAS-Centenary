<?php
require_once('./includes/basehead.html');
require_once('header.php');

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$current_userid = $_SESSION['id'];

	if ($current_userid !== $id) {
		http_response_code(403);
		header("Location: /CAS Centenary/errordocs/403.html");
		die();
	}
	//check if user exists if not 404 error
	$q = "SELECT * FROM `user` WHERE (`id` = '$id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	while ($row = mysqli_fetch_assoc($r)) {
		$e = $row['email'];
		$u = $row['username'];
	}


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

	// get order
	$q = "SELECT * FROM `rsvp` WHERE (`user_id` = '$id')";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /CAS Centenary/errordocs/404.html");
		die();
	}

	while ($row = mysqli_fetch_assoc($r)) {
		$booking_id = $row['id'];
	}
}

?>

<title>CAS 100 - Order Confirmation</title>

<body>
	<div class="row container-fluid d-flex justify-content-center align-content-lg-center vh-100 w-100">
		<div class="col-md-8 text-center border rounded-3 border-gray border-1 p-5">
			<h3><?php echo $u ?>, your booking has been confirmed!</h3>
			<p>An email has been sent to <?php echo $e ?>.</p>
			<h5 class=" text-start pt-2">Your order:</h5>
			<p class="text-start text-muted">Booking ID: #<?php echo $booking_id ?></p>
			<button class="btn btn-lg btn-primary w-100" onclick="window.location.href='index.php'">Go Back</button>
		</div>
	</div>
</body>

<?php
require_once('footer.php');
