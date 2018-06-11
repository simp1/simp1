<?php
	#Erditiert den Stammdatensatz
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
	$werkzeugID = $_GET['werkzeugID'];
	$werkid;
	//prüft tokens
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=1){#werkzeug_nr ist unique
			$stmt = $con->prepare("SELECT werkzeugID FROM stammdaten WHERE werkzeugID=? AND werkzeug_nummer=?");
			$stmt->bind_param('is', $werkzeugID, $werkzeugnummer);
			$stmt->execute();
			$stmt->bind_result($werkid);
			$stmt->store_result();
			if($stmt->num_rows == 0){
				$stmt = $con->prepare("SELECT werkzeugID FROM stammdaten WHERE werkzeug_nummer=?");
				$stmt->bind_param('s', $werkzeugnummer);
				$stmt->execute();
				$stmt->bind_result($werkid);
				$stmt->store_result();
				if($stmt->num_rows == 0){
					$stmt = $con->prepare("UPDATE stammdaten SET werkzeug_nummer=?,kurzbeschreibung=?,type=?,druckmaterial=?,druckmodus=?,drucker=?,herstelldatum=? WHERE werkzeugID=?");
					$stmt->bind_param('sssssssi', $werkzeugnummer, $beschreibung, $typ, $material, $modus, $drucker,$hd,$werkzeugID);
					$stmt->execute();
					#schlagwörter löschen
					$stmt = $con->prepare("DELETE FROM schlagwort WHERE werkzeugID=?");
					$stmt->bind_param('i', $werkzeugID);
					$stmt->execute();
					#schalgwörter generieren und speichern
					$teile = explode(",", $sw);
					if(empty($werkzeugID)){#prüfe ob insert geklappt hat
						echo $_GET['jsoncallback'].'('.json_encode("fehler").');';
						exit();
					}else{#die gesplitteten schlagwort durchlaufen
						foreach ($teile as $schlagwort){
							trim($schlagwort);
							if($schlagwort==" "){
								
							}else{
								$stmt = $con->prepare("INSERT INTO schlagwort (werkzeugID, schlagwort) VALUES (?,?)");
								$stmt->bind_param('is', $werkzeugID, $schlagwort);
								$stmt->execute();
							}
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
				echo $_GET['jsoncallback'].'('.json_encode("exist").');';
				exit();
			}else{#einfügen in die tabelle stammdaten
				$stmt = $con->prepare("UPDATE stammdaten SET werkzeug_nummer=?,kurzbeschreibung=?,type=?,druckmaterial=?,druckmodus=?,drucker=?,herstelldatum=? WHERE werkzeugID=?");
				$stmt->bind_param('sssssssi', $werkzeugnummer, $beschreibung, $typ, $material, $modus, $drucker,$hd,$werkzeugID);
				$stmt->execute();
				#schlagwörter löschen
				$stmt = $con->prepare("DELETE FROM schlagwort WHERE werkzeugID=?");
				$stmt->bind_param('i', $werkzeugID);
				$stmt->execute();
				#schalgwörter generieren und speichern
				$teile = explode(",", $sw);
				if(empty($werkzeugID)){#prüfe ob insert geklappt hat
					echo $_GET['jsoncallback'].'('.json_encode("fehler").');';
					exit();
				}else{#die gesplitteten schlagwort durchlaufen
					foreach ($teile as $schlagwort){
						trim($schlagwort);
						if($schlagwort==" "){
							
						}else{
							$stmt = $con->prepare("INSERT INTO schlagwort (werkzeugID, schlagwort) VALUES (?,?)");
							$stmt->bind_param('is', $werkzeugID, $schlagwort);
							$stmt->execute();
						}
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

