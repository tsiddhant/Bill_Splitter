<?php include "includes/db.php"; ?>
<?php include "includes/admin_header.php"; ?>

<?php include "includes/admin_navigation.php"; ?>


<br>
<button name="group" class="btn btn-primary" id="1">Add Group</button>

<br><br>
<form id="group" class="col-lg-4" action="" method="post">
<div class="container jumbotron" id="new">
    <label for="group">Type Group Name : </label>
    <input type="text" class="form-control" placeholder="ENTER GROUP NAME" name="group_name">
    <hr>
    <input type="submit" class="btn btn-primary" name="add_group" value="SUBMIT">
 
</div>
</form>

<?php
if(isset($_POST['add_group'])){
    $group_name     = $_POST['group_name'];
    $admin_id       = $_SESSION['user_id'];
    $admin_username = $_SESSION['username'];
    $query = "INSERT INTO groups (`admin_id`, `admin_username`, `group_name`, `status`) ";
    $query .= "VALUES ('{$admin_id}', '{$admin_username}', '{$group_name}', 'open') ";
    $result = mysqli_query($connection,$query);
    if(!$result){
        die("ERROR".mysqli_error($connection));
    }
    header("Location: groups.php");
}
?>



<style>
#group {
    display: none;
}
 
</style>
<script>   
$(document).ready(function(){
  $("#1").click(function(){
    $("form").toggle(400);
  });
});
</script>


<div class="table-responsive col-lg-6">
            <table class="table table-bordered table-hover table-warning">
                <thead>
                    <tr>
                        <th scope="col">Serial No.</th>
                        <th scope="col">Group Name</th>
                        <th scope="col">Admin Username</th>
                        <th scope="col">Status</th>
                        
                        
                    </tr>
                </thead>
                <tbody class="table-hover">

                    <?php
                    $query = "SELECT * FROM groups WHERE members LIKE '%{$_SESSION['username']}%' OR admin_username LIKE '%{$_SESSION['username']}%' ";
                    $result = mysqli_query($connection, $query);
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $group_name       = $row['group_name'];
                        $admin_username   = $row['admin_username'];
                        $status            = $row['status'];
                        
                        echo '<tr scope="row">';
                        echo "<td>$i</td>";
                        echo "<td><a href='#'>$group_name</a></td>";
                        echo "<td>$admin_username</td>";
                        echo "<td>$status</td>";
                        
                        // echo "<td><a href='friends.php?delete={$user_id}'>Delete</a></td>";
                        echo "</tr>";
                        $i++;
                    }
                    ?>

                </tbody>
            </table>
        </div>

        <?php
        if (isset($_GET['delete'])) {
            $the_user_id = ($_GET['delete']);
            $query = "DELETE FROM friendship WHERE user2_id = {$the_user_id} AND user1_id = {$_SESSION['user_id']}";
            $delete_user_query = mysqli_query($connection, $query);
            if (!$delete_user_query) {
                die("ERROR!" . mysqli_error($connection));
            }
            header("Location: friends.php");
        }
        ?>


<?php include "includes/admin_footer.php"; ?>