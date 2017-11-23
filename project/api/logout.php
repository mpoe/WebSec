<?php
/*Get the active session*/
session_start();

/*Destroy that active session*/
session_destroy();

//echo '{"status" : "ok"}';
/*Redired the user to the home page*/
header('Location: ../index.php');
?>