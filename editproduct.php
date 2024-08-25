<?php
require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');

session_start();

// check if user has logged in - if not 403 foribbden error

// if (isset($_SESSION['login'])) {
// 	if ($_SESSION['admin'] == 0) {
// 		http_response_code(403);
// 		header("Location: /CAS Centenary/errordocs/403.html");
// 		die();
// 	}
// } else {
// 	http_response_code(403);
// 	header("Location: /CAS Centenary/errordocs/403.html");
// 	die();
// }

$errors = array();

if (isset($_GET['id'])) {
	//check if product exists 
	$id = $_GET['id'];

	$q = "SELECT * FROM `product` WHERE (`id` = '$id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));


	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /errordocs/404.html");
		die();
	}

	while ($row = mysqli_fetch_assoc($r)) {
		$na = $row['name'];
		$pr = $row['price'];
		$st = $row['stock'];
		$pic = $row['image'];
		$des = $row['desc'];
		$lim = $row['limit_per_customer'];
	}

	$name = $desc = $price = $stock = $picture = $limit =  FALSE;

	if (isset($_POST['submit'])) {
		$errors = array();

		if (empty($_POST['name'] || $_POST['price'] || $_POST['stock'])) {
			array_push($errors, "Required fields empty!");
		} elseif ($_POST['name'] == $na && $_POST['price'] == $pr && $_POST['stock'] == $st && $_POST['picture'] == $pic && $_POST['desc'] == $des && $_POST['limit'] == $lim) {
			array_push($errors, "Please edit to continue!");
		} else {

			$name = preg_replace('/\s+/', ' ', $_POST['name']);

			// form validation through required fields
			if (strlen($name) > 2) {
				if (strlen($name) < 255) {
					$t = mysqli_real_escape_string($conn, $name);
				} else {
					array_push($errors, "Your product name exceeds the chracter limit (255)!");
				}
			} else {
				array_push($errors, "Your product name is less than 2 characters long!");
			}


			if ($_POST['price'] <= 0) {
				array_push($errors, "Price must not be less than or equal to 0!");
			} else {
				$price = mysqli_real_escape_string($conn, $_POST['price']);
			}

			if ($_POST['stock'] <= 0) {
				array_push($errors, "Stock quantity must not be less than or equal to 0!");
			} else {
				$stock = mysqli_real_escape_string($conn, $_POST['stock']);
			}

			$description = preg_replace('/\s+/', ' ', $_POST['desc']);
			$pic_link = preg_replace('/\s+/', ' ', $_POST['picture']);
		}
		// desc not required field
		if (!empty($description)) {
			if (strlen($description) > 5000) {
				array_push($errors, "Your synopsis is more than 5000 characters!");
			} else {
				$desc = mysqli_real_escape_string($conn, $description);
			}
		} else {
			$desc = NULL;
		}

		if (!empty($pic_link)) {
			if (strlen($pic_link) > 255) {
				array_push($errors, "Your picture link is more than 255 characters!");
			} else {
				$picture = mysqli_real_escape_string($conn, $pic_link);
			}
		} else {
			$picture = NULL;
		}

		if (!empty($_POST['limit'])) {
			if ($_POST['limit'] <= 0) {
				array_push($errors, "Limit quantity must not be less than or equal to 0!");
			} elseif ($_POST['limit'] > $stock) {
				array_push($errors, "Limit quantity must not be more than stock quantity!");
			} else {
				$limit = mysqli_real_escape_string($conn, $_POST['limit']);
			}
		} else {
			$limit = NULL;
		}
	}
} else {
	ob_end_clean();
	header("Location: index.php");
	exit();
}

if ($name && $price && $stock && ($desc !== False) && ($picture !== False) && ($limit !== False)) {

	$check_name_exists = "SELECT `name` FROM `product` WHERE `id` != '$id' AND `name`='" . $name . "'";
	$r = mysqli_query($conn, $check_name_exists) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));

	if (mysqli_num_rows($r) == 0) {
		date_default_timezone_set("Pacific/Auckland");
		$now = time();
		$datetime = date("Y-m-d H:i:s", $now);

		if ($limit == NULL) {
			$limit = 0;
		}

		$query = "UPDATE `product` SET `image` = '$picture', `name` = '$name', `desc` = " . ($desc == NULL ? "NULL" : "'$desc'") . ", `price` = '$price', `stock` = '$stock', `limit_per_customer` = '$limit', `updated_at` = '$datetime' WHERE (`id` = '$id')";

		$result = mysqli_query($conn, $query);
		header("Location: stock.php?s=update");
		mysqli_close($conn);
	} else {
		array_push($errors, "Product already exists. (Product Name Found!)");
	}
}

?>

<title>Edit - <?php echo $na ?></title>

<?php
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


<div class="container-fluid bg-light vh-100 w-100 d-flex justify-content-center align-content-center">
	<main class="text-center w-75 m-auto border border-light rounded-3 px-5 py-4 ">

		<form method="POST" autocomplete="off">
			<a href="index.php">
				<img class="p-0 mb-2" src="./images/LOGO-3line-raster-shaded-CAS.png" width="105px" height="100px" alt="logo">
			</a>
			<h1 class="h3 fw-semibold text-primary">Editing <?php echo $na ?></h1>
			<p>Fields with <span class="text-warning fw-bold">*</span> are required fields</p>

			<div class="d-inline-flex gap-5 justify-content-center">
				<div class="col-md-6">
					<div class="form-floating">
						<input name="name" type="text" class="form-control border border-3 border-info" id="floatingInput" placeholder="" value="<?php if (!isset($_POST['name'])) {
																																																																				echo $na;
																																																																			} else {
																																																																				echo $_POST['name'];
																																																																			} ?>">
						<label for="floatingInput">Title<span class="text-warning fw-bold">*</span></label>
						<div id="titleHelp" class="form-text text-info">Please enter the Product name.</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-floating">
						<textarea name="desc" type="text" class="form-control border border-3 border-info" id="floatingSynopsis" cols="30" rows="5"><?php if (!isset($_POST['desc'])) {
																																																																					echo $des;
																																																																				} else {
																																																																					echo $_POST['desc'];
																																																																				} ?></textarea>
						<label for="floatingDesc">Description</label>
						<div id="descHelp" class="form-text text-info">Include the general description of the product. (Max: 5000 characters)</div>
					</div>
				</div>
			</div>
			<div class="justify-content-center d-flex gap-5">
				<div class="col-md-2">
					<div class="form-floating">
						<input name="price" type="number" class="form-control border border-3 border-info" id="floatingGenre" placeholder="" value="<?php if (!isset($_POST['price'])) {
																																																																					echo $pr;
																																																																				} else {
																																																																					echo $_POST['price'];
																																																																				} ?>" max=9999 step=0.1>
						<label for="floatingPrice">Price (NZ$)<span class="text-warning fw-bold">*</span></label>
						<div id="priceHelp" class="form-text text-info">Set Price.</div>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-floating">
						<input name="stock" type="number" class="form-control border border-3 border-info" id="floatingGenre" placeholder="" value="<?php if (!isset($_POST['stock'])) {
																																																																					echo $st;
																																																																				} else {
																																																																					echo $_POST['stock'];
																																																																				} ?>" max=99999 step=1>
						<label for="floatingStock">Stock<span class="text-warning fw-bold">*</span></label>
						<div id="stockHelp" class="form-text text-info">Set Stock (quantity).</div>
					</div>
				</div>
			</div>
			<div class=" justify-content-center d-flex gap-2 pt-3">
				<div class="col-md-2">
					<div class="form-floating">
						<input name="limit" type="number" class="form-control border border-3 border-info" id="floatingGenre" placeholder="" value="<?php if (!isset($_POST['limit'])) {
																																																																					echo $lim;
																																																																				} else {
																																																																					echo $_POST['limit'];
																																																																				} ?>" max=99999 step=1>
						<label for=" floatingLimit">Limit per customer</label>
						<div id="limitHelp" class="form-text text-info">Set Limit Per Customer</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-floating">
						<input name="picture" type="text" class="form-control border border-3 border-info" id="floatingGenre" placeholder="" value="<?php if (!isset($_POST['picture'])) {
																																																																					echo $pic;
																																																																				} else {
																																																																					echo $_POST['picture'];
																																																																				} ?>">
						<label for="floatingPicture">Insert Picture Link</label>
					</div>
				</div>
			</div>

			<div class="mt-4 d-inline-flex gap-3">
				<button class="btn btn-lg btn-tertiary text-white border-primary" type="button" onclick="window.location.href='stock.php'">Cancel</button>

				<button class="btn btn-lg btn-primary w-100" type="submit" name="submit">Save Changes</button>
			</div>
			<p class="mt-3s mb-3 text-muted text-center text-light">&copy; Christchurch Adventist School 2024-2025</p>
		</form>
	</main>
</div>



<?php
include('footer.php');
