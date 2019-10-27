<?php
	session_start();

	if(!isset($_SESSION['Eid']))
		header('location:login.php');

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "supermarket";
?>

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

<h1>Add Purchase</h1>
<form method="post">
	<label>Supplier ID</label>
	<select name="Sid">
	<?php
		$mysqli = new mysqli($servername, $username, $password, $dbname);
		$sqlSelect="SELECT * FROM supplier";
		$result = $mysqli-> query ($sqlSelect);
		while ($row = mysqli_fetch_array($result)) {
	    	$rows[] = $row;
		}
		foreach ($rows as $row) {
		    print "<option value='" . $row['Supplier_ID'] . "'>" .$row['Supplier_ID']."(". $row['Supplier_Name'] . ")</option>";
		}
	?>
	</select>
	<label>Godown ID</label>
	<select name="Gid">
	<?php
		$mysqli = new mysqli($servername, $username, $password, $dbname);
		$sqlSelect="SELECT * FROM godown";
		$result = $mysqli-> query ($sqlSelect);
		while ($row = mysqli_fetch_array($result)) {
	    	$rows[] = $row;
		}
		foreach ($rows as $row) {
		    print "<option value='" . $row['Godown_ID'] . "'>" .$row['Godown_ID']."(". $row['Godown_Location'] . ")</option>";
		}
	?>
	</select>
	<label>Date of Purchase</label>
	<input type="Date" name="date">
	<button type="submit" name="button1">Add</button>
</form>

<?php
	function isManager($mid, $gid)
	{
		$q = "select * from godown where Godown_ID = $gid and Manager_ID = $mid";

		$con = mysqli_connect("127.0.0.1","root","");
		mysqli_select_db($con, "supermarket");
		
		$result = mysqli_query($con, $q);

		$n = mysqli_num_rows($result);
		return $n > 0;
	}

	
	if(isset($_POST['button1']))
	{
		$Gid = $_POST['Gid'];
		$Sid = $_POST['Sid'];
		$input_date = $_POST['date'];
		$date=date("Y-m-d",strtotime($input_date));
		if(isManager($_SESSION['Eid'], $Gid))
		{
			$q = "select * from purchase where Godown_ID = '$Gid' and Supplier_ID = '$Sid' and DOP = '$date'";

			$con = mysqli_connect("127.0.0.1","root","");
			mysqli_select_db($con, "supermarket");
			
			$result = mysqli_query($con, $q);

			$n = mysqli_num_rows($result);

			if($n != 0)
			{

				$q = "select Purchase_ID from purchase where Godown_ID = '$Gid' and Supplier_ID = '$Sid' and DOP = '$date' limit 1";
				$result = mysqli_query($con, $q);
				$Pid = mysqli_fetch_row($result)[0];

				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "supermarket";

				$conn = new mysqli($servername, $username, $password, $dbname);
				if ($conn->connect_error) {
				    die("Connection failed: " . $conn->connect_error);
				}
				$sql = "SELECT * FROM purchase_item_details natural join item where Purchase_ID = $Pid";

				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
				    echo "<table><tr><th>Item ID</th><th>Item Name</th><th>Quantity</th><th>Price per unit</th><th>Total price</th></tr>";

				    while($row = $result->fetch_assoc()) {
				        echo "<tr><td>" . $row["Item_ID"]. "</td><td>" . $row["Item_Name"]. "</td><td>" . $row["Quantity"] . "</td><td>Rs." . $row["Item_Unit_Price"] . " per " . $row["Item_Units"] ."</td><td>" . $row["Item_Unit_Price"] * $row["Quantity"]. "</td></tr>";
				    }
				    echo "</table>";
				} else {
				    echo "0 results";
				}






			}
			else
			{
				$q = "INSERT INTO `purchase`(`Godown_ID`, `Supplier_ID`, `DOP`) VALUES ($Gid, $Sid, '$date')";
				// echo $q;

				if(mysqli_query($con, $q))
				{
					echo "Purchase Added Successfully!!";
				}
				else
				{
					echo "Purchase cannot be added!! Check Details again";
				}
			}
			$q = "select Purchase_ID from purchase where Godown_ID = '$Gid' and Supplier_ID = '$Sid' and DOP = '$date' limit 1";
			$result = mysqli_query($con, $q);
			$Pid = mysqli_fetch_row($result)[0];
			echo "<br><br<b>Purchase exists!! Purchase id is : $Pid</b><br><br>";
			echo "<a href='editpurchase.php?Pid=".$Pid."&Gid=".$Gid."&Sid=".$Sid."''>Edit this purchase</a><br><br>";
		}
		else
		{
			echo "You are not permitted to add Purchase!!";
		}
	}

	
?>

</body>
</html>