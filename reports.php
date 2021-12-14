<?php
include_once 'header.php';

session_start();

$username = $_SESSION['username'];
$U_id = $_SESSION['U_id'];
echo ("<script>console.log('PHP: " . $U_id . "');</script>");

include_once 'db.php';
include_once 'api.php';

$sql3= "SELECT * FROM `user` WHERE U_id = '$U_id';";
$result3 = $conn->query($sql3);

if ($result3->num_rows > 0) {

    while($row = $result3->fetch_assoc()) 
    {
        $userid= $row["U_id"]; 
        $password= $row["U_password"];
        $username= $row["U_username"];
       
    }
} 
else {
echo "0 results";
}


$gains = getGain($conn,$U_id);

$costs= getCost($conn,$U_id);
$nofCustomer = getCustomerNumber($conn,$U_id);
$nofOrder = getOrderNumber($conn,$U_id);

$result = $gains - $costs;
if ($result>0)
{
    $profits = $result;
}
else if ($result<=0){
 $loss= $result;
}
echo'

';

$db = ($conn);

$result = $db->query("SELECT sold_items.P_id,sold_items.P_quantity,inventory.P_id,inventory.P_name
 FROM inventory JOIN sold_items ON sold_items.P_id= inventory.P_id WHERE sold_items.U_id = $U_id");

$result1 = $db->query("SELECT sold_items.P_id,sold_items.P_quantity,inventory.P_id,inventory.P_name,inventory.P_sellingprice, sold_items.P_quantity*inventory.P_Sellingprice AS total_price
 FROM inventory JOIN sold_items ON sold_items.P_id= inventory.P_id WHERE sold_items.U_id = $U_id");

// $result2 = $db->query("SELECT YEAR(O_dateoforder) AS year, MONTH(O_dateoforder) AS month, count(O_id) AS orders FROM customer_order WHERE U_id = $U_id GROUP BY YEAR(O_dateoforder), MONTH(O_dateoforder) ;");
?>
<html>
  <head>
    <style>
      
/* The popup form - hidden by default */
.form-popup {
  display: none;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 100%;
  padding: 10px;

  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
    </style>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  
  <link rel="stylesheet" href="css/reports.css">
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.load('current', {'packages':['corechart', 'bar']});
      google.charts.load('current', {'packages':['corechart', 'bar']});

      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawStuff);
      google.charts.setOnLoadCallback(drawChart1);


function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Item', 'quantity'],
      <?php
      if($result->num_rows > 0){
          while($row = $result->fetch_assoc()){
            echo "['".$row['P_name']."', ".$row['P_quantity']."],";
          }
      }
      ?>
    ]);
    
    var options = {
        title: 'Sales per item',
        width: 1100,
        height: 600,
        pieSliceText: 'value'

    };
    
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    
    chart.draw(data, options);
}
function drawStuff() {

//var chartDiv = document.getElementById('chart_div');

var data = google.visualization.arrayToDataTable([
  ['', ''],
  ['Sales',  parseInt('<?php echo $gains; ?>')],
  ['Expenses',  parseInt('<?php echo $costs; ?>')],



]);

var materialOptions = {
  width: 500,
  colors: ['red'],

  chartArea:{left:10,top:1220,width:"100%",height:"100%"},

  legend: {position: 'none'},


  chart: {
    
    title: 'Sales VS Expenses',

  },

  axes: {
    y: {
      //distance: {label: 'parsecs'}, // Left y-axis.
    }
  }
};

function drawMaterialChart() {
  var materialChart = new google.charts.Bar(document.getElementById('chart_div'));
  materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
  button.innerText = 'Change to Classic';
  button.onclick = drawClassicChart;
}



drawMaterialChart();

}
function drawChart1() {

//var chartDiv = document.getElementById('chart_div');

var data = google.visualization.arrayToDataTable([
  ['', ''],
  <?php
      if($result1->num_rows > 0){
          while($row = $result1->fetch_assoc()){
            echo "['".$row['P_name']."', ".$row['total_price']."],";
          }
      }
      ?>

]);

var materialOptions = {
  width: 500,
  colors: ['red'],

  chartArea:{left:10,top:1220,width:"100%",height:"100%"},

  legend: {position: 'none'},


  chart: {
    
    title: 'Profit per item',

  },

  axes: {
    y: {
      //distance: {label: 'parsecs'}, // Left y-axis.
    }
  }
};

function drawMaterialChart() {
  var materialChart = new google.charts.Bar(document.getElementById('chart_div1'));
  materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
  button.innerText = 'Change to Classic';
  button.onclick = drawClassicChart;
}



drawMaterialChart();


}
</script>
  </head>
<body >
<br>
<br><br>

<h1>Business Reports</h1>


<table style="margin-left: 6%;" >
<tr>
  <div class="customer-number">
  <td>
    <p class="number"><?Php echo "{$nofCustomer}"?></p>
    customers
  </td>
  </div>
  <div class="order-number">
  <td>
  <p class="number"><?Php echo "{$nofOrder}"?></p>
    orders
  </td>
  </div>
</tr>
  <tr>
    <td>
      <div id="chart_div1" style="margin-top:100px;float:right;width: 100%; height: 450px;"></div>
    </td>
    <td>
      <div id="piechart" style="margin-top:100px;float:right"></div>

    </td>
  </tr>
</table>


<div id="chart_div" style="width: 100%; height: 400px;"></div>
<br>




</body>
</html>
