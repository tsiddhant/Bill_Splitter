<?php include "db.php"; ?><!-- Including Database Connection File -->
<?php session_start(); ?><!-- Session Started -->
<?php
//Verifying Login
if (isset($_POST['login'])) {
    $username = $_POST['username'];//Taking Username
    $password = $_POST['password'];//Taking Password

    $username = mysqli_real_escape_string($connection, $username);//To Prevent SQL Injection 
     //Setting Up Cookies
    if(!empty($_POST['remember_me'])){
        $hour = time() + 3600*24*30;
        setcookie('username', $username, $hour);
        setcookie('password', $password, $hour);
    }
    //Query to Verify if Username Entered Is Valid
    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    $check_user_exists = mysqli_num_rows($select_user_query);
    if(!$check_user_exists){
        $_SESSION["message"] = "INVALID USERNAME";
        header("location: ../login.php");//Redirecting to Login Page if Invalid Username
    }

    if (!$select_user_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
    while ($row = mysqli_fetch_array($select_user_query)) {//Getting User Details To Store In SESSION
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_name = $row['name'];
        $db_user_number = $row['number'];
        $db_user_email = $row['email'];
        $db_user_password = $row['password'];
    }
    if ($username === $db_username && password_verify($password,$db_user_password)) {//Checking PASSWORD entered
        //Setting SESSION values
        $_SESSION['user_id'] = $db_user_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['name'] = $db_user_name;
        $_SESSION['email'] = $db_user_email;

        header("Location: ../admin.php");//Redirecting to admin Page after succesful login
    } else {
        $_SESSION["message"] = "INVALID PASSWORD";
        header("Location: ../login.php");
    }
}

?>