<?php
require_once('../include/db.php');
require_once('../include/functions.php');

if(hasAccess(7)){
	/*Get all the user data from the server*/
	$stmt = $conn->prepare('CALL GetUsersForAdminIndex()');
	$stmt->execute();
	/*Setup an array to hold all the user data*/
	$rows = array();

	$i = 0;
	while($users = $stmt->fetchObject()){

		/*Push each users data into the array*/
		$rows[] = $users;
	}
	/*Convert the array into a json object*/
	$jsonRows = json_encode($rows);
	/*Print out the user data, using htmlentities to prevent XSS*/
// echo $jsonRows;
	/*htmlentities returns a escaped string to the ajax request*/
	echo htmlentities($jsonRows);
} else
{
	/*Possible attack*/
	header('Location: ../../index.php');

	/*Log that this person is trying to get into the admin section somehow*/
}