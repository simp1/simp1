<?php
#Gibt die Gelöschten User an
	session_start();
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods: GET');
	
	include '../functions.inc.php';
	
	$username = $_GET['username'];
	$antwort="";
	$erg = status($username);
	if($erg>=100){
		$sql="SELECT * FROM benutzer WHERE entfernt=1";
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
			$superadmin = $ausgabe->superadmin;
			$antwort .="<tr>";
			$antwort .= "<td>".$uid."</td><td>".$pwd."</td><td>".$admin."</td><td>".$rights."</td>";
			if($superadmin==0){
				$antwort .="<td><button type='button' id=".$uid." class='butosuccess' onClick='recreate(id)'>wiederherstellen</button></td>";
			}else{
				$antwort .="<td><button type='button' id=".$uid." class='butosuccess' onClick='norights()'>wiederherstellen</button></td>";
			}
			$antwort .="</tr>";
		}
		$antwort .="</div></table>";
		echo $_GET['jsoncallback'].'('.json_encode($antwort).');';
		exit();
	}elseif ($erg>=10){
		$sql="SELECT * FROM benutzer WHERE entfernt=1";
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
				$antwort .="<td><button type='button' class='butosuccess' id=".$uid." onClick='recreate(id)'>wiederherstellen</button></td>";
			}else{
				$antwort .="<td><button type='button' class='butosuccess' id=".$uid." onClick='norights()'>wiederherstellen</button></td>";
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