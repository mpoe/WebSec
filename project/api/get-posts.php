<?php
	//session_start();

$token = $_SESSION['token'];
include("include/db.php");

	//Needs to be more clear, needs to be joined with contacts, can do later
$stmt = $conn->prepare("SELECT post.id, post.postdesc, post.postimage, post.postedfrom 
	FROM post 
	JOIN contacts
	ON post.postedfrom=contacts.requestedto OR post.postedfrom=contacts.requestedfrom 
	WHERE contacts.reqstatusid =5 AND (contacts.requestedfrom = :uid OR contacts.requestedto = :uid2) ORDER BY post.id DESC");
	//We can be either the sender or receiver of a friendrequest, and we would like to see our own post
$stmt->bindValue(":uid", $_SESSION['UserID']);
	//so let's check for either of the 2
$stmt->bindValue(":uid2", $_SESSION['UserID']);
$stmt->execute();

if ($stmt->rowCount() == 0) {
		echo "<h2>Please add a friend to see posts from them, use the search bar above to find friends, you can see your own posts without friends by going to your wall (search for your avatar name</h2>";
	} 

while($post = $stmt->fetchObject()){
	$userstmt = $conn->prepare("SELECT avatarname FROM users WHERE id = $post->postedfrom ORDER BY id DESC");
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
			$stmt2 = $conn->prepare("SELECT * FROM pcomment WHERE postid = $post->id ORDER BY pcomment.dposted DESC");
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