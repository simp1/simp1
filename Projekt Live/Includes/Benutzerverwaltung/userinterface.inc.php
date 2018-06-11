<?php
#Gibt die Aktiven User an, mit allen Funktionsbuttons
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	
	$username = $_GET['username'];
	$antwort="";
	$erg = status($username);
	if($erg>=100){
		$sql="SELECT * FROM benutzer WHERE entfernt=0";
		$statemt = getsql($sql);
		$uid;
		$pwd;
		$admin;
		$rights;
		$antwort .= "<div class='table-responsive'><table class='table table-striped'>";
		
		$antwort .= "<thead class='thead-dark'>";
		
		$antwort .= "<tr><th>Benutzername</th><th>Passwort</th><th>Adminstatus</th><th>Rechte</th><th>Funktionen</th><th></th></tr></thead>";
		
		while($ausgabe = $statemt->fetch_object()){
			$uid = $ausgabe->username;
			$pwd = $ausgabe->password;
			$admin = $ausgabe->admin;
			$rights = $ausgabe->rights;
			$superadmin = $ausgabe->superadmin;
			$antwort .="<tr>";
			$antwort .= "<td>".$uid."</td><td>".$pwd."</td><td>".$admin."</td><td>".$rights."</td>";
			if($superadmin==0){
				$antwort .="<td><button type='button' class='butosuccess' id=".$uid." onClick='editieren(id)'>editieren</button></td>";
				$antwort .="<td><button type='button' class='butosuccess' id=".$uid." onClick='entfernen(id)'>entfernen</button></td>";
			}else{
				$antwort .="<td><button type='button' class='butosuccess' id=".$uid." onClick='norights()'>editieren</button></td>";
				$antwort .="<td><button type='button' class='butosuccess' id=".$uid." onClick='norights()'>entfernen</button></td>";
			}
			$antwort .="</tr>";
		}
		$antwort .="</div></table>";
		echo $_GET['jsoncallback'].'('.json_encode($antwort).');';
		exit();
	}else if($erg>=10){
		$sql="SELECT * FROM benutzer WHERE entfernt=0";
		$statemt = getsql($sql);
		$uid;
		$pwd;
		$admin;
		$rights;
		$antwort .= "<div class='table-responsive'><table class='table table-striped'>";
		$antwort .= "<tr><th>Benutzername</th><th>Passwort</th><th>Adminstatus</th><th>Rechte</th><th>Funktionen</th><th></th></tr>";
		while($ausgabe = $statemt->fetch_object()){
			$uid = $ausgabe->username;
			$pwd = $ausgabe->password;
			$admin = $ausgabe->admin;
			$rights = $ausgabe->rights;
			$superadmin =$ausgabe->superadmin;
			$antwort .="<tr>";
			$antwort .= "<td>".$uid."</td><td>".$pwd."</td><td>".$admin."</td><td>".$rights."</td>";
			if($superadmin==0&&$admin==0){
				$antwort .="<td><button type='button' class='butosuccess' id=".$uid." onClick='editieren(id)'>editieren</button></td>";
				$antwort .="<td><button type='button' class='butosuccess' id=".$uid." onClick='entfernen(id)'>entfernen</button></td>";
			}else{
				$antwort .="<td><button type='button' class='butosuccess' id=".$uid." onClick='norights()'>editieren</button></td>";
				$antwort .="<td><button type='button' class='butosuccess' id=".$uid." onClick='norights()'>entfernen</button></td>";
			}
			$antwort .="</tr>";
		}
		$antwort .="</div></table>";
		echo $_GET['jsoncallback'].'('.json_encode($antwort).');';
		exit();			
	}else{
		echo $_GET['jsoncallback'].'('.json_encode($antwort).');';
		exit();
	}
?>