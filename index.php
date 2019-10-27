<?php
	session_start();
	unset($_SESSION["session"]);
?>

<h1>Login</h1>

<form action="login.php" method="post">
	<label>Employee-ID</label>
	<input type="text" name="Eid" required>
	<label>Password</label>
	<input type="Password" name="pass" required>
	<button type="submit">Submit</button>
</form>

<h1>Registration</h1>

<form action="registration.php" method="post">
	<label>Name</label>
	<input type="text" name="name" required>
	<label>Supervisor_ID</label>
	<input type="text" name="Sid">
	<label>House Number</label>
	<input type="text" name="hno" required>
	<label>Street</label>
	<input type="text" name="street" required>
	<label>Pincode</label>
	<input type="Number" name="pincode" required>
	<br>
	<label>Password</label>
	<input type="Password" name="pass" required>
	<button type="submit" name="but">Submit</button>
</form>