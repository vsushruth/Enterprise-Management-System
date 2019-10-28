<?php
	session_start();

	if(!isset($_SESSION['Eid']))
		header('location:login.php');

	
?>

<?php include "head.php"; ?>
<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>
<a href='home.php'>Back</a>

<h1>All Godowns</h1>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supermarket";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM godown";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class = 'table table-hover table-striped'><tr><th>Godown ID</th><th>Godown Location</th><th>Manager ID</th></tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Godown_ID"]. "<a href='godown.php?Gid=".$row["Godown_ID"]."'><button type='submit' name='submit1'>More</button></a></td><td>" . $row["Godown_Location"]. "</td><td>" . $row["Manager_ID"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>


<h1>Add Godown</h1>
<form method="post">
	<label>Location</label>
	<input type="text" name="loc" required>
	<label>Manager-ID</label>
	<select name="Mid">
	<?php
		$mysqli = new mysqli($servername, $username, $password, $dbname);
		$sqlSelect="SELECT * FROM employee";
		$result = $mysqli-> query ($sqlSelect);
		while ($row = mysqli_fetch_array($result)) {
	    	$rows[] = $row;
		}
		foreach ($rows as $row) {
		    print "<option value='" . $row['Employee_ID'] . "'>" .$row['Employee_ID']."(". $row['Employee_Name'] . ")</option>";
		}
	?>
	</select>
	<button type="submit" name="button1">Add</button>
</form>

<?php
	if(isset($_POST['button1']) && $_SESSION['Eid'] == 1)
	{
		$Mid = $_POST['Mid'];
		$loc = $_POST['loc'];
		$q = "select * from godown where Godown_Location = '$loc' and Manager_ID = '$Mid'";

		$con = mysqli_connect("127.0.0.1","root","");
		mysqli_select_db($con, "supermarket");
		
		$result = mysqli_query($con, $q);

		$n = mysqli_num_rows($result);

		if($n != 0)
		{
			echo "Godown exists!!";
		}
		else
		{
			$q = "INSERT INTO `godown`(`Godown_Location`, `Manager_ID`) VALUES ('$loc', $Mid)";

			if(mysqli_query($con, $q))
			{
				echo "Godown Added Successfully!!";
				header('location:godowns.php');
			}
			else
			{
				echo "Godown cannot be added!! Check Manager ID";
			}

		}
	}
	else if($_SESSION['Eid'] != 1)
	{
		echo "You are not permitted to add Godown!!";
	}
?>

</body>
</html>