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
                                    <div class="form-group">
                                        <label for="post_username"><h3>Username</h3></label>
                                        <input type="text" value="" name="username" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary btn-block" value="Reset password" name="reset">
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
date_default_timezone_set("Asia/Kolkata");
if (isset($_POST['reset'])) {
    $username = $_POST['username'];
    $request = "SELECT * FROM users WHERE username = '$username'";
    $retval = mysqli_query($connection, $request);
    $rows = mysqli_num_rows($retval);
    $data = mysqli_fetch_assoc($retval);
    $email = $data['email'];
    if ($rows) {
        $otp = rand(100000, 999999);
        $text = "Your password reset OTP is $otp";
        $subject = "Password reset using OTP validation";
        $mail_status = sendmail($data['email'], $username, $subject, $text);
        if ($mail_status) {
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $curr_time = date("Y-m-d H:i:s");
            echo "$curr_time";
            $result = mysqli_query($connection, "INSERT INTO otp_expiry (username,otp,expiry_status,create_at) VALUES ('$username','$otp','0','$curr_time')");
            echo "<script> location.href='otp_page.php'; </script>";
            exit;
        } else {
            echo "some problem in sending email " . mysqli_error($connection);
        }
    } else {
        echo "Username doesn't exist" . "<br>" . "Enter valid username";
    }
}

?>