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

<!-- QUERY TO SHOW ALL FRIENDS WITH USER -->
                    <?php
                    $limit = 5; //PAGINATION  
                    if (isset($_GET["page"])) {
                        $page  = $_GET["page"]; 
                        } 
                        else{ 
                        $page=1;
                        };  
                    $start_from = ($page-1) * $limit;
                    // Query to get all friends of user
                    $query = "SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user1_id WHERE f.user2_id = {$_SESSION['user_id']} UNION SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user2_id WHERE f.user1_id = {$_SESSION['user_id']} LIMIT $start_from, $limit";
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
            <?php  //PAGINATION
                $result_db = mysqli_query($connection,"SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user1_id WHERE f.user2_id = {$_SESSION['user_id']} UNION SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user2_id WHERE f.user1_id = {$_SESSION['user_id']} "); 
                $row_db = mysqli_fetch_row($result_db);  
                $total_records = $row_db[0];  
                $total_pages = ceil($total_records / $limit); 
                /* echo  $total_pages; */
                $pagLink = "<ul class='pagination'>";  
                for ($i=1; $i<=$total_pages; $i++) {
                            $pagLink .= "<li class='page-item'><a class='page-link' href='friends.php?page=".$i."'>".$i."</a></li>";	
                }
                echo $pagLink . "</ul>";  
            ?>
        </div>
<!-- QUERY TO SHOW EXPENSES DUE WITH THE PARTICULAR FRIEND SELECTED -->
<?php      if(isset($_GET['view'])){   ?>
        <h2 class="mt-4 align-content-center">Friend Expense</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-warning"><!-- Creating Table to Show Expenses Due with particular friend -->
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
            //Query to select particular friend
            $user__name;
            $query = "SELECT * FROM users WHERE user_id = '{$_GET['view']}' ";
            $select_frs = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_frs))
                $user__name             = $row['username'];


            //Query to get Expenses due with selected friend
            $query9 = "SELECT e.group_id,e.group_name,l.amount_due,l.date,l.user_name,l.pay_to,l.liability_id FROM groups e LEFT JOIN liability l ON e.group_id = l.group_id WHERE l.user_name = '$user__name' AND l.status = 'pending' AND l.pay_to = '{$_SESSION['username']}' ";                    
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
                                echo "<td><a href='friends.php?pay=$id'><input type='button' id='myBtn' class='btn btn-primary' name='pay' value='PAY'></a></td>";
                                echo "</tr>";
                            }
        
        ?>
        
        </tbody>
            </table>
        </div>
                        <?php    }    ?>

    </div>
<!-- QUERY TO DELETE THAT FRIEND WITH NO PAYMENTS DUE LEFT -->
    <?php

    if (isset($_GET['delete'])) {
        $the_user_id = ($_GET['delete']);
    $getname = "SELECT username FROM users WHERE user_id = '{$the_user_id}' ";
    $result_getname = mysqli_query($connection,$getname);
    $row_getname = mysqli_fetch_assoc($result_getname);
    $name = $row_getname['username'];
    $query_check = "SELECT * FROM liability WHERE user_name = '{$_SESSION['username']}' AND pay_to = '{$name}' ";
    $result_check = mysqli_query($connection,$query_check);
    $count = mysqli_num_rows($result_check);
        if(!$count){
            //Query to delete friend with no dues
            $query = "DELETE FROM friends WHERE user2_id = {$the_user_id} AND user1_id = {$_SESSION['user_id']} || user1_id = {$the_user_id} AND user2_id = {$_SESSION['user_id']}";
            $delete_user_query = mysqli_query($connection, $query);
            if (!$delete_user_query) {
                die("ERROR!" . mysqli_error($connection));
            }
            header("Location: friends.php");
        }
        else{ 
            $message = "Payments Due";
            echo "<script type='text/javascript'>alert('$message');</script>";//Show message if Payments are due
        }
       
    }

    ?>


<!-- PAYMENT GATEWAY -->
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content Showing that Payment is being Processed-->
  <div class="modal-content col-lg-4">
    <span class="close">&times;</span>
    <div class="wait alert-warning">
            <strong>Wait!</strong> Payment Being Processed.
        </div>
        <script>

            $(document).ready(function(){
                $(".wait").fadeOut(5000);
                <?php sleep(1); ?>
            });
        </script>

    <div class="alert alert-success">
            <strong>Success!</strong> Payment Settled Up.
        </div>
        <script>
            $(document).ready(function(){
                $(".alert").fadeIn(6000);
                <?php sleep(1); ?>
            });
        </script>
  </div>
    
    <?php
        // Query to update liability TABLE and changing payment status
        if (isset($_GET['pay'])) {
            $the_user_id_pay = ($_GET['pay']);
            $query_pay = "UPDATE liability SET status = 'paid' WHERE liability_id = '{$the_user_id_pay}' ";
            $result_query_pay = mysqli_query($connection,$query_pay);
            $num_rows = mysqli_num_rows($result_query_pay);
            if($num_rows){
                $payment = "PAYMENT CONFIRMED!!";
            }
        }
    ?>

</div> 


<script>
    // modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
    modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    } 

</script>
