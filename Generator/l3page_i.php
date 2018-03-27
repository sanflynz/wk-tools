<?php
	include("includes/db.php");
	include("../__classes/pagination.php");
	include("includes/header.php");

	$sql = "SELECT * FROM webl3pages ORDER BY last_modified DESC";
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
		<h1>Level 3 Pages</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<br>
		<a href="l3page_e.php" class="btn btn-primary">New L3 Page</a>&nbsp;
		<button class="btn btn-warning" type="button" id="import-old-toggle">Import from old style page</button> <br>
		<div id="import-old-container" style="display: none;">
			
			<form action="l3page_e.php?import=old" method="post" accept-charset="utf-8">
				<br>
				<div class="input-group">
			      	<input type="text" name="url" class="form-control" placeholder="Page URL..." id="import-old-url">
			      		<span class="input-group-btn">
			        		<button class="btn btn-success" type="submit" name="import-old" id="import-old-button">Go!</button>
			      		</span>
			    </div>
			    <br>
			    <div class="import-settings">
			    	<h4>Settings</h4>
			    	<div class="row">
			    		<div class="col-md-2">
			    			<strong>HDI</strong>
			    			<input type="text" name="hdi" class="form-control" id="" placeholder="0" value="0">
			    		</div>
			    		<div class="col-md-2">
			    			<strong>Featured / Gateway</strong>
							<input type="text" name="featured-gateway" class="form-control" placeholder="1" value="1">
							
			    		</div>
			    		<div class="col-md-2">
			    			<div class="form-group">
							    <label for="">Category lists</label>
							    <input type="text" name="category-lists" class="form-control" placeholder="3" value="3">
							 </div>
			    		</div>
			    	
			    		<div class="col-md-2">
			    			<div class="form-group">
							    <label for="">Videos</label>
							    <input type="text" name="videos" class="form-control" id="" placeholder="4" value="4">
							 </div>
			    		</div>
			    	
			    		<div class="col-md-2">
			    			<div class="form-group">
							    <label for="">Embedded promos</label>
							    <input type="text" name="embedded-promos" class="form-control" id="5" placeholder="5" value="5">
							 </div>
			    		</div>
			    		<div class="col-md-2">
			    			<div class="form-group">
							    <label for="">Resources</label>
							    <input type="text" name="resources" class="form-control" id="" placeholder="6" value="6">
							 </div>
			    		</div>
			    	</div>
			    	<div class="row">
			    		<div class="col-md-12">(NA = not included, update following valued)</div>
			    	</div>
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
					<td><?php echo $row['page-heading']; ?></td>
					<td><?php echo $row['country']; ?></td>
				<!--	<td></td>
					<td></td> -->
					<td align="right"> 
						<a href="l3page_e.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-pencil"  title="Edit Page"></i></a>&nbsp;&nbsp;
						<a href="l3page_au_v.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-eye" title="View Page"></i></a>&nbsp;&nbsp;
						<a href="l3page_export.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-code" title="Export Code"></i></a>&nbsp;&nbsp;
						<a href="l3page_e.php?copy=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-copy" title="Copy this page"></i></a>&nbsp;&nbsp;
						<a href="l3page_d.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-minus-circle" style="color: red;" title="Delete this page" onclick="return confirm('Are you sure you want to delete this record?')"></i></a>&nbsp;&nbsp;
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