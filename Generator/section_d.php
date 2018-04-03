<?php 

	if(isset($_POST['id'])){
		include("includes/db.php");
		$sql = "DELETE FROM sections WHERE id = '" . $_POST['id'] . "'";
		$r = $conn->query($sql);
		if($r){
			echo 'success';
		}
		else{
			echo 'Error: ' . $conn->error;
		}

		
	}
	else{
		echo 'Error: section ID was not passed';
	}




 ?>