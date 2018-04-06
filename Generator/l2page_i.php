<?php
	include("includes/db.php");
	include("../__classes/Pagination.php");
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
		<h1>Level 1/2/3 Pages</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<br>
		<a href="l2page_e.php?type=storefront" class="btn btn-primary">New L1 Page</a>&nbsp;
		<a href="l2page_e.php?type=category" class="btn btn-primary">New L2 Page</a>&nbsp;
		<a href="l2page_e.php?type=sub-category" class="btn btn-primary">New L3 Page</a>&nbsp;
		
		<button type="button" class="btn btn-warning import-toggle">Import</button>
		<!-- <button class="btn btn-warning import-toggle" type="button" data-type="old-storefront">Import old Storefront</button><button class="btn btn-warning import-toggle" type="button" data-type="old-category">Import old Category (L2)</button>  --><br>
		
		<div id="import-container" style="display: none;">
			<form action="l2page_e.php" method="post" accept-charset="utf-8">
				<br>
				<select name="import-type" id="import-type" class="form-control" required style="width: 50%">
					<option value="">Select page type</option>
					<option value="old-storefront">Old Storefront</option>
					<option value="old-category">Old Category</option>
					<option value="old-sub-category">Old Sub-category</option>
					<option value="old-items-list">Old Items List</option>
				</select>
				<br>
				
			    <div class="import-settings" id="old-storefront-settings" style="display: none;">
			    	<label>
			    		# category-list rows <input name="cat-list-rows" type="text" class="form-control" style="width: 50px">
			    	</label>
			    </div>
				
			    <div class="import-settings" id="old-category-settings" style="display: none;">
			    	old cateogory
			    </div>
				
					 <div class="import-settings" id="old-sub-category-settings" style="display: none;">
			    	<h4>Settings</h4>
			    	<div class="row">
			    		<div class="col-md-2">
			    			<strong>HDI</strong>
			    			<input type="text" name="settings[hdi]" class="form-control" id="" placeholder="0" value="0">
			    		</div>
			    		<div class="col-md-2">
			    			<strong>Featured / Gateway</strong>
							<input type="text" name="settings[featured-gateway]" class="form-control" placeholder="1" value="1">
							
			    		</div>
			    		<div class="col-md-2">
			    			<div class="form-group">
							    <label for="">Alternating HDI</label>
							    <input type="text" name="settings[alternating-hdi]" class="form-control" placeholder="3" value="3">
							 </div>
			    		</div>
			    	
			    		<div class="col-md-2">
			    			<div class="form-group">
							    <label for="">Videos</label>
							    <input type="text" name="settings[videos]" class="form-control" id="" placeholder="4" value="4">
							 </div>
			    		</div>
			    	
			    		<div class="col-md-2">
			    			<div class="form-group">
							    <label for="">Embedded promos</label>
							    <input type="text" name="settings[embedded-promos]" class="form-control" id="5" placeholder="5" value="5">
							 </div>
			    		</div>
			    		<div class="col-md-2">
			    			<div class="form-group">
							    <label for="">Resources</label>
							    <input type="text" name="settings[resources]" class="form-control" id="" placeholder="6" value="6">
							 </div>
			    		</div>
			    	</div>
			    	<div class="row">
			    		<div class="col-md-12">(NA = not included, update following valued)</div>
			    	</div>
			    </div>
				
				
					<div class="input-group" style="width: 60%">
					<input name="url" type="text" class="form-control" placeholder="Page URL..." >
			      		<span class="input-group-btn">
			        		<button class="btn btn-success" type="submit" name="import" value="true">Go!</button>
			      	</span>
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