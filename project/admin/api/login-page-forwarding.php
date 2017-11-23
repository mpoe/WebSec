<?php
//include('../include/db.php');

/*This file is used to forward users on to other parts of the website based on their access rights*/

$userAccessRight = $_SESSION['ar_id'] ;

//var_dump($_SESSION);

echo $userAccessRight;
if($userAccessRight == 7 || $userAccessRight == 9)
{
	/*For administrators*/
	/*Redirect the user to the admin section*/
	header('Location: ../index.php');
	// echo "admin";
} 
else if($userAccessRight = 1)
{
	/*For normal and unlogged users*/
	/*Redirect the user to the admin section*/
	header('Location: ../../feed.php');
	// echo "normal user";

	/*Log that this user is trying to get into the admin section somehow*/

}
else
{

	/*Possible attack*/
	header('Location: ../../index.php');
	// echo "unknown user";

	/*Log that this person is trying to get into the admin section somehow*/
}