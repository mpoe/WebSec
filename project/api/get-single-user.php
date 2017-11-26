<?php 
session_start();
include("../include/db.php");

//Needs to be sanitized??
$uID = $_GET['id'];
$curUser = $_SESSION['UserID'];
$token = $_SESSION['token'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = $uID");
$stmt->execute();

$user = $stmt->fetchObject();

?>
<div class="profile-box">
	<!-- Not dynamic -->
	<?php if(!isset($user->profileimage))
	{
		?>
		<img class="profile-image" src="img/userimg.png"/>
		<?php 
	}
	else { 
		?>
		<img class="profile-image" src=<?php echo '"img/' . $user->profileimage . '"' ?>/>
		<?php
	} 
	?>
	<p><?php echo $user->avatarname ?></p>
	<p><?php echo $user->djoin ?></p>
	<?php
	if($uID == $curUser)
	{
			//This is the logged in user, on his own page, do nothing in this case.
	}
	else{
		$friendstmt = $conn->prepare("SELECT * FROM contacts WHERE (requestedto = $curUser AND requestedfrom = $uID) OR (requestedto = $uID AND requestedfrom = $curUser) AND reqstatusid = 5");
		$friendstmt->execute();
		if($friendstmt->fetchObject() == null)
		{
			?>
			<form action="api/create-friend-request.php" method="post">
				<input type="text" name="token" hidden value="<?php echo $token; ?>">
				<input type="text" name="id" hidden value="<?php echo $user->id; ?>">
				<input type="submit" value="Add friend">
			</form>
			<?php
		}
		else
		{
			?>
			<p>You are friends</p>
			<?php
		}
	}
	?>
</div>