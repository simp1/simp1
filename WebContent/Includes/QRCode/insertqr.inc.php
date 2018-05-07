<?php
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	$parts  = $_POST['datastring'];
	$teile = explode(";;",$parts);
	$token=$teile[3];
	$token_login=$teile[4];
	$username=$teile[2];
	$werkzeugID=$teile[0];
	$qr=$teile[1];
	$qr = str_replace(' ','+',$qr);
	$link =$teile[5];

	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=1){
			$sql="INSERT INTO qrcode (werkzeugID,svg,link) VALUES (?,?,?)";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('iss', $werkzeugID, $qr, $link);
			$stmt->execute();
			echo "success";
			exit();
		}else{
			echo "rights";
			exit();
		}
	}else{
		echo "token";
		exit();
	}
	
?>