<?php
	#Anlegen des Prüfprotokolls
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	$werkzeugID;
	$datum = $_GET['datum'];
	$laenge = $_GET['laenge'];
	$breite = $_GET['breite'];
	$laufendenummer;
	$bezeichnung="Breite";
	$pruefID;
	$werkzeugnummer = $_GET['werkzeugID'];
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>0){
			$sql="SELECT * FROM stammdaten WHERE werkzeug_nummer='".$werkzeugnummer."' AND entfernt=0";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$werkzeugID = $ausgabe->werkzeugID;
			}
			$sql="SELECT MAX(laufendenummer) as laufendenummer FROM werkzeug_pruef WHERE werkzeugID='".$werkzeugID."'";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$laufendenummer = $ausgabe->laufendenummer;
			}
			$laufendenummer=$laufendenummer+1;
			$stmt = $con->prepare("INSERT INTO werkzeug_pruef (werkzeugID, laufendenummer, datum) VALUES (?,?,?)");
			$stmt->bind_param('iis', $werkzeugID, $laufendenummer, $datum);
			$stmt->execute();
			
			$sql="SELECT * FROM werkzeug_pruef WHERE laufendenummer='".$laufendenummer."';";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$pruefID = $ausgabe->pruefID;
			}
			$stmt = $con->prepare("INSERT INTO pruefmerkmale (pruefID, beschreibung, wert) VALUES (?,?,?)");
			$stmt->bind_param('iss', $pruefID, $bezeichnung, $breite);
			$stmt->execute();
			$bezeichnung="Laenge";
			$stmt = $con->prepare("INSERT INTO pruefmerkmale (pruefID, beschreibung, wert) VALUES (?,?,?)");
			$stmt->bind_param('iss', $pruefID, $bezeichnung, $laenge);
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