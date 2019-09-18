<?php include "includes/db.php"; ?><!-- Including Database Connection File -->
<?php include "includes/new_admin_header.php"; ?><!-- Including Header File -->
<?php include "includes/admin_navigation.php"; ?><!-- Including navigation File -->
<link rel="stylesheet" href="friends.css"><!-- Including CSS File -->
<?php include "mail_function/mail_function.php"; ?><!-- Including mail sending File -->

<div class="row">
<?php
    include "includes/view_all_friends.php";
    include "includes/friends_sidebar.php";
?>
</div>

<?php include "includes/admin_footer.php"; ?><!-- Including Footer File -->