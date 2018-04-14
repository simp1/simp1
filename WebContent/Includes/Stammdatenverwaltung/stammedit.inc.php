<?php
	#Anzeigen der Stammdaten zu einer ID
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	#gets die übergeben werden
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	$werkzeugID=$_GET['werkzeugID'];
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=1){
			$output="";
			#Anzuzeigende werte
			$sql="SELECT * FROM stammdaten WHERE entfernt=0 AND werkzeugID='".$werkzeugID."';";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$werkzeugnummer = $ausgabe->werkzeug_nummer;
				$typ = $ausgabe->type;
				$kurzbeschreibung = $ausgabe->kurzbeschreibung;
				$drucker = $ausgabe->drucker;
				$material = $ausgabe->druckmaterial;
				$modus = $ausgabe->druckmodus;
				$hd = $ausgabe->herstelldatum;
				$sw="";
				$sql="SELECT * FROM schlagwort WHERE werkzeugID ='".$werkzeugID."'";
				$statement = getsql($sql);
				while($op = $statement->fetch_object()){
					$wort = $op->schlagwort;
					if($wort==$werkzeugnummer||$wort==$typ||$wort==$drucker||$wort==$material||$wort==$hd){
						
					}else{
						$sw .= $wort.", ";
					}
				}
				$sw .= $werkzeugID;
				$output .= $werkzeugnummer.";".$typ.";".$kurzbeschreibung.";".$drucker.";".$material.";".$modus.";".$hd.";".$sw.";".$werkzeugID;
				
			}
			echo $_GET['jsoncallback'].'('.json_encode($output).');';
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