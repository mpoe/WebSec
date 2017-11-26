<?php
session_start();
include("../include/db.php");
include("../include/xsrfprot.php");
$postdesc = $_POST['post-data'];

$postdesc = htmlspecialchars($postdesc, ENT_QUOTES, 'UTF-8');

include("../include/token-validation.php");

$stmt = $conn->prepare("CALL CreatePost(:postdesc, :postedfrom)");
$stmt->bindValue(":postdesc", $postdesc);
$stmt->bindValue(":postedfrom", $_SESSION['UserID']);
$stmt->execute();

header('Location: ' . $_SESSION["org_referer"]);
?>