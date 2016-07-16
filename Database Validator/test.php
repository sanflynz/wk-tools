
<?php 	include('includes/header.php');

$r = $conn->query("SELECT * FROM email_chk WHERE id = 865");
$row = $r->fetch_assoc();

print_r($row);
		
		
?>


<div class="row">
	

	
	


</div>






<?php include('includes/footer.php');	?>