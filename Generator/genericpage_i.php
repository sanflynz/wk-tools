<?php
	include("includes/db.php");
	include("includes/sitefunctions.php");
	include("../__classes/Pagination.php");
	include("includes/header.php");

	// $sql = "SHOW TABLES LIKE `webgenericpages`";
	// $r = $conn->query($sql);
	// if($r->num_rows > 0){
	// 	setFlash("warning", "Database table does not exist");
		
		$sql = "CREATE TABLE IF NOT EXISTS `webgenericpages` (
		  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  `name` varchar(250) NOT NULL,
		  `title` varchar(250) NOT NULL,
		  `image` varchar(250) NOT NULL,
		  `description` text NOT NULL,
		  `features` text NOT NULL,
		  `post_features` text NOT NULL,
		  `more` text NOT NULL,
		  `items` text NOT NULL,
		  `resources` text NOT NULL,
		  `related` text NOT NULL,
		  `country` varchar(100) NOT NULL,
		  `last_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	
		$r = $conn->query($sql);
		if($r){
			
			
		}
		else{
			setFlash("danger", "Unable to create table: " . $conn->error . "<br><br>" . $sql);
			$error = 1;
		}
	// }

	if(!isset($error)){
		$sql = "SELECT * FROM webgenericpages ORDER BY last_modified DESC";
		// $r = $conn->query($sql);
		// if($conn->error){
		// 	echo "Error: " . $conn->error;
		// }

		// get the pages and stuff later
		$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
		$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 10;

		$Pagination  = new Pagination( $conn, $sql );
		$r = $Pagination->getData( $limit, $page );
	}

?>


<div class="row">
	<div class="col-xs-12">
		<h1>Generic (child) Pages</h1>
		<br>
<?php 	flash(); ?>		
	</div>
</div>
<?php
if(!isset($error)){ ?>

<div class="row">
	<div class="col-md-4">
		<a href="genericpage_e.php" class="btn btn-primary">New Generic (child) Page</a>
	</div>
</div>



<div class="row">
	<br>
	<div class="col-xs-12">
	<?php 	
			if($Pagination->total > 0){ ?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Title</th>
					<th>Country</th>
				<!--	<th>Start Date</th>
					<th>End Date</th> -->
					<th style="width: 270px"></th>
					
				</tr>
			</thead>
			<tbody>
		<?php 	//while($row = $r->fetch_assoc()){ 
				foreach($r->data as $row){

			?>		
				<tr>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['title']; ?></td>
					<td><?php echo $row['country']; ?></td>
				<!--	<td></td>
					<td></td> -->
					<td align="right"> 
						<a href="genericpage_e.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-pencil"  title="Edit Page"></i></a>&nbsp;&nbsp;
						<a href="genericpage_au_v.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-eye" title="View Page"></i></a>&nbsp;&nbsp;
						<a href="genericpage_export.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-code" title="Export Code"></i></a>&nbsp;&nbsp;
						<a href="genericpage_e.php?copy=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-copy" title="Copy this page"></i></a>&nbsp;&nbsp;
						<a href="genericpage_d.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-minus-circle" style="color: red;" title="Delete this page" onclick="return confirm('Are you sure you want to delete this record?')"></i></a>&nbsp;&nbsp;
					</td>
				</tr>
		<?php 	} ?>		
			</tbody>
		</table>
	<?php 	}
			else{
				echo "No results found";
			}	?>	

	</div>
</div>

<?php if($Pagination->total > $limit){ ?>
<div class="row">
	<div class="col-xs-6"></div>
	<div class="col-xs-6 text-right">
		<?php echo $Pagination->buildLinks(); ?>
	</div>
</div>

<?php
}

}

	include("includes/footer.php");

?>