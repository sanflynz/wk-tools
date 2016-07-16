
<?php 	include('includes/header.php');

		include('../__classes/UploadCsvMysql.php');

		include('../__classes/MySqlFunctions.php');

		$mysql = new MySqlFunctions($conn);


		
function countDuplicates($table,$comparisonField,$mysql,$conn){
	
	$headers = explode(",", $mysql->getHeaders($table));
	if(in_array($comparisonField, $headers)){
	
		$sql = "SELECT * FROM `" . $table . "` INNER JOIN(SELECT `" . $comparisonField . "` FROM `" . $table . "` GROUP BY `" . $comparisonField ."` HAVING COUNT(id) > 1) temp ON `" . $table . "`.`" . $comparisonField . "` = temp.`" . $comparisonField . "` ORDER BY temp.`" . $comparisonField . "`";
		$r = $conn->query($sql);
		echo $conn->error;
		return $r->num_rows;	
	}
	else{
		return "Unable to calculate";
	}
				
}


if(isset($_GET['action']) && $_GET['action'] == "upload"){
	if(!$_POST){
		$error = "Data did not post";
	}
	if(isset($_POST['submit'])) {
		//$fields = $string = preg_replace('/\s+/', '', $_POST['fields']);

		$up = new UploadCsvMysql($conn);
		$up->uploadCreate($_GET['table']);
	}	
}

if(isset($_GET['action']) && $_GET['action'] == "clear"){
	$sql = "DROP TABLE " . $_GET['table'];
	if ($conn->query($sql) === TRUE) {
		$success = "All records deleted from " . $_GET['table'];
		if($conn->query("DELETE FROM email_chk WHERE `table` = '" . $_GET['table'] . "'")){
			$success .= "<br>All records cleared from email validation for " . $_GET['table'];
		}
		else{
			$error = "Unable to clear email validation for " . $_GET['table'] . ": " . $conn->error;
		}
		// 
	} else {
		$error = "Unable to clear all records from " . $_GET['table'] . ": " . $conn->error;
	}						
}



?>

<!-- SFDC INSTRUCTIONS -->
<div id="instructionsSFDC" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Salesforce.com Upload Instructions</h4>
      </div>
      <div class="modal-body">
        <p>Use a report with the following fields EXACTLY, IN ORDER</p>

        <p>Email,Contact ID,Salutation,First Name,Last Name,Account Name,Masterpack Customer Code,Position,Department,Phone,Mobile,Mail Flag,Mailing Address Line 1,Mailing Address Line 2,Mailing Address Line 3,Mailing City,Mailing Zip/Postal Code,Mailing Country,GoDirect User ID,Industry Group Description,Industry Description,Account Owner</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- GD INSTRUCTIONS -->
<div id="instructionsGD" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">GoDirect Upload Instructions</h4>
      </div>
      <div class="modal-body">
        <p>not sure yet, need to find the report</p>

        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- ELQ INSTRUCTIONS -->
<div id="instructionsELQ" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eloqua Upload Instructions</h4>
      </div>
      <div class="modal-body">
        <p>Segment > NZ Contacts > View Contacts > Export?<br>
        	<br>
        	View: ANZ_NZ_Default Contact View<br>
        	<br>
        	Save as XLS, convert to csv in Excel

        </p>

        <p>ContactID,Salutation,First Name,Last Name,Company,Department,job title,Business Phone,Mobile Phone,Email Address,ANZ_Mail Flag,Email Permission,Address 1,Address 2,Address 3,City,Zip or Postal Code,Country,Date Created,Date Modified,ANZ_SFDC_Contact ID,Eloqua Contact ID,ANZ_Masterpack_customer_code,ISO Country</p>

        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- CUSTOM INSTRUCTIONS -->
<div id="instructionsCST" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Custom Upload Instructions</h4>
      </div>
      <div class="modal-body">
        <p>
        	Upload a CSV File.  The header row will be used to create the column/field names.  First column must be ID (values can be empty)
        </p>

        <p></p>

        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!--- ERROR HANDLING -->
<div class="row">
	<div class="col-xs-12">
<?php 	if(!empty($up->error)){ ?>
			<div class="alert alert-danger">
				<strong>ERROR: </strong><?php echo $up->error; ?>
			</div>
<?php	}?>	
<?php 	if(!empty($up->success)){ ?>
			<div class="alert alert-success">
				<strong>WINNING! </strong><?php echo $up->success; ?>
			</div>
<?php	}
		if(!empty($error)){ ?>
			<div class="alert alert-danger">
				<strong>ERROR: </strong><?php echo $error; ?>
			</div>
<?php	}?>	
<?php 	if(!empty($success)){ ?>
			<div class="alert alert-success">
				<strong>WINNING! </strong><?php echo $success; ?>
			</div>
<?php	} ?>	
	</div>
</div>


<div class="row">
	<div class="col-md-6">
		<h1>Salesforce.com</h1>

	<?php 	$r = $conn->query("SELECT * from all_sfdc");
			if(!$conn->error){ $totalSFDC = $r->num_rows; } else { $totalSFDC = "0";}

			$r2 = $conn->query("SELECT * FROM all_sfdc INNER JOIN(SELECT email FROM all_sfdc GROUP BY email HAVING COUNT(id) > 1) temp ON all_sfdc.email = temp.email");
			if(!$conn->error){ $duplicateSFDC = $r2->num_rows; } else { $duplicateSFDC = "0"; }

			?>	
		
		<strong># Contacts: </strong><?php echo $totalSFDC; ?><br>
		<?php 	if($totalSFDC > 0){ ?><strong># Duplicates: </strong><?php echo countDuplicates("all_sfdc","Email", $mysql,$conn); ?><br><?php } ?>		
<br>
		<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#instructionsSFDC"><i class="fa fa-info"></i></button> -->
		<a href="viewtable.php?table=all_sfdc" class="btn btn-default <?php if($totalSFDC == 0){ echo 'hidden'; } ?> " title="VIEW RECORDS"><i class="fa fa-file-text-o"></i></a>
		<a href="viewtable.php?table=all_sfdc&action=duplicates" class="btn btn-default <?php if($totalSFDC == 0){ echo 'hidden'; } ?> " title="VIEW DUPLICATES"><i class="fa fa-copy"></i></a>
		<a href="validateemails.php?table=all_sfdc&emailfield=Email" class="btn btn-default <?php if($totalSFDC == 0){ echo 'hidden'; } ?> " title="VALIDATE EMAIL ADDRESSES"><i class="fa fa-envelope-o" style="color: #5cb85c"></i></a>
		<a href="index.php?action=clear&table=all_sfdc" class="btn btn-default <?php if($totalSFDC == 0){ echo 'hidden'; } ?> " onClick="return confirm('Clear all records and start again?')" title="CLEAR RECORDS"><i class="fa fa-close" style="color: red;"></i></a>
		<button type="button" class="btn btn-default" id="upload_sfdc"><i class="fa fa-cloud-upload" title="SHOW/HIDE UPLOADER" style="color: #428bca"></i></button><br>
		<br>
		
		<div id="sfdc_uploader" style="display: none;">
			<br>
			<form class="form-inline" method="post" action="index.php?action=upload&table=all_sfdc" enctype='multipart/form-data'>
				<div class="input-group">
					<span class="input-group-btn">
	                    <span class="btn btn-default btn-file" style="width: 45px;">
	                        <i class="fa fa-floppy-o fa-lg" style="color: #428bca;"></i> <input type="file" id="uploadfile" name="uploadfile" multiple>
	                    </span>
	                </span>
					<input type="text" class="form-control" readonly>
				</div>
				<button type="submit" name="submit" class="btn btn-default" style="width: 45px;"><i class="fa fa-check fa-lg" style="color: #5cb85c;"></i></button>
			</form>
			<br>
		</div>
		

	</div>

	<div class="col-md-6">
		<h1>Custom</h1>
	

	<?php 	$r = $conn->query("SELECT * from all_cst");
			if(!$conn->error){ $totalCST = $r->num_rows; } else { $totalCST = 0; }
	 ?>	
		
		<strong># Contacts: </strong><?php echo $totalCST; ?><br>
<?php 	if($totalCST > 0){?><strong># Duplicates: </strong><?php echo countDuplicates("all_cst","Email", $mysql,$conn); ?><br><?php } ?>		
		
		<br>
		<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#instructionsCST"><i class="fa fa-info"></i></button> -->
		<a href="viewtable.php?table=all_cst" class="btn btn-default <?php if($totalCST == 0){ echo 'hidden'; } ?> " title="VIEW RECORDS"><i class="fa fa-file-text-o"></i></a>
		<a href="viewtable.php?table=all_cst&action=duplicates" class="btn btn-default <?php if($totalCST == 0){ echo 'hidden'; } ?> " title="VIEW DUPLICATES"><i class="fa fa-copy"></i></a>
		<a href="validateemails.php?table=all_cst&emailfield=Email" class="btn btn-default <?php if($totalCST == 0){ echo 'hidden'; } ?> " title="VALIDATE EMAIL ADDRESSES"><i class="fa fa-envelope-o" style="color: #5cb85c"></i></a>
		<a href="index.php?action=clear&table=all_cst" class="btn btn-default <?php if($totalCST == 0){ echo 'hidden'; } ?> " onClick="return confirm('Clear all records and start again?')" title="CLEAR RECORDS"><i class="fa fa-close" style="color: red;"></i></a>
		<button type="button" class="btn btn-default" id="upload_cst"><i class="fa fa-cloud-upload" title="SHOW/HIDE UPLOADER" style="color: #428bca"></i></button><br>
		<br>

		<div id="cst_uploader" style="display: none;">
			<form class="form-inline" method="post" action="index.php?action=upload&table=all_cst" enctype='multipart/form-data'>
				<div class="input-group">
					<span class="input-group-btn">
	                    <span class="btn btn-default btn-file" style="width: 45px;">
	                        <i class="fa fa-floppy-o fa-lg" style="color: #428bca;"></i> <input type="file" id="uploadfile" name="uploadfile" multiple>
	                    </span>
	                </span>
					<input type="text" class="form-control" readonly>
				</div>
				<button type="submit" name="submit" class="btn btn-default" style="width: 45px;"><i class="fa fa-check fa-lg" style="color: #5cb85c;"></i></button>
			</form>
			<br>
		</div>
			
	</div>
	
</div>	
<div class="row">
	<div class="col-md-6">
		<hr>
		<h1>Eloqua</h1>
	
	<?php 	$r = $conn->query("SELECT * from all_elq");
			if(!$conn->error){ $totalELQ = $r->num_rows; } else { $totalELQ = 0; } ?>	
		
		<strong># Contacts: </strong><?php echo $totalELQ; ?><br>
		<?php 	if($totalELQ > 0){?><strong># Duplicates: </strong><?php echo countDuplicates("all_elq","Email Address", $mysql,$conn); ?><br><?php } ?>		
		<br>
		<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#instructionsELQ"><i class="fa fa-info"></i></button> -->
		<a href="viewtable.php?table=all_elq" class="btn btn-default <?php if($totalELQ == 0){ echo 'hidden'; } ?> " title="VIEW RECORDS"><i class="fa fa-file-text-o"></i></a>
		<a href="viewtable.php?table=all_elq&action=duplicates" class="btn btn-default <?php if($totalELQ == 0){ echo 'hidden'; } ?> " title="VIEW DUPLICATES"><i class="fa fa-copy"></i></a>
		<a href="validateemails.php?table=all_elq&emailfield=Email_Address" class="btn btn-default <?php if($totalELQ == 0){ echo 'hidden'; } ?> " title="VALIDATE EMAIL ADDRESSES"><i class="fa fa-envelope-o" style="color: #5cb85c"></i></a>
		<a href="index.php?action=clear&table=all_elq" class="btn btn-default <?php if($totalELQ == 0){ echo 'hidden'; } ?> " onClick="return confirm('Clear all records and start again?')" title="CLEAR RECORDS"><i class="fa fa-close" style="color: red;"></i></a>
		<button type="button" class="btn btn-default" id="upload_elq"><i class="fa fa-cloud-upload" title="SHOW/HIDE UPLOADER" style="color: #428bca"></i></button><br>
		<br>
		
		<div id="elq_uploader" style="display: none;">
			<br>
			<form class="form-inline" method="post" action="index.php?action=upload&table=all_elq" enctype='multipart/form-data'>
				<div class="input-group">
					<span class="input-group-btn">
	                    <span class="btn btn-default btn-file" style="width: 45px;">
	                        <i class="fa fa-floppy-o fa-lg" style="color: #428bca;"></i> <input type="file" id="uploadfile" name="uploadfile" multiple>
	                    </span>
	                </span>
					<input type="text" class="form-control" readonly>
				</div>
				<button type="submit" name="submit" class="btn btn-default" style="width: 45px;"><i class="fa fa-check fa-lg" style="color: #5cb85c;"></i></button>
			</form>
			<br>
		</div>

	</div>


	<div class="col-md-6">
		<hr>
		<h1>GoDirect</h1>
	
	<?php 	$r = $conn->query("SELECT * from all_gd");
			if(!$conn->error){ $totalGD = $r->num_rows; } else{ $totalGD = 0; }
			 ?>	
		
		<strong># Contacts: </strong><?php echo $totalGD; ?><br>
		<?php 	if($totalGD > 0){?><strong># Duplicates: </strong><?php echo countDuplicates("all_gd","Email", $mysql,$conn); ?><br><?php } ?>		
		<br>
		<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#instructionsGD"><i class="fa fa-info"></i></button> -->
		<a href="viewtable.php?table=all_gd" class="btn btn-default <?php if($totalGD == 0){ echo 'hidden'; } ?> " title="VIEW RECORDS"><i class="fa fa-file-text-o"></i></a>
		<a href="viewtable.php?table=all_gd&action=duplicates" class="btn btn-default <?php if($totalGD == 0){ echo 'hidden'; } ?> " title="VIEW DUPLICATES"><i class="fa fa-copy"></i></a>
		<a href="validateemails.php?table=all_gd&emailfield=Email" class="btn btn-default <?php if($totalGD == 0){ echo 'hidden'; } ?> " title="VALIDATE EMAIL ADDRESSES"><i class="fa fa-envelope-o" style="color: #5cb85c"></i></a>
		<a href="index.php?action=clear&table=all_gd" class="btn btn-default <?php if($totalGD == 0){ echo 'hidden'; } ?> " onClick="return confirm('Clear all records and start again?')" title="CLEAR RECORDS"><i class="fa fa-close" style="color: red;"></i></a>
		<button type="button" class="btn btn-default" id="upload_gd"><i class="fa fa-cloud-upload" title="SHOW/HIDE UPLOADER" style="color: #428bca"></i></button><br>
		<br>
		
		<div id="gd_uploader" style="display: none;">
			<br>
			<form class="form-inline" method="post" action="index.php?action=uploadGD" enctype='multipart/form-data'>
				<div class="input-group">
					<span class="input-group-btn">
	                    <span class="btn btn-default btn-file" style="width: 45px;">
	                        <i class="fa fa-floppy-o fa-lg" style="color: #428bca;"></i> <input type="file" id="uploadfile" name="uploadfile" multiple>
	                    </span>
	                </span>
					<input type="text" class="form-control" readonly>
				</div>
				<button type="submit" name="submit" class="btn btn-default" style="width: 45px;"><i class="fa fa-check fa-lg" style="color: #5cb85c;"></i></button>
			</form>
			<br>
		</div>

	</div>

	
	
</div>
<div class="row">
	<div class="col-sm-12"><BR></div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
  			<div class="panel-heading">
    			<h3 class="panel-title">Email List Validation</h3>
  			</div>
  			<div class="panel-body">
    			<ol>
					<li>Upload country extract from SFDC</li>
					<li>Upload Custom List</li>
					<li>Upload Eloqua List (may need to customise to add subscriptions?)</li>
					<li>Export then delete duplicates from SFDC</li>
					<li>Export then delete duplicates from custom list</li>
					<li>Compare Custom & SFDC where not in SFDC, export then delete</li>
					<li>Validate email addresses in Custom.  Repair, then export & delete fails</li>`
					<li>Repaired emails in ELQ and SFDC?</li>
					<li>Check SFDC Mail Flag, export & delete M, N, X</li>
					<li>Compare Custom & SFDC & Eloqua where not in Eloqua, export and upload to eloqua through New Contacts program</li>
					<li>Compare Custom & SFDC & Eloqua where in Eloqua.  Look for Email permission, subscriptions</li>
					<li>MORE TO COME....</li>
    			</ol>
  			</div>
		</div>
	</div>
</div>
<div class="row" style="display: none;">
	<h2>Functions</h2>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		
		<div class="panel panel-default">
		  	<div class="panel-heading" role="tab" id="headingOne">
		  		<h4 class="panel-title">
		  			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
		  			Comparing Contacts</a>
		  		</h4>
		  	</div>
		  	<div id="collapseOne" class="panel panel-collapse collapse" role="tab-panel" aria-labelledby="headingOne">
			  	<div class="panel-body">
			    	Stuff here
			  	</div>
			  	<ul class="list-group">
    				<li class="list-group-item"><a href="#">Contacts in GoDirect but not in SFDC</a></li>
    				<li class="list-group-item">Contacts in Eloqua but not in SFDC</li>
    				<li class="list-group-item"><a href="comparetables.php?action=inSFDCnotELQ">Contacts in SFDC but not in Eloqua</a></li>
    			</ul>	
		  	</div>
		</div>
		

		<div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="headingTwo">
		      <h4 class="panel-title">
		        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
		          Collapsible Group Item #2
		        </a>
		      </h4>
		    </div>
		    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
		      <div class="panel-body">
		        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
		      </div>
		    </div>
		  </div>

	</div>
	


</div>

<script>
	$(document).ready(function(){
		$('#upload_sfdc').click(function(){
			$('#sfdc_uploader').toggle();
		});
		$('#upload_cst').click(function(){
			$('#cst_uploader').toggle();
		});
		$('#upload_elq').click(function(){
			$('#elq_uploader').toggle();
		});


		$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        
	        var input = $(this).parents('.input-group').find(':text'),
	            log = numFiles > 1 ? numFiles + ' files selected' : label;
	        
	        if( input.length ) {
	            input.val(log);
	        } else {
	            if( log ) alert(log);
	        }
	        
	    });

	    $(document).on('change', '.btn-file :file', function() {
		  var input = $(this),
		      numFiles = input.get(0).files ? input.get(0).files.length : 1,
		      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		  input.trigger('fileselect', [numFiles, label]);
		});




	});
</script>




<?php include('includes/footer.php');	?>