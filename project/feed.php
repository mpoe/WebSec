<?php
session_start();

include("include/db.php");
include("include/token.php");

if(!isset( $_SESSION['UserID'])){
	header('Location: '. "index.php");
}
$loggedID = $_SESSION['UserID'];
include("include/header.php");
?>
	<div class="container-wrapper">
		<div class="container-left container">
		</div>
		<div class="container-mid container">
			<form class="create-post-form" action="api/create-post.php" method="post" enctype="multipart/form-data">
				<input class="post-input" type="textarea" name="post-data" placeholder="What's on your mind?">
				<input type="file" value="Select image" name="fileToUpload" id="fileToUpload">
				<input type="text" name="token" hidden value="<?php echo $token; ?>">
				<input type="submit" name="post" value="post">
			</form>
			<?php
			include('api/get-posts.php');
			?>
		</div>
		<div class="container-right container">
			<div class="event-box">
				<div class="event">
					<p>Event title</p>
					<p>Event date: 00/00-0000</p>
					<img class="event-image" src="img/event.jpg"/>
				</div>
			</div>

			<div class="request-box">
			<?php
			include('api/get-friend-request.php');
			?>
		</div>
		<div class="online-box">
			<?php
			include('api/get-friends.php');
			?>
			</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
	$( document ).ready(function() {
    	$.get("api/get-single-user.php?id=<?php echo $loggedID; ?>", function(sData){
    		$(".container-left").append(sData);
		//Do nothing
		})
	});
	
</script>