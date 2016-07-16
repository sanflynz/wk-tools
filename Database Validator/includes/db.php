<?php
	error_reporting (0);
	//error_reporting(E_ALL);
	set_time_limit (0);

	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "wk_databases";

	// Create connection
	$conn = new mysqli($servername, $username, $password,$database);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

?>