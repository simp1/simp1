<?php
	#löscht den User
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	

	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username_token=$_GET['username_token'];
	$username=$_GET['username'];
	//prüft tokens
	if(checktoken($token,$token_login,$username_token)){
		$stmt = $con->prepare("SELECT username FROM benutzer WHERE username=?");
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->bind_result($userid);
		$stmt->store_result();
		if($stmt->num_rows == 1){
			$stmt = $con->prepare("UPDATE benutzer SET entfernt=1 WHERE username=? AND superadmin=0");#setzt den User inaktiv
			$stmt->bind_param('s', $username);
			$stmt->execute();
			echo $_GET['jsoncallback'].'('.json_encode("success").');';
			exit();
		}else{
			echo $_GET['jsoncallback'].'('.json_encode("exist").');';
			exit();
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("token").');';
		exit();
	}
	

?>