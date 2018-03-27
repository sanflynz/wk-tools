<?php 

include("includes/db.php");
include("classes/Pagination.php");
include("includes/header.php");
include("includes/sitefunctions.php");

	// $sql = "CREATE TABLE IF NOT EXISTS `webgenericpages` (
	//   `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	//   `name` varchar(250) NOT NULL,
	//   `title` varchar(250) NOT NULL,
	//   `image` varchar(250) NOT NULL,
	//   `description` text NOT NULL,
	//   `features` text NOT NULL,
	//   `post_features` text NOT NULL,
	//   `more` text NOT NULL,
	//   `items` text NOT NULL,
	//   `resources` text NOT NULL,
	//   `related` text NOT NULL,
	//   `country` varchar(100) NOT NULL,
	//   `last_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
	// ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

$sql = "CREATE TABLE IF NOT EXISTS `pages` (
		  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  `name` varchar(255) NOT NULL,
		  `country` varchar(100) NOT NULL,
		  `type` varchar(255) NOT NULL,
		  `settings` text,
		  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

$r = $conn->query($sql);
if($r){
	setFlash("info", "checked pages table");
	
}
else{
	setFlash("danger", "Unable to create pages table: " . $conn->error . "<br><br>" . $sql);
	$error = 1;
}

$sql2 = "CREATE TABLE IF NOT EXISTS `sections` (
		  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  `page_id` int(10) NOT NULL,
		  `type` varchar(250) NOT NULL,
		  `settings` text,
		  `name` varchar(255) DEFAULT NULL,
		  `content` longtext NOT NULL,
		  `s_order` int(10) NOT NULL,
		  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	// }
	// 
$r2 = $conn->query($sql2);
if($r2){
	setFlash("info", "checked sections table");
	
}
else{
	setFlash("danger", "Unable to create sections table: " . $conn->error . "<br><br>" . $sql);
	$error = 1;
}


// get the pages and stuff later

if(!extension_loaded('zip')){
	setFlash("danger", "The PHP Zip extension is not installed. Please see administrator for assistance in setting up"); 
}


?>

	<?php flash(); 	?>	

	<h3>Note!</h3>
	This may not work for everything, but should be good fo 80% of promotional pages.  For more tricky pages can help to make the basic structure, then having Mandy/PNX edit could be useful.

	<h3>Things To Do</h3>			

	<div class="row">
		<div class="col-xs-12">
			<ul>
				<li>Sorting list page. And search?</li>
				<li>Backup database button</li>					
			</ul>
		</div>
		
		
	</div>
		
<?php include("includes/footer.php"); ?>		