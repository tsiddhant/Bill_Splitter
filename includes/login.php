<?php include "db.php"; ?>
<?php session_start(); ?>
<?php

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
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
    if ($username === $db_username && $password === $db_user_password) {
        $_SESSION['user_id'] = $db_user_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['name'] = $db_user_name;
        $_SESSION['email'] = $db_user_email;

        header("Location: ../admin.php");
    } else {
        header("Location: ../login.php");
    }
}

?>