<?php
	#löscht das Attribut
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	

	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username'];
	$attrID=$_GET['attrID'];
	$userid;
	//prüft tokens
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=1){
			$stmt = $con->prepare("SELECT geoattrID FROM werkzeuggeoID WHERE geoattrID=?");
			$stmt->bind_param('i', $attrID);
			$stmt->execute();
			$stmt->bind_result($userid);
			$stmt->store_result();
			if($stmt->num_rows == 1){
				$stmt = $con->prepare("DELETE FROM werkzeuggeoID WHERE geoattrID=?");
				$stmt->bind_param('i', $attrID);
				$stmt->execute();
				echo $_GET['jsoncallback'].'('.json_encode("success").');';
				exit();
			}else{
				echo $_GET['jsoncallback'].'('.json_encode("exist").');';
				exit();
			}
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("token").');';
		exit();
	}
	

?>