<?php
include 'functions.inc.php';
include 'config.inc.php';
$werkzeugID=$_POST['werkzeugzuge'];
$zugehoerigkeit=$_POST['zugehoerig'];
$idzuge=$_POST['idzuge'];
$target_dir = "../uploads/pdf/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$werkid;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$sql="SELECT * FROM stammdaten WHERE werkzeug_nummer='".$werkzeugID."' AND entfernt=0";
$statemt = getsql($sql);
while($ausgabe = $statemt->fetch_object()){
	$werkid = $ausgabe->werkzeugID;
}
// Check if file already exists
if (file_exists($target_file)) {
	header("Location: http://localhost/workspace/swimp/WebContent/werkzeugverwaltung.html?&werkzeugID=".$werkzeugID."&exist");
    echo "Sorry, file already exists.";
    
    exit();
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    header("Location: http://localhost/workspace/swimp/WebContent/werkzeugverwaltung.html?&werkzeugID=".$werkzeugID."&large");
    exit();
    $uploadOk = 0;
}
// Allow certain file formats
if($fileType != "pdf") {
			echo "Sorry, only PDF files are allowed.";
			header("Location: http://localhost/workspace/swimp/WebContent/werkzeugverwaltung.html?&werkzeugID=".$werkzeugID."&format");
			exit();
			$uploadOk = 0;
		}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    header("Location: http://localhost/workspace/swimp/WebContent/werkzeugverwaltung.html?&werkzeugID=".$werkzeugID."&nosuccess");
    exit();
    
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    	$sql;
    	$zuordnung;
    	$allgemein;
    	if($zugehoerigkeit==1){
    		$sql="INSERT INTO dokumente (werkzeugID, format, url, bezeichnung, zuordnung) VALUES (?,?,?,?,?)";
    		$zuordnung=werkzeug;
    	}elseif ($zugehoerigkeit==2){
    		$sql="INSERT INTO dokumente (werkzeugID, format, url, bezeichnung, zuordnung) VALUES (?,?,?,?,?)";
    		$zuordnung=geo;
    	}elseif ($zugehoerigkeit==3){
    		if(empty($idzuge)){
    			$sql="INSERT INTO dokumente (werkzeugID, format, url, bezeichnung, zuordnung) VALUES (?,?,?,?,?)";
    			$zuordnung=einsatz;
    		}else{
    			$sql="INSERT INTO dokumente (einsatzID, format, url, bezeichnung) VALUES (?,?,?,?)";
    		}
    	}elseif ($zugehoerigkeit==5){
    			$sql="INSERT INTO dokumente (format, url, bezeichnung) VALUES (?,?,?)";
    			$allgemein=1;
    	}else {
    		if(empty($idzuge)){
    			$sql="INSERT INTO dokumente (werkzeugID, format, url, bezeichnung, zuordnung) VALUES (?,?,?,?,?)";
    			$zuordnung=pruef;
    		}else{
    			$sql="INSERT INTO dokumente (pruefID, format, url, bezeichnung) VALUES (?,?,?,?)";
    		}
    	}
    	$nameofdoc=basename( $_FILES["fileToUpload"]["name"]);
    	$teile = explode(".", $nameofdoc);
    	$url="http://localhost/workspace/swimp/WebContent/uploads/pdf/".$nameofdoc;
    	if(empty($zuordnung)){
    		if($allgemein==1){
    			$stmt = $con->prepare($sql);
    			$stmt->bind_param('sss', $teile[1], $url, $teile[0]);
    			$stmt->execute();
    		}else {
    			$stmt = $con->prepare($sql);
    			$stmt->bind_param('isss', $idzuge, $teile[1], $url, $teile[0]);
    			$stmt->execute();
    		}
    	}else{
    		$stmt = $con->prepare($sql);
    		$stmt->bind_param('issss', $werkid, $teile[1], $url, $teile[0], $zuordnung);
    		$stmt->execute();
    	}
    	
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        header("Location: http://localhost/workspace/swimp/WebContent/werkzeugverwaltung.html?&werkzeugID=".$werkzeugID."&success");
        exit();
    } else {
        echo "Sorry, there was an error uploading your file.";
        header("Location: http://localhost/workspace/swimp/WebContent/werkzeugverwaltung.html?&werkzeugID=".$werkzeugID."&nosuccess");
        exit();
    }
}
?>
