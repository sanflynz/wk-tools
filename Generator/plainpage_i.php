<?php
	include("includes/db.php");
	include("includes/header.php");

?>


<div class="row">
	<div class="col-xs-12">
		<h1>Plain Pages</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		buttons
	</div>
</div>
<div class="row">
	<br>
	<div class="col-xs-12">
	<?php 	$sql = "SELECT * FROM webplainpages";
			$r = $conn->query($sql);
			if($conn->error){
				echo "Error: " . $conn->error;
			}
			if($r->num_rows > 0){ ?>
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
		<?php 	while($row = $r->fetch_assoc()){ ?>		
				<tr>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['country']; ?></td>
				<!--	<td></td>
					<td></td> -->
					<td align="right"> 
						<a href="plainpage_e.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-pencil"  title="Edit Page"></i></a>&nbsp;&nbsp;
						<a href="plainpage_au_v.php?id=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-eye" title="View Page"></i></a>&nbsp;&nbsp;
						<a href="plainpage_export.php?id=<?php echo $row['id']; ?>" class="btn btn-default" target="_blank"><i class="fa fa-code" title="Export Code"></i></a>&nbsp;&nbsp;
						<a href="plainpage_e.php?copy=<?php echo $row['id']; ?>" class="btn btn-default"><i class="fa fa-copy" title="Copy this page"></i></a>&nbsp;&nbsp;
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



<?php

	include("includes/footer.php");

?>