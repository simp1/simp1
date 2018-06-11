<?php
	#DB Verbindungsdaten, von außerhalb Unsichtbar
	$dbServername ="localhost";#IP der DB
	$dbUsername ="root";#Loginname für die DB
	$dbPassword="master";#PW für die DB
	$dbName ="winprj01";#Name der DB
		
	$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);#Verbindung für die DB
	$con= new mysqli($dbServername,$dbUsername,$dbPassword,$dbName);#Verbindung für die DB

?>