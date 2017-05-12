<?php 


include("includes/db.php");
//error_reporting(0);
$sql = "SELECT * FROM `webpromopods` ORDER BY `order`";
$r = $conn->query($sql);
$p = $r->fetch_assoc();

$site = "";

// Turn on output buffering
ob_start();

include "promopods_au_bare.php";
// At the end of the PHP script, write the buffered content to a file
$content = ob_get_clean();
file_put_contents("pages/promopods.html", $content);
?>


<a href="pages/promopods.html" download>Get File</a>
<br>
<?php 
// Output the HTML to the browser
print $content;

?>