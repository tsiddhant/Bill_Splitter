<?php include "includes/db.php"; ?>
<?php include "includes/new_admin_header.php"; ?> 
<?php include "all_functions.php"; ?>
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
<div>
<div class="row">
          <div class="col-md-6">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-title">Expenses(Monthly)</h5>
              </div>
              <div class="card-body embed-responsive table-responsive">
                <form action="#" method="post">
                    <select name="select1"> 
                        <option value="2019" <?php if(isset($_POST['select1']) && $_POST['select1'] == "2019") echo 'selected="selected"';?> >2019</option> 
                        <option value="2018" <?php if(isset($_POST['select1']) && $_POST['select1'] == "2018") echo 'selected="selected"';?>>2018</option> 
                        <option value="2017" <?php if(isset($_POST['select1']) && $_POST['select1'] == "2017") echo 'selected="selected"';?>>2017</option> 
                    </select>
                    <button type="submit">Ok</button>
                </form>
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
          <div class="col-md-6">
            <div class="card card-chart">
              <div class="card-header">
              <h5 class="card-title">Expenses(Weekly)</h5>
              </div>
              <div class="card-body embed-responsive table-responsive">
                <form action="#" method="post">
                    <select name="select2"> 
                        <option value="2019" <?php if(isset($_POST['select2']) && $_POST['select2'] == "2019") echo 'selected="selected"';?> >2019</option> 
                        <option value="2018" <?php if(isset($_POST['select2']) && $_POST['select2'] == "2018") echo 'selected="selected"';?>>2018</option> 
                        <option value="2017" <?php if(isset($_POST['select2']) && $_POST['select2'] == "2017") echo 'selected="selected"';?>>2017</option> 
                    </select>
                    <select name="select3" size='1'>
                    <?php
                    for ($i = 0; $i < 12; $i++) {
                        $time = strtotime(sprintf('%d months', $i));   
                        $label = date('F', $time);   
                        $value = date('m', $time);
                        echo "<option value='$value'>$value</option>";
                    }
                    ?>
                    </select>
                    <button type="submit">Ok</button>
                </form>
              <div id="columnchart_material1" ></div>
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
            </form>
    </div>
<?php } ?>

<?php
// ADDING MEMBERS INTO YOUR GROUP(ONLY IF THEY ARE YOUR FRIEND)
add_members($admin_id, $group_id,$connection);

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
            </form>
<?php } ?>

<?php
// DELETING MEMBERS FROM GROUP(ONLY IF THEY ARE YOUR FRIEND)
delete_members($admin_id, $group_id, $connection);
?>

<!-- ADDING NEW EXPENSES FORM IN GROUP -->
<button name="group" class="btn btn-primary" id="1">Add Expense</button>
<br><br>

        <div class="d-inline-block table-responsive">
            <span><form id="group" class="form-check-inline" action="" method="post" onsubmit="return check();">
                <span><div class="jumbotron embed-responsive-1by1" id="new">
                        <?php if($_SESSION['user_id'] == $admin_id){ ?>
                            <span class="d-inline"><label class="" for="inlineFormCustomSelect">Members: </label></span>
                            <span class="d-inline"><select name="select[]" size="2" multiple="multiple" class="members" id="members" required>
                            <?php 
                                show_all_members_admin($connection, $admin_username, $group_id);
                            ?>
                            </select></span>
                        <?php } else { ?>
                            <span class="d-inline"><label class="mr-sm-2" for="inlineFormCustomSelect">Members: </label></span>
                            <span class="d-inline"><select name="select[]" size="2" multiple="multiple" class="members" id="members" required>
                            <?php 
                                show_all_members_non_admin($connection, $admin_username, $group_id, $admin_id);
                            ?>
                            </select></span>
                        <?php } ?>
                        <br><br>
                <div>
                <i class="fa fa-sticky-note" aria-hidden="true"></i>
                <span class="d-inline-block"><input type="text" class="form-control" id="inlineFormInput" placeholder="Enter a Description" name="subject_name" value="<?php echo isset($_POST['subject_name']) ? $_POST['subject_name'] : '' ?>"required></span>
                <span class="d-inline-block"><br>
                <div class="">
                        
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
                <br>
                <br>
                <div>
                    <label for="paid_by">Paid by:</label>
                    <?php if($_SESSION['user_id'] == $admin_id){ ?>
                            <span class="d-inline"><select name="select2" id="inlineFormCustomSelect" required>
                              <?php 
                                  show_all_members_admin($connection, $admin_username, $group_id);
                              ?>
                            </select></span>                      
                        <?php } else { ?>                            
                            <span class="d-inline"><select name="select2" size="1" id="inlineFormCustomSelect" required>
                              <?php 
                                  show_all_members_non_admin($connection, $admin_username, $group_id, $admin_id);
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
            <div class="jumbotron" style="width:250px;" id="new3">
            <div>

<!-- AJAX --><div id="js"><h6>NO OPTION SELECTED</h6></div>
            </div>
            </div>
            </span>          
        </form></span>
    </div>

<?php include "includes/admin_footer.php"; 
      
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
  //calc_sum($money, $sum, $flag2, $net_amount);
  //////////////////////////
  bill_split($flag2, $net_amount, $sum, $group_id, $description, $currency, $paid_by, $tag, $connection);
} 

if(isset($_POST["add_expense"]))  {
///////////////////DELETE LIABILITY FIELDS WITH SAME USERNAME AND PAID TO
  del_duplicate($connection);
}
?>
<!-- SCRIPT FUNCTIONS TO SHOW AND HIDE (TOGGLE) FORMS ON BUTTON CLICK -->
<script>   
$(document).ready(function(){
    $("#group").hide();
    $("#group2").hide();
    $("#new2").hide();
    $("#new3").hide();
  $("#1").click(function(){
    $("#group").toggle(400);
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

    function updateSymbol(e){
    var selected = $(".currency-selector option:selected");
    $(".currency-symbol").text(selected.data("symbol"))
    $(".currency-amount").prop("placeholder", selected.data("placeholder"))
    $('.currency-addon-fixed').text(selected.text())
    }

    $(".currency-selector").on("change", updateSymbol)

    updateSymbol()
</script>
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
            document.getElementById("js").innerHTML += "&nbsp <input type='checkbox' name='select_group' checked='checked' disabled> "+str[i]+"&nbsp<br> <input type='number' name='money_exact[]'><br>";
            
        }
        }
        });

</script>
<script type="text/javascript">
          google.charts.load('current', {'packages':['corechart','bar']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Month', 'Paid'],
              <?php $max2=0;
                    if(isset($_POST['select1'])){
                    $year_choose = $_POST['select1'];
                    }
                    else{
                    $year_choose = date('Y');
                    }
        
               $query3 = "SELECT MONTHNAME(date) AS Month, SUM(total_expense) AS Sum1 FROM expense WHERE paid_by = '{$_SESSION['username']}' AND group_id = '{$group_id}' AND DATE_FORMAT(date, '%Y') = '{$year_choose}' GROUP BY DATE_FORMAT(date, '%m') ORDER BY DATE_FORMAT(date, '%m') ASC ";
               $result_query_sum3 = mysqli_query($connection,$query3);
               while($row = mysqli_fetch_assoc($result_query_sum3)){
                    $month = $row['Month'];
                    $paid   = $row['Sum1'];
                    if($paid>$max2) $max2 = $paid;

                    echo "['{$month}',{$paid}],";
              }


        ?>
            ]);

            var options = {
              width: 550,
              height: 200,
              legend: { 
                position: 'none' 
                },
                bars: 'vertical', 
                axes: {
                  y: {
                    0: { 
                      side: 'top',
                      label: 'Percentage',
                    } 
                  }
                },
                vAxis: { ticks: [10,20,30] },
                bar: { groupWidth: "90%" },
                vAxis: {
                    viewWindowMode:'explicit',
                    viewWindow: {
                                  max:<?php echo $max2; ?>+2000,
                                  min:0-100
                                }
                },
              colors:['red'],
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
          google.charts.load('current', {'packages':['corechart','bar']});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Week', 'Paid'],
              <?php $max2=0;
                    if(isset($_POST['select2'])){
                    $year_choose = $_POST['select2'];
                    }
                    else{
                    $year_choose = date('Y');
                    }

                    if(isset($_POST['select3'])){
                    $month_choose = $_POST['select3'];
                    }
                    else{
                    $month_choose = date('m');
                    }
        
            $query3 = "SELECT WEEK(date) AS week, SUM(total_expense) AS Sum1 FROM expense WHERE paid_by = '{$_SESSION['username']}' AND group_id = '{$group_id}' AND DATE_FORMAT(date, '%Y') = '{$year_choose}' AND DATE_FORMAT(date, '%m') = '{$month_choose}' GROUP BY week ORDER BY WEEK(date) ASC ";
            $result_query_sum3 = mysqli_query($connection,$query3);
            while($row = mysqli_fetch_assoc($result_query_sum3)){
                $week = $row['week'];
                $paid   = $row['Sum1'];
                if($paid>$max2) $max2 = $paid;

                echo "['{$week}',{$paid}],";
            }


        ?>
            ]);

            var options = {
              width: 550,
              height: 200,
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
              colors:['#f3bb45'],
              animation: {
                startup: true,
                duration: 2000,
                easing: 'linear'
              }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material1'));

            
            chart.draw(data, google.charts.Bar.convertOptions(options));
          }


    </script>
