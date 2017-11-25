<?php
session_start();
include("../include/db.php");

//Needs to be sanitized??
$commentdesc = $_POST['comment'];
$commentdesc = htmlspecialchars($commentdesc, ENT_QUOTES, 'UTF-8');
$postid = $_POST['post-id'];

include("../include/token-validation.php");


$isfriends = false;

$friendstmt = $conn->prepare("SELECT postedfrom FROM post WHERE id = :postid");
$friendstmt->bindValue(":postid", $postid);
$friendstmt->execute();

//op = original poster
$op = $friendstmt->fetchObject();

if($op->postedfrom == $_SESSION['UserID'])
{
    echo "It is me, Mario!";
    $stmt = $conn->prepare("CALL CreateComment(:postid, :userid, :commentdesc)");
    $stmt->bindValue(":postid", $postid);
    $stmt->bindValue(":userid", $_SESSION['UserID']);
    $stmt->bindValue(":commentdesc", $commentdesc);

    $stmt->execute();
}


$friendstmt2 = $conn->prepare(" SELECT requestedfrom FROM contacts WHERE requestedto = $op->postedfrom");
$friendstmt2->execute();

//get all friends from posts author
while($friend = $friendstmt2->fetchObject())
{
    if($friend->requestedfrom == $_SESSION['UserID'])
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

?>