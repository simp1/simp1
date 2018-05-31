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
			$output .= "<div class='table-responsive'><table class='table table-striped'>";
			$output .= "<thead class='thead-dark'>";
			$output .= "<tr><th>Werkzeugnummer</th><th>WerkzeugID</th><th>Kurzbeschreibung</th><th>Werkzeugtyp</th><th>Drucker</th><th>Druckmaterial</th><th>Druckmodus</th><th>Herstelldatum</th><th>Schlagworte</th></tr></thead>";
			
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
				$output .= "<tr>";
				$output .= "<td>".$werkzeugnummer."</td><td>".$werkzeugID."</td><td>".$kurzbeschreibung."</td><td>".$typ."</td><td>".$drucker."</td><td>".$material."</td><td>".$modus."</td><td>".$hd."</td><td>".$sw."</td>";
				
			}
				$output .="</tr></table></div>";
				
				//Attribute
				$output .= "<div class='row'>";
				$output .= "<div class='table-responsive col-md-8'><table class='table table-striped'>";
				$output .= "<thead class='thead-dark'>";
				$output .= "<tr><th>Attributsbeschreibung</th><th>Attributswert</th><th>Aktion</th></tr></thead>";
				
				$sql="SELECT * FROM werkzeug_attribute WHERE werkzeugID='".$werkzeugID."'";
				$statemt = getsql($sql);
				while($ausgabe = $statemt->fetch_object()){
					$bez = $ausgabe->bezeichnung;
					$val = $ausgabe->wert;
					$id_attr = $ausgabe->werkzeug_attID;
					$output .= "<td>".$bez."</td>"; //Werkzeugattribute
					$output .= "<td>".$val."</td>"; //Werkzeugattribute
					if($erg>=1){
					    $output .="<td><button type='button' class='butosuccess'>entfernen</button></tr></td>";//
					}else{
						$output .="<td><button type='button' class='butosuccess'>entfernen</button></tr></td>";
					}
				}
				$output .="</table></div>";

			
			//QR-Code
			
			$output .="<div class='col-md-4'>";
			$stmt = $con->prepare("SELECT svg FROM qrcode WHERE werkzeugID=?");
			$stmt->bind_param('i', $werkzeugID);
			$stmt->execute();
			$stmt->bind_result($userid);
			$stmt->store_result();
			if($stmt->num_rows != 0){
				$sql="SELECT svg FROM qrcode WHERE werkzeugID='".$werkzeugID."';";
				$statemnt = getsql($sql);
				while($ausgabe = $statemnt->fetch_object()){
					$imgsrc = $ausgabe->svg;
				}
				$output .= "<img id='imgqrcode' src='".$imgsrc."'>";
				if($erg>=1){
				    $output .="<button type='button' class='butosuccess' id=".$werkzeugnummer." onClick='openqr(id)'>QR-Code</button>";
				}else{
				    $output .="<button type='button' class='butosuccess' id=".$werkzeugnummer." onClick='norights()'>QR-Code</button>";
				}
			}
			
			$output .="</div>";
			
			$output .="</div>";
			$output .="<div>";
			
			$output .="Dokumente zum Werkzeug<br>";
			$sql="SELECT * FROM dokumente WHERE werkzeugID='".$werkzeugID."' AND zuordnung='werkzeug'";
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