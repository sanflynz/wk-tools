<?php
	include("includes/db.php");
	include("../__classes/pagination.php");
	include("includes/header.php");

	$sql = "SELECT * FROM webpromopages ORDER BY last_modified DESC";
	// $r = $conn->query($sql);
	// if($conn->error){
	// 	echo "Error: " . $conn->error;
	// }

	// get the pages and stuff later
	$page = ( isset($_GET['page'])) ? $_GET['page'] : 1;
	$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 10;

	$Pagination  = new Pagination( $conn, $sql );
	$r = $Pagination->getData( $limit, $page );

?>


<div class="row">
	<div class="col-xs-12">
		<h1>Promo Pages</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<br>
		<a href="promopage_e.php" class="btn btn-primary">New Promo Page</a>
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
						<a href="promopage_e.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-pencil"  title="Edit Page"></i></a>&nbsp;&nbsp;
						<a href="promopage_au_v.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-eye" title="View Page"></i></a>&nbsp;&nbsp;
						<a href="promopage_export.php?id=<?php echo $row['id']; ?>" class="btn btn-default" target="_blank"><i class="fa fa-code" title="Export Code"></i></a>&nbsp;&nbsp;
						<a href="promopage_e.php?copy=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-copy" title="Copy this page"></i></a>&nbsp;&nbsp;
						<a href="promopage_d.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-minus-circle" style="color: red;" title="Delete this page" onclick="return confirm('Are you sure you want to delete this record?')"></i></a>&nbsp;&nbsp;
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

	include("includes/footer.php");

?>