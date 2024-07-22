<body>

	<body>
		<?php
		require_once('./includes/connectlocal.inc');

		session_start();

		?>
		<nav class="navbar fixed-top navbar-expand-lg navbar-dark z-1 bg-danger">

			<div class="container-fluid ps-5 pt-2">

				<a href="index.php">
					<img src="./images/logo.svg" alt="logo-banner" class="navbar-brand ms-2 p-0" width="300px">
				</a>

				<button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="nav_button">
					<span class="navbar-toggler-icon text-dark">
					</span>
				</button>
				<div id="navbarNav" class="collapse navbar-collapse">
					<ul class="navbar navbar-nav bg-text-shadow ms-auto mb-lg-0 pe-3">
						<li class="nav-item px-3">
							<a class="nav-link text-primary fw-normal" href="index.php">Home</a>
						</li>
						<li class="nav-item px-3">
							<a class="nav-link text-primary fw-normal" href="">History</a>
						</li>
						<li class="nav-item px-3">
							<a class="nav-link text-primary fw-normal" href="">About</a>
						</li>
						<li class="nav-item px-3">
							<a class="nav-link text-primary fw-normal" href="">Contact Us</a>
						</li>
						<li class="nav-item px-3">
							<a class="nav-link text-primary fw-normal" href="">Store</a>
						</li>
					</ul>
				</div>
				<div class='navbar navbar-nav d-flex align-items-center justify-content-center pe-3'>
					<button type='button' class='nav-item btn navbar-btn btn-sm text-primary' id='btn_login' style='--bs-btn-padding-y: 0.5rem; --bs-btn-padding-x: 1.5rem; --bs-btn-font-size: 0.8rem;  border-color: #2b0806;'>Sign In</button>
				</div>
				<div class='navbar navbar-nav d-flex align-items-center justify-content-center pe-5'>
					<button type='button' class='nav-item btn btn-primary navbar-btn btn-sm text-capitalize' id='btn_register' style='--bs-btn-padding-y: 0.5rem; --bs-btn-padding-x: 1.3rem; --bs-btn-font-size: 0.8rem;'>Sign Up</button>
				</div>
			</div>
		</nav>
	</body>
</body>