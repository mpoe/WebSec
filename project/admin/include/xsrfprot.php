<?php


//session_start();
$myDomain = $_SESSION["org_referer"];
$requestsSource = $_SERVER['HTTP_REFERER'];

if($requestsSource != $myDomain)
{
    echo "die scrub";
    die;
} 
?>