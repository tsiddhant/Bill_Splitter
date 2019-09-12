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
  <link href="assets/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" />

  <!-- Sidebar Navigation -->
  <link href="css/simple-sidebar.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

   <!-- GOOGLE CHARTS -->
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body class="">
  <div class="wrapper ">
    
  <?php include "includes/admin_navigation.php"; ?>
<link rel="stylesheet" href="expense_overview.css">


<div id="container1 col-lg-12">
        <div id="left">
              <!-- Page content -->
              <div class="main">
              <br>
              <h1><span class="blue">&lt;</span>Expense<span class="blue">&gt;</span> <span class="yellow">Overview</span></h1>
              <h2><?php echo $_SESSION['name'];?></h2><h2><?php  if(isset($_GET['value'])) echo $_GET['value']; ?></h2>
<!-- AJAX SEARCH -->
            <div class="col-lg-4">
              
                <div class="card-body ">
                  <div class="row">
                    <div class="col-md-12">
                    <input type="text" oninput = "pass_data()" name="expense_description" id="expense_description" placeholder="Search by Description name" class="btn btn-primary" style="margin-left:25%;" >
                    </div>
                  </div>
                </div>
              
            </div>
   
    
    
<!-- END -->
              
              <table id="example" class="display container" cellspacing="0" width="100%">
                <thead id="head">
                  <tr>
                          <th><h1>Serial No.</h1></th>
                    <th><h1>Expense Description</h1></th>
                          <th><h1>Amount Paid:</h1></th>
                          <th><h1>Paid By:</h1></th>
                  </tr>
                  </thead>
              <tbody>

              <?php
              $query = "SELECT * FROM groups WHERE members LIKE '%{$_SESSION['user_id']}%' OR admin_username = '{$_SESSION['username']}' ORDER BY date DESC";
              $result = mysqli_query($connection, $query);
              while ($row = mysqli_fetch_assoc($result)) {
                  $group_id         = $row['group_id'];
                  $group_name       = $row['group_name'];
                  $admin_id         = $row['admin_id'];
                  $admin_username   = $row['admin_username'];
                  $date             = $row['date'];
              ?>
                  <tbody class="labels">
                    <tr>
                      <td colspan="5">
                        <label for=<?php  echo $group_name; ?> ><h1><?php  echo "+$group_name"; ?></h1></label><br><label><h6><?php  echo "$admin_username &nbsp&nbsp Created on:$date"; ?></h6></label>
                        <input type="checkbox" name="<?php  echo $group_name; ?>" id=<?php  echo $group_name; ?> data-toggle="toggle">
                      </td>
                    </tr>
                  </tbody>
                  <tbody class="hide" style="display:none;">
              <?php
                              if(isset($_GET['value'])){
                                $tags = $_GET['value'];
                                  $query_1 = "SELECT * FROM expense WHERE group_id = '{$group_id}' AND tags = '{$tags}' ORDER BY date ASC";
                                  $result_1 = mysqli_query($connection, $query_1);
                                  $i = 1;
                                  while ($row_1 = mysqli_fetch_assoc($result_1)) {
                                      $expense_desc_1     = $row_1['expense_description'];
                                      $total_1            = $row_1['total_expense'];
                                      $paidby_1           = $row_1['paid_by'];
                                      $date_1             = $row_1['date'];
                                      echo "<tr><td colspan='4'>$date_1</td></tr>";
                                      echo "<tr>";
                                      echo "<td><h4>$i.</h4></td>";
                                      echo "<td><h4>$expense_desc_1</h4></td>";
                                      echo "<td><h4><i class='fa fa-money' aria-hidden='true'>$total_1</i></h4></td>";
                                      echo "<td><h4>$paidby_1</h4></td>";
                                      echo "</tr>";
                                      $i++;
                                  }
                              }
                              else{
                                  $query_1 = "SELECT * FROM expense WHERE group_id = $group_id ORDER BY date ASC";
                                  $result_1 = mysqli_query($connection, $query_1);
                                  $i = 1;
                                  while ($row_1 = mysqli_fetch_assoc($result_1)) {
                                      $expense_desc_1     = $row_1['expense_description'];
                                      $total_1            = $row_1['total_expense'];
                                      $paidby_1           = $row_1['paid_by'];
                                      $date_1             = $row_1['date'];
                                      echo "<tr><td colspan='4'>$date_1</td></tr>";
                                      echo "<tr>";
                                      echo "<td><h4>$i.</h4></td>";
                                      echo "<td><h4>$expense_desc_1</h4></td>";
                                      echo "<td><h4><i class='fa fa-money' aria-hidden='true'>$total_1</i></h4></td>";
                                      echo "<td><h4>$paidby_1</h4></td>";
                                      echo "</tr>";
                                      $i++;
                                  }
                              }
              ?>
                  </tbody>
                  
                  <?php    }  ?>
              </tbody>
              </table>
              </div>
        </div>
        <div id="right"  style="background-color:white">
              <!-- SIDEBAR -->
             
                

            <div class="col-lg-12">
              <div class="card card-stats">
                <div class="card-body ">
                  <div class="row">
                    <div class="col-md-12">
                          <label class='alert-heading' value=''><h3><u>TAGS</u></h3></label><br>
                          <?php $sql = "SELECT * FROM category";
                                $result_sql = mysqli_query($connection,$sql);
                              
                                while($row = mysqli_fetch_assoc($result_sql)){
                                    $tags = $row['category'];
                                    echo "<label class='alert-heading' value='$tags'><a href='expense_overview.php?value=$tags'>&nbsp$tags</a></label><br><br>";
                                
                                }
                          ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

                  
            
    </div>


<?php include "includes/admin_footer.php"; ?>

<script>

$(document).ready(function() {
	$('[data-toggle="toggle"]').change(function(){
		$(this).parents().next('.hide').toggle();
	});
});

</script>
<script>
 function pass_data(){

    var expense_description = document.getElementById('expense_description').value;  
	load_data(expense_description); 
 } 
 
 function load_data(expense_description)
 {
  
  $.ajax({
   type:"GET",	  
   url:"find_expense.php",
   data:{expense_description:expense_description},
   success:function(data)
   {
    $('#example').html(data);
   }
  });
 }

</script>