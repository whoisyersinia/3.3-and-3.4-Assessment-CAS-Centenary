<?php
require_once('./includes/basehead.html');
require_once('header.php');


if (isset($_GET['searchterm'])) {
	$query = $_GET['searchterm'];
	$query = mysqli_escape_string($conn, $query);
	$q = "SELECT * FROM `product` WHERE `name` LIKE '%$query%' ORDER BY `product`.`updated_at` DESC";
	if (empty($query)) {
		$search = False;
	} else {
		$search = True;
	}
} else {
	$search = False;
	$q = "SELECT * FROM `product` ORDER BY `product`.`updated_at` DESC";
}

$r = mysqli_query($conn, $q);

if (mysqli_num_rows($r) == 0) {
	$msg = "<h1 class='px-5 d-flex justify-content-center'>Sorry, no results found!</h1>

	";
}

$product_results = array();


while ($row = mysqli_fetch_array($r)) {
	if (isset($row['image']) && !empty($row['image'])) {
		$picture = $row['image'];
	} else {
		$picture = "no_image.png";
	}
	array_push(
		$product_results,
		"<div class='col d-flex justify-content-start align-self-start'>
			<a href='product.php?id=$row[id]' class='card-link'>
				<div class='card' style='width: 18rem;'>
					<img src='./product_images/$picture' class='card-img-top card-img hover-zoom' height='250px' alt='card-img'>
					<div class='card-body mx-1'>
						<h5 class='card-title text-break text-clamp' style='font-size: clamp(1rem, 1.3vw, 1.5rem);'>$row[name]</h5>
						<h3 class='card-subtitle mb-2 text-wrap text-primary text-clamp fw-bold'>$ $row[price].00</h6>
					</div>
				</div>
			</a>
		</div>
		"
	);
}

?>

<title>CAS100 - Store</title>

<body class="mt-5 pt-5 px-0 container-fluid">
	<h1 class="fw-bold text-primary d-flex justify-content-center">CAS 100 Store</h1>
	<?php
	if ($search == True) {
		echo "<h4 class='fw-bold text-info justify-content-center d-flex'>Search results for: $query</h4>";
	}
	?>
	<div class="d-flex justify-content-center align-content-center mx-auto">
		<form method="GET">
			<div class=" d-inline-flex gap-2 container-fluid">
				<i class="fa-solid text-primary fa-magnifying-glass justify-content-center align-self-center fa-xl"></i>
				<input class="form-control me-2" type="search" placeholder="Search for product" aria-label="Search" name="searchterm" value="<?php if (isset($_GET['searchterm'])) echo $_GET['searchterm']; ?>">
				<button class="btn btn-outline-primary " type="submit" name="search">Search</button>
			</div>
			<div class="d-inline-flex gap-2 mx-3">
			</div>

		</form>
	</div>
	<div class='container-fluid pt-3 mb-5 px-5 mt-5'>
		<?php
		if (isset($msg)) {
			echo $msg;
		}
		?>
		<div class='row row-cols-sm-1 row-cols-lg-4 row-cols-md-2 d-flex g-5 align-items-sm-start justify-content-sm-start p-0'>
			<?php
			if (isset($product_results)) {
				foreach ($product_results as $product) {
					echo $product;
				};
			}
			?>
		</div>
	</div>
</body>

<?php

require_once('footer.php');
