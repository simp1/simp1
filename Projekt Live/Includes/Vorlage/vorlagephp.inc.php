<?php
	#Was macht die Datei?
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	#Includes
	include '../functions.inc.php';
	include '../config.inc.php';
	#Notwendige �bergabeparameter
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	if(checktoken($token,$token_login,$username)){#Pr�ft die Tokens
		$erg = status($username);
		if($erg>=0){#Pr�ft die Rechte, momentan mindestens Leserechte
			
		}else{
			echo $_GET['jsoncallback'].'('.json_encode("rights").');';
			exit();
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("token").');';
		exit();
	}
	
?>