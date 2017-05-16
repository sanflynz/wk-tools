<?php
	include("includes/db.php");

	if(isset($_GET['id'])){

		$sql = "DELETE FROM webpromopages WHERE id = " . $_GET['id'];
		$r = $conn->query($sql);
		header("location: promopage_i.php");

	}

	?>