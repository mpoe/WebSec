<?php
/*Start a new session*/
require_once("../include/db.php");
require_once('./update-profile-image.php');

// var_dump($_POST);
// var_dump($_FILES);

//get the data
$uid = $_POST['userid'];
$email = $_POST['email'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$avatarname = $_POST['aname'];
$profileimg = '';
$mobile = $_POST['mobile'];
$file = $_FILES;
//echo "<p>" . $_FILES["profileimage"]["name"] . "</p>";

//If the user is not uploading a new profile image
if(!isset($_FILES["profileimage"]["name"])){
	//echo "Not uploading an image";

	//Remember that the password is the hash.
	$stmt = $conn->prepare("CALL UpdateUser(:uid, :email, :fname, :lname, :avatarname, :mobile)");
	$stmt->bindValue(":uid", $uid);
	$stmt->bindValue(":email", $email);
	$stmt->bindValue(":fname", $fname);
	$stmt->bindValue(":lname", $lname);
	$stmt->bindValue(":avatarname", $avatarname);
	$stmt->bindValue(":mobile", $mobile);
	$stmt->execute();
//else if the user is uploading a new profile image
}else{
	//echo "Uploading an image";
	//get profile image name
	$profileimg = uploadProfileImage($_FILES);

	//Remember that the password is the hash.
	$stmt = $conn->prepare("CALL UpdateUserAndImage(:uid, :email, :fname, :lname, :avatarname, :profileimg, :mobile)");
	$stmt->bindValue(":uid", $uid);
	$stmt->bindValue(":email", $email);
	$stmt->bindValue(":fname", $fname);
	$stmt->bindValue(":lname", $lname);
	$stmt->bindValue(":avatarname", $avatarname);
	$stmt->bindValue(":profileimg", $profileimg);
	$stmt->bindValue(":mobile", $mobile);
	$stmt->execute();
}

