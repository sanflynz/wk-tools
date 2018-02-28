<?php
	include("includes/db.php");

	if(isset($_GET['id'])){

		$sql = "DELETE FROM webl3pages WHERE id = " . $_GET['id'];
		$r = $conn->query($sql);
		header("location: l3page_i.php");

	}

	?>