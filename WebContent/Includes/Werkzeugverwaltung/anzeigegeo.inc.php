<?php
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username'];
	$werknummer=$_GET['werkzeugnummer'];
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=0){
			$output="";
			$werkzeugID;
			$sql="SELECT * FROM stammdaten WHERE werkzeug_nummer='".$werknummer."' AND entfernt = 0";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$werkzeugID = $ausgabe->werkzeugID;
			}
			$sql="SELECT * FROM werkzeuggeometrie WHERE werkzeugID='".$werkzeugID."'";
			$statemt = getsql($sql);
			$output .= "<div class='table-responsive'><table class='table table-striped'>";
			$output .= "<thead class='thead-dark'>";
			$output .= "<tr><th>WerkzeugID</th><th>GeoID</th><th>Kavitaet</th><th>Position</th><th>Auswerfer</th><th>Bohrbild</th><th>Form</th><th>Aussenmass</th><th>MassAs</th><th>MassDs</th><th>Bezeichnung</th><th>Wert</th><th>Aktion</th>";
			$output .= "</tr></thead>";
			while($ausgabe = $statemt->fetch_object()){
				$werkzeuggeoID = $ausgabe->werkzeuggeoID;
				$kavitaet = $ausgabe->kavitaet;
				$position = $ausgabe->position;
				$auswerfer= $ausgabe->auswerfer;
			}
			
			
			$output .= "<tr><td>".$werkzeugID."</td><td>".$werkzeuggeoID."</td><td>".$kavitaet."</td><td>".$position."</td><td>".$auswerfer."</td>";
			
			
			
			$sql="SELECT * FROM werkzeuggeometrie WHERE werkzeugID='".$werkzeugID."'";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$bohrbild = $ausgabe->bohrbild;
				$form = $ausgabe->form;
				$ausmas = $ausgabe->ausmas;
				$massas= $ausgabe->massas;
				$massds= $ausgabe->massds;
			}
			$output .= "<td>".$bohrbild."</td><td>".$form."</td><td>".$ausmas."</td><td>".$massas."</td><td>".$massds."</td>";
			
			$sql="SELECT * FROM werkzeuggeoattr WHERE werkzeuggeoID='".$werkzeuggeoID."'";
			$statement = getsql($sql);
			
			while($ausgabe = $statement->fetch_object()){
				$bezeichnung = $ausgabe->bezeichnung;
				$wert = $ausgabe->wert;
				$output .= "<td>".$bezeichnung."</td><td>".$wert."</td>";
			}
			$output .="<td><button type='button' class='butosuccess'>Download</button></td>";
			
			
			
			$output .="</tr></table></div>";	
			echo $_GET['jsoncallback'].'('.json_encode($output).');';
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