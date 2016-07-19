<?php

include("classes/UploadCsvMySql.php");
include("classes/DownloadCsvMysql.php");

//error_reporting (0);
error_reporting (E_ALL);
set_time_limit (0);



/*** DATABASE CONNECTION ***/
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "wk_ees";

	// Create connection
	$conn = new mysqli($servername, $username, $password,$database);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	//echo "Connected successfully";

/*** DATABASE CONNECTION -- ENDS ***/

// Need to get rid of this -> $_GET['action']
$action = '';
$qs = $_SERVER["QUERY_STRING"];
if($qs){
	
	$st = explode('=',$qs);
	$action = $st['1'];
}

$error = '';	
$success = '';

function latestStage() {
	// work back from unsubscribe
	global $conn;
	$r = $conn->query("SELECT * from uploads");
	//$uploads = $r->num_rows;
	while($row = $r->fetch_assoc()) {
        
		if($row['Unsubscribed']){
        	$stage = "complete";
        }
        elseif($row['Hardbounce']){
        	$stage = "Unsubscribed";
        }
        elseif($row['Softbounce']){
        	$stage = "Hardbounce";
        }
        elseif($row['Clicked']){
        	$stage = "Softbounce";
        }
        elseif($row['Opened']){
        	$stage = "Clicked";
        }
        elseif($row['Delivered']){
        	$stage = "Opened";
        }
        elseif($row['List']){
        	$stage = "Delivered";
        }
        else{
        	$stage = "List";
        }
    }

    return $stage;
}

echo latestStage() . "<br>";
if(isset($_GET['action']) ){ echo $_GET['action']; }

$stageError = 0;
if((!isset($_GET['action']) && (latestStage() != "List")) && (($_GET['action'] != "clearall") ||($_GET['action'] != "campaigndownload") || (isset($_GET['action']) && ($_GET['action'] != latestStage())))){
	$error = "Wrong Stage!";
	$stageError = 1;
}

if(isset($_POST['submit']) && $stageError == 0) {

	if(latestStage() == 'List'){
		// Upload List
		$upStage = new UploadCsvMysql($conn);
		$cols = "anz_sfdc_contact_id,status";
		$upStage->upload('status', $cols);
	}
	else{
		// read rows, and update based on $key (not always ID)
		$upStage = new UploadCsvMysql($conn);
		$cols = "status"; // Columns to update
		$upStage->update('status', $cols, "anz_sfdc_contact_id");
	}


	// Put some success/error handling here
	if(!$upStage->error){
		// Update latestStage
		$sql = "UPDATE `uploads` SET `" . $_GET['action'] . "`= '1' WHERE 1";
		
		if ($conn->query($sql) === TRUE) {
			// Redirect to next stage
			switch ($_GET['action']) {
				case 'List':
					$nextStage = "Delivered"; 	break;
				case 'Delivered':
					$nextStage = "Opened"; 		break;
				case 'Opened':
					$nextStage = "Clicked"; 	break;
				case 'Clicked':
					$nextStage = "Softbounce"; 	break;
				case 'Softbounce':
					$nextStage = "Hardbounce"; 	break;
				case 'Hardbounce':
					$nextStage = "Unsubscribed"; 	break;
				case 'Unsubscribed':
					$nextStage = "complete"; 	break;
			}
		}

		// Redirect
		header("Location: index.php?action=" . $nextStage); 
		exit();
	}


	
}

if(isset($_GET['action']) && $_GET['action'] == 'campaigndownload'){

	$d = new DownloadCsvMysql($conn);
	$d->filename = "SFDC_Campaign_Update.csv";
	$d->download('status');

}

if(isset($_GET['action']) && $_GET['action'] == "clearall"){
	$sql = "Truncate TABLE status";
	if ($conn->query($sql) === TRUE) {
		// Set all back to uploads back to 0
		$conn->query("UPDATE `uploads` SET `List`= '0', `Delivered` = '0', `Opened` = '0', `Clicked` = '0', `Softbounce` = '0', `Hardbounce` = '0',`Unsubscribed` = '0' WHERE 1");
		header("location: index.php");
		//$success = "All records deleted";
	} else {
		$error = "Unable to clear all records" . $conn->error;
	}	
	
}


// List Rows
$r = $conn->query("SELECT * from status");
$total = $r->num_rows;

// List Rows
$r = $conn->query("SELECT * from status WHERE status LIKE '%List%'");
$totalList = $r->num_rows;

// List Delivered
$r = $conn->query("SELECT * from status WHERE status LIKE '%Sent%'");
$totalDelivered = $r->num_rows;

// List Opened
$r = $conn->query("SELECT * from status WHERE status LIKE '%Opened%'");
$totalOpened = $r->num_rows;

// List Clicked
$r = $conn->query("SELECT * from status WHERE status LIKE '%Clicked%'");
$totalClicked = $r->num_rows;

// List Softbounce
$r = $conn->query("SELECT * from status WHERE status LIKE '%Softbounce%'");
$totalSoftbounce = $r->num_rows;

// List Hardbounce
$r = $conn->query("SELECT * from status WHERE status LIKE '%Hardbounce%'");
$totalHardbounce = $r->num_rows;

// List Unsubscribed
$r = $conn->query("SELECT * from status WHERE status LIKE '%Unsubscribed%'");
$totalUnsubscribed = $r->num_rows;

?> 

<!DOCTYPE html> 
<html>
  <head>
  
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	
	<style>
		.btn{
			width: 110px;
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
		}
	</style>

	<script>

	</script>
	
	
	<title>Eloqua Email Status</title>
</head>

<body>	


<div class="container">
	<div class="row">
		<h2>Eloqua Email Status</h2>	
		<br>
	</div>
	
	<div class="row">
		<a href="index.php?action=List" class="btn btn-default" id="btn_List">List</a>  
		<a href="index.php?action=Delivered" class="btn btn-default" id="btn_Delivered">Delivered</a>  
		<a href="index.php?action=Opened" class="btn btn-default" id="btn_Opened">Opened</a>  
		<a href="index.php?action=Clicked" class="btn btn-default" id="btn_Clicked">Clicked</a>  
		<a href="index.php?action=Softbounce" class="btn btn-default" id="btn_Softbounce">Softbounce</a>  
		<a href="index.php?action=Hardbounce" class="btn btn-default" id="btn_Hardbounce">Hardbounce</a>  
		<a href="index.php?action=Unsubscribed" class="btn btn-default" id="btn_Unsubscribed">Unsubscribed</a>  
		
		<a href="index.php?action=clearall" class="btn btn-danger" onClick="return confirm('Clear all records and start again?')">Clear All</a><br>
		<br>
		<br>
	</div>

<?php 		if(!empty($upStage->error)){ ?>
				<div class="alert alert-danger">
					<strong>ERROR: </strong><?php echo $upStage->error; ?>
				</div>
	<?php	}?>	
	<?php 	if(!empty($upStage->success)){ ?>
				<div class="alert alert-success">
					<strong>WINNING! </strong><?php echo $upStage->success; ?>
				</div>
	<?php	}?>	

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
	<div class="row" id="uploader" style="display: none;">
	
		<form class="form-inline" method="post" action="index.php?action=<?php echo latestStage(); ?>" enctype='multipart/form-data'>
			<div class="input-group">
				<span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        Browse&hellip; <input type="file" id="uploadfile" name="uploadfile" multiple>
                    </span>
                </span>
				<input type="text" class="form-control" readonly>
			</div>
			<button type="submit" name="submit" class="btn btn-default">Upload</button>
		</form>
		<br>
		<br>
	</div>

	<div class="row">
		<table class="table table-striped">
			<thead>
				<tr>
					<th class="text-center">Total</th>
					<th class="text-center">List</th>
						<th class="text-center">Delivered</th>
							<th class="text-center">Opened</th>
								<th class="text-center">Clicked</th>
									<th class="text-center text-muted">Softbounce</th>
										<th class="text-center text-muted">Hardbounce</th>
											<th class="text-center text-muted">Unsubscribed</th>
											
				
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-center"><?php echo $total; ?></td>
					<td class="text-center"><?php echo $totalList; ?></td>
						<td class="text-center"><?php echo $totalDelivered; ?></td>
							<td class="text-center"><?php echo $totalOpened; ?></td>
								<td class="text-center"><?php echo $totalClicked; ?></td>
									<td class="text-center warning"><?php echo $totalSoftbounce; ?></td>
										<td class="text-center warning"><?php echo $totalHardbounce; ?></td>
											<td class="text-center warning"><?php echo $totalUnsubscribed; ?></td>
											
				</tr>
				<tr>
					<td class="text-center"></td>
					<td class="text-center"><?php echo ceil(($totalList/$total)*100) . "%"; ?></td>
						<td class="text-center"><?php echo ceil(($totalDelivered/$total)*100) . "%"; ?></td>
							<td class="text-center"><?php echo ceil(($totalOpened/$total)*100) . "%"; ?></td>
								<td class="text-center"><?php echo ceil(($totalClicked/$total)*100) . "%"; ?><br><?php echo ceil(($totalClicked/$totalOpened)*100) . "%"; ?></td>
									<td class="text-center warning"><?php echo ceil(($totalSoftbounce/$total)*100) . "%"; ?></td>
										<td class="text-center warning"><?php echo ceil(($totalHardbounce/$total)*100) . "%"; ?></td>
											<td class="text-center warning"><?php echo ceil(($totalUnsubscribed/$total)*100) . "%"; ?></td>
											
				</tr>
			</tbody>
		</table>
	</div>

	<div class="row">
		<h4>Update SFDC Campaign</h4>
		<br>
		<form class="form-inline">
		  <div class="form-group">
		    <label for="campaignID">Campaign ID</label>
		    <input type="text" class="form-control" id="campaignID" placeholder="">
		  </div>
		  <button type="button" class="btn btn-default" id="getlink">Get Link</button>  
		  <a href="index.php?action=campaigndownload" class="btn btn-success" id="btn_complete">Download</a>  <br>
		
		</form>
		<span id="campaignlink"></span>
	</div>
</div>

<script src="https://code.jquery.com/jquery-1.11.3.min.js" type="text/javascript"></script>

	<script>
			

		function getParameterByName(name) {
			name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
			var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
				results = regex.exec(location.search);
			return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
		}	
		
		var action = getParameterByName('action');
		var stageError = <?php echo $stageError; ?>;
		var stageArray = ['List','Delivered','Opened','Clicked','Softbounce','Hardbounce','Unsubscribed'];	

		if($.inArray("<?php echo latestStage(); ?>", stageArray) != -1 && stageError == 0){
			document.getElementById('uploader').style.display = 'block';			
		} 

		// Get current stage and highlight button
		if("<?php echo latestStage(); ?>" == "complete"){
			document.getElementById("btn_complete").className = "btn btn-success";
		}
		else{	
			document.getElementById("btn_<?php echo latestStage(); ?>").className = "btn btn-info";
		}
		
		$(document).on('change', '.btn-file :file', function() {
		  var input = $(this),
		      numFiles = input.get(0).files ? input.get(0).files.length : 1,
		      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		  input.trigger('fileselect', [numFiles, label]);
		});

		$(document).ready( function() {
		    
			$('#getlink').click(function(){
				//alert($('#campaignID').val());
				var gotopage = "<a href='https://ap4.salesforce.com/camp/campaignimport.jsp?id=" + $('#campaignID').val() + "' target='_blank'>https://ap4.salesforce.com/camp/campaignimport.jsp?id=" + $('#campaignID').val() + "</a>";
				$('#campaignlink').html(gotopage);
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
		});
	</script>

</body>
</html>