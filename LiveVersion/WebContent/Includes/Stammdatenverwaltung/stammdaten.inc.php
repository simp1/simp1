<?php
	#Erstellt den Stammdatensatz
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	#gets die übergeben werden
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	$werkzeugnummer=$_GET['werkzeugnummer'];
	$beschreibung=$_GET['beschreibung'];
	$typ=$_GET['typ'];
	$drucker=$_GET['drucker'];
	$material=$_GET['material'];
	$modus=$_GET['modus'];
	$hd=$_GET['hd'];
	$sw=$_GET['sw'];
	$werkid;
	//prüft tokens
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=1){#werkzeug_nr ist unique
			$stmt = $con->prepare("SELECT werkzeugID FROM stammdaten WHERE werkzeug_nummer=?");
			$stmt->bind_param('s', $werkzeugnummer);
			$stmt->execute();
			$stmt->bind_result($werkid);
			$stmt->store_result();
			if($stmt->num_rows == 1){
				echo $_GET['jsoncallback'].'('.json_encode("doppelt").');';
				exit();
			}else{#einfügen in die tabelle stammdaten
				$stmt = $con->prepare("INSERT INTO stammdaten (werkzeug_nummer,kurzbeschreibung,type,druckmaterial,druckmodus,drucker,herstelldatum) VALUES (?,?,?,?,?,?,?)");
				$stmt->bind_param('sssssss', $werkzeugnummer, $beschreibung, $typ, $material, $modus, $drucker,$hd);
				$stmt->execute();
				#schalgwörter generieren und speichern
				$teile = explode(",", $sw);
				#ermitteln der werkzeug id
				$werkzeugID;
				$sql="SELECT werkzeugID FROM stammdaten WHERE werkzeug_nummer='".$werkzeugnummer."'";
				$statemt = getsql($sql);
				while($ausgabe = $statemt->fetch_object()){
					$werkzeugID = $ausgabe->werkzeugID;
				}
				if(empty($werkzeugID)){#prüfe ob insert geklappt hat
					echo $_GET['jsoncallback'].'('.json_encode("fehler").');';
					exit();
				}else{#die gesplitteten schlagwort durchlaufen
					foreach ($teile as $schlagwort){
						$stmt = $con->prepare("INSERT INTO schlagwort (werkzeugID, schlagwort) VALUES (?,?)");
						$stmt->bind_param('is', $werkzeugID, $schlagwort);
						$stmt->execute();
						
					}
					#standartübernahmer der schlagwörter
					$stmt = $con->prepare("INSERT INTO schlagwort (werkzeugID, schlagwort) VALUES (?,?)");
					$stmt->bind_param('is', $werkzeugID, $werkzeugnummer);
					$stmt->execute();
					$stmt = $con->prepare("INSERT INTO schlagwort (werkzeugID, schlagwort) VALUES (?,?)");
					$stmt->bind_param('is', $werkzeugID, $drucker);
					$stmt->execute();
					$stmt = $con->prepare("INSERT INTO schlagwort (werkzeugID, schlagwort) VALUES (?,?)");
					$stmt->bind_param('is', $werkzeugID, $material);
					$stmt->execute();
					$stmt = $con->prepare("INSERT INTO schlagwort (werkzeugID, schlagwort) VALUES (?,?)");
					$stmt->bind_param('is', $werkzeugID, $typ);
					$stmt->execute();
					$stmt = $con->prepare("INSERT INTO schlagwort (werkzeugID, schlagwort) VALUES (?,?)");
					$stmt->bind_param('is', $werkzeugID, $hd);
					$stmt->execute();
				}
				echo $_GET['jsoncallback'].'('.json_encode("success").');';
				exit();
			
			}
		}else{
			echo $_GET['jsoncallback'].'('.json_encode("rechte").');';
			exit();
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("token").');';
		exit();
	}
?>

