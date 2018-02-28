<?php 

include("includes/db.php");
include("classes/Pagination.php");
include("includes/header.php");



// Check for dependencies
if(!extension_loaded('zip')){ ?>
	<div class="alert alert-danger">
		<strong>ERROR: </strong>The PHP Zip extension is not installed. Please see administrator for assistance in setting up
	</div>
<?php
}
$folders = array(
		array(
			'name' => 'Files',
			'dir' => 'files', 
			'fullpath' => 'c:\wamp\www\WORK\wk-tools\generator\files'
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


// Convert any unseralised L3 requirements
$sql = "SELECT * FROM webl3pages";
$r = $conn->query($sql) or die($conn->error);
$x = 0;
$fieldNames = "popular-1,popular-2,popular-3,videos,resources-left,resources-right";
while($p = $r->fetch_assoc()){
	// POPULAR	
 	for($i = 1; $i <= 3; $i++){
 		
 		if($p['popular-' . $i]){
 			if(@unserialize($p['popular-' . $i]) === FALSE){
 				$p['popular-' . $i] = explode("|",$p['popular-' . $i]);
			 	$p['popular-' . $i]['text'] = $p['popular-' . $i][0];
			 	$p['popular-' . $i]['image'] = $p['popular-' . $i][1];
			 	$p['popular-' . $i]['url'] = $p['popular-' . $i][2];
			 	$p['popular-' . $i]['tab'] = $p['popular-' . $i][3];

			 	$p['popular-' . $i] = serialize($p['popular-' . $i]);
			 	$x++;
 			}
 			
	 		
		}
 	}	
 	// SPLIT VIDEOS
	if($p['videos']){ 
		$parts = explode("[ITEMS]",$p['videos']);
		$items = explode("|", $parts[1]);
		$p['videos'] = "";
		$p['videos']['heading'] = substr($parts[0],9);
		$p['videos']['left'] = $items[0];
		$p['vidoes']['right'] = $items[1];

		$p['videos'] = serialize($p['videos']);
		$x++;
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

			$p['pod-' . $s] = serialize($p['pod-' . $s]);
			$x++;
		}
	}

	// foreach($sides as $s){
	// 	if($p['resources-' . $s]){
	// 		$parts = explode("[ITEMS]",$p['resources-' . $s]);
	// 		$p['resources-' . $s] = ""; // resets the array?
	// 		$p['resources-' . $s]['heading'] = substr($parts[0],9);
			
	// 		$p['resources-' . $s]['items'] = explode("\n",$parts[1]);  // text | url | tab | action | label  // icon???

	// 		$p['resources-' . $s] = serialize($p['resources-left']);
			

	// 	}
	// }


 	$values = "";
 	$j = 1;
 	foreach(explode(",", $fieldNames) as $fn){
		//$values .= "`" . $fn . "`" . "='" . addslashes($p[$fn]) . "'";
		$values .= "`" . $fn . "`" . "='" . $p[$fn] . "'";
		//echo "<br>" . $valuess;
			

		if($j < count(explode(",",$fieldNames))){
			$values .= ",";
		}
		$j++;
	}

 	$sql2 = "UPDATE webl3pages SET $values WHERE id = " . $p['id'];
	if($conn->query($sql2)){
		//echo "updated";
	}
	else{
		echo $conn->error;
		echo "<br>" . $sql2 . "<br><br>";
	
	}
		

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