<?php

require_once('./include/db.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- IMPORTED FONTAWESOME -->
	<link rel="stylesheet" type="text/css" href="dist/font-awesome/css/font-awesome.min.css">  
	<!-- IMPORTED CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/user-wall.css">
	<link rel="stylesheet" type="text/css" href="css/user-profile.css">

	<link rel="icon" type="image/png" href="./img/favicon.png" />

</head>
<body>

	<div class="TopBar">
		<div class="TopBar_Logo">Avatar Connect</div>
		<div class="TopBar_Greet">Hello <?php echo $_SESSION['fname'];?></div>

		<!-- <form class=" logout_form"> 
			<button class="Login_Btn logout_btn">Logout</button>
		</form> -->

		<form class="TopBar_Form"> <!-- Needs form information -->
			<button class="Login_Btn">Search</button>
			<input class="TopBar_Username"  placeholder="Search">
		</form>

	</div>

	<div id="section-administrator" class="section" style="display:flex;">

		