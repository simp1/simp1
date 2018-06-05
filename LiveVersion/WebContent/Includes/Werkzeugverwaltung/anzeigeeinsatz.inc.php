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
			$output .= "<tr><th>WerkzeugID</th><th>EinsatzID</th><th>Lfd</th><th>Datum</th><th>Schussnummer</th><th>Maschine</th><th>Kuehlung</th><th>Kuehldauer</th><th>Schliesskraft</th><th>Sonstige</th><th>Aktion</th><th>Dokumente</th>";
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
				
				$output .="</td>";
				if($erg>=1){
					$output .="<td><button type='button' id='".$einsatzID."' onclick='einsatzloeschen(id)' class='butosuccess'>entfernen</button></td>";
				}else{
					$output .="<td><button type='button' id='".$einsatzID."' onclick='norights()' class='butosuccess'>entfernen</button></td>";
				}
				$sql="SELECT * FROM dokumente WHERE einsatzID='".$einsatzID."'";
				$statemet = getsql($sql);
				$output .="<td>";
				while($ausgabe = $statemet->fetch_object()){
					$x=1;
					$bez = $ausgabe->bezeichnung;
					$url = $ausgabe->url;
					$bez = substr($bez, 0, 15);
					$output .="<a class='butosuccess' href='".$url."' download>".$bez."</a> ";
				}
				if($x==0){
					$output .="no document";
				}
				$output .="</td></tr>";
			}
			
			$output .="</table></div>";	
			
			$output .="Dokumente zum Werkzeugeinsatz<br>";
			$sql="SELECT * FROM dokumente WHERE werkzeugID='".$werkzeugID."' AND zuordnung='einsatz'";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$bez = $ausgabe->bezeichnung;
				$url = $ausgabe->url;
				$bez = substr($bez, 0, 25);
				$output .="<a class='btn btn-success' href='".$url."' download>".$bez."</a><br>";
			}
			
			
			
			$output .="</div>";
			
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