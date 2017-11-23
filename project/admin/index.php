

<!--**************************************-->
<!--************IMPORT HEADER*************-->
<?php 
$title = "Admin home";

require_once("include/header.php"); ?>




<!-- ADMINS TABLE -->
<div class="article-admin-table" >

	<div id="lbladminAdd" class="admin-icon link pointer admin-add-user" data-go-to="section-admin-create"  title="Create a new user, you can make an administrative user here">
		<div id="adminAddIcon">
			<span class="fa fa-plus "></span>
			<span class="fa fa-user"></span>
		</div>
		<div>Add user</div>					
	</div>

	<div id="lbladminAdd" class="admin-icon link pointer admin-logout" data-go-to="section-admin-create"  title="Logout to kill the session">
		<div id="adminAddIcon">
			<span class="fa fa-sign-out"></span>
		</div>
		<div>Logout</div>					
	</div>

</div>

<div class="container-mid container">
	<table id="admin-index-table">
		<tr>
			<th></th>
			<th>Avatar Name</th>
			<th>Email Address</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Mobile</th>
			<th>Date Joined</th>
			<th>Last active</th>
			<th>Failed login count</th>
			<th>Reset password</th>
			<th>Ban Account</th>
			<th>Edit Account</th>
			<th>View Wall</th>
		</tr>
		<div class="dynamic-index-data" >

		</table>

	</div>

</div>

<!--**************************************-->
<!--************IMPORT FOOTER*************-->
<?php include "include/footer.php"; ?>