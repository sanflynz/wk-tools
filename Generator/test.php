<?php

	include("includes/db.php");
	include("includes/sitefunctions.php");
	include('../__classes/UploadFile.php');

	$images = "../../../Uploads/image/";



	if($_POST){

		$up = new UploadFile($conn, $images);  // Can we put destination and file into this?
		$up->test($_FILES['main-image']);
		// $up->destination = $images;
		//$up->upload($_FILES['main-image']);
		
	}
	else{
		echo "no post";
	}

	include("includes/header.php");

?>

<?php flash(); 	?>	
<form method="post" role="form" enctype="multipart/form-data">
	<div class="row">
		<div class="col-xs-6">
			
			<div class="file-group">
				<div class="input-group">
					<input type="text" name="heading" id="" value="somefile.jpg" class="form-control">
					<div class="input-group-btn">
						<button type="button" class="btn btn-primary file-toggle"><i class="fa fa-pencil" style="margin: 3px; 0px;"></i></button>
					</div>
				</div>
				<div class="input-group" style="display: none">
					<input type="text" value="" class="form-control file-text">
					<div class="input-group-btn">
						<button type="button" class="btn btn-primary file-dialog"><i class="fa fa-folder-open" style="margin: 3px; 0px;"></i></button>
						<button type="button" class="btn btn-danger file-toggle file-cancel"><i class="fa fa-ban" style="margin: 3px; 0px;"></i></button>
					</div>
				</div>
				<input type="file" name="main-image" id="" class="form-control" style="display: none;">
			</div>
			<br>
			<br>
			
			
			<div class="file-group">
				<div class="input-group">

					<input type="text" name="heading" id="" value="someotherfile.jpg" class="form-control">
					<div class="input-group-btn">
						<button type="button" class="btn btn-primary file-toggle"><i class="fa fa-pencil" style="margin: 3px; 0px;"></i></button>
					</div>
				</div>
				<div class="input-group" style="display: none">
					<input type="text" value="" class="form-control file-text">
					<div class="input-group-btn">
						<button type="button" class="btn btn-primary file-dialog"><i class="fa fa-folder-open" style="margin: 3px; 0px;"></i></button>
						<button type="button" class="btn btn-danger file-toggle file-cancel"><i class="fa fa-ban" style="margin: 3px; 0px;"></i></button>
					</div>
				</div>
				<input type="file" name="main-image" id="" class="form-control" style="display: none;">
			</div>
			
		</div>
	</div>
	
</form>


<?php

include("includes/footer.php");

?>