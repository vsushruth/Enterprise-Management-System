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
<a href='restock.php'>Back</a>
<?php
	echo "<h3>Items already added: </h3>";
	$Rid = $_GET['Rid'];
	$Gid = $_GET['Gid'];
	$Sid = $_GET['Sid'];
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM restock_item_details natural join item where Restock_ID = $Rid";

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

	$sql = "SELECT * FROM godown_item_details natural join item where Godown_ID = $Gid";

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


		$q = "SELECT Quantity FROM restock_item_details natural join item where Restock_ID = $Rid and Item_ID = $Iid";

		$con = mysqli_connect("127.0.0.1","root","");
		mysqli_select_db($con, "supermarket");
		
		$result = mysqli_query($con, $q);

		$n = mysqli_num_rows($result);



		
		$q1 = "SELECT Quantity FROM godown_item_details natural join item where Godown_ID = $Gid and Item_ID = $Iid";

		$result1 = mysqli_query($con, $q1);

		$qu = mysqli_fetch_row($result1)[0];
		// echo $qu;

		$q2 = "SELECT Quantity FROM restock_item_details natural join item where Restock_ID = $Rid and Item_ID = $Iid";

		$result2 = mysqli_query($con, $q);

		$n1 = mysqli_num_rows($result);
		if($qu >= $quant && $quant > 0)
		{
			if($n != 0)
			{

				$qu = mysqli_fetch_row($result)[0];
				$q = "Update `restock_item_details` set `Quantity` = `Quantity` + $quant where Restock_ID = $Rid and Item_ID = $Iid and `Quantity` + $quant >= 0";
				$q1 = "Update `godown_item_details` set `Quantity` = `Quantity` - $quant where Godown_ID = $Gid and Item_ID = $Iid";
				$q2 = "Update `showroom_item_details` set `Quantity` = `Quantity` + $quant where Showroom_ID = $Sid and Item_ID = $Iid"; 
			}
			else if($quant > -1)
			{
				$q = "INSERT INTO `restock_item_details` VALUES ($Rid, $Iid, $quant)";
				$q1 = "Update `godown_item_details` set `Quantity` = `Quantity` - $quant where Godown_ID = $Gid and Item_ID = $Iid";
				if()
					$q2 = "INSERT INTO `showroom_item_details` VALUES ($Sid, $Iid, $quant)";
				else
					$q2 = "Update `showroom_item_details` set `Quantity` = `Quantity` + $quant where Showroom_ID = $Sid and Item_ID = $Iid"; 
				// echo $q;
			}

			if(($n > 0 || $quant > -1) && mysqli_query($con, $q) && mysqli_query($con, $q1) && mysqli_query($con, $q2))
			{
				echo "Purchase Added Successfully!!";
				header("location:editrestock.php?Rid=".$Rid."&Gid=".$Gid."&Sid=".$Sid);
			}
			else
			{
				echo "asdas";
			}
		}
		else
		{
			echo "Restock cannot be added!! Check Item ID and Quantity";
		}
	}

?>
