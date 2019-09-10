<?php
include("includes/db.php");
error_reporting(0);

$output = '';
$expense_description = $_GET['expense_description'];

if($expense_description !== '')
{
 $query = "SELECT * FROM expense WHERE expense_description LIKE '%".$expense_description."%' ";
}

$result = mysqli_query($connection, $query);
$total = mysqli_num_rows($result);
if($total)
{
    $i=0;
 while($row = mysqli_fetch_assoc($result))
 {
  $output .= '
   <tr>
    <td>'.$i.'</td>
    <td>'.$row["expense_description"].'</td>
    <td>'.$row["total_expense"].'</td>	
    <td>'.$row["paid_by"].'</td>
    <td>'.$row['tags'].'</td>
   </tr>';
   $i++;
 }
 echo $output;
}
else
{
 echo "<br><h3>"; echo 'Data Not Found'; echo "</h3>";
}

?>