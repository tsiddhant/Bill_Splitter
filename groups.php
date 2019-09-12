<?php include "includes/db.php"; ?>
<?php include "includes/new_admin_header.php"; ?> 
<?php include "includes/admin_navigation.php"; ?>
<link rel="stylesheet" href="groups.css">

<!-- ADDING NEW GROUP FOR ADMIN -->
<br>
<button name="group" class="btn btn-primary" id="1">Add Group</button>
<br>
<form id="group" class="col-lg-4" action="" method="post">
<div class="container jumbotron" id="new">
    <label for="group">Type Group Name : </label>
    <input type="text" class="form-control" placeholder="ENTER GROUP NAME" name="group_name">
    <hr>
    <input type="submit" class="btn btn-primary" name="add_group" value="SUBMIT">
 
</div>
</form>
<!-- INSERTING NEW GROUP IN DATABASE -->
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

<!-- SHOWING ALL GROUPS WITH USER AS MEMBER OR ADMIN -->
<div class="embed-responsive col-lg-8" style="margin:auto; height:300px;">
            <table class="table table-borderless rounded table-hover table-warning">
                <thead>
                    <tr>
                        <th scope="col">Serial No.</th>
                        <th scope="col">Group Name</th>
                        <th scope="col">Admin Username</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date Created</th>
                        
                        
                    </tr>
                </thead>
                <tbody class="table-hover">

                    <?php
                    $query = "SELECT * FROM groups WHERE members LIKE '%{$_SESSION['username']}%' OR admin_username LIKE '%{$_SESSION['username']}%' ";
                    $result = mysqli_query($connection, $query);
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $group_id         = $row['group_id'];
                        $group_name       = $row['group_name'];
                        $admin_username   = $row['admin_username'];
                        $status           = $row['status'];
                        $date             = $row['date'];
                        
                        echo '<tr scope="row">';
                        echo "<td>$i</td>";
                        echo "<td><a href='groups_add.php?source={$group_id}'>$group_name</a></td>";
                        echo "<td>$admin_username</td>";
                        echo "<td>$status</td>";
                        echo "<td>$date</td>";

                        echo "<td><a href='groups.php?comment={$group_id}'>Comments</a></td>";

                        echo "</tr>";
                        $i++;
                    }
                    ?>

                </tbody>
            </table>
        </div>
<!-- QUERY TO DELETE A GROUP -->
        <?php
        if (isset($_GET['delete'])) {
            $the_user_id = ($_GET['delete']);
            $query = "DELETE FROM friends WHERE user2_id = {$the_user_id} AND user1_id = {$_SESSION['user_id']}";
            $delete_user_query = mysqli_query($connection, $query);
            if (!$delete_user_query) {
                die("ERROR!" . mysqli_error($connection));
            }
            header("Location: friends.php");
        }
        ?>

<hr><br><br><br>

<!-- COMMENTS -->
 <!-- Blog Comments -->
 <?php if(isset($_GET['comment'])) {

      $the_group_id = $_GET['comment'];

            if (isset($_POST['create_comment'])) {
                $comment_content = $_POST['content'];
                if (!empty($comment_content)) {
                    $query = "INSERT INTO comments (comment_group_id, comment_author, comment_content)";
                    $query .= "VALUES ($the_group_id ,'{$_SESSION['name']}', '{$comment_content}')";
                    $create_comment_query = mysqli_query($connection, $query);
                    if (!$create_comment_query) {
                        die('QUERY FAILED' . mysqli_error($connection));
                    }
                }
            ?>
                <div class="alert alert-success">
                    <strong>Success!</strong> Comment Posted.
                </div>
                <script>
                    $(document).ready(function(){
                        $(".alert").fadeOut(5000);
                    });
                </script>
              <?php
            }
?>

            <!-- Comments Form -->
            <div id="comment_form">
            <div class="well col-lg-4 float-lg-right" style="height:200px; width:400px; margin-right:40px;">
            <div class="jumbotron">
                <h4>Leave a Comment:</h4>
                <form role="form" action="" method="post">
                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <textarea name="content" class="form-control" id="content" rows="3"></textarea>
                    </div>
                    <button type="submit" name="create_comment" id="submit_btn" class="button">Submit</button>
                </form>
            </div>
            </div>
            </div>

           
            <!-- Posted Comments -->

            <?php 

            $query = "SELECT * FROM comments WHERE comment_group_id = {$the_group_id} ";
            $query .= "ORDER BY comment_id ASC ";
            $select_comment_query = mysqli_query($connection, $query);
            if(!$select_comment_query) 
            {
                die('Query Failed' . mysqli_error($connection));
            }
            while ($row = mysqli_fetch_array($select_comment_query)) {
            $comment_date   = $row['comment_date']; 
            $comment_content= $row['comment_content'];
            $comment_author = $row['comment_author'];
            

            ?>

        <!-- Comment -->
        <div class="overflow-auto" id="cdisplay" style="height:300px; width:400px;">
            <div class="media float-lg-left" style="margin-left:5px;" id="here">
                <a class="pull-left">
                <i class="fa fa-comments" aria-hidden="true" style="font-size:25px;"></i>
                </a>
                <div class="media-body">
                    <h5 class="media-heading">
                        &nbsp<u><?php echo $comment_author;?></u>
                        <small><?php echo $comment_date;?></small>
                    </h5>
                    <?php echo $comment_content;?><br><br>
                </div>
            </div>
            
            <?php } ?>
            </div>
<?php  } ?>

<?php include "includes/admin_footer.php"; ?>