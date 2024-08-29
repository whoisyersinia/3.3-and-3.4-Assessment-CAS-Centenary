<?php
require_once('./includes/basehead.html');
require_once('header.php');

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

if (!empty($_GET['s'])) {
	if ($_GET['s'] === "approved") {

		echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
		id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
		<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
		</svg>";

		echo "Successfully changed status to approved!";

		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";
		header("refresh:3;url=event.php");
	} elseif ($_GET['s'] === "cancel") {
		echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
			id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
			<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
			</svg>";

		echo "Successfully cancelled booking!";

		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
			</div>";
		header("refresh:3;url=event.php");
	}
}

if (isset($_GET['searchterm'])) {
	$query = $_GET['searchterm'];
	$query = mysqli_escape_string($conn, $query);
	$q = "SELECT * FROM `rsvp` WHERE `id` LIKE '$query' ORDER BY `rsvp`.`created_at` DESC";
	if (empty($query)) {
		$search = False;
	} else {
		$search = True;
	}
} else {
	$search = False;
	$q = "SELECT * FROM `rsvp` ORDER BY `rsvp`.`created_at` DESC";
}
$r = mysqli_query($conn, $q);

//show orders table

$result = False;
$booking_results = array();

while ($row = mysqli_fetch_assoc($r)) {
	$result = True;
	$booking_id = $row['id'];
	$booked_at = $row['created_at'];
	$user_id = $row['user_id'];
	$status = ucfirst($row['status']);

	$date = new DateTime($booked_at);
	$da = $date->format('jS F Y\, h:i:s A');

	$userQuery = "SELECT username FROM `user` WHERE id = '$user_id'";
	$userResult = mysqli_query($conn, $userQuery);
	$userRow = mysqli_fetch_assoc($userResult);
	$username = $userRow['username'];

	$paid_url = "window.location.href='approvebook.php?id=$booking_id'";
	$view_url = "window.location.href='user.php?id=$user_id'";
	$cancel_url = "window.location.href='cancelbook.php?id=$booking_id'";
	if ($status == "Pending") {
		$buttons = "
		<button class='btn btn-outline-success me-2' onclick=$paid_url><i class='fa-solid fa-check'></i> Confirm</button>
		<button class='btn btn-outline-warning' onclick=$cancel_url><i class='fa-solid fa-ban'></i> Cancel</button>
		";
	} else {
		$buttons = "";
	}

	array_push(
		$booking_results,
		"<tr>
		<th>$booking_id</th>
		<th>$status</th>
		<th><a class='a-link text-primary pe-2' href=''>$username</a>
		</th> 
		<th>$da</th>
		<th>
		<button class='btn btn-outline-primary me-2' onclick=$view_url >View User</button>
		$buttons
		</th>
		</tr>"

	);
}
?>

<title>CAS100 - Events</title>

<body class="mt-5 pt-5 px-0 container-fluid">
	<h1 class="fw-bold text-primary d-flex justify-content-center">RSVPs for CAS Centenary Reunion</h1>
	<div class="d-flex justify-content-center align-content-center mx-auto">
		<form method="GET">
			<div class=" d-inline-flex gap-2 container-fluid">
				<i class="fa-solid text-primary fa-magnifying-glass justify-content-center align-self-center fa-xl"></i>
				<input class="form-control me-2" type="search" placeholder="Search for booking id" aria-label="Search" name="searchterm" value="<?php if (isset($_GET['searchterm'])) echo $_GET['searchterm']; ?>">
				<button class="btn btn-outline-primary " type="submit" name="search">Search</button>
			</div>
			<div class="d-inline-flex gap-2 mx-3">
			</div>

		</form>
	</div>
	<div class="pt-3 p-5">
		<?php
		if ($result === True) {
			echo "<table class='table table-hover table-responsive table-light border-primary table-bordered rounded-3 '>
			<thead>
				<tr>
					<th scope='col'>#Booking Id</th>
					<th scope='col'>Status</th>
					<th class='w-10'scope='col'>Username</th>
					<th class='w-20' scope='col'>Booked at</th>	
					<th class='w-55'>Actions</th>
				</tr>
			</thead>
			<tbody class='table-group-divider'>
				
			";
			if (isset($booking_results)) {
				foreach ($booking_results as $bookings) {
					echo $bookings;
				};
			}
			echo "
			</tbody>
		</table>";
		} else {
			echo "<h2 class='fw-bold text-primary d-flex justify-content-center pt-3'>No results found!</h2>";
			echo "<h3><a class='fw-bold text-info d-flex justify-content-center' href='event.php'>Show all bookings</a></h3>";
		}
		?>

	</div>
</body>

<?php

require_once('footer.php');
