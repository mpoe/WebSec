<?php 

require_once("include/token.php");

?>
<script src="dist/jquery-3.2.1.min.js"></script>
<script>
	$( document ).ready(function() {
		/*******INITIALIZE FUNCTIONS********/
		initializeJS();

		/*GET CURRENT PAGE*/
		function initializeJS(){
			/************FUNCTIONS***********/
		//Get the current page
		var currentPage =window.location.href.substring(window.location.href.lastIndexOf('/') + 1);

		//If the user is on a desired page, execute the appropriate js
		if(currentPage.lastIndexOf = 'index'){
			//Get all user data
			getAllUserData();
		}

	}

	/*GET ALL USER DATA*/
	function getAllUserData(){

		/*empty all the rows below the navigation in the table*/
		$('#admin-index-table tr:not(:first)').remove();

		/*user table row blueprint*/
		var userBlueprint = '	\
		<tr>\
		<th></th>\
		<td class="table-id">{{id}}</td>\
		<td>{{aname}}</td>\
		<td>{{email}}</td>\
		<td>{{fname}}</td>\
		<td>{{lname}}</td>\
		<td>{{mobile}}</td>\
		<td>{{djoined}}</td>\
		<td>{{lactive}}</td>\
		<td class="centered-txt">{{failedlogins}}</td>\
		<td class="links admin-table-buttons"  title="Reset password">\
		<span class=" fa fa-refresh fa-fw"></span>\
		<span class=" fa fa-key  fa-fw"></span>\
		</td>\
		{{blockedbutton}}\
		<td class="links"  title="Edit user, you can promote the user to administrator here">\
		<a href="edit-user-profile.php?id={{idtoedit}}&token=<?php echo $token; ?>">\
		<span class="fa fa-pencil-square-o" aria-hidden="true" ></span>\
		<span class="fa fa-user" aria-hidden="true"></span>\
		</a>\
		</td>\
		<td class="links"  title="Edit content on users wall">\
		<a href="edit-user-wall.php">\
		<span class="fa fa-pencil-square-o" aria-hidden="true" ></span>\
		<span class=" fa fa-address-card  fa-fw"></span>\
		</a>\
		</td>\
		</tr>';

		/*Setup ajax request to get all the data*/
		$.ajax({
			"url": "./api/get-all-users.php",
			"method":"get",
			"cache":false,
			"dataType":"text"
		}).done(function(data){
			//console.log(data.email);
			var convertedData = htmlDecode(data);
			//console.log(convertedData);
			var jsonData = JSON.parse(convertedData);
			//console.log(data);
			/*Convert the string being recieved from the server to JSON*/
			//console.log(jsonData);

			/*get the information from each item*/
			for(var i = 0; i < jsonData.length; i++){

				var tempBlueprint = userBlueprint;

				var id = jsonData[i].id;
				var email = jsonData[i].email;
				var aName = jsonData[i].avatarname;
				var fName = jsonData[i].fname;
				var lName = jsonData[i].lname;
				var mobile = jsonData[i].mobile;
				var lActive = jsonData[i].lastAttempt;
				var dJoined = jsonData[i].djoin;
				var failedlogins = jsonData[i].incorrectAttempts;
				var aAccount = jsonData[i].activeacct;

				//Encode all the untrusted data that was added by the client to avoid XSS
				email = htmlEncode(email);
				aName = htmlEncode(aName);
				fName = htmlEncode(fName);
				lName = htmlEncode(lName);
				mobile = htmlEncode(mobile);

				/*replace the placeholders in the template with the data recieved from the server*/
				tempBlueprint = tempBlueprint.replace("{{id}}", id);
				tempBlueprint = tempBlueprint.replace("{{aname}}", aName);
				tempBlueprint = tempBlueprint.replace("{{email}}", email);
				tempBlueprint = tempBlueprint.replace("{{fname}}", fName);
				tempBlueprint = tempBlueprint.replace("{{lname}}", lName);
				tempBlueprint = tempBlueprint.replace("{{mobile}}", mobile);
				tempBlueprint = tempBlueprint.replace("{{djoined}}", dJoined);
				tempBlueprint = tempBlueprint.replace("{{lactive}}", lActive);
				tempBlueprint = tempBlueprint.replace("{{failedlogins}}", failedlogins);
				tempBlueprint = tempBlueprint.replace("{{idtoedit}}", id);

				/*Alternate active user*/
				if(aAccount == "1"){

					var stringToReplace = '{{blockedbutton}}';
					var stringReplaceWith = '<td class="links admin-table-buttons "  title="Activate user">\
					<span class="fa fa-unlock blocked-button" aria-hidden="true"></span>\
					</td>';

					tempBlueprint = tempBlueprint.replace(stringToReplace, stringReplaceWith);
					//console.log(tempBlueprint);
				} else{

					var stringToReplace = '{{blockedbutton}}';
					var stringReplaceWith = '<td class="links admin-table-buttons"  title="Deactivate user">\
					<span class="fa fa-ban blocked-button" aria-hidden="true"></span>\
					</td>';

					tempBlueprint = tempBlueprint.replace(stringToReplace, stringReplaceWith);
				}

				/*append the new row to the cleared table*/
				$('#admin-index-table').append(tempBlueprint);
			}

			//console.log("DONE");
		}).fail( function(){
			//console.log("ERROR");
		} );
	}

	//Source - https://stackoverflow.com/questions/14346414/how-do-you-do-html-encode-using-javascript
	function htmlEncode(value){
  		//create a in-memory div, set it's inner text(which jQuery automatically encodes)
 		//then grab the encoded contents back out.  The div never exists on the page.
 		return $('<div/>').text(value).html();
 	}

 	function htmlDecode(value){
 		return $('<div/>').html(value).text();
 	}
 });

/****************** ALTERNATE DISABLED BUTTON ********************/
$(document).on("click", ".blocked-button" , function(e){
	var target = e.target;
	var targetsClass = target.className;

	/*Work with ajax for updating blocked/active users here*/
	updateUserTableButtons(target, targetsClass);

});

function updateUserTableButtons(target, targetsClass){
	if(targetsClass.indexOf("fa-ban") >= 0){
		/*Remove the current icon*/
		$(target).removeClass("fa-ban");
		/*Add the new icon*/
		$(target).addClass("fa-unlock");
		/*Change the title of the button*/
		$(target).parent().attr("title", "Activate user");
	} else{
		/*Remove the current icon*/
		$(target).removeClass("fa-unlock");
		/*Add the new icon*/
		$(target).addClass("fa-ban");
		/*Change the title of the button*/
		$(target).parent().attr("title", "Deactivate user");
	}
}


/****************** GO TO HOME ********************/
$(document).on("click", ".TopBar_Logo" , function(e){
	goToAddUser();
});	

function goToAddUser(){
	console.log("GOING TO INDEX");
	window.location = "./index.php";
}

/****************** GO TO ADD USER PAGE ********************/
$(document).on("click", ".admin-add-user" , function(e){
	goToHome();
});	

function goToHome(){
	console.log("GOING TO ADD USER");
	window.location = "./create-user-profile.php";
}

/****************** LOGOUT ADMIN ********************/
$(document).on("click", ".admin-logout" , function(e){
	logoutUser();
});	

function logoutUser(){
	window.location = "./api/logout.php";
}

/******************APPENDING NEW IMAGES TO THE DOM - FORM EDIT USER PROFILE******************/
$(document).on('change', '[type="file"]', function () {
	/*setup fileReader to read file */
	var preview = new FileReader();
	/*read contents of blob*/
	preview.readAsDataURL(this.files[0]);

	var self = this;
	//Append the image to the dom
	filePreview(self);
});


function filePreview(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('.profileimg').remove();
			$('.user_img').append('<img class="profileimg" src="'+e.target.result+'" width="auto" height="100"/>');
		}
		reader.readAsDataURL(input.files[0]);
	}
}
</script>
</div>
</body>
</html>