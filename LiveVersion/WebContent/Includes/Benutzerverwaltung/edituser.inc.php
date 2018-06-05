<?php
	#bearbeitet den User
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
	if(!($admin>=0 && $admin<=1) || !($rights>=0 && $rights<=1)){
		echo $_GET['jsoncallback'].'('.json_encode("fehler").');';
		exit();
	}
	//prüft tokens
	if(checktoken($token,$token_login,$username_token)){
		$erg = status($username_token);
		if($erg>=100){
			if(empty($password)){
				$sql="SELECT password FROM benutzer WHERE username='".$username."';";
				$statemt = getsql($sql);
				while($ausgabe = $statemt->fetch_object()){
					$password=$ausgabe->password;
				}
			}else{
				$password = sha1($password);
			}
			$stmt = $con->prepare("SELECT username FROM benutzer WHERE username=?");
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$stmt->bind_result($userid);
			$stmt->store_result();
			if($stmt->num_rows == 1){
				$stmt = $con->prepare("UPDATE benutzer SET password=?, admin=?, rights=? WHERE username=? AND superadmin=?");
				$stmt->bind_param('siisi', $password, $admin, $rights, $username, $superadmin);
				$stmt->execute();
				echo $_GET['jsoncallback'].'('.json_encode("success").');';
				exit();
			}else{
				echo $_GET['jsoncallback'].'('.json_encode("exist").');';
				exit();
			}
		}elseif ($erg >= 10){
			if(empty($password)){
				$sql="SELECT password FROM benutzer WHERE username='".$username."';";
				$statemt = getsql($sql);
				while($ausgabe = $statemt->fetch_object()){
					$password=$ausgabe->password;
				}
			}else{
				$password = sha1($password);
			}
			$stmt = $con->prepare("SELECT username FROM benutzer WHERE username=?");
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$stmt->bind_result($userid);
			$stmt->store_result();
			if($stmt->num_rows == 1){
				$admin=0;
				$stmt = $con->prepare("UPDATE benutzer SET password=?, admin=?, rights=? WHERE username=? AND superadmin=?");
				$stmt->bind_param('siisi', $password, $admin, $rights, $username, $superadmin);
				$stmt->execute();
				echo $_GET['jsoncallback'].'('.json_encode("success").');';
				exit();
			}else{
				echo $_GET['jsoncallback'].'('.json_encode("exist").');';
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