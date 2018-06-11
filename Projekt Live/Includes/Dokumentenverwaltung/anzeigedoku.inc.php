<?php
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	$antwort="";
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=1){
			$sql="SELECT * FROM dokumente";
			$statemt = getsql($sql);
			
			$antwort .= "<div class='table-responsive'><table class='table table-striped'>";
			
			$antwort .= "<thead class='thead-dark'>";
			
			$antwort .= "<tr><th>Name</th><th>Funktionen</th><th>Status</th></tr></thead>";
			
			while($ausgabe = $statemt->fetch_object()){
				$url = $ausgabe->url;
				$name = $ausgabe->bezeichnung;
				$format = $ausgabe->format;
				$id = $ausgabe->dokuID;
				$filename = '../../uploads/pdf/'.$name.'.'.$format;
				if (file_exists($filename)) {
					$antwort .= "<tr><td>".$name."</td><td><a href='".$url."' download><button class='butosuccess' type='button'>".$name."</button></a>   <button type='button' class='butosuccess' id=".$id." onClick='entfernen(id)'>Delete</button></td><td>Existiert</td></tr>";
				}else{
					$antwort .= "<tr><td>".$name."</td><td><button type='button' class='butosuccess abstandlinks' id=".$id." onClick='entfernen(id)'>Delete</button></td><td>Lost</td></tr>";
				}
			}
			$antwort .="</table></div>";
			echo $_GET['jsoncallback'].'('.json_encode($antwort).');';
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
