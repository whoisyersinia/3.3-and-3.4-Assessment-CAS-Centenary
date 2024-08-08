<?php
require_once('./includes/basehead.html');
require_once("./includes/connectlocal.inc");
require_once('header.php');


?>

<title>CAS100 - Stock</title>

<body class="mt-5 pt-5 px-0 container-fluid">
	<div class="d-flex justify-content-center align-content-center mx-auto">
		<form action="search.php" method="GET">
			<div class=" d-inline-flex gap-2 container-fluid">
				<i class="fa-solid text-primary fa-magnifying-glass justify-content-center align-self-center fa-xl"></i>
				<input class="form-control me-2" type="search" placeholder="Search for product" aria-label="Search" name="searchterm" value="<?php if (isset($_GET['searchterm'])) echo $_GET['searchterm']; ?>">
				<button class="btn btn-outline-primary " type="submit" name="search">Search</button>
			</div>
			<div class="d-inline-flex gap-2 mx-3">
			</div>

		</form>
	</div>
	<div class="d-flex justify-content-center align-content-center pt-3">
		<button type='button' class='btn btn-danger border-black text-primary p-2 px-3 me-3' onclick="window.location.href='addproduct.php'"><i class='fa-solid fa-plus pe-2'></i>Add product</button>
	</div>
	<p class="mt-5 mb-3 text-muted text-center text-light">&copy; Anicus 2023</p>
</body>