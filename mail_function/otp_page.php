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
                            <h3>An OTP has been send to your registered email-id</h3>
                            <label>Enter OTP here:</label>
                            <input type="text" value="" class="form-control" name="otp">
                            <div><span id="end">Time 2 minutes</span></div>

                            <input type="submit" class="btn btn-primary btn-block" value="Verify OTP" name="submit" required="">
                            <input type="submit" class="btn btn-primary btn-block" id="resendbtn" disabled=true value="Resend OTP" name="resendbtn" required="">
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

if (isset($_POST['submit'])) {
    $otp = $_POST['otp'];
    $result = mysqli_query($connection, "SELECT * FROM otp_expiry WHERE otp = '$otp' AND expiry_status != 1 AND NOW() <= DATE_ADD(NOW(),INTERVAL 2 MINUTE)");
    if (!$result) {
        die("ERROR" . mysqli_error($connection));
    }
    $count = mysqli_num_rows($result);
    if (!empty($count)) {
        $result = mysqli_query($connection, "DELETE FROM otp_expiry WHERE otp = '$otp' ");
        echo "<script> location.href='new_password.php'; </script>";
    } else {
        echo "Invalid OTP";
    }
}
?>