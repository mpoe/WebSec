<?php
	$userid = $_GET['id'];
	$userid = htmlspecialchars($userid, ENT_QUOTES, 'UTF-8');
	include("include/db.php");
	$token = $_SESSION['token'];

	$stmt = $conn->prepare("SELECT * FROM post WHERE postedfrom = :userid");
    $stmt->bindValue(":userid", $userid);
	$stmt->execute();

	if ($stmt->rowCount() == 0) {
		echo "<h2>User has no posts</h2>";
	} 

	while($post = $stmt->fetchObject()){
		$userstmt = $conn->prepare("SELECT avatarname, profileimage FROM users WHERE id = $post->postedfrom");
		$userstmt->execute();
		$user = $userstmt->fetchObject();
		?>

		<div class="post">
			<div class="user-info">
				<img src=<?php echo '"img/' . $user->avatarname . '"' ?>/>
				<p class="username"><?php echo $user->avatarname ?></p>
			</div>
			<div class="post-info">
				<p class="post-content"><?php echo $post->postdesc; ?></p>
			</div>
		
		<div class="comment-section">
			<!-- add correct folder structure -->
			<form action="api/create-comment.php" method="post">
				<img class="comment-image" src="img/userimg.png">
				<input class="comment-input" type="text" name="comment">
				<input type="text" name="token" hidden value="<?php echo $token; ?>">
				<input type="hidden" name="post-id" value=<?php echo $post->id; ?>>
				<input class="comment-submit" type="submit" name="submit" value="submit">
			</form>

			<?php
				$stmt2 = $conn->prepare("SELECT * FROM pcomment WHERE postid = $post->id");
				$stmt2->execute();
				while($comment = $stmt2->fetchObject()){
					$userstmt2 = $conn->prepare("SELECT avatarname FROM users WHERE id = $comment->userid");
					$userstmt2->execute();
					$user2 = $userstmt2->fetchObject();
			?>
			<div class="comment">
				<img class="comment-image" src="img/userimg.png">
				<a href="#"><?php echo $user2->avatarname ?></a>
				<span><?php echo $comment->commentdesc; ?></span>
			</div>
			<?php
		}
		?>
		</div>
		</div>
	<?php
	}
?>