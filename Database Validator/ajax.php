<?php
	include('includes/db.php');

	include('classes/ValidateEmails.php');
	include("../__classes/MySqlFunctions.php");
	include('../__classes/DownloadCsvMysql.php'); 

	?> 

	<?php

	if($_GET['action'] == "tableComparisonOptions"){

		$mysql = new MySqlFunctions($conn);
		$cols = explode(",", $mysql->getHeaders($_GET['table']));
		$options = "";
		foreach($cols as $c){
			$options .= "<option>" . $c . "</option>";
		}

		echo $options;


	}	


	if($_GET['action'] == "tableFields"){
		
		$mysql = new MySqlFunctions($conn);
		$cols = explode(",", $mysql->getHeaders($_GET['table']));
		$fields = "";
		$i = 0;
		foreach($cols as $c){
			$fields .= '<tr><td width="50%"><input class="fieldCheckBox" data-num="' . $i . '" type="checkbox" name="data[' . $_GET['t'] . '][fields][' . $i . '][field]" value="' . $c . '"> ' . $c . '</td><td width="50%"><input type="text" name="data[' . $_GET['t'] . '][fields][' . $i . '][fieldAs]" class="form-control" style="width: 150px;"></td></tr>';
			$i++;
		}

		echo $fields;
		

		// 
	}	

	if($_GET['action'] == "validateEmail"){
		//print_r($_POST);
		$id = $_POST['pk'];
		$value = $_POST['value'];
		$name = $_POST['name'];

		// validate email
		$v = new ValidateEmail();
		//$emailField = str_replace("_", " ", $_GET['emailfield']);
		$em = $v->checkall(trim($value));


		// Get table and table_id out
		$r = $conn->query("SELECT * FROM email_chk WHERE id = " . $id);
		$t = $r->fetch_assoc();
		print_r($t);
		
		// Update email_chk
		$sql = "UPDATE email_chk SET `hasEmail`='" . $em['present'] . "',`formatOK`='" . $em['format'] . "',`domainOK`='" . $em['domain'] . "',`checkOK`='" . $em['final'] . "' WHERE id = " . $id;
		if($conn->query($sql)){
			// $r2 = $conn->query("SELECT * FROM email_chk WHERE id = " . $id);
			// $t2 = $r2->fetch_assoc();
			// print_r($t2);
			
			// update base table
			$sql2 = "UPDATE " . $t['table'] . " SET `" . $name . "`='" . $value . "' WHERE id='" . $t['table_id'] . "'";
			if($conn->query($sql2)){
				// return success
				$r2 = $conn->query("SELECT `Email` FROM all_cst WHERE id = " . $t['table_id']);
				$t2 = $r2->fetch_assoc();	
				// 
				// 
				header('HTTP/1.1 200 OK', true, 200);
				//header('HTTP/1.0 400 Bad Request', true, 400);
			}	
			else{
				// return error (update base table)
				header('HTTP/1.0 400 Bad Request', true, 400);
				echo "Couldnt update base table";
			}
			// name
			// pk
			// value
		}
		else{
			// return error (update email_chk)
			header('HTTP/1.0 400 Bad Request', true, 400);
			echo "Couldnt update email_chk";
		}
		
	}



	if(isset($_GET['export_results'])){
		echo $_POST;
		//echo $_POST['sql'];

		$sql = $_POST['sql'];
		$cols = $_POST['cols'];

		$CsvDown = new DownloadCsvMysql($conn);
		$CsvDown->filename = "results.csv";
		$CsvDown->downloadSQL($sql,$cols,$cols);



	}



?>