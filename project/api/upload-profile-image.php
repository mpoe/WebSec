<?php
//Upload the users profile image
// - returns the images new name
// - need to setup error log for uploads
function uploadProfileImage($files){
	//var_dump($files);


	/* setup a placeholder for the file name */
	/* replace the files name */
	$tempName = explode('.', $_FILES["profileimage"]["name"]);
	//echo "<br>Temp name: " . $_FILES["profileimage"]["name"] . "<br>";

	//Generate a random sting for the image name
	$imageName = uniqid() . '.' . end($tempName);
	//echo "<br>New name: " . $imageName . "<br>";

	/* setup a placeholder for the file upload path */
	$filePath = './../../img/';
	//echo "<br>".$imageName ."<br>";

	/* upload the files the the server */
	/* - added checks to make sure file is being uploaded*/
	//move_uploaded_file($_FILES["profileimage"]["tmp_name"], $filePath . $imageName);


	/*VALIDATE FOR IMAGES*/
	$uploadOk = 1;
	$target_file = $filePath . $imageName;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	// Check if image file is a actual image or fake image
	$check = getimagesize($_FILES["profileimage"]["tmp_name"]);
	if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}

	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}

	// Check file size - only upload files smaller than 5mb
	if ($_FILES["profileimage"]["size"] > 5000000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["profileimage"]["tmp_name"], $filePath . $imageName)) {
			echo "The file ". $imageName. " has been uploaded.";

		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}

	

	return $imageName;
}