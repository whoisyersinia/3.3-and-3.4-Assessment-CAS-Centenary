<!DOCTYPE html>
<html lang="en">

<?php
include('./includes/basehead.html');
session_start();

?>

<head>
	<title>Christchurch Adventist School 100</title>
</head>

<body>
	<?php
	require_once('header.php');
	if (isset($_SESSION['login']) && (!isset($_SESSION['welcome_message']))) {
		echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top z-2' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
		id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
		<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
		</svg>";

		echo "Welcome, " . $_SESSION['username'] . ".";


		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";

		// ensure that welcome message only prints once after login
		$_SESSION['welcome_message'] = True;
	}

	if (isset($_SESSION['login'])) {
		$_SESSION['login'] = time();
		// automatically logout user in specific amount of time  - specifed below (default: 3 days?)
		$inactive = 30;
		$session_time = time() - $_SESSION['login'];

		if ($session_time > $inactive) {
			header("Location: logout.php");
		}
	}

	//status popup messages 

	if (!empty($_GET['s'])) {
		echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
			<path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
		</svg>";

		echo "You have been logged out!";

		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
			</div>";
		header("refresh:3;url=index.php");
	}


	?>
	<div class="w-100 vh-100 d-flex justify-content-center align-items-center z-0">
		<div class="container-fluid pt-5">
			<div class="row">
				<div class="col-md-6 col-sm-3">
					<div class="px-5 text-left content">
						<div class="hstack gap-3">
							<p class="lead text-primary mb-4 text-shadow-1">100 Years</p>
							<div class="vr mb-4"></div>
							<p class="lead mb-4 text-primary text-shadow-1 fw-bold">Of Christian Values</p>
						</div>
					</div>
					<main class="bg-text">
						<div class="px-5 text-left content text-primary gap-0">
							<h1 class="fw-bold main-text start_fade-left m-0">Respect</h1>
							<h1 class="fw-bold main-text start_fade-left m-0 strokeme">Excellence</h1>
							<h1 class="fw-bold main-text start_fade-left m-0 strokeme">Responsibility</h1>
							<h1 class="fw-bold main-text start_fade-left m-0 strokeme">Integrity</h1>
						</div>
						<div class="px-5 my-5 content">
							<button type='button' class='btn btn-primary btn-rounded btn-lg px-4' style='--bs-btn-padding-y: 0.75rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: 0.9rem; border-color: #2b0806;' id='sign_up'>Former students?</button>
							<button type='button' class='btn btn-outline-primary btn-rounded btn-lg px-5' style='--bs-btn-padding-y: 0.75rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: 0.9rem; border-color: #2b0806;' id='sign_up'>Visit the Store</button>
						</div>
					</main>
				</div>
				<div class="col-md-6 col-sm-3 text-center">
					<img src="images/logo2.svg" class="img-fluid mx-auto cas-logo pt-5" alt="">
				</div>
			</div>
		</div>
	</div>
</body>

<?php
require_once('footer.php');
?>

</html>