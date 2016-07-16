<?php

	//error_reporting (0);
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

	// QUERY STRINGS
	if(isset($_GET['action'])){ $action = $_GET['action']; } else { $action = ''; };
	
	/*echo "action: " . $_GET['action'];
	$qs = $_SERVER["QUERY_STRING"];

	if($qs){

		$q = explode('&', $qs);
		
		$qp = array(); // Query Parameters
		foreach($q as $set){
			$s = explode('=',$set);
			$qp[$s[0]] = $s[1];
		}
		
		//echo "<pre>" . print_r($qp) . "</pre>";
		///$action = $_GET['action'];

		echo $_GET['limit'];
	}  */


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Database Validator</title>

	<link rel="shortcut icon" href="favicon-stack-overflow.ico">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../__resources/css/bootstrap.min.css" rel="stylesheet">
	<link href="../__resources/css/font-awesome.css" rel="stylesheet">
	<link href="../__resources/css/bootstrap-editable.css" rel="stylesheet">

	<link href='https://fonts.googleapis.com/css?family=Bitter:700' rel='stylesheet' type='text/css'>

	<script src="../__resources/js/jquery-2.1.4.min.js"></script>
	<script src="../__resources/js/bootstrap.min.js" ></script>
	<script src="../__resources/js/bootstrap-editable.min.js" type="text/javascript" ></script>

	
	
	<style>
		
		body {
		  padding-top: 60px;
		}
		.btn-file {
		  position: relative;
		  overflow: hidden;
		}
		.btn-file input[type=file] {
			position: absolute;
			top: 0;
			right: 0;
			min-width: 100%;
			min-height: 100%;
			font-size: 100px;
			text-align: right;
			filter: alpha(opacity=0);
			opacity: 0;
			background: red; 
			cursor: inherit;
			display: block;
		}
		input[readonly] {
			background-color: white !important;
			cursor: text !important;
			color: black;
		}

		
	</style>
	
	
</head>
<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php" style="font-family: Bitter; font-size: 28px; color: #FFFFFF;"><i class="fa  fa-stack-overflow"></i>&nbsp;&nbsp;Database Validator</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="viewtable.php">View Tables</a></li>
            <li><a href="comparetables.php">Compare Tables</a></li>
            <li><a href="validateemails.php">Validate Emails</a></li>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
				<li class="active"><a href="../" target="_blank">TOOLS</a></li>
			</ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">