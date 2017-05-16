<?php

include("includes/db.php");


if($_POST){

	// print '<pre>'; 
	// print_r($_POST);
	// print '</pre>';
	$fieldNames = "offer,offer_detail,tagline,call_to_action,url,image,promo_name,item_name,order";
	$fields = "";
	$values = "";
	foreach($_POST['data'] as $p){

		$i = 1;
		foreach(explode(",", $fieldNames) as $f){
			$values .= "`" . addslashes($f) . "`" . "='" . addslashes($p[$f]) . "'";
			if($i < count(explode(",",$fieldNames))){
				$values .= ",";
			}
			$i++;
		}
		$sql = "UPDATE webpromopods SET $values WHERE id = " . $p['id'];
		//echo $sql;
		$r = $conn->query($sql);
		if($r){
			// redirect
			header("location: promopods_au_v.php?site=" . $_POST['country'] . "&title=" . urlencode($_POST['title']));
		}
		else{
			$error = "Unable to update promo page: " . $conn->error;
		}

	}
}



$sql = "SELECT * FROM webpromopods";
$r = $conn->query($sql);

// code here


include("includes/header.php"); ?>
	
<div class="row">
	<div class="col-xs-12">
		<h1>Promo Pods</h1>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<br>
		Buttons:  Clear All  |  Upload  |  Download  | template<br>
		<br>
	</div>
</div>

<form method="post" enctype="multipart/form-data">
	
<table class="table">
	<tr>
		<td width="250" align="right"><strong>Country</strong></td>
		<td>
			<select name="country" id="" class="form-control" required style="width: 40%">
				<option></option>
				<option value="au" <?php if(isset($_GET['site']) && strtolower($_GET['site']) == "au") {echo " selected"; } ?> >Australia</option>
				<option value="nz" <?php if(isset($_GET['site']) && strtolower($_GET['site']) == "nz") {echo " selected"; } ?>>New Zealand</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Title</strong></td>
		<td>
			<input type="text" class="form-control" id="title" value="<?php if(isset($_GET['title'])){ echo $_GET['title']; } ?>" name="title" style="width: 40%">
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Pods</strong></td>
		<td>
		<table class="table">
			<tr>
				<th>Offer</th>
				<th>Offer Detail</th>
				<th>Tagline</th>
				<th>Call To Action</th>
				<th>URL</th>
				<th>Image</th>
				<th>Promo Name</th>
				<th>Item Name</th>
				<th>Order</th>
			</tr>
<?php 	$i = 0;
		while($row = $r->fetch_assoc()){
			//print_r($row);
		 ?>
			<tr>
				<td>
					<input type="hidden" name="data[<?php echo $i; ?>][id]" value="<?php echo $row['id']; ?>">
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][offer]" value="<?php echo str_replace('"', '&quot;', $row['offer']); ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][offer_detail]" value="<?php echo $row['offer_detail']; ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][tagline]" value="<?php echo $row['tagline']; ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][call_to_action]" value="<?php echo htmlentities($row['call_to_action']); ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][url]" value="<?php echo $row['url']; ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][image]" value="<?php echo $row['image']; ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][promo_name]" value="<?php echo $row['promo_name']; ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][item_name]" value="<?php echo $row['item_name']; ?>">
				</td>
				<td>
					<input type="text" class="form-control" name="data[<?php echo $i; ?>][order]" value="<?php echo $row['order']; ?>" size="2">
				</td>
			</tr>
<?php		$i++;
		}
	

?>			</table>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" class="btn btn-success" value="View Pods"></td>
	</tr>
</table>

</form>

<?php



include("includes/footer.php");
	

?>