<?php
require_once('./includes/basehead.html');
require_once('header.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (!empty($_GET['s'])) {
	if ($_GET['s'] === "del") {
		echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
				id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
				<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
				</svg>";

		echo "Successfully deleted cart!";

		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
				</div>";
		header("refresh:3;url=cart.php");
	}
}

if (!isset($_SESSION['login'])) {
	header("Location: login.php?s=req");
} else {

	//check if current user owns the cart
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$current_userid = $_SESSION['id'];

		if ($current_userid !== $id) {
			http_response_code(403);
			header("Location: /CAS Centenary/errordocs/403.html");
			die();
		}
		//check if cart exists if not 404 error
		$q = "SELECT * FROM `user` WHERE (`id` = '$id')";
		$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));


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

		// get cart items
		$cart_items = array();
		$res = False;

		$q = "SELECT * FROM `cart` WHERE (`user_id` = '$id')";
		$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
		while ($row = mysqli_fetch_assoc($r)) {
			$total_price = $row['total_price'];
		}

		$cart_id = $_SESSION['cart']['id'];

		// join cart_items to cart
		$q = "SELECT product.id, product.name, product.price, product.stock, product.image, product.limit_per_customer, cart.total_price, cart_item.quantity FROM `product` 
		LEFT JOIN `cart_item` ON product.id = cart_item.product_id 
		LEFT JOIN `cart` ON cart.id = cart_item.cart_id
		WHERE cart_item.cart_id = '$cart_id'
		ORDER BY `cart_item`.`created_at` DESC";
		$r = mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

		while ($row = mysqli_fetch_array($r)) {
			$total_product_price = 0;
			$res = true;
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
							<p class='text-primary pt-1 ps-3' href=''>$name</p>
						</div>
					</th> 
					<th>
						<div class='number pt-2 pb-3'>
							<span id='minus' class='minus'>-</span>
							<input data-product-id='$id' data-limit='$lim' value='$qty' name='quantity' type='text' value='1' max='999' min='1' />
							<span id='plus' class='plus'>+</span>
						</div>
						<a class='text-decoration-none text-primary' href='deletecartitem.php?id=$id'><i class='fa-solid fa-trash-can pe-2'></i>Remove</a>
					</th>
					<th class='pt-3'>$$total_product_price.00</th>		
					</tr>
				"
			);
		}
	} else {
		$res = False;
	}
}

?>

<title>CAS100 - Cart</title>

<body class="d-flex flex-column vh-100">
	<div class="row container-fluid pt-5 mt-5">
		<div class="col-md-8">
			<div class="d-flex justify-content-between">
				<h1 class="text-primary px-5">Cart</h1>
				<?php if ($res == True) { ?>
					<a class="px-5 pt-3 text-decoration-none text-primary" href="deletecart.php"><i class='fa-solid fa-trash-can pe-2'></i>Remove</a>
				<?php } ?>
			</div>
			<div class="px-5">
				<?php
				if ($res == True) {
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
				} else {
					echo "<h2 class='text-primary pt-3'>Cart empty!</h2>";
				}
				?>
			</div>
		</div>
		<?php if ($res == True) { ?>
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
					<button class="btn btn-lg btn-primary w-100" onclick="window.location.href='checkout.php?id=<?php echo $_SESSION['id'] ?>'">Checkout now</button>
				</div>
			</div>
		<?php } ?>
		<div class="modal fade" id="warningModal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5 text-warning" id="exampleModalLabel"><i class="fa-solid fa-triangle-exclamation"></i> Exceeded item limit per customer!</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<?php
require_once('footer.php');
