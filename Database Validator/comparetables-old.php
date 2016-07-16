
<?php 	include('includes/header.php'); 
		include('classes/Pagination.php'); 
		include('classes/DownloadCsvMysql.php'); 

	if(isset($_GET['action'])){
		switch($_GET['action']){

			case "inSFDCnotELQ" : 
				$cols = "id,email,contact_id,salutation,first_name,last_name,account_name,masterpack_customer_code,position,department,phone,mobile,mail_flag,mailing_address_line_1,mailing_address_line_2,mailing_address_line_3,mailing_city,mailing_zip_postal_code,mailing_country,godirect_user_id,industry_group_description,industry_description,account_owner";
				$colsA = explode(',',$cols);
				$sql = "SELECT s.*,e.eloqua_contact_id FROM all_sfdc s LEFT JOIN all_elq e ON s.email = e.email_address WHERE `e`.`eloqua_contact_id` IS NULL";
				break;

			case "inCSTinSFDC" : 
				$cols = "id,all_cst.email,contact_id,salutation,first_name,last_name,account_name,masterpack_customer_code,position,department,phone,mobile,mail_flag,mailing_address_line_1,mailing_address_line_2,mailing_address_line_3,mailing_city,mailing_zip_postal_code,mailing_country,godirect_user_id,industry_group_description,industry_description,account_owner";
				$colsA = explode(',',$cols);
				$sql = "SELECT c.email AS 'all_cst.email',s.* FROM all_cst c LEFT JOIN all_sfdc s ON c.email = s.email";
				// NOT IN SDFCD
				$sqlNOSFDC = "SELECT c.email AS 'all_cst.email',s.* FROM all_cst c LEFT JOIN all_sfdc s ON c.email = s.email WHERE s.email IS NULL";
				// Mail Flag Count
				$sqlMF = "SELECT c.email AS 'all_cst.email',s.*,e.eloqua_contact_id FROM all_cst c LEFT JOIN all_sfdc s ON c.email = s.email LEFT JOIN all_elq e ON s.email = e.email_address WHERE `e`.`eloqua_contact_id` IS NULL AND (s.mail_flag = 'N' OR s.mail_flag = 'M' OR s.mail_flag = 'X')";
				break;

			case "inCSTinSFDCforELQ" : 

				if(isset($_GET['comparisonfield'])){

				}

				$cols = "id,all_cst.email,contact_id,salutation,first_name,last_name,account_name,masterpack_customer_code,position,department,phone,mobile,mail_flag,mailing_address_line_1,mailing_address_line_2,mailing_address_line_3,mailing_city,mailing_zip_postal_code,mailing_country,godirect_user_id,industry_group_description,industry_description,account_owner";
				$colsA = explode(',',$cols);
				$sql = "SELECT c.email AS 'all_cst.email',s.* FROM all_cst c LEFT JOIN all_sfdc s ON c.email = s.email";
				// NOT IN SDFCD
				$sqlNOSFDC = "SELECT c.email AS 'all_cst.email',s.* FROM all_cst c LEFT JOIN all_sfdc s ON c.email = s.email WHERE s.email IS NULL";
				// Mail Flag Count
				$sqlMF = "SELECT c.email AS 'all_cst.email',s.*,e.eloqua_contact_id FROM all_cst c LEFT JOIN all_sfdc s ON c.email = s.email LEFT JOIN all_elq e ON s.email = e.email_address WHERE `e`.`eloqua_contact_id` IS NULL AND (s.mail_flag = 'N' OR s.mail_flag = 'M' OR s.mail_flag = 'X')";
				break;

			case "inCSTinSFDCnotELQ" : 
				$cols = "id,all_cst.email,contact_id,salutation,first_name,last_name,account_name,masterpack_customer_code,position,department,phone,mobile,mail_flag,mailing_address_line_1,mailing_address_line_2,mailing_address_line_3,mailing_city,mailing_zip_postal_code,mailing_country,godirect_user_id,industry_group_description,industry_description,account_owner";
				$colsA = explode(',',$cols);
				$sql = "SELECT c.email AS 'all_cst.email',s.*,e.eloqua_contact_id FROM all_cst c LEFT JOIN all_sfdc s ON c.email = s.email LEFT JOIN all_elq e ON s.email = e.email_address WHERE `e`.`eloqua_contact_id` IS NULL";

				break;

			
		}	

		// get the pages and stuff later
		$page = ( isset($_GET['page'])) ? $_GET['page'] : 1;
		$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 50;

		$Pagination  = new Pagination( $conn, $sql );
		$results    = $Pagination->getData( $limit, $page );
	}

	if(isset($_GET['button'])){
		if($_GET['button'] == "csvForEloquaUpload" && $_GET['action'] == "inSFDCnotELQ"){
			$eCols = "email,contact_id,first_name,last_name,account_name,masterpack_customer_code,position,department,phone,mobile,mail_flag,mailing_address_line_1,mailing_address_line_2,mailing_address_line_3,mailing_city,mailing_zip_postal_code,mailing_country";
			$eHeaders = "Email Address,ANZ_SFDC_Contact ID,First Name,Last Name,Company,ANZ_Masterpack_customer_code,job title,Department,Business Phone,Mobile Phone,ANZ_Mail Flag,Address 1,Address 2,Address 3,City,Zip or Postal Code,Country,ISO Country";
			$CsvDown = new DownloadCsvMysql($conn);
			$CsvDown->downloadSQL($sql,$eCols,$eHeaders);
		}

		if($_GET['button'] == "csvForEloquaUpload" && $_GET['action'] == "inCSTinSFDCnotELQ"){
			$eCols = "email,contact_id,first_name,last_name,account_name,masterpack_customer_code,position,department,phone,mobile,mail_flag,mailing_address_line_1,mailing_address_line_2,mailing_address_line_3,mailing_city,mailing_zip_postal_code,mailing_country";
			$eHeaders = "Email Address,ANZ_SFDC_Contact ID,First Name,Last Name,Company,ANZ_Masterpack_customer_code,job title,Department,Business Phone,Mobile Phone,ANZ_Mail Flag,Address 1,Address 2,Address 3,City,Zip or Postal Code,Country,ISO Country";
			$CsvDown2 = new DownloadCsvMysql($conn);
			$CsvDown2->downloadSQL($sql,$eCols,$eHeaders);
		}

		if($_GET['button'] == "csvForEloquaUpload" && $_GET['action'] == "inCSTinSFDCforELQ"){
			$eCols = "email,contact_id,first_name,last_name,account_name,masterpack_customer_code,position,department,phone,mobile,mail_flag,mailing_address_line_1,mailing_address_line_2,mailing_address_line_3,mailing_city,mailing_zip_postal_code,mailing_country";
			$eHeaders = "Email Address,ANZ_SFDC_Contact ID,First Name,Last Name,Company,ANZ_Masterpack_customer_code,job title,Department,Business Phone,Mobile Phone,ANZ_Mail Flag,Address 1,Address 2,Address 3,City,Zip or Postal Code,Country,ISO Country";
			$CsvDown3 = new DownloadCsvMysql($conn);
			$CsvDown3->downloadSQL($sql,$eCols,$eHeaders);
		}
	}

	if(isset($sqlNOSFDC)){
		$t = $conn->query($sqlNOSFDC);
		$tTotal = $t->num_rows;
	}

	if(isset($sqlMF)){
		$u = $conn->query($sqlMF);
		$uTotal = $u->num_rows;
	}

?>
<div class="row">
	<div class="col-xs-12">
		<h1>Compare Tables</h1>
		
		<br>
	</div>
	<div class="col-md-4">
		<select class="form-control" onchange="javascript:location.href = this.value;">
			<option value="#">--- SELECT COMPARISON TO VIEW ---</option>
		  	<option <?php if( isset($_GET['action']) && $_GET['action'] == "inSFDCnotELQ"){ echo " selected "; } ?> value="comparetables.php?action=inSFDCnotELQ">In Salesforce.com, not Eloqua</option>
		  	<option <?php if( isset($_GET['action']) && $_GET['action'] == "inCSTinSFDC"){ echo " selected "; } ?> value="comparetables.php?action=inCSTinSFDC">In Custom, in Salesforce.com</option>
		  	<option <?php if( isset($_GET['action']) && $_GET['action'] == "inCSTinSFDCforELQ"){ echo " selected "; } ?> value="comparetables.php?action=inCSTinSFDCforELQ">In Custom, in Salesforce.com for ELQ import</option>
		  	<option <?php if( isset($_GET['action']) && $_GET['action'] == "inCSTinSFDCnotELQ"){ echo " selected "; } ?> value="comparetables.php?action=inCSTinSFDCnotELQ">In Custom, in Salesforce.com, not Eloqua</option>
		  	
		</select>
	</div>

	<div class="col-md-4">
		<?php if ($_GET['action'] == "inSFDCnotELQ" || $_GET['action'] == "inCSTinSFDCnotELQ" || $_GET['action'] == "inCSTinSFDCforELQ"){ ?>
			<a href="comparetables.php?action=<?php echo $_GET['action']; ?>&button=csvForEloquaUpload" class="btn btn-success" style="width: 200px">CSV for Eloqua Upload</a>
		<?php } ?>

	</div>

</div>
<?php 	if( ( isset( $sqlNOSFDC ) && $tTotal > 0) || ( isset( $sqlMF ) && $uTotal > 0) ){ ?>
<div class="row">
	<div class="col-xs-12">
		<br>
	<?php 	if($tTotal > 0){ ?>
		<div class="alert alert-warning">
			<strong>WARNING: </strong><?php echo $tTotal; ?> contacts are not found in the SFDC List
		</div>
		<br>
<?php			}	?>

	<?php 	if($uTotal > 0){ ?>
		<div class="alert alert-warning">
			<strong>WARNING: </strong><?php echo $uTotal; ?> contacts have an illegal mail flag (X, N or N)
		</div>
		<br>
<?php			}	?>		

	</div>
</div>
<?php		} ?>
<?php if(isset($_GET['action'])){ ?>
<div class="row">
	<div class="col-xs-12">
		<br>
		<?php echo $Pagination->total; ?> Records Found<br>
		<?php $Pagination->showLinks = 3; ?>
		<?php echo $Pagination->buildLinks(); ?>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<table class="table table-hover">
			<tr>
		<?php	foreach($colsA as $c){
					echo "<th>" . $c . "</th>";
				}	?>	
				
				
			</tr>
			<?php // print_r($results->data); ?>
		<?php 	foreach($results->data as $re){
					echo "<tr>";
					$line = array();
					foreach($colsA as $c){
						if(($_GET['action'] == "inSDFCnotELQ") && $c == "contact_id"){
							echo "<td><a href='https://ap4.salesforce.com/" . $re[$c] . "' target='_blank'>" . $re[$c] . "</a></td>";
							$line[] = $re[$c];
						}
						else{
							echo "<td>" . $re[$c] . "</td>";
							$line[] = $re[$c];
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

<?php } ?>




<?php 	include('includes/footer.php'); ?>