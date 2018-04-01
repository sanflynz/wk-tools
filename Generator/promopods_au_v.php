<?php 

include("includes/db.php");
include("includes/header_web_au.php"); 

if(isset($_GET['site'])){
    if(strtolower($_GET['site']) == "nz"){
        $site = "http://www.thermofisher.co.nz";
    }
    elseif(strtolower($_GET['site']) == "au"){
        $site = "http://www.thermofisher.com.au";
    }
}



// if($p['country'] == "New Zealand"){
// 	$sURL = "http://www.thermofisher.co.nz/search.aspx?search=";
// }
// elseif($p['country'] == "Australia"){
// 	$sURL = "http://www.thermofisher.com.au/search.aspx?search=";
// }

include ("promopods_au_bare.php");



?>


<table width="700" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr valign="bottom">
            <td height="20">
            	<br><br><br><br>
            	<a href="promopods_e.php?title=<?php echo $_GET['title']; ?>&site=<?php echo $_GET['site']; ?>" class="btn btn-commerce">Edit</a>
            	<a href="promopods_export.php?title=<?=$_GET['title']; ?>&site=<?php echo $_GET['site']; ?>" class="btn btn-commerce">Export</a>
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