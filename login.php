<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>
<link rel="stylesheet" href="login.css">


<div class="container login-form">     
        <form  action="includes/login.php" method="post">
            <h1 style="text-align: center">LOGIN</h1>
         
            <div class="form-group"> 
                <label for="username">Username:</label>
                <input class="form-control" type="text" id="username" name="username" placeholder="Username" required autofocus>                        
            </div>
            <div class="form-group">
                <label for="pwd" >Password:</label>
                <input class="form-control" type="password" id="pwd" placeholder="Password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success login-btn btn-block" name="login" value="Login">
            </div>
            <div class="or-seperator"><i>or</i></div>
            <div class="text-center social-btn">
                <a class="btn btn-primary btn-block"><i class="fa fa-facebook"></i> Sign in with <b>Facebook</b></a>
                <a href="<?php echo $loginURL ?>" class="btn btn-danger btn-block" ><i class="fa fa-google"></i> Sign in with <b>Google</b></a>
            </div>
            <div class="clearfix"> 
                <label class="pull-left checkbox-inline">
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
                <a class="pull-right text-success" id="forgot-password" href="mail_function/reset_password.php" style="color:white;">Forgot Password?</a>
            </div>   
        </form>         
    </div>

<?php include "includes/footer.php"; ?>