<?php
#Prüft die Tokens
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	include '../functions.inc.php';
	
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username'];
	//Prüft die Login Daten
	if(checktoken($token,$token_login,$username)){
		//Prüft Rechte
		$erg = status($username);
		if($erg>=100){
			echo $_GET['jsoncallback'].'('.json_encode("sadmin").');';
			exit();
		}else if($erg>=10){
			echo $_GET['jsoncallback'].'('.json_encode("admin").');';
			exit();
		}else{
			echo $_GET['jsoncallback'].'('.json_encode("noadmin").');';
			exit();
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("fehler").');';
		exit();
	}

?>