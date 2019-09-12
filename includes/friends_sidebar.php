<div class="position-relative">
    <div class="col-lg-3 d-flex ">
        <div class="bg-light" id="sidebar-wrapper">
            <div class="list-group list-group-flush">


                <div class="container">
                    <br><br>

                    <br><br>
<!-- SHOWING ALL FRIEND REQUESTS FOR THE USER -->
                    <div class="well form-group">
                        <h5>FRIEND REQUESTS
                            <hr>
                        </h5>
                        <div class="form-group">
                            <table class="table-borderless table-responsive">
                                <?php
                                $query = "SELECT * FROM friend_request WHERE status = 'pending' AND user2_id = {$_SESSION['user_id']} ";
                                $result_query = mysqli_query($connection, $query);
                                while ($row = mysqli_fetch_assoc($result_query)) {
                                    $friend = $row['user1_id'];
                                    $query2 = "SELECT * FROM users WHERE user_id = {$friend}";
                                    $result_query2 = mysqli_query($connection, $query2);
                                    while ($row2 = mysqli_fetch_assoc($result_query2)) {
                                        $id = $row2['user_id'];
                                        $name = $row2['name'];
                                        $user_name = $row2['username'];
                                        echo "<tr><td colspan='3'>{$name}</td></tr>";
                                        echo "<tr><td>{$user_name}</td>";
                                        echo "<td><a href='friends.php?reject={$id}' class='col-sm-6'>Reject</a></td>";
                                        echo "<td><a href='friends.php?accept={$id}' class='col-sm-6'>Accept</a></td></tr><tr><td colspan='3'>----------------------------------</td></tr>"
                                        ?>
                                <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>

                    <br><br>

<!-- QUERY FOR SENDING FRIEND REQUESTS TO VALID USERNAMES -->
                    <?php
                    $usernameErr = '';
                    if (isset($_POST['request_friend'])) {

                        $friend_id = $_POST['username'];
                        $query = "SELECT * FROM users";
                        $result_query = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_assoc($result_query)) {
                            if ($friend_id == $_SESSION['username']) {
                                $usernameErr = '';
                            } else if ($friend_id == $row['username']) {
                                $usernameErr = "Username Exists!!";
                            }
                        }
                        
                            $query = "SELECT * FROM users WHERE username = '{$friend_id}' ";
                            $select_user_profile_query = mysqli_query($connection, $query);
                            while ($row = mysqli_fetch_array($select_user_profile_query)) {
                                $user_id = $row['user_id'];
                                $username = $row['username'];
                                $user_name = $row['name'];
                                $user_email = $row['email'];
                                $user_number = $row['number'];
                            }


                        $query2 = "SELECT * FROM friends WHERE user1_id = {$_SESSION['user_id']} OR user2_id = {$_SESSION['user_id']} ";
                        $result_query2 = mysqli_query($connection, $query2);
                        while ($row = mysqli_fetch_assoc($result_query2)) {
                            if ($user_id == $row['user1_id'] || $user_id == $row['user2_id']) {
                                $usernameErr = "";
                                echo "<script>
                                    alert('Already Friend!');
                                    </script>";
                            }
                        }

                        $query3 = "SELECT * FROM friend_request WHERE user1_id = {$_SESSION['user_id']} OR user2_id = {$_SESSION['user_id']} ";
                        $result_query3 = mysqli_query($connection, $query3);
                        while ($row = mysqli_fetch_assoc($result_query3)) {
                            if ($user_id == $row['user1_id'] || $user_id == $row['user2_id']) {
                                $usernameErr = "";
                                echo "<script>
                                    alert('Already Requested!');
                                    </script>";
                            }
                        }

// SENDING MAIL FOR FRIEND REQUEST
                        if (!empty($usernameErr)) {

                            $text = "You have received a new friend request from $username. Login now to accept it.";
                            $subject = "Bill_Splitter : New Friend Request";
                            $mail_status = sendmail($_SESSION['email'], $username, $subject, $text);
                            if($mail_status){
                                $query = "INSERT INTO friend_request (`user1_id`, `user2_id`, `status`) ";
                                $query .= "VALUES ('{$_SESSION['user_id']}', '{$user_id}', 'pending') ";
                                $result_query = mysqli_query($connection, $query);
                            }

                            if (!$result_query) {
                                die("ERROR IN SENDING MAIL!!" . mysqli_error($connection));
                            }
                        header("Location: friends.php");
                        }
                        
                    }

                    ?>


                    <div class="well form-group">
                        <form action="" method="post">
                            <h5 class="">Send REQUESTS
                                <hr>
                            </h5>

                            <div class="form-group">
                                <input type="text" placeholder="Enter Username" class="form-control" name="username" required>
                                <?php echo $usernameErr; ?>
                            </div>
                            <span>
                                <div class="form-group col-sm-12">
                                    <input class="btn btn-primary btn-block" type="submit" name="request_friend" value="SEND">
                                </div>
                            </span>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- QUERY TO ACCEPT AND REJECT FRIEND REQUESTS -->
<?php
if (isset($_GET['accept'])) {
    $user_id = $_GET['accept'];
    $query = "INSERT INTO friends(`user1_id`, `user2_id`, `date`) VALUES ({$user_id},{$_SESSION['user_id']},now())";
    $result_query = mysqli_query($connection, $query);
    if (!$result_query) {
        die("ERROR IN ADDING FRIEND " . mysqli_error($connection));
    }
    if ($result_query) {
        $query2 = "DELETE FROM friend_request WHERE user1_id = $user_id";
        $result_query2 = mysqli_query($connection, $query2);
        if (!$result_query2) {
            die("ERROR IN ACCEPTING REQUEST " . mysqli_error($connection));
        }
    }
    header("Location: friends.php");
}
?>
<?php
if (isset($_GET['reject'])) {
    $user_id = $_GET['reject'];
        $query = "DELETE FROM friend_request WHERE user1_id = $user_id";
        $result_query = mysqli_query($connection, $query);
        if (!$result_query) {
            die("ERROR IN DELETING REQUEST " . mysqli_error($connection));
        }
    header("Location: friends.php");
}
?>