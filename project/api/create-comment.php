<?php
session_start();
include("../include/db.php");

$commentdesc = $_POST['comment'];
$commentdesc = htmlspecialchars($commentdesc, ENT_QUOTES, 'UTF-8');
$postid = $_POST['post-id'];
$postid = htmlspecialchars($postid, ENT_QUOTES, 'UTF-8');

include("../include/token-validation.php");

$isfriends = false;

$friendstmt = $conn->prepare("SELECT postedfrom FROM post WHERE id = :postid");
$friendstmt->bindValue(":postid", $postid);
$friendstmt->execute();

//op = original poster
$op = $friendstmt->fetchObject();

//This is ourselves, we are allowed to post on our own posts
if($op->postedfrom == $_SESSION['UserID'])
{
    $stmt = $conn->prepare("CALL CreateComment(:postid, :userid, :commentdesc)");
    $stmt->bindValue(":postid", $postid);
    $stmt->bindValue(":userid", $_SESSION['UserID']);
    $stmt->bindValue(":commentdesc", $commentdesc);

    $stmt->execute();
    header('Location: ' . $_SESSION["org_referer"]);
}

$friendstmt2 = $conn->prepare("SELECT requestedfrom, reqstatusid FROM contacts WHERE requestedto = $op->postedfrom");
$friendstmt2->execute();

//get all friends from posts author
while($friend = $friendstmt2->fetchObject())
{
    if($friend->requestedfrom == $_SESSION['UserID'] && $friend->reqstatusid == 5 )
    {
        $isfriends = true;
    }
}

if($isfriends)
{
    echo "we are friends";
    $stmt = $conn->prepare("CALL CreateComment(:postid, :userid, :commentdesc)");
    $stmt->bindValue(":postid", $postid);
    $stmt->bindValue(":userid", $_SESSION['UserID']);
    $stmt->bindValue(":commentdesc", $commentdesc);

    $stmt->execute();
}
else{
    echo "not friends";
}
header('Location: ' . $_SESSION["org_referer"]);
?>