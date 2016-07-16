<?php 
include("includes/db.php");
include("includes/header_" . $_SESSION['environment'] . ".php"); 

    echo $rowAc['home_content'];
 ?>

    
    
<?php include("includes/footer_" . $_SESSION['environment'] . ".php"); ?>