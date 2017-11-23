<?php


$token = $_POST['token'];

if($token == $_SESSION['token'])
{
	//We good
}
else{
	echo "Failed";
	die();
}

?>