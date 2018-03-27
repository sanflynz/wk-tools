<?php
	include("includes/db.php");
	include("includes/sitefunctions.php");

	$status = "create";

	if($_POST){
		$p = $_POST;
		$fieldNames = "name,country,type,settings";
		$fields = "";
		$values = "";

		if($p['id'] == ""){
			$status = "new";
			$i = 1;
			foreach(explode(",", $fieldNames) as $fn){
				$fields .= "`" . $fn . "`"; if($i < count(explode(",", $fieldNames))){ $fields .= ","; }
				$values .= "'" . addslashes($_POST[$fn]) . "'"; if($i < count(explode(",", $fieldNames))){ $values .= ","; }
				$i++;
			}

			$sql = "INSERT INTO pages (" . $fields . ") VALUES (" . $values . ")";
			//echo $sql;
			$r = $conn->query($sql);
			if($r){
				$p['id'] = mysqli_insert_id($conn);
				// TODO: Automatically add required sections for type
				// 
				
				setFlash("success", "Page created");				
				header("location: page_e.php?id=" . $p['id']);
				
			}
			else{
				setFlash('danger', "Unable to add page: " . $conn->error . "<br><span style='font-size: smaller'>" . $sql . "</span>");
			}
		}
		else {
			print '<pre>'; 
			print_r($_POST);
			print '</pre>';
		}


	}

	if(isset($_GET['id'])){
		$status = "edit";
		$sql = "SELECT * FROM `pages` p WHERE p.id = " . $_GET['id'];
		$r = $conn->query($sql);
		$p = $r->fetch_assoc();

		$sql2 = "SELECT * FROM `sections` s WHERE s.page_id = " . $_GET['id'] . "ORDER BY s.order";
		$r2 = $conn->query($sql2);
		$s = $r->fetch_assoc();
		$numS = $r->num_rows;
	}



	include("includes/header.php");
 ?>

<div class="row">
	<div class="col-xs-12">
		<h1>Page Add/Edit</h1>
		<div id="notifications">		
			<?php flash(); 	?>	
		</div>
	</div>
</div>

<br>
<form method="post" role="form" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php if(isset($p)) {echo $p['id'];} ?>">

<?php include("Templates/settings/edit.php"); 

if($status != "create"){ ?>



<div class="row">
	<div class="col-md-12">
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSectionDialog">Add Section</button>
		<br>
		<br>
		<hr>
	</div>
</div>

<?php include("Templates/modals/pageaddsection.php"); ?>


<div id="sections">
	
</div>

<?php 
} ?>


<table class="table table-edit-components">
	<tr>
		<td></td>
		<td><button class="btn btn-success">Submit Changes</button></td>
	</tr>
</table>
	

</form>

 <?php


	include("includes/footer.php");

?>

