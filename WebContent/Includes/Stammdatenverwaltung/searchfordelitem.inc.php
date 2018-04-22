<?php
	#Anzeigen des Stammdatensatz
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	include '../config.inc.php';
	#gets die übergeben werden
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	$suchwort=$_GET['suchwort'];
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=0){
			$output="";
			#Anzuzeigende werte
			$sql="SELECT * FROM stammdaten LEFT JOIN schlagwort ON stammdaten.werkzeugID = schlagwort.werkzeugID WHERE schlagwort.schlagwort like '%".$suchwort."%' AND stammdaten.entfernt = 1 GROUP BY stammdaten.werkzeugID";
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
				$output .= "<div class='table-responsive'><table class='table table-striped'>";
				$output .= "<tr><td>Werkzeugnummer</td><td>".$werkzeugnummer."</td><td>Drucker</td><td>".$drucker."</td></tr>";
				$output .= "<tr><td>WerkzeugID</td><td>".$werkzeugID."</td><td>Druckmaterial</td><td>".$material."</td></tr>";
				$output .= "<tr><td>Kurzbeschreibung</td><td>".$kurzbeschreibung."</td><td>Druckmodus</td><td>".$modus."</td></tr>";
				$output .= "<tr><td>Werkzeugtyp</td><td>".$typ."</td><td>Herstelldatum</td><td>".$hd."</td></tr>";
				$output .= "<tr><td>Schlagworte</td><td colspan='3'>".$sw."</td></tr>";
				if($erg>=1){
					$output .="<tr><td><button type='button' class='butosuccess' id=".$werkzeugID." onClick='activate(id)'>Wiederherstellen</button></td></tr>";
				}else{
					$output .="<tr><td><button type='button' class='butosuccess' id=".$werkzeugID." onClick='norights()'>Wiederherstellen</button></td></tr>";
				}
				$output .="</div></table>";
				
			}
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