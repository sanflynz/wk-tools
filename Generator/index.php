<?php 

include("includes/db.php");
include("classes/Pagination.php");
include("includes/header.php");



// get the pages and stuff later

if(!extension_loaded('zip')){ ?>
	<div class="alert alert-danger">
		<strong>ERROR: </strong>The PHP Zip extension is not installed. Please see administrator for assistance in setting up
	</div>
<?php
}


?>
	<h3>Note!</h3>
	This may not work for everything, but should be good fo 80% of promotional pages.  For more tricky pages can help to make the basic structure, then having Mandy/PNX edit could be useful.

	<h3>Things To Do</h3>			

	<div class="row">
		<div class="col-xs-12">
			<ul>
				<li>Level 3 page generator. How to import/edit?</li>
				<li>Sorting list page. And search?</li>
				<li>Download zip with image and files??</li>
				<li>Bug Report</li>	
				<li>Backup database button</li>					
			</ul>
		</div>
		
		
	</div>
		
<?php include("includes/footer.php"); ?>		