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

<div class = "container-fluid row padding" >
    <div class="col-lg-3 col-md-6 col-sm-6" >
        <h1 style = "padding-left: 15%"><br>Add Purchases : </h1>
    </div>

    <div class="col-lg-9 col-md-6 col-sm-6" >
		<form method="post">
			<br>
			<label><h5>Supplier ID</h5></label>
			<br>
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
			<br><br>
			<label><h5>Godown ID</h5></label>
			<br>
			<select name="Gid">
			<?php
				$mysqli = new mysqli($servername, $username, $password, $dbname);
				$sqlSelect="SELECT * FROM godown";
				$result = $mysqli-> query ($sqlSelect);
				while ($row = mysqli_fetch_array($result)) {
					$rows1[] = $row;
				}
				foreach ($rows1 as $row) {
					print "<option value='" . $row['Godown_ID'] . "'>" .$row['Godown_ID']."(". $row['Godown_Location'] . ")</option>";
					// echo $row['Godown_Location'];
				}
			?>
			</select>
			<br><br>
			<label><h5>Date of Purchase</h5></label>
			<br>
			<input type="Date" name="date">
			<br><br>
			<button type="submit" name="button1">Add</button>
		</form>
	</div>
</div>

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

<br>
<center><h3><a href='home.php' style = "color : white; font-weight : bold; padding-left : 50px; text-decoration: underline">Back</a></h3></center>
<br><br><br>

</body>
</html>