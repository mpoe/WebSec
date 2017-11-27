
<?php 
$title = "Admin edit user profile";

require_once("include/header.php");
require_once('./include/db.php');
require_once('include/functions.php');

if(hasAccess(7)){


	?>
	<div class="body-wrapper">
		<div class="edit_user_window">
			<div class="edit_user_topbar">Edit user account</div>
			<?php
		// Figure out how a token will work here
		//Get the users id from the url
			$userid = $_GET["id"];
		//Get the users data
			$stmt = $conn->prepare('CALL GetUserForAdmin(:uid)');
			$stmt->bindValue(":uid", $userid);
			$stmt->execute();
			while($user = $stmt->fetchObject()){
			// var_dump($user);
			//While getting the user data
				?>
				<!-- Insert profile image -->
				<div class="user_img" >
					<?php
					$profileimage = $user->profileimage;
					if(!isset($profileimage)){
						echo '<img class="profileimg" src="./../img/person.png" style="width: auto; height: 100%;">';	
					} else{				
						echo '<img class="profileimg" src="./../img/' . htmlentities($profileimage) . '" style="width: auto; height: 100%;">'; 
					}
					?>
				</div>
				<div class="username">Username</div>

				<form action="./api/edit-user-profile.php" method="post" enctype="multipart/form-data">

					<input class="admin_id" name="userid" value=<?php echo '"' . $user->id . '"' ?>> 
					<label for="email">Email</label> 
					<input class="email_address_edit" placeholder="Email address" name="email" value=<?php echo '" '. htmlentities($user->email) .' " ';?> > 
					<label for="fname">First name</label> 
					<input class="first_name_edit" placeholder="First name" name="fname" value=<?php echo '" '. htmlentities($user->fname) .' " ';?> > 
					<label for="lname">Last name</label> 
					<input class="last_name_edit" placeholder="Last name" name="lname" value=<?php echo '" '. htmlentities($user->lname) .' " ';?> > 
					<label for="aname">Avatar name</label> 
					<input class="avatar_name_edit" placeholder="Avatar name" name="aname" value=<?php echo '" '. htmlentities($user->avatarname) .' " ';?> >
					<label for="mobile">Mobile</label> 
					<input class="last_name_edit" placeholder="Mobile number (6456-6754)" name="mobile" value=<?php echo '" '. htmlentities($user->mobile) .' " ';?> > 
					
					
					<label for="profile-image">Edit profile image </label> 
					<input id="#edit_profile_img_btn" class="edit_profile_img_btn" type="file" name="profileimage" id="profileimage">
					<input type="submit" class="edit_account_btn" name="edit_acct" id="edit_acct" value="Submit">

				</form>
				<?php
			}
			?>
		</div>
	</div>

	<?php include "include/footer.php"; 
}else
{
	/*Possible attack*/
	header('Location: ../index.php');

	/*Log that this person is trying to get into the admin section somehow*/
}
?>
