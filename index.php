<?php
	session_start();
	unset($_SESSION["session"]);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Supermarket</title>
		<link rel="shortcut icon" href="img/reflux_logo.jpg"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
		<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

		<!--link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" /-->
		<link href="style.css" rel="stylesheet">
		<link rel="stylesheet" href="https://m.w3newbie.com/you-tube.css">

	</head>

	<body>

		<nav class = "navbar navbar-expand-md navbar-light bg-light sticky-top text-center" id="navigationbar">
			<div class = "container-fluid" >
				<a class = "navbar-brand" href = "#">
					<ul class="navbar-nav ml-auto">
						<!-- li class="nav-item active">
							<img id="logo" src="reflux_logo.png" style="width: 50px; height: 50px; float: left;">
						</li -->
						<li class="nav-item">
							<h1 style="color:black">Supermarket System</h1>
						</li>
					</ul>
				</a>
			</div>
		</nav>
		

		<div class="container-fluid padding">
			<div class = "row padding">

				<div class="col-lg-6 col-md-6 col-sm-6" >
					<img class = "image-index" src = "super1.jpg">
					<p><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
					Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				</div>
				
				<div class="col-lg-6 col-md-6 col-sm-6">
				
					<div class="tab">
						<button class="tablinks" onclick="openCity(event, 'Login')" id="defaultOpen">Login</button>
						<button class="tablinks" onclick="openCity(event, 'Register')">Register</button>
					</div>
	
					<div id="Login" class="tabcontent">
						<h1>Login</h1>
							<div>
								<form action="login.php" method="post">
									<label>Employee-ID</label>
									<input type="text" name="Eid" required>
									<br>
									<label>Password</label>
									<input type="password" name="pass" required>
									<br><br>
									<input type ="submit" value = "Submit">
								</form>
							</div>
					</div>

	
					<div id="Register" class="tabcontent">
						<h1>Registration</h1>
						<div>
							<form action="registration.php" method="post">
									<label>Name</label>
									<input type="text" name="name" required>
									<br><br>
									<label>Supervisor_ID</label>
									<input type="text" name="Sid">
									<br><br>
									<label>House Number</label>
									<input type="text" name="hno" required>
									<br><br>
									<label>Street</label>
									<input type="text" name="street" required>
									<br><br>
									<label>Pincode</label>
									<input type = "number" name="pincode" required>
									<br><br>
									<label>Password</label>
									<input type="password" name="pass" required>
									<br><br>
									<input type="submit"  name="but" value = "Submit">
							</form>
						</div>
					</div>
				</div>

			</div>
		</div>

		
		
		<script>

            function openCity(evt, cityName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(cityName).style.display = "block";
                evt.currentTarget.className += " active";
            }
            
            // Get the element with id="defaultOpen" and click on it
            document.getElementById("defaultOpen").click();
            
		</script>
		

	</body>
</html>