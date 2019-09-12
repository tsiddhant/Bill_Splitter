<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Reset Password</title>

	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<link href="../css/simple-sidebar.css" rel="stylesheet">

</head>

<body>

	<div class="d-flex" id="wrapper">


		<div class="bg-light border-right" id="sidebar-wrapper">
			<div class="sidebar-heading">RESET PASSWORD<br></div>
			<div class="list-group list-group-flush">
			</div>
		</div>

		<div id="page-content-wrapper">

			<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom"><br><br>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
				</div>
			</nav>

			<div class="container jumbotron">
				<div id="page-wrapper">
					<div class="col-lg-4 offset-sm-3">
						<form action="" method="post">
							<div>
								<h3 align: center;>Otp verified successfully</h3>
								<br><br>
							</div>
							<div class="form-group">
								<label>Enter New Password</label>
								<input type="password" value="" class="form-control" name="password" required="">
							</div>
							<div class="btn-group-toggle">
								<input type="submit" id="submit" class="btn btn-primary btn-block" value="Change Password" name="change" required="">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<?php
include('../includes/db.php');
include('mail_function.php');
session_start();
error_reporting(0);
$username = $_SESSION['username'];
if (isset($_POST['change'])) {
	$password = $_POST['password'];
	$password = password_hash($password, PASSWORD_DEFAULT);
	echo "<script type='text/javascript'>alert('password updated')</script>";
	$query = "UPDATE users SET password = '{$password}' WHERE username = '{$username}' ";
	$result = mysqli_query($connection, $query);

	if ($result) {
		$text = "Your password has been updated.";
		$subject = "Password Reset";
		$mail_status = sendmail($email, $username, $subject, $text);
		session_unset();
		session_destroy();
		header('location:../login.php');
		echo "<script type='text/javascript'>alert('password updated')</script>";
	} else {
		session_unset();
		session_destroy();
		echo "<script type='text/javascript'>alert('Problem with server try again later')</script>";
	}
}


?>