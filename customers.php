<?php
	session_start();

	if(!isset($_SESSION['Eid']))
		header('location:login.php');
	$Eid = $_SESSION['Eid'];
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

$sql = "SELECT * FROM customer";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class = 'table table-hover table-striped'><tr><th>Customer ID</th><th>Customer Name</th><th>Sales Exec ID</th><th>Contact Number</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Customer_ID"]. "</td><td>" . $row["Customer_Name"]. "</td><td>" . $row["Sales_Exec_ID"]. "</td><td>" . $row["Contact_Number"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>


<h1>Add Customer</h1>
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
        $q = "select * from customer where Customer_Name = '$name' and Contact_Number = '$contact'";
        // echo $q;
        $con = mysqli_connect("127.0.0.1","root","");
        mysqli_select_db($con, "supermarket");
        
        $result = mysqli_query($con, $q);

        $n = mysqli_num_rows($result);

        if($n != 0)
        {
            echo "Customer exists!!";
        }
        else
        {
            $q = "INSERT INTO `customer`(`Customer_Name`, `Contact_Number`, `Sales_Exec_ID`) VALUES ('$name', '$contact', '$Eid')";
            echo $q;

            if(mysqli_query($con, $q))
            {
                echo "Customer Added Successfully!!";
                header('location:customers.php');
            }
            else
            {
                echo "Customer cannot be added!! Check Details entered";
            }

        }
    }
?>


</body>
</html>