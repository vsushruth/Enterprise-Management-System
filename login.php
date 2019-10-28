<?php
	session_start();

	$con = mysqli_connect("127.0.0.1","root","");
	mysqli_select_db($con, "supermarket");

	$Eid = $_POST['Eid'];
	$pass = $_POST['pass'];
	
	$pass = hash('sha1', $pass);
	
	$q = "select * from employee where Employee_ID = '$Eid' and Password = '$pass'";

	$result = mysqli_query($con, $q);

	$n = mysqli_num_rows($result);

	if($n == 1)
	{
		$_SESSION['Eid'] = $Eid;
		header('location:home.php');
	}
	else
	{
		header('location:index.php');
	}
?>