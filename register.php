<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>
<?php include "includes/db.php"; ?>

<?php
$username = $name = $number = $email = $password = "";
$usernameErr = $nameErr = $numberErr = $emailErr = $passwordErr = "";

if (isset($_POST['user_submit'])) {

    $username = $_POST['username'];
    if (empty($_POST['username']) || strlen($username) < 4) {
        $usernameErr = "USER Name is Required!!(min 4 length)";
    } else {
        $username = test_input($_POST['username']);
        $query = "SELECT * FROM users";
        $result_query = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($result_query)) {
            if ($username == $row['username']) {
                $usernameErr = "Username Already Exists!!";
                break;
            }
        }
    }

    if (empty($_POST['name'])) {
        $nameErr = "Name is Required!!";
    } else {
        $name = test_input($_POST['name']);
        if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
            $nameErr = "Only letters and whitespace allowed!!";
        }
    }

    $number = $_POST['number'];
    if (!empty($number)) {
        if (preg_match('/^\d{10}$/', $number)) {
            $numberErr = "";
        } else {
            $numberErr = "Phone number invalid !";
        }
    } else {
        $numberErr = "You must provide a phone number !";
    }

    $email = $_POST['email'];
    if (empty($_POST['email'])) {
        $emailErr = "Email is Required!!";
    }

    $password = $_POST['password'];
    if (empty($_POST['password']) || strlen($password) < 4) {
        $passwordErr = "Password is Required!!(min 4 length)";
    }

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


<div class="container col-lg-offset-3">
    <div class="container col-sm-7 table-bordered ">
        <h1>REGISTER NEW USER</h1>
        <hr>

        <div>
            <form action="register.php" method="post">
                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Username">
                    </div>
                    <?php echo $usernameErr ?>
                </div>
                <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Name">
                    </div>
                    <?php echo $nameErr ?>
                </div>
                <div class="form-group row">
                    <label for="inputNumber" class="col-sm-2 col-form-label">Mobile no.</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputNumber" name="number" placeholder="Mobile no.">
                    </div>
                    <?php echo $numberErr ?>
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
                    </div>
                    <?php echo $emailErr ?>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                    </div>
                    <?php echo $passwordErr ?>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 offset-sm-2">
                        <input type="submit" name="user_submit" class="btn btn-primary" value="Register">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>