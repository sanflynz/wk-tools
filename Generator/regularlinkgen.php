<?php include "./includes/header.php";

	if(isset($_POST['submit'])){

		$link = "<a href=\"" . rawurldecode($_POST['link']) . "\"";
		if($_POST['tab'] == "new"){
			$link .= " target=\"_blank\"";
		}
		if($_POST['style'] != "standard"){
			$link .= " class=\"" . $_POST['style'] . "\"";
		}

		if($_POST['category']){
			$link .= " onClick=\"_gaq.push(['_trackEvent', '" . $_POST['category'] ."', '" . $_POST['action'] ."', '" . $_POST['label'] ."']);\"";
		}

		$link .= ">" . $_POST['text'] . "</a>";
		
		//$link .= "EnquiryType=" . rawurlencode($_POST['EnquiryType']);
		//$link .= "&ProductCode=" . rawurlencode($_POST['ProductCode']);
		//if(isset($_POST['email'])){
			//$link .= "&email=" . $_POST['email'];
		//}

		
	}

?>

<h1>Regular Link Generator</h1>
<br>
Generates a full HTML link to use in your other pages where they are not automatically generated<br>

<br>
<form method="post" role="form">
	
<table class="table" style="width: 50%">
	<tr>
		<td align="right" valign="middle"><strong>URL</strong></td>
		<td>
			<input type="text" name="link" class="form-control" required value="<?php if(isset($_POST['submit'])){ echo $_POST['link']; }  ?>">
		</td>
		<td></td>
	</tr>
	<tr>
		<td align="right" valign="middle"><strong>Text</strong></td>
		<td>
			<input type="text" name="text" class="form-control" required value="<?php if(isset($_POST['submit'])){ echo $_POST['text']; }  ?>">
		</td>
		<td></td>
	</tr>
	<tr>
		<td align="right" valign="middle"><strong>Tab</strong></td>
		<td>
			<select name="tab" id="" class="form-control">
				<option value="parent" <?php if(isset($_POST['tab']) && $_POST['tab'] == "parent"){ echo "selected"; }  ?>>Parent</option>
				<option value="new" <?php if(isset($_POST['tab']) && $_POST['tab'] == "new"){ echo "selected"; }  ?>>New</option>
			</select>
		</td>
		<td><a href="#" class="btn btn-primary"><i class="fa fa-info"></i></a></td>
	</tr>
	<tr>
		<td align="right" valign="middle"><strong>Style</strong></td>
		<td>
			<select name="style" id="" class="form-control">
				<option value="standard" <?php if(isset($_POST['style']) && $_POST['style'] == "standard"){ echo "selected"; }  ?>>Standard</option>
				<option value="btn btn-featured" <?php if(isset($_POST['style']) && $_POST['style'] == "btn btn-featured"){ echo "selected"; }  ?>>Featured</option>
				<option value="btn btn-primary" <?php if(isset($_POST['style']) && $_POST['style'] == "btn btn-primary"){ echo "selected"; }  ?>>Primary</option>
				<option value="btn btn-default" <?php if(isset($_POST['style']) && $_POST['style'] == "btn btn-default"){ echo "selected"; }  ?>>Default</option>
				<option value="btn btn-commerce" <?php if(isset($_POST['style']) && $_POST['style'] == "btn btn-commerce"){ echo "selected"; }  ?>>Commerce</option>
			</select>
		</td>
		<td><a href="#" class="btn btn-primary"><i class="fa fa-info"></i></a></td>
	</tr>

	<tr>
		<td colspan="2">Optional: Add some event tracking?</td>
		<td><a href="#" class="btn btn-primary"><i class="fa fa-info"></i></a></td>
	</tr>

	<tr>
		<td align="right" valign="middle"><strong>Category</strong></td>
		<td>
			<input type="text" name="category" class="form-control" value="<?php if(isset($_POST['submit']) && isset($_POST['category'])){ echo $_POST['category']; }  ?>">
		</td>
	</tr>
	<tr>
		<td align="right" valign="middle"><strong>Action</strong></td>
		<td>
			<input type="text" name="action" class="form-control" value="<?php if(isset($_POST['submit']) && isset($_POST['action'])){ echo $_POST['action']; }  ?>">
		</td>
	</tr>
	<tr>
		<td align="right" valign="middle"><strong>Label</strong></td>
		<td>
			<input type="text" name="label" class="form-control" value="<?php if(isset($_POST['submit']) && isset($_POST['label'])){ echo $_POST['label']; }  ?>">
		</td>
	</tr>
	
	
	
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Generate Link" class="btn btn-success"></td>
	</tr>
</table>
</form>
<?php 	if(isset($link)){ ?>
			<h4>Generated Link:</h4>
			<code><?php echo htmlentities($link); ?></code>
<?php	} ?>



<?php include "./includes/footer.php"; ?>