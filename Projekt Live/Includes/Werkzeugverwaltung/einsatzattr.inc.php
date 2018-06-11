<?php
	#erstellen des Einsatzattributes
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	$lfd = $_GET['lfd'];
	$wert = $_GET['wert'];
	$bez= $_GET['bez'];
	$einsatzID;
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>0){
			$sql="SELECT * FROM werkzeug_einsatz WHERE laufendenummer='".$lfd."'";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$einsatzID = $ausgabe->einsatzID;
			}
			
			$stmt = $con->prepare("INSERT INTO einsatzattr (einsatzID, bezeichnung, wert) VALUES (?,?,?)");
			$stmt->bind_param('iss', $einsatzID, $bez, $wert);
			$stmt->execute();
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