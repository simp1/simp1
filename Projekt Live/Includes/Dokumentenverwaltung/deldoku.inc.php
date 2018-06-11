<?php
	#l�scht die Doku vom Server und den Eintrag in der DB
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	#Includes
	include '../functions.inc.php';
	include '../config.inc.php';
	#�bergabeparameter
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username'];
	$dokuID=$_GET['dokuID'];
	$userid;
	#Tokens werden gepr�ft
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=1){
			$sql="SELECT * FROM dokumente WHERE dokuID='".$dokuID."'";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$url = $ausgabe->url;
				$name = $ausgabe->bezeichnung;
				$format = $ausgabe->format;
				$id = $ausgabe->dokuID;
				$filename = '../../uploads/pdf/'.$name.'.'.$format;#path zur File die gel�scht wird
			}
			unlink($filename);#l�scht die File 
			$stmt = $con->prepare("DELETE FROM dokumente WHERE dokuID=?");
			$stmt->bind_param('i', $dokuID);
			$stmt->execute();
			echo $_GET['jsoncallback'].'('.json_encode("success").');';#Datei Erfolgreich gel�scht
			exit();
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("token").');';
		exit();
	}
?>