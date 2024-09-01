<!DOCTYPE html>
<html lang="en">

<?php
include('./includes/basehead.html');
require_once('header.php');

?>

<head>
	<title>Christchurch Adventist School 100</title>
</head>

<body>
	<?php
	if (isset($_SESSION['login']) && (!isset($_SESSION['welcome_message']))) {
		echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
		id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
		<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
		</svg>";

		echo "Welcome, " . $_SESSION['username'] . ".";


		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";
		header("refresh:3;url=index.php");


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
	}


	?>
	<div class="w-100 vh-100 d-flex justify-content-center align-items-center overflow-hidden">
		<div class="container-fluid pt-5">
			<div class="row row-cols-sm-1">
				<div class="col-md-6 col-sm-1">
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
						<div class="px-5 my-5 content d-flex gap-2">
							<button type='button' class='btn btn-primary btn-rounded btn-lg px-4' style='--bs-btn-padding-y: 0.75rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: 0.9rem; border-color: #2b0806;' id='sign_up' onclick="window.location.href='reunion.php'">Former student?</button>
							<button type='button' class='btn btn-outline-primary btn-rounded btn-lg px-5' style='--bs-btn-padding-y: 0.75rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: 0.9rem; border-color: #2b0806;' id='sign_up' onclick="window.location.href='store.php'">Visit the Store</button>
						</div>
					</main>
				</div>
				<div class="col-md-6 col-sm-1 text-center">
					<img src="images/logo2.svg" class="img-fluid mx-auto cas-logo pt-5" alt="">
				</div>
			</div>
		</div>
	</div>
	<div class="px-5 py-5 bg-primary w-100 vh-50 shadow-lg">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-7 ">
					<div class="school_card card card-cover overflow-hidden text-bg-light rounded-4 hover-zoom card_img">
					</div>
				</div>
				<div class="col-md-5 text-end fade-right text-white reveal_once mt-2">
					<h1 class="fw-bold">Centenary Reunion <span class="text-white text_effect">2025</span></h1>
					<p>Join us as we celebrate and commemorate the 100th Centenary of Christchurch Adventist School. From the 25 to 27th of April 2025, we will hold a series of events to celebrate the school's history and achievements. This event is open for our former students, friends and family. Save your spot by booking here!</p>
					</p>

					<button type='button' class='btn btn-light btn-rounded btn-lg px-4 w-50' style='--bs-btn-padding-y: 0.75rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: 0.9rem; border-color: #ffffff;' id='sign_up' onclick="window.location.href=' rsvp.php'">Book Now</button>

					<div class="text-start">
						<h1 class="fw-bold mt-5">From humble <span class="text-white text_effect">beginnings</span>...</h1>
						<p>Christchurch Adventist School was officially opened on April 27, 1925, at 15 Grants Road, Papanui, Christchurch. It started with an enrollment of 22 students. Maud Smart was their teacher and remained in charge with a handful of assistants until 1933. Statistics for 1934 mention three teachers caring for 43 students from grades 1 through 10.
						</p>
						<button type='button' class='btn btn-outline-light btn-rounded btn-lg px-4 w-50' style='--bs-btn-padding-y: 0.75rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: 0.9rem; border-color: #ffffff;' id='sign_up' onclick="window.location.href='history.php'">Read More</button>
					</div>

				</div>
			</div>
		</div>
	</div>
	<section class="home-testimonial pb-5">
		<div class="container-fluid">
			<div class="row d-flex justify-content-center testimonial-pos">
				<div class="col-md-12 pt-4 d-flex justify-content-center">
					<h3>Our Alumni</h3>
				</div>
				<div class="col-md-12 d-flex justify-content-center">
					<h2>100 Years of Educating for Etenrity</h2>
				</div>
			</div>
			<section class="home-testimonial-bottom">
				<div class="container testimonial-inner">
					<div class="row d-flex justify-content-center">
						<div class="col-md-4 style-3">
							<div class="tour-item ">
								<div class="tour-desc bg-white">
									<div class="tour-text color-grey-3 text-center">&ldquo;A special congratulations to CAS for their 100th anniversary. My time at CAS has been defined by one word - blessed. I have sincere gratitude to the staff of the past and present. I hope that CAS continues to equip our young people with the tools they need for life as well as for eternity.&rdquo;</div>
									<div class="d-flex justify-content-center pt-2 pb-2"><img class="tm-people" src="./images/marcus.jpg" alt=""></div>
									<div class="link-name d-flex justify-content-center">Marcus Demafeliz</div>
									<div class="link-position d-flex justify-content-center">2024 Graduate</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 style-3">
							<div class="tour-item ">
								<div class="tour-desc bg-white">
									<div class="tour-text color-grey-3 text-center">&ldquo;CAS honours a century of learning, growth, and community. As we reflect on our rich history, we express gratitude to all who have contributed to our journey. Here’s to continuing our legacy of success and shaping bright futures for generations to come. Happy 100th Anniversary!&rdquo;</div>
									<div class="d-flex justify-content-center pt-2 pb-2"><img class="tm-people" src="./images/otylia.jpg" alt=""></div>
									<div class="link-name d-flex justify-content-center">Otylia Zeng</div>
									<div class="link-position d-flex justify-content-center">2024 Graduate</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 style-3">
							<div class="tour-item ">
								<div class="tour-desc bg-white">
									<div class="tour-text color-grey-3 text-center">&ldquo;Happy 100th Anniversary to CAS! For a century, we’ve inspired minds, fostered growth, and built a community rooted in learning and friendship. As we celebrate this remarkable milestone, we thank everyone who has been a part of our journey and look forward to a bright future ahead.​&rdquo;</div>
									<div class="d-flex justify-content-center pt-2 pb-2"><img class="tm-people" src="./images/aeirone.jpg" alt=""></div>
									<div class="link-name d-flex justify-content-center">Aeirone Felipe</div>
									<div class="link-position d-flex justify-content-center">2024 Graduate</div>
								</div>
							</div>
						</div>
					</div>
			</section>
	</section>
	<section class="vh-100 bg-light home-mv">
		<div class="container-fluid py-5 h-100">
			<div class="row d-flex align-items-center h-100">
				<div class="col col-lg-6 mb-4 mb-lg-0 ">
					<figure class="text-center bg-white py-5 px-4 shadow-2" style="border-radius: .75rem;">
						<h4 style="color:#2F4582;">Our Mission</h4>
						<blockquote class="blockquote">
							<p>
								<span class="lead font-italic">Educating for eternity through GROWTH [an acronym for Godliness, Rich Relationships, Ownership, Wisdom, Transformational learning & Harvest] is the expression of curriculum and the guide for teaching and learning practice at Christchurch Adventist School.
								</span>
							</p>
						</blockquote>
					</figure>
				</div>
				<div class="col col-lg-6">
					<figure class="text-center bg-white py-5 px-4 shadow-2" style="border-radius: .75rem;">
						<h4 style="color:#2F4582;">Our Vision</h4>
						<blockquote class="blockquote">
							<p>
								<span class="lead font-italic">To go beyond one hallway and to be a school that is known for its commitment to excellence in all areas of school life. To be a school that is known for its commitment to excellence.
									Celebrating GROWTH is allowing time for the recognition of achievement in all areas of the GROWTH vision, both small and great.

								</span>
							</p>
						</blockquote>
					</figure>
				</div>
			</div>
		</div>
	</section>
</body>

<?php
require_once('footer.php');
?>

</html>