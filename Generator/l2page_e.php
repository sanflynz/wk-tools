<?php	

include("includes/db.php");
include("includes/sitefunctions.php");

$error = FALSE;

if($_POST && !isset($_POST['import'])){

	$p = $_POST['page'];
	$sections = $_POST['section'];

	$data = array();

	// Page
	$data['page'] = $_POST['page'];

	// print '<pre>'; 
	// print_r($_POST);
	// print '</pre>';

	// sections
	$i = 0;
	foreach($sections as $s){
		

		// dirty way of reordering the indexes after reordering??
		if($s['type'] == 'category-lists'){
			// need to reorder the index?
			
			$content = $s['content']['items'];
			unset($s['content']['items']);

			$x = 1;
			foreach($content as $c){

				//$c['copy'] = mysqli_real_escape_string($conn,$c['copy']);
				//echo $c['copy'];
				$s['content']['items'][$x]['heading'] = $c['heading'];
				$s['content']['items'][$x]['copy'] = str_replace("'","&apos;",$c['copy']);
				$s['content']['items'][$x]['url'] = $c['url'];
				$s['content']['items'][$x]['tab'] = $c['tab'];
				//$s['content']['items'][$x]['copy'] = mysqli_real_escape_string($conn,$s['content']['items'][$x]['copy']);
				$x++;
			}
			// foreach($s['content']['items'] as $y){
			// 	$y['copy'] = mysqli_real_escape_string($conn,$y['copy']);
			// }
			//$s['content']['items'] = $content;
			// print '<pre>'; 
			// print_r($s);
			// print '</pre>';
		}

		if($s['type'] == "hdi"){
			$s['content']['copy'] = mysqli_real_escape_string($conn,$s['content']['copy']);
		}

		$data['section'][$i]['id'] = $s['id'];
		$data['section'][$i]['type'] = $s['type'];
		if(!empty($s['settings'])){ $data['section'][$i]['settings'] = serialize($s['settings']); } else {
			$data['section'][$i]['settings'] = "";
		}
		$data['section'][$i]['content'] = serialize($s['content']);
		$data['section'][$i]['s_order'] = $s['s_order'];
		$i++;


		
		
	}
	
	// print '<pre>'; 
	// print_r($data);
	// print '</pre>';
	// exit();
	
	//echo"<br><hr>";
	// page
	if(empty($data['page']['id'])){
		// insert
		$sql = "INSERT INTO `pages` (`name`,`country`,`type`) VALUES ('" . $data['page']['name'] ."','" . $data['page']['country'] ."','" . $data['page']['type'] ."')";
		$r = $conn->query($sql);
		if($conn->error){
			$error = TRUE;
			setFlash("danger", "Unable to add " . $data['page']['type'] ." page: " . $conn->error);
		}
		else{
			$p['id'] = mysqli_insert_id($conn);
		}
	}
	else{
		// update
		$sql = "UPDATE `pages` SET `name`='" . $data['page']['name'] ."',`country`='" . $data['page']['country'] ."',`type`='" . $data['page']['type'] ."' WHERE `id`='" . $data['page']['id'] ."'";
		$r = $conn->query($sql);
		if($conn->error){
			$error = TRUE;
			setFlash("danger", "Unable to update " . $data['page']['type'] ." page: " . $conn->error);
		}
		
	}
	if(!$error){
		// sections
		foreach($data['section'] as $sct){
			if(empty($sct['id'])){
				// insert
				$sql = "INSERT INTO `sections` (`page_id`,`type`,`settings`,`content`,`s_order`) VALUES ('" . $p['id'] . "','" . $sct['type'] . "','" . $sct['settings'] . "','" . $sct['content'] . "','" . $sct['s_order'] . "')";
				$r = $conn->query($sql);
				if($conn->error){
					$error = TRUE;
					setFlash("danger", "Unable to add " . $sct['type'] ." section: " . $conn->error);
				}
				else{
					$section[$sct['id']] = mysqli_insert_id($conn);
				}
			}
			else{
				// update
				$sql = "UPDATE `sections` SET `settings`='" . $sct['settings'] . "',`content`='" . $sct['content'] . "',`s_order`='" . $sct['s_order'] . "' WHERE `id` ='" . $sct['id'] . "'";
				$r = $conn->query($sql);
				if($conn->error){
					$error = TRUE;
					setFlash("danger", "Unable to update " . $sct['type'] ." section: " . $conn->error);
				}

				//setFlash("info", $sql);
				
			}
		}
		if(!$error){
			// redirect
			header("location: l2page_au_v.php?id=" . $p['id']);
				
		}

	}

	
} // END POST
else {
	

	if(!empty($_GET['id'])){
		// get stuff
		$sql = "SELECT * FROM `pages` WHERE `id`='" . $_GET['id'] . "'";
		$r = $conn->query($sql);
		$p = $r->fetch_assoc();

		$sql = "SELECT * FROM `sections` WHERE `page_id` = '" . $_GET['id'] . "' ORDER BY `s_order`" ;
		$r = $conn->query($sql);
		$sections = array();
		$i = 0;
	 	while($row = $r->fetch_assoc()){
	 		$sections[$i]['id'] = $row['id'];
	 		$sections[$i]['type'] = $row['type'];
	 		$sections[$i]['settings'] = unserialize($row['settings']);
	 		$sections[$i]['content'] = unserialize($row['content']);
	 		$sections[$i]['s_order'] = $row['s_order'];	 		
	 		$i++;
	 	}
	}


	if(!empty($_POST['import'])){  // import stuff
		$import = $_POST;
		$settings = array();
		if($import['import-type'] == "old-storefront"){
			include("includes/import-old-storefront.php");
			$p['type'] = "storefront";

			$cat_rows = array();
			$row = 3;
			for($i = 1; $i <= $import['cat-list-rows']; $i++){
				$cat_rows[] = $row;
				$row += 2;
			}
			$settings = array(
				"mondrian-a" => 1,
				"hdi" => 2,
				"category-lists" => $cat_rows,
				"embedded-promos" => end($cat_rows) + 2,
			);
			
		}
		elseif($import['import-stype'] == "old-category"){
			include("includes/l2-import-old.php");
			$p['type'] = "category";
		}
		
		$data = import_page($import['url'], $settings);
		$sections = $data['sections'];
		//$p = $data['page'];

		setFlash("info", "Page imported from:<br><a href='" . $import['url'] . "' target='_blank'>" . $import['url'] . "</a>");

		// print '<pre>'; 
		// print_r($data);
		// print '</pre>';
	}

	if(empty($_GET['id']) && empty($_POST['import'])){
		
	//if((empty($_GET['id']) && empty($_POST['import']) || count($sections) == 0)){
		if(!empty($_GET['type']) && $_GET['type'] == "storefront"){
			$sections = array(
				0 => array('type' => 'mondrian-a'),
				1 => array('type' => 'hdi', 'settings' => array('type' => 'storefront-default')),
				2 => array('type' => 'category-lists', 'settings' => array('columns' => 4)),
				3 => array('type' => 'embedded-promos', 'settings' => array('width' => 'wide'))
			);
			$p['type'] = $_GET['type'];

		}
		elseif(!empty($_GET['type']) && $_GET['type'] == "category"){
			$sections = array(
				0 => array('type' => 'mondrian-f'),
				1 => array('type' => 'hdi', 'settings' => array('type' => 'category-default')),
				2 => array('type' => 'featured-gateway'), 
				3 => array('type' => 'category-lists', 'settings' => array('columns' => 2)),
				4 => array('type' => 'embedded-promos', 'settings' => array('width' => 'normal')),
				5 => array('type' => 'resources')
			);
			$p['type'] = $_GET['type'];
		}
		else{
			setFlash("danger", "You must select a page type");
			$sections = array();
		}
		
		//setFlash("success", 'were doing stuff!!');
	}
}

// print '<pre>'; 
// //print_r($p);
// print_r($sections);
// print '</pre>';


include("includes/header.php");

	// print '<pre>'; 
	// print_r($data);
	// print '</pre>';

?>
<style>
	.table tr td {
		border-top: 0px !important;
	}
</style>
<div class="row">
	<div class="col-xs-12">
		<h1>Level 1/2 page add/edit</h1>
		<br>
		<div id="notifications">		
			<?php flash(); 	?>	
		</div>
	</div>
</div>
<form method="post" accept-charset="utf-8" role="form" enctype="multipart/form-data">
	<input type="hidden" name="page[id]" value="<?php if(!empty($p['id'])){ echo $p['id']; } ?>">
	<input type="hidden" name="page[type]" value="<?php if(!empty($p['type'])){ echo $p['type']; } ?>">


<div class="row">
	<div class="col-md-8">
		<table class="table table-edit-components" >
			<tr>
				<td >Country</td>
				<td>
					<select name="page[country]" id="" class="form-control" required autocomplete="foo">
						<option></option>
						<option value="Australia" <?php if(!empty($p['country']) == "Australia") {echo " selected"; } ?> >Australia</option>
						<option value="New Zealand" <?php if(!empty($p['country']) == "New Zealand") {echo " selected"; } ?>>New Zealand</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td >Page Name</td>
				<td><input name="page[name]" type="text" value="<?php if(isset($p['name'])) { echo $p['name']; } ?>" class="form-control"></td>
			</tr>
			<tr>
				<td >Page Type</td>
				<td><?php if(!empty($p['type'])) { echo $p['type']; } ?></td>
			</tr>
		</table>
	</div>
	<div class="col-md-4">
		other stuff
	</div>
</div>
<br>

<?php
	$i = 0;
	foreach($sections as $s){ ?>
		<div class="section">
			<div class="section-heading">
				<h4><?=$s['type']; ?> </h4>
			</div>
			<input type="hidden" name="section[<?=$i; ?>][id]" class="section-id" value="<?php if(!empty($s['id'])){ echo $s['id']; } ?>">
			<input type="hidden" name="section[<?=$i; ?>][s_order]" class="section-order" value="<?php echo !empty($s['s_order']) ? $s['s_order'] : $i; ?>">
			<input type="hidden" name="section[<?=$i; ?>][type]" value="<?=$s['type']; ?>">
				

<?php		if($s['type'] == "mondrian-a"){ ?>
			
				<table class="table table-edit-components">
			<?php 	$panels = array('feature','centre','landscape');
					foreach($panels as $panel){ ?>
						<tr>
							<td><?=ucfirst($panel); ?> panel</td>
							<td>
								<div class="row">
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon"><?=$panel;?> Image</span>
											<input type="text" name="section[<?=$i; ?>][content][<?=$panel;?>][image]" class="form-control" value="<?php if(!empty($s['content'][$panel]['image'])){ echo $s['content'][$panel]['image']; } ?>">
										</div>
										
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon"><?=$panel;?> name</span>
											<input type="text" name="section[<?=$i; ?>][content][<?=$panel;?>][name]" class="form-control" value="<?php if(!empty($s['content'][$panel]['name'])){ echo $s['content'][$panel]['name']; } ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">URL</span>
												<input type="text" name="section[<?=$i; ?>][content][<?=$panel;?>][url]" class="form-control" value="<?php if(!empty($s['content'][$panel]['url'])){ echo $s['content'][$panel]['url']; } ?>">
										</div>									
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">Tab</span>
												<select name="section[<?=$i; ?>][content][<?$panel;?>][tab]" id="" class="form-control">
													<option value="parent" <?php if(!empty($s['content'][$panel]['tab']) && $s['content'][$panel]['tab'] == "parent" ) { echo " selected"; } ?>>Parent</option>
													<option value="new"<?php if(!empty($s['content'][$panel]['tab']) && $s['content'][$panel]['tab'] == "new" ) { echo " selected"; } ?>>New</option>
										</select>
										</div>									
									</div>
								</div>
							</td>
						</tr>
						
			<?php	} ?>	
						<tr>
							<td>Navigation</td>
							<td>
						<?php 	for($n = 1; $n <= 5; $n++){ ?>		
								<div class="row">
									<div class="col-md-5">
										<div class="input-group">
											<span class="input-group-addon">Link <?=$n; ?> text</span>
											<input type="text" name="section[<?=$i; ?>][content][navigation][<?php echo $n; ?>][text]" class="form-control" value="<?php if(!empty($s['content']['navigation'][$n]['text'])){ echo htmlentities($s['content']['navigation'][$n]['text']); } ?>">
										</div>
										
									</div>
									<div class="col-md-4">
										<div class="input-group">
											<span class="input-group-addon">Link <?=$n; ?> URL</span>
												<input type="text" name="section[<?=$i; ?>][content][navigation][<?php echo $n; ?>][url]" class="form-control" value="<?php if(!empty($s['content']['navigation'][$n]['url'])){ echo $s['content']['navigation'][$n]['url']; } ?>">
										</div>									
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<span class="input-group-addon">Tab <?=$n; ?></span>
												<select name="section[<?php echo $i; ?>][content][navigation][<?=$n; ?>][tab]" id="" class="form-control">
													<option value="parent" <?php if(isset($s['content']['navigation'][$n]['tab']) && $s['content']['navigation'][$n]['tab'] == "parent" ) { echo " selected"; } ?>>Parent</option>
													<option value="new"<?php if(isset($s['content']['navigation'][$n]['tab']) && $s['content']['navigation'][$n]['tab'] == "new" ) { echo " selected"; } ?>>New</option>
										</select>
										</div>									
									</div>
								</div>
						<?php 	} ?>		
							</td>
						</tr>
						
					</table>		 		
<?php			$i++;
			}  // end mondrian-a
			
			if($s['type'] == "mondrian-f"){ ?>
			
				<table class="table table-edit-components">
						<tr>
							<td>Main image</td>
							<td>
								<div class="row">
									<div class="col-md-6">
										<input type="text" name="section[<?php echo $i; ?>][content][main-image]" id="" class="form-control" value="<?php if(isset($s['content']['main-image'])){ echo $s['content']['main-image']; } ?>">
									</div>
									<div class="col-md-6">
										<input type="file" name="section[<?php echo $i; ?>][content][main-image]" class="form-control" value="">
									</div>
								</div>
								
							</td>
						</tr>
						<tr>
							<td>Navigation</td>
							<td>
						<?php 	for($n = 1; $n <= 5; $n++){ ?>		
								<div class="row">
									<div class="col-md-5">
										<div class="input-group">
											<span class="input-group-addon">Link <?php echo $n; ?> text</span>
											<input type="text" name="section[<?php echo $i; ?>][content][navigation][<?php echo $n; ?>][text]" class="form-control" value="<?php if(isset($s['content']['navigation'][$n]['text'])){ echo htmlentities($s['content']['navigation'][$n]['text']); } ?>">
										</div>
										
									</div>
									<div class="col-md-4">
										<div class="input-group">
											<span class="input-group-addon">Link <?php echo $n; ?> URL</span>
												<input type="text" name="section[<?php echo $i; ?>][content][navigation][<?php echo $n; ?>][url]" class="form-control" value="<?php if(isset($s['content']['navigation'][$n]['url'])){ echo $s['content']['navigation'][$n]['url']; } ?>">
										</div>									
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<span class="input-group-addon">Tab <?php echo $n; ?></span>
												<select name="section[<?php echo $i; ?>][content][navigation][<?php echo $n; ?>][tab]" id="" class="form-control">
													<option value="parent" <?php if(isset($s['content']['navigation'][$n]['tab']) && $s['content']['navigation'][$n]['tab'] == "parent" ) { echo " selected"; } ?>>Parent</option>
													<option value="new"<?php if(isset($s['content']['navigation'][$n]['tab']) && $s['content']['navigation'][$n]['tab'] == "new" ) { echo " selected"; } ?>>New</option>
										</select>
										</div>									
									</div>
								</div>
						<?php 	} ?>		
							</td>
						</tr>
						
					</table>		 		
<?php			$i++;
			}  // end mondrian-f

			if($s['type'] == "hdi"){ ?>
					<input type="hidden" name="section[<?=$i; ?>][settings][type]" value="<?php if(!empty($s['settings']['type'])) { echo $s['settings']['type']; } ?>">
					<table class="table table-edit-components">
						<tr>
							<td>Heading</td>
							<td><input type="text" name="section[<?php echo $i; ?>][content][heading]" class="form-control" value="<?php if(isset($s['content']['heading'])){ echo $s['content']['heading']; } ?>"></td>
						</tr>
						<tr>
							<td>Copy</td>
							<td>
								<textarea name="section[<?php echo $i; ?>][content][copy]" rows="5" class="form-control"><?php if(isset($s['content']['copy'])){ echo htmlentities($s['content']['copy']); } ?></textarea>
							</td>
						</tr>
					</table>

	<?php		$i++;
			} // end hdi

			if($s['type'] == "featured-gateway"){ ?>
				<table class="table table-edit-components">
					<tr>
						<td>Heading</td>
						<td><input type="text" name="section[<?=$i;?>][content][heading]" class="form-control" value="<?php if(!empty($s['content']['heading'])){ echo $s['content']['heading']; } ?>"></td>
					</tr>
			<?php 	for($x = 0; $x <= 2; $x++){ ?>		
					<tr>
						<td>Popular <?=$x + 1;?></td>
						<td>
							<div class="row">
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon">Text <?=$x + 1;?></span>
										<input type="text" name="section[<?=$i;?>][content][items][<?=$x;?>][text]" class="form-control" value="<?php if(!empty($s['content']['items'][$x]['text'])){ echo htmlentities($s['content']['items'][$x]['text']); } ?>">
									</div>
								</div>
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon">URL <?=$x + 1;?></span>
										<input type="text" name="section[<?=$i;?>][content][items][<?=$x;?>][url]" class="form-control" value="<?php if(!empty($s['content']['items'][$x]['url'])){ echo $s['content']['items'][$x]['url']; } ?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon">Image <?=$x + 1;?></span>
										<input type="text" name="section[<?=$i;?>][content][items][<?=$x;?>][image]" class="form-control" value="<?php if(!empty($s['content']['items'][$x]['image'])){ echo $s['content']['items'][$x]['image']; } ?>">
									</div>
								</div>
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon">Tab <?=$x + 1;?></span>
										<select name="section[<?=$i;?>][content][items][<?=$x;?>][tab]" id="" class="form-control">
											<option value="parent" <?php if(isset($s['content']['items'][$x]['tab']) && $s['content']['items'][$x]['tab'] == "parent" ) { echo " selected"; } ?>>Parent</option>
											<option value="new"<?php if(isset($s['content']['items'][$x]['tab']) && $s['content']['items'][$x]['tab'] == "new" ) { echo " selected"; } ?>>New</option>
										</select>
									</div>
								</div>
							</div>
							
						</td>
					</tr>
				
		<?php		} ?>
				</table>
	<?php		$i++;
			}

			if($s['type'] == "category-lists"){ ?>
				<input type="hidden" name="section[<?=$i; ?>][settings][columns]" value="<?php if(!empty($s['settings']['columns'])) { echo $s['settings']['columns']; } ?>">
					<table class="table table-edit-components">
					<tr>
						<td>Heading</td>
						<td><input type="text" name="section[<?=$i;?>][content][heading]" class="form-control" value="<?php if(!empty($s['content']['heading'])){ echo $s['content']['heading']; } ?>"></td>
					</tr>
			<?php 	$count = (!empty($s['content']['items'])) ? count($s['content']['items']) : $s['settings']['columns'];
					for($x = 1; $x <= $count; $x++){	?>	
					<tr>
						<td>
							Item <?php echo $x; ?><br>
							<button type="button" class="btn btn-default btn-sm feature-up <?php if($x == 1){ echo "disabled"; } ?>" title="Move up"><i class="fa fa-arrow-up"></i></button> 
							<button type="button" class="btn btn-default btn-sm feature-down <?php if($x == $count){ echo "disabled"; } ?>" title="Move down"><i class="fa fa-arrow-down"></i></button> 
							<button type="button" class="btn btn-default btn-sm feature-delete" title="Delete"><i class="fa fa-trash"></i></button>
							
						</td>
						<td>	
							<div class="row" >
								<div class="col-md-6">
									
									<div class="input-group" style="margin-bottom: 5px; !important;">
										<span class="input-group-addon">Heading</span>
										<input type="text" name="section[<?=$i; ?>][content][items][<?=$x; ?>][heading]" class="form-control" value="<?php if(isset($s['content']['items'][$x]['heading'])) { echo htmlentities($s['content']['items'][$x]['heading']); } ?>">
									</div>
									
									<div class="input-group" style="margin-bottom: 5px; !important;">
										<span class="input-group-addon">URL</span>
										<input type="text" name="section[<?=$i; ?>][content][items][<?=$x; ?>][url]" class="form-control" value="<?php if(isset($s['content']['items'][$x]['url'])) { echo $s['content']['items'][$x]['url']; } ?>">
									</div>
									<div class="input-group" style="margin-bottom: 5px; !important;">
										<span class="input-group-addon">tab</span>
										<select name="section[<?=$i; ?>][content][items][<?=$x; ?>][tab]" id="" class="form-control">
											<option value="parent" <?php if(isset($s['content']['items'][$x]['tab']) && $s['content']['items'][$x]['tab'] == "parent" ) { echo " selected"; } ?>>Parent</option>
											<option value="new"<?php if(isset($s['content']['items'][$x]['tab']) && $s['content']['items'][$x]['tab'] == "new" ) { echo " selected"; } ?>>New</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<textarea name="section[<?=$i; ?>][content][items][<?=$x; ?>][copy]" id="" rows="5" class="form-control" placeholder="Copy..."><?php if(isset($s['content']['items'][$x]['copy'])) { echo htmlentities($s['content']['items'][$x]['copy']); } ?></textarea>
								</div>
							</div>					
						</td>
					</tr>
				<?php
					} ?>
					
							
				</table>
				<table class="table table-edit-components">
					<tr>
						<td></td>
						<td>
							<button id="add-category-list" type="button" class="btn btn-success btn-xs" style="margin-left: 15px;"><i class="fa fa-plus"></i></button>
						</td>
					</tr>
				</table>
				
				
	<?php		$i++;
			} // end category-lists

			if($s['type'] =="embedded-promos"){ ?>
				<input type="hidden" name="section[<?=$i; ?>][settings][width]" value="<?php if(!empty($s['settings']['width'])) { echo $s['settings']['width']; } ?>"><table class="table table-edit-components">
					<tr>
						<td><?php  ?></td>
						<td>
							<table style="width: 100%">
								<tr>
									
								
			<?php 	for($x = 1; $x <= 2; $x++){
						$side = ($x == 1) ? "Left" : "Right";  ?>
					
						<td style="width: 50%; padding-right: 10px; font-weight: normal;">
							<div class="input-group">
								<span class="input-group-addon"><?php echo $side; ?> Name</span>
								<input name="section[<?=$i; ?>][content][<?=$x; ?>][name]" type="text" class="form-control" value="<?php if(isset($s['content'][$x]['name'])) { echo $s['content'][$x]['name']; } ?>">
							</div>
							<div class="input-group">
								<span class="input-group-addon"><?php echo $side; ?> URL</span>
								<input name="section[<?=$i; ?>][content][<?=$x; ?>][url]" type="text" class="form-control" value="<?php if(isset($s['content'][$x]['url'])) { echo $s['content'][$x]['url']; } ?>">
							</div>
							<div class="input-group">
								<span class="input-group-addon"><?php echo $side; ?> image</span>
								<input  name="section[<?php echo $i; ?>][content][<?php echo $x; ?>][image]" type="text" class="form-control" value="<?php if(isset($s['content'][$x]['image'])) { echo $s['content'][$x]['image']; } ?>">
							</div>
							<div class="input-group" style="margin-bottom: 5px; !important;">
								<span class="input-group-addon">tab</span>
								<select name="section[<?php echo $i; ?>][content][<?php echo $x; ?>][tab]" id="" class="form-control">
									<option value="parent" <?php if(isset($s['content'][$x]['tab']) && $s['content'][$x]['tab'] == "parent" ) { echo " selected"; } ?>>Parent</option>
									<option value="new"<?php if(isset($s['content'][$x]['tab']) && $s['content'][$x]['tab'] == "new" ) { echo " selected"; } ?>>New</option>
								</select>
							</div>
						</td>
					
	<?php	}		?>
					</tr>
							</table>
						</td>

				</table>
				
<?php			$i++;
			} // end embedded-promos

			if($s['type'] == "resources"){ ?>
				<table class="table table-edit-components">
					
				<?php 	for($x = 0; $x <= 1; $x++){ ?>		
					<tr>
						<td>Resources <?=$x + 1; ?></td>
						<td>
							<div class="input-group">
								<span class="input-group-addon">Heading</span>
								<input type="text" name="section[<?=$i; ?>][content][<?=$x; ?>][heading]" class="form-control" value="<?php if(!empty($s['content'][$x]['heading'])){ echo $s['content'][$x]['heading']; } ?>" placeholder="<?php echo ($x == 0) ? "eg: Resources" : "eg: Support" ?>" >
							</div><br>
							<div class="resource-links">
					<?php 	$lCount = !empty($s['content'][$x]['link']) ? count($s['content'][$x]['link'])  : 0;
							for($y = 0; $y <= $lCount - 1; $y++){ ?>
								<div class="resource-link-item">
									<input type="text" name="section[<?=$i; ?>][content][<?=$x; ?>][link][<?=$y;?>][icon]" value="<?php if(isset($s['content'][$x]['link'][$y]['icon'])) { echo $s['content'][$x]['link'][$y]['icon']; } ?>" size="10" placeholder="icon">
									<input type="text" name="section[<?=$i; ?>][content][<?=$x; ?>][link][<?=$y;?>][name]" value="<?php if(isset($s['content'][$x]['link'][$y]['name'])) { echo $s['content'][$x]['link'][$y]['name']; } ?>" size="10" placeholder="name" autocomplete="foo">
									<input type="text" name="section[<?=$i; ?>][content][<?=$x; ?>][link][<?=$y;?>][url]" value="<?php if(isset($s['content'][$x]['link'][$y]['url'])) { echo $s['content'][$x]['link'][$y]['url']; } ?>" size="10" placeholder="url">
									<input type="text" name="section[<?=$i; ?>][content][<?=$x; ?>][link][<?=$y;?>][tab]" value="<?php if(isset($s['content'][$x]['link'][$y]['tab'])) { echo $s['content'][$x]['link'][$y]['tab']; } ?>" size="10" placeholder="tab">
									<input type="text" name="section[<?=$i; ?>][content][<?=$x; ?>][link][<?=$y;?>][tracking][category]" value="<?php if(isset($s['content'][$x]['link'][$y]['tracking']['category'])) { echo $s['content'][$x]['link'][$y]['tracking']['category']; } ?>" size="10" placeholder="trk category">
									<input type="text" name="section[<?=$i; ?>][content][<?=$x; ?>][link][<?=$y;?>][tracking][action]" value="<?php if(isset($s['content'][$x]['link'][$y]['tracking']['action'])) { echo $s['content'][$x]['link'][$y]['tracking']['action']; } ?>" size="10" placeholder="trk caction">
									<input type="text" name="section[<?=$i; ?>][content][<?=$x; ?>][link][<?=$y;?>][tracking][label]" value="<?php if(isset($s['content'][$x]['link'][$y]['tracking']['label'])) { echo $s['content'][$x]['link'][$y]['tracking']['label']; } ?>" size="10" placeholder="trk label">
									<a href="<?=$s['content'][$x]['link'][$y]['url'];?>" <?php if($s['content'][$x]['link'][$y]['tab'] == "new"){ echo "_blank"; } ?> <?php if(!empty($s['content'][$x]['link'][$y]['tracking'])) { echo "onclick=\"tracking()\""; } ?>><?=$s['content'][$x]['link'][$y]['name'];?></a><br>
								</div>	
					<?php 	} ?>	
							</div>
							<button type="button" class="btn btn-success btn-xs add-resource-link"><i class="fa fa-plus"></i></button>
						</td>
					</tr>
				<?php 	} ?>		
					
				</table>
	<?php		$i++;
			}// end resources

			echo "</div>";
		} // end sections foreach
?>

<br>
<input type="submit" value="Submit" class="btn btn-success">

</form>
<br><br><br>
<?php
include("includes/footer.php");
?>