<?php

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_profile_query = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($select_user_profile_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['password'];
        $user_name = $row['name'];
        $user_email = $row['email'];
        $user_number = $row['number'];
        $picsource   = $row['picsource'];
    }
}

?>
<?php 
$friends_count=0;
         $query = "SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user1_id WHERE f.user2_id = {$_SESSION['user_id']} UNION SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user2_id WHERE f.user1_id = {$_SESSION['user_id']}";
         $select_friends = mysqli_query($connection, $query);
         $friends_count = mysqli_num_rows($select_friends);
$comments_count=0;
        $query2 = "SELECT * FROM comments WHERE comment_author = '{$_SESSION['name']}' ";
        $select_comments = mysqli_query($connection, $query2);
        $comments_count = mysqli_num_rows($select_comments);
$expenses_count=0;
        $query3 = "SELECT * FROM expense WHERE paid_by = '{$_SESSION['username']}' ";
        $select_expenses = mysqli_query($connection, $query3);
        $expenses_count = mysqli_num_rows($select_expenses);
$groups_count=0;
        $query4 = "SELECT * FROM groups WHERE admin_username = '{$_SESSION['username']}' OR members LIKE '%{$_SESSION['username']}%' ";
        $select_groups = mysqli_query($connection, $query4);
        $groups_count = mysqli_num_rows($select_groups);
?>

<script>
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

<?php

  if(isset($_POST["submit"]))
 {   

    if(file_exists($picsource)){
        unlink($picsource);
    }


    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "uploaded_images/".$filename;
    move_uploaded_file($tempname,$folder);
 $query = "UPDATE users SET picsource = '{$folder}' WHERE user_id = '{$_SESSION['user_id']}' ";
    $result_query = mysqli_query($connection,$query);
  header("Location: profile.php");
 }
?>

<hr>
<div class="container">
    <div class="row">
  		<div class="col-sm-10"><h1>PROFILE</h1></div>
    </div>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->
              

      <div class="text-center">
        <img src="<?php  echo $picsource; ?>" class="avatar img-circle img-thumbnail" alt="No image!" style="border-radius:150px;">
        <form action="" method="post" enctype="multipart/form-data">
        <input type="file" class="text-center center-block file-upload" name = "uploadfile" value = "" required>
        <button type="submit" value="Upload Image" name="submit">Upload Image</button>
        </form>
      </div><br>
          
          <div class="container jumbotron-fluid">
                <ul class="list-group">
                    <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>Friends Added</strong></span><?php echo $friends_count;  ?></li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>Groups Joined</strong></span><?php echo $groups_count;  ?></li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>Comments Posted</strong></span><?php echo $comments_count;  ?></li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>Payments Made</strong></span><?php echo $expenses_count;  ?></li>
                </ul> 
               
                <div class="panel panel-default">
                    <div class="panel-heading offset-4">Social Media</div>
                    <div class="panel-body offset-2">
                        <a href="#"><i class="fa fa-facebook fa-2x"></i></a> <a href="#"><i class="fa fa-github fa-2x"></i></a> <a href="#"><i class="fa fa-twitter fa-2x"></i></a> <a href="#"><i class="fa fa-pinterest fa-2x"></i></a> <a href="#"><i class="fa fa-google-plus fa-2x"></i></a>
                    </div>
                </div>
          </div>
          
        </div><!--/col-3-->
    	<div class="col-sm-9">
              <br><br><br><br>
          <div class="jumbotron col-lg-9 float-lg-right">
            <div class="tab-pane active" id="home">
                <hr>
                        <form action="" method="post">

                        <div class="form-group">

                            <input type="text" value="<?php echo $user_name; ?>" class="form-control" name="user_name" disabled>
                        </div>

                        <div class="form-group">
                            <label for="post_username">Username</label>
                            <input type="text" value="<?php echo $username; ?>" class="form-control" name="username" disabled>
                        </div>

                        <div class="form-group">
                            <label for="post_number">Number</label>
                            <input type="text" value="<?php echo $user_number; ?>" class="form-control" name="user_number" disabled>
                        </div>

                        <div class="form-group">
                            <label for="post_email">Email</label>
                            <input type="email" value="<?php echo $user_email; ?>" class="form-control" name="user_email" disabled>
                        </div>

                        <div class="form-group">
                            <label for="post_password">Password</label>
                            <input type="password" id="password" value="<?php echo $user_password; ?>" class="form-control" name="user_password" disabled><input type="checkbox" onclick="myFunction()">Show Password
                        </div>

                        </form>
              
              <hr>
              
             </div><!--/tab-pane-->
            
          </div><!--/tab-content-->

        </div><!--/col-9-->
    </div><!--/row-->
                                                      
    <script>
            $(document).ready(function() {

    
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.avatar').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }


            $(".file-upload").on('change', function(){
                readURL(this);
            });
            });
    </script>
