<?php include "./includes/header.php";

	if(isset($_POST['submit'])){
		
		if($_POST['country'] == "nz"){
			$link = "http://info.thermofisher.co.nz/productrequest?";
		}
		elseif($_POST['country'] == "au"){
			$link = "http://info.thermofisher.com.au/productrequest?";
		}
		$link .= "lt=" . rawurlencode($_POST['LeadType']);
		$link .= "&pn=" . rawurlencode($_POST['ProductName']);
		$link .= "&bu=" . rawurlencode($_POST['BusinessUnit']);
		$link .= "&pt=" . rawurlencode($_POST['ProductType']);
		

		if(isset($_POST['CampaignId']) && $_POST['CampaignId'] != ""){
			$link .= "&cid=" . $_POST['CampaignId'];
		}

		
	}

?>

<h1>Request Link Generator</h1>
<br>
Generates the link to the AU or NZ basic "Request" form.  Anything more complex will require a custom form.<br>
Requests are sent to Salesforce via the leads module.  If no campaign is selected they will be added to campaign "MKT-WEB-Dynamic Lead Form"<br>
<a href="https://ap4.salesforce.com/00O6F00000B3nTF" target="_blank">See submissions to leads module here</a><br>
<br>
<?php 	if(isset($link)){ ?>
<div class="alert alert-success">
	<h4>Generated Link:</h4>
	<a href="<?php echo $link; ?>" target="_blank"><?php echo $link; ?></a>
</div>
<br>			
<?php	} ?>

<form method="post" role="form">
	
<table class="table" style="width: 50%">
	<tr>
		<td align="right" valign="middle"><strong>Country</strong></td>
		<td>
			<select name="country" id="" class="form-control" required>
				<option value=""></option>
				<option value="nz" <?php if(isset($link) && $_POST['country'] == "nz"){ echo "selected"; }  ?>>New Zealand</option>
				<option value="au" <?php if(isset($link) && $_POST['country'] == "au"){ echo "selected"; }  ?>>Australia</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Campaign ID</strong></td>
		<td><input type="text" name="CampaignId" class="form-control" value="<?php if(isset($link)){ echo $_POST['CampaignId']; }  ?>"></td>
	</tr>
	<tr>
		<td align="right"><strong>Product Type</strong></td>
		<td>
			<select name="ProductType" id="ProductType" class="form-control" required>
				<option value=""></option>
				<option value="Consumable" <?php if(isset($link) && $_POST['ProductType'] == "Consumable"){ echo "selected"; }  ?>>Consumable</option>
				<option value="Reagent" <?php if(isset($link) && $_POST['ProductType'] == "Reagent"){ echo "selected"; }  ?>>Reagent</option>
				<option value="Equipment" <?php if(isset($link) && $_POST['ProductType'] == "Equipment"){ echo "selected"; }  ?>>Equipment</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Business Unit</strong></td>
		<td>
			<select name="BusinessUnit" id="BusinessUnit" class="form-control">
				<option value=""></option>
				<option value="SCI" <?php if(isset($link) && $_POST['BusinessUnit'] == "SCI"){ echo "selected"; }  ?>>SCI</option>
				<option value="HTC" <?php if(isset($link) && $_POST['BusinessUnit'] == "HTC"){ echo "selected"; }  ?>>HTC</option>
				<option value="EIP" <?php if(isset($link) && $_POST['BusinessUnit'] == "EIP"){ echo "selected"; }  ?>>EIP</option>
				<option value="LSG" <?php if(isset($link) && $_POST['BusinessUnit'] == "LSG"){ echo "selected"; }  ?>>LSG</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Lead Type</strong></td>
		<td>
			<select name="LeadType" id="" class="form-control" required>
				<option value=""></option>
				<option value="Sales Request" <?php if(isset($link) && $_POST['LeadType'] == "Sales Request"){ echo "selected"; }  ?>>Request Information</option>
				<option value="Quote Request" <?php if(isset($link) && $_POST['LeadType'] == "Quote Request"){ echo "selected"; }  ?>>Request Quote</option>
				<option value="Demo Request" <?php if(isset($link) && $_POST['LeadType'] == "Demo Request"){ echo "selected"; }  ?>>Request Demo</option>
				<option value="Sample Request" <?php if(isset($link) && $_POST['LeadType'] == "Sample Request"){ echo "selected"; }  ?>>Request Sample</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Product Name</strong></td>
		<td><input type="text" name="ProductName" class="form-control" required value="<?php if(isset($link)){ echo $_POST['ProductName']; }  ?>"></td>
	</tr>
	
	
	
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Generate Link" class="btn btn-success"></td>
	</tr>
</table>
</form>

<br>
<br>



<?php include "./includes/footer.php"; ?>