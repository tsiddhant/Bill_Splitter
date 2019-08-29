<?php include "includes/db.php"; ?>
<?php include "includes/admin_header.php"; ?>

<?php include "includes/admin_navigation.php"; ?>





<h1 class="mt-4">Friends Section</h1>
<?php
if (isset($_GET['source'])) {
    $source = $_GET['source'];
} else {
    $source = '';
}
switch ($source) {
    case 'add_friends' : include "includes/add_friends.php";
        break;
    default:
        include "includes/view_all_friends.php";
        break;
}
?>




    <?php include "includes/admin_footer.php"; ?>