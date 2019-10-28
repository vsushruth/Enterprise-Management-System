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


<div class = "container-fluid row padding" >
    <div class="col-lg-3 col-md-6 col-sm-6" >    
        <h3 style = "padding-left: 20%"><br>Add Employees : </h3>
    </div>
    <div class="col-lg-9 col-md-6 col-sm-6" >
        <form method="post">
            <label>Employee- ID</label>
            <br>
            <select name="id">
            <?php
                $mysqli = new mysqli($servername, $username, $password, $dbname);
                $sqlSelect="SELECT * FROM employee";
                $result = $mysqli-> query ($sqlSelect);
                while ($row = mysqli_fetch_array($result)) {
                    $rows1[] = $row;
                }
                foreach ($rows1 as $row) {
                    print "<option value='" . $row['Employee_ID'] . "'>" .$row['Employee_ID']."(". $row['Employee_Name'] . ")</option>";
                }
            ?>
            </select>
            <button type="submit" name="button1">Add</button>
        </form>
    </div>
</div>
<br>
<?php
    if(isset($_POST['button1']))
    {
        $id = $_POST['id'];
        
        $con = mysqli_connect("127.0.0.1","root","");
        mysqli_select_db($con, "supermarket");

        $q = "select * from showroom_employee_details where Showroom_ID = $Sid and Employee_ID = $id";
        
        $result = mysqli_query($con, $q);

        $n = mysqli_num_rows($result);

        if($n != 0)
        {
            echo "Employee exists!!";
        }
        else
        {
            $q = "INSERT INTO `showroom_employee_details` VALUES ('$Sid', '$id')";
            echo $q;

            if(mysqli_query($con, $q))
            {
                echo "Employee Added Successfully!!";
                header("location:showroom.php?Sid=".$Sid);
            }
            else
            {
                echo "Employee cannot be added!! Check Details entered";
            }

        }
    }
?>
