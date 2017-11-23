<?php

include("../include/db.php");
include ('upload-profile-image.php');



//get the data
$email = $_POST['email'];
//Should we check if passwords match here?
//Yeah I think we should, mark it down as validation (Jacobs task)
$password = $_POST['password1'];
$password2 = $_POST['password2'];
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ //
$fname = $_POST['fname'];
$lname = $_POST['lname'];
//Hardcoded for now
$avatarname = "Hardcoded";

$mobile = "1234-5678";
$files = $_FILES;

$profileimg = uploadProfileImage($files);
//Set the salt
$salt = mcrypt_create_iv(16,MCRYPT_DEV_URANDOM);
$salt = base64_encode($salt);

//Hash it
$hash = hash("sha256",$password.$salt);

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
?>