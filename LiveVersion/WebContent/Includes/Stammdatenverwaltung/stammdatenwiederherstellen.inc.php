<?php
	#Anzeigen des Stammdatensatz
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	#gets die �bergeben werden
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=1){
			$output="";
			$output .= "<div class='table-responsive'><table class='table table-striped'>";
			$output .= "<thead class='thead-dark'>";
			
			$output .= "<tr><th>Werkzeugnummer</th><th>WerkzeugID</th><th>Kurzbeschreibung</th><th>Werkzeugtyp</th><th>Drucker</th><th>Druckmaterial</th><th>Druckmodus</th><th>Herstelldatum</th><th>Schlagworte</th><th>Aktion</th></tr></thead>";
			
			#Anzuzeigende werte
			$sql="SELECT * FROM stammdaten WHERE entfernt=1";
			$statemt = getsql($sql);
			while($ausgabe = $statemt->fetch_object()){
				$werkzeugID = $ausgabe->werkzeugID;
				$werkzeugnummer = $ausgabe->werkzeug_nummer;
				$typ = $ausgabe->type;
				$kurzbeschreibung = $ausgabe->kurzbeschreibung;
				$drucker = $ausgabe->drucker;
				$material = $ausgabe->druckmaterial;
				$modus = $ausgabe->druckmodus;
				$hd = $ausgabe->herstelldatum;
				$sw="";
				$sql="SELECT * FROM schlagwort WHERE werkzeugID ='".$werkzeugID."'";
				$statement = getsql($sql);
				while($op = $statement->fetch_object()){
					$wort = $op->schlagwort;
					if(empty($wort)){
						
					}else{
						$sw .= $wort.", ";
					}
				}
				$sw .= $werkzeugID;
				$output .= "<tr>";
				$output .= "<td>".$werkzeugnummer."</td><td>".$werkzeugID."</td><td>".$kurzbeschreibung."</td><td>".$typ."</td><td>".$drucker."</td><td>".$material."</td><td>".$modus."</td><td>".$hd."</td><td>".$sw."</td>";
				
			    $output .="<td><button type='button' class='butosuccess' id=".$werkzeugID." onClick='activate(id)'>Wiederherstellen</button></td></tr>";

			}
			$output .="</div></table>";

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