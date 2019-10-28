<?php
    session_start();

    if(!isset($_SESSION['Eid']))
        header('location:login.php');
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
<h1>All Showrooms</h1>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supermarket";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM showroom";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class = 'table table-hover table-striped'><tr><th>Showroom ID</th><th>Showroom Name</th><th>Showroom Location</th><th>Manager ID</th></tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Showroom_ID"]."<a href='showroom.php?Sid=".$row["Showroom_ID"]."'><button type='submit' name='submit1'>More</button></a></td><td>". $row["Showroom_Name"]. "</td><td>" . $row["Showroom_Location"]. "</td><td>" . $row["Manager_ID"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>


<h1>Add Showroom</h1>
<form method="post">
    <label>Name</label>
    <input type="text" name="name" required>
    <label>Location</label>
    <input type="text" name="loc" required>
    <label>Manager-ID</label>
    <select name="Mid">
    <?php
        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $sqlSelect="SELECT * FROM employee";
        $result = $mysqli-> query ($sqlSelect);
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        foreach ($rows as $row) {
            print "<option value='" . $row['Employee_ID'] . "'>" .$row['Employee_ID']."(". $row['Employee_Name'] . ")</option>";
        }
        $mysqli->close();
    ?>
    </select>
    <button type="submit" name="button2">Add</button>
</form>

<?php
    if(isset($_POST['button2']) && $_SESSION['Eid'] == 1)
    {
        $Mid = $_POST['Mid'];
        $name = $_POST['name'];
        $loc = $_POST['loc'];
        $q = "select * from showroom where Showroom_Name = '$name' and Showroom_Location = '$loc' and Manager_ID = $Mid";
        // echo $q;
        $con = mysqli_connect("127.0.0.1","root","");
        mysqli_select_db($con, "supermarket");
        
        $result = mysqli_query($con, $q);

        $n = mysqli_num_rows($result);

        if($n != 0)
        {
            echo "Showroom exists!!";
        }
        else
        {
            $q = "INSERT INTO `showroom`(`Showroom_Name`, `Showroom_Location`, `Manager_ID`) VALUES ('$name', '$loc', $Mid)";
            // echo $q;

            if(mysqli_query($con, $q))
            {
                echo "Showroom Added Successfully!!";
                header('location:showrooms.php');
            }
            else
            {
                echo "Showroom cannot be added!! Check Manager ID";
            }

        }
    }
    else if($_SESSION['Eid'] != 1)
    {
        echo "You are not permitted to add Showroom!!";
    }
?>

</body>
</html>