        <div class="table-responsive">
            <table class="table table-bordered table-hover table-warning">
                <thead>
                    <tr>
                        <th scope="col">User Id</th>
                        <th scope="col">Username</th>
                        <th scope="col">name</th>
                        <th scope="col">number</th>
                        <th scope="col">Email</th>
                        <th scope="col">Remove</th>
                    </tr>
                </thead>
                <tbody class="table-hover">

                    <?php

                    $query = "SELECT p.* FROM friendship f JOIN users p ON p.user_id = f.user1_id WHERE f.user2_id = {$_SESSION['user_id']} UNION SELECT p.* FROM friendship f JOIN users p ON p.user_id = f.user2_id WHERE f.user1_id = {$_SESSION['user_id']}";
                    $select_friends = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($select_friends)) {
                        $user_id             = $row['user_id'];
                        $username            = $row['username'];
                        $user_name           = $row['name'];
                        $user_number         = $row['number'];
                        $user_email          = $row['email'];

                        echo '<tr scope="row">';
                        echo "<td>$user_id </td>";
                        echo "<td>$username</td>";
                        echo "<td>$user_name</td>";
                        echo "<td>$user_number</td>";
                        echo "<td>$user_email</td>";
                        echo "<td><a href='friends.php?delete={$user_id}'>Delete</a></td>";
                        echo "</tr>";
                    }

                    ?>

                </tbody>
            </table>
        </div>

        <?php

        if (isset($_GET['delete'])) {
            $the_user_id = ($_GET['delete']);

            $query = "DELETE FROM friendship WHERE user2_id = {$the_user_id} AND user1_id = {$_SESSION['user_id']}";
            $delete_user_query = mysqli_query($connection, $query);
            if (!$delete_user_query) {
                die("ERROR!" . mysqli_error($connection));
            }
            header("Location: friends.php");
        }

        ?>