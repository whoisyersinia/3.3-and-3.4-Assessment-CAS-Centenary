<?php
require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');

session_start();

// check if user has logged in - if not 403 foribbden error
// if (!isset($_SESSION['login'])) {
// 	http_response_code(403);
// 	header("Location: /anicus/errordocs/403.html");
// 	die();
// }

$errors = array();
$t = $g = $ep = $da = $sy = FALSE;

// if (isset($_POST['submit'])) {
// 	ini_set('display_errors', '1');
// 	ini_set('display_startup_errors', '1');
// 	error_reporting(E_ALL);

// 	if (empty($_POST['title'] || $_POST['genre'] = array() || $_POST['ep'])) {
// 		array_push($errors, "Required fields empty!");
// 	} else {

// 		$title = preg_replace('/\s+/', ' ', $_POST['title']);


// 		if (strlen($title) > 2) {
// 			if (strlen($title) < 255) {
// 				$t = mysqli_real_escape_string($conn, $title);
// 			} else {
// 				array_push($errors, "Your title exceeds the chracter limit (255)!");
// 			}
// 		} else {
// 			array_push($errors, "Your title is less than 2 characters long!");
// 		}

// 		if (isset($_POST['genre'])) {
// 			$genre = implode(', ', $_POST['genre']);
// 			$g = mysqli_real_escape_string($conn, $genre);
// 		} else {
// 			array_push($errors, "Genre field empty!");
// 		}

// 		if ($_POST['ep'] <= 0) {
// 			array_push($errors, "Episodes must not equal or be less than 0!");
// 		} else {
// 			$ep = mysqli_real_escape_string($conn, $_POST['ep']);
// 		}


// 		if (!empty($_POST['date_aired'])) {
// 			date_default_timezone_set("Pacific/Auckland");
// 			$now = time();
// 			$date_now = date('Y-m-d', $now);
// 			if ($_POST['date_aired'] > $date_now) {
// 				array_push($errors, "Airing date must not be in the future.");
// 			} else {
// 				$da = mysqli_real_escape_string($conn, $_POST['date_aired']);
// 			}
// 		} else {
// 			$da = NULL;
// 		}

// 		$synopsis = preg_replace('/\s+/', ' ', $_POST['synopsis']);
// 	}
// 	if (!empty($synopsis)) {
// 		if (strlen($synopsis) > 5000) {
// 			array_push($errors, "Your synopsis is more than 5000 characters!");
// 		} else {
// 			$sy = mysqli_real_escape_string($conn, $synopsis);
// 		}
// 	} else {
// 		$sy = NULL;
// 	}
// }


// if ($t && $g && $ep && ($da !== False) && ($sy !== False)) {

// 	$check_title_exists = "SELECT `title` FROM `anime` WHERE `title`='" . $t . "'";
// 	$r = mysqli_query($conn, $check_title_exists) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));

// 	if (mysqli_num_rows($r) == 0) {
// 		$userid = $_SESSION['iduser'];
// 		$now = time();
// 		$date_now = date('Y-m-d', $now);

// 		$query = "INSERT into `anime` (`title`, `synopsis`, `genre`, `date_aired`, `episodes`, `updated_on`, `iduser`) VALUES ('$t', " . ($sy == NULL ? "NULL" : "'$sy'") . ", '$g', " . ($da == NULL ? "NULL" : "'$da'") . ", '$ep', '$date_now','$userid')";

// 		$result = mysqli_query($conn, $query);
// 		header("Location: anime.php?s=add");
// 		mysqli_close($conn);
// 	} else {
// 		array_push($errors, "Anime already exists. (Same Title Found!)");
// 	}
// }


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

<title>Add Product</title>



<div class="container-fluid bg-light vh-100 w-100 d-flex justify-content-center align-content-center">
	<main class="text-center w-75 m-auto border border-light rounded-3 px-5 py-4 ">

		<form method="POST" autocomplete="off">
			<a href="index.php">
				<img class="p-0 mb-2" src="./images/LOGO-3line-raster-shaded-CAS.png" width="105px" height="100px" alt="logo">
			</a>
			<h1 class="h3 fw-semibold text-primary">Enter Product Details</h1>
			<p>Fields with <span class="text-warning fw-bold">*</span> are required fields</p>

			<div class="d-inline-flex gap-5 justify-content-center">
				<div class="col-md-6">
					<div class="form-floating">
						<input name="name" type="text" class="form-control border border-3 border-info" id="floatingInput" placeholder="" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>">
						<label for="floatingInput">Title<span class="text-warning fw-bold">*</span></label>
						<div id="titleHelp" class="form-text text-info">Please enter the Product name.</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="form-floating">
						<textarea name="synopsis" type="text" class="form-control border border-3 border-info" id="floatingSynopsis" cols="30" rows="5"><?php if (isset($_POST['synopsis'])) echo $_POST['synopsis']; ?></textarea>
						<label for="floatingSynopsis">Description</label>
						<div id="synopsisHelp" class="form-text text-info">Include the general description of the product. (Max: 5000 characters)</div>
					</div>
				</div>
			</div>

			<div class="mt-4">
				<button class="btn btn-lg btn-primary w-100" type="submit" name="submit">Add Product to Inventory</button>
			</div>
			<p class="mt-5 mb-3 text-muted text-center text-light">&copy; Christchurch Adventist School 2024-2025</p>
		</form>
	</main>
</div>



<?php
include('footer.php');
