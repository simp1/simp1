<?php

	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 	
	$path="backup_dump.sql";
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=10){
			$dbbezeichnung = "root";
			$password = "";
			$host = "127.0.0.1";
			$dbname = "project";
			
			$backup = exec('C:/xampp/mysql/bin/mysqldump --user=' . $dbbezeichnung . ' --password='. $password .' --host=' . $host . ' ' . $dbname . ' > ' . $path . '');
			backupstamp($username);
			echo $_GET['jsoncallback'].'('.json_encode("success").');';
			exit();
		}else{
			echo $_GET['jsoncallback'].'('.json_encode("rights").');';
			exit();
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("token").');';
		exit();
	}
?>