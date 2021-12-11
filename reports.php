<?php
include_once 'header.php';

session_start();

$username = $_SESSION['username'];
$U_id = $_SESSION['U_id'];
echo ("<script>console.log('PHP: " . $U_id . "');</script>");

include_once 'db.php';
include_once 'api.php';


$gains = getGain($conn,$U_id);

$costs= getCost($conn,$U_id);

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

$db = new mysqli("localhost", "root", "root", "salesSystem");

$result = $db->query("SELECT sold_items.P_id,sold_items.P_quantity,inventory.P_id,inventory.P_name
 FROM inventory JOIN sold_items ON sold_items.P_id= inventory.P_id WHERE sold_items.U_id = $U_id");


?>
<html>
  <head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.load('current', {'packages':['corechart', 'bar']});

      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawStuff);


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
        width: 900,
        height: 500,
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
</script>
  </head>
<body>
<br>
<br><br>

<div id="piechart" style="margin-top:100px;"></div>

<div id="chart_div" style="width: 800px; height: 500px;"></div>

</body>
</html>
