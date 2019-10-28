<?php
	session_start();

	if(!isset($_SESSION['Eid']))
		header('location:login.php');
?>

<?php include "head.php"; ?>
<!-- <a href="logout.php">LOGOUT</a> -->

<br><br>
<center><h1> Welcome <?php echo $_SESSION['Eid'] ?></h1></center>
<br>
<img src = "superExterior.jpg" style = " display: block; margin-left: auto; margin-right: auto; width: 50%;" >


<!-- <a href="summary.php">Summary</a> -->

<!-- <a href="suppliers.php">Suppliers</a>

<a href="purchase.php">Purchase</a>

<a href="godowns.php">Godowns</a>

<a href="restock.php">Restock</a>

<a href="showrooms.php">Showrooms</a>

<a href="sale.php">Sale</a>

<a href="customers.php">Customers</a>

<br><br><a href="items.php">Items</a> -->