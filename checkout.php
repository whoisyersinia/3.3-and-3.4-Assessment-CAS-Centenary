<?php
require_once('./includes/basehead.html');
require_once('header.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (!isset($_SESSION['login'])) {
	header("Location: login.php?s=req");
} else {

	//check if current user owns the cart
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$current_userid = $_SESSION['id'];
		$cart_id = $_SESSION['cart']['id'];

		if ($current_userid !== $id) {
			http_response_code(403);
			header("Location: /CAS Centenary/errordocs/403.html");
			die();
		}
		//check if user exists if not 404 error
		$q = "SELECT * FROM `user` WHERE (`id` = '$id')";
		$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

		while ($row = mysqli_fetch_assoc($r)) {
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
		}


		if ($_GET['id'] == " ") {
			ob_end_clean();
			header("Location: index.php");
			exit();
		}

		if (mysqli_num_rows($r) == 0) {
			http_response_code(404);
			header("Location: /CAS Centenary/errordocs/404.html");
			die();
		}

		// get cart
		$q = "SELECT * FROM `cart` WHERE (`id` = '$cart_id')";
		$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
		while ($row = mysqli_fetch_assoc($r)) {
			$total_price = $row['total_price'];
		}
	} else {
		http_response_code(404);
		header("Location: /CAS Centenary/errordocs/404.html");
		die();
	}
}

$errors = array();
$fn = $ln = FALSE;

if (isset($_POST['submit'])) {
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);

	if (empty($first_name) || empty($last_name)) {
		array_push($errors, "Required fields empty!");
	} else {
		// form validation through required fields
		if (strlen($first_name) > 2) {
			if (strlen($first_name) < 255) {
				$fn = mysqli_real_escape_string($conn, $first_name);
			} else {
				array_push($errors, "Your first name exceeds the chracter limit (255)!");
			}
		} else {
			array_push($errors, "Your first name is less than 2 characters long!");
		}

		if (strlen($last_name) > 2) {
			if (strlen($last_name) < 255) {
				$ln = mysqli_real_escape_string($conn, $last_name);
			} else {
				array_push($errors, "Your last name exceeds the chracter limit (255)!");
			}
		} else {
			array_push($errors, "Your last name is less than 2 characters long!");
		}
	}
}

if ($fn && $ln) {
	date_default_timezone_set("Pacific/Auckland");
	$now = time();
	$datetime = date("Y-m-d H:i:s", $now);
	// update users
	$q = "UPDATE `user` SET `first_name` = '$fn', `last_name` = '$ln' WHERE (`id` = '$id')";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	// insert into orders
	$q = "INSERT into `order` (`user_id`, `cart_id`, `total`, `created_at`, `modified_at`) VALUES ('$id', '$cart_id', '$total_price', '$datetime', '$datetime')";
	$r = mysqli_query($conn, $q) or trigger_error("Qsuery: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	// update qty in products
	$q = "SELECT product.id, product.name, product.price, product.stock, product.image, cart.total_price, cart_item.quantity FROM `product` 
	LEFT JOIN `cart_item` ON product.id = cart_item.product_id 
	LEFT JOIN `cart` ON cart.id = cart_item.cart_id
	WHERE cart_item.cart_id = '$cart_id'
	ORDER BY `cart_item`.`created_at` DESC";
	$result = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	while ($row = mysqli_fetch_array($result)) {
		$product_id = $row['id'];
		$stock = $row['stock'];
		$qty = $row['quantity'];
		$new_qty = $stock - $qty;
		$q = "UPDATE `product` SET `stock` = '$new_qty' WHERE (`id` = '$product_id')";
		$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
	}

	// get order_id
	$q = "SELECT * FROM `order` WHERE (`cart_id` = '$cart_id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	while ($row = mysqli_fetch_assoc($r)) {
		$order_id = $row['id'];
	}

	// update current cart to ordered
	$q = "UPDATE `cart` SET `ordered` = 1 WHERE (`id` = '$cart_id')";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	// create new cart
	$q = "INSERT into `cart` (`user_id`, `created_at`, `modified_at`, `ordered`) VALUES ('$id', '$datetime', '$datetime', 0)";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	//get new cart
	$q = "SELECT * FROM `cart` WHERE (`user_id` = '$id' AND `ordered` = 0)";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	$_SESSION['cart'] = mysqli_fetch_array($r, MYSQLI_ASSOC);
	mysqli_free_result($r);
	mysqli_close($conn);
	// send email
	$url = "receipt.php?id=" . $id . "&order_id=" . $order_id;
	header("Location: $url");
}

//print errors
if ($errors) {
	echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
	echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
	<path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
</svg>";

	echo array_values($errors)[0];

	echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
	</div>";
};

?>

<title>CAS100 - Checkout</title>



<body>
	<form method="post">
		<div class="row container-fluid pt-5 mt-5">
			<div class="col-md-8">
				<div class="d-flex justify-content-start px-5">
					<a class="text-muted pe-1 text-decoration-none icon-link-hover" href="cart.php?id=<?php echo $_SESSION['id'] ?>">Cart </a>
					<span class='text-muted'>></span>
					<a class="text-primary ps-1 pe-1 text-decoration-none">Checkout </a>
					<span class="text-muted">></span>
					<p class="ps-1 text-muted"> Confirmation</p>
				</div>
				<div class="border rounded-3 border-gray border-1 p-5 mt-2">
					<h5 class="text-primary">Enter personal details</h5>
					<div class="flex-row justify-content-around mx-auto">
						<div class="form-floating">
							<input name="first_name" type="text" class="form-control border border-2 border-gray" id="firstname" placeholder="name@example.com" value="<?php if (!isset($_POST['first_name'])) {
																																																																														echo $first_name;
																																																																													} else {
																																																																														echo $_POST['first_name'];
																																																																													} ?>">
							<label for="firstname">First name*</label>
						</div>
						<div class="form-floating mt-2">
							<input name="last_name" type="text" class="form-control border border-2 border-gray" id="lastname" placeholder="name@example.com" value="<?php if (!isset($_POST['last_name'])) {
																																																																													echo $last_name;
																																																																												} else {

																																																																													echo $_POST['last_name'];
																																																																												} ?>">
							<label for="lastname">Last name*</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 border rounded-3 border-gray border-1 checkout_box p-5 mt-5">
				<div class="mx-auto">
					<div class="d-flex justify-content-between ">
						<p class="">Subtotal</p>
						<p class="fw-bold">$<?php echo $total_price ?>.00</p>
					</div>
					<div class="d-flex p-0 justify-content-between ">
						<p class="">Discount</p>
						<p class="fw-bold">$0.00</p>
					</div>
					<hr>
					<div class="d-flex p-0 justify-content-between pt-2">
						<p class="">Grand total</p>
						<p class="fw-bold">$<?php echo $total_price ?>.00</p>
					</div>
					<button class="btn btn-lg btn-primary w-100" type="submit" name="submit">Pre-Order</button>
				</div>
			</div>
		</div>
	</form>
</body>

<?php
require_once('footer.php');
