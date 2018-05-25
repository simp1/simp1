<?php
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	$werkzeugnummer = $_GET['werkid'];
	$wert = $_GET['wert'];
	$bez= $_GET['bez'];
	$werkzeugID;
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>0){
			$sql="SELECT * FROM stammdaten WHERE werkzeug_nummer='".$werkzeugnummer."' AND entfernt=0";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$werkzeugID = $ausgabe->werkzeugID;
			}
			
			$stmt = $con->prepare("INSERT INTO werkzeuggeoattr (werkzeugID, bezeichnung, wert) VALUES (?,?,?)");
			$stmt->bind_param('iss', $werkzeugID, $bez, $wert);
			$stmt->execute();
			echo $_GET['jsoncallback'].'('.json_encode("success").');';
			exit();
		}else{
			echo $_GET['jsoncallback'].'('.json_encode("rights").');';
			exit();
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("token").');';
		exit();
	}
	
?>