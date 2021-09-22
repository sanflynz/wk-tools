<?php
	include("includes/sitefunctions.php");
	//include("classes/TableBuilder.php");
	include("includes/header.php");

	if($_POST){
		$p = $_POST;
		$rows = explode("\n",$p['items']);

		$priceColAU = "";
		$promoPriceColAU = "";
		$priceColNZ = "";
		$promoPriceColNZ = "";

		if($p['tabletype'] == "No Promo Price"){ $pricetype = ""; }

		//$standardCols = array("Masterpack SKU","Agile SKU","Description","Size","List Price","Promo Price","Action");
		//$standardCols = array("Web SKU","Description","Size","List Price");
		//$promoCols = array("Web SKU","Description","Size","List Price","Promo Price");

		$i = 0; // ROW NUMBER
		$n['items'] = array();
		foreach($rows as $r){
			$cells = explode("\t", $r);
			
			// HEADER ROW

			$x = 0; // COLUMN NUMBER
			if($i == 0){	
				
				$n['items'][$i][] = "Catalog number";

				foreach($cells as $c){
					$c = trim($c);
					
					if($c == "Web SKU" || $c == "Promo Price"){
						// DO NOTHING
					}
					elseif($c == "Description"){
						$descCol = $x;
						$n['items'][$i][] = $c;
					}
					elseif($c == "List Price AU"){
						$priceColAU = $x;
						
							$n['items'][$i][] = "List Price (AUD)";
												
					}
					elseif($c == "List Price NZ"){
						
						$priceColNZ = $x;
						
							$n['items'][$i][] = "List Price (NZD)";			
						
						
					}
					
					// elseif($c == "Action"){  
					// 	$n['items'][$i][] = "";
					// }
					else{
						$n['items'][$i][] = $c;
					}
					
					$x++;  // NEW COLUMN
				}
				// ACTION COLUMN
				$n['items'][$i][] = "";

				
			}
			else {	// ALL OTHER ROWS

				foreach($cells as $c){
					$c = trim($c);
					if($x == 0){
						$n['items'][$i][] = "<a href=\"https://www.thermofisher.com/order/catalog/product/" . $cells[0] . "\">" . $cells[0] . "</a>"; // LINK TO PDP
						// if(!empty($cells[0])){
							
						// }
						// else{
						// 	$n['items'][$i][] = $cells[0] . "<br><span style=\"font-size: smaller\"><strong>GoDirect:</strong> " . $cells[0] . "</span>";  // LINK TO GO DIRECT
						// }
					}
					elseif($x == $descCol){
						$c = str_replace("|","<br>",$c);
						$n['items'][$i][] = "<a href=\"https://www.thermofisher.com/order/catalog/product/" . $cells[0] . "\">" . $c . "</a>\n"; // LINK TO PDP
						
					}
					elseif($x == $priceColAU){
						// Generate the price/promo price
						$n['items'][$i][] = $cells[$priceColAU];
						
					}
					elseif($x == $priceColNZ){
						// Generate the price/promo price
						$n['items'][$i][] = $cells[$priceColNZ];
						
					}
					
					else{
						// ALL OTHER COLUMNS
						$n['items'][$i][] = $c;


					}

					$x++;  // NEW COLUMN

				}
				// ACTION COLUMN
				$n['items'][$i][] = "<a href=\"https://www.thermofisher.com/order/catalog/product/" . $cells[0] . "\">Buy now &rsaquo;</a>\n"; // LINK TO PDP

			}

			$i++;  // NEW ROW


			// echo "<pre>";
			// echo print_r($n);
			// echo "</pre>";


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
		<h1>Table Generator V3</h1>
		<br>
<?php 	flash(); ?>		
	</div>
</div>


<form method="post" role="form" class="form-horizontal">
<div class="form-group">
	<label for="country" class="col-sm-1 control-label">Country</label>
    <div class="col-sm-3">
      <select name="country" class="form-control" id="Country" disabled>
      	<option value="Australia" <?php if(isset($p) && $p['country'] == "Australia"){ echo " selected"; } ?>>Australia</option>
      	<option value="New Zealand" <?php if(isset($p) && $p['country'] == "New Zealand"){ echo " selected"; } ?>>New Zealand</option>
      </select>
    </div>
</div>
<div class="form-group">
	<label for="tabletype" class="col-sm-1 control-label">Type</label>
    <div class="col-sm-3">
      <select name="tabletype" class="form-control" id="tabletype">
      	<option value="No Promo Price" <?php if(isset($p) && $p['tabletype'] == "No Promo Price"){ echo " selected"; } ?>>No Promo Price</option>
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