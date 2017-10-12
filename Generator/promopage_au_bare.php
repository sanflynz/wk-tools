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
}
elseif($p['country'] == "Australia"){
	$sURL = "http://www.thermofisher.com.au/search.aspx?search=";
}

?>

<!-- ############ CODE STARTS ############# -->

<table width="700" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr valign="bottom">
            <td height="15">
            
            </td>
        </tr>
  </tbody>
</table>
<table width="700" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td colspan="3" style="font-family: Arial, Helvetica, sans-serif; Line-height: 39.8px; font-size: 29px; color: #333;" height="48">
            	<?php echo $p['title']; ?></td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td width="177">&nbsp;</td>
            <td width="13">&nbsp;</td>
            <td width="510">&nbsp;</td>
        </tr>
        <tr>
            
            <td valign="top" colspan="3">
            	<p style="font-size: 14px;">
            	<img src="<?php echo $p['image']; ?>" alt="<?php echo $p['title']; ?>" style="background-color: #666666; float: left; margin: 0px 20px 15px 0px;" width="200">
            	<?php echo nl2br($p['description']); ?></p>
		
		<?php if($p['features'] != ""){

				// Check if grouped
				if(preg_match('[GROUP]', $p['features'])){
					echo "<br>";
					$groups = explode("[GROUP]", $p['features']);
					foreach ($groups as $g){
						if($g != ""){
							$features = explode("\n",$g);
							foreach($features as $f){
								if(preg_match("[HEADING]", $f)){
									$f = str_replace("[HEADING]", "", $f);
									echo "<b>" . $f . "</b><br>";
									echo "<ul style=\"padding-left:20px; margin-top:10px; list-style-position: outside; overflow: hidden;\">"; 
								}
								elseif(!preg_match("[GROUP]", $f)  && $f != ""){ ?>
									<li style="color:#616265; line-height:25px; list-style-type: disc !important;"><?php echo $f; ?></li>
						<?php	}

								
							}
							echo "</ul><br>";
						}
						
					}
					

				}
				else { ?>	
				
              <ul style="padding-left:20px; margin-top:10px; list-style-position: outside;">
              <?php foreach($features as $f){ ?>
                <li style="color:#616265; line-height:25px; list-style-type: disc !important;"><?php echo $f; ?></li>
              <?php } ?>  
              
              </ul>
              <?php } ?>
         <?php } ?>  

           <?php if($p['post_features'] != ""){ ?>   
              <p style="margin-top:15px; font-size: 14px;"><?php echo nl2br($p['post_features']); ?></p>
			<?php } ?>
			 <?php if($p['more'] != ""){ ?>  
              <p style="margin-top:20px; font-size: 14px;"><a style="color:#6caae3;" href="<?php echo $p['more']; ?>" target="_blank">Find out more &raquo;</a></p>
			<?php } ?>
            </td>           
        </tr>
    </tbody>
</table>

<table width="700" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr valign="bottom">
            <td height="20">
            
            </td>
        </tr>
  </tbody>
</table>

<?php 	
	if(!empty($p['items'])){	
		if(preg_match('[GROUP]', $p['items'])){
			$groups = explode("[GROUP]", $p['items']);
			foreach ($groups as $g){ 
				if($g != ""){
					$items = explode("\n",$g);
					if(preg_match("[HEADING]", $items[0])){	?>
						<br><br><b><?php echo str_replace("[HEADING]", "", $items[0]); ?></b><br><br>
			<?php 	} ?>
					<table padding="6" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#616265; border:solid 1px #C0C0C0; border-collapse: collapse;" width="700" border="0" cellspacing="0">
					<tbody>
					
			<?php	$n = 0;
					foreach ($items as $i) {
						if($i != ""){
							$columns = explode("\t", $i);
							if($n == 0){
								// do nothing
							}
							elseif($n == 1){
								$headers = $columns?>
					<tr style="font-weight:bold; color:#555759; background-color:#e0edf9;">
						<td valign="middle" width="2%"  height="48" >&nbsp;</td>
	            
			        <?php 	foreach($headers as $h){
			        			if($h == "Description"){ $width = ""; } elseif($h == "Item Code"){ $width = "20%"; } else { $width = "15%"; } 

			        			if(preg_match('/[0-9]+%/',$h,$w)){
			        				$width = $w[0];
			        				// remove the reference
			        				$h = preg_replace('/\[([0-9]+%)\]/','',$h);
			        			}

			        			if(preg_match('/price/i', $h)){
									$style = "style='padding-right: 20px; text-align: right;'";
								}
								else{
									$style = "";
								}

			        				?>
						<td valign="middle" width="<?php echo $width; ?>" <?php echo $style; ?>><?php echo $h; ?></td>
					<?php
								}	 ?>    
			        </tr>
		<?php	
							}
							else{ ?>
					<tr <?php if($n % 2 == 0){?>style="background-color:#f3f3f3;" <?php } ?>>
						<td height="47">&nbsp;</td>
					<?php 	foreach($columns as $k => $v){
								$tracking = "";
								$url = "";
								$tab = "";

								if(preg_match('/price/i', $headers[$k])){
									$style = "style='padding-right: 20px; text-align: right;'";
								}
								elseif(preg_match('/Pack Size/i', $headers[$k])){
									$style = "style='text-align: center;'";
								}
								else{
									$style = "";
								}

								echo "<td " . $style . ">";
								//if(preg_match('/.*price.*$/i', $headers[$k])){ echo "align='right' style='padding-right: 20px' "; }
								// if col[0] = item code, make item code and description links
								if(preg_match('/Item Code/i', $headers[0])){
								//if($headers[0] == "Item Code"){
									if($k == "0" || $k == "1"){
										$url = $sURL . $columns[0] . "#gsc.tab=0&gsc.q=" . $columns[0];
										$link = $v;
										$tracking = "onClick=\"_gaq.push(['_trackEvent', 'Promo Page', 'Item', '" . $columns[0] . "']);\"";
									}
								}

								if(preg_match('/\[(url=.*)\]/',$v)){
									str_replace(array("\r", "\n"), '', trim($v));
									$start = strpos($v, "=") + 1;
									$end = strpos($v, "]") - $start;
									$x = explode("|", substr($v, $start, $end));
									$url =  $x[1];
									$link = $x[0];
									$tab = $x[2];
									
								}

								if($url != ""){ ?>
									<a href="<?php echo $url;?>" <?php if($tab == "new"){ echo "target='_blank' "; } echo $tracking; ?>><?php echo $link; ?></a>
						<?php	}
								else{
									echo $v;
								}

								echo "</td>";
								
						} ?> 
					</tr>	

		<?php		}
						}
						$n++;

					}
				} ?>
					</tbody>
				</table>  
	<?php
			}



		}
		else{ ?>
			  




<table padding="6" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#616265; border:solid 1px #C0C0C0; border-collapse: collapse;" width="700" border="0" cellspacing="0">
	<tbody>
<?php 	$n = 0;
		foreach($items as $i){
			$columns = explode("\t", $i);
			if($n == 0){ 
				$headers = $columns?>
				<tr style="font-weight:bold; color:#555759; background-color:#e0edf9;">
					<td valign="middle" width="2%"  height="48" >&nbsp;</td>
            
		        <?php 	foreach($headers as $h){
		        			if($h == "Description"){ $width = ""; } elseif($h == "Item Code"){ $width = "20%"; } else { $width = "15%"; } 

		        			if(preg_match('/[0-9]+%/',$h,$w)){
		        				$width = $w[0];
		        				// remove the reference
		        				$h = preg_replace('/\[([0-9]+%)\]/','',$h);
		        			}

		        			if(preg_match('/price/i', $h)){
								$style = "style='padding-right: 20px; text-align: right;'";
							}
							else{
								$style = "";
							}

		        				?>
					<td valign="middle" width="<?php echo $width; ?>" <?php echo $style; ?>><?php echo $h; ?></td>
				<?php
							}	 ?>    
		        </tr>
	<?php	}
			else{ ?>
				<tr <?php if($n % 2 == 0){?>style="background-color:#f3f3f3;" <?php } ?>>
					<td height="47">&nbsp;</td>
				<?php 	foreach($columns as $k => $v){
							$tracking = "";
							if(preg_match('/price/i', $headers[$k])){
								$style = "style='padding-right: 20px; text-align: right;'";
							}
							elseif(preg_match('/Pack Size/i', $headers[$k])){
								$style = "style='text-align: center;'";
							}
							else{
								$style = "";
							}

							echo "<td " . $style . ">";
							//if(preg_match('/.*price.*$/i', $headers[$k])){ echo "align='right' style='padding-right: 20px' "; }
							$url = "";
							$tab = "";
							// if col[0] = item code, make item code and description links
							if(preg_match('/Item Code/i', $headers[0])){
							//if($headers[0] == "Item Code"){
								if($k == "0" || $k == "1"){
									$url = $sURL . $columns[0] . "#gsc.tab=0&gsc.q=" . $columns[0];
									$link = $v;
									//$tab = "new";
									$tracking = "onClick=\"_gaq.push(['_trackEvent', 'Promo Page', 'Item', '" . $columns[0] . "']);\"";
								}
							}

							if(preg_match('/\[(url=.*)\]/',$v)){
								str_replace(array("\r", "\n"), '', trim($v));
								$start = strpos($v, "=") + 1;
								$end = strpos($v, "]") - $start;
								$x = explode("|", substr($v, $start, $end));
								$url =  $x[1];
								$link = $x[0];
								$tab = $x[2];
								
							}

							if($url != ""){ ?>
								<a href="<?php echo $url;?>" <?php if($tab == "new"){ echo "target='_blank' "; } echo $tracking; ?>><?php echo $link; ?></a>
					<?php	}
							else{
								echo $v;
							}

							echo "</td>";
							
					} ?> 
				</tr>	

	<?php	}
			

			$n++;
		} ?>	
    </tbody>
</table>    


<?php	}
	} ?>

<table width="700" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr valign="bottom">
            <td height="20">
            
            </td>
        </tr>
  </tbody>
</table>

<?php 	if($p['resources'] != "" || $p['related'] != ""){ ?>
	<table width="700" border="0" cellspacing="0" cellpadding="0" style="background-color: #f3f3f3;">
	  <tr>
	    <td width="10">&nbsp;</td>
	    <td width="300" valign="top" <?php if($p['related'] == ""){ echo 'colspan="3"'; } ?>>
	    	<h2>Resources and Support</h2>
	    	<ul>
			<?php foreach($resources as $res){
				$parts = explode("|",$res);
				// 0 = text, 1 = URL, 2 = tab (new or parent), OPTIONAL{ 3 = Event Action, 4 = Event Label } ?>
			<li style="margin-bottom:10px;"><a href="<?php echo $parts[1]; ?>" <?php if(preg_match('/new/',$parts[2])){ echo "target='_blank' "; } if(isset($parts[3])){ echo "onClick=\"_gaq.push(['_trackEvent', 'Promo Page', '" . $parts[3] . "', '" . $parts[4] . "']);\""; }?> ><?php echo $parts[0]; ?></a></li>
	<?php		} ?>
	    	</ul>
	    </td>
<?php if($p['related'] != ""){ ?>	    
	    <td width="20">&nbsp;</td>
	    <td width="300" valign="top">
	    	
	    	<h2>Related Products</h2>
	    	<ul>
			<?php foreach($related as $rel){
				$parts = explode("|",$rel); ?>
			<li style="margin-bottom:10px;"><a href="<?php echo $parts[1]; ?>" <?php if(preg_match('/new/',$parts[2])){ echo "target='_blank'"; } if(isset($parts[3])){ echo "onClick=\"_gaq.push(['_trackEvent', 'Promo Page', '" . $parts[3] . "', '" . $parts[4] . "']);\""; } ?> ><?php echo $parts[0]; ?></a></li>
	<?php		} ?>
	    	</ul>
	    	
	    </td>
<?php } ?>
	  </tr>
	  <tr>
	    <td height="10">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	  </tr>
	</table>

	<table width="700" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr valign="bottom">
            <td height="20">
            
            </td>
        </tr>
  </tbody>
</table>
<?php
} ?>

<?php	if($p['terms'] != ""){ ?>
<table width="700" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td width="700px" valign="top" style="font-family:Arial, Helvetica, sans-serif; Line-height: 22px; font-size:11px; color:#888; "><b>Terms &amp; Conditions</b><br>
           <?php echo nl2br($p['terms']); ?>
       		</td>
        </tr>
    </tbody>
</table>
<?php } ?>
	

<!-- ############ CODE ENDS ############# -->