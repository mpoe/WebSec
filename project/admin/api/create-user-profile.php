<?php
require_once('../include/db.php');
require_once('./upload-profile-image.php');
require_once('../include/functions.php');

if(hasAccess(7)){
//get the data
	$email = $_POST['email'];
//Should we check if passwords match here?
	$password = $_POST['password1'];
	$password2 = $_POST['password2'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$avatarname = $_POST['aname'];
	$profileimg = '';
	$mobile = $_POST['mobile'];
	$file = $_FILES;

//Set the salt
	$salt = mcrypt_create_iv(16,MCRYPT_DEV_URANDOM);
	$salt = base64_encode($salt);

//Hash it
	$hash = hash("sha256",$password.$salt);

//Upload the users profile image
// - returns the images new name
//If the user is not uploading a new profile image
	if(!isset($_FILES["profileimage"]["name"])){
		$profileimage = 'person.png';
	} else{
		$profileimg = uploadProfileImage($file);
	}

//Remember that the password is the hash.
	$stmt = $conn->prepare("CALL CreateSocialUser(:email, :pass, :salt, :fname, :lname, :avatarname, :profileimg, :mobile)");
	$stmt->bindValue(":email", $email);
	$stmt->bindValue(":pass", $hash);
	$stmt->bindValue(":salt", $salt);
	$stmt->bindValue(":fname", $fname);
	$stmt->bindValue(":lname", $lname);
	$stmt->bindValue(":avatarname", $avatarname);
	$stmt->bindValue(":profileimg", $profileimg);
	$stmt->bindValue(":mobile", $mobile);
	$stmt->execute();






	echo '{"status":"success"}';
}
else
{
	/*Possible attack*/
	header('Location: ../../index.php');

	/*Log that this person is trying to get into the admin section somehow*/
}
?>