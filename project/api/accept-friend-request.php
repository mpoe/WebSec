<?php
	session_start();
	include("../include/db.php");
	include("include/token-validation.php");
	$curUser = $_SESSION['UserID'];
	$requestedFromUser = $_GET['requester-id'];

	$stmt = $conn->prepare("UPDATE contacts SET reqstatusid = '5' WHERE contacts.requestedto = :cuid AND contacts.requestedfrom = :ruid");
	$stmt->bindValue(":cuid", $curUser );
	$stmt->bindValue(":ruid", $requestedFromUser );
	$stmt->execute();

	header('Location: ' . $_SESSION["org_referer"]);
	

?>