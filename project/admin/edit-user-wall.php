
<?php 
$title = "Admin edit user wall";

include("/include/header.php");
require_once('include/functions.php');

if(hasAccess(7)){
	?>


</div>
<div class="container-wrapper">
	<div class="user-wall-wrapper container-left container">
		<div class="profile-box">
			<img class="profile-image" src="../img/userimg.png"/>
			<p>(Username)Jenkins</p>
			<p>(Join Date) 00/00-0000</p>
			<a href="#">Add friend</a>
		</div>
	</div>

	<div class="container-mid container">
		<form class="create-post-form" action="api/create-post.php" method="post" enctype="multipart/form-data">
			<input class="post-input" type="textarea" name="post-data" placeholder="What's on your mind?">
			<input type="file" value="Select image" name="fileToUpload" id="fileToUpload">
			<input type="submit" name="post" value="post">
		</form>
		<div class="post" id="post-xx">
			<div class="user-info">
				<img src="../img/userimg.png" />
				<p class="username">(Username)Jenkins</p>
			</div>
			<div class="post-info">
				<p class="post-content">Some random update </p>
			</div>
			<div class="comment-section">
				<form class="create-comment-form"  action="api/create-comment.php" method="post">
					<img class="comment-image" src="../img/userimg.png">
					<input class="comment-input" type="text" name="comment">
					<input class="comment-submit" type="submit" name="submit" value="submit">
				</form>
				<div class="comment">
					<img class="comment-image" src="../img/userimg.png">
					<a href="#">(Username)Jenkins</a>
					<span>Nice content!</span>
				</div>
			</div>
		</div>
	</div>

	<div class="container-right container">
		<div class="event-box">
			<div class="event">
				<p>Event title</p>
				<p>Event date: 00/00-0000</p>
				<img class="event-image" src="../img/event.jpg"/>
			</div>
		</div>

		<div class="request-box">
			<h2>Friend requests</h2>
			<div class="request">
				<img class="request-image" src="../img/Beaker.jpg">
				<p>Username wants to add you as a friend</p>
			</div>
		</div>

		<div class="online-box">
			<div class="online-user">
				<div class="online-user-info">
					<img class="online-image" src="../img/Beaker.jpg">
					<p>Username</p>
				</div>
				<div class="online"></div>
			</div>
		</div>

	</div>
</div>


<?php include "/include/footer.php";

}else
{
	/*Possible attack*/
	header('Location: ../index.php');

	/*Log that this person is trying to get into the admin section somehow*/
}
?>
