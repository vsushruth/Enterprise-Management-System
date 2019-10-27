<?php
	session_start();

	if(!isset($_SESSION['Eid']))
		header('location:login.php');
	$Gid = $_GET['Gid'];
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

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supermarket";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h1>Items in Godown</h1>";


$sql = "SELECT * FROM godown_item_details natural join item where Godown_ID = $Gid";
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



echo "<h1>Purchase history</h1>";


$sql = "SELECT * FROM purchase natural join purchase_item_details natural join godown natural join item natural join supplier where Godown_ID = $Gid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>Item ID</th><th>Item Name</th><th>Supplier ID</th><th>Supplier Name</th><th>Quantity</th><th>Price per unit</th><th>Total price</th></tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Item_ID"]. "</td><td>" . $row["Item_Name"]. "</td><td>" . $row["Supplier_ID"]. "</td><td>" . $row["Supplier_Name"]. "</td><td>" . $row["Quantity"] . "</td><td>Rs." . $row["Item_Unit_Price"] . " per " . $row["Item_Units"] ."</td><td>" . $row["Item_Unit_Price"] * $row["Quantity"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}



echo "<h1>Restock history</h1>";


$sql = "SELECT * FROM restock natural join restock_item_details natural join godown natural join item natural join showroom where Godown_ID = $Gid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>Item ID</th><th>Item Name</th><th>Showroom ID</th><th>Showroom Name</th><th>Quantity</th><th>Price per unit</th><th>Total price</th></tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Item_ID"]. "</td><td>" . $row["Item_Name"]. "</td><td>" . $row["Showroom_ID"]. "</td><td>" . $row["Showroom_Name"]. "</td><td>" . $row["Quantity"] . "</td><td>Rs." . $row["Item_Unit_Price"] . " per " . $row["Item_Units"] ."</td><td>" . $row["Item_Unit_Price"] * $row["Quantity"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}







$conn->close();
?>

