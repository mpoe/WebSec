<?php 
$title = "Admin create user profile";

require_once("include/header.php");
require_once('./include/db.php');

?>
<div class="body-wrapper">
	<div class="edit_user_window">
		<div class="edit_user_topbar">Create user account</div>

		<div class="user_img">
			<!-- <img src="./../img/person.png" style="width: auto; height: 100%;"> -->
		</div>
		<div class="username">Username</div>

		<form action="./api/create-user-profile.php" method="post" enctype="multipart/form-data">
			<!-- 		<form action="./api/create-user-profile.php" method="post" enctype="multipart/form-data"> -->		
				<label for="email">Email</label> 
				<input class="email_address_edit" placeholder="Email address" name="email"> <label for="fname">First name</label> 
				<input class="first_name_edit" placeholder="First name" name="fname"> 
				<label for="lname">Last name</label> 
				<input class="last_name_edit" placeholder="Last name" name="lname"> 
				<label for="mobile">Mobile</label> 
				<input class="last_name_edit" placeholder="Last name" name="mobile"> 
				<label for="aname">Avatar name</label> 
				<input class="avatar_name_edit" placeholder="Avatar name" name="aname">
				<label for="password1">Password</label> 
				<input class="Signup_Password" name="password1" placeholder="Password" type="password" tabindex="7">
				<label for="password2">Re-enter password</label> 
				<input class="Signup_Repassword" name="password2" placeholder="Re-password" type="password" tabindex="8">
				<label for="profileimage">Upload profile image </label> 
				<input class="edit_profile_img_btn" type="file" name="profileimage" id="profileimage">
				<input type="submit" class="edit_account_btn" name="edit_acct" id="edit_acct" value="Submit">
			</form>
		</div>
	</div>

	<?php include "include/footer.php"; ?>
