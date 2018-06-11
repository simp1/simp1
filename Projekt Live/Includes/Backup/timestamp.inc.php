<?php
	/*
	 * Erzeugt den DB Eintrag zum BackUp, wird aufgerufen beim Laden der Startseite und prüft wann das letzte Backup war
	 */
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');#Nur Get erlaubt
	/*
	 * Includes
	 */
	include '../functions.inc.php';
	include '../config.inc.php';
	/*
	 *  Auswerten der Übergabeparameter
	 */
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	if(checktoken($token,$token_login,$username)){#prüft die Session
		$erg = status($username);
		if($erg>=10){#prüft die Rechte
			$timestamp = time() - 604800;#Rechnet von jetzt 7 Tage zurück, als Timestamp
			$time = time();#aktuelle Zeit
			/*
			 * Prüft ob ein Zeitstemple vom Jetzt bis 7 Tage zurück existiert, falls nein wird eine Meldungs ausgegeben auf der HTML
			 */
			$stmt = $con->prepare("SELECT uid FROM backup WHERE timestamp BETWEEN ? AND ?");
			$stmt->bind_param('ii', $timestamp, $time);
			$stmt->execute();
			$stmt->bind_result($userid);
			$stmt->store_result();
			if($stmt->num_rows == 0){
				$lastupdate;
				$sql="SELECT MAX(timestamp) as timestamp FROM backup";
				$statemt = getsql($sql);
				while($ausgabe = $statemt->fetch_object()){
					$lastupdate=$ausgabe->timestamp;
				}
				$datum = date("d.m.Y - H:i",$lastupdate);
				$datum .= ";backup";
				echo $_GET['jsoncallback'].'('.json_encode($datum).');';#Rückgabe des Datum vom letzten BackUp
				exit();
			}else{
				$lastupdate;
				$sql="SELECT MAX(timestamp) as timestamp FROM backup";
				$statemt = getsql($sql);
				while($ausgabe = $statemt->fetch_object()){
					$lastupdate=$ausgabe->timestamp;
				}
				$datum = date("d.m.Y - H:i",$lastupdate);
				echo $_GET['jsoncallback'].'('.json_encode($datum).');';#Rückgabe des Datum vom letzten BackUp
				exit();
			}
		}else{
			echo $_GET['jsoncallback'].'('.json_encode("rights").');';#Rechteprüfung nicht bestanden
			exit();
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("token").');';#Token sind ungültig
		exit();
	}
	
?>