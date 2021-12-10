<?php
include_once 'header.php';

session_start();

$username = $_SESSION['username'];
$U_id = $_SESSION['U_id'];
echo ("<script>console.log('PHP: " . $U_id . "');</script>");

include_once 'db.php';
include_once 'api.php';
$db = new mysqli("localhost", "root", "root", "salesSystem");
//$result = $db->query("SELECT P_id,P_quantity FROM sold_items WHERE U_id = $U_id ");


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
<br>
<br>
 <div id="chart_div" style="width: 800px; height: 500px;"></div>
 <div id="piechart"></div>

'



;

?>
<html>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
              google.charts.load('current', {'packages':['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {

        var chartDiv = document.getElementById('chart_div');

        var data = google.visualization.arrayToDataTable([
          ['', ''],
          
          ['Sales',  parseInt('<?php echo $gains; ?>')],
          ['Costs',  parseInt('<?php echo $costs; ?>')],

        
  
        ]);

        var materialOptions = {
          width: 500,
          colors: ['red'],

          chartArea:{left:10,top:1220,width:"100%",height:"100%"},

          legend: {position: 'none'},


          chart: {
            
            title: 'Cost VS Sales',

          },
        
          axes: {
            y: {
              //distance: {label: 'parsecs'}, // Left y-axis.
            }
          }
        };

        

        function drawMaterialChart() {
          var materialChart = new google.charts.Bar(chartDiv);
          materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
          button.innerText = 'Change to Classic';
          button.onclick = drawClassicChart;
        }

    

        drawMaterialChart();
    };
</script>


<body>
<div class="container">
  <h2>Google Pie Chart | Technopoints</h2>
  <table class="table table-striped">
    <thead>
      <tr>
		<th>#</th>
        <th>Activities</th>
        <th>Hours</th>
      </tr>
    </thead>
    <tbody>
	<?php   require 'db.php';
  $U_id = $_SESSION['U_id'];
debug_to_console($U_id);
		$fetchqry = "SELECT * FROM `sold_items` WHERE U_id = $U_id";
		$result=mysqli_query($conn,$fetchqry);
		$num=mysqli_num_rows($result);
	 while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
?>
      <tr>
		<td><?php echo $row['P_id'];?></td>
        <td><?php echo $row['P_quantity'];?></td>
      </tr>
	<?php } ?>
    </tbody>
  </table>
</div>
<div id="piechart"></div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
 
// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Hobbies', 'Time in Hours'], <?php
		$result=mysqli_query($conn,$fetchqry);
  while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
  echo "['".$row['P_id']."', ".$row['P_quantity']."],";
   } ?>  ]);
  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Daily Activities', 
				 'width':'auto', 
				 'height':'auto',
				 // pieHole: 0.2,
				  };
 
  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);

  drawChart();
}
</script>

<div id="piechart"></div>
</body>
</html>
