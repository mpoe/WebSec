<?php
session_start();
include("../include/db.php");


	//Session token.

$uToAdd = $_POST['id'];
$uToAdd = htmlspecialchars($uToAdd, ENT_QUOTES, 'UTF-8');
$uFrom = $_SESSION['UserID'];


include("../include/token-validation.php");

$stmt = $conn->prepare("CALL CreateFriendReq(:reqto, :reqfrom)");
$stmt->bindValue(":reqto",$uToAdd);
$stmt->bindValue(":reqfrom",$uFrom);
$stmt->execute();

header('Location: ' . $_SESSION["org_referer"]);
?>