<?php include "includes/db.php"; ?>
<?php include "includes/admin_header.php"; ?>

<?php include "includes/admin_navigation.php"; ?>


 
     


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




                    $query = "SELECT users.* FROM groups JOIN friends ON groups.user_id = friends.user1_id JOIN users ON friends.user1_id = users.user_id";
                   
                   
                    $select_members = mysqli_query($connection, $query);

            
                    while ($row = mysqli_fetch_assoc($select_members)) {
                        
                       
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
                        echo "<td><a href='groups.php?delete={$user_id}'>Delete</a></td>";
                        echo "</tr>";

                    }

                
                
                    ?>

                </tbody>
            </table>
        </div>



      








<?php include "includes/admin_footer.php"; ?>