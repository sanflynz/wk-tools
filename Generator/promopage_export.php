<?php 


include("includes/db.php");
//error_reporting(0);
$sql = "SELECT * FROM `webpromopages` p WHERE p.id = " . $_GET['id'];
$r = $conn->query($sql);
$p = $r->fetch_assoc();

// Turn on output buffering
ob_start();

include "promopage_au_bare.php";
// At the end of the PHP script, write the buffered content to a file
$content = ob_get_clean();
$pageName = $p['name'] . '_' . $p['country'];
file_put_contents("pages/" . $pageName . ".html", $content);
?>


<a href="pages/<?php echo $pageName; ?>.html" download>Get File</a>
<br>
<br>
<br>
<?php echo
// Output the HTML to the browser
print $content;




?>