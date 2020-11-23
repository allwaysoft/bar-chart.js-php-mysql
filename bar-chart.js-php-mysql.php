<?php
$servername = 'localhost';
$username = 'phpsamples';
$password = 'phpsamples';
$db = 'phpsamples';
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
mysqli_set_charset($conn, "utf8");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$data1 = '';
$data2 = '';
$buildingName = '';
$query = "SELECT costs.cost_id, costs.building_id, buildings.building_name, costs.consumption_date, costs.gas_consumption, costs.gas_cost, costs.created_at, costs.updated_at FROM costs INNER JOIN buildings ON costs.building_id = buildings.building_id";
$runQuery = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($runQuery)) {
    $data1 = $data1 . '"' . $row['gas_consumption'] . '",';
    $data2 = $data2 . '"' . $row['gas_cost'] . '",';
    $buildingName = $buildingName . '"' . ucwords($row['building_name']) . '",';
}
$data1 = trim($data1, ",");
$data2 = trim($data2, ",");
$buildingName = trim($buildingName, ",");
?>

<!DOCTYPE html>
<html>
	<head>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
		<title>Bar Chart using PHP MySQL and Chart JS</title>



	</head>

	<body>	   
   
	    
<div id="container" style="width: 75%;">
		<canvas id="canvas"></canvas>
	</div>
	<script>
		var barChartData = {
			labels: [<?php echo $buildingName; ?>],
			datasets: [{
				label: 'Consumption',
				backgroundColor: 'rgb(255, 99, 132)',
				borderColor: 'rgb(255, 99, 132)',
				borderWidth: 1,
				data: [<?php echo $data1; ?>]
			}, {
				label: 'Cost',
				backgroundColor: 'rgb(54, 162, 235)',
				borderColor: 'rgb(54, 162, 235)',
				borderWidth: 1,
				data:[<?php echo $data2; ?>]
			}]

		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Chart.js Bar Chart'
					}
				}
			});

		};


	</script>	    
	    
	</body>
</html>