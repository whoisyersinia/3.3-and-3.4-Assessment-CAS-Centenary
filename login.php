<?php
require_once('./includes/connectlocal.inc');
require_once('./includes/basehead.html');

?>

<title>Login - CAS 100</title>
<div class="bg-danger vh-100 w-100 d-flex justify-content-center align-content-center">
	<div class="container-fluid">
		<div class="row vh-100">
			<div class="col-md-6 col-sm-3 bg-primary">
				<img src="" alt="">
			</div>
			<div class="col-md-6 col-sm-3 justify-content-center align-content-center">
				<main class="text-center w-auto m-auto px-5 mx-5 py-4">
					<form method="POST" action="login.php">
						<h1 class="h1 mb-3 fw-semibold text-primary">Welcome back!</h1>
						<div class="form-floating">
							<input name="email_user" type="text" class="pe-3 form-control border border-3 border-info" id="floatingInput" placeholder="name@example.com" value="<?php if (isset($_POST['email_user'])) echo $_POST['email_user']; ?>">
							<label for="floatingInput">Email or Username</label>
						</div>
						<div class="form-floating mt-3">
							<input name="password" type="password" class="form-control border border-3 border-info" id="floatingPassword" placeholder="Password">
							<label for="floatingPassword">Password</label>
						</div>
						<div class="checkbox mb-3 mt-2">
							<p class="text-info">Don't have an account?<a href="register.php" class="text-primary text-decoration-none"> Sign up now.</a></p>
						</div>
						<button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Sign in</button>
						<p class="mt-5 mb-3 text-muted">&copy; Christchurch Adventist School 2024-2025</p>
					</form>
				</main>
			</div>
		</div>
	</div>
</div>
<?php
require_once('footer.php');
