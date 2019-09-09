<?php include "includes/db.php"; ?>
<?php include "includes/admin_header.php"; ?>

<?php include "includes/admin_navigation.php"; ?>


<div id="container1 col-lg-12">
        <div id="left">
              <!-- Page content -->
              <div class="main">
              <br>
              <h1><span class="blue">&lt;</span>Expense<span class="blue">&gt;</span> <span class="yellow">Overview</span></h1>
              <h2><?php echo $_SESSION['name'];?></h2>

              <table id="example" class="display container" cellspacing="0" width="100%">
                <thead>
                  <tr>
                          <th><h1>Serial No.</h1></th>
                    <th><h1>Expense Description</h1></th>
                          <th><h1>Paid By:</h1></th>
                          <th><h1>Amount Paid:</h1></th>
                          <th><h1></h1></th>
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
                  <tbody class="hide">
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
        <div id="right">
              <!-- SIDEBAR -->
              <div class="container">
                
                  <br><br>
                  <label class='alert-heading' value=''>CATEGORY</label><br>
                  <?php $sql = "SELECT * FROM category";
                        $result_sql = mysqli_query($connection,$sql);
                        while($row = mysqli_fetch_assoc($result_sql)){
                            $tags = $row['category'];
                            echo "<label class='alert-heading' value='$tags'><a href='expense_overview.php?value=$tags '>$tags</label><br>";
                        }
                  ?>
              </div>
        </div>
    </div>

<style>
    #container1 {
            border: 1px solid black;
            display: table;
            width: 100%;
        }

        #left {
            display: table-cell;
            vertical-align: top;
            width: 80%;
            float: left;
            margin-right:0;
        }
        #right {
            display: table-cell;
            margin-top: 15%;
            float: right;
            width: 20%;
            background-color: black;
            border-radius: 20px;
            text-emphasis-color: white;
        }


body {
  font-family: Verdana;
  font-weight: 200;
  line-height: 1.42em;
  color:#A7A1AE;
  background-color:#1F2739;
}

h1 {
  font-size:3em; 
  font-weight: 300;
  line-height:1em;
  text-align: center;
  color: #4DC3FA;
}

h2 {
  font-size:1em; 
  font-weight: 300;
  text-align: center;
  display: block;
  line-height:1em;
  padding-bottom: 2em;
  color: #FB667A;
}

h2 a {
  font-weight: 700;
  text-transform: uppercase;
  color: #FB667A;
  text-decoration: none;
}

.blue { color: #185875; }
.yellow { color: #FFF842; }

.container th h1 {
	  font-weight: bold;
	  font-size: 1em;
  text-align: left;
  color: #185875;
}

.container td {
	  font-weight: normal;
	  font-size: 1em;
  -webkit-box-shadow: 0 2px 2px -2px #0E1119;
	   -moz-box-shadow: 0 2px 2px -2px #0E1119;
	        box-shadow: 0 2px 2px -2px #0E1119;
}

.container {
	  text-align: left;
	  overflow: hidden;
	  width: 80%;
	  margin: 0 auto;
  display: table;
  padding: 0 0 8em 0;
}

.container td, .container th {
	  padding-bottom: 2%;
	  padding-top: 2%;
  padding-left:2%;  
}

.container tr:nth-child(odd) {
	  background-color: #323C50;
}

.container tr:nth-child(even) {
	  background-color: #2C3446;
}

.container th {
	  background-color: #1F2739;
}

.container td:first-child { color: #FB667A; }

.labels tr:hover {
   background-color: #464A52;
-webkit-box-shadow: 0 6px 6px -6px #0E1119;
	   -moz-box-shadow: 0 6px 6px -6px #0E1119;
	        box-shadow: 0 6px 6px -6px #0E1119;
}

.labels td:hover {
  background-color: grey;
  color: #403E10;
  font-weight: bold;
  
  transition-delay: 0s;
	  transition-duration: 0.4s;
	  transition-property: all;
  transition-timing-function: line;
}

@media (max-width: 800px) {
.container td:nth-child(4),
.container th:nth-child(4) { display: none; }

.container td:nth-child(5),
.container th:nth-child(5) { display: none; }
}

[data-toggle="toggle"] {
	display: none;
}

</style>
<script>

$(document).ready(function() {
	$('[data-toggle="toggle"]').change(function(){
		$(this).parents().next('.hide').toggle();
	});
});

</script>

<?php include "includes/admin_footer.php"; ?>