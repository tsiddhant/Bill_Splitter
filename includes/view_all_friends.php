    <div class="col-lg-8 container">
        <h2 class="mt-4 align-content-center">Friends Section</h2>
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

                    $query = "SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user1_id WHERE f.user2_id = {$_SESSION['user_id']} UNION SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user2_id WHERE f.user1_id = {$_SESSION['user_id']}";
                    $select_friends = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($select_friends)) {
                        $user_id             = $row['user_id'];
                        $username            = $row['username'];
                        $user_name           = $row['name'];
                        $user_number         = $row['number'];
                        $user_email          = $row['email'];

                        echo '<tr scope="row">';
                        echo "<td>$user_id </td>";
                        echo "<td><a href='friends.php?view={$user_id}'>$username</a></td>";
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
<?php      if(isset($_GET['view'])){   ?>
        <h2 class="mt-4 align-content-center">Friend Expense</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-warning">
                <thead>
                    <tr>
                        <th scope="col">Group Name:</th>
                        <th scope="col">Owed To:</th>
                        <th scope="col">Paid by</th>
                        <th scope="col">Amount Due</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody class="table-hover"></tbody>
        <?php
       
                $user__name;
            $query = "SELECT * FROM users WHERE user_id = '{$_GET['view']}' ";
            $select_frs = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_frs))
                $user__name             = $row['username'];



            $query9 = "SELECT e.group_id,e.group_name,l.amount_due,l.date,l.user_name,l.pay_to,l.liability_id FROM groups e LEFT JOIN liability l ON e.group_id = l.group_id WHERE l.user_name = '$user__name' AND l.status = 'pending' AND l.pay_to = '{$_SESSION['username']}' UNION SELECT e.group_id,e.group_name,l.amount_due,l.date,l.user_name,l.pay_to,l.liability_id FROM groups e LEFT JOIN liability l ON e.group_id = l.group_id WHERE l.pay_to = '$user__name' AND l.status = 'pending' AND l.user_name = '{$_SESSION['username']}' ";                    
            $select_expense = mysqli_query($connection, $query9);
                            while ($row = mysqli_fetch_assoc($select_expense)) {
                            
                                $groupname            = $row['group_name'];
                                $id                   = $row['liability_id'];
                                $owed_to                = $row['user_name'];
                                $paid_by                = $row['pay_to'];
                                $amountdue              = $row['amount_due'];
                                $date                   = $row['date'];

                                echo '<tr scope="row">';
                                echo "<td>$groupname </td>";
                                echo "<td>$owed_to</td>";
                                echo "<td>$paid_by</td>";
                                echo "<td>$amountdue</td>";
                                echo "<td>$date</td>";
                                echo "<td><a href='friends.php?pay=$id'><input type='button' class='btn btn-primary' name='pay' value='PAY'></a></td>";
                                echo "</tr>";
                            }
        
        ?>
        
        </tbody>
            </table>
        </div>
                        <?php    }    ?>

    </div>

    <?php

    if (isset($_GET['delete'])) {
        $the_user_id = ($_GET['delete']);

        $query = "DELETE FROM friends WHERE user2_id = {$the_user_id} AND user1_id = {$_SESSION['user_id']}";
        $delete_user_query = mysqli_query($connection, $query);
        if (!$delete_user_query) {
            die("ERROR!" . mysqli_error($connection));
        }
        header("Location: friends.php");
    }

    ?>