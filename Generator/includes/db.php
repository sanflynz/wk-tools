<?php
//error_reporting (0);
error_reporting (E_ALL);
set_time_limit (0);

/*** DATABASE CONNECTION ***/
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "wk_generator";

	// Create connection
	$conn = new mysqli($servername, $username, $password,$database);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	//echo "Connected successfully";

/*** DATABASE CONNECTION -- ENDS ***/


/*** JUST FOR CONFERENCE  ***/
session_start();
if(!isset($_SESSION['environment'])){
	$_SESSION['environment'] = "local";
}
//	$_SESSION['conference']


// $r = $conn->query("SELECT environment FROM settings");
// if($r){
//     $settings = $r->fetch_assoc();
// }





// if(isset($_GET['environment'])){
// 	if($settings['environment'] == "local"){
// 		$conn->query("UPDATE settings SET environment = 'production' WHERE 1");
// 		$settings['environment'] = 'production';
// 	}
// 	elseif($settings['environment'] == "production"){
// 		$conn->query("UPDATE settings SET environment = 'local' WHERE 1");
// 		$settings['environment'] = 'local';
// 	}
// }

?>