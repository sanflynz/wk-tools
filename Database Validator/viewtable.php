
<?php 	include('includes/header.php'); 
		include('../__classes/Pagination.php'); 
		include('../__classes/DownloadCsvMysql.php'); 
		include('../__classes/MySqlFunctions.php');

		$mysql = new MySqlFunctions($conn);
		
		$error = "";

	if(isset($_GET['table'])){

		$cols = $mysql->getHeaders($_GET['table']);
		if($mysql->error){
			$error .= $mysql->error;
		}
		else{
			$colsA = explode(',',$cols);

			if(isset($_GET['action']) && $_GET['action'] == "duplicates"){
				if(isset($_GET['comparisonfield'])){
					if(isset($_GET['comparisonfield'])){
						$comparisonField = str_replace("_"," ",$_GET['comparisonfield']);
						$sql = "SELECT * FROM `" . $_GET['table'] . "` INNER JOIN(SELECT `" . $comparisonField . "` FROM `" . $_GET['table'] . "` GROUP BY `" . $comparisonField ."` HAVING COUNT(id) > 1) temp ON `" . $_GET['table'] . "`.`" . $comparisonField . "` = temp.`" . $comparisonField . "` ORDER BY temp.`" . $comparisonField . "`";
					
						if(isset($_GET['function']) && $_GET['function'] == "delete"){
							$r2 = $conn->query($sql);
							if($r2){
								while($row = $r2->fetch_assoc()){
								 	
									if(!$conn->query("DELETE FROM " . $_GET['table'] . " WHERE id = " . $row['id'])){
										$error .= "Could not delete row " . $row['id'] . ": " . $conn->error . "<br>";
									}
								}
								if(!$error){
									header("location: viewtable.php?table=" . $_GET['table'] . "&action=duplicates&comparisonfield=" . $_GET['comparisonfield']);	
								}
							}
							else{
								$error = "Could not select duplicates: " . $conn->error;
							}
						}
						
					}
				}
				else{
					$warning = "Please select a field to find duplicates on";
				}			
			}		
			else{
				$sql = "SELECT * FROM `" . $_GET['table'] . "`";

			}	
			
			if(isset($sql)){

				if(isset($_GET['function']) && $_GET['function'] == "export_csv"){
					$CsvDown = new DownloadCsvMysql($conn);
					if(isset($_GET['action']) && $_GET['action'] == "duplicates" ){ $duplicates = "_duplicates"; } else { $duplicates = ""; }
					$CsvDown->filename = $_GET['table'] . $duplicates . ".csv";
					$CsvDown->downloadSQL($sql,$cols,$cols);

					if(isset($_GET['action'])){ $action = "&action=" . $_GET['action']; } else { $action = ""; }

					header("location: viewtable.php?table=" . $_GET['table'] . $action . "&comparisonfield=" . $_GET['comparisonfield']);	
				
				}
					
				$page = ( isset($_GET['page'])) ? $_GET['page'] : 1;
				$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 50;

				$Pagination  = new Pagination( $conn, $sql );
				if($Pagination->error){
					$error = $Pagination->error;
				}
				else{
					$results    = $Pagination->getData( $limit, $page );
				}
				
			}
		}
	}	
 
	if(isset($_GET['button'])){
		if($_GET['button'] == "csvForEloquaUpload" && $_GET['action'] == "allSFDC"){
			$eCols = "email,contact_id,first_name,last_name,account_name,masterpack_customer_code,position,department,phone,mobile,mail_flag,mailing_address_line_1,mailing_address_line_2,mailing_address_line_3,mailing_city,mailing_zip_postal_code,mailing_country";
			$eHeaders = "Email Address,ANZ_SFDC_Contact ID,First Name,Last Name,Company,ANZ_Masterpack_customer_code,job title,Department,Business Phone,Mobile Phone,ANZ_Mail Flag,Address 1,Address 2,Address 3,City,Zip or Postal Code,Country,ISO Country";
			$CsvDown = new DownloadCsvMysql($conn);
			$CsvDown->downloadSQL($sql,$eCols,$eHeaders);
		}

		if($_GET['button'] == "csvForEloquaUpload" && $_GET['action'] == "allCST"){
			$eCols = "email,contact_id,first_name,last_name,account_name,masterpack_customer_code,position,department,phone,mobile,mail_flag,mailing_address_line_1,mailing_address_line_2,mailing_address_line_3,mailing_city,mailing_zip_postal_code,mailing_country";
			$eHeaders = "Email Address,ANZ_SFDC_Contact ID,First Name,Last Name,Company,ANZ_Masterpack_customer_code,job title,Department,Business Phone,Mobile Phone,ANZ_Mail Flag,Address 1,Address 2,Address 3,City,Zip or Postal Code,Country,ISO Country";
			$CsvDown2 = new DownloadCsvMysql($conn);
			$CsvDown2->downloadSQL($sql,$eCols,$eHeaders);
		}
	}

?>

<div class="row">
	<div class="col-xs-12">
		<h1>View Table</h1>
		
		<br>
	</div>
</div>	
<div class="row">
	<div class="col-xs-12">
<?php	if(!empty($error)){ ?>
			<div class="alert alert-danger">
				<strong>ERROR: </strong><?php echo $error; ?>
			</div>
<?php	}?>	
<?php 	if(!empty($warning)){ ?>
			<div class="alert alert-warning">
				<strong>WARNING! </strong><?php echo $warning; ?>
			</div>
<?php	} ?>
<?php 	if(!empty($success)){ ?>
			<div class="alert alert-success">
				<strong>WINNING! </strong><?php echo $success; ?>
			</div>
<?php	} ?>
	</div>
</div>	
<div class="row">
	<div class="col-md-4">
		<select class="form-control" onchange="javascript:location.href = this.value;">
			<option value="#">--- SELECT TABLE TO VIEW ---</option>
		  	<option <?php if( isset($_GET['table']) && $_GET['table'] == "all_sfdc" && !isset($_GET['action'])){ echo " selected "; } ?> value="viewtable.php?table=all_sfdc">SFDC All</option>
		  	<option <?php if( isset($_GET['table']) && $_GET['table'] == "all_sfdc" && isset($_GET['action']) && $_GET['action'] == "duplicates"){ echo " selected "; } ?> value="viewtable.php?table=all_sfdc&action=duplicates">&nbsp;&nbsp;&nbsp;&nbsp;SFDC Duplicates</option>
		  	<option <?php if( isset($_GET['table']) && $_GET['table'] == "all_elq"){ echo " selected "; } ?> value="viewtable.php?table=all_elq" >Eloqua All</option>
		  	<option <?php if( isset($_GET['table']) && $_GET['table'] == "all_cst" && !isset($_GET['action'])){ echo " selected "; } ?> value="viewtable.php?table=all_cst" >Custom All</option>
		  	<option <?php if( isset($_GET['table']) && $_GET['table'] == "all_cst" && isset($_GET['action']) && $_GET['action'] == "duplicates"){ echo " selected "; } ?> value="viewtable.php?table=all_cst&action=duplicates" >&nbsp;&nbsp;&nbsp;&nbsp;Custom Duplicates</option>
		</select>
	</div>

	<div class="col-md-4">


<?php 	if(isset($_GET['action']) && $_GET['action'] == "duplicates"){ ?>
			<select class="form-control" onchange="javascript:location.href = this.value;">
				<option value="#">--- SELECT COMPARISON FIELD ---</option>
<?php 		foreach(explode(",", $cols) as $c){ ?>

				<option <?php if( isset($_GET['comparisonfield']) && $_GET['comparisonfield'] == str_replace(" ", "_", $c)){ echo " selected "; } ?> value="viewtable.php?table=<?php echo $_GET['table']; ?>&action=duplicates&comparisonfield=<?php echo str_replace(" ", "_", $c); ?>"><?php echo $c; ?></option>
<?php		}
		}	?>		  	
			</select>

		<?php if (isset($_GET['table']) && ($_GET['table'] == "all_sfdc" || $_GET['table'] == "all_cst")){ ?>
		<!--	<a href="viewtable.php?table=<?php echo $_GET['table']; ?>&button=csvForEloquaUpload" class="btn btn-success" style="width: 200px">CSV for Eloqua Upload</a> -->
		<?php } ?>
	</div>
	<div class="col-md-4">


	</div>



</div>

<?php if(isset($sql)){ ?>
<div class="row">
	<div class="col-xs-12">
		<br>
		<?php echo $Pagination->total; ?> Records Found  &nbsp;&nbsp;
		<?php 	if(isset($_GET['action'])){ $action = "&action=" . $_GET['action']; }
				if(isset($_GET['comparisonfield'])){ $comparison = "&comparisonfield=" . $_GET['comparisonfield']; } else { $comparison = ""; } ?>
		<a href="viewtable.php?table=<?php echo $_GET['table']; ?><?php echo $action; ?>&function=export_csv<?php echo $comparison; ?>" class="btn btn-default" title="EXPORT RECORDS"><i class="fa fa-cloud-download" style="color: green;"></i></a>
		<?php 	if(isset($_GET['action']) && $_GET['action'] == "duplicates"){
			if(isset($_GET['comparisonfield'])){ ?>
				
				<a href="viewtable.php?table=<?php echo $_GET['table']; ?>&action=duplicates&function=delete&comparisonfield=<?php echo $_GET['comparisonfield']; ?>" class="btn btn-default" onclick="return confirm('Are you sure you want to delete <?php echo $Pagination->total; ?> duplicates')" title="DELETE DUPLICATES"><i class="fa fa-close" style="color: red;"></i></a>
	<?php	}

		}	?>
		<br>
		<?php $Pagination->showLinks = 3; ?>
		<?php if($Pagination->total > 0) { echo $Pagination->buildLinks(); } ?>

			
	</div>
</div>

<?php if($Pagination->total > 0){ ?>

<div class="row">
	<div class="col-xs-12">
		<table class="table table-hover">
			<thead>
				<tr>
			<?php	foreach($colsA as $c){
						echo "<th>" . $c . "</th>";
					}	?>	
					
					
				</tr>
			</thead>
			<tbody>
		<?php 	foreach($results->data as $re){
					echo "<tr>";
					foreach($colsA as $c){
						$c = trim($c);
						echo "<td>" . $re[$c] . "</td>";
					}
					echo "</tr>";
				}	?>
			</tbody>	
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

<?php 	include('includes/footer.php'); ?>