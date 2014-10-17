<?php

if(isset($_POST['send'])) {

	$target_path = "media/images/";
	$target_path = $target_path . basename($_FILES['uploadedfile']['name']); 

	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
	    echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
	    " has been uploaded";
	} else{
	    echo "There was an error uploading the file, please try again!";
	}

	// $target_dir = "uploads/";
	// $target_dir = $target_dir . basename( $_FILES["uploadFile"]["name"]);
	// $uploadOk=1;

	// // Check if file already exists
	// if (file_exists($target_dir . $_FILES["uploadFile"]["name"])) {
	//     echo "Sorry, file already exists.";
	//     $uploadOk = 0;
	// }

	// // Check file size
	// if ($uploadFile_size > 500000) {
	//     echo "Sorry, your file is too large.";
	//     $uploadOk = 0;
	// }

	// // Only GIF files allowed 
	// if (!($uploadFile_type == "image/gif")) {
	//     echo "Sorry, only GIF files are allowed.";
	//     $uploadOk = 0;
	// }

	// // Check if $uploadOk is set to 0 by an error
	// if ($ok==0) {
	//     echo "Sorry, your file was not uploaded.";
	// // if everything is ok, try to upload file
	// } else { 
	//     if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_dir)) {
	//         echo "The file ". basename( $_FILES["uploadFile"]["name"]). " has been uploaded.";
	//     } else {
	//         echo "Sorry, there was an error uploading your file.";
	//     }
	// }
} else {

$html = '<form method="post" enctype="multipart/form-data">
  			Välj fil: 
  			<input type="file" name="uploadedfile"><br>
  			<input type="submit" name="send" value="Upload File">
		</form>';


echo $html;
}