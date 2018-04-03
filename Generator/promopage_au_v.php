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

include ("promopage_au_bare.php");

?>

<input type="hidden" id="country" value="<?=$p['country'];?>">



<table width="700" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr valign="bottom">
            <td height="20">
            	<br><br><br><br>
            	<a href="promopage_e.php?id=<?php echo $_GET['id'];?>" class="btn btn-commerce local">Edit</a>
            	<a href="promopage_i.php" class="btn btn-commerce local">List</a>
            	<a href="promopage_export.php?id=<?php echo $_GET['id'];?>" class="btn btn-commerce local">Export</a>
            </td>
        </tr>
  </tbody>
</table>

<script>
document.addEventListener("DOMContentLoaded", hideSide);
function hideSide(){
    $("#side").hide();
}    
</script>

<?php

include("includes/footer_web_au.php"); ?>