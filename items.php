<?php
	session_start();

	if(!isset($_SESSION['Eid']))
		header('location:login.php');
	$Eid = $_SESSION['Eid'];
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
<a href='home.php'>Back</a>
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

if ($result->num_rows > 0) {
    echo "<table><tr><th>Item ID</th><th>Item Name</th><th>Item Units</th><th>Item Unit Price</th></tr>";
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


<h1>Add Item</h1>
<form method="post">
    <label>Name</label>
    <input type="text" name="name" required>
    <label>Units of Measurement</label>
    <input type="varchar" name="units" required>
	<label>Price per unit</label>
    <input type="double" name="price" required>
    <button type="submit" name="button2">Add</button>
</form>

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