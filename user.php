<?php
require_once('./includes/basehead.html');
require_once('header.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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

	$q = "SELECT * FROM `user` WHERE (`id` = '$id')";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	while ($row = mysqli_fetch_assoc($r)) {
		$e = $row['email'];
		$u = $row['username'];
		$fn = $row['first_name'];
		$ln = $row['last_name'];
		$ph = $row['phone_number'];
		$al = $row['alumni'];
		$grad_year = $row['graduated_year'];
	}
	if ($al == 1) {
		$al = "Yes";
	} else {
		$al = "No";
		$grad_year = "N/A";
	}


	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /errordocs/404.html");
		die();
	}

	// get rsvp
	$q = "SELECT * FROM `rsvp` WHERE (`user_id` = '$id')";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
	while ($row = mysqli_fetch_assoc($r)) {
		$booking_id = $row['id'];
		$status = $row['status'];
	}
	$paid_url = "window.location.href='approvebook.php?id=$booking_id'";
	$cancel_url = "window.location.href='cancelbook.php?id=$booking_id'";
}

?>
<title>CAS100 - <?php echo $u ?></title>


<body>
	<div class="row container-fluid pt-5 mt-5 d-flex justify-content-center align-content-center">
		<div class="col-md-4  border rounded-3 border-gray border-1 p-5 mt-5 w-50">
			<div class="mx-auto">
				<h3>User Details</h1>
					<p>Username:<span class="fw-bold"> <?php echo $u ?></span></p>
					<p>Name: <span class="fw-bold"><?php echo $fn, " ", $ln ?></span></p>
					<p>Email:<span class="fw-bold"> <?php echo $e ?></span></p>
					<p>Phone Number: <span class="fw-bold"><?php echo $ph ?></span></p>
					<p>Alumni: <span class="fw-bold"><?php echo $al ?></span></p>
					<p>Graduated Year: <span class="fw-bold"><?php echo $grad_year ?></span></p>
					<p>RSVP Status: <span class="fw-bold"><?php echo $status ?></span></p>
					<button class="btn btn-lg btn-primary w-100" onclick="window.location.href='order.php'">Go back</button>
					<?php if ($status == 'pending') { ?>
						<div class="d-flex">
							<button class="btn btn-lg btn-outline-success w-100 mt-2 me-3" onclick=<?php echo $paid_url ?>><i class='fa-solid fa-check'></i> Confirm</button>
							<button class="btn btn-lg btn-outline-warning w-100 mt-2" onclick=<?php echo $cancel_url ?>><i class='fa-solid fa-ban'></i> Cancel</button>
						</div>
					<?php } ?>
			</div>
		</div>
	</div>
</body>

<?php
require_once('footer.php');
