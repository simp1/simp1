<?php
	#Anzeige des Werkzeugprotokolls
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
			$output .= "<tr><th>WerkzeugID</th><th>PruefID</th><th>Lfd</th><th>Datum</th><th>Pruefmerkmale</th><th>Aktion</th><th>Dokumente</th>";
			$output .= "</tr></thead>";
			while($ausgabe = $statemt->fetch_object()){
				$x=0;
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
				$output .="</td>";
				if($erg>=1){
					$output .="<td><button type='button' id='".$pruefID."' onclick='pruefloeschen(id)' class='butosuccess'>entfernen</button></td>";
				}else{
					$output .="<td><button type='button' id='".$pruefIDID."' onclick='norights()' class='butosuccess'>entfernen</button></td>";
				}
				$sql="SELECT * FROM dokumente WHERE pruefID='".$pruefID."'";
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
				$output .="</th></tr>";
			}
			
			$output .="</table></div>";	
			
			$output .="Dokumente zum Werkzeugprotokoll<br>";
			$sql="SELECT * FROM dokumente WHERE werkzeugID='".$werkzeugID."' AND zuordnung='pruef'";
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