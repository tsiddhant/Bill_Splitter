<?php include "includes/db.php"; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php
   if (!isset($_SESSION['username'])) {
    header("Location: login.php");
   }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
   ADMIN HOMEPAGE
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <!-- <link href="assets/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" /> -->

  <!-- Sidebar Navigation -->
  <link href="css/simple-sidebar.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

   <!-- GOOGLE CHARTS -->
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body class="">
  <div class="wrapper ">
<?php include "includes/admin_navigation.php"; ?>
<link rel="stylesheet" href="groups_add.css">
<!-- QUERY TO SHOW GROUP NAME AND STATUS -->
<?php
 $query = "SELECT * FROM groups WHERE group_id = {$_GET['source']} ";
 $result = mysqli_query($connection, $query);
 while ($row = mysqli_fetch_assoc($result)) {
     $group_id         = $row['group_id'];
     $group_name       = $row['group_name'];
     $admin_id         = $row['admin_id'];
     $admin_username   = $row['admin_username'];
     $status           = $row['status'];
 }
?>
<div class="row">
<div class="col-lg-12 text-center"><span class="text-center"><h2><u><?php echo $group_name; ?></u></h2></span></div> 
<div class="col-lg-12 text-center"><span class="text-center"><h6>*<?php echo $status ?></h6></span></div>
</div>

<?php 
if($_SESSION['user_id'] == $admin_id){ ?>
    <div class="d-inline">
            <button name="button" class="btn btn-primary" id="0">Add Members</button>
            <br><br>
            <form  id="add" class="col-lg-8" action="" method="post">
                <div class="d-inline-block">
                    <label>*Friends Only</label>
                    <span><input type="text" name="friend" class="form-group" placeholder="Enter Valid Username"></span>
                    <span><button name="add_members" type="submit">ADD</button></span>
                </div>
            </form><br>
    </div>
<?php } ?>

<?php
// ADDING MEMBERS INTO YOUR GROUP(ONLY IF THEY ARE YOUR FRIEND)
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
                                        die("ERROR_3 ".mysqli_error($connection));
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


?>
<?php 
if($_SESSION['user_id'] == $admin_id){ ?>
            <button name="button" class="btn btn-primary" id="-1">Delete Members</button>
            <br><br>
            <form  id="delete" class="col-lg-8" action="" method="post">
                <div class="d-inline-block">
                    <label>*Friends Only</label>
                    <span><input type="text" name="friend" class="form-group" placeholder="Enter Valid Username"></span>
                    <span><button name="delete_members" type="submit">DELETE</button></span>
                </div>
            </form><br>
<?php } ?>

<?php
// DELETING MEMBERS FROM GROUP(ONLY IF THEY ARE YOUR FRIEND)
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


?>
<!-- ADDING NEW EXPENSES FORM IN GROUP -->
<button name="group" class="btn btn-primary" id="1">Add Expense</button>
<br><br>

        <div class="d-inline-block">

            <span><form id="group" class="form-check-inline" action="" method="post" onsubmit="return check();">
           
                <span><div class="jumbotron embed-responsive-1by1" id="new">
                
                        <?php if($_SESSION['user_id'] == $admin_id){ ?>
                            <span class="d-inline"><label class="" for="inlineFormCustomSelect">Members: </label></span>
                            <span class="d-inline"><select name="select[]" size="2" multiple="multiple" class="members" id="members" required>
                                <?php 
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
                                ?>
                            </select></span>
                        
                        <?php } else { ?>
                            
                            <span class="d-inline"><label class="mr-sm-2" for="inlineFormCustomSelect">Members: </label></span>
                            <span class="d-inline"><select name="select[]" size="2" multiple="multiple" class="members" id="members" required>
                                <?php 
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
                                ?>
                            </select></span>

                        <?php } ?>
                        <br><br>


                <div>
                    <i class="fa fa-sticky-note" aria-hidden="true"></i>
                    <span class="d-inline-block"><input type="text" class="form-control" id="inlineFormInput" placeholder="Enter a Description" name="subject_name" value="<?php echo isset($_POST['subject_name']) ? $_POST['subject_name'] : '' ?>"required></span>
                    <span class="d-inline-block">
                        <div class="wrapper">
                        
            <!-- CURRENCY SELECTOR TYPE -->
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon currency-symbol">$</div>
                            <input type="text" class="form-control currency-amount" id="inlineFormInputGroup" placeholder="0.00" size="5" name="money" value="<?php echo isset($_POST['money']) ? $_POST['money'] : '' ?>" required>
                            <div class="input-group-addon currency-addon">

                                <select class="currency-selector" name="currency" required>
                                <option data-symbol="$" data-placeholder="0.00" value="1">USD</option>
                                <option data-symbol="€" data-placeholder="0.00" value="2">EUR</option>
                                <option data-symbol="£" data-placeholder="0.00" value="3">GBP</option>
                                <option data-symbol="¥" data-placeholder="0.00" value="4">JPY</option>
                                <option data-symbol="₹" data-placeholder="0.00"  value="5" selected>INR</option>
                                </select>

                            </div>
                            </div>
                        
                        </div>
                    </span>
                </div>
                <script>
                    function updateSymbol(e){
                    var selected = $(".currency-selector option:selected");
                    $(".currency-symbol").text(selected.data("symbol"))
                    $(".currency-amount").prop("placeholder", selected.data("placeholder"))
                    $('.currency-addon-fixed').text(selected.text())
                    }

                    $(".currency-selector").on("change", updateSymbol)

                    updateSymbol()
                </script>
                <br>
                <br>
                <div>
                    <label for="paid_by">Paid by:</label>
                    <?php if($_SESSION['user_id'] == $admin_id){ ?>
                            <span class="d-inline"><select name="select2" id="inlineFormCustomSelect" required>
                                <?php 
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
                                    }
                                    echo "<option value={$admin_username}>{$admin_username}</option>"
                                ?>
                            </select></span>
                        
                        <?php } else { ?>
                            
                            <span class="d-inline"><select name="select2" size="1" id="inlineFormCustomSelect" required>
                                <?php 
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
                                ?>
                            </select></span>
                        <?php } ?>
                         and Split 
                        </label>
                        <button name="group2" type="button" class="btn btn-primary" id="next">---></button>
                        <br><br><br>
                       <!-- NEW SELECT CATEGORY TAB -->
                        <label>Category:</label>
                        <select name="category" id="category" size="1" required>
                        <option value='OTHERS' selected>OTHERS</option>
                        <?php
                        $sql="SELECT * FROM category "; // Query to collect data
                        $result_sql = mysqli_query($connection,$sql); 
                        while($row = mysqli_fetch_assoc($result_sql)) {
                        echo "<option value=$row[category]>$row[category]</option>";
                        }
                        ?>
                        </select>
                        <!-- END OF SELECT TAB -->
                        <br><br>
                    
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" name="add_expense" value="SUBMIT">
                </div>
           
            </div></span>
            

<!-- FORM 2 SHOWING SPLIT TYPE -->
           
            <span><div class="container" >
                <div class="jumbotron" id="new2">
                    <div>
                        <input type="radio" name="equal" value="1" id="radio1" <?php if (isset($_POST['equal']) && $_POST['equal']=="1") echo "checked";?> required>1.Split Equally
                    </div>    
                        <br>
                    <div>    
                        <input type="radio" name="equal" value="2" id="radio2" <?php if (isset($_POST['equal']) && $_POST['equal']=="2") echo "checked";?> required>2.Split Exact 
                    </div>
                </div>
            </div></span>
            

            

            <span><div class="container" >
                <div class="jumbotron" id="new3">
                    <div>
<!-- SHOWING SELECTED MEMBERS FROM FORM 1 INTO FORM 3 USING JQUERY AND AJAX -->
<script>
    var i;
        $(document).ready(function() {
        $("#members").change(function(){
        my_function();
        });
        ///////////////////////////////

        var my_function = function() {
        var str=new Array();
        $("#members option:selected").each(function() {
        str.push($(this).val());
        });
        // $("#display1").html(str.join(","));
        document.getElementById("js").innerHTML = '';
        for(i=0;i<str.length;i++){
            document.getElementById("js").innerHTML += "&nbsp <input type='checkbox' name='select_group' checked='checked' disabled> "+str[i]+"&nbsp <input type='number' name='money_exact[]'><br>";
            
        }
        }
        });

</script>
<!--  --><div id="js"><h6><b><i>NO OPTION SELECTED</i></b></h3></div>

                </div>
            </div></span>
            


        </form></span>
    </div>
<!-- SCRIPT FUNCTIONS TO SHOW AND HIDE (TOGGLE) FORMS ON BUTTON CLICK -->

<script>   
$(document).ready(function(){
    $("#group").hide();
    $("#group2").hide();
    $("#new2").hide();
    $("#new3").hide();
  $("#1").click(function(){
    $("#group").toggle(200);
    if(!$("#group2").is(":hidden")){
        $("#group2").toggle(200);
    }
    if(!$("#new2").is(":hidden")){
        $("#new2").toggle(200);
    }
    if(!$("#new3").is(":hidden")){
        $("#new3").toggle(200);
    }
  });
});
  
$(document).ready(function(){
  $("#next").click(function(){
    $("#new2").toggle(200);
    $("#new4").hide();
    $("#new3").hide();
  });
});
   
$(document).ready(function(){
    $("#add").hide();
  $("#0").click(function(){
    $("#add").toggle(200);
  });
});

$(document).ready(function(){
    $("#delete").hide();
  $("#-1").click(function(){
    $("#delete").toggle(200);
  });
});

$(document).ready(function(){
    $("#new3").hide();
  $("#radio2").click(function(){
    $("#new3").show();
  });
});

$(document).ready(function(){
  $("#radio1").click(function(){
    $("#new3").hide();
  });
});

function check(){
    var number = document.getElementsByName('money')[0].value;
    if(isNaN(number)){
        alert("INSERT A NUMBER IN NET AMOUNT!!");
        return false;
    }
    var length = document.getElementsByName('subject_name')[0].value;
    if(length.length < 5){
        alert("DESCRIPTION SHOULD BE MINIMUM 5 LENGTH!!");
        return false;
    }
    else{
        return true;
    }
}

</script>



<?php include "includes/admin_footer.php"; ?>


<?php 
      
    // Check if form is submitted successfully 
    if(isset($_POST["add_expense"]))  
    { 

        $description = $_POST['subject_name'];
        $net_amount = $_POST['money'];
        $currency = $_POST['currency'];
        $paid_by = $_POST['select2'];
        $tag    = $_POST['category'];

//////////////////////////CALCULATING SUM AND CHECKING
$money=0; 
$sum=0;
$flag2=0;
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
//////////////////////////
            if(is_numeric($net_amount) && ($sum == $net_amount || $_POST['equal'] == "1")){
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
?> 
<?php


if(isset($_POST["add_expense"]))  {
///////////////////DELETE LIABILITY FIELDS WITH SAME USERNAME AND PAID TO
        $delete_query = "DELETE FROM liability WHERE user_name = '{$_POST['select2']}' AND pay_to = '{$_POST['select2']}' ";
        $result_delete_query = mysqli_query($connection,$delete_query);
        if(!$result_delete_query){
            die("ERROR IN DELETING".mysqli_error($connection));
        }
///////////////////

    }
?>
