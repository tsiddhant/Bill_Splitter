<?php include "includes/db.php"; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Groups</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
</head>
<body>

<?php include "includes/admin_navigation.php"; ?>


</body>

</html>