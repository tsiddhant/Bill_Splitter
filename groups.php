<?php include "includes/db.php"; ?><!-- Including Database Connection File -->
<?php include "includes/new_admin_header.php"; ?> <!-- Including header File -->
<?php include "includes/admin_navigation.php"; ?><!-- Including Navigation File -->
<link rel="stylesheet" href="groups.css"><!-- Including CSS File -->

<!-- ADDING NEW GROUP FOR ADMIN -->
<br>
<button name="group" class="btn btn-primary" id="1">Add Group</button>
<br>
<form id="group" class="col-lg-4" action="" method="post">
<div class="container" id="new">
    <label for="group">Type Group Name : </label>
    <input type="text" class="form-control" placeholder="ENTER GROUP NAME" name="group_name">
    <input type="submit" class="btn btn-primary" name="add_group" value="SUBMIT">
</div>
</form>
<!-- INSERTING NEW GROUP IN DATABASE -->
<?php
if(isset($_POST['add_group'])){
    $group_name     = $_POST['group_name'];
    $admin_id       = $_SESSION['user_id'];
    $admin_username = $_SESSION['username'];
    $query = "INSERT INTO groups (`admin_id`, `admin_username`, `group_name`, `status`) ";//Query to insert new group in table
    $query .= "VALUES ('{$admin_id}', '{$admin_username}', '{$group_name}', 'open') ";
    $result = mysqli_query($connection,$query);
    if(!$result){
        die("ERROR".mysqli_error($connection));
    }
    header("Location: groups.php");//Redirecting after insert is successful
}
?>

<!-- SHOWING ALL GROUPS WITH USER AS MEMBER OR ADMIN -->
<div class="embed-responsive col-lg-8" style="margin:auto; height:300px;">
            <table class="table table-borderless rounded table-hover table-warning"><!-- Creating table to display all groups joined by user -->
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
                <!-- PAGINATION -->
                    <?php
                    $limit = 4;  
                    if (isset($_GET["page"])) {
                        $page  = $_GET["page"]; 
                        } 
                        else{ 
                        $page=1;
                        };  
                    $start_from = ($page-1) * $limit;
                // Query to select all groups where user is member or admin
                    $query = "SELECT * FROM groups WHERE members LIKE '%{$_SESSION['username']}%' OR admin_username LIKE '%{$_SESSION['username']}%' LIMIT $start_from, $limit";
                    $result = mysqli_query($connection, $query);
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $group_id         = $row['group_id'];
                        $group_name       = $row['group_name'];
                        $admin_username   = $row['admin_username'];
                        $status           = $row['status'];
                        $date             = $row['date'];
                        
                        echo '<tr scope="row">';//Displaying all groups details joined by user
                        echo "<td>$i</td>";
                        echo "<td><a href='groups_add.php?source={$group_id}'>$group_name</a></td>";
                        echo "<td>$admin_username</td>";
                        echo "<td>$status</td>";
                        echo "<td>$date</td>";
                        echo "<td><a href='groups.php?comment={$group_id}&name={$group_name}'>Comments</a></td>";
                        echo "</tr>";
                        $i++;
                    }
                    ?>

                </tbody>
            </table><!-- End of Table -->
<!-- PAGINATION -->
            <?php  
                $result_db = mysqli_query($connection,"SELECT COUNT(user_id) FROM users"); 
                $row_db = mysqli_fetch_row($result_db);  
                $total_records = $row_db[0];  
                $total_pages = ceil($total_records / $limit); 
                /* echo  $total_pages; */
                $pagLink = "<ul class='pagination'>";  
                for ($i=1; $i<=$total_pages; $i++) {
                            $pagLink .= "<li class='page-item'><a class='page-link' href='groups.php?page=".$i."'>".$i."</a></li>";	
                }
                echo $pagLink . "</ul>";  
            ?>

        </div>
<!-- QUERY TO DELETE A GROUP -->
        <?php
        if (isset($_GET['delete'])) {
            $the_user_id = ($_GET['delete']);
            $query = "DELETE FROM friends WHERE user2_id = {$the_user_id} AND user1_id = {$_SESSION['user_id']}";//Query to delete group
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
      $the_group_name = $_GET['name'];
      echo "<h1><center><u>$the_group_name</u></center></h2><h4><center>Comments Section</center></h4>";
            if (isset($_POST['create_comment'])) {
                $comment_content = $_POST['content'];
                if (!empty($comment_content)) {//Query to insert new comment 
                    $query = "INSERT INTO comments (comment_group_id, comment_author, comment_content)";
                    $query .= "VALUES ($the_group_id ,'{$_SESSION['name']}', '{$comment_content}')";
                    $create_comment_query = mysqli_query($connection, $query);
                    if (!$create_comment_query) {
                        die('QUERY FAILED' . mysqli_error($connection));
                    }
                }
            ?>
                <div class="alert alert-success"><!-- Showing alert on successful comment posted -->
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
                <form role="form" action="" method="post"><!-- Creating form to insert new comment -->
                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <textarea name="content" class="form-control" id="content" rows="3"></textarea>
                    </div>
                    <button type="submit" name="create_comment" id="submit_btn" class="button">Submit</button><!-- Comment Posting Button -->
                </form>
            </div>
            </div>
            </div>

            <!-- Posted Comments -->
            <?php 
            // Query to select all comments of particular post
            $query = "SELECT * FROM comments WHERE comment_group_id = {$the_group_id} ";
            $query .= "ORDER BY comment_id ASC ";
            $select_comment_query = mysqli_query($connection, $query);
            if(!$select_comment_query) 
            {
                die('Query Failed' . mysqli_error($connection));
            }
        ?>
        <div class="" id="cdisplay" style="overflow:scroll; height:400px; width:500px;background-color:whitesmoke;">
        <?php
            while ($row = mysqli_fetch_array($select_comment_query)) {//Selecting details of particular comment
            $comment_date   = $row['comment_date']; 
            $comment_content= $row['comment_content'];
            $comment_author = $row['comment_author'];
        ?>

        <!-- Comment -->
            <!-- Displaying details of All Group Comments -->
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

<?php include "includes/admin_footer.php"; ?><!-- Including Footer File -->

<script>   
$(document).ready(function(){
  $("#1").click(function(){
    $("#group").toggle(400);
  });
});
</script>