<?php
require_once('./includes/basehead.html');
require_once("./includes/connectlocal.inc");
require_once('header.php');

// check if user has admin perms in - if not 403 foribbden error

if (isset($_SESSION['login'])) {
	if ($_SESSION['admin'] == 0) {
		http_response_code(403);
		header("Location: /CAS Centenary/errordocs/403.html");
		die();
	}
} else {
	http_response_code(403);
	header("Location: /CAS Centenary/errordocs/403.html");
	die();
}

// status popup messages
if (!empty($_GET['s'])) {
	if ($_GET['s'] === "add") {

		echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top z-2' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
		id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
		<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
		</svg>";

		echo "Successfully added product!";

		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";
		header("refresh:3;url=stock.php");
	} elseif ($_GET['s'] === "delete") {
		echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top z-2' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
				id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
				<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
				</svg>";

		echo "Successfully deleted product!";

		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
				</div>";
		header("refresh:3;url=stock.php");
	} elseif ($_GET['s'] === "update") {
		echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top z-2' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
				id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
				<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
				</svg>";

		echo "Successfully updated product!";

		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
				</div>";
		header("refresh:3;url=stock.php");
	}
}

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

//show inventory table 
$r = mysqli_query($conn, $q);

$result = False;
$product_results = array();

while ($row = mysqli_fetch_assoc($r)) {
	$result = True;
	$id = $row['id'];
	$name = $row['name'];
	$price = $row['price'];
	$stock = $row['stock'];
	$picture = $row['image'];

	if (isset($row['image']) && !empty($row['image'])) {
		$picture = $row['image'];
	} else {
		$picture = "no_image.png";
	}

	array_push(
		$product_results,
		"<tr>
		<th><img src='./product_images/$picture' alt='img'  width='100px'></th>
		<th><a class='a-link text-primary pe-2' href=''>$name</a>
		<div class='d-inline-flex'>
		<a class='d-flex justify-content-end align-content-end px-2' style='font-size:0.8rem' href='deleteproduct.php?id=$id&a=delete'>Delete</a>
		<a class='d-flex justify-content-end align-content-end px-1' style='font-size:0.8rem' href='editproduct.php?id=$id'>Edit</a>
		</div> 
		</th> 
		<th>$$price.00</th>
		<th>$stock</th>


		</tr>"

	);
}

?>

<title>CAS100 - Inventory</title>

<body class="mt-5 pt-5 px-0 container-fluid">
	<h1 class="fw-bold text-primary d-flex justify-content-center">Inventory</h1>
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
	<div class="d-flex justify-content-center align-content-center pt-3">
		<button type='button' class='btn btn-danger border-black text-primary p-2 px-3 me-3 mb-2' onclick="window.location.href='addproduct.php'"><i class='fa-solid fa-plus pe-2'></i>Add product</button>
	</div>

	<?php
	if ($result === True) {
		echo "<table class='table table-hover table-responsive table-light border-primary table-bordered'>
			<thead>
				<tr>
					<th  class='w-10'scope='col'>Image</th>
					<th class='w-75' scope='col'>Product Name</th>
					<th scope='col'>Price</th>
					<th  class='w-10' scope='col'>Stock</th>
	
				</tr>
			</thead>
			<tbody class='table-group-divider'>
				
			";
		if (isset($product_results)) {
			foreach ($product_results as $product) {
				echo $product;
			};
		}
		echo "
			</tbody>
		</table>";
	} else {
		echo "<h2 class='fw-bold text-primary d-flex justify-content-center pt-3'>No results found!</h2>";
	}
	?>
</body>

<?php

require_once('footer.php');
