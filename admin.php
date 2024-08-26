<?php
require_once('./includes/basehead.html');
include('header.php');

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

date_default_timezone_set("Pacific/Auckland");
$hour = date('H');


// Greeting based on time of day (just for fun)
if ($hour >= 6 && $hour < 12) {
	$greeting = "Good morning, ";
} elseif ($hour >= 12 && $hour < 18) {
	$greeting = "Good afternoon, ";
} else {
	$greeting = "Good evening, ";
}


?>

<title>Admin Page</title>

<body>
	<div class="w-100 vh-100 d-flex justify-content-center align-items-center z-0">
		<div class="container-fluid pt-5">
			<div class="row">
				<div class="col-md-6 col-sm-3">
					<div class="px-5 text-left content">
						<div class="hstack gap-3">
							<p class="lead mb-4 text-primary text-shadow-1 fw-bold">Welcome to your dashboard.</p>
						</div>
					</div>
					<main class="bg-text">
						<div class="px-5 text-left content text-primary gap-0">
							<h1 class="fw-bold main-text start_fade-left m-0"><?php echo $greeting, $_SESSION['username'] ?></h1>
						</div>
						<div class="px-5 my-5 content d-flex justify-content-start gap-3">
							<?php
							$windowloc = "window.location.href=";
							$url = "stock.php";
							$onclick = $windowloc . "\"$url\"";

							$order_url = "window.location.href='order.php'";
							$event_url = "window.location.href='event.php'";

							echo "<button type='button' class='btn btn-primary btn-rounded btn-lg' style='--bs-btn-padding-y: 0.75rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: 0.9rem; border-color: #2b0806;' id='sign_up' onclick='$onclick'>View Inventory</button>";

							echo "<button type='button' class='btn btn-outline-primary btn-rounded btn-lg px-5' style='--bs-btn-padding-y: 0.75rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: 0.9rem; border-color: #2b0806;' id='sign_up' onclick=$event_url>View Event</button>";

							echo "<button type='button' class='btn btn-info btn-rounded btn-lg px-5 text-white border-primary' style='--bs-btn-padding-y: 0.75rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: 0.9rem; border-color: #2b0806;' id='sign_up' onclick=$order_url>View Orders</button>"
							?>
						</div>
					</main>
				</div>
			</div>
		</div>
	</div>
</body>

<?php

require_once('footer.php');
