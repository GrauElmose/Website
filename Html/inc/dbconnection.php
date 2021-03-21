<?php


// Function to open database. Use by e.g. $conn = OpenDB()
function OpenDB()
{
	//Constants
	$dbhost = "db.grauelmose.home";
	$dbuser = "root";
	$dbpass = "#Nmwlelqa01#";
	$db = "grauelmose";
		
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
	
	if ($conn->connect_error) {
		die("Connection failed:" . $conn->connect_error);
	}
	
	return $conn;
}


// Function to close database. Use by e.g. CloseDB($conn)
function CloseDB($conn)	
{
	$conn -> close();
}

?>