<?php
	include("includes/db.php");

	if(isset($_GET['id'])){

		$sql = "DELETE FROM pages WHERE id = " . $_GET['id'];
		$r = $conn->query($sql);

		$sql = "DELETE FROM sections WHERE page_id = " . $_GET['id'];
		$r = $conn->query($sql);

		header("location: l2page_i.php");

	}

	?>