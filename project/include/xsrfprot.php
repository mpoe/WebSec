<?php


//session_start();

//Get the page we SHOULD arrive from
$myDomain = $_SESSION["org_referer"];
//Find out where we actually CAME from
$requestsSource = $_SERVER['HTTP_REFERER'];

//If they do not match, they are coming from another domain, which we should block immediately
if($requestsSource != $myDomain)
{
    echo "die scrub";
    die;
} 
?>