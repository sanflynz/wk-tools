<?php
	include("includes/db.php");
	include("../__classes/pagination.php");
	include("includes/header.php");

	$sql = "SELECT * FROM pages ORDER BY modified DESC";
	// $r = $conn->query($sql);
	// if($conn->error){
	// 	echo "Error: " . $conn->error;
	// }

	// get the pages and stuff later
	$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
	$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 10;

	$Pagination  = new Pagination( $conn, $sql );
	$r = $Pagination->getData( $limit, $page );

?>


<div class="row">
	<div class="col-xs-12">
		<h1>Level 1/2 Pages</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<br>
		<a href="l2page_e.php?type=storefront" class="btn btn-primary">New L1 Page</a>&nbsp;
		<a href="l2page_e.php?type=category" class="btn btn-primary">New L2 Page</a>&nbsp;
		
		<button type="button" class="btn btn-warning import-toggle">Import</button>
		<!-- <button class="btn btn-warning import-toggle" type="button" data-type="old-storefront">Import old Storefront</button><button class="btn btn-warning import-toggle" type="button" data-type="old-category">Import old Category (L2)</button>  --><br>
		
		<div id="import-container" style="display: none;">
			<form action="l2page_e.php" method="post" accept-charset="utf-8">
				<br>
				<select name="import-type" id="import-type" class="form-control" required style="width: 50%">
					<option value="">Select page type</option>
					<option value="old-storefront">Old Storefront</option>
					<option value="old-category">Old Category</option>
				</select>
				<br>
				<div class="input-group">
					<input name="url" type="text" class="form-control" placeholder="Page URL...">
			      		<span class="input-group-btn">
			        		<button class="btn btn-success" type="submit" name="import" value="true">Go!</button>
			      	</span>
			    </div>
			    <div class="import-settings" id="old-storefront-settings" style="display: none;">
			    	<br>
			    	<label>
			    		# category-list rows <input name="cat-list-rows" type="text" class="form-control" style="width: 50px">
			    	</label>
			    </div>
			    <div class="import-settings" id="old-category-settings" style="display: none;">
			    	old cateogory
			    </div>
			</form>
		</div>
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
					
					<td><?php echo $row['country']; ?></td>
				<!--	<td></td>
					<td></td> -->
					<td align="right"> 
						<a href="l2page_e.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-pencil"  title="Edit Page"></i></a>&nbsp;&nbsp;
						<a href="l2page_au_v.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-eye" title="View Page"></i></a>&nbsp;&nbsp;
						<a href="l2page_export.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-code" title="Export Code"></i></a>&nbsp;&nbsp;
						<a href="l2page_e.php?copy=<?php echo $row['id']; ?>" class="btn btn-default disabled"><i class="fa fa-copy" title="Copy this page"></i></a>&nbsp;&nbsp;
						<a href="l2page_d.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-minus-circle" style="color: red;" title="Delete this page" onclick="return confirm('Are you sure you want to delete this record?')"></i></a>&nbsp;&nbsp;
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