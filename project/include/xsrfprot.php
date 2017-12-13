<?php

//Get the page we SHOULD arrive from
$myDomain = $_SESSION["org_referer"];
//Find out where we actually CAME from
$requestsSource = $_SERVER['HTTP_REFERER'];

//If they do not match, they are coming from another domain, which we should block immediately
if($requestsSource != $myDomain)
{
	//We are coming from another site, kill everything now!
    die;
}

?>