	<?php
	require_once('./includes/connectlocal.inc');

	session_start();
	?>
	<nav class="navbar fixed-top navbar-expand-lg">

		<div class="container-fluid ps-4 pt-2 text-shadow-1">

			<a href="index.php">
				<img src="./images/logo.svg" alt="logo-banner" class="navbar-brand ms-4 p-0 logo-nav">
			</a>

			<button class="navbar-toggler me-4 bg-light text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="nav_button">
				<span class="navbar-toggler-icon text-light">
				</span>
			</button>
			<div id="navbarNav" class="collapse navbar-collapse">
				<ul class="navbar navbar-nav bg-text-shadow ms-auto mb-lg-0 pe-3">
					<li class="nav-item px-2">
						<a class="nav-link text-primary fw-normal" href="reunion.php">Centenary Reunion</a>
					</li>
					<li class="nav-item px-2">
						<a class="nav-link text-primary fw-normal" href="history.php">History</a>
					</li>
					<li class="nav-item px-2">
						<a class="nav-link text-primary fw-normal" href="about.php">About</a>
					</li>
					<li class="nav-item px-2">
						<a class="nav-link text-primary fw-normal" href="store.php">Store</a>
					</li>
					<?php
					$total_qty = 0;
					if (isset($_SESSION['login'])) {
						$query = "SELECT * FROM `cart_item` WHERE (`cart_id` = '" . $_SESSION['cart']['id'] . "')";
						$r =  mysqli_query($conn, $query);
						while ($row = mysqli_fetch_array($r)) {
							$qty = $row['quantity'];
							$total_qty += $qty;
						}
					}
					?>
					<li class="nav-item px-3">
						<a class="nav-link text-primary fw-normal" href="cart.php?id=<?php if (isset($_SESSION['login'])) echo $_SESSION['id'] ?>"><i class="fa-solid fa-cart-shopping pe-2"></i>
							<span id="cart_total"><?php echo $total_qty ?></span>
						</a>
					</li>
					<?php
					if (isset($_SESSION['login'])) {
						if ($_SESSION['admin'] == 1) {
							echo "<li class='nav-item px-3 pt-1'>
								<a class='fw-bold text-tertiary text-decoration-none' href='admin.php' style='font-size: 1.3rem;'><i class='fa-solid fa-user-tie pe-2'></i>$_SESSION[username]</a>
								</li>";
						} else {
							echo "<li class='nav-item px-3 pt-1'>
								<a class='fw-bold text-primary text-decoration-none' style='font-size: 1.3rem;'><i class='fa-solid fa-user pe-2'></i>$_SESSION[username]</a>
								</li>";
						}
					}
					?>
				</ul>
				<?php
				if (isset($_SESSION['login'])) {

					echo "<div class='navbar navbar-nav d-flex align-items-center justify-content-center pe-md-5 pe-sm-3'>
					<button type='button' class='nav-item btn btn-tertiary navbar-btn btn-sm text-capitalize text-white me-2'id='btn_logout' style='--bs-btn-padding-y: 0.5rem; --bs-btn-padding-x: 1.5rem; --bs-btn-font-size: 0.8rem; border-color: #000000;'>Logout</button> </div>";
				} else {
					echo "<div class='navbar navbar-nav d-flex align-items-center justify-content-center pe-3'>
					<button type='button' class='nav-item btn navbar-btn btn-sm text-primary' id='btn_login' style='--bs-btn-padding-y: 0.5rem; --bs-btn-padding-x: 1.5rem; --bs-btn-font-size: 0.8rem;  border-color: #2b0806;'>Sign In</button>
					</div>";

					echo "<div class='navbar navbar-nav d-flex align-items-center justify-content-center pe-md-5 pe-sm-3'>
					<button type='button' class='nav-item btn btn-primary navbar-btn btn-sm text-capitalize' id='btn_register' style='--bs-btn-padding-y: 0.5rem; --bs-btn-padding-x: 1.3rem; --bs-btn-font-size: 0.8rem;'>Sign Up</button>
					</div>";
				}
				?>
			</div>



		</div>
	</nav>