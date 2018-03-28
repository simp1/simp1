<?php	
#Login Erstellt Tokens und prüft den User
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include 'functions.inc.php';
	include 'config.inc.php';
	
	$username = $_GET['username'];
	$pwd = $_GET['password'];
	$pwd = sha1($pwd);
	$ip = getUserIpAddr();
	$token = sha1(md5(time()));
	$token_login = sha1(md5($ip));
	$timestamp = time();
	$antwort="".$token.":".$token_login;
	if(empty($pwd)||empty($username)){
		echo "empty";
		exit();
	}	
	$sql="SELECT * FROM benutzer WHERE username='".$username."' AND password='".$pwd."' AND entfernt=0;";
	$statemt = getsql($sql);
	while($ausgabe = $statemt->fetch_object()){
		$stmt = $con->prepare("SELECT username FROM tokens WHERE username=?");
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->bind_result($userid);
		$stmt->store_result();
		if($stmt->num_rows == 1){
			$stmt = $con->prepare("UPDATE tokens SET timestamp=?, token=?, token_login=?, lastip=? WHERE username=?");
			$stmt->bind_param('issis', $timestamp, $token, $token_login, $ip, $username);
			$stmt->execute();
			echo $_GET['jsoncallback'].'('.json_encode($antwort).');';
			exit();
		}else{
			$stmt = $con->prepare("INSERT INTO tokens (timestamp,token,token_login,lastip,username) VALUES (?,?,?,?,?)");
			$stmt->bind_param('issis', $timestamp, $token, $token_login, $ip, $username);
			$stmt->execute();
			echo $_GET['jsoncallback'].'('.json_encode($antwort).');';
			exit();
		}
		
	}
	echo "error";
	exit();
?>