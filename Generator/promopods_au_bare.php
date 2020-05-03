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
			            	<a href="#" target="_blank"><img src="/Uploads/image/landing-page-banner-image.jpg" style="border: 1px solid grey; width: 640px; height: 300px;"></a>
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
		if($i == 1){ 
			echo "<table width=\"980\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
			echo "\t<tr>\n";
		}
			echo "\t\t<td width=\"315\" valign=\"top\">\n";

		    echo "\t\t\t<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"310\" style=\"border:1px solid #C9C8C8; padding: 8px;\">\n";
		    echo "\t\t\t\t<tr>\n";
		    echo "\t\t\t\t\t<td style=\"color: #FFFFFF; font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 20px; line-height:1.33\" valign=\"middle\" width=\"105\" height=\"100\" bgcolor=\"#ee2d35\" align=\"center\">\n";
		    echo "\t\t\t\t\t\t" . $row['offer'];
		    echo "\t\t\t\t\t</td>\n";
		    echo "\t\t\t\t\t<td width=\"10\">&nbsp;</td>\n";
		    echo "\t\t\t\t\t<td width=\"200\">\n";
		    echo "\t\t\t\t\t\t<h3><a onClick=\"_gaq.push(['_trackEvent', 'Promotions', '" . $row['promo_name'] . "', '" . $row['item_name'] . "']);\" href=\"" . $site . $row['url'] ."\" style=\"font-size: 18px; line-height: 21px;\" " . $target . ">" . $row['offer_detail'] . "</a></h3>";
		    echo "\t\t\t\t\t</td>";
		    echo "\t\t\t\t</tr>";
		    echo "\t\t\t\t<tr>";
		    echo "\t\t\t\t\t<td width=\"100\" height=\"10\">&nbsp;</td>";
		    echo "\t\t\t\t\t<td width=\"10\" height=\"10\">&nbsp;</td>";
		    echo "\t\t\t\t\t<td width=\"200\" height=\"10\">&nbsp;</td>";
		    echo "\t\t\t\t</tr>";
		    echo "\t\t\t\t<tr>";
		    echo "\t\t\t\t\t<td height=\"100\" colspan=\"3\" align=\"center\">";
		    echo "\t\t\t\t\t\t<img src=\"" . $site . $row['image'] . "\" style=\"background-color: #6E6E6E\" alt=\"\" width=\"294\" height=\"150\">";
		    echo "\t\t\t\t\t</td>";
		    echo "\t\t\t\t</tr>";
		    echo "\t\t\t\t<tr>";
		    echo "\t\t\t\t\t<td colspan=\"3\" height=\"10\">&nbsp;</td>";
		    echo "\t\t\t\t</tr>";
		    echo "\t\t\t\t<tr>";
		    echo "\t\t\t\t\t<td colspan=\"3\" valign=\"top\" height=\"50\">" . $row['tagline'] . "<br>";
		    echo "\t\t\t\t\t\t<a href=\"" . $site . $row['url'] . "\" " . $target . " onClick=\"_gaq.push(['_trackEvent', 'Promotions', '" . $row['promo_name'] . "', '" . $row['item_name'] . "']);\">" . $row['call_to_action'] . "</a>";
		    echo "\t\t\t\t\t</td>";
		    echo "\t\t\t\t</tr>";
		    echo "\t\t\t</table>";
		    echo "\t\t</td>";
		


		if($i == 3){
			echo "\t</tr>";
			echo "</table>";
			echo "<table width=\"980\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
			echo "\t<tbody>";
			echo "\t\t<tr>";
			echo "\t\t\t<td height=\"15\">&nbsp;</td>";
			echo "\t\t</tr>";
			echo "\t</tbody>";
			echo "</table>";
			$i = 1;
		}
		else{ 
			echo "\t\t<td width=\"15\">&nbsp;</td>";
			$i++;
		}
}

if($i > 1){
	while($i > 1){ 
			echo "\t\t<td width=\"315\" valign=\"top\">";
			echo "\t\t\t<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"310\">";
			echo "\t\t\t\t<tr>";
		    echo "\t\t\t\t\t<td width=\"100\" height=\"10\">&nbsp;</td>";
		    echo "\t\t\t\t\t<td width=\"10\" height=\"10\">&nbsp;</td>";
		    echo "\t\t\t\t\t<td width=\"200\" height=\"10\">&nbsp;</td>";
		    echo "\t\t\t\t</tr>";
		    echo "\t\t\t</table>";
		    echo "\t\t</td>";

		if($i == 3){
			echo "\t</tr>";
			echo "</table>";
			echo "<table width=\"980\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
			echo "\t<tbody>";
			echo "\t\t<tr>";
			echo "\t\t\t<td height=\"15\">&nbsp;</td>";
			echo "\t\t</tr>";
			echo "\t</tbody>";
			echo "</table>";
			$i = 1;
		}
		else{ 
			echo "<td width=\"15\">&nbsp;</td>";            
			
			$i++;	
		}
		
	}

}

?>