<?php
require_once('./includes/basehead.html');
require_once('header.php');

session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_GET['id'])) {
	//check if anime exists 
	$id = $_GET['id'];

	$q = "SELECT * FROM `product` WHERE (`id` = '$id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));


	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /errordocs/404.html");
		die();
	}

	while ($row = mysqli_fetch_assoc($r)) {
		$id = $row['id'];
		$na = $row['name'];
		$pr = $row['price'];
		$st = $row['stock'];
		$pic = $row['image'];
		$des = $row['desc'];
	}
}

// add to cart
// if (isset($_POST['add_to_cart'])) {
// 	// check if user has a cart
// 	// check if user is logged in
// 	if (!isset($_SESSION['login'])) {
// 		header("Location: login.php?s=req");
// 	} else {
// 		$user_id = $_SESSION['id'];
// 	}
// 	$query = "SELECT * FROM `cart` WHERE (`user_id` = '$user_id')";
// 	$result =  mysqli_query($conn, $query);

// 	date_default_timezone_set("Pacific/Auckland");
// 	$now = time();
// 	$datetime = date("Y-m-d H:i:s", $now);
// 	if (mysqli_num_rows($r) == 0) {
// 		// create cart
// 		$q = "INSERT INTO `cart` (`user_id`, `created_at`, `modified_at`) VALUES ('$user_id', '$datetime', '$datetime')";
// 		var_dump($q);
// 		$r =  mysqli_query($conn, $q);
// 	}
// 	// select user cart
// 	$_SESSION['cart'] = mysqli_fetch_array($result, MYSQLI_ASSOC);

// 	// add to cart
// 	$quantity = $_POST['quantity'];
// 	$q = "INSERT INTO `cart_item` (`cart_id`, `product_id`, `quantity`, `created_at`, `modified_at`) VALUES ('" . $_SESSION['cart']['id'] . "', '$id', '$quantity', '$datetime', '$datetime')";
// 	$r =  mysqli_query($conn, $q);
// 	mysqli_close($conn);
// }

?>

<title>CAS 100 - <?php echo $na ?></title>

<body>
	<div class="row mt-3 pt-2 container-fluid"></div>
	<form method="post" id='shop_form' action="addtocart.php/?id=<?php echo $id ?>">
		<div class="row container-fluid mt-5 pt-5 align-self-md-stretch mx-auto px-5">
			<div class="col-md-4">
				<img src="./product_images/<?php echo $pic ?>" alt="" class="img-fluid">
				<?php
				ini_set('display_errors', '1');
				ini_set('display_startup_errors', '1');
				error_reporting(E_ALL);
				?>
			</div>
			<div class="col-md-1">
			</div>
			<div class="col-md-7 p-5 bg-secondary product-card">
				<h3 class="product_name"><?php echo $na ?></h3>
				<h1 class="product_price pt-2">$<?php echo $pr ?>.00</h1>
				<p class="payment_details">PRE-ORDER ONLY. Pay on site at Christchurch Adventist School.</p>
				<div class="number pt-2">
					<p class='quantity_helper'>QUANTITY</p>
					<span class="minus">-</span>
					<input id="qty" name="quantity" type="text" value="1" max="999" min="1" />
					<span class="plus">+</span>
				</div>
				<div class="pt-5">
					<button type="submit" class="w-100 btn-lg btn btn-primary" name="add_to_cart">Add to Cart</button>
				</div>
				<div class="pt-2">
					<hr>
					<div class=" d-inline-flex">
						<i class="fa-solid fa-location-dot pt-1"></i>
						<p class="px-2 free_shipping">Free shipping anywhere in NZ or pick up at CAS.</p>
					</div>
				</div>
			</div>
		</div>
	</form>
	<div class="row container-fluid pt-4 mt-4 px-5 mx-auto">
		<div class="col-md-5"></div>
		<div class="col-md-7 px-5">
			<p class="product_desc"><?php echo $des ?></p>
			<p class="text-muted copyright">&copy; Christchurch Adventist School 2024-2025</p>
		</div>
	</div>
	</form>

	<div class="modal fade" id="cartModal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel">Item added to cart</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">
							<img src="./product_images/<?php echo $pic ?>" alt="" class="img-fluid">
						</div>
						<div class="col-md-6">
							<h5>$<?php echo $pr ?>.00</h5>
							<p><?php echo $na ?></p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue Shopping</button>
					<button type="button" class="btn btn-primary">Go to Cart</button>
				</div>
			</div>
		</div>
	</div>
</body>

<?php
require_once('footer.php');
