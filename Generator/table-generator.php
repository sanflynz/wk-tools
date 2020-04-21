<?php 

//include("includes/db.php");
//include("includes/db.php");
include("includes/header_web_au.php"); 
include("classes/TableBuilder.php");


$p['page-width'] = "nav-width";

if($_POST){
	$p = $_POST;
	$rows = explode("\n",$p['items']);

}


?>
<style>
	hr {
		border-top: 1px solid #F3F3F3
	}
</style>
<h1>Table Builder</h1>	
<form method="post" role="form">
<b>Width: </b> <select name="page-width">
	<option value="nav-width">nav-width</option>
	<option value="full-width" selected>full-width</option>
</select>
&nbsp;&nbsp;<b>Country*: </b><select name="country">
	<option value=""></option>
	<option value="Australia" <?php if(isset($p['country']) && $p['country'] == "Australia"){ echo " selected "; } ?>>Australia</option>
	<option value="New Zealand" <?php if(isset($p['country']) && $p['country'] == "New Zealand"){ echo " selected "; } ?>>New Zealand</option>
</select>
&nbsp;&nbsp;<b>SFDC Campaign ID*:</b> <input type="text" name="campaignid" style="border: 1px solid #DDD; border-radius: 2px; color: #6d6d6d; padding: 2px;" maxlength="15" value="<?php if(isset($p['campaignid'])){ echo $p['campaignid']; } ?>">
<br>
<span style="font-style: italic;">* required for [Request quote]</span>
<br>

	<textarea name="items" style="border: 1px solid #DDD; width: 100%; border-radius: 2px; color: #6d6d6d; padding: 5px;" rows="10"><?php if(isset($p['items'])) {echo htmlentities($p['items']); } ?></textarea> <br>
	<br>
	<button class="btn btn-commerce" type="submit" formaction="table-generator.php">Generate table</button>
</form>
<br>
<hr>
<br>
<div class="<?php echo $p['page-width'];?>">







<?php 	
	if(!empty($p['items'])){ 
		echo "<div class='" . $p['page-width'] . "'>";
		$table = new TableBuilder($p['items'],array("table", "table-bordered", "table-hover", "table-promo"),"fixed");
		$table->country = $p['country'];
		$table->campaignid = $p['campaignid'];
		$content = $table->build();
		echo $content;

		echo "</div><br><br>"; ?>

		<div style="width: 100%;">
			<pre><code class="html" id="thecode"><?php print htmlentities($content); ?></code></pre>
		</div>
<?php	
	}
?>
	<br>


</div>
<br />
<hr>
<h3>Table Instructions</h3>

Copy from a spreadsheet. It will automatically recognise cells and new rows <br>
<br>
If you want to link to the Search page on the Item Code and Description ensure the first two column headings are "Item Code" and "Description" exactly <br>
<br>
Column Widths... add eg: [25%] directly after the column heading name to set eg: Item Code[25%] <br>
<br>
Column Alignment... add [center], [left], or [right], after the column heading name to align eg: Temp Range[center] <br>
<br>
'Login to buy' button... Add [BUY] to the last column in each row in your spreadsheet. Leave the header row blank. Requires 'Item Code' in at least one column. <br>
<br>
If you want to break out into multiple tables use Groups:<br>
Groups...<br>
[GROUP][HEADING]Heading/Title Here<br>
Table header row<br>
Items<br>
Items<br>
[GROUP][HEADING]Heading/Title Here<br>
Table header row<br>
Items<br>
Items<br>


<script>
document.addEventListener("DOMContentLoaded", hideSide);
function hideSide(){
    $("#side").hide();
}    
</script>


<?php

include("includes/footer_web_au.php"); ?>