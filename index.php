
<?php
  session_start();
  if(isset($_SESSION['admin'])){
    header('location:pages/admin/index.php');
  }

  if(isset($_SESSION['staff'])){
    header('location:pages/staff/index.php');

  }

?>

<!DOCTYPE HTML>
<html lang="en-us">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="vendor/assets/css/style.css" type='text/css' />
	<link rel="stylesheet" href="vendor/assets/bootstrap/css/bootstrap.min.css" type="text/css" />
	<title>Log in form</title>
</head>


<body>
	<div class="header text-center mb-5 ">
		<div class="container d-flex justify-content-center align-items-center">
			<div class="login-form-bx ">
				<div class="row">
					<div class="col-md-7 cards">
						<div class="authincation-content">

							<a class="login-logo " href="">
								<img src="vendor/dist/img/log.jpg " alt="" height="150" width="auto">
							</a>
							<div class="mb-4">

							</div>
							<form action="app/action/login.php" method="post">
							<?php
								if (isset($_SESSION['error'])) {
									echo "<div class='alert alert-danger text-center'>" . $_SESSION['error'] . "</div>";
									unset($_SESSION['error']); // Clear error after displaying
								}
								?>
								<div class="form-group">
									<label class="mb-2 tag">
										<strong class="">Email</strong></label>
									<input type="text" name="email" placeholder="Enter your Email" class="form-control  input " required />
								</div>


								<div class="form-group">
									<label class="mb-2 tag">
										<strong class="">Password</strong>
									</label>
									<input type="password" name="password" placeholder="Enter your password" class="form-control input " required />
								</div>

								<div class="form-row d-flex justify-content-between mt-4 mb-2">

								</div>
								<div class="text-center">
									<button type="login" name="login" class="btn btn-primary btn-block">login</button>
								</div>
							</form>


						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
</body>

</html>