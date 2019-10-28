<?php
	session_start();

	//if(!isset($_SESSION['Eid']))
	//	header('location:login.php');
	//$Eid = $_SESSION['Eid'];
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
<?php include "head.php"; ?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supermarket";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM item";
$result = $conn->query($sql);

echo "<h1><center>All Items</center></h1>";
if ($result->num_rows > 0) {
    echo "<table class = 'table table-hover table-striped' ><tr><th>Item ID</th><th>Item Name</th><th>Item Units</th><th>Item Unit Price</th></tr>";
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
        <h1 style = "padding-left: 20%"><br>Add Items : </h1>
    </div>
    <div class="col-lg-9 col-md-6 col-sm-6" >
        <form method="post">
            <label>Name</label>
            <input type="text" name="name" required>
            <br><br>
            <label>Units of Measurement</label>
            <input type="varchar" name="units" required>
            <br><br>
            <label>Price per unit</label>
            <input type="double" name="price" required 
                style = "width: 95%;
                padding: 10px 20px;
                margin: 3px 10px;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;"
            >
            <br><br>
            <input type="submit" name="button2" value = "Add">
        </form>
    </div>
</div>
<br><br>
<center><h3><a href='home.php' style = "color : white; font-weight : bold; padding-left : 50px; text-decoration: underline">Back</a></h3></center>

<?php
    if(isset($_POST['button2']))
    {
        $name = $_POST['name'];
        $units = $_POST['units'];
        $price = $_POST['price'];
        $q = "select * from item where Item_Name = '$name' and Item_Unit_Price = '$price' and Item_Units = '$units'";
        // echo $q;
        $con = mysqli_connect("127.0.0.1","root","");
        mysqli_select_db($con, "supermarket");
        
        $result = mysqli_query($con, $q);

        $n = mysqli_num_rows($result);

        if($n != 0)
        {
            echo "Item exists!!";
        }
        else
        {
            $q = "INSERT INTO `item`(`Item_Name`, `Item_Units`, `Item_Unit_Price`) VALUES ('$name', '$units', '$price')";
            echo $q;

            if(mysqli_query($con, $q))
            {
                echo "Item Added Successfully!!";
                header('location:items.php');
            }
            else
            {
                echo "Item cannot be added!! Check Details entered";
            }

        }
    }
?>


</body>
</html>