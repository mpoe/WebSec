<?php

include("../include/db.php");
include ('upload-profile-image.php');
include ('sanitizers.php');

//get the data
$email = $_POST['email'];
//Should we check if passwords match here?
//Yeah I think we should, mark it down as validation (Jacobs task)
$password = $_POST['password1'];
$password2 = $_POST['password2'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$avatarname = $_POST['avatarname'];
$mobile = $_POST['phone'];
$files = $_FILES;

//Sanitize the registration input
$regSantized = registerSanitizer($email, $password, $fname, $lname, $avatarname, $avatarname,$mobile);
//If the sanitizer removed any strange text exit the sign-up process and forward the user to the index page
if($regSantized['dataissafe'] == false ){
	
	//Forward the user to the home page, alert the user that we have detected xss tampering (This may demotivate and annoy the attack, forcing them to give up)
	header('Location: ../index.php');
	exit;
} 

//Set the salt
$salt = mcrypt_create_iv(16,MCRYPT_DEV_URANDOM);
$salt = base64_encode($salt);

//Hash it
$hash = hash("sha256",$password.$salt);

// Checks for input fields being empty
if(empty($email) || empty($avatarname) || empty($fname) || empty($lname) || empty($mobile) || empty($password) || empty($password2)){
	echo 'Make sure to fill out every input! <br>';
}
else{

    //Checks if email is correct format
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		echo 'Invalid email format';
	}
	else{

       //Checks if names are valid
		if(!preg_match('/^[a-zA-Z ]*$/', $fname) || !preg_match('/^[a-zA-Z ]*$/', $lname)){
			echo'Invalid name format!';
		} 
		else{
            // Checks phone number format
			if(!preg_match('/^(([1-9]\d{0,2}[ ])|([0]\d{1,3}[-]))((\d{2}([ ]\d{2}){2})|(\d{3}([ ]\d{3})*([ ]\d{2})+))$/i', $mobile)){
				echo'Invalid phone number';
			}
			else{
                // Checks password format
				if(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[=?!@&$#^\-])[A-Za-z0-9=?!@&$#^\-]{8,}$/', $password)){
					echo'Invalid password';
				}
				else{

              		//Checks if password fields are the same
					if($password == $password2){

						//Upload the users profile image
						// - returns the images new name
						//If the user is not uploading a new profile image
						if(!isset($_FILES["profileimage"]["name"])){
							$profileimage = 'person.png';
						}else{
							$profileimg = uploadProfileImage($files);
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

						try{
							$stmt->execute();
							echo '{"status":"success"}';
						}  catch (PDOException $e) {
							if ($e->errorInfo[1] == 1062) {
      							// duplicate entry, do something else
								echo "<p>Email address already exists in the system</p>";
							} else {
      						// an error other than duplicate entry occurred
							}
						}
					}
					else
					{
						echo 'Both password field should be the same! <br>';
					}
				}

			}

		}


	}      

}





?>