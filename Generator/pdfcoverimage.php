<?php 

include("includes/db.php");
include("classes/Pagination.php");
include("includes/header.php");

$pageError = FALSE;

?>

<h1>PDF Cover Images</h1>

<?php
if(!extension_loaded('imagick')){ ?>
	<div class="alert alert-danger">
		<strong>ERROR: </strong>The PHP ImageMagick extension is not installed. Please see administrator for assistance in setting up
	</div>
<?php
	$pageError = TRUE;
} 


$folders = array(
		array(
			'name' => 'pdf-cover',
			'dir' => 'pdf-cover', 
			'fullpath' => 'c:\wamp\www\WORK\wk-tools\generator\pdf-cover'
		),
		array(
			'name' => 'pdf-cover/images',
			'dir' => 'pdf-cover/images', 
			'fullpath' => 'c:\wamp\www\WORK\wk-tools\generator\pdf-cover\images'
		),
		array(
			'name' => 'pdf-cover/pdfs',
			'dir' => 'pdf-cover/pdfs', 
			'fullpath' => 'c:\wamp\www\WORK\wk-tools\generator\pdf-cover\pdfs'
		)
	);
foreach($folders as $f){
	if(!is_dir($f['dir'])){ 
		// Try to mkdir?
		if(mkdir($f['dir'])){ ?>
		<div class="alert alert-info">
			<strong>INFO: </strong><?php echo $f['name']; ?> directory has been created<br>
			<?php echo $f['fullpath']; ?>
		</div>
	<?php
		}
		else { ?>
		<div class="alert alert-danger">
			<strong>ERROR: </strong><?php echo $f['name']; ?> directory does not exist.  Please create folder<br>
			<?php echo $f['fullpath']; ?>
		</div>
	<?php
		}
	}
}


if($pageError === FALSE){ ?>

Output Information <br> 
Image Size <?php $maxW = "200";  $maxH = ""; ?> <br>
Image name <?php $imgName = "ANZ Cover name.jpg";  $imgDir = "pdf-cover/images"; ?><br>
<br>
Input File <?php $pdfDir = "pdf-cover/PDFs"; ?><br>
<br>
<a href="pdf-cover/GenomeEditing.pdf" title="">pdf</a><br>
<br>

<?php

// $im = new imagick('GenomeEditing.pdf[0]');
// $im->setImageFormat('jpg');
// header('Content-Type: image/jpeg');
// echo $im;


$image = new Imagick('testcover.jpg');
header('Content-type: image/jpeg');

// If 0 is provided as a width or height parameter,
// aspect ratio is maintained
$image->thumbnailImage(100, 0);

echo $image;

?>
<?php

	if(isset($_GET['action']) && $_GET['action'] == "convert"){
		

	}
}

?>



<?php include("includes/footer.php"); ?>		