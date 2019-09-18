<?php include "db.php"; ?>
<?php session_start(); ?>
<?php

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
     
    if(!empty($_POST['remember_me'])){
        $hour = time() + 3600*24*30;
        setcookie('username', $username, $hour);
        setcookie('password', $password, $hour);
    }

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    $check_user_exists = mysqli_num_rows($select_user_query);
    if(!$check_user_exists){
        $_SESSION["message"] = "INVALID USERNAME";
        header("location: ../login.php");
    }

    if (!$select_user_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
    while ($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_name = $row['name'];
        $db_user_number = $row['number'];
        $db_user_email = $row['email'];
        $db_user_password = $row['password'];
    }
    if ($username === $db_username && password_verify($password,$db_user_password)) {
        $_SESSION['user_id'] = $db_user_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['name'] = $db_user_name;
        $_SESSION['email'] = $db_user_email;

        header("Location: ../admin.php");
    } else {
       // header("Location: ../login.php");
    }
}

?>