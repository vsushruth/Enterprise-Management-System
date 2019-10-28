<?php

	include "head.php";
	session_start();

	if(!isset($_SESSION['Eid']))
		header('location:home.php');

	$Eid = $_SESSION['Eid'];

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "supermarket";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}


	echo "<h1><center>Employees under you</center></h1>";
	$sql = "SELECT * FROM employee natural join employee_contacts where Supervisor_ID = $Eid";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    echo "<table class = 'table table-hover table-striped'><tr><th>Employee ID</th><th>Employee Name</th><th>Employee Contact</th></tr>";

	    while($row = $result->fetch_assoc()) {
	        echo "<tr><td>" . $row["Employee_ID"]. "</td><td>" . $row["Employee_Name"]. "</td><td>" . $row["Contact"]. "</td></tr>";
	    }
	    echo "</table>";
	} else {
	    echo "0 results";
	}
	if(isset($_POST['button2']))
    {
        $num = $_POST['number'];
	    if(strlen($num) < 10)
		{
			echo "Phone number must be 10 digits";
		}
		else
		{
	        $con = mysqli_connect("127.0.0.1","root","");
	        mysqli_select_db($con, "supermarket");

	        $q = "select * from employee_contacts where Employee_ID = $Eid and Contact = $num";
	        
	        $result = mysqli_query($con, $q);

	        $n = mysqli_num_rows($result);

	        if($n != 0)
	        {
	            echo "Number exists!!";
	        }
	        else
	        {
	            $q = "INSERT INTO `employee_contacts` VALUES ($Eid, $num)";
	            // echo $q
	        }

            if(mysqli_query($con, $q))
            {
                echo "Item Added Successfully!!";
                header('location:admin.php');
            }
            else
            {
                echo "Item cannot be added!! Check Details entered";
            }
        }
    }

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}


	echo "<h1><center><br>Your contact details</center></h1>";
	$sql = "SELECT * FROM employee natural join employee_contacts where Employee_ID = $Eid";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    echo "<table class = 'table table-hover table-striped'><tr><th>Employee ID</th><th>Employee Address</th><th>Employee Contact</th></tr>";

	    while($row = $result->fetch_assoc()) {
	        echo "<tr><td>" . $row["Employee_ID"]. "</td><td>" . $row["Home_Number"].$row["Street"].$row["Pincode"]. "</td><td>" . $row["Contact"]. "</td></tr>";
	    }
	    echo "</table>";
	} else {
	    echo "0 results";
	}
?>
<br>
<br>
<div class = "container-fluid row padding">
    <div class="col-lg-3 col-md-6 col-sm-6" >    
        <h1 style = "padding-left: 20%"><br>Add Phone Number : </h1>
    </div>
    <div class="col-lg-9 col-md-6 col-sm-6" >
        <form method="post">
            <label>Number</label>
            <br>
            <input type="varchar" name="number" required>
            <br><br>
            <input type="submit" name="button2" value = "Add">
        </form>
    </div>
</div>