<?php 

include("includes/db.php");
include("includes/header.php");


	if($_POST){
		if(isset($_POST['addConferenceGroup'])){
			// get last order
			$r = $conn->query("SELECT * FROM conference_groups WHERE conference_id = '" . $_GET['id'] . "'' ORDER BY `order` DESC LIMIT 1");
			if($r->num_rows > 0){
				$row = $r->fetch_assoc();
				$newOrder = $row['order'] + 1;
			}
			else{
				$newOrder = 1;
			}
			// check not already exists
			// 
			// 
			$r = $conn->query("INSERT INTO conference_groups (conference_id,group_id,`order`) VALUE ('" . $_GET['id'] . "','" . $_POST['group_id'] . "','" . $newOrder . "')");
			echo $conn->error;

		}

		if(isset($_POST['addConferenceProduct'])){
			echo "were in";
			// get last order
			$r = $conn->query("SELECT * FROM conference_products WHERE conference_id = '" . $_GET['id'] . "' AND conference_group_id = '" . $_POST['conference_group_id'] . "' ORDER BY `order` DESC LIMIT 1");
			
			if($r->num_rows > 0){
				$row = $r->fetch_assoc();
				$newOrder = $row['order'] + 1;
			}
			else{
				$newOrder = 1;
			}

			$r = $conn->query("INSERT INTO conference_products (conference_id,conference_group_id,product_id,`order`) VALUE ('" . $_GET['id'] . "','" . $_POST['conference_group_id'] . "','" . $_POST['product_id'] . "','" . $newOrder . "')");
			echo $conn->error;
			
		}
	}

	
	function getGroup($id, $conn){
		$r = $conn->query("SELECT * FROM groups WHERE id = " . $id);
		$g = $r->fetch_assoc();

		return $g;

	}

	$sql = "SELECT * FROM `conferences` c WHERE c.id = " . $_GET['id'];
	$r = $conn->query($sql);
	$c = $r->fetch_assoc();
	//while($row = $r->fetch_assoc()){
	//	$c = $row;
	//}

	$sqlCG = "SELECT cg.id as cgid, g.id as gid, g.name FROM conference_groups cg LEFT JOIN groups g ON cg.group_id = g.id WHERE cg.conference_id = " . $_GET['id'] . " ORDER BY cg.`order`";
	$rCG = $conn->query($sqlCG);


	if($rCG->num_rows > 0){
		
	// 	//$conference_group = array();
	// 	//$conference_product = array();
	// 	//$group = array();
	// 	$product = array();
	 	while( $rowCG = $rCG->fetch_assoc() ){
	 		$p['conference_group'][$rowCG['cgid']]['group']['id'] = $rowCG['gid'];
	 		$p['conference_group'][$rowCG['cgid']]['group']['name'] = $rowCG['name'];
	 		
	// 		// get conference
	// 		$p['group'][$row['group_id']] = getGroup($row['group_id'],$conn);
	 	}

	 	foreach($p['conference_group'] as $k => $v){
	 		$sqlCP = "SELECT cp.id as cpid, p.id as pid, cp.*, p.* FROM conference_products cp LEFT JOIN products p on cp.product_id = p.id WHERE conference_id = '" . $_GET['id'] . "' AND cp.conference_group_id = '" . $k . "' ORDER BY cp.order";
	 		$rCP = $conn->query($sqlCP);
	 		while($rowCP = $rCP->fetch_assoc()){
	 			$p['conference_group'][$k]['products'][] = $rowCP;	
	// 			//$r3 = $conn->query("SELECT * FROM products WHERE");
	 		}
			
	 	}
	 	// echo "<pre>";
	 	// print_r($p);
	 	// echo "</pre>";

	}	
?>

<div class="row">
	<div class="col-md-12">
		<h1>Conference</h1>
		<br>
		<table class="table">
			<tr>
				<td width="250" align="right"><strong>Conference Name</strong></td>
				<td><?php echo $c['name']; ?></td>
			</tr>
			<tr>
				<td width="250" align="right"><strong>Start Date</strong></td>
				<td><?php  ?></td>
			</tr>
			<tr>
				<td width="250" align="right"><strong>End Date</strong></td>
				<td><?php  ?></td>
			</tr>
			<tr>
				<td align="right"><strong>Email to Send</strong></td>
				<td><?php echo $c['email_to_send']; ?></td>
			</tr>
			<tr>
				<td align="right"><strong>Hero Image</strong></td>
				<td><a href="<?php echo $c['hero_img']; ?>" target="_blank"><img src="<?php echo $c['hero_img']; ?>" class="img-reponsive"></a></td>
			</tr>
			<tr>
				<td align="right"><strong>Home Page Content</strong></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<h3>Products</h3>
		<button class="btn btn-default" id="showAddGroup">ADD GROUP</button><br>
		<br>
		<div class="" id="addGroupDiv" style="display: none;">
		<?php 	$rAddG = $conn->query("SELECT id,name FROM groups"); ?>	
			<form class="form-inline" method="post" name="addConferenceGroup">
			  <div class="form-group">
			    <select name="group_id" class="form-control">
			    	<option value=""> --- SELECT GROUP --- </option>
			    <?php 	while($rowAddG = $rAddG->fetch_assoc()){ ?>
							<option value="<?php echo $rowAddG['id']; ?>"><?php echo $rowAddG['name']; ?></option>
			    <?php	} ?>	
			    </select>

			  </div>
			  
			  <button type="submit" name="addConferenceGroup" value="submit" class="btn btn-default btn-success"><i class="fa fa-check"></i></button>
			</form>
			 <br>
		</div>

<?php 	if($rCG->num_rows > 0){
			foreach($p['conference_group'] as $k => $v){ ?>

			<h4>&nbsp;&nbsp;&nbsp;<?php echo $v['group']['name']; ?> </h4>
			<button class="btn btn-default btn-xs showAddProduct" id="showAddProduct" data-conferenceGroup="<?php echo $k; ?>">ADD PRODUCT</button><br>

			<div class="" id="addProductDiv" style="display: none;" data-cgDivFor="<?php echo $k; ?>">
				<br>
		<?php 	$rAddP = $conn->query("SELECT id,name FROM products"); ?>	
			<form class="form-inline" method="post">
				<input type="hidden" name="conference_group_id" value="<?php echo $k; ?>">
			  	<div class="form-group">
			    	<select name="product_id" class="form-control">
			    		<option value=""> --- SELECT PRODUCT --- </option>
			    <?php 	while($rowAddP = $rAddP->fetch_assoc()){ ?>
							<option value="<?php echo $rowAddP['id']; ?>"><?php echo $rowAddP['name']; ?></option>
			    <?php	} ?>	
			    	</select>
			  	</div>
			  	<button type="submit" name="addConferenceProduct" value="submit" class="btn btn-default btn-success"><i class="fa fa-check"></i></button>
				<a href="product_e.php" class="btn btn-default" title="Add New Product"><i class="fa fa-plus"></i></a>
			  	
			</form>
			<br>
		</div>

	<?php 	if($rCG->num_rows > 0 && isset($v['products'])){ ?>		
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Item</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
			<?php 	
					foreach($v['products'] as $product){
						$signRequired = "brand_id,sign_name,sign_desc,sign_short_url,sign_size,redirect_url";
						$brandRequired = "name,bg_colour,logo_sm,logo_md";
						$signOk = true;
						foreach(explode(",", $signRequired) as $r){
							if(!$product[$r]){
								$signOk = false;
							}
						}
						
						$landingRequired = "heading,btn_landing,desc_landing,findoutmore,questions,main_img_landing,specialist_email,redirect_url";
						$landingOk = true;
						foreach(explode(",", $landingRequired) as $r){
							if(!$product[$r]){
								$landingOk = false;
							}
						}

						$emailRequired = "btn_email,btn_email_link,desc_email,main_img_email";
						$emailOk = true;
						foreach(explode(",", $emailRequired) as $r){
							if(!$product[$r]){
								$emailOk = false;
							}
						}

						 ?>
					<tr>
						<td><?php echo $product['name']; ?></td>
						<td align="right">
							<a href="makesign2.php?product=<?php echo $product['pid']; ?>" class="btn <?php if($signOk === true){ echo "btn-default"; } else { echo "btn-warning"; }   ?>" title="Product Sign" target="_blank"><i class="fa fa-file-o"></i></a> 
							<a href="landingpage.php?id=<?php echo $product['pid']; ?>&conference=<?php echo $_GET['id']; ?>" class="btn <?php if($landingOk === true){ echo "btn-default"; } else { echo "btn-warning"; }   ?>" title="Landing Page" target="_blank"><i class="fa fa-file-text-o"></i></a> 
							<a href="email.php?id=<?php echo $product['pid']; ?>&conference=<?php echo $_GET['id']; ?>" class="btn <?php if($emailOk === true){ echo "btn-default"; } else { echo "btn-warning"; }   ?>" title="Email" target="_blank"><i class="fa fa-envelope-o"></i></a> 
							<a href="product_e.php?id=<?php echo $product['pid']; ?>&conference=<?php echo $_GET['id']; ?>" class="btn btn-default" title="Edit"><i class="fa fa-pencil"></i></a> 
							<button id="orderUpCp"  class="btn btn-default <?php if($product['order'] == count($v['products'])){ echo " disabled"; } ?>" title="Move Down"><i class="fa fa-arrow-down" ></i></button> 
							<button id="orderDownCp" class="btn btn-default <?php if($product['order'] == "1"){ echo " disabled"; } ?>" ><i class="fa fa-arrow-up" title="Move Up"></i></button> 
							<button id="removeCp" class="btn btn-default" title="Remove"><i class="fa fa-close"></i></button> 
							
						</td>
						
					</tr>
			<?php 	}	
					?>		
				</tbody>
			</table>
	<?php 	} ?>		
			<br>
			<hr>
			<?php }
			} ?>
	</div>
</div>






<?php

include("includes/footer.php"); ?>