<?php 

//include("includes/db.php");
include("classes/TableBuilder.php");

$sql = "SELECT * FROM `webgenericpages` p WHERE p.id = " . $_GET['id'];
$r = $conn->query($sql);
$p = $r->fetch_assoc();

$features = explode("\n",$p['features']);
$items = explode("\n",$p['items']);
$resources = explode("\n",$p['resources']);
$related = explode("\n",$p['related']);



?>

<style>
	#PageContent .table-hdi img {
		width: 230px;
	}
</style>

<!-- CONTENT BEGINS -->
<div class="full-width">
<h1><?php echo $p['title']; ?></h1>

<table class="table-hdi">
  <tr>
    <td>
		<img src="<?php echo $p['image']; ?>" alt="<?php echo $p['title']; ?>"/>
		<div>
			<?php if($p['description']){ echo nl2br($p['description']) . "\n"; } ?>
		</div>
    </td>
  </tr>
</table>
	
<?php 	if(!empty($p['items'])){ 
		$table = new TableBuilder($p['items'],array("table", "table-bordered", "table-hover", "table-promo"));
		
		echo $table->build();
?>
	
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