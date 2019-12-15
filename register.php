<?php include "includes/db.php"; ?><!-- Including Database Connection File -->
<?php include "includes/header.php"; ?><!-- Including Header File -->
<?php include "includes/navigation.php"; ?><!-- Including Navigation File -->
<link rel="stylesheet" href="register.css"><!-- Including CSS File -->

<!-- NEW USER VALIDATION -->
<?php
$username = $name = $number = $email = $password = "";
// Variables for Showing Errors
$usernameErr = $nameErr = $numberErr = $emailErr = $passwordErr = "";
// Validating USer registration Details
if (isset($_POST['user_submit'])) {
//Validating Username
    $username = test_input($_POST['username']);
        if (strlen($username) < 4) {
            $usernameErr = "USER Name is Required!!(min 4 length)";//Checking Username Length
        } else {
            $query = "SELECT * FROM users";//QUERY to check if USERNAME already Exists or Not
            $result_query = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($result_query)) {
                if ($username == $row['username']) {
                    $usernameErr = "Username Already Exists!!";//Showing Username Error if Exists
                    break;
                }
            }
        }
// Validating Name
    $name = test_input($_POST['name']);
        if (!preg_match("/^[a-zA-Z ]+$/", $name)) {//Checking if Name is Valid Name
        $nameErr = "Only letters and whitespace allowed!!";//Showing Name Error if Exists
        }
//Validating Number
    $number = $_POST['number'];
        if (preg_match('/^\d{10}$/', $number)) {//Checking if Number is a valid 10 digit number
            $numberErr = "";
        } else {
            $numberErr = "Phone number invalid !";//Showing Number Error if Exists
        }

    $email = $_POST['email'];
//Validating Password
    $password = $_POST['password'];
    if (strlen($password) < 4) {//Checking Password Length
        $passwordErr = "Password is Required!!(min 4 length)";
    }
    $password = password_hash($password, PASSWORD_DEFAULT);//PASSWORD HASHING FOR SECURITY

    $username = $_POST['username'];
    $username = mysqli_real_escape_string($connection, $username);//PREVENTING SQL INJECTION
    $name = mysqli_real_escape_string($connection, $name); //PREVENTING SQL INJECTION
//Query to insert data into USERS table
    if (empty($nameErr) && empty($numberErr) && empty($usernameErr) && !empty($email) && !empty($password)) {
        $query = "INSERT INTO users (`username`, `name`, `number`, `email`, `password`) ";
        $query .= "VALUES ('{$username}', '{$name}', '{$number}', '{$email}', '{$password}') ";
        $result_query = mysqli_query($connection, $query);

        if (!$result_query) {
            die("USER NOT REGISTERED!!" . mysqli_error($connection));
        }

        $message = "USER REGISTERED";
        echo "<script type='text/javascript'>alert('$message');</script>";//Showing Successful Registration Message
        // header("Location: login.php");
    }
}
//JS to Trim Input By User for Security
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>


<!-- NEW USER REGISTRATION FORM -->
    <div class="container table-bordered ">
        <h1 style="margin-left:13%;">REGISTER NEW USER</h1>
        <hr>

        <div>
            <form action="register.php" method="post"><!-- Registration Form -->
                <div class="form-group row"><!-- Username -->
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Username" required>
                    </div>
                    <?php echo $usernameErr ?>
                </div>
                <div class="form-group row"><!-- Name -->
                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Name" required>
                    </div>
                    <?php echo $nameErr ?>
                </div>
                <div class="form-group row"><!-- Number -->
                    <label for="inputNumber" class="col-sm-2 col-form-label">Mobile no.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputNumber" name="number" placeholder="Mobile no." required>
                    </div>
                    <?php echo $numberErr ?>
                </div>
                <div class="form-group row"><!-- Email -->
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" required>
                    </div>
                    <?php echo $emailErr ?>
                </div>
                <div class="form-group row"><!-- Password -->
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password" required>
                    </div>
                    <?php echo $passwordErr ?>
                </div>
                <div class="form-group row"><!-- Submit Button -->
                    <div class="" style="margin-left:13%;">
                        <input type="submit" name="user_submit" class="btn btn-primary" value="Register">
                    </div>
                </div>
            </form><!-- End of Form -->
        </div>
    </div><!-- End of Container -->

<?php include "includes/footer.php"; ?><!-- Including Footer File -->