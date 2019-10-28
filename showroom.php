<?php
	session_start();

	if(!isset($_SESSION['Eid']))
		header('location:login.php');
	$Sid = $_GET['Sid'];
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

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supermarket";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h1><center>Items in Showroom</center></h1>";


$sql = "SELECT * FROM showroom_item_details natural join item where Showroom_ID = $Sid";
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



echo "<h1><center>Sale history</center></h1>";


$sql = "SELECT * FROM sale natural join sale_item_details natural join showroom natural join item natural join customer where Showroom_ID = $Sid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class = 'table table-hover table-striped'><tr><th>Item ID</th><th>Item Name</th><th>Customer ID</th><th>Customer Name</th><th>Quantity</th><th>Price per unit</th><th>Total price</th></tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Item_ID"]. "</td><td>" . $row["Item_Name"]. "</td><td>" . $row["Customer_ID"]. "</td><td>" . $row["Customer_Name"]. "</td><td>" . $row["Quantity"] . "</td><td>Rs." . $row["Item_Unit_Price"] . " per " . $row["Item_Units"] ."</td><td>" . $row["Item_Unit_Price"] * $row["Quantity"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}



echo "<h1><center>Restock history</center></h1>";


$sql = "SELECT * FROM restock natural join restock_item_details natural join item where Showroom_ID = $Sid";
// echo $sql;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class = 'table table-hover table-striped'><tr><th>Item ID</th><th>Item Name</th><th>Godown ID</th><th>Quantity</th><th>Price per unit</th><th>Total price</th></tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Item_ID"]. "</td><td>" . $row["Item_Name"]. "</td><td>" . $row["Godown_ID"]. "</td><td>" . $row["Quantity"] . "</td><td>Rs." . $row["Item_Unit_Price"] . " per " . $row["Item_Units"] ."</td><td>" . $row["Item_Unit_Price"] * $row["Quantity"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}


echo "<h1><center>Employee details</center></h1>";


$sql = "SELECT * FROM showroom_employee_details natural join employee where Showroom_ID = $Sid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class = 'table table-hover table-striped'><tr><th>Employee ID</th><th>Employee Name</th></tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Employee_ID"]. "</td><td>" . $row["Employee_Name"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}






$conn->close();
?>

