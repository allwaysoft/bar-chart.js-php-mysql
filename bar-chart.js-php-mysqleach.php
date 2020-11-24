

<!DOCTYPE html>
<html>
	<head>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
		<title>Bar Chart using PHP MySQL and Chart JS</title>



	</head>

	<body>	   

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

$buildings = "SELECT building_id, building_name FROM  buildings order by building_id";
$runQuerybuildings = mysqli_query($conn, $buildings);
while ($rowbuildings = mysqli_fetch_array($runQuerybuildings)) {
	$building_id = $rowbuildings['building_id'];
	$building_name = $rowbuildings['building_name'];
?>

<div id="<?php echo "container".$building_id; ?>" style="width: 75%;">
		<canvas id="<?php echo "canvas".$building_id; ?>"></canvas>
	</div>

<?php
}
?>	
	<script>

		window.onload = function() {

<?php
$buildings = "SELECT building_id, building_name FROM  buildings order by building_id";
$runQuerybuildings = mysqli_query($conn, $buildings);
while ($rowbuildings = mysqli_fetch_array($runQuerybuildings)) {
	$building_id = $rowbuildings['building_id'];
	$building_name = $rowbuildings['building_name'];

	$gas_consumption = '';
	$consumption_date = '';
	$query = "SELECT consumption_date, gas_consumption FROM costs where building_id=" . $building_id;
	$runQuery = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_array($runQuery)) {
   	$gas_consumption = $gas_consumption . '"' . $row['gas_consumption'] . '",';
   	$consumption_date = $consumption_date . '"' . $row['consumption_date'] . '",';
	}
	$gas_consumption = trim($gas_consumption, ",");
	$consumption_date = trim($consumption_date, ",");
?>   
	    

			var <?php echo "ctx".$building_id; ?> = document.getElementById('<?php echo "canvas".$building_id; ?>').getContext('2d');
			window.myBar = new Chart(<?php echo "ctx".$building_id; ?>, {
				type: 'bar',
				data: {
			labels: [<?php echo $consumption_date; ?>],
			datasets: [{
				label: 'Consumption',
				backgroundColor: 'rgb(255, 99, 132)',
				borderColor: 'rgb(255, 99, 132)',
				borderWidth: 1,
				data: [<?php echo $gas_consumption; ?>]
			}]

		},
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: '<?php echo $building_name; ?>'
					},
				scales: {
        yAxes: [{
            ticks: {
                beginAtZero:true
            }
        }]
    }


				}
			});

		


    
<?php
}
?>	 
};
	</script>	 
	</body>
</html>