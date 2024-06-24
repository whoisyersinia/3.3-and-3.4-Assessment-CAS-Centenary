<!DOCTYPE html>
<html lang="en">

<?php
include('./includes/basehead.html');
?>

<head>
	<title>Document</title>
</head>

<body>
	<div class="container-fluid overflow-hidden px-4 py-5 bg-dark w-100 shadow-lg">
		<div class="row">
			<div class="col-md-7">
				<div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg hover-zoom card_img">
					<div class="d-flex flex-column h-100 px-4 pt-5 mt-5 text-white text-shadow-1">
						<ul class="d-flex list-unstyled mt-auto">
							<li class="me-auto pt-5 mt-5">
								<img class="rounded-circle border border-white" src="./images/cat_transparent.svg" width="32" height="32" alt="logo" loading="lazy">
							</li>
							<li class="d-flex align-items-center">
								<a class="text-decoration-none text-white pt-5 mt-5"><small>Anicus 2023</small></a>
							</li>
						</ul>
					</div>

				</div>
			</div>
			<div class="col-md-5 text-end m-0 fade-right reveal_once">
				<h2 class="fw-bold ">Welcome to the <span class="text-white text_effect">World of Anime.</span></h2>
				<p>Anime is a type of animation originating from Japan. It has a wide range of genres for all type of viewers, including, but not limted to: <span class="fw-bold">action, drama, romance, comedy, horror, fantasy, sports, sci-fi, 'slice of life'</span> etc.</p>
				<hr>
				</hr>
				<h4>Don't know where to start?</h4>

				<div class="d-inline-flex">
					<i class="fa-solid fa-check pt-1 px-2"></i>
					<a href="listsearch.php" class="text-decoration-underline text-primary">
						<h5 class="text-muted">Check our 'Anime for Beginners Lists'</h5>
					</a>
				</div>
				<!--SEARCH FORM-->
				<form class="d-inline-flex pt-2" action="search.php" method="GET">
					<input class="form-control me-2" type="search" placeholder="Search for anime" aria-label="Search" name="searchterm" required>
					<button class="btn btn-outline-primary" type="submit" name="search">Search</button>
				</form>
			</div>
		</div>

	</div>
</body>

</html>