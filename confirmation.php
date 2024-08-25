<?php
require_once('./includes/basehead.html');
require_once('header.php');

if (isset($_GET['id'], $_GET['order_id'])) {
	$id = $_GET['id'];
	$current_userid = $_SESSION['id'];
	$order_id = $_GET['order_id'];
	$username = $_SESSION['username'];

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
		$total_price = $row['total'];
	}
}

?>

<title>CAS 100 - Order Confirmation</title>

<body>
	<div class="row container-fluid d-flex justify-content-center align-content-lg-center vh-100 w-100">
		<div class="col-md-8 text-center border rounded-3 border-gray border-1 p-5">
			<h3><?php echo $username ?>, your order has been recieved by us!</h3>
			<h5 class=" text-start pt-2">Your order:</h5>
			<p class="text-start text-muted">Order ID: #<?php echo $order_id ?></p>
			<div class="mx-auto">
				<div class="d-flex justify-content-between ">
					<p class="">Subtotal</p>
					<p class="fw-bold">$<?php echo $total_price ?>.00</p>
				</div>
				<div class="d-flex p-0 justify-content-between ">
					<p class="">Discount</p>
					<p class="fw-bold">$0.00</p>
				</div>
				<hr>
				<div class="d-flex p-0 justify-content-between pt-2">
					<p class="">Grand total</p>
					<p class="fw-bold">$<?php echo $total_price ?>.00</p>
				</div>
			</div>
			<button class="btn btn-lg btn-primary w-100" onclick="window.location.href='store.php'">Continue Shopping</button>
		</div>
	</div>
</body>