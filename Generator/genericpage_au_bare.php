<?php 

//include("includes/db.php");

$sql = "SELECT * FROM `webgenericpages` p WHERE p.id = " . $_GET['id'];
$r = $conn->query($sql);
$p = $r->fetch_assoc();

$features = explode("\n",$p['features']);
$items = explode("\n",$p['items']);
$resources = explode("\n",$p['resources']);
$related = explode("\n",$p['related']);


if($p['country'] == "New Zealand"){
	$sURL = "http://www.thermofisher.co.nz/search.aspx?search=";
	$gURL = "https://www.thermofisher.co.nz/godirect/main/productdetails.aspx?id=";
}
elseif($p['country'] == "Australia"){
	$sURL = "http://www.thermofisher.com.au/search.aspx?search=";
	$gURL = "https://www.thermofisher.com.au/godirect/main/productdetails.aspx?id=";
}

?>

<link rel="stylesheet" type="text/css" href="http://uat.thermofisher.com.au/css/level-page-updates.css">
<!-- CONTENT BEGINS -->
<div class="full-width">
<h1><?php echo $p['title']; ?></h1>

<table class="table-hdi">
  <tr>
    <td>
		<img src="<?php echo $p['image']; ?>" width="230" alt=""/>
		<div>
			<?php if($p['description']){ echo nl2br($p['description']) . "\n"; } ?>
		</div>
    </td>
  </tr>
</table>
	
<?php 	if(!empty($p['items'])){ ?>
	
	<?php
		$rows = explode("\n", $p['items']);
		$t = 0;
		$r = 1;
		foreach($rows as $row){
			// Is this the start of a group?
			$cells = explode("\t", $row);
			if(preg_match('[GROUP]', $row)){
				if($t > 0){
					// this should be the end of the previous table				
					echo "\t\t</tbody>\n";
					echo "\t</table>\n";
					$r = 1;

				}
				
				if(preg_match('[HEADING]', $row)){
					echo "\t<h3>" . trim(str_replace("[GROUP][HEADING]", "", $row)) . "</h3>\n";
				}
				
				//echo "\t<table class=\"table table-bordered table-hover\">\n";

			}
			else{
				if($r == 1){ 
					echo "\t<table class=\"table table-bordered table-hover table-products\">\n";
					echo "\t\t<thead>\n";
					echo "\t\t\t<tr>\n";

					$i = 0;
					foreach($cells as $c){
						$style = "";
						// does it have a width?
						if(preg_match('/[0-9]+%/',$c,$w)){
	        				$width = $w[0];
	        				// remove the reference
	        				$c = preg_replace('/\[([0-9]+%)\]/','',$c);
	        				$style .= "width: " . $w[0] . "; ";
	        			}

	        			// right align price
	        			if(preg_match('/price/i', $c)){
							$style .= "padding-right: 20px; text-align: right;";						
						}
						if(preg_match('/Unit/i', $c) || preg_match('/Size/i', $c)){
							$style .= "text-align: center;";
						}

						// For styling child rows later, what is the header called?
						$h[$i] = $c;
						$i++;					

						echo "\t\t\t\t<th style=\"". $style . "\">" . trim($c) . "</th>\n";
					}

					echo "\t\t\t</tr>\n";
					echo "\t\t</thead>\n";
					echo "\t\t<tbody>\n";

					
				}
				else {
					echo "\t\t\t<tr>\n";
					$i = 0;
					foreach($cells as $c){	
						$style = "";				
						if(trim($h[0]) == "Item Code" && $i == "0"){
							$c = "<a href=\"" . $sURL . $c . "#gsc.tab=0&gsc.q=" . trim($c) . "\" onClick=\"_gaq.push(['_trackEvent', 'Product Search Link', 'Item Code', '" . $c . "']);\">" . trim($c) . "</a>";
						}
						if(trim($h[0]) == "Item Code" && trim($h[1]) == "Description" && $i == "1"){
							$c = "<a href=\"" . $sURL . $cells[0] . "#gsc.tab=0&gsc.q=" . $cells[0] . "\"  onClick=\"_gaq.push(['_trackEvent', 'Product Search Link', 'Item Code', '" . trim($cells[0]) . "']);\">" . trim($c) . "</a>";
						}
						if((preg_match('/Unit/i', $h[$i]) || preg_match('/Size/i', $h[$i])) && $cells[$i] == $c){
							$style .= "text-align: center;";
						}
						if(preg_match('/price/i', $h[$i]) && $cells[$i] == $c){
							$style .= "padding-right: 20px; text-align: right;";
							//$c = str_replace("$", "$ ", $c);
						}
						if(preg_match('/BUY./', $c)){
							$buy = explode('|',$c);
							$c = "<a href=\"" . $gURL . $buy[1] . "\" class=\"btn btn-commerce btn-mini\" target=\"_blank\" onClick=\"_gaq.push(['_trackEvent', 'Product Buy Link', 'Item Code', '" . trim($c) . "']);\">Login to buy</a>";
							$style .= "text-align: center;";
							
						}
						echo "\t\t\t\t<td style=\"" . $style . "\">\n\t\t\t\t\t" . trim($c) . "\n\t\t\t\t</td>\n";
						$i++;
					}
					echo "\t\t\t</tr>\n";
				}
				

				$r++;

			}

			if($t == count($rows) -1){

				echo "\t\t</tbody>\n";
				echo "\t</table>\n";
			}
			$t++;
		} ?>
	
<?php 
	} ?>

<?php 	
	if($p['features'] != ""){

		echo "\t<table class=\"table-features\">\n";
		echo "\t\t<tr>\n";
		echo "\t\t\t<td>\n";
		echo "\t\t\t\t<h2>Description</h2>\n";
		// Check if grouped
		if(preg_match('[GROUP]', $p['features'])){
			echo "\t\t\t<br>\n";
			$groups = explode("[GROUP]", $p['features']);
			foreach ($groups as $g){
				if($g != ""){
					$features = explode("\n",$g);
					foreach($features as $f){
						if(preg_match("[HEADING]", $f)){
							$f = str_replace("[HEADING]", "", $f);
							echo "\t\t\t<h3>" . trim($f) . "</h3>\n";
							echo "\t\t\t<ul>\n"; 
						}
						elseif(!preg_match("[GROUP]", $f)  && $f != ""){ 
							echo"\t\t\t\t<li>" .  trim($f) . "</li>\n";
						}

						
					}
					echo "\t\t\t</ul>\n";
				}					
			}
		}
		else { 
			echo "\t\t\t<ul>\n";
			foreach($features as $f){ 
        		echo"\t\t\t\t<li>" .  trim($f) . "</li>\n";
      		}
      	
			echo "\t\t\t</ul>\n";
      	}
      	echo "\t\t\t</td>\n";
      	echo "\t\t</tr>\n";
      	echo "\t</table>\n";
		
  
 
	}
   	if(isset($p['post_features']) && $p['post_features'] != ""){ 
   		echo "\t\t\t\t<br>";
   		echo "\t\t\t\t" . nl2br($p['post_features']) . "\n"; 

	}  ?>


<?php 	if($p['resources'] != "" || $p['related'] != ""){ ?>


<table class="table-resources">
  
    <tr>
<?php 	if($p['resources'] != ""){ 	
	        echo "\t\t<td >\n";
	        echo "\t\t\t<h2>Resources & support</h2>\n";
	        echo "\t\t\t<ul>\n";
	        foreach($resources as $res){
				$parts = explode("|",$res);
				// 0 = text, 1 = URL, 2 = tab (new or parent), OPTIONAL{ 3 = Event Action, 4 = Event Label } 
				echo "\t\t\t\t<li >";
				if(isset($parts[5])){ echo "<i class='" . $parts[5] . "'></i>&nbsp;&nbsp;"; }
				echo "<a href=\"" . $parts[1];
				if(preg_match('/new/',$parts[2])){ echo "\" target='_blank' "; } 
				if(isset($parts[3])){ echo "\" onClick=\"_gaq.push(['_trackEvent', 'Request Link', '" . $parts[3] . "', '" . $parts[4] . "']);\""; }
				echo ">" . $parts[0] . "</a></li>\n";
			}
	        echo "\t\t\t</ul>\n";
	        echo "\t\t</td>\n";
 		}
 		if($p['related'] != ""){ 	
	        echo "\t\t<td >\n";
	        echo "\t\t\t<h2>Related products</h2>\n";
	        echo "\t\t\t<ul>\n";
	        foreach($related as $rel){
				$parts = explode("|",$rel);
				// 0 = text, 1 = URL, 2 = tab (new or parent), OPTIONAL{ 3 = Event Action, 4 = Event Label } 
				echo "\t\t\t\t<li >";
				if(isset($parts[5])){ echo "<i class='" . $parts[5] . "'></i>&nbsp;&nbsp;"; }
				echo "<a href=\"" . $parts[1];
				if(preg_match('/new/',$parts[2])){ echo "target='_blank' "; } 
				if(isset($parts[3])){ echo "onClick=\"_gaq.push(['_trackEvent', 'Request Link', '" . $parts[3] . "', '" . $parts[4] . "']);\""; }
				echo ">" . $parts[0] . "</a></li>\n";
			}
	        echo "\t\t\t</ul>\n";
	        echo "\t\t</td>\n";
 		}
 		echo "\t</tr>";
 		echo "</table>";
} ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", hideSide);
function hideSide(){
    $("#side").hide();
}    
</script>

<!--  CONTENT ENDS -->