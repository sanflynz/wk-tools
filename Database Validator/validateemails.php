<?php 	include('includes/db.php'); 
		include('classes/Pagination.php'); 
		include('classes/ValidateEmails.php');
		include('classes/MySqlFunctions.php');
		include('classes/DownloadCsvMysql.php');

		$mysql = new MySqlFunctions($conn);

	if(isset($_GET['table'])){
		$headers = $mysql->getHeaders($_GET['table']);
	}
		
	
		


	if(isset($_GET['table']) && isset($_GET['emailfield'])){
		switch($_GET['table']){

			case "all_sfdc" : 
				$cols = "sid,first_name,last_name,contact_id,email,checkOK,hasEmail,formatOK,domainOK";
				$colsA = explode(',',$cols);
				//$sql = "SELECT * FROM email_chk WHERE `table` = 'all_sfdc'";
				$sql = "SELECT * FROM `email_chk` LEFT JOIN all_sfdc ON (all_sfdc.id = email_chk.table_id) WHERE email_chk.`table` = 'all_sfdc' ORDER BY email_chk.checkOK,all_sfdc.account_name";
				$r = $conn->query("SELECT * from all_sfdc");
				$totalRecords = $r->num_rows; 
				break;

			case "all_cst" : 
				//$cstH = $mysql->getHeaders('all_cst');
				
				$cols = "id," . $_GET['emailfield'] . ",checkOK,hasEmail,formatOK,domainOK";
				$colsA = explode(',',$cols);
				//$sql = "SELECT * FROM email_chk WHERE `table` = 'all_sfdc'";
				$sql = "SELECT e.id as id,e.checkOK,e.hasEmail,e.formatOK,e.domainOK,c.`" . $_GET['emailfield'] ."` FROM `email_chk` e LEFT JOIN all_cst c ON (c.id = e.table_id) WHERE e.`table` = 'all_cst' ORDER BY e.checkOK";
				
				$r = $conn->query("SELECT * from all_cst");
				$totalRecords = $r->num_rows; 

				break;			
		}	



		// get the pages and stuff later
		$page = ( isset($_GET['page'])) ? $_GET['page'] : 1;
		$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 50;

		$Pagination  = new Pagination( $conn, $sql );
		$results    = $Pagination->getData( $limit, $page );


		$r = $conn->query("SELECT * FROM email_chk WHERE checkOK='1'");
		$numPassed = $r->num_rows;

	}

	if(isset($_GET['action']) && $_GET['action'] ==  "run"){
		//echo "Were In<br>";
		// foreach record in table, select if not in email_chk table
		$sql = "SELECT *, " . $_GET['table'] . ".id as my_id FROM " . $_GET['table'] ." LEFT JOIN email_chk ON (email_chk.`table` = '" . $_GET['table'] . "' AND email_chk.table_id = " . $_GET['table'] . ".id) WHERE email_chk.id IS NULL";
		//$sql = "SELECT * FROM all_sfdc as s LEFT JOIN email_chk as e ON (e.`table` = 'all_sfdc' AND e.table_id = s.id) WHERE e.id IS NULL";
		$r = $conn->query($sql);
		//echo $sql;
		while ($row = $r->fetch_assoc()){
			//echo "..." . $row['email'] . "...<br>";
			//start validating!
			$v = new ValidateEmail();
			$emailField = str_replace("_", " ", $_GET['emailfield']);
			$tv = $v->checkall(trim($row[$emailField]));
			//print_r($tv);
			//echo "<br><br>";
			$q2 = "INSERT INTO email_chk (`table`,table_id,hasEmail,formatOK,domainOK,checkOK) VALUES 
						('" . $_GET['table'] . "','" . $row['my_id'] . "','" . $tv['present'] . "','" . $tv['format'] . "','" . $tv['domain'] . "','" . $tv['final'] . "')";
			if ($conn->query($q2) === FALSE) {
				$error = "Unable to add validation record" . $conn->error;
				break;
			}

		}

		header("location: validateemails.php?table=" . $_GET['table'] . "&emailfield=" . $_GET['emailfield']);
		
	}

	if(isset($_GET['action']) && $_GET['action'] ==  "exportFailed"){

		
		$cols = $mysql->getHeaders('all_cst');

		$cols .= ",checkOK,hasEmail,formatOK,domainOK";

		$r = $conn->query("SELECT * FROM email_chk WHERE checkOK = '0'");
		while($row = $r->fetch_assoc()){
			$r2 = $conn->query("SELECT * FROM " . $_GET['table'] . " WHERE id = " . $row['table_id']);
			
			// Get base table row
			$sql = "SELECT * FROM email_chk e LEFT JOIN " . $_GET['table'] . " t ON e.table_id = t.id WHERE e.checkOK='0'";
			
			$CsvDown = new DownloadCsvMysql($conn);
			$CsvDown->filename = $_GET['table'] . "_email_validation_failed.csv";
			$CsvDown->downloadSQL($sql,$cols,$cols);

			// redirect
			header("location: validateemails.php?action=" . $_GET['action'] . "&emailfield=" . $_GET['emailfield']);
					
		}

	}

	if(isset($_GET['action']) && $_GET['action'] ==  "deleteFailed"){

		// get the fails
		$r = $conn->query("SELECT * FROM email_chk WHERE checkOK = '0'");
		while($row = $r->fetch_assoc()){
			$r2 = $conn->query("SELECT * FROM " . $_GET['table'] . " WHERE id = " . $row['table_id']);
			print_r($row);

			// Delete base table row
			if($conn->query("DELETE FROM ". $_GET['table'] . " WHERE id='" . $row['table_id'] . "'")){
				if($conn->query("DELETE FROM email_chk WHERE id='" . $row['id'] . "'")){
					//success
					header("location: validateemails.php?table=" . $_GET['table'] . "&emailfield=" . $_GET['emailfield']);
					
				}
				else{
					echo "email_chk delete failed";
				}
			}
			else{
				echo "Failed delete base table fails";
			}
		}



	}

	
		//echo "<pre>" . print_r($results->data) . "</pre>";
	
	include('includes/header.php'); 
		
?>

<div class="row">
	<div class="col-xs-12">
		<h1>Validate Emails</h1>
		
		<br>
	</div>
	<div class="col-md-4">
		<select class="form-control" onchange="javascript:location.href = this.value;">
			<option value="#">--- SELECT TABLE TO VIEW ---</option>
		  	<option <?php if( isset($_GET['table']) && $_GET['table'] == "all_sfdc"){ echo " selected "; } ?> value="validateemails.php?table=all_sfdc">SFDC</option>
		  	<option <?php if( isset($_GET['table']) && $_GET['table'] == "all_cst"){ echo " selected "; } ?> value="validateemails.php?table=all_cst">Custom</option>
		  	
		</select>
		
	</div>
	<div class="col-md-4">
			

			<select class="form-control" onchange="javascript:location.href = this.value;">
			<option value="#">--- SELECT EMAIL FIELD ---</option>
<?php 		foreach(explode(",", $headers) as $c){ ?>

				<option <?php if( isset($_GET['emailfield']) && $_GET['emailfield'] == str_replace(" ", "_", $c)){ echo " selected "; } ?> value="validateemails.php?table=all_cst&emailfield=<?php echo str_replace(" ", "_", $c); ?>"><?php echo $c; ?></option>
<?php		}

?>		  	
		</select>
		
	</div>	
</div>
<div class="row">
	<div class="col-xs-12">
	<?php 	if(!empty($error)){ ?>
				<div class="alert alert-danger">
					<strong>ERROR: </strong><?php echo $error; ?>
				</div>
	<?php	}?>	
	<?php 	if(!empty($success)){ ?>
				<div class="alert alert-success">
					<strong>WINNING! </strong><?php echo $success; ?>
				</div>
	<?php	}?>	
	</div>
</div>	
	


<?php if(isset($_GET['table'])){ ?>
<div class="row">
	<div class="col-xs-12">
		<br>
		Total Records: <?php echo $totalRecords; ?>, <?php echo $Pagination->total; ?> validated, <?php echo $numPassed; ?> passed &nbsp;&nbsp;&nbsp;&nbsp;
		
	<?php if($totalRecords != $Pagination->total){ ?>
		<a href="validateemails.php?action=run&table=<?php echo $_GET['table']; if($_GET['table'] == "all_cst"){ echo "&emailfield=". $_GET['emailfield']; } ?>" class="btn btn-success btn-xs" id="button-run">Run</a>&nbsp;&nbsp;
	<?php }
	if($numPassed < $totalRecords && $Pagination->total > 0){ ?>
		<a href="validateemails.php?action=exportFailed&table=<?php echo $_GET['table']; if($_GET['table'] == "all_cst"){ echo "&emailfield=". $_GET['emailfield']; } ?>" class="btn btn-success btn-xs">Export Failed</a>&nbsp;&nbsp;
		<a href="validateemails.php?action=deleteFailed&table=<?php echo $_GET['table']; if($_GET['table'] == "all_cst"){ echo "&emailfield=". $_GET['emailfield']; } ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete validation failures?')">Delete Failed</a>&nbsp;&nbsp;
<?php } ?>		
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<?php $Pagination->showLinks = 3; ?>
		<?php if($Pagination->total > 0){ echo $Pagination->buildLinks(); } ?>
	</div>
</div>

<?php if($Pagination->total > 0){ ?>
<div class="row">
	<div class="col-xs-12">
		<table class="table table-hover" id="emails">
			<thead>
				<tr>
		<?php	foreach($colsA as $c){
					echo "<th>" . $c . "</th>";
				}	?>	
				
				
			</tr>
		</thead>	
		<?php 	foreach($results->data as $re){

					echo "<tr";
					if($re['checkOK'] == "0"){ echo ' class="danger"'; }
					echo ">";
					foreach($colsA as $c){
						if(($_GET['table'] == "all_sfdc") && $c == "contact_id"){
							echo "<td><a href='https://ap4.salesforce.com/" . $re[$c] . "' target='_blank'>" . $re[$c] . "</a></td>";
						}
						elseif($_GET['table'] == "all_cst" && $c == $_GET['emailfield']){ ?>
							<td><a href="#" id="" data-pk="<?php echo $re['id']; ?>" ><?php echo $re[$c]; ?></a></td>
			<?php		}
			 			elseif(($c == "checkOK" || $c == "hasEmail" || $c == "formatOK" || $c == "domainOK") && $re[$c] == "0"){
							echo "<td style='color: red; font-weight: bold;'>FAIL</td>";
						}
						elseif(($c == "checkOK" || $c == "hasEmail" || $c == "formatOK" || $c == "domainOK") && $re[$c] == "1"){
							echo "<td>OK</td>";
						}
						
						else{
							echo "<td>" . $re[$c] . "</td>";
						}
					}
					echo "</tr>";
				}	?>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<?php echo $Pagination->buildLinks(); ?>
	</div>
</div>


<?php }
} ?>
<?php 
	if(isset($_GET['emailfield'])){ ?>
		<script type="text/javascript">
			$(document).ready(function() {

				

			    $("#emails a").editable({
			    	type: 'text',
        			url: 'ajax.php?action=validateEmail',
        			name: '<?php echo $_GET['emailfield']; ?>',
        			title: 'Enter Email'
			    });
			});
		</script>
<?php	}
?>

<?php 	include('includes/footer.php'); ?>