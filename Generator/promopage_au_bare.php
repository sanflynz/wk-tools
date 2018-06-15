<?php 

//include("includes/db.php");
include("classes/TableBuilder.php");

$sql = "SELECT * FROM `webpromopages` p WHERE p.id = " . $_GET['id'];
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

<div class="full-width">

<h1><?php echo $p['title']; ?></h1>	
		
<table class="table-hdi">
  <tr>
    <td>		
		<img src="<?php echo $p['image']; ?>">
		<div>
			<?php if($p['description']){ echo nl2br($p['description']) . "\n"; } ?> <br>
        	<br>
		</div>     
    </td>
  </tr>
</table>

<?php 	
	if($p['features'] != ""){
		echo "<table class=\"table-features\">\n";
		echo "\t<tr>\n";
		echo "\t\t<td>\n";
		// Check if grouped
		if(preg_match('[GROUP]', $p['features'])){
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
		echo "\t\t</td>\n";
		echo "\t</tr>\n";
		echo "</table>\n";
  
 
	}
   	if(isset($p['post_features']) && $p['post_features'] != ""){ ?> 		

		<br>
		
		<?php echo "\t\t" . nl2br($p['post_features']) . "\n"; ?>
		<br>
	
<?php 
	} 

	?>

	
<?php 	if(!empty($p['items'])){ 
		$table = new TableBuilder($p['items'],array("table", "table-bordered", "table-hover", "table-promo"));
		
		echo $table->build();
?>
	<br>

	
	
	
<?php 
	} ?>

<?php	if($p['terms'] != ""){ ?>
<table class="table-promo-tandc">
	<tr>
		<td>
			<h4>Terms & Conditions</h4>
			<?php echo nl2br($p['terms']); ?>
		</td>
	</tr>
</table>
<?php } ?>
		


<?php 	if($p['resources'] != "" || $p['related'] != ""){ ?>


<table class="table-resources">
  <tbody>
    <tr>
    	<?php 	if($p['resources'] != ""){ ?>
<td >
          	<h2>Resources & Support</h2>
          	<ul>
        <?php	foreach($resources as $res){
				$parts = explode("|",$res);
				// 0 = text, 1 = URL, 2 = tab (new or parent), OPTIONAL{ 3 = Event Action, 4 = Event Label } ?>
		<li ><?php if(isset($parts[5])){ echo "<i class='" . $parts[5] . "'></i>&nbsp;&nbsp;"; } ?><a href="<?php echo $parts[1]; ?>" <?php if(preg_match('/new/',$parts[2])){ echo "target='_blank' "; } if(isset($parts[3])){ echo "onClick=\"_gaq.push(['_trackEvent', 'Request Link', '" . $parts[3] . "', '" . $parts[4] . "']);\""; }?> ><?php echo $parts[0]; ?></a></li>
<?php		} ?>
          	</ul>
        </td>
<?php       } 
			if($p['related'] != ""){?>
        <td >
          	<h2>Related products</h2>
          	<ul>
    <?php        	foreach($related as $rel){
				$parts = explode("|",$rel); ?>
			<li style="margin-bottom:10px;"><?php if(isset($parts[5])){ echo "<i class='" . $parts[5] . "'></i>&nbsp;&nbsp;"; } ?><a href="<?php echo $parts[1]; ?>" <?php if(preg_match('/new/',$parts[2])){ echo "target='_blank'"; } if(isset($parts[3])){ echo "onClick=\"_gaq.push(['_trackEvent', 'Request Link', '" . $parts[3] . "', '" . $parts[4] . "']);\""; } ?> ><?php echo $parts[0]; ?></a></li>
<?php		}  ?>
          	</ul>
        </td>
<?php 	} ?>        
    </tr>
  </tbody>
</table>

<?php
	} ?>
	  





</div>

