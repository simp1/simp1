<?php	
	#Login Erstellt Tokens und prüft den User
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');#Nur GET erlaubt
	
	include 'functions.inc.php';
	include 'config.inc.php';
	
	$username = $_GET['username'];
	$pwd = $_GET['password'];
	$pwd = sha1($pwd);#Sha1 verschlüsselung da md5 unsicher ist
	$ip = getUserIpAddr();#Bindet den Account an die IP
	$token = sha1(md5(time()));#doppelt verschlüsseltes Token von einem Zeitstempel
	$token_login = sha1(md5($ip));#doppelt verschlüsseltes Token von der IP
	$timestamp = time();
	$antwort="".$token.":".$token_login;#Rückgabewert der Tokens an die WebSeite
	if(empty($pwd)||empty($username)){#Prüft ob beide Angaben Username und Passwort nicht leer sind
		echo "empty";
		exit();
	}	
	$sql="SELECT * FROM benutzer WHERE username='".$username."' AND password='".$pwd."' AND entfernt=0;";#Ist der User noch aktiv
	$statemt = getsql($sql);
	while($ausgabe = $statemt->fetch_object()){
		$stmt = $con->prepare("SELECT username FROM tokens WHERE username=?");#Gibt es den Nutzer oder muss ich einen neuen Eintrag erzeugen
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->bind_result($userid);
		$stmt->store_result();
		if($stmt->num_rows == 1){
			$stmt = $con->prepare("UPDATE tokens SET timestamp=?, token=?, token_login=?, lastip=? WHERE username=?");#Updaten der Tokens eines alten Eintrags
			$stmt->bind_param('issis', $timestamp, $token, $token_login, $ip, $username);
			$stmt->execute();
			echo $_GET['jsoncallback'].'('.json_encode($antwort).');';
			exit();
		}else{
			$stmt = $con->prepare("INSERT INTO tokens (timestamp,token,token_login,lastip,username) VALUES (?,?,?,?,?)");#Neuanlegen eines Nutzers
			$stmt->bind_param('issis', $timestamp, $token, $token_login, $ip, $username);
			$stmt->execute();
			echo $_GET['jsoncallback'].'('.json_encode($antwort).');';
			exit();
		}
		
	}
	echo "error";#unbekannter Fehler
	exit();
?>