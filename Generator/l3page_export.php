<?php 


include("includes/db.php");
//error_reporting(0);
$sql = "SELECT * FROM `webl3pages` p WHERE p.id = " . $_GET['id'];
$r = $conn->query($sql);
$p = $r->fetch_assoc();

// Turn on output buffering
ob_start();

include "l3page_au_bare.php";
// At the end of the PHP script, write the buffered content to a file
$content = ob_get_clean();
$pageName = 'l3_' . $p['name'] . '_' . $p['country'];
file_put_contents("pages/" . $pageName . ".html", $content);

include("includes/header.php");

?>
<!-- https://highlightjs.org/  -->
<link rel="stylesheet" type="text/css" href="../__resources/css/atom-one-light.css">
<script src="../__resources/js/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Images</h4>
      </div>
      <div class="modal-body">
      	Click on each image to save for submission<br>
      	<br>
        <div class="row" id="imagelist"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="hiddenCode" style="display: none;"><?php print $content; ?></div>

<br>
<a href="pages/<?php echo $pageName; ?>.html" download class="btn btn-success btn-xs" style="width: 80px;">Get File</a>&nbsp;&nbsp;
<button type="button" id="listImages" download class="btn btn-success btn-xs" style="width: 80px;" data-toggle="modal" data-target="#myModal">Images</button>&nbsp;&nbsp;
<a href="l3page_i.php" class="btn btn-primary btn-xs" style="width: 80px;">List</a>&nbsp;&nbsp;
<a href="l3page_au_v.php?id=<?php echo $_GET['id']; ?>" class="btn btn-primary btn-xs" style="width: 80px;">View Page</a>
<br>
<br>



<div style="width: 70%;">
<pre><code class="html" id="thecode"><?php print htmlentities($content); ?></code></pre></div>
<br>
<br>
<?php 
// Output the HTML to the browser
print $content;


include("includes/footer.php");

?>