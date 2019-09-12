<?php
// SHOW PREVIOUS DETAILS
if (isset($_GET['source'])) {

    $query = "SELECT * FROM users WHERE user_id = {$_SESSION['user_id']} ";
    $select_users_query = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_users_query)) {
        $user_id        = $row['user_id'];
        $username       = $row['username'];
        $user_password  = $row['password'];
        $user_name      = $row['name'];
        $user_email     = $row['email'];
        $user_number    = $row['number'];
    }

    ?>
<?php
// UPDATE NEW DETAILS
    if (isset($_POST['edit_profile'])) {

        $username      = ($_POST['username']);
        $user_name     = ($_POST['name']);
        $user_password = ($_POST['password']);
        $user_password = password_hash($user_password, PASSWORD_DEFAULT);
        $user_email    = ($_POST['email']);
        $user_number   = ($_POST['number']);
// CHECK IF OLD PASSWORD IS SAME AS NEW
        if (!empty($user_password)) {

            $query_password = "SELECT password FROM users WHERE user_id =  {$_SESSION['user_id']}";
            $get_user_query = mysqli_query($connection, $query_password);
            if (!$get_user_query) {
                die("ERROR!" . mysqli_error($connection));
            }

            $row = mysqli_fetch_array($get_user_query);
            $db_user_password = $row['password'];

            if ($db_user_password != $user_password) {
                echo "PASSWORD CHANGED!!";
            }

            $query = "UPDATE users SET ";
            $query .= "name  = '{$user_name}', ";
            $query .= "username = '{$username}', ";
            $query .= "email = '{$user_email}', ";
            $query .= "number = '{$user_number}', ";
            $query .= "password   = '{$user_password}' ";
            $query .= "WHERE user_id = {$_SESSION['user_id']} ";

            $edit_user_query = mysqli_query($connection, $query);

            if (!$edit_user_query) {
                die("ERROR!" . mysqli_error($connection));
            }


            echo "Profile Updated";
            header("Location: profile.php");
        }
    }
} else {
    header("Location: profile.php");
}

?>

<div id="page-wrapper">

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-6 offset-sm-3">

                <h1 class="">
                    PROFILE UPDATE
                    <hr>
                </h1>
                <form action="" method="post">

                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" value="<?php echo $user_name; ?>" class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="post_tags">Username</label>
                        <input type="text" value="<?php echo $username; ?>" class="form-control" name="username" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="post_content">Email</label>
                        <input type="email" value="<?php echo $user_email; ?>" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="post_content">Number</label>
                        <input type="text" value="<?php echo $user_number; ?>" class="form-control" name="number" required>
                    </div>
                    <div class="form-group">
                        <label for="post_content">Password</label>
                        <input type="text" value="" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary btn-block" type="submit" name="edit_profile" value="Update Profile">
                    </div>

                </form>
            </div>
        </div>
      
    </div>
  
</div>
