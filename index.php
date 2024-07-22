<!DOCTYPE html>
<html lang="en">

<?php
include('./includes/basehead.html');
?>

<head>
	<title>Christchurch Adventist School 100</title>
</head>

<body>
	<?php
	require_once('header.php');
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