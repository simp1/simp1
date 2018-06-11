<?php
	#Prüft die Rechte des Admins
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	include 'functions.inc.php';
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username'];
	//Prüft die Login Daten
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>1){#mindestens Admin
			echo $_GET['jsoncallback'].'('.json_encode("success").');';#Erfolg also mindestens Adminuser
			exit();
		}else{
			echo $_GET['jsoncallback'].'('.json_encode("norights").');';#kein Admin
			exit();
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("fehler").');';#kein Valider User
		exit();
	}

?>