<?php
	/*
	 * Erzeugt den DB Eintrag zum BackUp, wird aufgerufen beim Laden der Startseite und pr�ft wann das letzte Backup war
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
	 *  Auswerten der �bergabeparameter
	 */
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	if(checktoken($token,$token_login,$username)){#pr�ft die Session
		$erg = status($username);
		if($erg>=10){#pr�ft die Rechte
			$timestamp = time() - 604800;#Rechnet von jetzt 7 Tage zur�ck, als Timestamp
			$time = time();#aktuelle Zeit
			/*
			 * Pr�ft ob ein Zeitstemple vom Jetzt bis 7 Tage zur�ck existiert, falls nein wird eine Meldungs ausgegeben auf der HTML
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
				echo $_GET['jsoncallback'].'('.json_encode($datum).');';#R�ckgabe des Datum vom letzten BackUp
				exit();
			}else{
				$lastupdate;
				$sql="SELECT MAX(timestamp) as timestamp FROM backup";
				$statemt = getsql($sql);
				while($ausgabe = $statemt->fetch_object()){
					$lastupdate=$ausgabe->timestamp;
				}
				$datum = date("d.m.Y - H:i",$lastupdate);
				echo $_GET['jsoncallback'].'('.json_encode($datum).');';#R�ckgabe des Datum vom letzten BackUp
				exit();
			}
		}else{
			echo $_GET['jsoncallback'].'('.json_encode("rights").');';#Rechtepr�fung nicht bestanden
			exit();
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("token").');';#Token sind ung�ltig
		exit();
	}
	
?>