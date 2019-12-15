<?php include "includes/db.php"; ?><!-- Including Database Connection File -->
<?php include "includes/new_admin_header.php"; ?><!-- Including Header File -->
<?php include "includes/admin_navigation.php"; ?><!-- Including navigation File -->

<?php
    if (isset($_GET['source'])) {
        $source = $_GET['source'];
    } else {
        $source = '';
    }
    switch ($source) {
        case 'edit_profile':
            include "includes/edit_profile.php";
            break;
        default:
            include "includes/profile.php";
            break;
    }
?>

<?php include "includes/admin_footer.php"; ?><!-- Including Footer File -->