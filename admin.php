<?php
	session_start();

	if(!isset($_SESSION['Eid']) || $_SESSION['Eid'] != 1)
		header('location:home.php');

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "supermarket";
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
		echo $q = "select * from godown where Godown_Location = '$loc' and Manager_ID = '$Mid'";
	?>
	</select>
	<button type="submit" name="button1">Add</button>
</form>

<?php
	if(isset($_POST['button1']))
	{
		echo"Hello";
		// $Mid = $_POST['Mid'];
		// $loc = $_POST['loc'];
		// $q = "select * from godown where Godown_Location = '$loc' and Manager_ID = '$Mid'";

		// $con = mysqli_connect("127.0.0.1","root","");
		// mysqli_select_db($con, "supermarket");

		
		// $result = mysqli_query($con, $q);

		// $n = mysqli_num_rows($result);

		// if($n != 0)
		// {
		// 	echo "Godown exists!!";
		// }
		// else
		// {
		// 	$q = "INSERT INTO `godown`(`Godown_Location`, `Manager_ID`) VALUES ('$loc', $Mid)";

		// 	if(mysqli_query($con, $q))
		// 	{
		// 		echo "Godown Added Successfully!!";
		// 		header('location:godowns.php');
		// 	}
		// 	else
		// 	{
		// 		echo "Godown cannot be added!! Check Manager ID";
		// 	}

		// }
	}
?>
