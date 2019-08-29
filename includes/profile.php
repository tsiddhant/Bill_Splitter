<?php

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_profile_query = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($select_user_profile_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['password'];
        $user_name = $row['name'];
        $user_email = $row['email'];
        $user_number = $row['number'];
    }
}

?>

<script>
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>



<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-6 offset-sm-3">

                <h1 class="page-header">
                    PROFILE
                    <hr>
                </h1>
                <form action="" method="post">

                    <div class="form-group">

                        <input type="text" value="<?php echo $user_name; ?>" class="form-control" name="user_name" disabled>
                    </div>

                    <div class="form-group">
                        <label for="post_username">Username</label>
                        <input type="text" value="<?php echo $username; ?>" class="form-control" name="username" disabled>
                    </div>

                    <div class="form-group">
                        <label for="post_number">Number</label>
                        <input type="text" value="<?php echo $user_number; ?>" class="form-control" name="user_number" disabled>
                    </div>

                    <div class="form-group">
                        <label for="post_email">Email</label>
                        <input type="email" value="<?php echo $user_email; ?>" class="form-control" name="user_email" disabled>
                    </div>

                    <div class="form-group">
                        <label for="post_password">Password</label>
                        <input type="password" id="password" value="<?php echo $user_password; ?>" class="form-control" name="user_password" disabled><input type="checkbox" onclick="myFunction()">Show Password
                    </div>

                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->