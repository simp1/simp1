<?php
	#Erstellt den User
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	
	$superadmin =0;
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username_token=$_GET['username_token'];
	$username=$_GET['username'];
	$password = $_GET['password'];
	$admin = $_GET['admin'];
	$rights = $_GET['rights'];
	$password = sha1($password);
	if(!($admin>=0 && $admin<=1) || !($rights>=0 && $rights<=1)){
		echo $_GET['jsoncallback'].'('.json_encode("fehler").');';
		exit();
	}
	//prüft tokens
	if(checktoken($token,$token_login,$username_token)){
		$erg = status($username_token);
		if($erg>=100){
			$stmt = $con->prepare("SELECT username FROM benutzer WHERE username=?");
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$stmt->bind_result($userid);
			$stmt->store_result();
			if($stmt->num_rows == 1){
				echo $_GET['jsoncallback'].'('.json_encode("doppelt").');';
				exit();
			}else{
				$stmt = $con->prepare("INSERT INTO benutzer (username,password,admin,rights,superadmin) VALUES (?,?,?,?,?)");
				$stmt->bind_param('ssiii', $username, $password, $admin, $rights, $superadmin);
				$stmt->execute();
				$stmt = $con->prepare("SELECT username FROM benutzer WHERE username=?");
				$stmt->bind_param('s', $username);
				$stmt->execute();
				$stmt->bind_result($userid);
				$stmt->store_result();
				if($stmt->num_rows == 1){
					echo $_GET['jsoncallback'].'('.json_encode("success").');';
					exit();
				}
				echo $_GET['jsoncallback'].'('.json_encode("fehler").');';
				exit();
			}
		}elseif ($erg>=10){
			$stmt = $con->prepare("SELECT username FROM benutzer WHERE username=?");
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$stmt->bind_result($userid);
			$stmt->store_result();
			if($stmt->num_rows == 1){
				echo $_GET['jsoncallback'].'('.json_encode("doppelt").');';
				exit();
			}else{
				$admin = 0;
				$stmt = $con->prepare("INSERT INTO benutzer (username,password,admin,rights,superadmin) VALUES (?,?,?,?,?)");
				$stmt->bind_param('ssiii', $username, $password, $admin, $rights, $superadmin);
				$stmt->execute();
				$stmt = $con->prepare("SELECT username FROM benutzer WHERE username=?");
				$stmt->bind_param('s', $username);
				$stmt->execute();
				$stmt->bind_result($userid);
				$stmt->store_result();
				if($stmt->num_rows == 1){
					echo $_GET['jsoncallback'].'('.json_encode("success").');';
					exit();
				}
				echo $_GET['jsoncallback'].'('.json_encode("fehler").');';
				exit();
			}
		}else{
			echo $_GET['jsoncallback'].'('.json_encode("fehler").');';
			exit();
		}
		
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("token").');';
		exit();
	}
	

?>