<?php
$db = new PDO("mysql:host=localhost;dbname=testdb", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$uUserName = $_GET["name"];
$uPassword = $_GET["password"];

function checkLastLogin($date) {
    if( strtotime("now") - strtotime($date) >= 300){
    	return true;
    }else{
    	return false;
    }
}

$stmt = $db->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
$stmt->bindValue(':username', $uUserName);
$stmt->bindValue(':password', $uPassword);
$stmt->execute();
if($user = $stmt->fetchObject()){
	if(intval($user->incorrectAttempts)>3){
		if(!checkLastLogin($user->lastAttempt)){
			echo "too many incorrect logins, try later";
			exit;
		}
	}
	$updStmt = $db->prepare("UPDATE users SET lastAttempt=:lastAttempt, incorrectAttempts=0 WHERE username=:username");
	$updStmt->bindValue(':lastAttempt',date('Y-m-d H:i:s'));
	$updStmt->bindValue(':username', $uUserName);
	$updStmt->execute();
}else{

	$updStmt = $db->prepare("UPDATE users SET lastAttempt=:lastAttempt, incorrectAttempts = incorrectAttempts+1 WHERE username=:username");
	$updStmt->bindValue(':lastAttempt',date('Y-m-d H:i:s'));
	$updStmt->bindValue(':username', $uUserName);
    $updStmt->execute();
	$userStmt = $db->prepare("SELECT * FROM users WHERE username=:username");
	$userStmt->bindValue(':username', $uUserName);
	$userStmt->execute();
	$userInfo = $userStmt->fetchObject();
	if(!checkLastLogin($userInfo->lastAttempt)){
			echo "too many incorrect logins, try later";
			exit;
		}
	var_dump($userInfo);
}

?>