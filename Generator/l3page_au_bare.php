<?php 

//include("includes/db.php");
//
//error_reporting (0);

$sql = "SELECT * FROM `webl3pages` p WHERE p.id = " . $_GET['id'];
$r = $conn->query($sql);
$p = $r->fetch_assoc();

$sql = "SELECT * FROM `webl3featured` f WHERE f.l3_id = " . $_GET['id'] . " ORDER BY f.id";
$r = $conn->query($sql);
$x = 0;
while($row = $r->fetch_assoc()){
	$p['featured'][$x] = $row;
	$x++;
}

// $features = explode("\n",$p['features']);
// $items = explode("\n",$p['items']);
// $resources = explode("\n",$p['resources']);
// $related = explode("\n",$p['related']);

// if($p['country'] == "New Zealand"){
// 	$sURL = "http://www.thermofisher.co.nz/search.aspx?search=";
// }
// elseif($p['country'] == "Australia"){
// 	$sURL = "http://www.thermofisher.com.au/search.aspx?search=";
// }


// SPLIT POPULAR	 	
for($i = 1; $i < 4; $i++){
	if($p['popular-' . $i]){
		$p['popular-' . $i] = explode("|",$p['popular-' . $i]);
	 	$p['popular-' . $i]['text'] = $p['popular-' . $i][0];
	 	$p['popular-' . $i]['image'] = $p['popular-' . $i][1];
	 	$p['popular-' . $i]['url'] = $p['popular-' . $i][2];
	 	$p['popular-' . $i]['tab'] = $p['popular-' . $i][3];
	}
}	 	

// SPLIT VIDEOS
if($p['videos']){ 
	$parts = explode("[ITEMS]",$p['videos']);
	$items = explode("|", $parts[1]);
	$p['videos'] = "";
	$p['videos']['heading'] = substr($parts[0],9);
	$p['videos']['left'] = $items[0];
	$p['vidoes']['right'] = $items[1];
}


// SPLIT PODS
$sides = array("left", "right");
foreach($sides as $s){
	if($p['pod-' . $s]){
		$p['pod-' . $s] = explode("|",$p['pod-' . $s]);
		$p['pod-' . $s]['name'] = $p['pod-' . $s][0];
		$p['pod-' . $s]['image'] = $p['pod-' . $s][1];
		$p['pod-' . $s]['url'] = $p['pod-' . $s][2];
		$p['pod-' . $s]['tab'] = $p['pod-' . $s][3];
	}
}


// SPLIT RESOURCES
foreach($sides as $s){
	if($p['resources-' . $s]){
		$parts = explode("[ITEMS]",$p['resources-' . $s]);
		$p['resources-' . $s] = ""; // resets the array?
		$p['resources-' . $s]['heading'] = substr($parts[0],9);
		
		$p['resources-' . $s]['items'] = explode("\n",$parts[1]);  // text | url | tab | action | label  // icon???

	}
}	?>



<!-- #### PAGE CONTENT ####  -->
<span id="version" data-type="Level 3" data-version="2" style="display: none;"></span>
<br>
<br>
<table width="700" border="0" cellspacing="0" cellpadding="0" id="intro" class="table-hdi">
    <tbody>
        <tr>
          <td width="230" valign="top">
            <img src="<?php if(isset($p['main-image'])){ echo $p['main-image']; } else { echo "/Uploads/image/level-3-main.jpg"; } ?>" width="230" alt="" style="margin-bottom: 20px;" />
          </td>
          <td width="17">&nbsp;</td>
          <td width="453">
            <h2 style="padding-top: 0px; line-height: 110%"><?php echo $p['page-heading']; ?></h2>
            <p><?php echo nl2br($p['description']); ?></p>
            <br>
          </td>
        </tr>
        
    </tbody>
</table>

<?php if($p['popular-heading'] || $p['popular-1'] || $p['popular-2'] || $p['popular-3']) { ?>
<br>
<table width="700" border="0" cellspacing="0" cellpadding="0" bgcolor="#EEEEED" id="popular">
    <tbody>
        <tr>
          <td width="21" height="46">&nbsp;</td>
          <td height="46" colspan="3" valign="middle">
            <h3><?php if(isset($p['popular-heading'])){ echo $p['popular-heading']; } else { echo "Popular XXXXXXXX products";} ?></h3>
          </td>
          <td height="46" colspan="3">&nbsp;</td>
        </tr>
        
        <tr>        	
          <td height="125">&nbsp;</td>
<?php 	for($i = 1; $i < 4; $i++){ ?>          
          <td width="208" align="center" valign="top">
            <a href="<?php if(isset($p['popular-' . $i]['url'])){ echo $p['popular-' . $i]['url']; } else { echo "#";} ?>" <?php if(isset($p['popular-' . $i]['tab']) && $p['popular-' . $i]['tab'] == "new"){ echo "target='_blank'"; } ?> onClick="_gaq.push(['_trackEvent', 'Level 3 Page', 'Popular Product', '<?php if(isset($p['popular-' . $i]['text'])){ echo $p['popular-' . $i]['text']; } else { echo "Popular Product " . $i;} ?>']);">
              <img src="<?php if(isset($p['popular-' . $i]['image']) && $p['popular-' . $i]['image'] != ""){ echo $p['popular-' . $i]['image']; } else { echo "/Uploads/image/popular-product.jpg";} ?>" width="208" height="125" alt="">
            </a><br>
            <br>
            <a href="<?php if(isset($p['popular-' . $i]['url'])){ echo $p['popular-' . $i]['url']; } else { echo "#";} ?>" <?php if(isset($p['popular-' . $i]['tab']) && $p['popular-' . $i]['tab'] == "new"){ echo "target='_blank'"; } ?> onClick="_gaq.push(['_trackEvent', 'Level 3 Page', 'Popular Product', '<?php if(isset($p['popular-' . $i]['text'])){ echo $p['popular-' . $i]['text']; } else { echo "Popular Product " . $i;} ?>']);">
            	<?php if(isset($p['popular-' . $i]['text'])){ echo $p['popular-' . $i]['text']; } else { echo "Popular Product " . $i;} ?>
            </a>
          </td>
          <td width="17">&nbsp;</td>
<?php 	} ?>          

        <tr>
            <td colspan="7">&nbsp;</td>            
        </tr>
    </tbody>
</table>
<?php }
else{
  //echo "<hr style=\"border: 0; height: 1px; background-color: #ddd;\">";
} ?>

<table width="700" border="0" cellspacing="0" cellpadding="0" id="featured" class="table-hdi-alternating">
  <tbody>
    <tr>
        <td colspan="5">
          <h2><?php if(isset($p['featured-heading']) && $p['featured-heading'] != ""){ echo $p['featured-heading']; } else { echo "Featured XXXXXXXX products"; } ?></h2>
        </td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
<?php 	
		$z = 1;
		foreach($p['featured'] as $f){ ?>
	
	<tr>
	<?php if($z % 2 != 0){ ?>	
      <td width="230" valign="top">
        <img src="<?php if(isset($f['image']) && $f['image'] != ""){ echo $f['image']; } else { echo "/Uploads/image/featured-product.jpg"; } ?>" width="230" height="160" style="border: 1px solid #d5d5d5" alt=""/>
      </td>
      <td width="17" valign="top">&nbsp;</td>
      
    <?php 	} ?>  
      <td colspan="3" align="left">
        <h3><a href="<?php if(isset($f['url']) && $f['url'] != ""){ echo $f['url']; } else { echo "#"; } ?>" <?php if(isset($f['url']) && $f['url'] != "" && $f['tab'] == "new"){ echo "target='_blank'"; } ?>><?php if(isset($f['image']) && $f['heading'] != ""){ echo $f['heading']; } else { echo "Featured Product Name"; } ?></a></h3>
        <p><?php if(isset($f['description']) && $f['description'] != ""){ echo nl2br($f['description']); } else { echo "Featured Product description"; } ?></p>
      </td>
      <?php if($z % 2 == 0){ ?>	
      <td width="17" valign="top">&nbsp;</td>
      
      <td width="230" valign="top">
        <img src="<?php if(isset($f['image']) && $f['image'] != ""){ echo $f['image']; } else { echo "/Uploads/image/featured-product.jpg"; } ?>" width="230" height="160" style="border: 1px solid #d5d5d5" alt=""/>
      </td>
    <?php 	} ?>  
    </tr>
    
    <tr>
      <td height="46" colspan="5" valign="top">&nbsp;</td>
    </tr>

			
<?php	$z++;
		} ?>    
    
  </tbody>
</table>

<?php if(isset($p['videos']['heading']) || isset($p['videos']['left']) || isset($p['videos']['right'])){ ?>
<br>
<br>
<table width="700" border="0" cellspacing="0" cellpadding="0" bgcolor="#ebf2fa" id="videos">
  <tbody> 
    <tr>
      <td height="46">&nbsp;</td>
      <td colspan="3">
        <h2><?php if(isset($p['videos']['heading']) && $p['videos']['heading'] != ""){ echo $p['videos']['heading']; } else { echo "Featured XXXXXXXX videos"; } ?></h2>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="21">&nbsp;</td>
      <td width="319">
        <iframe width="319" height="195" src="<?php if(isset($p['videos']['left']) && $p['videos']['left'] != ""){ echo $p['videos']['left']; } else { echo "https://www.youtube.com/embed/3aofxoV0Afk"; } ?>" frameborder="0" allowfullscreen></iframe>
      </td>
      <td>&nbsp;</td>
      <td width="319">
        <iframe width="319" height="195" src="<?php if(isset($p['videos']['right']) && $p['videos']['right'] != ""){ echo $p['videos']['Right']; } else { echo "https://www.youtube.com/embed/3aofxoV0Afk"; } ?>" frameborder="0" allowfullscreen></iframe>
      </td>
      <td width="21">&nbsp;</td>
    </tr>
    <tr>
        <td height="32" colspan="5">&nbsp;</td>
    </tr>
  </tbody>
</table>
<?php }

if(isset($p['pod-left']['url']) || isset($p['pod-left']['image']) || isset($p['pod-right']['url']) || isset($p['pod-right']['image'])){ ?>
<br>
<br>
<table width="700" border="0" cellspacing="0" cellpadding="0" id="pods">
  <tbody>    
    <tr>
        <td colspan="2" width="340">
          <a href="<?php if(isset($p['pod-left']['url']) && $p['pod-left']['url'] != ""){ echo $p['pod-left']['url']; } else { echo "#"; } ?>" <?php if(isset($p['pod-left']['tab']) && $p['pod-left']['tab'] == "new"){ echo "target='_blank'"; } ?>  onClick="_gaq.push(['_trackEvent', 'Level 3 Page', 'Resource Pod Promo', '<?php if(isset($p['pod-left']['name'])){ echo $p['pod-left']['name']; } else { echo "Left";} ?>']);" >
            <img src="<?php if(isset($p['pod-left']['image']) && $p['pod-left']['image'] != ""){ echo $p['pod-left']['image']; } else { echo "/Uploads/image/resource-pod-narrow.jpg"; } ?>" width="340" height="140" alt="">
          </a>
        </td>
        <td>&nbsp;</td>
        <td colspan="2" width="340" align="right">
          <a href="<?php if(isset($p['pod-right']['url']) && $p['pod-right']['url'] != ""){ echo $p['pod-right']['url']; } else { echo "#"; } ?>" <?php if(isset($p['pod-right']['tab']) && $p['pod-right']['tab'] == "new"){ echo "target='_blank'"; } ?> onClick="_gaq.push(['_trackEvent', 'Level 3 Page', 'Resource Pod Promo', '<?php if(isset($p['pod-right']['name'])){ echo $p['pod-right']['name']; } else { echo "Right";} ?>']);" >
            <img src="<?php if(isset($p['pod-right']['image']) && $p['pod-right']['image'] != ""){ echo $p['pod-right']['image']; } else { echo "/Uploads/image/resource-pod-narrow.jpg"; } ?>" width="340" height="140" alt="">
          </a>
        </td>
    </tr>
  </tbody>  
</table>
<?php }

if(isset($p['resources-left']['heading']) || isset($p['resources-right']['heading'])){ ?>
<br>
<br>
<table width="700" border="0" cellspacing="0" cellpadding="0" bgcolor="#EEEEED" id="resources">
    <tbody>
        <tr>
          <td width="21">&nbsp;</td>
<?php 	$sides = array("left","right");
		foreach ($sides as $s){ 
      
			// text | url | tab | action | label | icon???   

      if(isset($p['resources-' . $s]['heading'])){ ?>          
          <td width="319" valign="top" <?php if(!isset($p['resources-left']) || !isset($p['resources-right'])){ echo "colspan='3' "; }  ?>>
            <h2><?php if(isset($p['resources-' . $s]['heading']) && $p['resources-' . $s]['heading'] != ""){ echo $p['resources-' . $s]['heading']; } else { if($s == "left"){ echo "Resources"; } else { echo "Support"; } } ?></h2>

<?php 	if(isset($p['resources-' . $s]['items']) && ($p['resources-' . $s]['items'][0] != "")){ ?>
			<ul>
<?php			foreach ($p['resources-' . $s]['items'] as $i){ 
					$b = explode("|",$i); ?>
				<li style="margin-bottom:10px;"><?php if(isset($b[5])){ echo "<i class='" . $b[5] . "'></i>&nbsp;&nbsp;"; } ?>
					<a href="<?php echo $b[1]; ?>" <?php if($b[2] == "new"){ echo "target='_blank'"; } ?> <?php if(isset($b[3])){ echo "onClick=\"_gaq.push(['_trackEvent', 'Level 3 Page', '" . $b[3] . "', '" . $b[4] . "']);\""; } ?>><?php echo $b[0]; ?></a></li>
<?php				
				} ?>
			</ul>
<?php		} 

       ?>
			
          </td>
    <?php } ?>      
          <td width="21">&nbsp;</td>
<?php }
      	 ?>          


        </tr>
        <tr>
            <td height="18" colspan="5">&nbsp;</td>
        </tr>
  </tbody>
</table>
<?php } ?>

<!-- #### PAGE CONTENT ENDS ####  -->