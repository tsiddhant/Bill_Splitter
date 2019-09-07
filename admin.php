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

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="style_admin2.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>
<body>


<?php include "includes/admin_navigation.php"; ?>


<h1 class="mt-4">BILL SPLITTER</h1>


<div class="container" id="box">
				<div class="row">
					<div class="col-lg-3">
						<div class="card text-center">
							<div class="title">
								<i class="fa fa-address-book" aria-hidden="true"></i>
								<a href="all_books_user.php">Browse</a>
							</div>
							
		
						</div>	
					</div>
                    <div class="col-lg-3">
						<div class="card text-center">
							<div class="title">
								<i class="fa fa-money" aria-hidden="true"></i>
								<a href="fine_user.php">Check</a>
							</div>
							
							
							
						</div>	
					</div>
				   
					<div class="col-lg-3">
						<div class="card text-center">
							<div class="title">
								<i class="fa fa-folder-open" aria-hidden="true"></i>
                                <a href="find_book_user.php">Find Books</a>
							</div>
							
							
						</div>	
					</div>
					<div class="col-lg-3">
						<div class="card text-center">
							<div class="title">
								<i class="fa fa-tasks" aria-hidden="true"></i>
                                <a href="logout.php">Exit</a>
							</div>
							
						</div>	
					</div>

				</div>
            </div>
<!-- GOOGLE CHARTS -->

 <div class="row">
  <div class="col-lg-12">
    <hr />
  </div>
  <div class="clearfix"></div>
  <div class="col-lg-6">
  <div id="piechart_3d" class="chart"></div>
  </div>
  <div class="col-lg-6">
  <div id="columnchart_material" class="chart"></div>
  </div>
</div>


<?php include "includes/admin_footer.php"; ?>

<script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart1);
            function drawChart1() {
                var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Work',     11],
                ['Eat',      2],
                ['Commute',  2],
                ['Watch TV', 2],
                ['Sleep',    7]
                ]);

                var options = {
                title: 'My Daily Activities',
                is3D: true,
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                chart.draw(data, options);
            }
</script>

<script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart2);

            function drawChart2() {
                var data = google.visualization.arrayToDataTable([
                ['Year', 'Sales', 'Expenses', 'Profit'],
                ['2014', 1000, 400, 200],
                ['2015', 1170, 460, 250],
                ['2016', 660, 1120, 300],
                ['2017', 1030, 540, 350]
                ]);

                var options = {
                chart: {
                    title: 'Company Performance',
                    subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                }
                };

                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }

$(window).resize(function(){
  drawChart1();
  drawChart2();
});
</script>
<style>

.chart {
  width: 100%; 
  min-height: 450px;
}
.row {
  margin:0 !important;
}

</style>