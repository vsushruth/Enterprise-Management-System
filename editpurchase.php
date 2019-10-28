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
</style>
</head>
<body>
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
	    echo "<table class = 'table table-hover table-striped'><tr><th>Item ID</th><th>Item Name</th><th>Quantity</th><th>Price per unit</th><th>Total price</th></tr>";

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
	    echo "<table class = 'table table-hover table-striped'><tr><th>Item ID</th><th>Item Name</th><th>Item Units</th><th>Item Unit Price</th></tr>";
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
<div class = "container-fluid row padding" >
    <div class="col-lg-3 col-md-6 col-sm-6" >
        <h1 style = "padding-left: 15%"><br>Add Items : </h1>
    </div>

    <div class="col-lg-9 col-md-6 col-sm-6" >
		<form method='post'>
			<label><h5>Item_ID</h5></label>
			<br>
			<input type='text' name='Iid' required>
			<br><br>
			<label><h5>Quantity</h5></label>
			<br>
			<input type='int' name='quant' required
				style = "width: 80%;
				padding: 10px 20px;
				margin: 3px 10px;
				display: inline-block;
				border: 1px solid #ccc;
				border-radius: 4px;
				box-sizing: border-box;"
			>
			<br><br>
			<button type='submit' name='button3'>Add</button>
		</form>
	</div>
</div>
<?php
	if(isset($_POST['button3']))
	{
		$Iid = $_POST['Iid'];
		$quant = $_POST['quant'];
		if($quant > 0)
		{
			$q = "select Quantity from purchase_item_details where Item_ID = $Iid and Purchase_ID = $Pid";

			$con = mysqli_connect("127.0.0.1","root","");
			mysqli_select_db($con, "supermarket");
			
			$result = mysqli_query($con, $q);

			$n1 = mysqli_num_rows($result);
			$qu = -1;
			
			if($n1 != 0)
			{
				$qu = mysqli_fetch_row($result)[0];
				$q = "Update `purchase_item_details` set `Quantity` = `Quantity` + $quant where Purchase_ID = $Pid and Item_ID = $Iid and `Quantity` + $quant >= 0";
			}
			else
			{
				$q = "INSERT INTO `purchase_item_details` VALUES ($Pid, $Iid, $quant)";				
				// echo $q;
			}

			$q2 = "select Quantity from godown_item_details where Item_ID = $Iid and Godown_ID = $Gid";
			
			$result2 = mysqli_query($con, $q2);

			$n2 = mysqli_num_rows($result2);
			if($n2 != 0)
			{
				$qu = mysqli_fetch_row($result)[0];
				if($qu + $quant >= 0)
					$q1 = "Update `godown_item_details` set `Quantity` = `Quantity` + $quant where Godown_ID = $Gid and Item_ID = $Iid and `Quantity` + $quant >= 0";
			}
			else
			{
				$q1 = "INSERT INTO `godown_item_details` VALUES ($Gid, $Iid, $quant)";
				
				// echo $q;
			}




			if(mysqli_query($con, $q) && mysqli_query($con, $q1))
			{
				echo "Purchase Added Successfully!!";
				header("location:editpurchase.php?Pid=".$Pid."&Gid=".$Gid."&Sid=".$Sid);
			}
		}
		else
		{
			echo "Purchase cannot be added!! Check Item ID and Quantity";
		}
	}

?>
<br>
<center><h3><a href='home.php' style = "color : white; font-weight : bold; padding-left : 50px; text-decoration: underline">Back</a></h3></center>
<br><br><br>

</body>
</html>