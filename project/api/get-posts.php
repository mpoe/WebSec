<?php
	session_start();

	$token = $_SESSION['token'];
	include("./include/db.php");

	//Needs to be more clear, needs to be joined with contacts, can do later
	$stmt = $conn->prepare("SELECT * FROM post WHERE 1=1");
	$stmt->execute();

	while($post = $stmt->fetchObject()){
		$userstmt = $conn->prepare("SELECT avatarname FROM users WHERE id = $post->postedfrom");
		$userstmt->execute();
		$user = $userstmt->fetchObject();
		?>

		<div class="post">
			<div class="user-info">
				<img src="img/userimg.png"/>
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
					<input type="hidden" name="post-id" value=<?php echo $post->id; ?>>
					<input type="text" name="token" hidden value="<?php echo $token; ?>">
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