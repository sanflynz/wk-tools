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

include("includes/header.php");

?>


<link rel="stylesheet" type="text/css" href="../__resources/css/atom-one-light.css">
<script src="../__resources/js/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<br>
<a href="pages/promopods.html" download class="btn btn-success btn-xs" style="width: 80px;">Get File</a>&nbsp;&nbsp;
<!--<button type="button" id="listImages" download class="btn btn-success btn-xs" style="width: 80px;" data-toggle="modal" data-target="#myModal">Images</button>&nbsp;&nbsp; -->
<a href="promopods_e.php?title=<?php echo $_GET['title']; ?>" class="btn btn-primary btn-xs" style="width: 80px;">Edit</a>&nbsp;&nbsp;

<br>
<br>



<div style="width: 70%;">
<pre><code class="html" id="thecode"><?php print htmlentities($content); ?></code></pre>
</div>
<br>
<br>

<?php 
// Output the HTML to the browser
//print $content;

include("includes/footer.php");

?>