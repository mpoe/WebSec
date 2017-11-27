<?php 
session_start();

include("../include/db.php");
/*Contains a function to forward the user*/
include('login-page-forwarding.php');
include ('sanitizers.php');

// GET USERINFO FROM URL 
$uEmail = $_POST['login-email']; 
$uPassword = $_POST['login-password'];

//Sanitize the registration input
$loginSanitizer = registerSanitizer($uEmail, $uPassword);
//If the sanitizer removed any strange text exit the sign-up process and forward the user to the index page
if($loginSanitizer['dataissafe'] == false ){
  $loggedstatus = '[{"status":"error", "type":"809", "descr":"Please stop attempting to attack our site", "dbdescr": "user entered potentially malicious code"}]'; 
  $_SESSION['loginstatus'] =  $loggedstatus;

  //Forward the user to the home page, alert the user that we have detected xss tampering (This may demotivate and annoy the attack, forcing them to give up)
  header('Location: ../index.php');
  exit;
} 


$uEmail = htmlspecialchars($uEmail, ENT_QUOTES, 'UTF-8');
$uPassword = htmlspecialchars($uPassword, ENT_QUOTES, 'UTF-8');

//Make sure the usres login credentials are not empty
if (empty($uEmail) || empty($uPassword) ){
  $loggedstatus = '[{"status":"error", "type":"807", "descr":"Please enter valid login credentials", "dbdescr": "user entered empty login credentials"}]'; 
  $_SESSION['loginstatus'] =  $loggedstatus;

  //Forward the user to the home page
  header('Location: ../index.php');
  exit; 
}


//Initiate function 
//Which checks the date given - as a string 
function checkLastLogin($date) { 
    //Converts the string to an int in seconds since 1970 or smt.. 
  if( strtotime("now") - strtotime($date) >= 300){ 
        //We are good, the user waited 5 minutes 
    return true; 
  }else{ 
        //The user needs to wait a bit longer 
    return false; 
  } 
} 


// get the hash and salt from the username  
$stmt = $conn->prepare("SELECT salt FROM users WHERE email=:email"); 
$stmt->bindValue(':email', $uEmail); 
$stmt->execute(); 
//If there is a user with that username we get the hash and salt for that user 
if($user = $stmt->fetchObject()) 
{
  $salt = $user->salt; 

//Now that we have the hash and salt we can check it with the user. 
  $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email AND pass=:password"); 
  $stmt->bindValue(':email', $uEmail); 
  $stmt->bindValue(':password', hash("sha256",$uPassword.$salt)); 
  $stmt->execute(); 
  //If login is correct do 
  if($user = $stmt->fetchObject()){ 
  //check if user has more than 3 incorrect attempts by convert string to int 
    if(intval($user->incorrectAttempts)>3){ 
        //Since we get a false if a user hasn't waited 
      if(!checkLastLogin($user->lastAttempt)){ 
        $loggedstatus = '[{"status":"error", "type":"805", "descr":"Too many failed attempts, the account has been locked for 5 minutes", "dbdescr": "too many failed login attempts, account is locked"}]'; 
        $_SESSION['loginstatus'] =  $loggedstatus;
        
        //Forward the user to the home page
        header('Location: ../index.php');
        exit; 
      } 
    } 

    // the user is clear, we can update the database and do whatever we need. 
    $updStmt = $conn->prepare("UPDATE users SET lastAttempt=:lastAttempt, incorrectAttempts=0 WHERE email=:email"); 
    $updStmt->bindValue(':lastAttempt',date('Y-m-d H:i:s')); 
    $updStmt->bindValue(':email', $uEmail); 
    $updStmt->execute();
    $_SESSION['UserID'] = $user->id;
    $_SESSION['avatar_name'] = $user->avatarname;
    $_SESSION['dJoin'] = $user->djoin;
    $_SESSION['lName'] = $user->lname;
    $_SESSION['fname'] = $user->fname;
    $_SESSION['email'] = $user->email;
    $_SESSION['ar_id'] = $user->arid;
    $loggedstatus = '[{"status":"success", "type":"800", "descr":"login success", "dbdescr": "login success"}]'; 
    //Forward the user to their designated destination
    forward_user($_POST['login-email'], $_POST['login-password']);
  } 
  else{
    //Password is most likely incorrect, can also be username which prompts us to go here. 
    //Update the user 
    $updStmt = $conn->prepare("UPDATE users SET lastAttempt=:lastAttempt, incorrectAttempts = incorrectAttempts+1 WHERE email=:email"); 
    $updStmt->bindValue(':lastAttempt',date('Y-m-d H:i:s')); 
    $updStmt->bindValue(':email', $uEmail); 
    $updStmt->execute(); 

    //Now check if they have too many incorrect attempts. 
    $userStmt = $conn->prepare("SELECT * FROM users WHERE email=:email"); 
    $userStmt->bindValue(':email', $uEmail); 
    $userStmt->execute(); 
    $userInfo = $userStmt->fetchObject(); 

    if(!checkLastLogin($userInfo->lastAttempt)) 
    { 
      $loggedstatus = '[{"status":"error", "type":"803", "descr":"Your login credentials were incorrect", "dbdescr": "user entered incorrect password"}]';
      $_SESSION['loginstatus'] =  $loggedstatus;
      
      //Forward the user to the home page
      header('Location: ../index.php');
      exit; 
    } 
  } 


} else{
  //Invalid email
 $loggedstatus =  '[{"status":"error", "type":"801", "descr":"Your login credentials were incorrect", "dbdescr": "user entered incorrect email"}]';
 $_SESSION['loginstatus'] =  $loggedstatus;

  //Forward the user to the home page
 header('Location: ../index.php');
} 


?>