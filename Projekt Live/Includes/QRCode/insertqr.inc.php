<?php
	/*
	 * Speichert den QR Code als Base64 encoding in die DB erlaubt ist hier ein POST
	 */
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: POST, GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	$parts  = $_POST['datastring'];
	$teile = explode(";;",$parts);
	$token=$teile[3];
	$token_login=$teile[4];
	$username=$teile[2];
	$werkzeugID=$teile[0];
	$qr=$teile[1];
	$qr = str_replace(' ','+',$qr);#anpassungen am encoding
	$link =$teile[5];
	$id;
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=1){
			$sql="SELECT * FROM stammdaten WHERE werkzeug_nummer='".$werkzeugID."' AND entfernt=0;";#prüfen ob Werkzeug gültig ist
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$id=$ausgabe->werkzeugID;
			}
			
			$sql="INSERT INTO qrcode (werkzeugID,svg,link) VALUES (?,?,?)";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('iss', $id, $qr, $link);
			$stmt->execute();
			echo "success";
			exit();
		}else{
			echo "rights";
			exit();
		}
	}else{
		echo "token";
		exit();
	}
	
?>