<?php

$sql = "SELECT * FROM `webpromopods` ORDER BY `order`";
$r = $conn->query($sql);



$target = "";

if(!isset($_GET['site'])){
	$site = "";
}
 ?>

			<table width="980" border="0" cellpadding="0" cellspacing="0">
			    <tbody>
			        <tr>
			            <td>&nbsp;</td>
			        </tr>
			    </tbody>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" width="980">
			    <tbody>
			        <tr>
			            <td style="font-family: Arial, Helvetica, sans-serif; Line-height: 39.8px; font-size: 29px; color: #333;">
			            	<h1><?php if(isset($_GET['title'])){ echo $_GET['title']; } ?></h1>
			            </td>
			        </tr>
			    </tbody>
			</table>
			<table width="980" border="0" cellpadding="0" cellspacing="0">
			    <tbody>
			        <tr>
			            <td>&nbsp;</td>
			        </tr>
			    </tbody>
			</table>


	<!-- OPTIONAL PROMO HEADER 

			<table border="0" cellspacing="0" cellpadding="0" width="980">
			    <tbody>
			        <tr>
			            <td valign="top" bgcolor="#ececec" style="padding:15px;">
			            <h3 style="margin-bottom:10px;"><b>Optional title</b></h3>
			            <p>Some text can go here</p>
			            <p style="margin-top:25px;"><a href="#" class="btn btn-primary">A button can go here</a></p>
			            </td>
			            <td width="640">
			            	<a href="#" target="_blank"><img src="/Uploads/image/landing-page-banner-image.jpg" width="640" height="480" alt=""></a>
			            </td>
			        </tr>
			    </tbody>
			</table>

			<table width="980" border="0" cellpadding="0" cellspacing="0">
			    <tbody>
			        <tr>
			            <td>&nbsp;</td>
			        </tr>
			    </tbody>
			</table>
	-->


<?php
$i = 1;
while($row = $r->fetch_assoc()){
		$target = "";
		if(substr($row['url'],-4) == ".pdf"){
			$target = "target='_blank'";
		}
		if($i == 1){ ?>
			<table width="980" cellpadding="0" cellspacing="0" border="0">
				<tr>
<?php	} ?>
					<td width="315" valign="top">
		                <table border="0" cellspacing="0" cellpadding="0" width="310" style="border:1px solid #C9C8C8; padding: 8px;">
		                    <tr>
		                        <td style="color: #FFFFFF; font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 20px; line-height:1.33" valign="middle" width="105" height="100" bgcolor="#ee2d35" align="center">
		                            <?php echo $row['offer']; ?>
		                        </td>    
		                        <td width="10">&nbsp;</td>
		                        <td width="200">
		                            <h3><a onClick="_gaq.push(['_trackEvent', 'Promotions', '<?php echo $row['promo_name']; ?>', '<?php echo $row['item_name']; ?>']);" href="<?php echo $site . $row['url']; ?>" style="font-size: 18px; line-height: 21px;" <?php echo $target; ?>><?php echo $row['offer_detail']; ?></a></h3>
		                        </td>
		                    </tr>

		                    <tr>
		                        <td width="100" height="10">&nbsp;</td>
		                        <td width="10" height="10">&nbsp;</td>
		                        <td width="200" height="10">&nbsp;</td>
		                    </tr>

		                    <tr>
		                        <td height="100" colspan="3" align="center">
		                        	<img src="<?php echo $site . $row['image']; ?>" style="background-color: #6E6E6E" alt="" width="294" height="150">
		                        </td>
		                    </tr>

		                    <tr>
		                        <td colspan="3" height="10">&nbsp;</td>
		                    </tr>

		                    <tr>
		                        <td colspan="3" valign="top" height="50"><?php echo $row['tagline']; ?><br>
		                            <a href="<?php echo $site . $row['url']; ?>" <?php echo $target; ?> onClick="_gaq.push(['_trackEvent', 'Promotions', '<?php echo $row['promo_name']; ?>', '<?php echo $row['item_name']; ?>']);" ><?php echo $row['call_to_action']; ?></a>
		                        </td>
		                    </tr>
		                </table>
		            </td>

<?php	if($i == 3){	?>
				</tr>
			</table>
			<table width="980" border="0" cellspacing="0" cellpadding="0">
			    <tbody>
			        <tr>
			            <td height="15">&nbsp;</td>
			        </tr>
			    </tbody>
			</table>
<?php		$i = 1;
		}
		else{ ?>
					<td width="15">&nbsp;</td>            
			
<?php		$i++;
		}
}

if($i > 1){
	while($i > 1){ ?>
					<td width="315" valign="top">
		                <table border="0" cellspacing="0" cellpadding="0" width="310">
		                    <tr>
		                        <td width="100" height="10">&nbsp;</td>
		                        <td width="10" height="10">&nbsp;</td>
		                        <td width="200" height="10">&nbsp;</td>
		                    </tr>
		                </table>
		            </td>
<?php
		if($i == 3){	?>
				</tr>
			</table>
			<table width="980" border="0" cellspacing="0" cellpadding="0">
			    <tbody>
			        <tr>
			            <td height="15">&nbsp;</td>
			        </tr>
			    </tbody>
			</table>
<?php		$i = 1;
		}
		else{ ?>
					<td width="15">&nbsp;</td>            
			
<?php		$i++;	
		}
		
	}

}

?>