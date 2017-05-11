<?php
	include("includes/db.php");


	if($_POST){

		$p = $_POST;
		//print_r($p);
		$fieldNames = "name,country,content";
		$fields = "";
		$values = "";

		if($p['id'] == ""){
			$i = 1;
			foreach(explode(",", $fieldNames) as $fn){
				$fields .= "`" . $fn . "`"; if($i < count(explode(",", $fieldNames))){ $fields .= ","; }
				$values .= "'" . addslashes($_POST[$fn]) . "'"; if($i < count(explode(",", $fieldNames))){ $values .= ","; }
				$i++;
			}

			$sql = "INSERT INTO webplainpages (" . $fields . ") VALUES (" . $values . ")";
			//echo $sql;
			$r = $conn->query($sql);
			if($r){
				// redirect
				header("location: plainpage_au_v.php?id=" . mysqli_insert_id($conn));
				
			}
			else{
				$error = "Unable to add promo page: " . $conn->error . "<br><br>" . $sql;
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
			$sql = "UPDATE webplainpages SET $values WHERE id = " . $p['id'];
			//echo $sql;
			$r = $conn->query($sql);
			if($r){
				// redirect
				header("location: plainpage_au_v.php?id=" . $p['id']);
			}
			else{
				$error = "Unable to update page: " . $conn->error;
			}

		}


	}

	if(isset($_GET['id'])){
		$sql = "SELECT * FROM `webplainpages` p WHERE p.id = " . $_GET['id'];
		$r = $conn->query($sql);
		$p = $r->fetch_assoc();
	}

	if(isset($_GET['copy'])){
		$sql = "SELECT * FROM `webplainpages` p WHERE p.id = " . $_GET['copy'];
		$r = $conn->query($sql);
		$p = $r->fetch_assoc();

		$p['id'] = "";
		$p['country'] = "";
		echo $p['country'];
	}



	include("includes/header.php");

	//print_r($p);
?>


<div class="row">
	<div class="col-xs-12">
		<h1>Promo Page Add/Edit</h1>

		<?php
		if(isset($error)){ ?>
			
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>ERROR:</strong> <?php echo $error; ?>
			</div>
<?php	}
	?>	
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
				<td align="right"><strong>Content</strong></td>
				<td><textarea name="content" class="form-control" rows="20"><?php if(isset($p)) { echo htmlentities($p['content']); } ?></textarea></td>
			</tr>

			<tr>
				<td></td>
				<td><button class="btn btn-success">Save and view</button></td>
			</tr>
		</table>
		</div>

	</div>
</form>



<?php

	include("includes/footer.php");

?>