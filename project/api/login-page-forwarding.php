<?php
/*This file is used to forward users on to other parts of the website based on their access rights*/
function forward_user($email, $pass){

	$userAccessRight = $_SESSION['ar_id'] ;

	if($userAccessRight == 7 || $userAccessRight == 9)
	{
		/*For administrators*/
		/*Redirect the user to the admin section*/
		?>
		<!-- DISCLAIMER - THIS COULD BE VERY BAD PRACTICE AND WE SHOULD TALK TO AN AUTHORITY ABOUT WHAT I DO HERE-->
		<!-- I'm doing this to relogin the user using the administrators database connection and privileges, instead of normal users database connection -->
		<!-- Create a html form that will repost the login data to the admin login system-->
		<!-- The login form is forced to submit via JS, only after the active session is destroyed -->


		<form id="admin-login-form" action="../admin/api/login.php" method="post" class="TopBar_Form"> <!-- Needs form information -->
			<button class="Login_Btn" tabindex="3">Log in</button>
			<input class="TopBar_Password" name="login-password" tabindex="2" value= <?php echo $pass;?> >
			<input class="TopBar_Username" name="login-email"  tabindex="1" value= <?php echo $email;?> >
		</form>

		<?php  
		/* Kill the active session, logging the current user out */
		session_destroy();
		?>
		<!-- Submit the form-->
		<script type="text/javascript">
			document.getElementById("admin-login-form").submit();
		</script>
		<?php
	} 
	else if($userAccessRight = 1)
	{
		/*For normal and unlogged users*/
		/*Redirect the user to the admin section*/
		echo "user";
		header('Location: ../feed.php');
	}
	else
	{
		/*Possible attack*/
		echo "go home";
		header('Location: ../index.php');
	}
}
