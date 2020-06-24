<?php 

//include("includes/db.php");
//include("includes/db.php");
include("includes/header_web_au.php"); 
include("classes/TableBuilder.php");



if($_POST){
	$p = $_POST;
	//print_r($p);
	$rows = explode("\n",$p['items']);

}


?>
<style>
	hr {
		border-top: 1px solid #F3F3F3
	}
</style>

<h1>Table Builder Plain</h1>	

<form method="post" role="form">

	<textarea name="items" style="border: 1px solid #DDD; width: 100%; border-radius: 2px; color: #6d6d6d; padding: 5px;" rows="10"><?php if(isset($p['items'])) {echo htmlentities($p['items']); } ?></textarea> <br>
	<br>
	<button class="btn btn-commerce" type="submit" formaction="table-generator-plain.php">Generate table</button>
</form>
<br>
<hr>
<br>






<?php 	
	if(!empty($p['items'])){ 
		$table = new TableBuilder($p['items'],array("rte-table-striped"));
		$content = $table->buildPlain();
		echo $content;

		?>

		

		<div style="width: 100%;">
			<pre><code class="html" id="thecode"><?php print htmlentities($content); ?></code></pre>
		</div>
<?php	
	}
?>
	<br>

<br />
<hr>
<h3>Table Instructions</h3>

Copy from a spreadsheet. It will automatically recognise cells and new rows <br>
<br>



<script>
document.addEventListener("DOMContentLoaded", hideSide);
function hideSide(){
    $("#side").hide();
}    



</script>


<?php

include("includes/footer_web_au.php"); ?>