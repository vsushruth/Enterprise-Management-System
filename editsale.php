<?php 
	include "head.php";
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
<a href='restock.php'>Back</a>
<?php
	echo "<h3>Items already added: </h3>";
	$Rid = $_GET['Rid'];
	$Gid = $_GET['Gid'];
	$Sid = $_GET['Sid'];
	$dor = $_GET['dor'];
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM restock_item_details natural join item natural join restock where Restock_ID = $Rid and DOR < $dor";

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

	echo "<h3>All items</h3>";

	$sql = "SELECT * FROM godown_item_details natural join item  natural join purchase where Godown_ID = $Gid  and DOP < '$dor' group by Item_ID";
	echo $sql;

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    echo "<table><tr><th>Item ID</th><th>Item Name</th><th>Item Units</th><th>Item Unit Price</th></tr>";
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        echo "<tr><td>" . $row["Item_ID"]. "</td><td>" . $row["Item_Name"]. "</td><td>" . $row["Quantity"]. "</td><td>" . $row["Item_Unit_Price"] * $row["Quantity"]. "</td></tr>";
	    }
	    echo "</table>";
	} else {
	    echo "0 results";
	}

	$conn->close();
?>

<h3>Add items:</h3>
<form method='post'>
    <label>Item_ID</label>
    <input type='text' name='Iid' required>
    <label>Quantity</label>
    <input type='int' name='quant' required>
    <button type='submit' name='button3'>Add</button>
</form>

<?php
	if(isset($_POST['button3']))
	{
		$Iid = $_POST['Iid'];
		$quant = $_POST['quant'];

		$con = mysqli_connect("127.0.0.1","root","");
		mysqli_select_db($con, "supermarket");
		
		//Check quantity available
		$q0 = "SELECT Quantity FROM godown_item_details natural join item where Godown_ID = $Gid and Item_ID = $Iid";
		$result0 = mysqli_query($con, $q0);
		$qu = mysqli_fetch_row($result0)[0];

		//Check if restock already exists
		$q1 = "SELECT Quantity FROM restock_item_details natural join item where Restock_ID = $Rid and Item_ID = $Iid";
		$result1 = mysqli_query($con, $q1);
		$n1 = mysqli_num_rows($result1);
		

		//Check if item exists in showroom
		$q2 = "SELECT Quantity FROM showroom_item_details natural join item where Showroom_ID = $Rid and Item_ID = $Iid";
		$result2 = mysqli_query($con, $q2);
		$n2 = mysqli_num_rows($result2);

		if($qu >= $quant && $quant > 0)
		{
			$q0 = "Update `godown_item_details` set `Quantity` = `Quantity` - $quant where Godown_ID = $Gid and Item_ID = $Iid";
			if($n1 != 0)
			{
				$q1 = "Update `restock_item_details` set `Quantity` = `Quantity` + $quant where Restock_ID = $Rid and Item_ID = $Iid and `Quantity` + $quant >= 0";
			}
			else
			{
				$q1 = "INSERT INTO `restock_item_details` VALUES ($Rid, $Iid, $quant)";
			}
			if($n2 != 0)
			{
				$q2 = "Update `showroom_item_details` set `Quantity` = `Quantity` + $quant where Showroom_ID = $Sid and Item_ID = $Iid"; 
			}
			else if($quant > -1)
			{
					$q2 = "INSERT INTO `showroom_item_details` VALUES ($Sid, $Iid, $quant)";
			}


			if(mysqli_query($con, $q0) && mysqli_query($con, $q1) && mysqli_query($con, $q2))
			{
				echo "Purchase Added Successfully!!";
				header("location:editrestock.php?Rid=".$Rid."&Gid=".$Gid."&Sid=".$Sid);
			}
			else
			{
				echo "Restock cannot be added!! Check Item ID and Quantity";
			}
		}
		else
		{
			echo "Restock cannot be added!! Check Item ID and Quantity";
		}
	}

?>
