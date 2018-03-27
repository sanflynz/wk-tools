<?php
	include("includes/db.php");
	include("includes/sitefunctions.php");
	//define ('SITE_ROOT', realpath(dirname(__FILE__)));
	//
	$error = "";
	$success = "";

	if($_POST){
		
		$fieldNames = "name,title,image,description,features,post_features,more,items,resources,related,country";
		$fields = "";
		$values = "";

		// Image Upload
		if($_FILES['image']['size'] > 0){
			$target_dir = "../../../Uploads/image/";
			
			$target_file = $target_dir . basename($_FILES['image']['name']);
			if(getimagesize($_FILES['image']['tmp_name'])){
				if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)){
					$success .= "Image was uploaded<br><br>";
					$_POST['image'] = substr($target_file,8);

				}
				else{
					setFlash('warning', "Image ". $_FILES['image']['name'] . " was not uploaded <a href=" . $target_dir . ">" . $target_dir . "</a>");
				}
			}
			else{
				setFlash("warning", "File " . $_FILES['image']['name'] . "is not an image");
			}
			

		}

		$p = $_POST;
		
		//print_r($p);
		

		if($p['id'] == ""){
			$i = 1;
			foreach(explode(",", $fieldNames) as $fn){
				$fields .= "`" . $fn . "`"; if($i < count(explode(",", $fieldNames))){ $fields .= ","; }
				$values .= "'" . addslashes($_POST[$fn]) . "'"; if($i < count(explode(",", $fieldNames))){ $values .= ","; }
				$i++;
			}

			$sql = "INSERT INTO webgenericpages (" . $fields . ") VALUES (" . $values . ")";
			//echo $sql;
			$r = $conn->query($sql);
			if($r){
				// redirect
				header("location: genericpage_au_v.php?id=" . mysqli_insert_id($conn));
				
			}
			else{
				setFlash('danger', "Unable to add page: " . $conn->error . "<br><br>" . $sql);
			}
		}
		else{
			$values = "";
			$i = 1;
			foreach(explode(",", $fieldNames) as $f){
				$values .= "`" . addslashes($f) . "`" . "='" . addslashes($p[$f]) . "'";
				if($i < count(explode(",",$fieldNames))){
					$values .= ",";
				}
				$i++;
			}
			$sql = "UPDATE webgenericpages SET $values WHERE id = " . $p['id'];
			//echo $sql;
			$r = $conn->query($sql);
			if($r){
				// redirect
				header("location: genericpage_au_v.php?id=" . $p['id']);
			}
			else{
				setFlash("danger", "Unable to update page: " . $conn->error);
			}

		}


	 }

	if(isset($_GET['id'])){
		$sql = "SELECT * FROM `webgenericpages` p WHERE p.id = " . $_GET['id'];
		$r = $conn->query($sql);
		$p = $r->fetch_assoc();
	}

	if(isset($_GET['copy'])){
		$sql = "SELECT * FROM `webgenericpages` p WHERE p.id = " . $_GET['copy'];
		$r = $conn->query($sql);
		$p = $r->fetch_assoc();

		$p['id'] = "";
		$p['country'] = "";
		echo $p['country'];
	}

	if(isset($_GET['copypromo'])){
		$sql = "SELECT * FROM `webpromopages` p WHERE p.id = " . $_GET['copy'];
		$r = $conn->query($sql);
		$p = $r->fetch_assoc();

		$p['id'] = "";
		$p['country'] = "";
		echo $p['country'];
	}



	include("includes/header.php");

	//print_r($p);
?>

<div class="modal fade" id="info-description" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal">&times;</button>
				<h4 style="margin: 0;">Description Instructions</h4>
			</div>
			<div class="modal-body">
				None yet
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="info-features" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal">&times;</button>
				<h4 style="margin: 0">Features Instructions</h4>
			</div>
			<div class="modal-body">
				Creates a bullet-point list.  Place each new point on a new line.<br>
				<br>
				Groups...<br>
				[GROUP][HEADING]Heading Here<br>
				Items<br>
				Items<br>
				[GROUP][HEADING]Heading Here<br>
				Items<br>
				Items<br>
				<br>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="info-items">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal">&times;</button>
				<h4 style="margin:0">Items Instructions</h4>
			</div>
			<div class="modal-body">
				Copy from a spreadsheet.  It will automatically recognise the tabs and new lines<br>
				<br>
				If you want to link to the Search page on the Item Code and Description ensure the first two column headings are "Item Code" and "Description" exactly<br>
				<br> 
				Column Widths...  add eg: [25%] directly after the column heading name to widen eg: Item Code[25%]<br>
				<br>
				If you want to break out the table into groups:<br>
				Groups...<br>
				[GROUP][HEADING]Heading/Title Here<br>
				Table header row<br>
				Items<br>
				Items<br>
				[GROUP][HEADING]Heading/Title Here<br>				
				Table header row<br>
				Items<br>
				Items<br>
				<br>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="info-resources">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal">&times;</button>
				<h4>Resources & Support</h4>
			</div>
			<div class="modal-body">
				Each resource or support item on a new line (press enter, wordwrap does not count)<br>
				<br>
				Structure is:<br>
				text<strong>|</strong>url<strong>|</strong>tab<strong>|</strong>action<strong>|</strong>label<br>
				<br>
				tab = new or parent<br>
				<br>
				action & label are optional, used for tracking.  If you use action, you must use label<br>
				Use the following actions only: PDF, Related Product, Request Quote, Request Information, Video<br>
				<br>
				eg: Brochure: Thermo Scientific MaxQ Shakers|https://tools.thermofisher.com/content/sfs/brochures/D11049~.pdf|new|PDF|MaxQ Shakers Brochure<br>
				<br>			
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-xs-12">
		<h1>Generic (child) Page Add/Edit</h1>
		<br>
<?php 	flash(); ?>	
		
	</div>
</div>
	


<div class="row">
	<div class="col-md-4">
		buttons
	</div>
</div>
<form method="post" role="form" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php if(isset($p)) {echo $p['id'];} ?>">
	<div class="row">
		<div class="col-xs-sm">
			<table class="table">
			<tr>
				<td width="250" align="right"><strong>Country</strong></td>
				<td>
					<select name="country" id="" class="form-control" required>
						<option></option>
						<option value="Australia" <?php if(isset($p['country']) && $p['country'] == "Australia") {echo " selected"; } ?> >Australia</option>
						<option value="New Zealand" <?php if(isset($p['country']) && $p['country'] == "New Zealand") {echo " selected"; } ?>>New Zealand</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td width="250" align="right"><strong>Page Name</strong></td>
				<td><input name="name" type="text" value="<?php if(isset($p)) { echo $p['name']; } ?>" class="form-control"></td>
			</tr>
			
			<tr>
				<td width="250" align="right"><strong>Page Heading</strong></td>
				<td><input name="title" type="text" value="<?php if(isset($p)) { echo htmlentities($p['title']); } ?>" class="form-control"></td>
			</tr>

			<tr>
				<td width="250" align="right"><strong>Main Image</strong></td>
				<td>
					<div class="form-group row">
						<div class="col-xs-6">
							<input name="image" type="text" value="<?php if(isset($p) && $p['image'] != "")  { echo $p['image']; } ?>" class="form-control">
					
						</div>
						<div class="col-xs-6">
							<input name="image" type="file" value="<?php if(isset($p) && $p['image'] != "")  { echo $p['image']; } ?>" class="form-control">
						</div>
					</div>
						
				</td>
			</tr>
			
			<tr>
				<td align="right">
					<strong>Description</strong><br>
					<br>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#info-description"><i class="fa fa-info"></i></button>
				</td>
				<td><textarea name="description" class="form-control" rows="15"><?php if(isset($p)) {echo htmlentities($p['description']);} ?></textarea></td>
			</tr>

			<tr>
				<td align="right">
					<strong>Features</strong><br>
					<br>
					<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#info-features"><i class="fa fa-info"></i></button>
				</td>
				<td><textarea name="features" class="form-control" rows="10"><?php if(isset($p)) {echo htmlentities($p['features']);} ?></textarea></td>
			</tr>

			<tr>
				<td align="right"><strong>Post-Features</strong></td>
				<td><textarea name="post_features" class="form-control" rows="5"><?php if(isset($p)) {echo htmlentities($p['post_features']);} ?></textarea></td>
			</tr>

			<tr>
				<td width="250" align="right"><strong>Quicklinks</strong></td>
				<td><input name="more" type="hidden" value="<?php if(isset($p)) { echo $p['more']; } ?>" class="form-control"></td>
			</tr>
			
			<tr>
				<td align="right">
					<strong>Items</strong><br>
					<br>
					<button class="btn btn-primary" data-toggle="modal" data-target="#info-items" type="button"><i class="fa fa-info"></i></button>
				</td>
				<td><textarea name="items" class="form-control" rows="6"><?php if(isset($p)) {echo htmlentities($p['items']); } ?></textarea></td>
			</tr>
			
			<tr>
				<td align="right">
					<strong>Resources</strong><br>
					<br>
					<button class="btn btn-primary" data-toggle="modal" data-target="#info-resources" type="button"><i class="fa fa-info"></i></button>
				</td>
				<td><textarea name="resources" class="form-control" rows="5"><?php if(isset($p)) {echo htmlentities($p['resources']);} ?></textarea></td>
			</tr>
			
			<tr>
				<td align="right">
					<strong>Support</strong><br>
					<br>
					<button class="btn btn-primary" data-toggle="modal" data-target="#info-resources" type="button"><i class="fa fa-info"></i></button>
				</td>
				<td><textarea name="related" class="form-control" rows="5"><?php if(isset($p)) {echo htmlentities($p['related']);} ?></textarea></td>
			</tr>
			
			<tr>
				<td></td>
				<td><button class="btn btn-success">Submit Changes</button></td>
			</tr>
		</table>
		</div>

	</div>
</form>



<?php

	include("includes/footer.php");

?>