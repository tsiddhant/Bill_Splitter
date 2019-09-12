<?php include "includes/db.php"; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php
   if (!isset($_SESSION['username'])) {
    header("Location: login.php");
   }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
   ADMIN HOMEPAGE
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" />

  <!-- Sidebar Navigation -->
  <link href="css/simple-sidebar.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

   <!-- GOOGLE CHARTS -->
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body class="">
  <div class="wrapper ">
    
  <?php include "includes/admin_navigation.php"; ?>
<?php include "mail_function/mail_function.php"; ?>


<div class="row">
<?php
    include "includes/view_all_friends.php";
    include "includes/friends_sidebar.php";
?>
</div>

<?php include "includes/admin_footer.php"; ?>