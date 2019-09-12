<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>


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


<style>
    .container {
      width: 100%;
      padding-top: 70px;
    }
    
    .login-form {
		width: 340px;
    	margin: 25px auto;
	}
    .login-form form {
        background:  teal;
        color: white;
    	margin-bottom: 15px;
      
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
        border-style: outset;
    }
    .login-btn {        
        font-size: 15px;
        font-weight: bold;
    }
    body {
	font-family: roboto;
}
    
  
     
    .login-btn {        
            font-size: 15px;
            font-weight: bold;
    }
    .or-seperator {
        margin: 20px 0 10px;
        text-align: center;
        border-top: 1px solid #ccc;
    }
    .or-seperator i {
        color: #2c3e50;
        padding: 0 10px;
        background: #f7f7f7;
        position: relative;
        top: -11px;
        z-index: 1;
    }
     
    .social-btn .btn {
        margin: 10px 0;
        font-size: 15px;
        text-align: left; 
        line-height: 24px;       
    }
    .social-btn .btn i {
		float: left;
		margin: 4px 15px  0 5px;
        min-width: 15px;
	}
  
</style>

    <?php include "includes/footer.php"; ?>