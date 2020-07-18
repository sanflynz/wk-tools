<?php
	include("includes/sitefunctions.php");
	//include("classes/TableBuilder.php");
	include("includes/header.php");

	if($_POST){
		$p = $_POST;
		$rows = explode("\n",$p['items']);

		if($p['tabletype'] == "Clearance"){ $pricetype = "Clearance price"; }
		if($p['tabletype'] == "Promotion"){ $pricetype = "Promo price"; }

		//$standardCols = array("Masterpack SKU","Agile SKU","Description","Size","List Price","Promo Price","Action");

		$i = 0; // ROW NUMBER
		$n['items'] = array();
		foreach($rows as $r){
			$cells = explode("\t", $r);
			
			$x = 0; // COLUMN NUMBER
					
			if($i == 0){	// HEADER ROW
				$n['items'][$i][] = "Catalog number";
				foreach($cells as $c){
					$c = trim($c);
					
					if($c == "Masterpack SKU" ||  $c == "Agile SKU" || $c == "Promo Price"){
						// DO NOTHING
					}
					elseif($c == "Description"){
						$descCol = $x;
						$n['items'][$i][] = $c;
					}
					elseif($c == "List Price"){
						$priceCol = $x;
						if($p['country'] == "Australia"){
							$n['items'][$i][] = "Price (AUD)";
						}
						else{
							$n['items'][$i][] = "Price (NZD)";
						}
						
					}
					elseif($c == "Action"){  
						$n['items'][$i][] = "";
					}
					else{
						$n['items'][$i][] = $c;
					}
					
					$x++;  // NEW COLUMN
				}
				
			}
			else {	// ALL OTHER ROWS

				foreach($cells as $c){
					$c = trim($c);
					if($x == 0){
						if(!empty($cells[1])){
							$n['items'][$i][] = "<a href=\"https://www.thermofisher.com/order/catalog/product/" . $cells[1] . "\">" . $cells[1] . "</a><br><span style=\"font-size: smaller\"><strong>GoDirect:</strong> " . $cells[0] . "</span>"; // LINK TO PDP
						}
						else{
							$n['items'][$i][] = $cells[0] . "<br><span style=\"font-size: smaller\"><strong>GoDirect:</strong> " . $cells[0] . "</span>";  // LINK TO GO DIRECT
						}
					}
					elseif($x == 1){ 
						// SKIP
					}
					elseif($x == $descCol){
						$c = str_replace("|","<br>",$c);
						if(!empty($cells[1])){

							$n['items'][$i][] = "<a href=\"https://www.thermofisher.com/order/catalog/product/" . $cells[1] . "\">" . $c . "</a>\n"; // LINK TO PDP
						}
						else{
							$n['items'][$i][] = $c;  // LINK TO GO DIRECT
						}
					}
					elseif($x == $priceCol){
						// Generate the price/promo price
						// what if request quote
						$n['items'][$i][] = "<div class=\"price-group\">\n\t\t\t\t\t\t\t<div class=\"price price-list\">\n\t\t\t\t\t\t\t\t<span class=\"price-amount\">" . $cells[$priceCol] . "</span>\n\t\t\t\t\t\t\t</div>\n\n\t\t\t\t\t\t\t<div class=\"price price-web\">\n\t\t\t\t\t\t\t\t<span class=\"price-amount\">" . $pricetype . ": " . $cells[$priceCol+1] . "</span>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>\n";
					}
					elseif($x == ($priceCol + 1)){
						// SKIP

					}
					else{
						// ALL OTHER COLUMNS
						if($c == "[BUY]" && $p['country'] == "Australia"){
							$c = "<a href=\"https://www.thermofisher.com.au/godirect/main/displaysearchitems.aspx?gsearch=" . $cells[0] ."\" target=\"_blank\">Buy on<br><span style=\"white-space: nowrap;\">GoDirect &rsaquo;</span></a>";
						}
						if($c == "[BUY]" && $p['country'] == "New Zealand"){
							$c = "<a href=\"https://www.thermofisher.co.nz/godirect/main/displaysearchitems.aspx?gsearch=" . $cells[0] ."\" target=\"_blank\">Buy on<br><span style=\"white-space: nowrap;\">GoDirect &rsaquo;</span></a>";
						}
						if($c == "[REQUEST QUOTE]" && $p['tabletype'] == "Promotion"){
							$c = "<a href=\"https://www.thermofisher.com/au/en/home/global/forms/anz/request-information-promo-anz.html?C_Product_of_Interest1=" . $cells[0] . "\">Request <span style=\"white-space: nowrap;\">quote &rsaquo;</span></a>";
						}
						if($c == "[REQUEST QUOTE]" && $p['tabletype'] == "Clearance"){
							$c = "<a href=\"https://www.thermofisher.com/au/en/home/global/forms/anz/request-information-clearance-anz.html?C_Product_of_Interest1=" . $cells[0] . "\">Request <span style=\"white-space: nowrap;\">quote &rsaquo;</span></a>";
						}
						if($c == "[QUOTE ANCHOR]"){
							$c = "<a href=\"#requestquote\">Request <span style=\"white-space: nowrap;\">quote &rsaquo;</span></a>";
						}

						$n['items'][$i][] = $c;


					}

					$x++;  // NEW COLUMN

				}

			}

			$i++;  // NEW ROW


			$content = "";
			$content .= "<div class=\"scrollable-table-container\">\n";
			$content .= "\t<div class=\"scrollable-table\">\n";
			$content .= "\t\t<table class=\"productlist-mobile-collapse table-mobile-collapse table table-bordered table-list table-striped\">\n";
			
			$i = 0;
			foreach($n["items"] as $r){
				if($i == 0){ // HEADER ROW

					$content .= "\t\t\t<thead>\n";
					$content .="\t\t\t\t<tr>\n";
					foreach($r as $c){
						$c = trim($c);
						switch($c) {
							case "Catalog number":
								$class = "table-list-sku";
								break;
							case "Size":
								$class = "table-list-size";	
								break;
							case "Price":
								$class = "table-list-price";
								break;
							default:
								$class = "";

						}
						$content .="\t\t\t\t\t<th class=\"$class\">$c</th>\n";
					}

					$content .="\t\t\t\t</tr>\n";
					$content .= "\t\t\t</thead>\n";
					$content .= "\t\t\t<tbody>\n";
				}
				else{	// ALL OTHER ROWS
					$content .="\t\t\t\t<tr>\n";
					foreach($r as $c){
						$content .="\t\t\t\t\t<td>\n\t\t\t\t\t\t$c\n\t\t\t\t\t</td>\n";

					}
					$content .="\t\t\t\t</tr>\n";
				}

				$i++;
			}

			$content .= "\t\t\t</tbody>\n";
			$content .= "\t\t</table>\n";
			$content .= "\t</div>\n";
			$content .= "</div>";

			



		}

		// echo "<pre>";
		// print_r($n);
		// echo "</pre>";


		// $table = new TableBuilder($p['items'],array("table", "table-bordered", "table-hover", "table-promo"),"fixed");
		// $content = $table->build();


	}

	

?>
<style>
.promoContainer{
	width: 950px;
}

.promoCon

.promoContainer .productlist-mobile-collapse.table-mobile-collapse {
    border-collapse: separate;
}

.promoContainer .table-bordered {
    border: 1px solid #dddddd;
    border-left: 0;
}

.promoContainer .table {
    max-width: 100%;
    margin-bottom: 22px;
    background-color: transparent;
}

.promoContainer .table-bordered caption + thead tr:first-child th, .promoContainer  .table-bordered caption + tbody tr:first-child th, .promoContainer  .table-bordered caption + tbody tr:first-child td, .promoContainer  .table-bordered colgroup + thead tr:first-child th, .promoContainer  .table-bordered colgroup + tbody tr:first-child th, .promoContainer  .table-bordered colgroup + tbody tr:first-child td, .promoContainer  .table-bordered thead:first-child tr:first-child th, .promoContainer  .table-bordered tbody:first-child tr:first-child th, .promoContainer  .table-bordered tbody:first-child tr:first-child td {
    border-top: 0;
}

.promoContainer .table-list th:first-child, .promoContainer .table-list td:first-child {
    border-left: 1px solid #dddddd;
}

.promoContainer .table-bordered thead tr th {
    background-color: #ffffff;
    vertical-align: bottom;
}

.promoContainer .price {
    word-break: break-word;
    white-space: normal;
    display: block;
    line-height: 16px;
    margin-top: 10px;
}

.promoContainer .price-web .price-amount {
    font-weight: bold;
}

.promoContainer .price-web .price-amount, .promoContainer .price-your .price-amount {
    text-decoration: none;
    color: #7fba00;
}
</style>

<div class="row">
	<div class="col-xs-12">
		<h1>Promo Table Generator</h1>
		<br>
<?php 	flash(); ?>		
	</div>
</div>


<form method="post" role="form" class="form-horizontal">
<div class="form-group">
	<label for="country" class="col-sm-1 control-label">Country</label>
    <div class="col-sm-3">
      <select name="country" class="form-control" id="Country">
      	<option value="Australia" <?php if(isset($p) && $p['country'] == "Australia"){ echo " selected"; } ?>>Australia</option>
      	<option value="New Zealand" <?php if(isset($p) && $p['country'] == "New Zealand"){ echo " selected"; } ?>>New Zealand</option>
      </select>
    </div>
</div>
<div class="form-group">
	<label for="tabletype" class="col-sm-1 control-label">Type</label>
    <div class="col-sm-3">
      <select name="tabletype" class="form-control" id="tabletype">
      	<option value="Promotion">Promotion</option>
      	<option value="Clearance">Clearance</option>
      </select>
    </div>
</div>
<div class="form-group">
	<label for="icid" class="col-sm-1 control-label">ICID</label>
    <div class="col-sm-3">
      <input type="text" name="icid" id="icid" class="form-control" value="" disabled>
   
    </div>
</div>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10" style="padding-left: 5px">
		<textarea name="items" id="items" cols="30" rows="10" class="form-control"><?php if(isset($p['items'])) {echo htmlentities($p['items']); } ?></textarea>
		<br>
		<button type="submit" class="btn btn-danger">Generate table</button>
	</div>
</div>

</form>

<?php 	
	if(!empty($p['items'])){  ?>
<hr>

<button type="button" id="copyCode" class="btn btn-sm btn-success" style="margin-bottom: 10px;">Copy code</button> <span id="copyMessage" style="display: none;">Code Copied!</span>
<div class="promoContainer">
	

<?php echo $content; ?>

			

</div><br><br>


<div style="width: 100%;">
	<pre><code class="html" id="theCode"><?php print htmlentities($content); ?></code></pre>
</div>

<textarea name="code" id="codePen" cols="1" rows="1" ><?php echo $content; ?></textarea>
<?php	
	}
?>


<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script>
	$(document).ready(function(){
		$('#copyCode').click(function(){
			/* Get the text field */
			  var copyText = document.getElementById("codePen");

			  /* Select the text field */
			  copyText.select();
			  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

			  /* Copy the text inside the text field */
			  document.execCommand("copy");

			  /* Alert the copied text */
			  //alert("Copied the text: " + copyText.value);
			  $('#copyMessage').show().delay(2000).fadeOut();

		});
	});
</script>

<?php


	include("includes/footer.php");

?>