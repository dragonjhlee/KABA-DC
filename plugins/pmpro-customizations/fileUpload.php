<?php
    $currentDir = WP_CONTENT_URL;
	$uploadDirectory = "/uploads/ProfilePic/";
	
	echo 'getcwd : ' . getcwd();
	echo 'root : ' . $_SERVER['DOCUMENT_ROOT'];
	echo 'file name : ' . $_SERVER['SCRIPT_FILENAME'];

    $fileName = $_FILES['myfile']['name'];
    $fileTmpName  = $_FILES['myfile']['tmp_name'];

	$uploadPath = $currentDir . $uploadDirectory . basename($fileName); 
	
	//echo $uploadPath;

	$didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                echo "The file " . basename($fileName) . " has been uploaded";
            } else {
                echo "An error occurred somewhere. Try again or contact the admin";
            }
?>