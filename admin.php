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
 

      <div class="content">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-globe text-warning"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Groups Joined</p>
                      <?php
                             $query4 = "SELECT * FROM groups WHERE admin_username = '{$_SESSION['username']}' OR members LIKE '%{$_SESSION['username']}%' ";
                             $select_groups = mysqli_query($connection, $query4);
                             $groups_count = mysqli_num_rows($select_groups);
                      ?>
                      <p class="card-title"><?php echo $groups_count; ?>
                        <p><br>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-money-coins text-success"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Expenses:<?php echo date('Y'); ?></p>
                      <?php   
                             $query3 = "SELECT SUM(total_expense) AS sum FROM expense WHERE paid_by = '{$_SESSION['username']}' AND DATE_FORMAT(date, '%Y') = date('Y') ";
                             $select_expenses = mysqli_query($connection, $query3);
                             $expenses_count = mysqli_fetch_assoc($select_expenses);
                      ?>
                      <p class="card-title"><?php echo $expenses_count['sum']; ?>
                        <p><br>
                    </div>
                  </div>
                </div>
              </div>
             
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-vector text-danger"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Comments</p>
                      <?php
                            $query2 = "SELECT * FROM comments WHERE comment_author = '{$_SESSION['name']}' ";
                            $select_comments = mysqli_query($connection, $query2);
                            $comments_count = mysqli_num_rows($select_comments);
                      ?>
                      <p class="card-title"><?php echo $comments_count; ?>
                        <p><br>
                    </div>
                  </div>
                </div>
              </div>
            
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-favourite-28 text-primary"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Friends</p>
                      <?php
                               $query = "SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user1_id WHERE f.user2_id = {$_SESSION['user_id']} UNION SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user2_id WHERE f.user1_id = {$_SESSION['user_id']}";
                               $select_friends = mysqli_query($connection, $query);
                               $friends_count = mysqli_num_rows($select_friends);
                      ?>
                      <p class="card-title"><?php  echo $friends_count; ?>
                        <p><br>
                    </div>
                  </div>
                </div>
              </div>
             
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 embed-responsive">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">Net Expenses Trends(Monthly)</h5>
              </div>
              <div class="card-body embed-responsive table-responsive">
              <div id="curve_chart" style="width: 1200px; height: 400px;"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4" style="margin-left:30px; margin-right:50px;">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">Expenditure-Category Based</h5>
              </div>
              <div class="card-body">
                  <div class="row" style="margin:auto;">
                  <form action="#" method="post">
                        <select name="select1"> 
                            <option value="2019" <?php if(isset($_POST['select1']) && $_POST['select1'] == "2019") echo 'selected="selected"';?> >2019</option> 
                            <option value="2018" <?php if(isset($_POST['select1']) && $_POST['select1'] == "2018") echo 'selected="selected"';?>>2018</option> 
                            <option value="2017" <?php if(isset($_POST['select1']) && $_POST['select1'] == "2017") echo 'selected="selected"';?>>2017</option> 
                        </select>
                        <button type="submit"> 
                            Ok 
                        </button>
                  </form>
                  </div> 
              <div id="piechart" style="width: 500px; height: 300px;"></div>
              </div>
              <div class="card-footer ">
                <div class="legend">
                  <i class="fa fa-circle text-primary"></i> Category
                  <i class="fa fa-circle text-warning"></i> Expense
                </div>
                <div class="card-footer">
                <hr>
                <div class="stats">
                  <i class="fa fa-calendar"></i> Amount of money spent
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-title">Net Expenses Trends(Yearly)</h5>
              </div>
              <div class="card-body embed-responsive">
              <div id="columnchart_material" ></div>
              </div>
              <div class="card-footer">
                <hr>
                <div class="stats">
                  <i class="fa fa-calendar"></i> Amount of money
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>

  <script src="assets/js/plugins/chartjs.min.js"></script>
  <script src="assets/js/plugins/bootstrap-notify.js"></script>

  <script>
    $(document).ready(function() {
      demo.initChartsPages();
    });
  </script>
  <?php include "includes/admin_footer.php"; ?>


  <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Category', 'Net Expense'],
          <?php  
              if(isset($_POST['select1'])){
                $year_choose = $_POST['select1'];
              }
              else{
                $year_choose = 2019;
              }
              
              $query2 = "SELECT SUM(total_expense) AS Sum, tags FROM expense WHERE paid_by = '{$_SESSION['username']}' AND DATE_FORMAT(date, '%Y') = '{$year_choose}' GROUP BY DATE_FORMAT(date, '%Y'),tags ORDER BY DATE_FORMAT(date, '%Y') ASC ";       
              $result_query_sum2 = mysqli_query($connection,$query2);
              while($row2 = mysqli_fetch_assoc($result_query_sum2)){
                   $tags  = $row2['tags'];
                   $sum   = $row2['Sum'];
                   echo "['{$tags}',{$sum}],";
              }
          ?>
        ]);

        var options = {
          legend: { position: 'none' },
          'width': 300,
          'height': 300,

          'chartArea': {'width': '80%', 'height': '80%'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

    <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart','bar']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Year', 'Paid', 'Owed'],
              <?php $max2=0;
        
               $query3 = "SELECT DATE_FORMAT(date, '%Y') AS Date, SUM(total_expense) AS Sum1 FROM expense WHERE paid_by = '{$_SESSION['username']}' GROUP BY DATE_FORMAT(date, '%Y') ORDER BY DATE_FORMAT(date, '%Y') DESC ";
               $result_query_sum3 = mysqli_query($connection,$query3);
               while($row = mysqli_fetch_assoc($result_query_sum3)){
                    $date  = $row['Date'];
                    $paid   = $row['Sum1'];
                    if($paid>$max2) $max2 = $paid;

                    $query4 = "SELECT SUM(amount_due) AS Sum2 FROM liability WHERE user_name = '{$_SESSION['username']}' AND DATE_FORMAT(date, '%Y') = {$date} ";
                    $result_query_sum4 = mysqli_query($connection,$query4);
                    while($row = mysqli_fetch_assoc($result_query_sum4)){
                      if($row['Sum2']) $owed   = $row['Sum2'];
                      else $owed = 0;
                      
                      if($owed>$max2) $max2 = $owed;
                    }


                    echo "['{$date}',{$paid},{$owed}],";
              }


        ?>
            ]);

            var options = {
              width: 600,
              height: 360,
              legend: { 
                position: 'none' 
                },
                bars: 'horizontal', 
                axes: {
                  x: {
                    0: { 
                      side: 'top',
                      label: 'Percentage',
                    } 
                  }
                },
                hAxis: { ticks: [10,20,30] },
                bar: { groupWidth: "90%" },
                hAxis: {
                    viewWindowMode:'explicit',
                    viewWindow: {
                                  max:<?php echo $max2; ?>+2000,
                                  min:0-100
                                }
                },
              colors:['#7cc4dd','#f3bb45'],
              animation: {
                startup: true,
                duration: 2000,
                easing: 'linear'
              }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            
            chart.draw(data, google.charts.Bar.convertOptions(options));
          }


    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Group Expenses','Money Owed'],
        <?php $max=0;
        
               $query = "SELECT DATE_FORMAT(date, '%m-%Y') AS Date, SUM(total_expense) AS Sum, MONTHNAME(date) AS Month FROM expense WHERE paid_by = '{$_SESSION['username']}' GROUP BY DATE_FORMAT(date, '%m-%Y') ORDER BY DATE_FORMAT(date, '%Y') ASC ";
               $result_query_sum = mysqli_query($connection,$query);
               while($row = mysqli_fetch_assoc($result_query_sum)){
                    $month = $row['Month'];
                    $date  = $row['Date'];
                    $sum   = $row['Sum'];
                    if($sum>$max) $max = $sum;
                    echo "['{$date}',{$sum},0],";
               }
               $query = "SELECT DATE_FORMAT(date, '%m-%Y') AS Date, SUM(amount_due) AS Sum, MONTHNAME(date) AS Month FROM liability WHERE user_name = '{$_SESSION['username']}' GROUP BY DATE_FORMAT(date, '%m-%Y') ORDER BY DATE_FORMAT(date, '%Y') ASC ";
               $result_query_sum = mysqli_query($connection,$query);
               while($row = mysqli_fetch_assoc($result_query_sum)){
                    $month = $row['Month'];
                    $date  = $row['Date'];
                    $sum   = $row['Sum'];
                    if($sum>$max) $max = $sum;
                    echo "['{$date}',0,{$sum}],";
               }


        ?>

        ]);

        var options = {
          curveType: 'function',
          legend: { position: 'none' },
          lineWidth: 8,
          pointSize: 20,
            vAxis: {
              viewWindowMode:'explicit',
              viewWindow: {
                max:<?php echo $max; ?>+100,
                min:0-100
              }
            },
          series: {
            0: { color: '#e2431e' },
            1: { color: '#e7711b' },
            2: { color: '#f1ca3a' },
            3: { color: '#6f9654' },
            4: { color: '#1c91c0' },
            5: { color: '#43459d' },
          }

        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>

    <script>
      $(window).resize(function(){
          drawChart1();
          drawChart2();
          drawChart2();
      });
    </script>


