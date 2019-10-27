
<?php
	session_start();

	if(!isset($_SESSION['Eid']))
		header('location:login.php');
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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM supplier";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>Supplier ID</th><th>Supplier Name</th><th>Supplier Contact</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Supplier_ID"]. "</td><td>" . $row["Supplier_Name"]. "</td><td>" . $row["Supplier_Contact"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>


<h1>Add Supplier</h1>
<form method="post">
    <label>Name</label>
    <input type="text" name="name" required>
    <label>Contact</label>
    <input type="varchar" name="contact" required>
    <button type="submit" name="button2">Add</button>
</form>

<?php
    if(isset($_POST['button2']))
    {
        $name = $_POST['name'];
        $contact = $_POST['contact'];
        $q = "select * from supplier where Supplier_Name = '$name' and Supplier_Contact = '$contact'";
        // echo $q;
        $con = mysqli_connect("127.0.0.1","root","");
        mysqli_select_db($con, "supermarket");
        
        $result = mysqli_query($con, $q);

        $n = mysqli_num_rows($result);

        if($n != 0)
        {
            echo "Supplier exists!!";
        }
        else
        {
            $q = "INSERT INTO `supplier`(`Supplier_Name`, `Supplier_Contact`) VALUES ('$name', '$contact')";
            echo $q;

            if(mysqli_query($con, $q))
            {
                echo "Supplier Added Successfully!!";
                header('location:suppliers.php');
            }
            else
            {
                echo "Supplier cannot be added!! Check Details entered";
            }

        }
    }
?>

</body>
</html>