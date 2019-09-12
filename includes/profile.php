<?php
// SHOW USER DATA
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

  if(isset($_POST["submit"]))
 {   
// DELETE PREVIOUS PHOTO
    if(file_exists($picsource)){
        unlink($picsource);
    }

// UPLOAD NEW PHOTO
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "uploaded_images/".$filename;
    move_uploaded_file($tempname,$folder);
    $query = "UPDATE users SET picsource = '{$folder}' WHERE user_id = '{$_SESSION['user_id']}' ";
    $result_query = mysqli_query($connection,$query);
    header("Location: profile.php");
 }
?>
    <div class="" style="">
  		<div><h1>PROFILE</h1></div>
    </div>
<hr>
<div class="container col-lg-3" style="margin-right:70%;">

<div class=" float-lg-left">
              

      <div class="text-center">

        <img src="<?php  echo $picsource; ?>" class="avatar img-circle img-thumbnail" alt="No image!" style="border-radius:150px;">
    
        <form action="" method="post" enctype="multipart/form-data">
        <input type="file" class="text-center center-block file-upload" name = "uploadfile" value = "" required>
        <button type="submit" value="Upload Image" name="submit">Upload Image</button>
        </form>
      </div><br>
          
</div> 
</div> 
<div class="container">
        <div class="row">
          <div class="col-lg-10">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                 
                  <div class="col-md-12">
                    
                        <form action="" method="post">

                        <div class="form-group">
                            <label for="post_username">Name</label>
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

                        </form>
                    
                  </div>
                </div>
              </div>
             
            </div>
          </div>
        </div>
</div>


<!-- Javascript to load file on browsing  -->
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