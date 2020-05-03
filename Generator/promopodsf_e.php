<?php

include("includes/db.php");

if(isset($_GET['action']) && $_GET['action'] == "truncate"){
	$sql = "TRUNCATE webpromopodsf";
	$r = $conn->query($sql);
	if($conn->error){
		$error = "Unable to clear database";
	}
	else{
		header("location: promopodsf_e.php");
	}
}

if(isset($_GET['action']) && $_GET['action'] == "upload"){
	include('../__classes/UploadCsvMysql.php');
	if(!$_POST['uploadcsv']){
		$error = "Data did not post";
	}
	if(isset($_POST['uploadcsv'])) {
		//$fields = $string = preg_replace('/\s+/', '', $_POST['fields']);


		$up = new UploadCsvMysql($conn);
		//$up->uploadCreate($_GET['table']);
		$cols = "`offer`,`offer_detail`,`tagline`,`call_to_action`,`url`,`image`,`promo_name`,`item_name`,`filters`,`order`";
		$up->upload("webpromopodsf",$cols);
		header("location: promopodsf_e.php");
	}
}

if(isset($_GET['action']) && $_GET['action'] == "download"){
		include('../__classes/DownloadCsvMysql.php');
		$down = new DownloadCsvMysql($conn);
		$down->filename = "promo_pods_" . strtolower(preg_replace("/\s+/", "_", $_GET['title'])) . "_" . $_GET['site'] . ".csv";

		$cols = "offer,offer_detail,tagline,call_to_action,url,image,promo_name,item_name,filters,order";
		$down->download("webpromopodsf",$cols);
		
}


if(isset($_POST['data'])){
	// print '<pre>'; 
	// print_r($_POST);
	// print '</pre>';
	$fieldNames = "offer,offer_detail,tagline,call_to_action,url,image,promo_name,item_name,filters,order";
	$fields = "";

	print_r(explode("\n",$_POST['filters']));

	// $filters = "";
	// foreach(explode("\n",$_POST['filters']) as $f){
	// 	$filters .= trim($f) . "|";
	// }
	// echo $filters;
	foreach($_POST['data'] as $p){

	$values = "";
	
		$i = 1;
		foreach(explode(",", $fieldNames) as $f){
			$values .= "`" . addslashes($f) . "`" . "='" . addslashes($p[$f]) . "'";
			if($i < count(explode(",",$fieldNames))){
				$values .= ",";
			}
			$i++;
		}
		$sql = "UPDATE webpromopodsf SET $values WHERE id = " . $p['id'];
		// echo $sql . "<br><br>";
		$r = $conn->query($sql);
		if($r){

			// redirect
			header("location: promopodsf_au_v.php?site=" . $_POST['country'] . "&title=" . rawurlencode($_POST['title']) . "&filters=" . rawurlencode($_POST['filters']));
		}
		else{
			$error = "Unable to update promo page: " . $conn->error;
		}

	}
}



$sql = "SELECT * FROM webpromopodsf";
$r = $conn->query($sql);

// code here


include("includes/header.php"); ?>

<div class="modal fade" id="info-promopods">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h4>Promo Pods with Filters</h4>
			</div>
			<div class="modal-body">
				To start, download and complete the template. Do not add or delete columns.<br>
				Order should be a number, indicating the order you wish these to be displayed in.<br>
				<br>
				<strong>Download</strong><br>
				When you have finished your promo pods, it is recommended to download and save to the following file location for easy updating in the future: <br>
				<br>
				<strong>Images</strong><br>
				Should be 294 x 150px.<br>
				Image naming convention: promo_pod_<i>product_name</i>.jpg<br>
				Should be uploaded to /Uploads/image on the website<br>
				<br>
				<strong>Filters</strong><br>
				Filters are Case Sensitive. <br>
				In your CSV file, you can have more than one filter, separate by a space.<br>
				If you want a filter with more than one word, eg: "Lab Equipment", in the CSV put "LabEquipment" but in the Generator Filters List put "Lab Equipment"<br>
				Filter name must be identical (except spaces) in the CSV file and the Filters List
			</div>
		</div>
	</div>
</div>

	
<div class="row">
	<div class="col-xs-12">
		<h1>Promo Pods with Filters<i class="fa fa-flask" style="color: #FFA500;" title="EXPERIMENTAL"></i></h1>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<br>
		<a href="promopodsf_e.php?action=truncate" class="btn btn-danger">Clear All</a>&nbsp;
		<span class="btn btn-primary" id="upload-toggle" title="Import CSV"><i class="fa fa-file-excel-o"></i> <i class="fa fa-arrow-circle-o-up"></i></span>&nbsp;
		<a href="<?php echo basename($_SERVER['REQUEST_URI']) . '&action=download'; ?>" class="btn btn-primary" title="Export CSV"><i class="fa fa-file-excel-o"></i> <i class="fa fa-arrow-circle-o-down"></i></a>&nbsp;
		<a href="supplementary/promo_pods_template_anz.csv" target="_blank" class="btn btn-default" title="CSV template" style="width: 40px;"><i class="fa fa-file-excel-o"></i></a>&nbsp; 
		<a href="" class="btn btn-default" style="width: 40px;" data-toggle="modal" data-target="#info-promopods"><i class="fa fa-info"></i></a><br>
		<div id="uploadwindow" style="display: none;">
			<p>
				<form action="promopodsf_e.php?action=upload" method="post" enctype="multipart/form-data">
					<input type="file" name="uploadfile" class="form-control">
					<input type="submit" value="Upload" name="uploadcsv" class="btn btn-primary">
				</form>
			</p>
		</div>
		<br>
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


<form method="post" enctype="multipart/form-data">
	
<table class="table">
	<tr>
		<td width="250" align="right"><strong>Country</strong></td>
		<td>
			<select name="country" id="" class="form-control" required style="width: 40%">
				<options></option>
				<option value="au" <?php if(isset($_GET['site']) && strtolower($_GET['site']) == "au") {echo " selected"; } ?> >Australia</option>
				<option value="nz" <?php if(isset($_GET['site']) && strtolower($_GET['site']) == "nz") {echo " selected"; } ?>>New Zealand</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Title</strong></td>
		<td>
			<input type="text" class="form-control" id="title" value="<?php if(isset($_GET['title'])){ echo $_GET['title']; } ?>" name="title" style="width: 40%">
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Filter List</strong></td>
		<td>
			<textarea name="filters" id="filters" cols="30" rows="3" class="form-control" style="width: 40%"><?php if(isset($_GET['filters'])){ echo $_GET['filters']; } ?></textarea>
			<span style="font-style: italic; font-size: smaller">One filter per line, as per the button text.  Filter name in the CSV should be the same, but without spaces.  Case Sensitive</span>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table class="table table-hover">
			<thead><tr>
							<th>Offer</th>
							<th>Offer Detail</th>
							<th>Tagline</th>
							<th>Call To Action</th>
							<th>URL</th>
							<th>Image</th>
							<th>Promo Name</th>
							<th>Item Name</th>
							<th>Filters</th>
							<th>Order</th>
						</tr></thead>
<?php 	$i = 0;
		while($row = $r->fetch_assoc()){
			//print_r($row);
		 ?>
			<tr>
				<td>
					<input type="hidden" name="data[<?php echo $i; ?>][id]" value="<?php echo $row['id']; ?>">
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][offer]" value="<?php echo str_replace('"', '&quot;', $row['offer']); ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][offer_detail]" value="<?php echo $row['offer_detail']; ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][tagline]" value="<?php echo $row['tagline']; ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][call_to_action]" value="<?php echo htmlentities($row['call_to_action']); ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][url]" value="<?php echo $row['url']; ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][image]" value="<?php echo $row['image']; ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][promo_name]" value="<?php echo $row['promo_name']; ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][item_name]" value="<?php echo $row['item_name']; ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][filters]" value="<?php echo $row['filters']; ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][order]" value="<?php echo $row['order']; ?>" size="4">
				</td>
			</tr>
<?php		$i++;
		}
	

?>			</table>
		</td>
	</tr>	

		
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" class="btn btn-success" value="View Pods"></td>
	</tr>
</table>

</form>


<?php



include("includes/footer.php");
	

?>