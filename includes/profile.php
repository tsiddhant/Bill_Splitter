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
$message='';
//  IMAGE VALIDATION
  if(isset($_POST["submit"]))
 {   
// UPLOAD NEW PHOTO
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];

        // Get Image Dimension
        $fileinfo = @getimagesize($tempname);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        
        $allowed_image_extension = array(
            "png",
            "jpg",
            "jpeg"
        );
        
        // Get image file extension
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        
        // Validate file input to check if is not empty
        if (! file_exists($tempname)) {
            $message = "Choose image file to upload.";
        }    // Validate file input to check if is with valid extension
        else if (! in_array($file_extension, $allowed_image_extension)) {
            $message = "Upload valiid images. Only PNG and JPEG are allowed.";
        }    // Validate image file size
        else if (($_FILES["uploadfile"]["size"] > 2000000)) {
            $message = "Image size exceeds 2MB";
        }    // Validate image file dimension
        else if ($width > "300" || $height > "200") {
            $message = "Image dimension should be within 300X200";
        } else {
            if(empty($response)){
                // DELETE PREVIOUS PHOTO
                if(file_exists($picsource)){
                    unlink($picsource);
                }
            }
            
            //INSERT NEW PHOTO
            $folder = "uploaded_images/".$filename;
            if (move_uploaded_file($tempname, $folder)) {
                $message = "Image uploaded successfully.(Reload to view it!!)";
                // Query to update new image in database
                $query = "UPDATE users SET picsource = '{$folder}' WHERE user_id = '{$_SESSION['user_id']}' ";
                $result_query = mysqli_query($connection,$query);
            } else {
                $message = "Problem in uploading image files.";
            }
        }
 }
?>
    <div class="" style="">
  		<div><h1><center>PROFILE</center></h1></div><!-- Header -->
    </div>
<hr>
<div class="container col-lg-3" style="margin-right:70%;">

<div class=" float-lg-left">
              

      <div class="text-center">
<!-- Showing Profile Image Of User -->
        <img src="<?php  echo $picsource; ?>" class="avatar img-circle img-thumbnail" alt="No image!" style="border-radius:150px;">
<!-- Form to Change User Profile Image -->
        <form action="" method="post" enctype="multipart/form-data"><!-- Creating form -->
        <input type="file" class="text-center center-block file-upload" name = "uploadfile" value = "" required><!-- Browse File -->
        <button type="submit" value="Upload Image" name="submit">Upload Image</button><!-- Form Submit Button -->
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
                    
                        <form action="" method="post"><!-- Profile Form -->

                        <div class="form-group"><!-- Name -->
                            <label for="post_username">Name</label>
                            <input type="text" value="<?php echo $user_name; ?>" class="form-control" name="user_name" disabled>
                        </div>

                        <div class="form-group"><!-- Username -->
                            <label for="post_username">Username</label>
                            <input type="text" value="<?php echo $username; ?>" class="form-control" name="username" disabled>
                        </div>

                        <div class="form-group"><!-- Number -->
                            <label for="post_number">Number</label>
                            <input type="text" value="<?php echo $user_number; ?>" class="form-control" name="user_number" disabled>
                        </div>

                        <div class="form-group"><!-- Email -->
                            <label for="post_email">Email</label>
                            <input type="email" value="<?php echo $user_email; ?>" class="form-control" name="user_email" disabled>
                        </div>
                        <div class="form-group">
                            <!--  -->
                            <?php //if($message!=''){ ?>
                            <div class="alert alert-success">
                                <strong><?php echo $message; ?></strong>
                            </div>
                            <script>
                                $(document).ready(function(){
                                    $(".alert").fadeOut(5000);
                                });
                            </script>
                            <?php //} ?>
                            <!--  -->
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