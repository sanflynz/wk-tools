<?php 

//include("includes/db.php");

$sql = "SELECT * FROM `webplainpages` p WHERE p.id = " . $_GET['id'];
$r = $conn->query($sql);
$p = $r->fetch_assoc();



// if($p['country'] == "New Zealand"){
// 	$sURL = "http://www.thermofisher.co.nz/search.aspx?search=";
// }
// elseif($p['country'] == "Australia"){
// 	$sURL = "http://www.thermofisher.com.au/search.aspx?search=";
// }

?>

<!-- ############ CODE STARTS ############# -->

<?php echo $p['content']; ?>
	

<!-- ############ CODE ENDS ############# -->




