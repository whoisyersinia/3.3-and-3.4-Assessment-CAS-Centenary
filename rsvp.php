<?php
require_once('./includes/basehead.html');
require_once('./includes/connectlocal.inc');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();


// check if user is logged in
if (!isset($_SESSION['login'])) {
	header("Location: login.php?s=req");
	exit();
} else {
	$userid = $_SESSION['id'];
}

$fn = $ln = $ph = $al = $grad = FALSE;

$errors = array();

if (isset($_POST['regi'])) {
	$trimmed = array_map('trim', $_POST);

	if (isset($_POST['casalumni'])) {
		$grad = $_POST['grad_year'];
		$al = 1;
	} else {
		$grad = NULL;
		$al = 0;
	}

	if (empty($_POST['first_name'] || empty($_POST['last_name']) || empty($_POST['phone']))) {
		array_push($errors, "Fields empty!");
	} else {
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];

		// trim whitespace
		$trimmed_ph = preg_replace('/\s+/', '', $_POST['phone']);

		if (preg_match('/^0[0-9]{9}$/', $trimmed_ph)) {
			$ph = mysqli_real_escape_string($conn, $trimmed_ph);
		} else {
			array_push($errors, "Phone number is invalid or empty!");
		}

		if (strlen($first_name) > 2) {
			if (strlen($first_name) < 255) {
				$fn = mysqli_real_escape_string($conn, $first_name);
			} else {
				array_push($errors, "Your first name exceeds the chracter limit (255)!");
			}
		} else {
			array_push($errors, "Your first name is less than 2 characters long!");
		}

		if (strlen($last_name) > 2) {
			if (strlen($last_name) < 255) {
				$ln = mysqli_real_escape_string($conn, $last_name);
			} else {
				array_push($errors, "Your last name exceeds the chracter limit (255)!");
			}
		} else {
			array_push($errors, "Your last name is less than 2 characters long!");
		}
	}
}

// if ok
if ($fn && $ln && $ph) {

	//check if user already booked
	$check_booked = "SELECT * FROM `rsvp` WHERE `user_id` = '$userid'";

	$r = mysqli_query($conn, $check_booked) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));


	if (mysqli_num_rows($r) == 0) {
		// set expiry 30 minutes after date now
		date_default_timezone_set("Pacific/Auckland");
		$now = time();
		$datetime = date("Y-m-d H:i:s", $now);

		// update user 
		if ($grad == NULL) {
			$q = "UPDATE `user` SET `first_name` = '$fn', `last_name` = '$ln', `phone_number` = '$ph', `alumni` = '$al' WHERE `id` = '$userid'";
		} else {
			$q = "UPDATE `user` SET `first_name` = '$fn', `last_name` = '$ln', `phone_number` = '$ph', `alumni` = '$al', `graduated_year` = '$grad' WHERE `id` = '$userid'";
		}

		$r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));

		//create rsvp request
		$query = "INSERT into `rsvp` (`event_id`, `user_id`, `created_at`) VALUES (1, '$userid', '$datetime')";

		$result = mysqli_query($conn, $query);

		header("Location: bookedconfirmation.php?id=$userid");
	} else {
		array_push($errors, "You have already booked this event!");
	}
}
?>

<head>
	<title>RSVP - CAS100</title>
</head>
<?php
if ($errors) {
	echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
	echo "<svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
		<path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
	</svg>";

	echo array_values($errors)[0];

	echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";
};
?>
<div class="bg-danger vh-100 w-100 d-flex justify-content-center align-content-center">
	<div class="container-fluid">
		<div class="row vh-100">
			<div class="col-md-6 col-sm-3 bg-primary">
				<img src="" alt="">
			</div>
			<div class="col-md-6 col-sm-3 justify-content-center align-content-center">
				<main class="text-center w-auto m-auto px-5 mx-5 py-4">
					<form method="POST">
						<h1 class="h1 mb-3 fw-semibold text-primary">Book Event</h1>
						<div class="d-flex gap-3">
							<div class="form-floating w-50">
								<input name="first_name" type="text" class="form-control border border-3 border-info"
									value="<?php if (!isset($_POST['first_name'])) {
														echo $_SESSION['first_name'];
													} else {
														echo $_POST['first_name'];
													} ?>">
								<label for=" floatingInput">First name<span class="text-warning">*</span></label>
							</div>

							<div class="form-floating w-50">
								<input name="last_name" type="text" class="form-control border border-3 border-info"
									value="<?php if (!isset($_POST['last_name'])) {
														echo $_SESSION['last_name'];
													} else {

														echo $_POST['last_name'];
													} ?>">
								<label for="floatingInput">Last name<span class="text-warning">*</span></label>
							</div>
						</div>
						<div class="form-floating mt-4">
							<input name="email" type="email" class="form-control border border-3 border-gray" disabled placeholder="name@example.com" value="<?php if (isset($_SESSION['email'])) echo $_SESSION['email']; ?>">
							<label for="floatingInput">Email address<span class="text-warning">*</span></label>
						</div>

						<label class="d-flex form-floating justify-content-start pt-3" for="phone">Phone Number<span class="text-warning">*</span></label>
						<div class="d-flex form-floating justify-content-start flex-column">
							<input name="phone" type="tel" id="phone" class="form-control border border-3 border-info">
						</div>

						<div class="form-check d-flex justify-content-start pt-3">
							<input class="form-check-input" type="checkbox" name="casalumni" id="casalumni">
							<label class="form-check-label ps-1">
								Are you a CAS Alumni?
							</label>
						</div>

						<input id="grad" name="grad_year" type="number" placeholder="Enter graduation year" class="d-none form-control border border-3 border-info" max="2024" min="1925" step="1">

						<br>

						<button class="w-100 btn btn-lg btn-primary" type="submit" name="regi">Register Event</button>
						<p class="mt-5 mb-3 text-muted text-center text-light">&copy; Christchurch Adventist School 2024-2025</p>

					</form>
				</main>
			</div>
		</div>
	</div>
</div>
<script>
	const phoneInputField = document.querySelector("#phone");
	const phoneInput = window.intlTelInput(phoneInputField, {
		preferredCountries: ["nz"],
		utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
	});
	const info = document.querySelector(".alert");

	function process(event) {
		event.preventDefault();

		const phoneNumber = phoneInput.getNumber();

		info.style.display = "";
		info.innerHTML = `Phone number in E.164 format: <strong>${phoneNumber}</strong>`;
	}

	$('#casalumni').click(function() {
		if ($(this).is(':checked')) {
			document.getElementById('grad').classList.remove("d-none");
		} else {
			document.getElementById('grad').classList.add("d-none");
		}
	});
</script>
<?php
include('footer.php');
