<?php
	$token = hash("sha256", rand());
    $_SESSION["token"] = $token;
    $_SESSION["org_referer"] = "http://".$_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"];
    if(!empty($_SERVER["QUERY_STRING"]))
    {
    	$_SESSION["org_referer"] = $_SESSION["org_referer"]. "?" . $_SERVER["QUERY_STRING"];
    }
?>