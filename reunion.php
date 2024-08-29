<?php
include('./includes/basehead.html');

if (!empty($_GET['s'])) {
	if ($_GET['s'] === "confirm") {
		echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
		id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
		<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
		</svg>";

		echo "Successfully Booked CAS Centenary Reunion!";

		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";
		header("refresh:3;url=reunion.php");
	}
}
?>

<title>CAS 100 - Reunion</title>

<div class="video-background-holder">
	<div class="video-background-overlay"></div>
	<video playsinline="playsinline" autoplay="autoplay" muted="muted" loop=loop>
		<source src="images/casvidbg.mp4" type="video/mp4">
		Your browser does not support the video tag.
	</video>
	<div class="video-background-content container-fluid h-100">
		<?php require_once('headerlight.php'); ?>
		<div class="row d-flex">
			<div class="col-md-6 col-sm-3">
				<div class="px-5 text-left content">
					<div class="hstack gap-3">
						<p class="lead text-white mb-4 text-shadow-1">CAS Alumni, Friends, and Family Invited</p>
						<hr>
					</div>
				</div>
				<main class="bg-text">
					<div class="px-5 text-left content text-white gap-0">
						<h1 class="fw-bold main-text start_fade-left m-0">Centenary</h1>
						<h1 class="fw-bold main-text start_fade-left m-0">Reunion</h1>
						<p class="pt-2 start_fade_left r-date">25-27 April 2025 (ANZAC Weekend) </p>
					</div>
					<div class="px-5 my-5 content">
						<button type='button' class='btn btn-light btn-rounded btn-lg px-4 w-75' style='--bs-btn-padding-y: 0.75rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: 0.9rem; border-color: #ffffff;' id='sign_up' onclick="window.location.href='rsvp.php'">Book Now</button>
					</div>
				</main>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid overflow-hidden px-4 py-5 bg-light w-100 vh-50 shadow-lg">
	<div class="row">
		<div class="col-md-7">
			<div class="card card-cover h-100 overflow-hidden text-bg-light rounded-4 shadow-lg hover-zoom card_img">
				<div class="d-flex flex-column h-100 px-4 pt-5 mt-5 text-white text-shadow-1">
					<ul class="d-flex list-unstyled mt-auto">
						<li class="d-flex align-items-center">
							<a class="text-decoration-none text-light pt-5 mt-5 fw-bold"><small>CAS 2020</small></a>
						</li>
					</ul>
				</div>

			</div>
		</div>
		<div class="col-md-5 text-end m-0 fade-right reveal_once ">
			<h2 class="fw-bold ">A time for <span class="text-primary text_effect">Celebration.</span></h2>
			<p>Join us as we celebrate and commemorate the 100th Centenary of Christchurch Adventist School. From the 25 to 27th of April 2025, we will hold a series of events to celebrate the school's history and achievements. This event is open for our former students, friends and family. Save your spot by booking here!</p>
			</p>
			<button type='button' class='btn btn-primary btn-rounded btn-lg px-4 w-50' style='--bs-btn-padding-y: 0.75rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: 0.9rem; border-color: #ffffff;' id='sign_up' onclick="window.location.href=' rsvp.php'">Book Now</button>
		</div>
	</div>
</div>

<?php
require_once('footer.php');
