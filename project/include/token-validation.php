<?php

//Get the token from the given form
$token = $_POST['token'];
//Sanitize the input
$token = htmlspecialchars($token, ENT_QUOTES, 'UTF-8');

//Check if the token matches the sessions token
if($token == $_SESSION['token'])
{
	//We good
}
else{
	echo "Failed";
	header('Location: ../index.php');
	die();
}

?>