<?php
session_start();
include("../include/db.php");
include("../include/xsrfprot.php");

$postdesc = $_POST['post-data'];

include("/include/token-validation.php");

$stmt = $conn->prepare("CALL CreatePost(:postdesc, :postedfrom)");
$stmt->bindValue(":postdesc", $postdesc);
$stmt->bindValue(":postedfrom", $_SESSION['UserID']);
$stmt->execute();

echo "x";

echo $postdesc;
echo $_SESSION['UserID'];
?>