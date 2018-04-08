<?php
	//SQL Anfrage
	function getsql($query) {
		include 'config.inc.php';
		$ergebnis = $con->query($query);
		return $ergebnis;
	
	}
	//Prüft das Token
	function checktoken($token,$token_login,$username) {
		include 'config.inc.php';
		$userid;
		$erg;
		$time_tab=time();
		$stmt = $con->prepare("SELECT username FROM tokens WHERE token=? AND token_login=?");
		$stmt->bind_param('ss', $token, $token_login);
		$stmt->execute();
		$stmt->bind_result($userid);
		$stmt->store_result();
		if($stmt->num_rows == 1){
			$sql="SELECT timestamp FROM tokens WHERE username='".$username."';";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$erg = $ausgabe->timestamp;
			}
			$time_tab=$time_tab - $erg;
		}else{
			return false;
		}
		if($time_tab>90000){//Gab es innerhalb 1500 min aktivität!
			return false;
		}else{
			$timestamp=time();
			$stmt = $con->prepare("UPDATE tokens SET timestamp=? WHERE username=?");
			$stmt->bind_param('is', $timestamp, $username);
			$stmt->execute();
			return true;
		}
		$stmt->close();
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
		$erg = "".$superadmin."".$admin."".$rights;
		return $erg;
	}

?>