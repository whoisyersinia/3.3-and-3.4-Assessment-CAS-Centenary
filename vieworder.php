<?php
require_once('./includes/basehead.html');
require_once('header.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_GET['id'])) {
	//check if order exists 
	$id = $_GET['id'];

	$q = "SELECT * FROM `order` WHERE (`id` = '$id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	while ($row = mysqli_fetch_assoc($r)) {
		$user_id = $row['user_id'];
		$order_id = $row['id'];
		$total_price = $row['total'];
		$status = $row['status'];
		$cart_id = $row['cart_id'];
	}

	$q = "SELECT * FROM `user` WHERE (`id` = '$user_id')";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	while ($row = mysqli_fetch_assoc($r)) {
		$e = $row['email'];
		$u = $row['username'];
		$fn = $row['first_name'];
		$ln = $row['last_name'];
	}

	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /errordocs/404.html");
		die();
	}
	// get cart items
	$cart_items = array();

	$q = "SELECT * FROM `cart` WHERE (`user_id` = '$id')";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
	while ($row = mysqli_fetch_assoc($r)) {
		$total_price = $row['total_price'];
	}

	// join cart_items to cart
	$q = "SELECT product.id, product.name, product.price, product.stock, product.image, product.limit_per_customer, cart.total_price, cart_item.quantity FROM `product` 
	LEFT JOIN `cart_item` ON product.id = cart_item.product_id 
	LEFT JOIN `cart` ON cart.id = cart_item.cart_id
	WHERE cart_item.cart_id = '$cart_id'
	ORDER BY `cart_item`.`created_at` DESC";
	$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	while ($row = mysqli_fetch_array($r)) {
		$total_product_price = 0;
		$id = $row['id'];
		$name = $row['name'];
		$price = $row['price'];
		$stock = $row['stock'];
		$picture = $row['image'];
		$qty = $row['quantity'];
		$total_price = $row['total_price'];
		$lim = $row['limit_per_customer'];

		$total_product_price += $price * $qty;

		if (isset($row['image']) && !empty($row['image'])) {
			$picture = $row['image'];
		} else {
			$picture = "no_image.png";
		}

		array_push(
			$cart_items,
			"
				<tr>
				<th>
					<div class='d-flex justify-content-start p-2'>
						<img src='./product_images/$picture' alt='img'  width='100px'>
						<a href='product.php?id=$id'><p class='text-primary pt-1 ps-3'>$name</p></a>
					</div>
				</th> 
				<th>
				<p class='pt-3'>$qty</p>
				</th>
				<th class='pt-3'>$$total_product_price.00</th>		
				</tr>
			"
		);
	}

	$paid_url = "window.location.href='paidorder.php?id=$order_id'";
	$cancel_url = "window.location.href='cancelorder.php?id=$order_id'";
}

?>
<title>CAS100 - Order #<?php echo $order_id ?></title>


<body>
	<div class="row container-fluid pt-5 mt-5">
		<div class="col-md-8 ">
			<div class="d-flex justify-content-between">
				<h1 class="text-primary px-5">Order #<?php echo $order_id ?> Cart</h1>
			</div>
			<div class="px-5">
				<?php
				echo "<table class='table table-hover table-responsive table-light table-sm'>
					<thead>
						<tr class='table-primary'>
							<th scope='col'>PRODUCT</th>
							<th scope='col'>QUANTITY</th>
							<th scope='col'>PRICE</th>
						</tr>
					</thead>
					<tbody class='table-group-divider'>
		
					";
				if (isset($cart_items)) {
					foreach ($cart_items as $product) {
						echo $product;
					};
				}
				echo "
					</tbody>
				</table>";
				?>
			</div>
		</div>
		<div class="col-md-4 border rounded-3 border-gray border-1 checkout_box p-5 mt-5">
			<div class="mx-auto">
				<h3>Customer Details</h1>
					<p>Username:<span class="fw-bold"> <?php echo $u ?></span></p>
					<p>Email:<span class="fw-bold"> <?php echo $e ?></span></p>
					<p>Name: <span class="fw-bold"><?php echo $fn, " ", $ln ?></span></p>
					<p>Order ID: <span class="fw-bold">#<?php echo $order_id ?></span></p>
					<p>Status:<span class="fw-bold"> <?php echo ucfirst($status) ?></span></p>
			</div>
		</div>
		<div class="row container-fluid ">
			<div class="col-md-8"></div>
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
					<button class="btn btn-lg btn-primary w-100" onclick="window.location.href='order.php'">Go back</button>
					<?php if ($status == 'pending') { ?>
						<div class="d-flex">
							<button class="btn btn-lg btn-outline-success w-100 mt-2 me-3" onclick=<?php echo $paid_url ?>><i class='fa-solid fa-hand-holding-dollar'></i> Paid</button>
							<button class="btn btn-lg btn-outline-warning w-100 mt-2" onclick=<?php echo $cancel_url ?>><i class='fa-solid fa-ban'></i> Cancel</button>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

</body>

<?php
require_once('footer.php');
