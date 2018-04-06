<?php 

//include("includes/db.php");
//
//error_reporting (0);

// get stuff
$sql = "SELECT * FROM `pages` WHERE `id`='" . $_GET['id'] . "'";
$r = $conn->query($sql);
$p = $r->fetch_assoc();

$sql = "SELECT * FROM `sections` WHERE `page_id` = '" . $_GET['id'] . "' ORDER BY `s_order`";
$r = $conn->query($sql);
$sections = array();
$i = 0;
while($row = $r->fetch_assoc()){
  $sections[$i]['id'] = $row['id'];
  //if(!empty($row['settings'])){ $sections[$i]['settings'] = unserialize($row['settings']); }
	if(!empty($row['settings'])){ $sections[$i]['settings'] = json_decode($row['settings'],true); }
  $sections[$i]['type'] = $row['type'];
// 	print '<pre>'; 
// 	echo $row['content'];
// 	print '</pre>';
	$sections[$i]['content'] = json_decode($row['content'],true);
  $sections[$i]['s_order'] = $row['s_order'];     
  $i++;
	
// 	print '<pre>'; 
// 	print_r(str_replace("\r\n", "\n", $row['content']));
// 	print '</pre>';
}

if($p['country'] == "New Zealand"){
	$sURL = "http://www.thermofisher.co.nz/search.aspx?search=";
	$gURL = "https://www.thermofisher.co.nz/godirect/main/productdetails.aspx?id=";
}
elseif($p['country'] == "Australia"){
	$sURL = "http://www.thermofisher.com.au/search.aspx?search=";
	$gURL = "https://www.thermofisher.com.au/godirect/main/productdetails.aspx?id=";
}
// print '<pre>'; 
// print_r($sections);
// print '</pre>';

	?>


<link rel="stylesheet" type="text/css" href="http://uat.thermofisher.com.au/css/level-page-updates.css">
<!-- CONTENT BEGINS  -->

<?php if($p['type'] == "storefront" || $p['type'] == "promo-child"){?>
<div class="full-width">
<?php } else { ?>
<div class="nav-width">
<?php
      }
foreach($sections as $s){  

  // MONDRIAN-A 
  if($s['type'] == "mondrian-a"){ ?>
<table class="table-mondrian-a">
    <tr>
        <td class="table-mondrian-a-feature"><a href="<?php echo empty($s['content']['feature']['url']) ? "#" : $s['content']['feature']['url']; ?>" onclick="_gaq.push(['_trackEvent', 'Mondrian', 'Feature Panel', '']);"><img src="<?php echo empty($s['content']['feature']['image']) ? "http://via.placeholder.com/484x404" : $s['content']['feature']['image']; ?>" alt=""></a>
        </td>
        <td>
            <table>
                <tr>
                    <td class="table-mondrian-a-center">
                        <a href="<?php echo empty($s['content']['centre']['url']) ? "#" : $s['content']['centre']['url']; ?>" onclick="_gaq.push(['_trackEvent', 'Mondrian', 'Center Panel', '']);" >
                            <img src="<?php echo empty($s['content']['centre']['image']) ? "http://via.placeholder.com/254x236" : $s['content']['centre']['image']; ?>" alt="" >
                        </a>    
                    </td>
                    <td class="table-mondrian-navigation">
                        <ul>
                      <?php foreach($s['content']['navigation'] as $n){ ?>
              <li><a href="<?php if(!empty($n['url'])){ echo $n['url']; }; ?>" <?php if(!empty($n['tab']) && $n['tab'] == "new"){ echo 'target="_blank"'; } ; ?> onclick="_gaq.push(['_trackEvent', 'Mondrian', 'Navigation', '<?php if(!empty($n['text'])){ echo $n['text']; }; ?>']);"><?php if(!empty($n['text'])){ echo $n['text']; }; ?></a></li>
  <?php       }    ?>    
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="table-mondrian-a-landscape">
                        <a href="#" onclick="_gaq.push(['_trackEvent', 'Mondrian', 'Landscape', '']);"><img src="<?php echo empty($s['content']['landscape']['image']) ? "http://via.placeholder.com/484x138" : $s['content']['landscape']['image']; ?>" alt=""></a>
                    </td>
                </tr>
            </table>
            
        </td>
    </tr>
</table>     
<?php
  }


  // MONDRIAN-F
  if($s['type'] == "mondrian-f"){  ?>
  <table class="table-mondrian-f">
    <tr>
      <td style="width: 460px;">
        <img src="<?php echo empty($s['content']['image']) ? "http://via.placeholder.com/454x258" : $s['content']['image']; ?>" alt="<?php if(!empty($s['content']['heading'])){ echo $s['content']['heading']; } ?>">
      </td>
      <td class="table-mondrian-navigation">
        <ul>
          
      <?php foreach($s['content']['navigation'] as $n){ ?>
              <li><a href="<?php if(!empty($n['url'])){ echo $n['url']; }; ?>" <?php if(!empty($n['tab']) && $n['tab'] == "new"){ echo 'target="_blank"'; } ; ?> onclick="_gaq.push(['_trackEvent', 'Mondrian', 'Navigation', '<?php if(!empty($n['text'])){ echo $n['text']; }; ?>']);"><?php if(!empty($n['text'])){ echo $n['text']; }; ?></a></li>
  <?php       }    ?>
          
        </ul>
      </td>
    </tr>
  </table>  
<?php  
  }


  // HDI
  if($s['type'] == "hdi"){ ?>
  <table class="table-hdi">
    <tr>
      <td width="100%">
<?php	if(!empty($s['settings']['type']) && $s['settings']['type'] == "promo-child-default"){ ?>
				 <h1><?php if(!empty($s['content']['heading'])){ echo $s['content']['heading']; } ?></h1>
<?php	}			
		 	if(!empty($s['settings']['type']) && ($s['settings']['type'] == "sub-category-default" || $s['settings']['type'] == "promo-child-default")){ ?>
					<img src="<?php echo empty($s['content']['image']) ? "http://via.placeholder.com/230x230" : $s['content']['image']; ?>" alt="">
		<?php	}	
					if($s['settings']['type'] != "promo-child-default"){?>
          <h1><?php if(!empty($s['content']['heading'])){ echo $s['content']['heading']; } ?></h1>
				
  <?php 	}
					if(!empty($s['content']['copy'])){ echo html_entity_decode($s['content']['copy']); } ?>   
      </td>
    </tr>
  </table>
<?php }
      
      // FEATURED GATEWAY
      if($s['type'] == 'featured-gateway'){
        if(!empty($s['content']['heading']) && !empty($s['content']['items'][0]['url'])){ ?>
   
  <table class="table-featured-gateway">
    <thead>
      <tr>
        <th colspan="3"><h3><?php if(!empty($s['content']['heading'])){ echo $s['content']['heading']; } ?></h3></th>
      </tr>
    </thead>
      <tbody>
          <tr>
      <?php   $i = 0;
              foreach($s['content']['items'] as $x){ ?>      
              <td>
                <a href="<?php if(!empty($x['url'])){ echo $x['url']; }; ?>" onclick="_gaq.push(['_trackEvent', 'Popular Product', 'Click', '<?php if(!empty($x['text'])){ echo $x['text']; }; ?>']);" <?php if($x['tab'] == "new"){ echo 'target="_blank"'; } ?>><img src="<?php echo empty($x['image']) ? "http://via.placeholder.com/208x125" : $x['image']; ?>" width="208" height="125" alt="<?php if(!empty($x['text'])){ echo $x['text']; }; ?>"><br>
                <?php if(!empty($x['text'])){ echo $x['text']; }; ?></a>
              </td>
      <?php     $i++;
              } ?>        
          </tr>          
      </tbody>
  </table>
<?php    
        }
      }

      // Category lists
      if($s['type'] == "category-lists"){ 
        $cols = !empty($s['settings']['columns']) ? $s['settings']['columns'] : 2;
        ?>
  <table class="table-category-lists">
<?php if(!empty($s['content']['heading'])){ ?>    
    <thead>
      <tr>
        <th colspan="<?=$cols;?>"><h2><?=$s['content']['heading']; ?></h2></th>
      </tr>
    </thead>
<?php } ?>    
    <tbody>
  <?php   $i = 1;
    foreach($s['content']['items'] as $x){
      echo ($i == 1) ? "<tr>" : ""; ?>
         
        <td>
          <h3><a href="<?php if(!empty($x['url'])){ echo $x['url']; }; ?>" <?php if(!empty($x['tab']) && $x['tab'] == "new"){ echo 'target="_blank"'; }; ?>><?php if(!empty($x['heading'])){ echo $x['heading']; }; ?></a></h3>
          <?php if(!empty($x['copy'])){ echo nl2br($x['copy']); }; ?>
        </td>
        
      
  <?php if($i % $cols == 0){
          echo "</tr>";
          $i = 1;
        }
        else {
          $i++;
        }
    } ?>    
    </tbody>
    
  </table>
<?php }
	
			 // ALTERNATING HDI
      if($s['type'] == "alternating-hdi"){ ?>
<!-- 		I should put this in the thead -->
	

	<table class="table-hdi-alternating">
	<?php if(!empty($s['content']['heading'])){ ?>	
		<thead>
			<tr>
				<th colspan="4"><h2><?=$s['content']['heading'];?></h2></th>
			</tr>
		</thead>
	<?php } ?>	
		<tbody>
	<?php   $z = 1;
					foreach($s['content']['items'] as $f){ ?>
			<tr>
	<?php       if($z % 2 != 0){ ?>        
					<td>
							<img src="<?php if(isset($f['image']) && $f['image'] != ""){ echo $f['image']; } else { echo "http://via.placeholder.com/230x160"; } ?>" width="230" height="160" alt="<?php if(isset($f['heading']) && $f['heading'] != ""){ echo $f['heading']; } else { echo "Featured Product Name"; } ?>"/>
					</td>
	<?php       } ?>      
					<td colspan="3">
							<h3><a href="<?php if(isset($f['url']) && $f['url'] != ""){ echo $f['url']; } else { echo "#"; } ?>" <?php if(isset($f['url']) && $f['url'] != "" && $f['tab'] == "new"){ echo "target='_blank'"; } ?>><?php if(isset($f['image']) && $f['heading'] != ""){ echo $f['heading']; } else { echo "Featured Product Name"; } ?></a></h3>
							<?php if(isset($f['copy']) && $f['copy'] != ""){ echo nl2br($f['copy']); } else { echo "Featured Product description"; } ?>
					</td>
	<?php       if($z % 2 == 0){ ?>   
					<td>
							<img src="<?php if(isset($f['image']) && $f['image'] != ""){ echo $f['image']; } else { echo "http://via.placeholder.com/230x160"; } ?>" width="230" height="160" alt="<?php if(isset($f['heading']) && $f['heading'] != ""){ echo $f['heading']; } else { echo "Featured Product Name"; } ?>"/>
					</td>
	<?php       } ?>
			</tr>

	<?php       $z++;
					} ?>    
		</tbody>
	</table>		
				
				
<?php	}
	
	
			if($s['type'] == "product-table"){ // PRODUCT TABLE ?>
	<table class="table-product-table" style="width: 100%;">
		<tr>
			<td>
<?php		if(!empty($s['content']['heading'])){ echo "<h3>" . $s['content']['heading'] . "</h3>"; }
				echo "\t\t\t\t<table class=\"table table-bordered table-hover\">\n";
				$rows = explode("\n", $s['content']['table']);
				$r = 1;
				foreach($rows as $row){
					$cells = explode("\t", $row);
					if($r == 1){

						echo "\t\t\t\t\t<thead>\n";
					}
						echo "\t\t\t\t\t\t<tr>\n";
						
						$i = 0;
						foreach($cells as $c){
							$style = "";
							
							// does it have a width?
							if(preg_match('/[0-9]+%/',$c,$w)){
								$c = preg_replace('/\[([0-9]+%)\]/','',$c);
								$style .= "width: " . $w[0] . "; ";
							}
							else{
								if(preg_match('/unit/i', $c)){
									$style .= "width: 10%;";
								}
								if(preg_match('/price/i', $c)){
									$style .= "width: 12%;";
								}								
							}
							
							// Matching styles to columns...
							if($r == 1){
								$match = $c;
								$h[$i] = $c;
							}
							else{
								$match = $h[$i];
							}
							
							// [text-center] [text-left] [text-right]
							if(preg_match('/\[text-[a-zA-Z]+\]/',$match,$t)){
								if($r == 1){
									$c = preg_replace('/\[text-[a-zA-Z]+\]/','',$c);
								}
								if($t[0] == "[text-center]") { $style .= "text-align: center; "; }
								if($t[0] == "[text-left]") { $style .= "text-align: left; "; }
								if($t[0] == "[text-right]") { $style .= "text-align: right; "; }
							}
							else{
								if(preg_match('/unit/i', $match)){
									$style .= "text-align: center; ";
								}
								if(preg_match('/price/i', $match)){
									$style .= "text-align: right; ";
								}								
							}
							
							// Item Code and Description links
							if(preg_match('/item code/i', trim($match)) && $r != 1){
								$c = "<a href=\"" . $sURL . $c . "#gsc.tab=0&gsc.q=" . trim($c) . "\" onClick=\"_gaq.push(['_trackEvent', 'Product Search Link', 'Item Code', '" . $c . "']);\">" . trim($c) . "</a>";
							}
							if(preg_match('/item code/i', trim($h[0])) && preg_match('/description/i', trim($match)) && $r != 1){
								$c = "<a href=\"" . $sURL . $cells[0] . "#gsc.tab=0&gsc.q=" . trim($cells[0]) . "\" onClick=\"_gaq.push(['_trackEvent', 'Product Search Link', 'Item Code', '" . $cells[0] . "']);\">" . trim($c) . "</a>";
							}
							
							// BUTTONS
							if(preg_match('/\[btn-buy\]/',$c)){
								if(!preg_match('/item code/i', trim($h[0]))){
									$c = "Must have item code in column 1";
								}
								else{
									$c = "<a href=\"" . $gURL . $cells[0] . "\" class=\"btn btn-commerce btn-mini\" target=\"_blank\" onClick=\"_gaq.push(['_trackEvent', 'Product Buy Link', 'Item Code', '" . trim($cells[0]) . "']);\">Login to buy</a>";
									$style .= "width: 10%; text-align: center;";
								}
							}
							if(preg_match('/\[btn=(.*)\]/',$c,$t)){
								$l = explode("|",$t[1]);
									if(!empty($l[2]) && $l[2] == "new"){ $tab = "target=\"_blank\""; } else { $tab = ""; }
									$c = "<a href=\"" . $l[1] . "\" " . $tab . " class=\"btn btn-primary\">" . $l[0] . "</a>";
							}
							
							// LINKS
							if(preg_match('/\[link(.*)=(.*)\]/',$c,$t)){
								if($t[1] == "-item"){
									$c = "<a href=\"" . $sURL . $t[2] . "#gsc.tab=0&gsc.q=" . $t[2] . "\" onClick=\"_gaq.push(['_trackEvent', 'Product Search Link', 'Companion Item Code', '" . $t[2] . "']);\">" . $t[2] . "</a>";
								}
								elseif($t[1] == "-quote"){
									$c = "<a href=\"" . $t[2] . "\">Request quote</a>";
								}
								elseif($t[1] == ""){
									$l = explode("|",$t[2]);
									if(!empty($l[2]) && $l[2] == "new"){ $tab = "target=\"_blank\""; } else { $tab = ""; }
									$c = "<a href=\"" . $l[1] . "\" " . $tab . ">" . $l[0] . "</a>";
								}
							}
							
							
							
							if($style){
								$style = "style=\"" . $style ."\"";
							}
							if($r == 1){
								echo "\t\t\t\t\t\t\t<th " . $style . ">" . $c . "</th>\n";
							}
							else{
								echo "\t\t\t\t\t\t\t<td " . $style . ">" . $c . "</td>\n";
							}
							
							$i++;
						}
						
						echo "\t\t\t\t\t\t</tr>\n";
					if($r == 1){
						echo "\t\t\t\t\t</thead>\n";
					}	
					$r++;
					
				}
				echo "\t\t\t\t</table>\n";
				
				
				
				
				?>				
			</td>
		</tr>
	</table>
				
<?php	}
	

      // EMBEDDED PROMOS
      if($s['type'] == 'embedded-promos'){ 
        if(!empty($s['content'][1]['url']) && !empty($s['content'][2]['url'])){
        ?>
  <table class="table-embedded-promos">
    <tr>
        <td>
          <a href="<?php if(!empty($s['content'][1]['url'])){ echo $s['content'][1]['url']; }; ?>" onclick="_gaq.push(['_trackEvent', 'Embedded Promo', 'Click', '<?php if(!empty($s['content'][1]['name'])){ echo $s['content'][1]['name']; }; ?>']);" <?php if(!empty($s['content'][1]['tab']) && $s['content'][1]['tab'] == "new"){ echo 'target="_blank"'; } ?>><img src="<?php echo empty($s['content'][1]['image']) ? "http://via.placeholder.com/340x140" : $s['content'][1]['image']; ?>" alt="<?php if(!empty($s['content'][1]['name'])){ echo $s['content'][1]['name']; }; ?>"></a>
        </td>
        <!-- <td width="20">&nbsp;</td> -->
        <td>
          <a href="<?php if(!empty($s['content'][2]['url'])){ echo $s['content'][2]['url']; }; ?>" onclick="_gaq.push(['_trackEvent', 'Embedded Promo', 'Click', '<?php if(!empty($s['content'][2]['name'])){ echo $s['content'][2]['name']; }; ?>']);" <?php if(!empty($s['content'][2]['tab']) && $s['content'][2]['tab'] == "new"){ echo 'target="_blank"'; } ?>><img src="<?php echo empty($s['content'][2]['image']) ? "http://via.placeholder.com/340x140" : $s['content'][2]['image']; ?>" alt="<?php if(!empty($s['content'][2]['name'])){ echo $s['content'][2]['name']; }; ?>"></a>
        </td>
    </tr>
  </table>
<?php   }
      }

      // RESOURCES 
      if($s['type'] == "resources"){ 
        if(!empty($s['content'][0]['heading'])) {
         ?>
  <table class="table-resources">
    <tbody>
      <tr>
<?php   for($x = 0; $x < count($s['content']); $x++){ 
           ?>        
          <td>
            <h2><?php if(!empty($s['content'][$x]['heading'])){ echo $s['content'][$x]['heading']; } ?></h2>
            <ul>
  <?php   
            for($y = 0; $y < count($s['content'][$x]['link']); $y++){
              $l = $s['content'][$x]['link'][$y];  ?>
                <li><?php if(!empty($l['icon'])){ ?><i class="<?=$l['icon']; ?>"></i> <?php } ?><a href="<?php if(!empty($l['url'])){ echo $l['url']; }; ?>" <?php if($l['tab'] == "new"){ echo 'target="_blank" '; } ?> <?php if(!empty($l['category']) && !empty($l['action'] && !empty($l['label']))){ ?>onclick="_gaq.push(['_trackEvent', '<?=$l['category'];?>, '<?=$l['action'];?>', <?=$l['label'];?>]);"<?php } ?>><?php if(!empty($l['name'])){ echo $l['name']; }; ?></a></li>
    <?php   }  
           ?>
            </ul>
          </td>
<?php     }
         ?>
      </tr>
    </tbody>
  </table>
<?php   } 
      }  // RESOURCES ENDS
	
	
			if($s['type'] == "terms-conditions"){ ?>
	<table class="table-promo-tandc">
	<tr>
		<td>
			<h4>Terms & Conditions</h4>
			<?=$s['content']; ?>
		</td>
	</tr>
</table>			
<?php	} // T AND C ENDS
			
			if($s['type'] == "custom"){ ?>
	<table class="table-custom">
	<tr>
		<td>
			<?=html_entity_decode($s['content']); ?>
		</td>
	</tr>
</table>			
<?php	} // T AND C ENDS
       ?>


<?php
} ?>

</div>

<script>
document.addEventListener("DOMContentLoaded", hideSide);
function hideSide(){
    $("#side").hide();
}    
</script>

<!--  CONTENT ENDS -->