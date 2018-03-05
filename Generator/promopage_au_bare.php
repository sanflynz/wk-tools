<?php 

//include("includes/db.php");

$sql = "SELECT * FROM `webpromopages` p WHERE p.id = " . $_GET['id'];
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
<style>
	h1 {
	font-family: Arial, Helvetica, sans-serif !important; 
	line-height: 40px !important; 
	font-size: 29px !important; 
	color: #333 !important;
	margin-top: 30px;
	margin-bottom: 30px;
}
td {
	font-size: 13px;
}
div.full-width {
	width: 950px;
}
div.nav-width {
	width: 700px;
}
.table th{
	background-color: #ddd !important;
}
.hdi {
	/*margin-top: 30px;*/
}
.hdi-image {
	display: inline-block !important; 
	vertical-align: top; 
	box-sizing: content-box;
	width: 30%;
}
.hdi-image img{
	max-width: 80%;
}
.hdi-description {
	display: inline-block !important; 
	margin-right: 0px; 
	box-sizing: content-box;
	width: 69%;
	font-size: 13px !important;
	color: #616265 !important;
	line-height: 22px !important;
}

.intro-copy {
	margin-top: 30px;
	font-size: 13px !important;
	color: #616265 !important;
	line-height: 22px !important;
}
.features{
	margin-top: 30px;
	width: 100%;
}
.features ul {
	padding-left:20px; 
	margin-top:10px; 
	list-style-position: outside; 
	overflow: hidden;
}
.features ul > li{
	color:#616265; 
	line-height:25px; 
	list-style-type: disc !important;
	font-size: 13px;
}
.promo-table{
	margin-top: 30px;
}
.resources {
	box-sizing: content-box;
	width: 100%;
	background-color: #f3f3f3;
	margin-top: 30px;
}
.resources div {
	box-sizing: content-box;
	display: inline-block;
	vertical-align: top;
}
.resources-1-col div {
	width: 100%;
	margin: 10px 0px 10px 15px;
}
.resources-2-col div {
	width: 47%;
	margin: 10px 0px 10px 15px;
}
.resources ul > li {
	box-sizing: content-box;
	margin-bottom:10px;
	font-size: 13px;
}
.resources h2 {
	margin-top: 10px !important;
	padding-top: 0px !important;
	line-height: 100% !important;
	font-size: 22px !important;
	color: #333333 !important;
}

.terms-conditions {
	margin-top: 30px;
	width: 100%;
	line-height: 22px !important; 
	font-size:11px !important; 
	color:#888 !important; 
}

.more-content{
	width: 100%;
	margin-top: 30px;
	font-size: 13px !important;
	color: #616265 !important;
	line-height: 22px !important;
}
</style>

<div class="full-width">
	<div class="hdi">
		<h1><?php echo $p['title']; ?></h1>	
		<div class="hdi-image">
			<img src="<?php echo $p['image']; ?>">
		</div>
		<div class="hdi-description">
			
			<?php if($p['description']){ echo nl2br($p['description']) . "\n"; } ?>
			

			
		</div>
	</div>
<?php 	
	if($p['features'] != ""){
		echo "\t<div class=\"features\">\n";
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
		echo "\t</div>";
  
 
	}
   	if(isset($p['post_features']) && $p['post_features'] != ""){ ?> 		

	<div class="more-content">
		
			<?php echo "\t\t" . nl2br($p['post_features']) . "\n"; ?>
		
	</div>
<?php 
	} 

	if($p['more'] != ""){ ?>
	<div class="more-content">
		<p style="margin-top:20px; font-size: 14px;">
			<a href="<?php echo $p['more']; ?>" target="_blank">Find out more &rsaquo;</a>
		</p>
	</div>
<?php 	
	} ?>
	
<?php 	if(!empty($p['items'])){ ?>

	<div class="promo-table">
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
					echo "\t<h3>" . trim(str_replace("[GROUP][HEADING]", "", $row)) . "</h3>\n\t<br>\n";
				}
				
				//echo "\t<table class=\"table table-bordered table-hover\">\n";

			}
			else{
				if($r == 1){ 
					echo "\t<table class=\"table table-bordered table-hover\">\n";
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
	</div>
<?php 
	} ?>

	


<?php 	if($p['resources'] != "" || $p['related'] != ""){ ?>
<div class="resources <?php if($p['resources'] != "" && $p['related'] != "") { echo "resources-2-col"; } else { echo "resources-1-col"; } ?>">
	
<?php 	if($p['resources'] != ""){ 
			echo "\t<div>\n";
			echo "\t<h2>Resources & Support</h2>\n";
			echo "\t<ul>\n";
			foreach($resources as $res){
				$parts = explode("|",$res);
				// 0 = text, 1 = URL, 2 = tab (new or parent), OPTIONAL{ 3 = Event Action, 4 = Event Label } ?>
		<li ><?php if(isset($parts[5])){ echo "<i class='" . $parts[5] . "'></i>&nbsp;&nbsp;"; } ?><a href="<?php echo $parts[1]; ?>" <?php if(preg_match('/new/',$parts[2])){ echo "target='_blank' "; } if(isset($parts[3])){ echo "onClick=\"_gaq.push(['_trackEvent', 'Request Link', '" . $parts[3] . "', '" . $parts[4] . "']);\""; }?> ><?php echo $parts[0]; ?></a></li>
<?php		} 
			echo "\t</ul>\n";
			echo "\t</div>\n";
	 	} ?>	    
<?php if($p['related'] != ""){ 
			echo "\t<div>\n";
			echo "\t<h2>Related products</h2>\n";
			echo "\t<ul>\n";
			foreach($related as $rel){
				$parts = explode("|",$rel); ?>
			<li style="margin-bottom:10px;"><?php if(isset($parts[5])){ echo "<i class='" . $parts[5] . "'></i>&nbsp;&nbsp;"; } ?><a href="<?php echo $parts[1]; ?>" <?php if(preg_match('/new/',$parts[2])){ echo "target='_blank'"; } if(isset($parts[3])){ echo "onClick=\"_gaq.push(['_trackEvent', 'Request Link', '" . $parts[3] . "', '" . $parts[4] . "']);\""; } ?> ><?php echo $parts[0]; ?></a></li>
<?php		}  
			echo "\t</ul>\n";
			echo "\t</div>\n";
	 	}
	 	echo "</div>";
	} ?>
	  



	<?php	if($p['terms'] != ""){ ?>
	<div class="terms-conditions">
		<b>Terms &amp; Conditions</b><br>
	    <?php echo nl2br($p['terms']); ?>
	</div>
	<?php } ?>
	

</div>