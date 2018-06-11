<?php
#DB Verbindung
	$dbServername ="localhost";
	$dbUsername ="root";
	$dbPassword="master";
	$dbName ="winprj01";
		
	$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);
	$con= new mysqli($dbServername,$dbUsername,$dbPassword,$dbName);

?>