<?php
	session_start();

	if(!isset($_SESSION['Eid']))
		header('location:login.php');

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "supermarket";
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
<a href='purchase.php'>Back</a>
<?php
	echo "<h3>Items already added: </h3>";
	$Pid = $_GET['Pid'];
	$Gid = $_GET['Gid'];
	$Sid = $_GET['Sid'];
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

	echo "<h3>All items</h3>";

	$sql = "SELECT * FROM item";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    echo "<table><tr><th>Item ID</th><th>Item Name</th><th>Item Units</th><th>Item Unit Price</th></tr>";
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        echo "<tr><td>" . $row["Item_ID"]. "</td><td>" . $row["Item_Name"]. "</td><td>" . $row["Item_Units"]. "</td><td>" . $row["Item_Unit_Price"]. "</td></tr>";
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


		$q = "select Quantity from purchase_item_details where Item_ID = $Iid and Purchase_ID = $Pid";

		$con = mysqli_connect("127.0.0.1","root","");
		mysqli_select_db($con, "supermarket");
		
		$result = mysqli_query($con, $q);

		$n = mysqli_num_rows($result);
		$qu = -1;
		
		if($n != 0)
		{
			$qu = mysqli_fetch_row($result)[0];
			$q = "Update `purchase_item_details` set `Quantity` = `Quantity` + $quant where Purchase_ID = $Pid and Item_ID = $Iid and `Quantity` + $quant >= 0";
			if($qu + $quant >= 0)
				$q1 = "Update `godown_item_details` set `Quantity` = `Quantity` + $quant where Godown_ID = $Gid and Item_ID = $Iid and `Quantity` + $quant >= 0";
		}
		else if($quant > -1)
		{
			$q = "INSERT INTO `purchase_item_details` VALUES ($Pid, $Iid, $quant)";
			$q1 = "INSERT INTO `godown_item_details` VALUES ($Gid, $Iid, $quant)";
			
			// echo $q;
		}

		if(($n > 0 || $quant > -1) && mysqli_query($con, $q) && mysqli_query($con, $q1))
		{
			echo "Purchase Added Successfully!!";
			header("location:editpurchase.php?Pid=".$Pid."&Gid=".$Gid."&Sid=".$Sid);
		}
		else
		{
			echo "Purchase cannot be added!! Check Item ID and Quantity";
		}
	}

?>
