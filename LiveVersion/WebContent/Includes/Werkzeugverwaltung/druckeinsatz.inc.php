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
			$sql="SELECT * FROM werkzeug_einsatz WHERE werkzeugID='".$werkzeugID."'";
			$statemt = getsql($sql);
			$output .= "<div class='table-responsive'><table class='table table-striped'>";
			$output .= "<thead class='thead-dark'>";
			$output .= "<tr><th>WerkzeugID</th><th>EinsatzID</th><th>Lfd</th><th>Datum</th><th>Schussnummer</th><th>Maschine</th><th>Kuehlung</th><th>Kuehldauer</th><th>Schliesskraft</th><th>Sonstige</th>";
			$output .= "</tr></thead>";
			while($ausgabe = $statemt->fetch_object()){
				$x=0;
				$laufendenummer = $ausgabe->laufendenummer;
				$datum = $ausgabe->datum;
				$einsatzID = $ausgabe->einsatzID;
				$maschine = $ausgabe->maschine ;
				$kuehlung = $ausgabe->kuehlung;
				$kuehldauer = $ausgabe->kuehldauer;
				$schussnummer = $ausgabe->schussnummer;
				$schliesskraft = $ausgabe->schliesskraft;
				
				$output .= "<tr><td>".$werkzeugID."</td><td>".$einsatzID."</td><td>".$laufendenummer."</td><td>".$datum."</td><td>".$schussnummer."</td><td>".$maschine."</td><td>".$kuehlung."</td><td>".$kuehldauer."</td><td>".$schliesskraft."</td><td>";
				$sql="SELECT * FROM einsatzattr WHERE einsatzID='".$einsatzID."'";
				$statement = getsql($sql);
				while($ausgabe = $statement->fetch_object()){
					$bezeichnung = $ausgabe->bezeichnung;
					$wert = $ausgabe->wert;
					$output .= "<b>".$bezeichnung.":</b> ".$wert." ";
				}
				
				
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