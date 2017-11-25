<?php

include("../include/db.php");

$searchString = $_GET["searchString"];
$searchString = htmlspecialchars($searchString, ENT_QUOTES, 'UTF-8');

//$stmt = $conn->prepare("SELECT avatarname, id FROM users WHERE avatarname LIKE %{$searchString}%");
//$stmt = $conn->prepare("SELECT avatarname, id FROM `users` WHERE avatarname LIKE '%big%'");
$stmt = $conn->prepare("SELECT avatarname, id FROM `users` WHERE avatarname LIKE :ss");
$searchString = "%".$searchString."%";
$stmt->bindParam(':ss', $searchString, PDO::PARAM_STR);
$stmt->execute();

$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode($results);

echo $json;

?>