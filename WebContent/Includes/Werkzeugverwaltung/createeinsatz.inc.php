<?php
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	$schussnummer=$_GET['schuss'];
	$werkzeugnummer = $_GET['werkzeugID'];
	$datum = $_GET['datum'];
	$maschine = $_GET['maschine'];
	$kuehl = $_GET['kuehl'];
	$kuehldauer = $_GET['kuehldauer'];
	$schlies = $_GET['schlies'];
	$laufendenummer=1;
	$werkzeugID;
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>0){
			$sql="SELECT * FROM stammdaten WHERE werkzeug_nummer='".$werkzeugnummer."' AND entfernt=0";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$werkzeugID = $ausgabe->werkzeugID;
			}
			
			$sql="SELECT MAX(laufendenummer) as laufendenummer FROM werkzeug_einsatz WHERE werkzeugID='".$werkzeugID."'";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$laufendenummer = $ausgabe->laufendenummer;
			}
			$laufendenummer=$laufendenummer+1;
			
			$stmt = $con->prepare("INSERT INTO werkzeug_einsatz (werkzeugID, laufendenummer, datum, schussnummer, maschine, kuehlung, kuehldauer, schließkraft) VALUES (?,?,?,?,?,?,?,?)");
			$stmt->bind_param('iisissii', $werkzeugID, $laufendenummer, $datum, $schussnummer, $maschine, $kuehl ,$kuehldauer, $schlies);
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