<?php
	session_start();
	include("include/db.php");

	$curUser = $_SESSION['UserID'];
	
	$stmt = $conn->prepare("SELECT u.*, c.requestedto, c.requestedfrom FROM users AS u JOIN contacts AS c ON u.id = c.requestedfrom WHERE c.requestedto = $curUser AND reqstatusid =1");
	$stmt->execute();

	$count = 0;

	while($user = $stmt->fetchObject()){
	?>

	<div class="request">
										<!-- Needs to be dynamic -->
		<img class="request-image" src="img/Beaker.jpg">
		<p><?php echo $user->avatarname; ?> wants to add you as a friend</p>
	</div>
	<?php
	$count++;
	}
	if($count == 0)
	{
		?>
			<p>No new friend requests</p>
		<?php
	}
?>