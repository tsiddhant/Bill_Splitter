<?php 
// ADDING MEMBERS INTO YOUR GROUP(ONLY IF THEY ARE YOUR FRIEND)
function add_members($admin_id, $group_id,$connection){

        if($_SESSION['user_id'] == $admin_id){

        if(isset($_POST['add_members'])){
            $friend_username = $_POST['friend'];
            $query = "SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user1_id WHERE f.user2_id = {$_SESSION['user_id']} UNION SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user2_id WHERE f.user1_id = {$_SESSION['user_id']}";
                            $select_friends = mysqli_query($connection, $query);
                            while ($row = mysqli_fetch_assoc($select_friends)) {
                        
                                $username            = $row['username'];
                                if($username == $friend_username){
                                $query2 = "SELECT * FROM groups WHERE group_id = {$group_id} AND members LIKE '%$friend_username%' ";
                                    $result_query2 = mysqli_query($connection,$query2);
                                    $num_row2 = mysqli_num_rows($result_query2);
                                $query21 = "SELECT * FROM groups WHERE group_id = {$group_id} ";
                                    $result_query21 = mysqli_query($connection,$query21);
                                    $row2 = mysqli_fetch_assoc($result_query21);
                                        if(!$num_row2){
                                            $members = $row2['members'];
                                            
                                        $query3 = "UPDATE groups SET members = CONCAT('$members',',','$friend_username') WHERE group_id = {$group_id} ";
                                            $result_query3 = mysqli_query($connection,$query3);
                                            if(!$result_query3){
                                                echo "<script type='text/javascript'>alert('Wrong Input!!');</script>";
                                            }
                                        }
                                        
                                    
                                    if(!$result_query2){
                                        echo "<script type='text/javascript'>alert('Wrong Input!!');</script>";
                                    }
                                }
                            }
                            if(!$select_friends){
                                echo "<script type='text/javascript'>alert('Wrong Input!!');</script>";
                            }
        }

        }

}


// DELETING MEMBERS FROM GROUP(ONLY IF THEY ARE YOUR FRIEND)
function delete_members($admin_id, $group_id, $connection){

    if($_SESSION['user_id'] == $admin_id){

    if(isset($_POST['delete_members'])){
        $friend_username = $_POST['friend'];
    
    $query_dcheck = "SELECT * FROM liability WHERE user_name = '{$friend_username}' AND group_id = {$group_id} AND status = 'pending' ";
    $result_query_dcheck = mysqli_query($connection,$query_dcheck);
    $count_check = mysqli_num_rows($result_query_dcheck);
        if(!$count_check){
    
        $query = "SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user1_id WHERE f.user2_id = {$_SESSION['user_id']} UNION SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user2_id WHERE f.user1_id = {$_SESSION['user_id']}";
                        $select_friends = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_assoc($select_friends)) {
                            $username            = $row['username'];
                            if($username == $friend_username){
                                $query2 = "SELECT * FROM groups WHERE group_id = {$group_id} ";
                                $result_query2 = mysqli_query($connection,$query2);
                                while($row2 = mysqli_fetch_assoc($result_query2)){
                                    if($result_query2){
                                        $members = $row2['members'];
                                        $query3 = "UPDATE groups SET members = REPLACE('$members',',$friend_username','') WHERE group_id = {$group_id} AND members LIKE '%$friend_username%' ";
                                        $result_query3 = mysqli_query($connection,$query3);
                                        if(!$result_query3){
                                            die("ERROR_3 ".mysqli_error($connection));
                                        }
                                    }
                                }
                                if(!$result_query2){
                                    die("ERROR_2 ".mysqli_error($connection));
                                }
                            }
                        }
                        if(!$select_friends){
                            die("ERROR_1 ".mysqli_error($connection));
                        }
        }
    }
    
    }
    
}


//SHOWING ALL MEMBERS IN SELECT DROPDOWN IN GROUPS IF USER IS ADMIN
function show_all_members_admin($connection, $admin_username, $group_id){
    $query = "SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user1_id WHERE f.user2_id = {$_SESSION['user_id']} UNION SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user2_id WHERE f.user1_id = {$_SESSION['user_id']}";
    $result_query = mysqli_query($connection,$query);
    if(!$result_query){
        die("ERROR".mysqli_error($connection));
    }
    while($row = mysqli_fetch_array($result_query)){
        $user_name = $row['username'];
        $query2 = "SELECT * FROM groups WHERE group_id = {$group_id} AND members LIKE '%$user_name%' ";
        $result_query2 = mysqli_query($connection,$query2);
        if(!$result_query2){
            die("ERROR".mysqli_error($connection));
        }
        $row2 = mysqli_fetch_array($result_query2);
        if($row2){
            echo "<option value={$user_name}>{$user_name}</option>";
        }
    }echo "<option value={$admin_username}>{$admin_username}</option>";
}


//SHOW ALL MEMBERS OF GROUP IF USER NOT ADMIN
function show_all_members_non_admin($connection, $admin_username, $group_id, $admin_id){
    $query = "SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user1_id WHERE f.user2_id = {$admin_id} UNION SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user2_id WHERE f.user1_id = {$admin_id}";
    $result_query = mysqli_query($connection,$query);
    if(!$result_query){
        die("ERROR".mysqli_error($connection));
    }
    while($row = mysqli_fetch_array($result_query)){
        $user_name = $row['username'];
            if($user_name != $_SESSION['username']){    
                $query2 = "SELECT * FROM groups WHERE group_id = {$group_id} AND members LIKE '%$user_name%' ";
                $result_query2 = mysqli_query($connection,$query2);
                if(!$result_query2){
                    die("ERROR".mysqli_error($connection));
                }
                $row2 = mysqli_fetch_array($result_query2);
                if($row2){
                    echo "<option value={$user_name}>{$user_name}</option>";
                }
            }
    }
    echo "<option value={$admin_username}>{$admin_username}</option>";
    echo "<option value={$_SESSION['username']}>{$_SESSION['username']}</option>";
}

//CALCULATING SUM AND CHECKING
function calc_sum($money, $sum, $flag2, $net_amount){
    if($_POST['equal'] == "2"){
        foreach($_POST['money_exact'] as $money)
                {
                   if(is_numeric($money)){
                       $sum = $sum + $money;
                   }
                   else{
                       if($flag2 == 0){
                             echo "<script type='text/javascript'>alert('!ENTER NUMERIC VALUES IN EXACT AMOUNT!');</script>";
                         $flag2 = 1;
                       }
                   }       
                }
        if($sum != $net_amount && $flag2 == 0){
            echo "<script type='text/javascript'>alert('!ENTER CORRECT VALUES IN EXACT AMOUNT!');</script>";
        }
    }
}

//MAIN BILL SPLIT CALCULATION PROGRAM
function bill_split($net_amount, $sum, $group_id, $description, $currency, $paid_by, $tag, $connection){
    if(is_numeric($net_amount) && ($sum == $net_amount || $_POST['equal'] == "1" || $_POST['equal'] == "2")){
        if(isset($_POST['equal'])){
            $split_type = $_POST['equal'];
        }
            $main_query = "INSERT INTO expense (group_id, expense_description, total_expense, currency, paid_by, split_type, tags) ";
            $main_query .=  "VALUES ('{$group_id}', '{$description}', {$net_amount}, '{$currency}', '{$paid_by}', '{$split_type}', '{$tag}') ";
            $result_main_query = mysqli_query($connection,$main_query);
            if(!$result_main_query){
                die("ERROR MAIN QUERY ".mysqli_error($connection));
            }

        ///////////////////////////PER PERSON AVERAGE BILL
                $count=0;
            if(isset($_POST['money_exact'])){
                foreach($_POST['money_exact'] as $value){
                $count = $count+1;
                }
            }

            $per_person_price = $net_amount/$count;
        //////////////////////////

        if($_POST['equal'] == "2" && $sum == $net_amount){
        //////////////////////////PER PERSON EXACT BILL
            $a = array();
            foreach($_POST['money_exact'] as $value){
                array_push($a,$value);
            }
        /////////////////////////           
            
                $i =0;

                if(isset($_POST["select"]))
                foreach ($_POST['select'] as $member){
                $flag = 1;
                $merge_query = "SELECT * FROM liability WHERE group_id = {$group_id}";
                $result_merge_query = mysqli_query($connection,$merge_query);
                while($row_merge = mysqli_fetch_assoc($result_merge_query)){
                
                    $person = $row_merge['user_name'];
                    $paidto = $row_merge['pay_to'];
                    $date   = $row_merge['date'];
                    $amountdue = $row_merge['amount_due'];
                    $liabilityid = $row_merge['liability_id'];
                    $t=time();
                    if($person == $member && $paidto == $paid_by && $date == date("Y-m-d",$t)){
                            $flag = 0;
                            $yes =  $a[$i]+$amountdue;
                            $query4 = "UPDATE liability SET ";  
                            $query4 .= "amount_due  = '{$yes}' ";
                            $query4 .= "WHERE liability_id = '{$liabilityid}' ";
                            $result_liability_query = mysqli_query($connection,$query4);
                            
                
                            if(!$result_main_query){
                            die("ERROR LIABILITY QUERY ".mysqli_error($connection));
                            }
                    }
                                    
                } 

            if($flag == 1){
            
                    $liability_query = "INSERT INTO liability (user_name, group_id, pay_to, amount_due) VALUES ('{$member}', '{$group_id}', '{$paid_by}', '{$a[$i]}') ";
                    $result_liability_query = mysqli_query($connection,$liability_query);
                    

                    if(!$result_main_query){
                    die("ERROR LIABILITY QUERY ".mysqli_error($connection));
                    }

                    $i = $i + 1;
                }
            }
            
        }
        else{
        ///////////////PER PERSON EQUAL BILL SPLITTED AND STORED QUERY

            if(isset($_POST["select"]))
            foreach ($_POST['select'] as $member){

        $flag = 1;
        $merge_query = "SELECT * FROM liability WHERE group_id = {$group_id}";
        $result_merge_query = mysqli_query($connection,$merge_query);
        while($row_merge = mysqli_fetch_assoc($result_merge_query)){

        $person = $row_merge['user_name'];
        $paidto = $row_merge['pay_to'];
        $date   = $row_merge['date'];
        $amountdue = $row_merge['amount_due'];
        $liabilityid = $row_merge['liability_id'];
        $t=time();
        if($person == $member && $paidto == $paid_by && $date == date("Y-m-d",$t)){
            $flag = 0;
            $yes =  $per_person_price+$amountdue;
            $query4 = "UPDATE liability SET ";
            $query4 .= "amount_due  = '{$yes}' ";
            $query4 .= "WHERE liability_id = '{$liabilityid}' ";
            $result_liability_query = mysqli_query($connection,$query4);
            

            if(!$result_main_query){
            die("ERROR LIABILITY QUERY ".mysqli_error($connection));
            }
        }
                    
        }            
        if($flag == 1){
            $liability_query = "INSERT INTO liability (user_name, group_id, pay_to, amount_due) VALUES ('{$member}', '{$group_id}', '{$paid_by}', '{$per_person_price}') ";
            $result_liability_query = mysqli_query($connection,$liability_query);
            

            if(!$result_main_query){
            die("ERROR LIABILITY QUERY ".mysqli_error($connection));
            }

        }  
            
            
            }


        }           

                }
}

///////////////////DELETE LIABILITY FIELDS WITH SAME USERNAME AND PAID TO
function del_duplicate($connection){
    $delete_query = "DELETE FROM liability WHERE user_name = '{$_POST['select2']}' AND pay_to = '{$_POST['select2']}' ";
    $result_delete_query = mysqli_query($connection,$delete_query);
    if(!$result_delete_query){
        die("ERROR IN DELETING".mysqli_error($connection));
    }
}


?>