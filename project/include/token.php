<?php
	$token = hash("sha256", rand());
    $_SESSION["token"] = $token;
    $_SESSION["org_referer"] = "http://".$_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"];
?>