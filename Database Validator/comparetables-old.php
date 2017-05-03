
<?php 	include('includes/header.php'); 

		include('../__classes/Pagination.php'); 
		include('../__classes/DownloadCsvMysql.php'); 
		include('../__classes/MySqlFunctions.php');

		$mysql = new MySqlFunctions($conn);


		/*** $_GET Options ***/
		// type : predefined,custom
		// predefined : customHealth

		if(isset($_POST['data'])){
			$data = $_POST['data'];

			// DO SOME VALIDATION eg: not both tables same, selected columns
			if(isset($_GET['type']) && $_GET['type'] == "predefined"){
				if($data['querytype'] == "Invalid Contacts"){

					// DO SOME VALIDATION ON TABLES AND FIELDS
					
					//OPTION 1 
					// $fields = $mysql->colsToAlias(explode(",", $mysql->getHeaders("all_cst")), 'cst');
					// $fields .= ", `sfdc`.`Email` AS 'sfdc__Email', `sfdc`.`Contact ID` AS 'sfdc__Contact ID', `sfdc`.`Active Account?` AS 'sfdc__Active Account?'";
					// $fields .= ", `elq`.`Email Address` AS elq__Email, `elq`.`Email Permission` AS 'elq__Email Permission'";
					// $sql = "SELECT " . $fields . " FROM all_cst cst LEFT JOIN all_sfdc sfdc ON cst.Email = sfdc.Email LEFT JOIN all_elq elq ON cst.Email = elq.`Email Address` WHERE sfdc.Email IS NULL OR sfdc.`Mail Flag` = 'M' OR sfdc.`Mail Flag` = 'N' OR sfdc.`Mail Flag` = '' OR sfdc.`Active Account?` = '0'";
					
					// OPTION 2 - make data array
					// $fields = $mysql->colsToAlias(explode(",", $mysql->getHeaders("all_cst")), 't1');
					// $fields .= ", `t2`.`Email` AS 't2__Email', `t2`.`Contact ID` AS 't2__Contact ID', `t2`.`Active Account?` AS 't2__Active Account?'";
					// $fields .= ", `t3`.`Email Address` AS t3__Email, `t3`.`Email Permission` AS 't3__Email Permission'";
					
					$data['t1']['table'] = 'all_cst';
					$data['t2']['table'] = 'all_sfdc';
					$data['t3']['table'] = 'all_elq';

					$data['t1']['comparisonfield'] = 'Email';
					$data['t2']['comparisonfield'] = 'Email';
					$data['t3']['comparisonfield'] = 'Email Address';

					foreach(explode(",", $mysql->getHeaders("all_cst")) as $h){
						$data['t1']['fields'][] = $h;
					}

					$data['t2']['fields'][] = "Contact ID";
					$data['t2']['fields'][] = "Email";
					$data['t2']['fields'][] = "Mail Flag";
					$data['t2']['fields'][] = "Active Account?";

					$data['t3']['fields'][] = "Email Address";
					$data['t3']['fields'][] = "Email Permission";

					$data['conditions'] = "`t2`.`Email` IS NULL OR t2.`Mail Flag` = 'N' OR t2.`Mail Flag` = 'M' OR t2.`Mail Flag` = '' OR t2.`Active Account?` = '0' OR t3.`Email Permission` = 'FALSE'";
				
				}

				if($data['querytype'] == "Invalid Contacts Auto Download Delete"){

					// Auto Download
					
					

					// Auto Delete
					//

				}
			}
			

			

				



				if(isset($data['delete_results_field']) && $data['delete_results_field'] == "true"){
					if($data['conditions'] == ''){
						$error = "Can not drop the entire table from this function";
					}
					else{

						// GET FIELDS
						$fields = $mysql->colsToAlias($data['t1']['fields'], 't1');
						if($data['t2']['table']){
							$fields .= "," . $mysql->colsToAlias($data['t2']['fields'], 't2');
						}
						if($data['t3']['table']){
							$fields .= "," . $mysql->colsToAlias($data['t3']['fields'], 't3');	
						}
						
						$sql = "SELECT " . $fields . " FROM `" . $data['t1']['table'] . "` t1";
						if($data['t2']['table']){
							$sql .=  " LEFT JOIN `" . $data['t2']['table'] . "` t2 ON `t1`.`" . $data['t1']['comparisonfield'] . "` = `t2`.`" . $data['t2']['comparisonfield'] . "`";
						}
						if($data['t3']['table']){
							$sql .= " LEFT JOIN `" . $data['t3']['table'] . "` t3 ON `t2`.`" . $data['t2']['comparisonfield'] . "` = `t3`.`" . $data['t3']['comparisonfield'] . "`";
						}
						if($data['conditions']){
							$sql .= " WHERE " . $data['conditions'];
						}

						$r = $conn->query($sql);
						while($row = $r->fetch_assoc()){

							//print_r($row); echo "<br>";

							$r2 = $conn->query("DELETE FROM " . $data['t1']['table'] . " WHERE id = " . $row['t1__id']);
							if($conn->error){
								$error .= $conn->error . "<br>";
							}

						}


						// $sqlD = "DELETE `t1` FROM `". $data['t1']['table'] . "` t1 ";
						// if($data['t2']['table']){
						// 	$sqlD .=  " LEFT JOIN `" . $data['t2']['table'] . "` t2 ON `t1`.`" . $data['t1']['comparisonfield'] . "` = `t2`.`" . $data['t2']['comparisonfield'] . "`";
						// }
						// if($data['t3']['table']){
						// 	$sqlD .= " LEFT JOIN `" . $data['t3']['table'] . "` t3 ON t2.`" . $data['t2']['comparisonfield'] . "` = t3.`" . $data['t3']['comparisonfield'] . "`";
						// }

						// $sqlD .= " WHERE " . $data['conditions'];
						// //echo $sqlD;
						// $rD = $conn->query($sqlD);
						// //print_r($rD);
						// if($rD){
						// 	$success = "Records deleted from " . $data['t1']['table'];
							

						// }
						// else{
						// 	$error = "Unable to delete records from " . $data['t1']['table'] . ": " . $conn->error . "<br><br><span style='font-style: italics'>" . $sqlD . "</span>";
						// }
					}
					$data['export_results_field'] = "";

				}

				// GET FIELDS
				$fields = $mysql->colsToAlias($data['t1']['fields'], 't1');
				if($data['t2']['table']){
					$fields .= "," . $mysql->colsToAlias($data['t2']['fields'], 't2');
				}
				if($data['t3']['table']){
					$fields .= "," . $mysql->colsToAlias($data['t3']['fields'], 't3');	
				}
				
				$sql = "SELECT " . $fields . " FROM `" . $data['t1']['table'] . "` t1";
				if($data['t2']['table']){
					$sql .=  " LEFT JOIN `" . $data['t2']['table'] . "` t2 ON `t1`.`" . $data['t1']['comparisonfield'] . "` = `t2`.`" . $data['t2']['comparisonfield'] . "`";
				}
				if($data['t3']['table']){
					$sql .= " LEFT JOIN `" . $data['t3']['table'] . "` t3 ON `t2`.`" . $data['t2']['comparisonfield'] . "` = `t3`.`" . $data['t3']['comparisonfield'] . "`";
				}
				if($data['conditions']){
					$sql .= " WHERE " . $data['conditions'];
				}
				
			//echo $sql;	
			
			$page = ( isset($_GET['page'])) ? $_GET['page'] : 1;
			$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 50;

			$Pagination  = new Pagination( $conn, $sql );
			$results    = $Pagination->getData( $limit, $page );

			if($Pagination->error){
				$error = "Pagination Error: " . $Pagination->error;
			}
			// echo "<pre>";
			// print_r($results);
			// echo "</pre>";
			// // $_GET['action'] = "show";

			if(isset($data['export_results_field']) && $data['export_results_field'] == "true"){
				foreach($data['t1']['fields'] as $f){
					$cols[] = "t1__" . $f;
				}
				if($data['t2']['table']){
					foreach($data['t2']['fields'] as $f){
						$cols[] = "t2__" . $f;
					}
				}
				if($data['t3']['table']){
					foreach($data['t3']['fields'] as $f){
						$cols[] = "t3__" . $f;
					}
				}

				$CsvDown = new DownloadCsvMysql($conn);
				$CsvDown->filename = "table_comparison.csv";
				$CsvDown->downloadSQL($sql,implode(",",$cols),implode(",",$cols));

				$data['export_results_field'] = '';
			}

			// REPOPULATE THE FORM

			// echo "<pre>";
			// print_r($_POST);
			// echo "</pre>";
		}


?>

<!-- INFO MODAL - INVALID CONTACTS -->
<div id="info-predefined-query" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title" id="info-predefined-title">Predefined Query Selector</h4>
	    </div>
	    <div class="modal-body">
	    	<div id="info-predfined-body-default">
	    		Select a predefined query from the list
	    	</div>
	    	<div id="info-predfined-body-invalid" style="display: none;">
	    		This query will find the following customers from a Custom Database: Contact is not is SFDC, SFDC Mail Flag is Incorrect (must be B or E), SFDC Active Account = False, 
				ELQ Email Permission = False<br>
				<br>
	    		<strong>Requirements:</strong>
	    		<ol>
	    			<li>Uploaded table SFDC with Contact ID, Email, Mail Flag and Active Account? columns included</li>
	    			<li>Uploaded table Eloqua with Email Address & Email Permission columns included</li>
	    			<li>Uploaded table Custom with Email field named Email</li>
	    		</ol>
	    	</div>
	    	<div id="info-predfined-body-not-eloqua" style="display: none;">
	    		This query will find the following customers from a Custom Database: Not in Eloqua.  Run only after removing invalid contacts<br>
				<br>
	    		<strong>Requirements:</strong>
	    		<ol>
	    			<li>Uploaded table SFDC with Contact ID, Email, Mail Flag, Active Account? + MORE columns included</li>
	    			<li>Uploaded table Eloqua with Email Address & Email Permission columns included</li>
	    			<li>Uploaded table Custom with Email field named Email</li>
	    		</ol>
	    	</div> 	 		
	      	 
	    </div>
	    <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    </div>
    </div>

  </div>
</div>



<div class="row">
	<div class="col-xs-12">
		<h1>Compare Tables</h1>
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
<div class="row" id="predefinedSelector">
	<div class="col-md-4">
		<h3>Predefined Query</h3>
		<br>
		<form action="comparetables.php?type=predefined#results" method="POST" class="form-inline" role="form" id="predefined_form">
			
			<div class="form-group">
				<select name="data[querytype]" id="querytype" class="form-control" required="required">
					<option value="">--- SELECT QUERY ---</option>
					<option value="Invalid Contacts" <?php if(isset($_POST['data']['querytype']) && $_POST['data']['querytype'] == "Invalid Contacts"){ echo " selected"; } ; ?>>Invalid Contacts</option>
				</select>
			</div>
			
			<button type="button" name="queryInfo" id="queryInfo" class="btn btn-default" style="width: 45px;"  data-toggle="modal" data-target="#info-predefined-query"><i class="fa fa-info fa-lg" style="color: #428bca;"></i></button>
			<button type="submit" name="submit" class="btn btn-default" style="width: 45px;"><i class="fa fa-check fa-lg" style="color: #5cb85c;"></i></button>
		</form>
		<br>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<hr>
		<h3>Custom Query</h3>
		<br>
	</div>
</div>
<div class="row" id="customSelector">
	<div class="col-md-4">
		<form action="comparetables.php?type=custom#results" method="post" id="custom_form">
			<input type="hidden" name="data[export_results_field]" id="export_results_field" value="false">
			<input type="hidden" name="data[delete_results_field]" id="delete_results_field" value="false">
	
	
			<select class="form-control" name="data[t1][table]" id="t1Selector">
				<option value="">--- SELECT TABLE 1 ---</option>
				<option value="all_sfdc" <?php if(isset($_POST['data']) && $data['t1']['table'] == "all_sfdc"){ echo " selected"; } ; ?> >SFDC</option>
				<option value="all_elq" <?php if(isset($_POST['data']) && $data['t1']['table'] == "all_elq"){ echo " selected"; } ; ?>>Eloqua</option>
				<option value="all_gd" <?php if(isset($_POST['data']) && $data['t1']['table'] == "all_gd"){ echo " selected"; } ; ?>>GoDirect</option>
				<option value="all_cst" <?php if(isset($_POST['data']) && $data['t1']['table'] == "all_cst"){ echo " selected"; } ; ?>>Custom</option>		  	
			</select>
			<br>				
					 
			<div id="t1_comparison_div" style="display: <?php if(isset($_POST['data'])){ echo "block"; } else { echo "none"; } ?>;">
				<label>Table 1 Comparison Field</label><br>
				<select id="t1_comparison_select" name="data[t1][comparisonfield]" class="form-control">
					
				</select>

				<br>
				<label>Table 1 Fields</label><br>
				<select name="data[t1][fields][]" id="t1_field_select" class="form-control" multiple>
					
				</select>

			</div>
	</div>

	<div class="col-md-4">
			<select class="form-control" id="t2Selector" name="data[t2][table]">
				<option value="">--- SELECT TABLE 2 ---</option>
				<option value="all_sfdc" <?php if(isset($_POST['data']) && $data['t2']['table'] == "all_sfdc"){ echo " selected"; } ; ?>>SFDC</option>
				<option value="all_elq"  <?php if(isset($_POST['data']) && $data['t2']['table'] == "all_elq"){ echo " selected"; } ; ?>>Eloqua</option>
				<option value="all_gd"  <?php if(isset($_POST['data']) && $data['t2']['table'] == "all_gd"){ echo " selected"; } ; ?>>GoDirect</option>
				<option value="all_cst"  <?php if(isset($_POST['data']) && $data['t2']['table'] == "all_cst"){ echo " selected"; } ; ?>>Custom</option>
			</select>
			
			<br>
			<div id="t2_comparison_div" style="display: <?php if(isset($_POST['data'])){ echo "block"; } else { echo "none"; } ?>;">
				<label>Table 2 Comparison Field</label><br>
				<select id="t2_comparison_select" name="data[t2][comparisonfield]" class="form-control">
					
				</select>

				<br>
				<label>Table 2 Fields</label><br>
				<select name="data[t2][fields][]" id="t2_field_select" class="form-control" multiple>
					
				</select>
			</div>
	</div>

	<div class="col-md-4">
			<select class="form-control" id="t3Selector" name="data[t3][table]">
				<option value="">--- SELECT TABLE 3 ---</option>
				<option value="all_sfdc" <?php if(isset($data['t3']) && $data['t3']['table'] == "all_sfdc"){ echo " selected"; } ; ?>>SFDC</option>
				<option value="all_elq"  <?php if(isset($data['t3']) && $data['t3']['table'] == "all_elq"){ echo " selected"; } ; ?>>Eloqua</option>
				<option value="all_gd"  <?php if(isset($data['t3']) && $data['t3']['table'] == "all_gd"){ echo " selected"; } ; ?>>GoDirect</option>
				<option value="all_cst"  <?php if(isset($data['t3']) && $data['t3']['table'] == "all_cst"){ echo " selected"; } ; ?>>Custom</option>
			</select>
			
			<br>
			<div id="t3_comparison_div" style="display: <?php if(isset($_POST['data'])){ echo "block"; } else { echo "none"; } ?>;">
				<label>Table 3 Comparison Field</label><br>
				<select id="t3_comparison_select" name="data[t3][comparisonfield]" class="form-control">
					
				</select>

				<br>
				<label>Table 3 Fields</label><br>
				<select name="data[t3][fields][]" id="t3_field_select" class="form-control" multiple>
					
				</select>
			</div>
	</div>	
</div>
<div class="row">
	<div class="col-md-4">
		
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<br>
		<label>Conditions (Sql WHERE...)</label><br>
		<textarea class="form-control" rows="2" name="data[conditions]"><?php if(isset($_POST['data'])){ echo $data['conditions']; } ?></textarea>
	</div>
	<div class="col-md-4">
		
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<br>
		<button type="submit" class="btn btn-success">Compare</button>
		</form>
	</div>
</div>
<?php if(isset($_POST['data'])){ ?>
<div class="row">
	<div class="col-xs-12">
		<a name="results"></a>
		<hr>
		<br>
		<?php echo $Pagination->total; ?> Records Found  
		<?php if($Pagination->total > 0){ ?>
			<!-- LATER, MAKE THIS A POP UP WINDOW WITH OPTIONS -->
			<button type="button" class="btn btn-default" title="EXPORT RESULTS" id="export_results"><i class="fa fa-cloud-download" style="color: green;"></i></button> 
			<button type="button" class="btn btn-default" title="DELETE RESULTS" id="delete_results"><i class="fa fa-close" style="color: red;"></i></button> <br>
			<?php $Pagination->showLinks = 3; ?>
			<?php echo $Pagination->buildLinks(); ?>&nbsp;&nbsp;
		<?php } ?>
		
	</div>
</div>
<?php if($Pagination->total > 0){ ?>
<div class="row" >
	<div class="col-xs-12">
	<?php 	$r = $mysql->aliasArrayToArray($results->data);
			//echo "<pre>"; print_r($r); echo "</pre>";?>	
		<table class="table table-hover">
			<thead>
		<?php 	$f = explode(",", $fields);
				foreach($f as $m){
					$n = explode(" AS ", $m);
					$o = explode("__", str_replace("'", "", $n[1]));
					$p[] = explode("__", str_replace("'", "", $n[1]));
					 ?>
					<th><?php echo $o[0] . "<br>" .$o[1]; ?></th>
		<?php	}
					 ?>		
			</thead>
			<tbody>

		<?php	
				foreach($r as $row){
					echo "<tr>";
					foreach($p as $c){
						
						echo "<td>" . $row[$c[0]][$c[1]] . "</td>";
						
						
					}
					echo "</tr>";
				}	
		?>		
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<?php echo $Pagination->buildLinks(); ?>
	</div>
</div>
<?php } ?>
<?php } ?>






<script>
	$(document).ready(function(){

		$('#queryInfo').click(function(){
			if($('#querytype').val() == 'Invalid Contacts'){
				$('#info-predfined-body-invalid').show();
				$('#info-predfined-body-default').hide();
				$('#info-predefined-title').html('Invalid Contacts');
			}
		});

		$('#custom_form').submit(function(){
			//$('#loader').show();
		});


		
		

<?php 	if(isset($_POST['data'])){ ?>

		$('#export_results').click(function(){
			$('#export_results_field').val("true");
			$( "#custom_form" ).submit();
		});

		$('#delete_results').click(function(){
			var r = confirm("Are you sure you want to delete these records from <?php echo $data['t1']['table']; ?>?");
		    if (r == true) {
		       	$('#delete_results_field').val("true");
				$( "#custom_form" ).submit();
		    } 
		    
		});

		$.ajax({
			type: "GET",
			url: "ajax.php?action=tableComparisonOptions&table=<?php echo $data['t1']['table']; ?>",
			success: function(response){
				//location.reload();
				//alert(response);
				$("#t1_comparison_select").html(response);	
				$("#t1_comparison_select").val('<?php echo $data['t1']['comparisonfield']; ?>');	
				
				$("#t1_field_select").html(response);	

				var fields = "<?php echo implode(",", $data['t1']['fields']); ?>";
				var fieldsArray = fields.split(",");
				$("#t1_field_select").val(fieldsArray);	

			} 
		});

<?php	if(isset($data['t2']['fields'])){ ?>

		$.ajax({
			type: "GET",
			url: "ajax.php?action=tableComparisonOptions&table=<?php echo $data['t2']['table']; ?>",
			success: function(response){
				//location.reload();
				//alert(response);
				$("#t2_comparison_select").html(response);	
				$("#t2_comparison_select").val('<?php echo $data['t2']['comparisonfield']; ?>');	
				
				$("#t2_field_select").html(response);	

				var fields = "<?php echo implode(",", $data['t2']['fields']); ?>";
				var fieldsArray = fields.split(",");
				$("#t2_field_select").val(fieldsArray);	
							
			} 
		});
<?php 	} ?>


<?php	if(isset($data['t3']['fields'])){ ?>
		$.ajax({
			type: "GET",
			url: "ajax.php?action=tableComparisonOptions&table=<?php echo $data['t3']['table']; ?>",
			success: function(response){
				//location.reload();
				//alert(response);
				$("#t3_comparison_select").html(response);	
				$("#t3_comparison_select").val('<?php echo $data['t3']['comparisonfield']; ?>');	
				
				$("#t3_field_select").html(response);	

				var fields = "<?php echo implode(",", $data['t3']['fields']); ?>";
				var fieldsArray = fields.split(",");
				$("#t3_field_select").val(fieldsArray);	
							
			} 
		});
<?php 	} ?>

<?php	} ?>		
		
		

		$("#t1Selector").change(function(){

			var t1Value = $(this).val();
			
			$.ajax({
				type: "GET",
				url: "ajax.php?action=tableComparisonOptions&table=" + t1Value,
				success: function(response){
					//location.reload();
					//alert(response);
					$("#t1_comparison_select").html(response);	
					$("#t1_field_select").html(response);				
				}
			});

			$.ajax({
				type: "GET",
				url: "ajax.php?action=tableFields&table=" + t1Value + "&t=t1",
				success: function(response){
					$("#t1_fields").html(response);
				}
			});

			$("#t1_comparison_div").show();



			//alert("got t1");
		});

		$("#t2Selector").change(function(){
			var t2Value = $(this).val();
			
			$.ajax({
				type: "GET",
				url: "ajax.php?action=tableComparisonOptions&table=" + t2Value,
				success: function(response){
					//location.reload();
					//alert(response);
					$("#t2_comparison_select").html(response);
					$("#t2_field_select").html(response);
					
				}
			});

			$("#t2_comparison_div").show();

			//alert("got t1");
		});

		$("#t3Selector").change(function(){
			var t3Value = $(this).val();
			
			$.ajax({
				type: "GET",
				url: "ajax.php?action=tableComparisonOptions&table=" + t3Value,
				success: function(response){
					//alert("were in");
					$("#t3_comparison_select").html(response);
					$("#t3_field_select").html(response);
					
				}
			});

			$("#t3_comparison_div").show();

			//alert("got t1");
		});

	});

</script>


<?php 	include('includes/footer.php'); ?>