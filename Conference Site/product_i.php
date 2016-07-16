<?php 

include("includes/db.php");
include("classes/Pagination.php");
include("includes/header.php");


// get the pages and stuff later
	$page = ( isset($_GET['page'])) ? $_GET['page'] : 1;
	$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 50;

	$sql = "SELECT brands.name as bName, products.name as pName, brands.*,products.* FROM products LEFT JOIN brands ON products.brand_id = brands.id ORDER BY brands.name,products.name";
	$Pagination  = new Pagination( $conn, $sql );
	$results = $Pagination->getData( $limit, $page );

?>

			<h1 class="text-center">Products</h1>

			<div class="row">
				<?php echo $Pagination->total; ?> Records Found<br>
				<?php $Pagination->showLinks = 3; ?>
				<?php echo $Pagination->buildLinks(); ?>
			</div>
		
			<div class="row">
				
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Brand Name</th>
							<th>Product Name</th>
							<th></th>
							<th width="50">Content</th>
							<th width="50">Questions</th>
							<th width="50">Specialist</th>
							<th width="50">Redirect</th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>

			<?php 	foreach($results->data as $r){ ?>			
						<tr>
							<td><a name="<?php echo $r['id']; ?>"></a><?php echo $r['bName']; ?></td>
							<td><?php echo $r['pName']; ?></td>
							<td><?php echo $r['country']; ?></td>
							<td align="center">
							<?php 	if($r['name'] && $r['heading'] && $r['btn_landing'] && $r['btn_email'] && $r['btn_email_link'] && $r['desc_landing'] && $r['desc_email'] && $r['findoutmore']){
										echo "<span class='glyphicon glyphicon-ok' aria-hidden='true' style='color: green;'></span>";
									}
									else{	
										echo "<span class='glyphicon glyphicon-remove' aria-hidden='true' style='color: red;'></span>";
									}			?>	
							</td>
							<td align="center">
							<?php 	if($r['questions']){
										echo "<span class='glyphicon glyphicon-ok' aria-hidden='true' style='color: green;'></span>";
									}
									else{	
										echo "<span class='glyphicon glyphicon-remove' aria-hidden='true' style='color: red;'></span>";
									}			?>		

							</td>
							<td align="center">
							<?php 	if($r['specialist_email']){
										echo "<span class='glyphicon glyphicon-ok' aria-hidden='true' style='color: green;'></span>";
									}
									else{	
										echo "<span class='glyphicon glyphicon-remove' aria-hidden='true' style='color: red;'></span>";
									}			?>		

							</td>
							<td align="center">
								<?php 	if($r['redirect_url']){
										echo "<span class='glyphicon glyphicon-ok' aria-hidden='true' style='color: green;'></span>";
									}
									else{	
										echo "<span class='glyphicon glyphicon-remove' aria-hidden='true' style='color: red;'></span>";
									}			?>	

							</td>
							<td style="width: 50px;"><a href="product_e.php?id=<?php echo $r['id']; ?>" class="btn btn-info" style="width: 100%"><i class="fa fa-pencil"></i></a></td>
							<td style="width: 50px;"><a href="makesign2.php?product=<?php echo $r['id']; ?>" target="_blank" class="btn btn-default" style="width: 100%"><i class="fa fa-file-o"></i></a></td>
							<td style="width: 50px;"><a href="landingpage.php?id=<?php echo $r['id']; ?>" target="_blank" class="btn btn-default" style="width: 100%"><i class="fa fa-file-text-o"></i></a></td>
							<td style="width: 50px;"><a href="email.php?id=<?php echo $r['id']; ?>" target="_blank" class="btn btn-default" style="width: 100%"><i class="fa fa-envelope-o"></i></a></td>
						</tr>
			<?php 	} ?>			
					</tbody>
				</table>
			</div>
		
<?php include("includes/footer.php"); ?>		