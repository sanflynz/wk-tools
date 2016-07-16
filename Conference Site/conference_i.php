<?php
	include("includes/db.php");
	include("includes/header.php");

?>


<div class="row">
	<div class="col-xs-12">
		<h1>Conferences</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		buttons
	</div>
</div>
<div class="row">
	<h4>Upcoming</h4>
	<div class="col-xs-12">
	<?php 	$sql = "SELECT * FROM conferences WHERE status = '1'";
			$r = $conn->query($sql);
			if($r->num_rows > 0){ ?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Conference</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th style="width: 270px"></th>
					
				</tr>
			</thead>
			<tbody>
		<?php 	while($row = $r->fetch_assoc()){ ?>		
				<tr>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo date('d m Y', strtotime($row['start_date'])); ?></td>
					<td><?php echo date('d m Y', strtotime($row['end_date'])); ?></td>
					<td align="right"> 
						<a href="conference_v.php?id=<?php echo $row['id']; ?>" class="btn btn-default btn-120">VIEW</a>&nbsp;&nbsp;
						<a href="#" class="setActiveConference btn <?php if(isset($_SESSION['activeConference']) && $_SESSION['activeConference'] == $row['id']){ echo " btn-info disabled"; } else { echo "btn-default"; } ?> btn-120" data-conferenceId="<?php echo $row['id']; ?>">SET ACTIVE</a>
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

<div class="row">
	<h4>Past</h4>
	<div class="col-xs-12">
	<?php 	$sql = "SELECT * FROM conferences WHERE status = '0'";
			$r = $conn->query($sql);
			if($r->num_rows > 0){ ?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Conference</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th></th>
					
				</tr>
			</thead>
			<tbody>
		<?php 	while($row = $r->fetch_assoc()){ ?>		
				<tr>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo date('d m Y', strtotime($row['start_date'])); ?></td>
					<td><?php echo date('d m Y', strtotime($row['end_date'])); ?></td>
					<td align="right"> 
						<a href="conference_v.php?id=<?php echo $row['id']; ?>" class="btn btn-default btn-120">VIEW</a>&nbsp;&nbsp;
						<a href="#" class="setActiveConference btn <?php if(isset($_SESSION['activeConference']) && $_SESSION['activeConference'] == $row['id']){ echo " btn-info disabled"; } else { echo "btn-default"; } ?> btn-120" data-conferenceId="<?php echo $row['id']; ?>">SET ACTIVE</a>
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