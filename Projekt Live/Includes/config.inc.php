<?php
	#DB Verbindungsdaten, von au�erhalb Unsichtbar
	$dbServername ="localhost";#IP der DB
	$dbUsername ="root";#Loginname f�r die DB
	$dbPassword="master";#PW f�r die DB
	$dbName ="winprj01";#Name der DB
		
	$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);#Verbindung f�r die DB
	$con= new mysqli($dbServername,$dbUsername,$dbPassword,$dbName);#Verbindung f�r die DB

?>