<?php
	/*
	 * Erzeugt die MySQLdump mittels /usr/bin/mysqldump Datei und speichert diesen im BackUp Ordner unter dem Namen backup_dump.sql
	 */
	session_start();#startet die Session
	header('Access-Control-Allow-Origin:*');#erlaubt Zugriff von außerhalb
	header('Access-Control-Allow-Methods: GET');#lässt nur Zugriff mittels einer GET Methode zu
	/*
	 * Include/Laden der Configdatei und der Functions
	 */
	include '../functions.inc.php';
	include '../config.inc.php';
	/*
	 * Auswerten der Übergabeparameter
	 */
	$token=$_GET['token'];
	$token_login=$_GET['token_login'];
	$username=$_GET['username']; 
	/*
	 * Definieren der Variablen in der man den Path abspeichert
	 */
	$path="backup_dump.sql";
	if(checktoken($token,$token_login,$username)){#verwendet die Funktion checktoken aus functions
		$erg = status($username);#verwendet die Funktion status aus functions
		if($erg>=10){#Nutzer muss mindestens Adminrechte haben
			$dbbezeichnung = "root";#Login für die DB
			$password = "master";#Passwort für die DB
			$host = "127.0.0.1";#IP der Datenbank
			$dbnamepro = "winprj01";#Name der Datenbank
			/*
			 * Verwendet den Executebefehl um eine Datei auf dem Server auszuführen
			 */
			$backup = exec('../../../../../../usr/bin/mysqldump --user=' . $dbbezeichnung . ' --password='. $password .' --host=' . $host . ' ' . $dbnamepro . ' > ' . $path . '');
			backupstamp($username);#macht einen DB Eintrag sobald das Backup durch ist, wann das BackUp war
			echo $_GET['jsoncallback'].'('.json_encode("success").');';#Rückgabe wenn alles geklappt hat success für Erfolg
			exit();#Ende
		}else{
			echo $_GET['jsoncallback'].'('.json_encode("rights").');';#Prüfung der Rechte nicht Bestanden
			exit();
		}
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("token").');';#Tokens sind ungültig
		exit();
	}
?>