<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>


<div class="container col-lg-offset-3">
    <div class="container col-lg-6 align-content-center table-bordered">
        <h1>LOGIN</h1>


        <div>
            <form class="form-signin" action="includes/login.php" method="post">
                <hr>
                <div class="form-label-group">
                    <label for="username" class="col-sm-2 col-form-label">Username:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                    </div>
                </div>
                <div class="form-label-group">
                    <label for="pwd" class="col-sm-2 col-form-label">Password:</label>
                    <div class="col-lg-6">
                        <input type="password" placeholder="Password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="form-group form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" name="login" value="Submit">
                </div>
            </form>
        </div>
    </div>


    <?php include "includes/footer.php"; ?>