<?php	

include("includes/db.php");
include("includes/sitefunctions.php");

$error = FALSE;


if($_POST){
	
	$p = $_POST['page'];
	$sections = $_POST['section'];

	$data = array();

	// Page
	$data['page'] = $_POST['page'];

	// sections
	$i = 0;
	foreach($sections as $s){
		$data['section'][$i]['id'] = $s['id'];
		$data['section'][$i]['type'] = $s['type'];
		$data['section'][$i]['content'] = serialize($s['content']);
		$data['section'][$i]['s_order'] = $s['s_order'];
		$i++;
	}

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
				$sql = "INSERT INTO `sections` (`page_id`,`type`,`content`,`s_order`) VALUES ('" . $p['id'] . "','" . $sct['type'] . "','" . $sct['content'] . "','" . $sct['s_order'] . "')";
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
				$sql = "UPDATE `sections` SET `content`='" . $sct['content'] . "',`s_order`='" . $sct['s_order'] . "' WHERE `id` ='" . $sct['id'] . "'";
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

	
	

	// print '<pre>'; 
	// print_r($data);
	// //print_r($_POST);
	// print '</pre>';
	


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
	 		$sections[$i]['content'] = unserialize($row['content']);
	 		$sections[$i]['s_order'] = $row['s_order'];	 		
	 		$i++;
	 	}
	}

	if(!empty($_GET['import']) && $_GET['import'] == "old"){
		// import stuff
		$url = "http://www.thermofisher.com.au/show.aspx?page=/ContentAUS/Lab-Equipment/Small-Equipment/Small-Equipment.html";
		include("includes/l2-import-old.php");
		$data = import_old_page($url);
		$sections = $data['sections'];

		// print '<pre>'; 
		// print_r($data);
		// print '</pre>';
	}

	//if(!isset($p) || $p['id'] == ""){
	if((empty($_GET['id']) && empty($_GET['import']) || count($sections) == 0)){
		if(!empty($_GET['type']) && $_GET['type'] == "storefront"){
			$sections = array(
				0 => array('type' => 'mondrian-a'),
				1 => array('type' => 'intro-copy'),
				3 => array('type' => 'category-lists', 'settings' => array('columns' => 4)),
				4 => array('type' => 'embedded-promos', 'settings' => array('width' => 'wide'))
			);
		}
		elseif(!empty($_GET['type']) && $_GET['type'] == "category"){
			$sections = array(
				0 => array('type' => 'mondrian-f'),
				1 => array('type' => 'hdi'),
				2 => array('type' => 'featured-gateway'), 
				3 => array('type' => 'category-lists', 'settings' => array('columns' => 2)),
				4 => array('type' => 'embedded-promos', 'settings' => array('width' => 'normal')),
				5 => array('type' => 'resources')
			);
		}
		else{
			setFlash("error", "You must select a page type");
		}
		
		//setFlash("success", 'were doing stuff!!');
	}
}

// print '<pre>'; 
// //print_r($p);
// print_r($sections);
// print '</pre>';


include("includes/header.php");

?>
<style>
	.table tr td {
		border-top: 0px !important;
	}
</style>
<div class="row">
	<div class="col-xs-12">
		<h1>Level 2 page add/edit</h1>
		<br>
		<div id="notifications">		
			<?php flash(); 	?>	
		</div>
	</div>
</div>
<form method="post" accept-charset="utf-8" role="form" enctype="multipart/form-data">
	<input type="hidden" name="page[id]" value="<?php if(!empty($p['id'])){ echo $p['id']; } ?>">
	<input type="hidden" name="page[type]" value="Category">


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
				<h4><?php echo $s['type']; ?> </h4>
			</div>
			<input type="hidden" name="section[<?php echo $i; ?>][id]" class="section-id" value="<?php if(isset($s['id'])){ echo $s['id']; } ?>">
			<input type="text" name="section[<?php echo $i; ?>][s_order]" class="section-order" value="<?php echo isset($s['s_order']) ? $s['s_order'] : $i; ?>">
			<input type="hidden" name="section[<?php echo $i; ?>][type]" value="<?php echo $s['type']; ?>">
				
<?php		if($s['type'] == "mondrian-f"){ ?>
			
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
											<input type="text" name="section[<?php echo $i; ?>][content][navigation][<?php echo $n; ?>][text]" class="form-control" value="<?php if(isset($s['content']['navigation'][$n]['text'])){ echo $s['content']['navigation'][$n]['text']; } ?>">
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
					<input type="hidden" name="section[<?php echo $i; ?>][settings][variant]" value="category-default">
					<table class="table table-edit-components">
						<tr>
							<td>Heading</td>
							<td><input type="text" name="section[<?php echo $i; ?>][content][heading]" class="form-control" value="<?php if(isset($s['content']['heading'])){ echo $s['content']['heading']; } ?>"></td>
						</tr>
						<tr>
							<td>Copy</td>
							<td>
								<textarea name="section[<?php echo $i; ?>][content][copy]" rows="5" class="form-control"><?php if(isset($s['content']['copy'])){ echo $s['content']['copy']; } ?></textarea>
							</td>
						</tr>
					</table>

	<?php		$i++;
			} // end intro-copy

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
										<input type="text" name="section[<?=$i;?>][content][items][<?=$x;?>][text]" class="form-control" value="<?php if(!empty($s['content']['items'][$x]['text'])){ echo $s['content']['items'][$x]['text']; } ?>">
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
				<table class="table table-edit-components">
					<tr>
						<td>Heading</td>
						<td><input type="text" name="section[<?=$i;?>][content][heading]" class="form-control" value="<?php if(!empty($s['content']['heading'])){ echo $s['content']['heading']; } ?>"></td>
					</tr>
			<?php 	$count = (!empty($s['content']['items'])) ? count($s['content']['items']) : 2;
					for($x = 1; $x <= $count; $x++){	?>	
					<tr>
						<td>
							Item <?php echo $x; ?><br>
							<input type="hidden" name="section[<?php echo $i; ?>][content][items][<?php echo $x; ?>][order]" value="<?php if(isset($s['content'][$x]['order'])) { echo $s['content']['items'][$x]['order']; } else { echo $x; } ?>" class="category-list-order"><br>			
							<button type="button" class="btn btn-default btn-sm feature-up <?php if($x == 1){ echo "disabled"; } ?>" title="Move up"><i class="fa fa-arrow-up"></i></button> 
							<button type="button" class="btn btn-default btn-sm feature-down <?php if($x == $count){ echo "disabled"; } ?>" title="Move down"><i class="fa fa-arrow-down"></i></button> 
							<button type="button" class="btn btn-default btn-sm feature-delete" title="Delete"><i class="fa fa-trash"></i></button>
							
						</td>
						<td>	
							<div class="row" >
								<div class="col-md-6">
									
									<div class="input-group" style="margin-bottom: 5px; !important;">
										<span class="input-group-addon">Heading</span>
										<input type="text" name="section[<?php echo $i; ?>][content][items][<?php echo $x; ?>][heading]" class="form-control" value="<?php if(isset($s['content']['items'][$x]['heading'])) { echo $s['content']['items'][$x]['heading']; } ?>">
									</div>
									
									<div class="input-group" style="margin-bottom: 5px; !important;">
										<span class="input-group-addon">URL</span>
										<input type="text" name="section[<?php echo $i; ?>][content][items][<?php echo $x; ?>][url]" class="form-control" value="<?php if(isset($s['content']['items'][$x]['url'])) { echo $s['content']['items'][$x]['url']; } ?>">
									</div>
									<div class="input-group" style="margin-bottom: 5px; !important;">
										<span class="input-group-addon">tab</span>
										<select name="section[<?php echo $i; ?>][content][items][<?php echo $x; ?>][tab]" id="" class="form-control">
											<option value="parent" <?php if(isset($s['content']['items'][$x]['tab']) && $s['content']['items'][$x]['tab'] == "parent" ) { echo " selected"; } ?>>Parent</option>
											<option value="new"<?php if(isset($s['content']['items'][$x]['tab']) && $s['content']['items'][$x]['tab'] == "new" ) { echo " selected"; } ?>>New</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<textarea name="section[<?php echo $i; ?>][content][items][<?php echo $x; ?>][copy]" id="" rows="5" class="form-control" placeholder="Copy..."><?php if(isset($s['content']['items'][$x]['copy'])) { echo $s['content']['items'][$x]['copy']; } ?></textarea>
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
				<table class="table table-edit-components">
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