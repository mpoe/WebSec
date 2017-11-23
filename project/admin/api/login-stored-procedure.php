<?php 
session_start();

require_once("../include/db.php");

// GET USERINFO FROM URL 
$uEmail = $_POST['login-email']; 
$uPassword = $_POST['login-password']; 

echo $uEmail  . "<br>";
echo $uPassword  . "<br>";


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

//Stored procedure to get email details for login
$stmt = $conn->prepare("CALL GetEmailByEmail(:email)"); 
// get the hash and salt from the username  
//$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email"); 
$stmt->bindValue(':email', $uEmail); 
$stmt->execute(); 
//If there is a user with that username we get the hash and salt for that user 
if($user = $stmt->fetchObject()) 
{
  $salt = $user->salt; 
} 

echo $salt . "<br>";
echo $user->pass . "<br>";
echo hash("sha256",$uPassword.$salt);

//Now that we have the hash and salt we can check it with the user. 
//$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email AND pass=:password"); 
$stmt = $conn->prepare("CALL GetLogin(:email, :password)");
$stmt->bindValue(':email', $uEmail); 
$stmt->bindValue(':password', hash("sha256",$uPassword.$salt)); 
$stmt->execute(); 

var_dump($stmt);
//If login is correct do 
if($user = $stmt->fetchObject()){ 
    //check if user has more than 3 incorrect attempts by convert string to int 
  if(intval($user->incorrectAttempts)>3){ 
        //Since we get a false if a user hasn't waited 
    if(!checkLastLogin($user->lastAttempt)){ 
      echo "<br>too many incorrect logins, try later<br>"; 
      echo '{"status":"error", "type":"11", "descr":"too many failed attempts, account is locked"}';
      exit; 
    } 
  } 
  /*Create an active session for the successfully logged in user*/
  $_SESSION['UserID'] = $user->id;
  $_SESSION['avatar_name'] = $user->avatarname;
  $_SESSION['dJoin'] = $user->djoin;
  $_SESSION['lName'] = $user->lname;
  $_SESSION['fname'] = $user->fname;
  $_SESSION['email'] = $user->email;
  $_SESSION['ar_id'] = $user->arid;
  echo "<br>";
  echo '{"status":"success"}';

  
  // the user is clear, we can update the database and do whatever we need. 
  $updStmt = $conn->prepare("UPDATE users SET lastAttempt=:lastAttempt, incorrectAttempts=0 WHERE email=:email"); 
  $updStmt->bindValue(':lastAttempt',date('Y-m-d H:i:s')); 
  $updStmt->bindValue(':email', $uEmail); 
  $updStmt->execute();
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
    echo "<br>wrong password<br>"; 
    echo '{"status":"error", "type":"10", "descr":"wrong password"}';
    exit; 
  } 
} 

?>