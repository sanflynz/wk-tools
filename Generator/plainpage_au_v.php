<?php 

include("includes/db.php");
include("includes/header_web_au.php"); 

$sql = "SELECT * FROM `webpromopages` p WHERE p.id = " . $_GET['id'];
$r = $conn->query($sql);
$p = $r->fetch_assoc();



// if($p['country'] == "New Zealand"){
// 	$sURL = "http://www.thermofisher.co.nz/search.aspx?search=";
// }
// elseif($p['country'] == "Australia"){
// 	$sURL = "http://www.thermofisher.com.au/search.aspx?search=";
// }

include ("plainpage_au_bare.php");

?>




<table width="700" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr valign="bottom">
            <td height="20">
            	<br><br><br><br>
            	<a href="plainpage_e.php?id=<?php echo $_GET['id'];?>" class="btn btn-commerce">Edit</a>
            	<a href="plainpage_i.php" class="btn btn-commerce">List</a>
            	<a href="plainpage_export.php?id=<?php echo $_GET['id'];?>" target="_blank" class="btn btn-commerce">Export</a>
            </td>
        </tr>
  </tbody>
</table>


<?php

include("includes/footer_web_au.php"); ?>