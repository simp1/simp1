<?php
	#Anlegen der Werkzeuggeometrie
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	$werkzeugID;
	$kavitaet=$_GET['kavitaet'];
	$werkzeugnummer = $_GET['werkzeugID'];
	$as = $_GET['as'];
	$ds = $_GET['ds'];
	$ausmas = $_GET['ausmas'];
	$auswerfer = $_GET['auswerfer'];
	$form = $_GET['form'];
	$position = $_GET['position'];
	$bohrbild = $_GET['bohrbild'];
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>0){
			$sql="SELECT * FROM stammdaten WHERE werkzeug_nummer='".$werkzeugnummer."' AND entfernt=0";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$werkzeugID = $ausgabe->werkzeugID;
			}
			$stmt = $con->prepare("INSERT INTO werkzeuggeometrie (werkzeugID, kavitaet, position, auswerfer, bohrbild, form, ausmas, massas, massds ) VALUES (?,?,?,?,?,?,?,?,?)");
			$stmt->bind_param('ississsss', $werkzeugID, $kavitaet, $position, $auswerfer, $bohrbild, $form ,$ausmas, $as, $ds);
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