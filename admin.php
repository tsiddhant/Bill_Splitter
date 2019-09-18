<?php include "includes/db.php"; ?><!-- Including Database Connection File -->
<?php include "includes/new_admin_header.php"; ?><!-- Including Header File -->
<?php include "includes/admin_navigation.php"; ?><!-- Including Admin Navigation File -->

      <div class="content"><!-- Creating a Container -->
        <div class="row"><!-- Creating a Row -->
          <div class="col-lg-3 col-md-6 col-sm-6"><!-- Creating a Card for Display -->
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
<!-- QUERY TO FIND NUMBER OF GROUPS JOINED BY THE USER -->
                      <p class="card-category">Groups Joined</p>
                      <?php
                             $query4 = "SELECT * FROM groups WHERE admin_username = '{$_SESSION['username']}' OR members LIKE '%{$_SESSION['username']}%' ";//Groups finding query
                             $select_groups = mysqli_query($connection, $query4);//Query command
                             $groups_count = mysqli_num_rows($select_groups);//Number of groups joined
                      ?>
                      <p class="card-title"><?php echo $groups_count; ?><!-- Displaying Count Calculated -->
                      <p><br>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End of Card -->
          <div class="col-lg-3 col-md-6 col-sm-6"><!-- Creating a card for Display -->
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
<!-- QUERY TO FIND TOTAL EXPENSES OF USER -->
                      <p class="card-category">Expenses:<?php echo date('Y'); ?></p>
                      <?php   
                             $query3 = "SELECT SUM(total_expense) AS sum FROM expense WHERE paid_by = '{$_SESSION['username']}' AND DATE_FORMAT(date, '%Y') = date('Y') ";//Expenses calculating query
                             $select_expenses = mysqli_query($connection, $query3);//Query command
                             $expenses_count = mysqli_fetch_assoc($select_expenses);//Total Expenses of User
                      ?>
                      <p class="card-title"><?php if($expenses_count['sum']){echo $expenses_count['sum'];} else{echo "0";} ?><!-- Displaying Expenses Calculated -->
                      <p><br>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End of Card -->
          <div class="col-lg-3 col-md-6 col-sm-6"><!-- Creating a card for Display -->
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
<!-- QUERY TO FIND TOTAL COMMENTS POSTED BY USER -->
                      <p class="card-category">Comments</p>
                      <?php
                            $query2 = "SELECT * FROM comments WHERE comment_author = '{$_SESSION['name']}' ";//Comments calculating query
                            $select_comments = mysqli_query($connection, $query2);//Query command
                            $comments_count = mysqli_num_rows($select_comments);//Total comments by User
                      ?>
                      <p class="card-title"><?php echo $comments_count; ?><!-- Displaying Comments Count Calculated -->
                      <p><br>
                    </div>
                  </div>
                </div>
              </div>           
            </div>
          </div><!-- End of Card -->
          <div class="col-lg-3 col-md-6 col-sm-6"><!-- Creating a card for Display -->
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
<!-- QUERY TO FIND TOTAL FRIENDS OF USER -->
                      <p class="card-category">Friends</p>
                      <?php
                               $query = "SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user1_id WHERE f.user2_id = {$_SESSION['user_id']} UNION SELECT p.* FROM friends f JOIN users p ON p.user_id = f.user2_id WHERE f.user1_id = {$_SESSION['user_id']}";//Calculating Friends Query
                               $select_friends = mysqli_query($connection, $query);//Query command
                               $friends_count = mysqli_num_rows($select_friends);//Total Friends of User
                      ?>
                      <p class="card-title"><?php  echo $friends_count; ?><!-- Displaying Friends Count Calculated -->
                      <p><br>
                    </div>
                  </div>
                </div>
              </div>            
            </div>
          </div><!-- End of Card -->
        </div><!-- End of Row -->
        <div class="row"><!-- Creating a row -->
          <div class="col-md-12 embed-responsive"><!-- Creating a card to display Monthly Expenses Graph -->
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">Net Expenses Trends(Monthly)</h5>
              </div>
              <div class="card-body embed-responsive table-responsive">
                <div id="curve_chart" style="width: 1200px; height: 400px;"></div><!-- Displaying Line Chart Using Google API -->
              </div>
            </div>
          </div>
        </div><!-- End of Row -->
        <div class="row"><!-- Creating a row -->
          <div class="col-md-4" style="margin-left:30px; margin-right:50px;"><!-- Creating a card to display Category Based Expenditure -->
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">Expenditure-Category Based</h5>
              </div>
              <div class="card-body">
                  <div class="row" style="margin:auto;"><!-- Creating a row -->
                  <form action="#" method="post"><!-- Creating a form for Selecting Year Dropdown -->
                        <select name="select1"> <!-- Dropdown Created-->
                            <option value="2019" <?php if(isset($_POST['select1']) && $_POST['select1'] == "2019") echo 'selected="selected"';?> >2019</option> 
                            <option value="2018" <?php if(isset($_POST['select1']) && $_POST['select1'] == "2018") echo 'selected="selected"';?>>2018</option> 
                            <option value="2017" <?php if(isset($_POST['select1']) && $_POST['select1'] == "2017") echo 'selected="selected"';?>>2017</option> 
                        </select>
                        <button type="submit"><!-- Form submit button --> 
                            Ok 
                        </button>
                  </form><!-- End of form -->
                  </div><!-- End of row --> 
              <div id="piechart" style="width: 500px; height: 300px;"></div><!-- Displaying Pie Chart Using Google API -->
              </div>
              <div class="card-footer ">
                <div class="legend">
                  <i class="fa fa-circle text-primary"></i> Category
                  <i class="fa fa-circle text-warning"></i> Expense
                </div>
                <div class="card-footer">
                <hr>
                <div class="stats">
                  <i class="fa fa-calendar"></i> Amount of money spent<!-- Card Footer -->
                </div>
                </div>
              </div>
            </div>
          </div><!-- End of Card -->
          <div class="col-md-7"><!-- Creating a card to Display Yearly Expenditure Graph -->
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-title">Net Expenses Trends(Yearly)</h5>
              </div>
              <div class="card-body embed-responsive table-responsive">
              <div id="columnchart_material" ></div><!-- Creating Column Chart Using Google API -->
              </div>
              <div class="card-footer">
                <hr>
                <div class="stats">
                  <i class="fa fa-calendar"></i> Amount of money<!-- Card Footer -->
                </div>
              </div>
            </div>
          </div><!-- End of Card -->
        </div><!-- End of Row -->
      </div><!-- End of Container -->
      
    </div><!-- End of Body Tag-->
  </div><!-- End of Html Tag -->

  <script src="assets/js/plugins/chartjs.min.js"></script><!-- JS for using google charts -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script><!-- JS for using bootstrap notifications alerts -->

  <?php include "includes/admin_footer.php"; ?><!-- Including Admin Footer File -->

<!-- JS for Category Pie Chart -->
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
                $year_choose = date('Y');
              }
              // Query to Get Total expenses on each Category Grouped Year Wise
              $query2 = "SELECT SUM(total_expense) AS Sum, tags FROM expense WHERE paid_by = '{$_SESSION['username']}' AND DATE_FORMAT(date, '%Y') = '{$year_choose}' GROUP BY DATE_FORMAT(date, '%Y'),tags ORDER BY DATE_FORMAT(date, '%Y') ASC ";       
              $result_query_sum2 = mysqli_query($connection,$query2);
              while($row2 = mysqli_fetch_assoc($result_query_sum2)){
                   $tags  = $row2['tags'];
                   $sum   = $row2['Sum'];
                   echo "['{$tags}',{$sum}],";
              }
          ?>
        ]);
        //Customizing pie chart 
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
<!-- JS for Yearly Expenses Chart -->
    <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart','bar']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Year', 'Paid', 'Owed'],
              <?php $max2=0;
              //Query to get total expenses by user Grouped Year Wise 
               $query3 = "SELECT DATE_FORMAT(date, '%Y') AS Date, SUM(total_expense) AS Sum1 FROM expense WHERE paid_by = '{$_SESSION['username']}' GROUP BY DATE_FORMAT(date, '%Y') ORDER BY DATE_FORMAT(date, '%Y') DESC ";
               $result_query_sum3 = mysqli_query($connection,$query3);
               while($row = mysqli_fetch_assoc($result_query_sum3)){
                    $date  = $row['Date'];
                    $paid   = $row['Sum1'];
                    if($paid>$max2) $max2 = $paid;
                    //Query to get total money Owed from Others Grouped Year Wise
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
// Customizing the Column Chart
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
<!-- JS For Monthly Expenses Chart -->
    <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Group Expenses','Money Owed'],
        <?php $max=0;
               //Query to Get Total Expenses Per Month By User
               $query = "SELECT DATE_FORMAT(date, '%m-%Y') AS Date, SUM(total_expense) AS Sum, MONTHNAME(date) AS Month FROM expense WHERE paid_by = '{$_SESSION['username']}' GROUP BY DATE_FORMAT(date, '%m-%Y') ORDER BY DATE_FORMAT(date, '%Y') ASC ";
               $result_query_sum = mysqli_query($connection,$query);
               while($row = mysqli_fetch_assoc($result_query_sum)){
                    $month = $row['Month'];
                    $date  = $row['Date'];
                    $sum   = $row['Sum'];
                    if($sum>$max) $max = $sum;
                    echo "['{$date}',{$sum},0],";
               }
               //Query to get Total Money Owed From Others Per Month By User
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
//Customizing the Line Chart
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
<!-- JS to Resize Google Chart On Changing Screen Size -->
    <script>
      $(window).resize(function(){
          drawChart1();
          drawChart2();
          drawChart2();
      });
    </script>


