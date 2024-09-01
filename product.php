<?php
require_once('./includes/basehead.html');
require_once('header.php');

if (isset($_GET['id'])) {
	//check if product exists 
	$id = $_GET['id'];

	$q = "SELECT * FROM `product` WHERE (`id` = '$id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));


	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /CAS Centenary/errordocs/404.html");
		die();
	}

	while ($row = mysqli_fetch_assoc($r)) {
		$id = $row['id'];
		$na = $row['name'];
		$pr = $row['price'];
		$st = $row['stock'];
		$pic = $row['image'];
		$des = $row['desc'];
		$lim = $row['limit_per_customer'];
	}

	if ($st == 0) {
		$msg = "<p class='text-warning'><i class='fa-solid fa-x'></i> Sorry, this item is out of stock!</p>";
	} elseif ($st <= 10) {
		$msg = "<p class='text-warning'><i class='fa-solid fa-stopwatch'></i> Hurry, Only <span class='fw-bold'>$st</span> left in stock!</p>";
	} else {
		$msg = NULL;;
	}

	if (isset($_SESSION['cart'])) {
		$cart_id = $_SESSION['cart']['id'];
	} else {
		$cart_id = NULL;
	}

	$q = "SELECT cart_item.quantity FROM `product` 
		LEFT JOIN `cart_item` ON product.id = cart_item.product_id 
		LEFT JOIN `cart` ON cart.id = cart_item.cart_id
		WHERE cart_item.cart_id = '$cart_id' AND product.id = '$id'";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	if (mysqli_num_rows($r) == 0) {
		$curr_qty = 0;
	} else {
		while ($row = mysqli_fetch_assoc($r)) {
			$curr_qty = $row['quantity'];
		}
	}
}

?>

<title>CAS 100 - <?php echo $na ?></title>

<body>
	<div class="row mt-3 pt-2 container-fluid"></div>
	<form method="post" id='shop_form' action="addtocart.php/?id=<?php echo $id ?>">
		<div class="row container-fluid mt-5 pt-5 align-self-md-stretch mx-auto px-5">
			<div class="d-flex justify-content-start px-3">
				<a class="text-muted pe-1 text-decoration-none icon-link-hover" href="store.php">Store </a>
				<span class='text-muted'>></span>
				<a class="text-primary ps-1 pe-1 text-decoration-none">Product </a>
				<?php if (isset($_SESSION['cart'])) { ?>
					<span class="text-muted">></span>
					<a class="text-decoration-none" href="cart.php?id=<?php echo $_SESSION['id'] ?>">
						<p class="ps-1 text-muted"> Cart</p>
					</a>
				<?php } ?>
			</div>
			<div class="col-md-4">
				<img src="./product_images/<?php echo $pic ?>" alt="" class="img-fluid">
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
					<input id="qty" name="quantity" type="text" value="1" max="<?php echo $lim ?>" min="1" />
					<span class="plus">+</span>
				</div>
				<div class="pt-3">
					<?php echo $msg ?>
				</div>
				<div class="pt-2">
					<?php if (isset($_SESSION['login'])) { ?>
						<?php if ($st == 0) { ?>
							<button type="button" class="w-100 btn-lg btn btn-primary" disabled>Out of Stock</button>
						<?php } else { ?>
							<button type="submit" class="w-100 btn-lg btn btn-primary" name="add_to_cart">Add to Cart</button>
						<?php } ?>
					<?php } else { ?>
						<button type="button" class="w-100 btn-lg btn btn-primary" onclick="window.location.href='login.php?s=req'">Login to Add Item to Cart</button>
					<?php } ?>
				</div>
				<div class="pt-2">
					<hr>
					<div class="d-inline-flex">
						<i class="fa-solid fa-location-dot pt-1"></i>
						<p class="px-2 free_shipping">Free shipping anywhere in NZ or pick up at CAS.</p>
					</div>
					<?php if ($lim > 0) { ?>
						<p><i class="fa-solid fa-hand"></i> Limit per customer: <span class="fw-bold"><?php echo $lim ?></span> items</p>
					<?php } ?>
					<!-- Hidden input fields to pass data to JS -->
					<input type="hidden" id='lim' value="<?php echo $lim ?>">
					<input type="hidden" id='curr_qty' value="<?php echo $curr_qty ?>">

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
					<button type="button" class="btn btn-primary" onclick="window.location.href='cart.php?id=<?php if (isset($_SESSION['login'])) echo $_SESSION['id'] ?>'">Go to Cart</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="warningModal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5 text-warning" id="exampleModalLabel"><i class="fa-solid fa-triangle-exclamation"></i> Limit <?php echo $lim ?> items per customer!</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue Shopping</button>
					<button type="button" class="btn btn-primary" onclick="window.location.href='cart.php?id=<?php if (isset($_SESSION['login'])) echo $_SESSION['id'] ?>'">Go to Cart</button>
				</div>
			</div>
		</div>
	</div>
</body>

<?php
require_once('footer.php');
