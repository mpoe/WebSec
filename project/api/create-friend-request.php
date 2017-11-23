<?php
	session_start();
	include("../include/db.php");


	//Session token.
	
	$uToAdd = $_POST['id'];
	$uFrom = $_SESSION['UserID'];

	
include("/include/token-validation.php");

	$stmt = $conn->prepare("CALL CreateFriendReq(:reqto, :reqfrom)");
	$stmt->bindValue(":reqto",$uToAdd);
	$stmt->bindValue(":reqfrom",$uFrom);
	$stmt->execute();
?>