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
	$werknummer=$_GET['werkzeugnummer'];
	if(checktoken($token,$token_login,$username)){
		$erg = status($username);
		if($erg>=0){
			$output="";
			#Anzuzeigende werte
			$werkzeugID;
			$imgsrc;
			$sql="SELECT * FROM stammdaten WHERE werkzeug_nummer='".$werknummer."' AND entfernt = 0";
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
				$output .="</div></table>";
				$output .= "<div class='table-responsive'><table class='table table-striped'>";
				$sql="SELECT * FROM werkzeug_attribute WHERE werkzeugID='".$werkzeugID."'";
				$statemt = getsql($sql);
				while($ausgabe = $statemt->fetch_object()){
					$bez = $ausgabe->bezeichnung;
					$val = $ausgabe->wert;
					$id_attr = $ausgabe->werkzeug_attID;
					$output .= "<tr><td>".$bez."</td><td>".$val."</td>";
					if($erg>=1){
						$output .="<td><button type='button' class='butosuccess' id=".$id_attr." onClick='entfernen(id)'>entfernen</button></td></tr>";
					}else{
						$output .="<td><button type='button' class='butosuccess' id=".$id_attr." onClick='norights()'>entfernen</button></td></tr>";
					}
				}
				$output .="</table></div>";	
			}
			$stmt = $con->prepare("SELECT svg FROM qrcode WHERE werkzeugID=?");
			$stmt->bind_param('i', $werkzeugID);
			$stmt->execute();
			$stmt->bind_result($userid);
			$stmt->store_result();
			if($stmt->num_rows == 1){
				$sql="SELECT svg FROM qrcode WHERE werkzeugID='".$werkzeugID."';";
				$statemnt = getsql($sql);
				while($ausgabe = $statemnt->fetch_object()){
					$imgsrc = $ausgabe->svg;
				}
				$output .= "<img src='".$imgsrc."'>";
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