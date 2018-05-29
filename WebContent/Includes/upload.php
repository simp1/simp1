<?php
$id=$_POST['identyfier'];
$target_dir = "../uploads/pdf/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
	header("Location: http://localhost/workspace/swimp/WebContent/test.html?&exist");
    echo "Sorry, file already exists.";
    
    exit();
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    header("Location: http://localhost/workspace/swimp/WebContent/test.html?&large");
    exit();
    $uploadOk = 0;
}
// Allow certain file formats
if($fileType != "pdf" ) {
			echo "Sorry, only PDF files are allowed.";
			header("Location: http://localhost/workspace/swimp/WebContent/test.html?&format");
			exit();
			$uploadOk = 0;
		}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    header("Location: http://localhost/workspace/swimp/WebContent/test.html?&nosuccess");
    exit();
    
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    	#todo
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        header("Location: http://localhost/workspace/swimp/WebContent/test.html?&success");
        exit();
    } else {
        echo "Sorry, there was an error uploading your file.";
        header("Location: http://localhost/workspace/swimp/WebContent/test.html?&nosuccess");
        exit();
    }
}
?>
