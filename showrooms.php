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

<br><br>
<h1><center>All Showrooms</center></h1>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supermarket";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM showroom join employee on showroom.Manager_ID = employee.Employee_ID order by Showroom_ID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class = 'table table-hover table-striped'><tr><th>Showroom ID</th><th>Showroom Name</th><th>Showroom Location</th><th>Manager ID</th></tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Showroom_ID"]."<a href='showroom.php?Sid=".$row["Showroom_ID"]."'><img src='1.png' style='width:30px; height30px; margin-left:20%;'></a></td><td>". $row["Showroom_Name"]. "</td><td>" . $row["Showroom_Location"]. "</td><td>" . $row["Employee_Name"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>

<div class = "container-fluid row padding" >
    <div class="col-lg-4 col-md-6 col-sm-6" >
        <h1 style = "padding-left: 15%; padding-top:10%"><br>Add Showrooms : </h1>
    </div>

    <div class="col-lg-8 col-md-6 col-sm-6" >
        <form method="post">
            <label><h5>Name</h5></label>
            <br>
            <input type="text" name="name" required>
            <br><br>
            <label><h5>Location</h5></label>
            <br>
            <input type="text" name="loc" required>
            
            <br><br>
            <label><h5>Manager-ID</h5></label>
            <br>
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
            <br><br>
            <button type="submit" name="button2">Add</button>
        </form>
    </div>
</div>

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


<br>
<center><h3><a href='home.php' style = "color : white; font-weight : bold; padding-left : 50px; text-decoration: underline">Back</a></h3></center>
<br><br><br>


</body>
</html>