<?php
	include("includes/db.php");
	include("includes/sitefunctions.php");
	include('../__classes/UploadFile.php');

	$images = "../../../Uploads/image/";
	$imagesRelative = "/Uploads/image/";
	//define ('SITE_ROOT', realpath(dirname(__FILE__)));
	
	$error = false;
	//$success = "";
	$x = 1;

	if(isset($_POST['import-old'])){
		
		$import = $_POST;
		include("includes/l3-import-old.php");

		$settings = array(
						"hdi" => $import['hdi'],
						"featured-gateway" => $import['featured-gateway'],
						"category-lists" => $import['category-lists'],
						"videos" => $import['videos'],
						"embedded-promos" => $import['embedded-promos'],
						"resources" => $import['resources']
					);
		
		$p = import_old_page($import['url'], $settings);

		// print '<pre>'; 
		// print_r($p);
		// print '</pre>';

		// number of Features
		$x = count($p['featured']);

		setFlash("info", "Page imported from:<br><a href='" . $import['url'] . "' target='_blank'>" . $import['url'] . "</a>");
	}

	if($_POST && !isset($_POST['import-old'])){

		 $fieldNames = "country,name,main-image,page-heading,description,popular-heading,popular-1,popular-2,popular-3,featured-heading,videos,pod-left,pod-right,resources-left,resources-right,last_modified";

		 $fields = "";
		 $values = "";

		$fFieldNames = "l3_id,heading,description,image,url,tab,order";
		$fFields = "";
		$fValues = "";	

		$p = $_POST;
		$p['last_modified'] = date("Y-m-d H:i:s");

		// UPLOAD IMAGES
		$up = new UploadFile($conn,$images);
		if(!$up->upload($_FILES['main-image'])) { $error = true; } 
		elseif($_FILES['main-image']['error'] != 4){ $p['main-image'] = $imagesRelative . $_FILES['main-image']['name']; }
	
		// upload dumb arrays ones
		$dumbOnes = array("popular-1","popular-2","popular-3","pod-left","pod-right");
		foreach($dumbOnes as $d){
			$file = "";

			$file['name'] = $_FILES[$d]['name']['image'];	
			$file['type'] = $_FILES[$d]['type']['image'];	
			$file['tmp_name'] = $_FILES[$d]['tmp_name']['image']; 
			$file['error'] = $_FILES[$d]['error']['image']; 	
			$file['size'] = $_FILES[$d]['size']['image'];	

			$up = new UploadFile($conn,$images);
			if(!$up->upload($file)) { $error = true; } 
			elseif($file['error'] != 4) { $p[$d]['image'] = $imagesRelative . $file['name']; }
		}

		// upload the dumb features
		$fc = count($_FILES['featured']['name']);

		for($i = 0; $i < $fc; $i++){
			$file = "";
				
			$file['name'] = $_FILES['featured']['name'][$i]['image'];
			$file['tmp_name'] = $_FILES['featured']['tmp_name'][$i]['image'];
			$file['type'] = $_FILES['featured']['type'][$i]['image'];
			$file['error'] = $_FILES['featured']['error'][$i]['image'];
			$file['size'] = $_FILES['featured']['size'][$i]['image'];
			$file['order'] = $i;

			$up = new UploadFile($conn,$images);
			if(!$up->upload($file)) { $error = true; } 
			elseif($file['error'] != 4) {
				$p['featured'][$i]['image'] = $imagesRelative . $file['name'];
			}

		}


		// CONCATENATE POPULAR
		for($i = 1; $i < 4; $i++){
			if($p['popular-'. $i]['text'] || $p['popular-'. $i]['image'] || $p['popular-'. $i]['url']){
				$p['popular-' . $i] = $p['popular-'. $i]['text'] . "|" . $p['popular-'. $i]['image'] . "|" . $p['popular-'. $i]['url'] . "|" . $p['popular-'. $i]['tab'];
			}
			else{
				$p['popular-' . $i] = "";
			}			
		}

		//CONCATENATE VIDEOS
		if($p['videos']['heading'] || $p['videos']['left'] || $p['videos']['right']){
			$p['videos'] = "[HEADING]" . $p['videos']['heading'] . "[ITEMS]" . $p['videos']['left'] . "|" . $p['videos']['right'];
		}
		else{
			$p['videos'] = "";
		}
		
		

		// CONCATENATE PODS
		$sides = array("left", "right");
	 	foreach($sides as $s){
			if($p['pod-' . $s]['name'] || $p['pod-' . $s]['image'] || $p['pod-' . $s]['url']){
				$p['pod-' . $s] = $p['pod-' . $s]['name'] . "|" . $p['pod-' . $s]['image'] . "|" . $p['pod-' . $s]['url'] . "|" . $p['pod-' . $s]['tab'];
			}
			else{
				$p['pod-' . $s] = "";

			}
		}

		// CONCATENATE RESOURCES/SUPPORT/RELATED
		$sides = array("left", "right");
	 	foreach($sides as $s){
			if(!empty($p['resources-' . $s]['heading']) || !empty($p['resources-' . $s]['item'])){
				$p['resources-' . $s] = "[HEADING]" . $p['resources-' . $s]['heading'] . "[ITEMS]" . $p['resources-' . $s]['items'];
			}
			else{
				$p['resources-' . $s] = "";
			}
		}
		

		if($p['id'] == ""){  // CREATE NEW PAGE

			$i = 1;
			foreach(explode(",", $fieldNames) as $fn){
				$fields .= "`" . $fn . "`"; if($i < count(explode(",", $fieldNames))){ $fields .= ","; }
				$values .= "'" . addslashes($p[$fn]) . "'"; if($i < count(explode(",", $fieldNames))){ $values .= ","; }
				$i++;
			}

			$sql = "INSERT INTO webl3pages (" . $fields . ") VALUES (" . $values . ")";
			//echo $sql;
			$r = $conn->query($sql);
			if($conn->error){
				setFlash("danger", "Unable to add Level 3 Page: " . $conn->error . "<br><br>" . $sql);
				$error = true;
				//$error .= "Unable to add Level 3 Page: " . $conn->error . "<br><br>" . $sql . "<br><br>";
			}
			else{
				$id = mysqli_insert_id($conn);
				$p['id'] = $id;  // then will at least update rather than create new page if error further down... should also update all the id's to p['id']???
				foreach($p['featured'] as $f){
					$f['l3_id'] = $id;
					$fFields = "";
					$fValues = "";
					$i = 1;
					foreach(explode(",", $fFieldNames) as $fn){
						$fFields .= "`" . $fn . "`"; if($i < count(explode(",", $fFieldNames))){ $fFields .= ","; } 
						$fValues .= "'" . addslashes($f[$fn]) . "'"; if($i < count(explode(",", $fFieldNames))){ $fValues .= ","; }
						$i++;						
					}
					$sql = "INSERT INTO webl3featured (" . $fFields . ") VALUES (" . $fValues . ")";
					$r = $conn->query($sql);
					if($conn->error){
						setFlash("danger", "Unable to add feature " . $f['heading'] . ": " . $conn->error . "<br><br>" . $sql);
						$error = true;
						
					}
				}
				
			}
			
		}
		else{  // UPDATE PAGE

			$id = $p['id'];

			$values = "";
			$fValues = "";
			$i = 1;
			foreach(explode(",", $fieldNames) as $fn){
				$values .= "`" . $fn . "`" . "='" . addslashes($p[$fn]) . "'";
								
				if($i < count(explode(",",$fieldNames))){
					$values .= ",";
				}
				$i++;
			}
			$sql = "UPDATE webl3pages SET $values WHERE id = " . $p['id'];
			$r = $conn->query($sql);
			if($conn->error){
				setFlash("danger", "Unable to update Level 3 page: " . $conn->error);
			}	
			else{

				// FEATURED ITEMS
				$x = 0;
				foreach($p['featured'] as $f){
					$f['l3_id'] = $p['id'];
					if($f['id'] == ""){
						// CREATE
						$i = 1;
						$fFields = "";
						$fValues = "";
						foreach(explode(",", $fFieldNames) as $fn){
							$fFields .= "`" . $fn . "`"; if($i < count(explode(",", $fFieldNames))){ $fFields .= ","; } 
							$fValues .= "'" . addslashes($f[$fn]) . "'"; if($i < count(explode(",", $fFieldNames))){ $fValues .= ","; }	
							$i++;			
						}
						echo $fFields . "<br>" . $fValues . "<br><br>";
						
						$sql = "INSERT INTO webl3featured (" . $fFields . ") VALUES (" . $fValues . ")";
						$p['featured'][$x]['id'] = mysqli_insert_id($conn);
						
						//echo $sql;
						$r = $conn->query($sql);
						if($conn->error){
							setFlash("danger", "Unable to add feature " . $f['heading'] . ": " . $conn->error . "<br><br>" . $sql);
							$error = true;
						}
						$i++;

					}
					else{

						// UPDATE
						$i = 1;
						$fFields = "";
						$fValues = "";
						foreach(explode(",", $fFieldNames) as $fn){
							$fValues .= "`" . addslashes($fn) . "`" . "='" . addslashes($f[$fn]) . "'";
							if($i < count(explode(",",$fFieldNames))){
								$fValues .= ",";
							}
							$i++;
						}
						$sql = "UPDATE webl3featured SET " . $fValues . " WHERE id = " . $f['id'];
						$r = $conn->query($sql);
						if($conn->error){
							setFlash("danger", "Unable to update feature " . $f['id'] . ": " . $f['heading'] . ": " . $conn->error . "<br><br>" . $sql);
							$error = "true";
						}	
					}
					$x++;
				}
			}
		}
		//echo "this is the end!";
		if(!$error){
			// redirect
			header("location: l3page_au_v.php?id=" . $id);
		}


  	}
  	else{ // GET EXISTING DATA


	  	if(isset($_GET['id']) || isset($_GET['copy'])){

	  		if(isset($_GET['id'])){ $thisId = $_GET['id']; }
	  		elseif(isset($_GET['copy'])){ $thisId = $_GET['copy']; }

		 	$sql = "SELECT * FROM `webl3pages` p WHERE p.id = " . $thisId;
		 	$r = $conn->query($sql);
		 	$p = $r->fetch_assoc();

		 	$sql2 = "SELECT * FROM `webl3featured` f WHERE f.l3_id = " . $thisId . " ORDER BY f.order,f.id";
		 	$r2 = $conn->query($sql2);
		 	
		 	$x = 0;
		 	while($row = $r2->fetch_assoc()){
		 		$p['featured'][$x] = $row;
		 		if(isset($_GET['copy'])){
		 			$p['featured'][$x]['id'] = "";
		 			$p['featured'][$x]['l3_id'] = "";
		 		}
		 		
		 		$x++;
		 	}
		 	if($x == 0){ $x = 1; }

		 	if(isset($_GET['copy'])){
		 		$p['id'] = "";
				$p['country'] = "";
		 	}
		}
  	}

	if(isset($p)){
		// SPLIT POPULAR	 	
	 	for($i = 1; $i < 4; $i++){
	 		if($p['popular-' . $i]){
		 		$p['popular-' . $i] = explode("|",$p['popular-' . $i]);
			 	$p['popular-' . $i]['text'] = $p['popular-' . $i][0];
			 	$p['popular-' . $i]['image'] = $p['popular-' . $i][1];
			 	$p['popular-' . $i]['url'] = $p['popular-' . $i][2];
			 	$p['popular-' . $i]['tab'] = $p['popular-' . $i][3];
			}
	 	}	 	
	 	
	 	// SPLIT VIDEOS
	 	if(isset($p['videos']) && $p['videos'] != ""){ 
	 		$parts = explode("[ITEMS]",$p['videos']);
	 		$items = explode("|", $parts[1]);
	 		$p['videos'] = "";
	 		$p['videos']['heading'] = substr($parts[0],9);
	 		$p['videos']['left'] = $items[0];
	 		$p['videos']['right'] = $items[1];
	 	}

	 	// SPLIT PODS
	 	$sides = array("left", "right");
	 	foreach($sides as $s){
	 	if($p['pod-' . $s]){
	 			$p['pod-' . $s] = explode("|",$p['pod-' . $s]);
	 			$p['pod-' . $s]['name'] = $p['pod-' . $s][0];
	 			$p['pod-' . $s]['image'] = $p['pod-' . $s][1];
	 			$p['pod-' . $s]['url'] = $p['pod-' . $s][2];
	 			$p['pod-' . $s]['tab'] = $p['pod-' . $s][3];
	 		}
	 	}
	 	
	 	
	 	// SPLIT RESOURCES
	 	foreach($sides as $s){
	 		if(isset($p['resources-' . $s]) && $p['resources-' . $s] != ""){
	 			$parts = explode("[ITEMS]",$p['resources-' . $s]);
	 			$p['resources-' . $s] = ""; // resets the array?
	 			$p['resources-' . $s]['heading'] = substr($parts[0],9);
	 			$p['resources-' . $s]['items'] = $parts[1];
	 			
	 		}
	 	}	
  	}

	include("includes/header.php");

?>

<style>
	input, select, textarea {
		margin-bottom: 3px;
	}
</style>

<!-- MODALS -->
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
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="info-resources">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal">&times;</button>
				<h4>Resources & Related</h4>
			</div>
			<div class="modal-body">
				Each resource or related item on a new line (press enter, wordwrap does not count)<br>
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

<div class="modal fade" id="info-terms">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal">&times;</button>
				<h4>Terms & Conditions</h4>
			</div>
			<div class="modal-body">
				Offer valid [START DATE] to [END DATE] to customers in [COUNTRY] only. Discount is off list price only, no further discounts apply. All pricing excludes GST
				<br>			
			</div>
		</div>
	</div>
</div>
<!-- MODALS END //-->

<div class="row">
	<div class="col-xs-12">
		<h1>Level 3 Page Add/Edit</h1>
		<br>
		<div id="notifications">		
			<?php flash(); 	?>	
		</div>
		
	</div>
</div>
	


<div class="row">
	<div class="col-md-4">
		<a href="http://www.thermofisher.com.au/show.aspx?page=/ContentAUS/StyleGuide/page-layouts.html#sub-category" class="btn btn-default" target="_blank">Example</a><br>
		<br>
	</div>
</div>
<form method="post" method="l3page_e.php" role="form" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php if(isset($p['id'])) {echo $p['id'];} ?>">
	<div class="row">
		<div class="col-xs-sm">
			<table class="table">
			<tr>
				<td width="250" align="right"><strong>Country</strong></td>
				<td>
					<select name="country" id="" class="form-control" required autocomplete="foo">
						<option></option>
						<option value="Australia" <?php if(isset($p['country']) && $p['country'] == "Australia") {echo " selected"; } ?> >Australia</option>
						<option value="New Zealand" <?php if(isset($p['country']) && $p['country'] == "New Zealand") {echo " selected"; } ?>>New Zealand</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td width="250" align="right"><strong>Page Name</strong></td>
				<td><input name="name" type="text" value="<?php if(isset($p['name'])) { echo $p['name']; } ?>" class="form-control"></td>
			</tr>
			
			<tr>
				<td colspan="2">
					<div class="section-heading">
						<h4>hdi</h4>
					</div>
				</td>
			</tr>
			
			<tr>
				<td width="250" align="right"><strong>Page Heading</strong></td>
				<td><input name="page-heading" type="text" value="<?php if(isset($p['page-heading'])) { echo htmlentities($p['page-heading']); } ?>" class="form-control"></td>
			</tr>

			<tr>
				<td width="250" align="right"><strong>Main Image</strong></td>
				<td>
					<div class="form-group row">
						<div class="col-xs-6">
							<input name="main-image" type="text" value="<?php if(isset($p['main-image']))  { echo $p['main-image']; } ?>" class="form-control">
					
						</div>
						<div class="col-xs-6">
							<input name="main-image" type="file" value="" class="form-control">
						</div>
					</div>
						
				</td>
			</tr>
			
			<tr>
				<td align="right">
					<strong>Main Description</strong><br>
					<br>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#info-description"><i class="fa fa-info"></i></button>
				</td>
				<td>
					<textarea name="description" class="form-control" rows="7"><?php if(isset($p['description'])) {echo htmlentities($p['description']);} ?></textarea>
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<div class="section-heading">
						<h4>featured-gateway</h4>
					</div>
				</td>
			</tr>

			<tr>
				<td width="250" align="right"><strong>Popular Products</strong></td>
				<td>
					<div class="row">
						<div class="col-xs-2">Heading</div>
						<div class="col-xs-10"><input name="popular-heading" type="text" class="form-control" placeholder="Popular XXXXXX products" value="<?php if(isset($p['popular-heading'])) { echo htmlentities($p['popular-heading']); } ?>"></div>
					</div>
					
					<div class="row">
						<div class="col-xs-12"><hr></div>
					</div>
		<?php	for($i = 1; $i <= 3; $i++){ ?>		
					<div class="row">
						<div class="col-xs-2">P<?=$i?> Name</div>
						<div class="col-xs-10"><input type="text" class="form-control" name="popular-<?=$i?>[text]" value="<?php if(isset($p['popular-' . $i]['text'])) { echo htmlentities($p['popular-' . $i]['text']); } ?>"></div>
					</div>
					<div class="row" id="p<?=$i?>-img-row" style="display: none;">
						<div class="col-xs-2">P<?=$i?> Image</div>
						<div class="col-xs-5"><input type="text" class="form-control" name="popular-<?=$i?>[image]" value="<?php if(isset($p['popular-' . $i]['image'])) { echo htmlentities($p['popular-' . $i]['image']); } ?>"></div>
						<div class="col-xs-5"><input type="file" class="form-control" name="popular-<?=$i?>[image]"></div>
					</div>
					<div class="row" id="p<?=$i?>-url-row" style="display: none;">
						<div class="col-xs-2">P<?=$i?> URL</div>
						<div class="col-xs-8"><input type="text" class="form-control" name="popular-<?=$i?>[url]" placeholder="http://" value="<?php if(isset($p['popular-' . $i]['url'])) { echo htmlentities($p['popular-' . $i]['url']); } ?>"></div>
						<div class="col-xs-2">
							<select name="popular-<?=$i?>[tab]" id="" class="form-control">
								<option value="parent" <?php if(isset($p['popular-' . $i]['tab']) && $p['popular-' .$i]['tab'] == "parent") { echo 
									"selected"; } ?>>Parent</parent>
								<option value="new" <?php if(isset($p['popular-' . $i]['tab']) && $p['popular-' . $i]['tab'] == "new") { echo 
									"selected"; } ?>>New</parent>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-2"></div>
						<div class="col-xs-10"><button class="btn btn-xs btn-primary" id="p<?=$i?>-toggle" type="button">Show/Hide</button></div>
					</div>
		<?php 	} ?>			
					
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="section-heading">
						<h4>category-lists</h4>
					</div>
				</td>
			</tr>
			<tr>
				<td align="right">
					<strong>Featured Products</strong><br>
					<br>
					<button class="btn btn-primary" data-toggle="modal" data-target="#info-items" type="button"><i class="fa fa-info"></i></button>
				</td>
				<td>
					<div id="features">
						
						
							<div class="row">
								<div class="col-xs-2">Heading</div>
								<div class="col-xs-10"><input name="featured-heading" type="text" class="form-control"  placeholder="Featured XXXXXX products" value="<?php if(isset($p['featured-heading'])) { echo htmlentities($p['featured-heading']); } ?>"></div>
							</div>
							<span id="fCount" data-count="<?php echo $x + 1; ?>" style="display: none;"></span>
							

				<?php 		for($y = 1; $y <= $x; $y++){ ?>

						<div class="featured-category">
							<div class="row">
								<div class="col-xs-12"><hr></div>
							</div>

							
							<div class="row">
								<div class="col-xs-2">F<?php echo $y; ?> Heading</div>
								<div class="col-xs-10">
									<input type="hidden" name="featured[<?php echo $y - 1; ?>][id]" value="<?php if(isset($p['featured'][$y - 1]['id'])) { echo $p['featured'][$y - 1]['id']; } ?>" class="feature-id">
									<input type="text" name="featured[<?php echo $y - 1; ?>][order]" value="<?php if(isset($p['featured'][$y - 1]['order'])) { echo $p['featured'][$y - 1]['order']; } else { echo $y; }?>" class="feature-order">
									<input type="text" class="form-control" name="featured[<?php echo $y - 1; ?>][heading]" value="<?php if(isset($p['featured'][$y - 1]['heading'])) { echo htmlentities($p['featured'][$y - 1]['heading']); } ?>"></div>
							</div>
							<div class="row">
								<div class="col-xs-2">F<?php echo $y; ?> URL</div>
								<div class="col-xs-8"><input type="text" class="form-control" name="featured[<?php echo $y - 1; ?>][url]" value="<?php if(isset($p['featured'][$y - 1]['url'])) { echo $p['featured'][$y - 1]['url']; } ?>">
								</div>
								<div class="col-xs-2">
									<select id="" class="form-control" name="featured[<?php echo $y - 1; ?>][tab]">
										<option value="parent" <?php if(isset($p['featured'][$y - 1]['tab']) && $p['featured'][$y - 1]['tab'] == "parent") { echo 
										"selected"; } ?>>Parent</parent>
									<option value="new" <?php if(isset($p['featured'][$y - 1]['tab']) && $p['featured'][$y - 1]['tab'] == "new") { echo 
										"selected"; } ?>>New</parent>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-2">F<?php echo $y; ?> Image</div>
								<div class="col-xs-5"><input type="text" class="form-control" name="featured[<?php echo $y - 1; ?>][image]" value="<?php if(isset($p['featured'][$y - 1]['image'])) { echo $p['featured'][$y - 1]['image']; } ?>"></div>
								<div class="col-xs-5"><input type="file" class="form-control" name="featured[<?php echo $y - 1; ?>][image]"></div>
							</div>
							<div class="row">
								<div class="col-xs-2">F<?php echo $y; ?> Description</div>
								<div class="col-xs-10"><textarea name="featured[<?php echo $y - 1; ?>][description]" id="" rows="5" class="form-control"><?php if(isset($p['featured'][$y - 1]['description'])) { echo htmlentities($p['featured'][$y - 1]['description']); } ?></textarea></div>
							</div>
							<div class="row">
								<div class="col-xs-2"></div>
								<div class="col-xs-10">
									<div class="alert alert-warning">
										<button type="button" class="btn btn-default btn-sm feature-delete" title="Delete"><i class="fa fa-trash"></i></button>
										<button type="button" class="btn btn-default btn-sm feature-up <?php if($y == 1){ echo "disabled"; } ?>" title="Move up"><i class="fa fa-arrow-up"></i></button> 
										<button type="button" class="btn btn-default btn-sm feature-down <?php if($y == $x){ echo "disabled"; } ?>" title="Move down"><i class="fa fa-arrow-down"></i></button>
									</div>
									
								</div>
							</div>
							<br>
						</div>
		<?php			
					} ?>
					</div>
					<button type="button" class="btn btn-success" id="addFeature">+</button>
				</td>
			</tr>
	

			<tr>
				<td colspan="2">
					<div class="section-heading">
						<h4>videos</h4>
					</div>
				</td>
			</tr>

			<tr>
				<td align="right"><strong>Videos</strong></td>
				<td>
					<div class="row">
						<div class="col-xs-2">Heading</div>
							<div class="col-xs-10"><input name="videos[heading]" type="text" class="form-control"  placeholder="Featured XXXXXX videos" value="<?php if(isset($p['videos']['heading'])) { echo htmlentities($p['videos']['heading']); } ?>"></div>
						

					</div>
					<div class="row">
						<div class="col-xs-2">Video left</div>
							<div class="col-xs-10">
								<input name="videos[left]" type="text" class="form-control" placeholder="YouTube URL" value="<?php if(isset($p['videos']['left'])) { echo htmlentities($p['videos']['left']); } ?>">
							</div>
						
					</div>
					<div class="row">
						<div class="col-xs-2">Video right</div>
							<div class="col-xs-10">
								<input name="videos[right]" type="text" class="form-control" placeholder="YouTube URL" value="<?php if(isset($p['videos']['right'])) { echo htmlentities($p['videos']['right']); } ?>">
							
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="section-heading">
						<h4>embedded-promos</h4>
					</div>
				</td>
			</tr>
			<tr>
				<td align="right"><strong>Pods</strong></td>
				<td>
					<div class="row">
						<div class="col-xs-2">Left Name</div>
						<div class="col-xs-5"><input name="pod-left[name]" type="text" value="<?php if(isset($p['pod-left']['name']))  { echo $p['pod-left']['name']; } ?>" class="form-control"></div>
					</div>
					<div class="row">
						<div class="col-xs-2">Left Image</div>
						<div class="col-xs-10">
							<div class="row">
								<div class="col-xs-6">
									<input name="pod-left[image]" type="text" value="<?php if(isset($p['pod-left']['image']))  { echo $p['pod-left']['image']; } ?>" class="form-control">
								</div>
								<div class="col-xs-6">
									<input name="pod-left[image]" type="file" value="" class="form-control">
								</div>
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-xs-2">Left URL</div>
						<div class="col-xs-8">
							<input name="pod-left[url]" type="text" class="form-control" value="<?php if(isset($p['pod-left']['url'])) { echo htmlentities($p['pod-left']['url']); } ?>" placeholder="http://">
						</div>
						<div class="col-xs-2">
							<select name="pod-left[tab]" id="" class="form-control">
								<option value="parent" <?php if(isset($p['pod-left']['tab']) && $p['pod-left']['tab'] == "parent") { echo 
									"selected"; } ?>>Parent</parent>
								<option value="new" <?php if(isset($p['pod-left']['tab']) && $p['pod-left']['tab'] == "new") { echo 
									"selected"; } ?>>New</parent>
							</select>
						</div>						
					</div>
					
					<hr>
					<div class="row">
						<div class="col-xs-2">Right Name</div>
						<div class="col-xs-5"><input name="pod-right[name]" type="text" value="<?php if(isset($p['pod-right']['name']))  { echo $p['pod-right']['name']; } ?>" class="form-control"></div>
					</div>
					<div class="row">
						<div class="col-xs-2">Right Image</div>
						<div class="col-xs-10">
							<div class="row">
								<div class="col-xs-6">
									<input name="pod-right[image]" type="text"  value="<?php if(isset($p['pod-right']['image']))  { echo $p['pod-right']['image']; } ?>" class="form-control">
								</div>
								<div class="col-xs-6">
									<input name="pod-right[image]" type="file" value="" class="form-control">
								</div>
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-xs-2">Right URL</div>
						<div class="col-xs-8">
							<input name="pod-right[url]" type="text" class="form-control" value="<?php if(isset($p['pod-right']['url'])) { echo htmlentities($p['pod-right']['url']); } ?>" placeholder="http://">
						</div>
						<div class="col-xs-2">
							<select name="pod-right[tab]" id="" class="form-control">
								<option value="parent" <?php if(isset($p['pod-right']['tab']) && $p['pod-right']['tab'] == "parent") { echo 
									"selected"; } ?>>Parent</parent>
								<option value="new" <?php if(isset($p['pod-right']['tab']) && $p['pod-right']['tab'] == "new") { echo 
									"selected"; } ?>>New</parent>
							</select>
						</div>						
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="section-heading">
						<h4>Resources</h4>
					</div>
				</td>
			</tr>
			<tr>
				<td align="right">
					<strong>Resources/Support/Related</strong><br>
					<br>
					<button class="btn btn-primary" data-toggle="modal" data-target="#info-resources" type="button"><i class="fa fa-info"></i></button>
				</td>
				<td>
					<div class="row">
						<div class="col-xs-2" >
							Left - Heading
						</div>
						<div class="col-xs-10">
							<input type="text" class="form-control" name="resources-left[heading]" placeholder="Resources" value="<?php if(isset($p['resources-left']['heading'])) { echo htmlentities($p['resources-left']['heading']); } ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-2">
							Left - Items
						</div>
						<div class="col-xs-10">
							<textarea  name="resources-left[items]" class="form-control" rows="5"><?php if(isset($p['resources-left']['items'])) {echo htmlentities($p['resources-left']['items']);} ?></textarea>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-2">
							Right - Heading
						</div>
						<div class="col-xs-10">
							<input type="text" class="form-control"  name="resources-right[heading]" placeholder="Support" value="<?php if(isset($p['resources-right']['heading'])) { echo htmlentities($p['resources-right']['heading']); } ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-2">
							Right - Items
						</div>
						<div class="col-xs-10">
							<textarea  name="resources-right[items]" class="form-control" rows="5"><?php if(isset($p['resources-right']['items'])) {echo htmlentities($p['resources-right']['items']);} ?></textarea>
						</div>
					</div>
					
				</td>
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