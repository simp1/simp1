<?php
	#db schreiben des Allgemeinen Werkzeugattributs
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	#includes
	include '../functions.inc.php';
	include '../config.inc.php';
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	$bezeichnung=$_GET['bezeichnung'];
	$wert=$_GET['wert'];
	$werkzeugnummer=$_GET['werkzeugnummer'];
	$werkzeugID;
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=1){
			$sql="SELECT * FROM stammdaten WHERE werkzeug_nummer='".$werkzeugnummer."' AND entfernt=0";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$werkzeugID = $ausgabe->werkzeugID;
			}	
			$stmt = $con->prepare("SELECT werkzeugID FROM stammdaten WHERE werkzeugID=?");
			$stmt->bind_param('i', $werkzeugID);
			$stmt->execute();
			$stmt->bind_result($werkid);
			$stmt->store_result();
			if($stmt->num_rows == 1){
				$stmt = $con->prepare("INSERT INTO werkzeug_attribute (werkzeugID, bezeichnung, wert) VALUES (?,?,?)");
				$stmt->bind_param('iss', $werkzeugID, $bezeichnung, $wert);
				$stmt->execute();
				echo $_GET['jsoncallback'].'('.json_encode("success").');';
				exit();
			}else{#einfügen in die tabelle stammdaten
				echo $_GET['jsoncallback'].'('.json_encode("exist").');';
				exit();
			}
		}else{
			echo $_GET['jsoncallback'].'('.json_encode("rights").');';
			exit();
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("token").');';
		exit();
	}
	
?>