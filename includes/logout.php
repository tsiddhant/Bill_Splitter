<?php session_start(); ?>
<?php

$_SESSION['username'] = null;
$_SESSION['name'] = null;
$_SESSION['email'] = null;
header("Location: ../login.php");

?>