<?php
	//session_start();
	include("include/db.php");

	$curUser = $_SESSION['UserID'];

	//Does not check for online yet.
																																						//vvvvv hardcoded while testing, change with $curUser
	$stmt = $conn->prepare("SELECT u.*, c.requestedto, c.requestedfrom FROM users AS u JOIN contacts AS c ON u.id = c.requestedfrom WHERE c.requestedto = 7777 AND reqstatusid =5");
	$stmt->execute();

	while($user = $stmt->fetchObject())
	{
		?>
		<div class="online-user">
			<div class="online-user-info">
				<img class="online-image" src="img/Beaker.jpg">
				<p><?php echo $user->avatarname; ?></p>
			</div>
			<div class="online"></div>
		</div>
		<?php
	}

?>