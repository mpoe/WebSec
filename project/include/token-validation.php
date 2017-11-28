<?php


$token = $_POST['token'];
$token = htmlspecialchars($token, ENT_QUOTES, 'UTF-8');

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