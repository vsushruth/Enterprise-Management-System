<?php

	include "head.php";
	session_start();

	if(!isset($_SESSION['Eid']) || $_SESSION['Eid'] != 1)
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
?>