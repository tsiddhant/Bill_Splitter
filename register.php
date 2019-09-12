<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>
<?php include "includes/db.php"; ?>

<?php
$username = $name = $number = $email = $password = "";
$usernameErr = $nameErr = $numberErr = $emailErr = $passwordErr = "";

if (isset($_POST['user_submit'])) {

    $username = test_input($_POST['username']);
        if (strlen($username) < 4) {
            $usernameErr = "USER Name is Required!!(min 4 length)";
        } else {
            $query = "SELECT * FROM users";
            $result_query = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($result_query)) {
                if ($username == $row['username']) {
                    $usernameErr = "Username Already Exists!!";
                    break;
                }
            }
        }

    $name = test_input($_POST['name']);
        if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $nameErr = "Only letters and whitespace allowed!!";
        }

    $number = $_POST['number'];
        if (preg_match('/^\d{10}$/', $number)) {
            $numberErr = "";
        } else {
            $numberErr = "Phone number invalid !";
        }

    $email = $_POST['email'];

    $password = $_POST['password'];
    if (strlen($password) < 4) {
        $passwordErr = "Password is Required!!(min 4 length)";
    }
    $password = password_hash($password, PASSWORD_DEFAULT);

    $username = $_POST['username'];
    $username = mysqli_real_escape_string($connection, $username);
    $name = mysqli_real_escape_string($connection, $name); 

    if (empty($nameErr) && empty($numberErr) && empty($usernameErr) && !empty($email) && !empty($password)) {
        $query = "INSERT INTO users (`username`, `name`, `number`, `email`, `password`) ";
        $query .= "VALUES ('{$username}', '{$name}', '{$number}', '{$email}', '{$password}') ";
        $result_query = mysqli_query($connection, $query);

        if (!$result_query) {
            die("USER NOT REGISTERED!!" . mysqli_error($connection));
        }

        $message = "USER REGISTERED";
        echo "<script type='text/javascript'>alert('$message');</script>";
        // header("Location: login.php");
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>



    <div class="container table-bordered ">
        <h1 style="margin-left:13%;">REGISTER NEW USER</h1>
        <hr>

        <div>
            <form action="register.php" method="post">
                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Username" required>
                    </div>
                    <?php echo $usernameErr ?>
                </div>
                <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Name" required>
                    </div>
                    <?php echo $nameErr ?>
                </div>
                <div class="form-group row">
                    <label for="inputNumber" class="col-sm-2 col-form-label">Mobile no.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputNumber" name="number" placeholder="Mobile no." required>
                    </div>
                    <?php echo $numberErr ?>
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" required>
                    </div>
                    <?php echo $emailErr ?>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password" required>
                    </div>
                    <?php echo $passwordErr ?>
                </div>
                <div class="form-group row">
                    <div class="" style="margin-left:13%;">
                        <input type="submit" name="user_submit" class="btn btn-primary" value="Register">
                    </div>
                </div>
            </form>
        </div>
    </div>



<style>
    .container { 
        background: teal;
        color: white;
      margin:auto;
      width: 500px; 
      padding-top: 70px;
    }
    form {
        background: teal;
        color: white;
        margin:auto;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px; 
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 10px;
    }
    .btn {
        margin: auto 125px;
        border-style: outset;
    }
    body {
    
	font-family: roboto;
}
</style>

<?php include "includes/footer.php"; ?>