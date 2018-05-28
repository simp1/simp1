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
			$sql="SELECT * FROM werkzeug_pruef WHERE werkzeugID='".$werkzeugID."'";
			$statemt = getsql($sql);
			$output .= "<div class='table-responsive'><table class='table table-striped'>";
			$output .= "<thead class='thead-dark'>";
			$output .= "<tr><th>WerkzeugID</th><th>PruefID</th><th>Lfd</th><th>Datum</th><th>Pruefmerkmale</th>";
			$output .= "</tr></thead>";
			while($ausgabe = $statemt->fetch_object()){
				$laufendenummer = $ausgabe->laufendenummer;
				$datum = $ausgabe->datum;
				$pruefID = $ausgabe->pruefID;
				
				$output .= "<tr><td>".$werkzeugID."</td><td>".$pruefID."</td><td>".$laufendenummer."</td><td>".$datum."</td><td>";
				$sql="SELECT * FROM pruefmerkmale WHERE pruefID='".$pruefID."'";
				$statement = getsql($sql);
				while($ausgabe = $statement->fetch_object()){
					$beschreibung = $ausgabe->beschreibung;
					$wert = $ausgabe->wert;
					$output .= "<b>".$beschreibung.":</b> ".$wert." ";
				}
				$output .="</td></tr>";
			}
			
			$output .="</table></div>";	
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