<?php
/**************************************************/
/*** Register sanitizer */
function registerSanitizer($email, $pass1, $pass2, $fname, $lname, $aname, $mobile){
	$dataIsSafe = false;

    //Create a placeholder for the credentials
	$sanitizedRegDetails = [];
	//Sanitize the variables
	$email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);
	$pass1_sanitized = filter_var($pass1, FILTER_SANITIZE_STRING);
	$pass2_sanitized = filter_var($pass2, FILTER_SANITIZE_STRING);
	$fname_sanitized = filter_var($fname, FILTER_SANITIZE_STRING);
	$lname_sanitized = filter_var($lname, FILTER_SANITIZE_STRING);
	$aname_sanitized = filter_var($aname, FILTER_SANITIZE_STRING);
	$mobile_sanitized = filter_var($mobile, FILTER_SANITIZE_STRING);

	//Compare the strings to see if there were any tags that got removed
	$emailTampered = compareSanitizedStr($email, $email_sanitized);
	$pass1Tampered = compareSanitizedStr($pass1, $pass1_sanitized);
	$pass2Tampered = compareSanitizedStr($pass2, $pass2_sanitized);
	$fnameTampered = compareSanitizedStr($fname, $fname_sanitized);
	$lnameTampered = compareSanitizedStr($lname, $lname_sanitized);
	$anameTampered = compareSanitizedStr($aname, $aname_sanitized);
	$mobileTampered = compareSanitizedStr($mobile, $mobile_sanitized);

	//If there were tags in any of the strings, return false on dataIsSafe
	if(($emailTampered == false)|| ($pass1Tampered == false) || ($pass2Tampered == false) || ($fnameTampered == false) || ($lnameTampered == false) || ($anameTampered == false) || ($mobileTampered == false)) {
		//echo "<p>data is not safe</p>";
		$dataIsSafe = false;
	}  else{
		//echo "<p>data is safe</p>";
		$dataIsSafe = true;
	}

    //Push sanitized variables into an array that can be used later
	$sanitizedRegDetails['email'] = 	$email_sanitized;
	$sanitizedRegDetails['pass1'] = 	$pass1_sanitized;
	$sanitizedRegDetails['pass2'] = 	$pass2_sanitized;
	$sanitizedRegDetails['fname'] = 	$fname_sanitized;
	$sanitizedRegDetails['lname'] = 	$lname_sanitized;
	$sanitizedRegDetails['aname'] = 	$aname_sanitized;
	$sanitizedRegDetails['mobile'] = 	$mobile_sanitized;
	$sanitizedRegDetails['dataissafe'] = 	$dataIsSafe;

	return $sanitizedRegDetails;
}

/**************************************************/
/*** Login sanitizer */
function loginSanitizer($email, $pass){
	$dataIsSafe = false;
	 //Create a placeholder for the credentials
	$sanitizedLoginDetails = [];
	//Sanitize the variables
	$email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);
	$pass_sanitized = filter_var($pass, FILTER_SANITIZE_STRING);

	//Compare the strings to see if there were any tags that got removed
	$emailTampered = compareSanitizedStr($email, $email_sanitized);
	$passTampered = compareSanitizedStr($pass, $pass_sanitized);

	/** EMAIL */
	if(($emailTampered == false)|| ($passTampered == false)) {
		//echo "<p>data is not safe</p>";
		$dataIsSafe = false;
	}  else{
		//echo "<p>data is safe</p>";
		$dataIsSafe = true;
	}

	 //Push sanitized variables into an array that can be used later
	$sanitizedLoginDetails['login-email'] = 	$email_sanitized;
	$sanitizedLoginDetails['login-password'] = 	$pass_sanitized;
	$sanitizedLoginDetails['dataissafe'] = 	$dataIsSafe;

	return $sanitizedLoginDetails;
}

/**************************************************/
/*** Compares sanitized strings ****/
function compareSanitizedStr($originalStr, $sanitizedStr) {
    //Count the credentials strings
	$originalStrLength = strlen($originalStr);
	$sanStrLength = strlen($sanitizedStr);

    //Placeholder boolean to check if the string lenths are the same length
	$stringsAreIdentical = false;

    //Compare the strings
	if ($originalStrLength == $sanStrLength) {
		//echo "<h4 style='color:green'>No illegal characters found</h4>";

		$stringsAreIdentical = true;
		return $stringsAreIdentical;
	} else if ($originalStrLength != $sanStrLength) {
		//echo "<h4 style='color:red'>Possible attack - the user entered illegal characters</h4>";

		$stringsAreIdentical = false;
		return $stringsAreIdentical;
	}
    //Returns true if the strings are identical and false if they don't match
	return $stringsAreIdentical;
}


/***********************/
/******- Testting code */
// $regSantized = registerSanitizer("garry@mail.com", "asdA!4", "asdA!4", "garry", "garry<script>alert('fyc')</script>", "garry", "564564");
// // $regSantized = registerSanitizer("garry@mail.com", "asdA!4", "asdA!4", "garry", "garrssy", "garry", "564564");
// var_dump($regSantized);
// echo "<p>" . $regSantized['dataissafe'] . "</p>";
// if($regSantized['dataissafe'] == false ){
// 	//Start a session, this session will be used to notify the user that we think they are peforming data tampering
// 	session_start();
// 	$_SESSION['tamperingdetected'] =  1;

// 	//Forward the user to the home page, alert the user that we have detected xss tampering (This may demotivate and annoy the attack, forcing them to give up)
// 	header('Location: ../index.php');
// 	exit;
// } else{
// 	//If the server hasn't had to sanitize any data
// 	//If $_SESSION['tamperingdetected'] is set, clear it
// 	if (isset($_SESSION['tamperingdetected'])) {
// 		$key=array_search($_GET['tamperingdetected'],$_SESSION['tamperingdetected']);
// 		if($key!==false)
// 			unset($_SESSION['tamperingdetected'][$key]);
// 		$_SESSION["tamperingdetected"] = array_values($_SESSION["tamperingdetected"]);
// 	} 
// 	//Continue with code as usual
// }

// $logSantized = loginSanitizer("garry@mail.com", "asdA!4");
// var_dump($logSantized);
?>