<?php
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=10){
			$timestamp = time() - 604800;
			$time = time();
			$stmt = $con->prepare("SELECT uid FROM backup WHERE timestamp BETWEEN ? AND ?");
			$stmt->bind_param('ii', $timestamp, $time);
			$stmt->execute();
			$stmt->bind_result($userid);
			$stmt->store_result();
			if($stmt->num_rows == 0){
				$lastupdate;
				$sql="SELECT MAX(timestamp) as timestamp FROM backup";
				$statemt = getsql($sql);
				while($ausgabe = $statemt->fetch_object()){
					$lastupdate=$ausgabe->timestamp;
				}
				$datum = date("d.m.Y - H:i",$lastupdate);
				$datum .= ";backup";
				echo $_GET['jsoncallback'].'('.json_encode($datum).');';
				exit();
			}else{
				$lastupdate;
				$sql="SELECT MAX(timestamp) as timestamp FROM backup";
				$statemt = getsql($sql);
				while($ausgabe = $statemt->fetch_object()){
					$lastupdate=$ausgabe->timestamp;
				}
				$datum = date("d.m.Y - H:i",$lastupdate);
				echo $_GET['jsoncallback'].'('.json_encode($datum).');';
				exit();
			}
		}else{
			echo $_GET['jsoncallback'].'('.json_encode("rights").');';
			exit();
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("token").');';
		exit();
	}
	
?>