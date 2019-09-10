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
    }
}

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

  if(isset($_POST['submit']))
 {   
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "uploaded_images/".$filename;
    move_uploaded_file($tempname,$folder);
    $query = "UPDATE SET ";


 }
unset($_POST);
?>

<hr>
<div class="container">
    <div class="row">
  		<div class="col-sm-10"><h1>PROFILE</h1></div>
    </div>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->
              

      <div class="text-center">
        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar">
        <h6>Upload a different photo...</h6>
        <input type="file" class="text-center center-block file-upload" name = "uploadfile" value = "" >
        <input type="submit" value="Upload Image" name="submit">
      </div><br>
          
          
          <ul class="list-group">
            <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Friends Added</strong></span> 125</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Groups Joined</strong></span> 13</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Comments Posted</strong></span> 37</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Payments Made</strong></span> 78</li>
          </ul> 
               
          <div class="panel panel-default">
            <div class="panel-heading">Social Media</div>
            <div class="panel-body">
            	<i class="fa fa-facebook fa-2x"></i> <i class="fa fa-github fa-2x"></i> <i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i> <i class="fa fa-google-plus fa-2x"></i>
            </div>
          </div>
          
        </div><!--/col-3-->
    	<div class="col-sm-9">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
            </ul>

              
          <div class="tab-content">
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