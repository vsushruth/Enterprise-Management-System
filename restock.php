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
    <div class="col-lg-4 col-md-6 col-sm-6" >
        <h1 style = "padding-left: 15%"><br>Restock : </h1>
    </div>

    <div class="col-lg-8 col-md-6 col-sm-6" >
		<form method="post">
			<label><h5>Showroom ID</h5></label>
			<br>
			<select name="Sid">
			<?php
				$mysqli = new mysqli($servername, $username, $password, $dbname);
				$sqlSelect="SELECT * FROM showroom";
				$result = $mysqli-> query ($sqlSelect);
				while ($row = mysqli_fetch_array($result)) {
					$rows[] = $row;
				}
				foreach ($rows as $row) {
					print "<option value='" . $row['Showroom_ID'] . "'>" .$row['Showroom_ID']."(". $row['Showroom_Name'] . ")</option>";
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
				}
			?>
			</select>
			<br><br>
			<label><h5>Date of Restock</h5></label>
			<br>
			<input type="Date" name="date">
			<br><br>
			<button type="submit" name="button1">Add</button>
		</form>
	</div>
</div>

<?php
	function isGodownManager($mid, $gid)
	{
		$q = "select * from godown where Godown_ID = $gid and Manager_ID = $mid";

		$con = mysqli_connect("127.0.0.1","root","");
		mysqli_select_db($con, "supermarket");
		
		$result = mysqli_query($con, $q);

		$n = mysqli_num_rows($result);
		return $n > 0;
	}

	function isShowroomManager($mid, $sid)
	{
		$q = "select * from showroom where Showroom_ID = $sid and Manager_ID = $mid";

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
		if(isGodownManager($_SESSION['Eid'], $Gid) || isShowroomManager($_SESSION['Eid'], $Sid))
		{
			$q = "select * from restock where Godown_ID = '$Gid' and Showroom_ID = '$Sid' and DOR = '$date'";

			$con = mysqli_connect("127.0.0.1","root","");
			mysqli_select_db($con, "supermarket");
			
			$result = mysqli_query($con, $q);

			$n = mysqli_num_rows($result);
			// echo $n."<br><br>";

			if($n != 0)
			{

				$q = "select Restock_ID from restock where Godown_ID = '$Gid' and Showroom_ID = '$Sid' and DOR = '$date' limit 1";
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
				$sql = "SELECT * FROM restock_item_details natural join item where Restock_ID = $Pid";

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


			}
			else
			{
				$q = "INSERT INTO `restock`(`Godown_ID`, `Showroom_ID`, `DOR`) VALUES ($Gid, $Sid, '$date')";
				// echo $q;

				if(mysqli_query($con, $q))
				{
					echo "Restock Added Successfully!!";
				}
				else
				{
					echo "Restock cannot be added!! Check Details again";
				}
			}
			$q = "select Restock_ID from restock where Godown_ID = '$Gid' and Showroom_ID = '$Sid' and DOR = '$date' limit 1";
			$result = mysqli_query($con, $q);
			$Rid = mysqli_fetch_row($result)[0];
			echo "<br><br<b><center>Restock exists!! Restock id is : $Rid</center></b><br><br>";
			echo "<a href='editrestock.php?Rid=".$Rid."&Gid=".$Gid."&dor=".$date."&Sid=".$Sid."''>Edit this restock</a><br><br>";
		}
		else
		{
			echo "<center>You are not permitted to add Restock!!</center>";
		}
	}

	
?>


<br>
<center><h3><a href='home.php' style = "color : white; font-weight : bold; padding-left : 50px; text-decoration: underline">Back</a></h3></center>
<br><br><br>

</body>
</html>