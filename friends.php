<?php include "includes/db.php"; ?>
<?php include "includes/new_admin_header.php"; ?>
<?php include "includes/admin_navigation.php"; ?>
<link rel="stylesheet" href="friends.css">
<?php include "mail_function/mail_function.php"; ?>

<div class="row">
<?php
    include "includes/view_all_friends.php";
    include "includes/friends_sidebar.php";
?>
</div>

<?php include "includes/admin_footer.php"; ?>