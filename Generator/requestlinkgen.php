<?php include "./includes/header.php";

	if(isset($_POST['submit'])){
		
		if($_POST['country'] == "nz"){
			$link = "http://info.thermofisher.co.nz/productrequest?";
		}
		elseif($_POST['country'] == "au"){
			$link = "http://info.thermofisher.com.au/productrequest?";
		}
		$link .= "EnquiryType=" . rawurlencode($_POST['EnquiryType']);
		$link .= "&ProductCode=" . rawurlencode($_POST['ProductCode']);
		if(isset($_POST['email'])){
			$link .= "&email=" . $_POST['email'];
		}

		
	}

?>

<h1>Request Link Generator</h1>
<br>
Generates the link to the AU or NZ basic "Request" form.  Anything more complex will require a custom form.<br>
Unless otherwise specified will send request to NZinfo@thermofisher.com or AUinfo@thermofisher.com.<br>
<a href="https://ap4.salesforce.com/00O6F00000B3nTF" target="_blank">See submissions to Case Queue email addresses here</a><br>
<br>
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
		<td align="right"><strong>Enquiry Type</strong></td>
		<td>
			<select name="EnquiryType" id="" class="form-control" required>
				<option value=""></option>
				<option value="Request Information" <?php if(isset($link) && $_POST['EnquiryType'] == "Request Information"){ echo "selected"; }  ?>>Request Information</option>
				<option value="Request Quote" <?php if(isset($link) && $_POST['EnquiryType'] == "Request Quote"){ echo "selected"; }  ?>>Request Quote</option>
				<option value="Request Demo" <?php if(isset($link) && $_POST['EnquiryType'] == "Request Demo"){ echo "selected"; }  ?>>Request Demo</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Product Code</strong></td>
		<td><input type="text" name="ProductCode" class="form-control" required value="<?php if(isset($link)){ echo $_POST['ProductCode']; }  ?>"></td>
	</tr>
	<tr>
		<td align="right"><strong>Email To<br></strong><span class="font-size: 8px;">(optional)</span></td>
		<td><input type="email" name="email" class="form-control" id="" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; }  ?>"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Generate Link" class="btn btn-success"></td>
	</tr>
</table>
</form>
<?php 	if(isset($link)){ ?>
			<h4>Generated Link:</h4>
			<a href="<?php echo $link; ?>" target="_blank"><?php echo $link; ?></a>
<?php	} ?>



<?php include "./includes/footer.php"; ?>