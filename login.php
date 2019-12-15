<?php include "includes/header.php"; ?><!-- Including Header File -->
<?php include "includes/navigation.php"; ?><!-- Including Navigation File -->
<link rel="stylesheet" href="login.css"><!-- Including CSS File -->

<div class="container login-form"><!-- Container For Login Form -->     
        <form  action="includes/login.php" method="post"><!-- Starting for Login Form -->
            <h1 style="text-align: center">LOGIN</h1>
         
            <div class="form-group"> <!-- Username -->
                <label for="username">Username:</label>
                <input class="form-control" type="text" id="username" name="username" placeholder="Username" required autofocus>                    
            </div>
            <div class="form-group"><!-- Password -->
                <label for="pwd" >Password:</label>
                <input class="form-control" type="password" id="pwd" placeholder="Password" name="password" required>
            </div>
            <div class="form-group"><!-- Login Button -->
                <input type="submit" class="btn btn-success login-btn btn-block" name="login" value="Login">
            </div>
            <div class="or-seperator"><i>or</i></div>
            <div class="text-center social-btn"><!-- Google And Facebook Link -->
                <a class="btn btn-primary btn-block"><i class="fa fa-facebook"></i> Sign in with <b>Facebook</b></a>
                <a href="<?php echo $loginURL ?>" class="btn btn-danger btn-block" ><i class="fa fa-google"></i> Sign in with <b>Google</b></a>
            </div>
            <div class="clearfix"> 
                <label class="pull-left checkbox-inline"><!-- Remember me -->
                    <input type="checkbox" class=" remember_me" name="remember_me" value="1"> Remember me
                </label>
                <a class="pull-right text-success" id="forgot-password" href="mail_function/reset_password.php" style="color:white;">Forgot Password?</a>
            </div>   
        </form>         
    </div>

<?php session_start(); ?><!-- Session Started -->
<?php include "includes/footer.php"; ?><!-- Including Footer File -->
<?php
//IF Wrong Details Entered then ERROR
if(isset($_SESSION["message"])){
    $message = "Invalid Username Or Password!!";
    echo "<script type='text/javascript'>alert('$message');</script>";
    $_SESSION["message"] = null;
}
?>