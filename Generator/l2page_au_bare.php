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
	//$sections[$i]['content'] = unserialize($row['content']);
	//$sections[$i]['content'] = unserialize(str_replace('\r\n', '\n', $row['content']));
	$sections[$i]['content'] = json_decode($row['content'],true);
  $sections[$i]['s_order'] = $row['s_order'];     
  $i++;
	
// 	print '<pre>'; 
// 	print_r(str_replace("\r\n", "\n", $row['content']));
// 	print '</pre>';
}
// print '<pre>'; 
// print_r($sections);
// print '</pre>';

	?>


<link rel="stylesheet" type="text/css" href="http://uat.thermofisher.com.au/css/level-page-updates.css">
<!-- CONTENT BEGINS  -->

<?php if($p['type'] == "storefront"){?>
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
        <img src="<?php echo empty($s['content']['main-image']) ? "http://via.placeholder.com/454x258" : $s['content']['main-image']; ?>" alt="<?php if(!empty($s['content']['heading'])){ echo $s['content']['heading']; } ?>">
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
		<?php if(!empty($s['settings']['type']) && $s['settings']['type'] == "sub-category-default"){ ?>
					<img src="<?php echo empty($s['content']['image']) ? "http://via.placeholder.com/230x230" : $s['content']['image']; ?>" alt="">
		<?php	}		?>
          <h1><?php if(!empty($s['content']['heading'])){ echo $s['content']['heading']; } ?></h1>
  <?php   if(!empty($s['content']['copy'])){ echo nl2br($s['content']['copy']); } ?>   
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
      }
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