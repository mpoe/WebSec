<?php

//DOESNT WORK YET, MIGHT NO BE NESCESARY EITHER BUT KEEPING IT FOR NOW!

session_start();
$myDomain = $_SESSION["org_referer"];
$requestsSource = $_SERVER['HTTP_REFERER'];

if($requestsSource != $myDomain)
{
    echo "die scrub";
    die;
} 
?>