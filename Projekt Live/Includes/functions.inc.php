<?php
	/*
	 * Kann nicht von außerhalb aufgerufen werden durch GET, POST,PUT...
	 */
	//SQL Anfrage werden hier ausgewertet und eine ergebnis zurückgeliefert
	function getsql($query) {#Normale SQL Abfragen
		include 'config.inc.php';
		$ergebnis = $con->query($query);
		return $ergebnis;
	
	}
	//Prüft das Token, wird für Tokens verwendet
	function checktoken($token,$token_login,$username) {#übergeben wird Token, Token_login und Username
		include 'config.inc.php';#Config wird reingeladen für die Methode
		$userid;#Variable deklariert
		$erg;
		$time_tab=time();#Zeitstemple
		$stmt = $con->prepare("SELECT username FROM tokens WHERE token=? AND token_login=?");#prepared Statement mit erhöhter Sicherheit
		$stmt->bind_param('ss', $token, $token_login);
		$stmt->execute();
		$stmt->bind_result($userid);
		$stmt->store_result();
		if($stmt->num_rows == 1){#Token wurde gefunden, Zeitstempel zum Token wird abgefragt
			$sql="SELECT timestamp FROM tokens WHERE username='".$username."';";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$erg = $ausgabe->timestamp;
			}
			$time_tab=$time_tab - $erg;
		}else{
			return false;
		}
		if($time_tab>18000){//Gab es innerhalb 1500 min aktivität!
			return false;
		}else{#Token ist noch gültig und der Zeitstemple zum Token wird aktualisiert und in die DB geschrieben
			$timestamp=time();
			$stmt = $con->prepare("UPDATE tokens SET timestamp=? WHERE username=?");
			$stmt->bind_param('is', $timestamp, $username);
			$stmt->execute();
			return true;
		}
		$stmt->close();#Statement wird geschlossen
	}
	//Generiert die IP Addresse des Benutzers
	function getUserIpAddr(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	// gibt rechte des nutzers zurück
	function status($username){
		$sql="SELECT * FROM benutzer WHERE username='".$username."';";
		$statemt = getsql($sql);
		$superadmin;
		$admin;
		$rights;
		while($ausgabe = $statemt->fetch_object()){
			$superadmin = $ausgabe->superadmin;
			$admin = $ausgabe->admin;
			$rights = $ausgabe->rights;
		}
		$erg = "".$superadmin."".$admin."".$rights;#Beispiel ist jemand Superadmin=> 100, bei einem Admin wäre das 010, Schreibrechte 001
		return $erg;
	}
	// Zeitstempel für das BackUp
	function backupstamp($username){
		include 'config.inc.php';
		$erg = status($username);
		if($erg>=10){
			$timestamp=time();
			$sql="INSERT INTO backup (uid,timestamp) VALUES (?,?)";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('si', $username, $timestamp);
			$stmt->execute();
			
		}
		
	}

?>