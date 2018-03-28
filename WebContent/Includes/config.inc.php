<?php
#DB Verbindung
	$dbServername ="localhost";
	$dbUsername ="root";
	$dbPassword="";
	$dbName ="project";
		
	$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);
	$con= new mysqli($dbServername,$dbUsername,$dbPassword,$dbName);

?>