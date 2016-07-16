<?php
	include("includes/db.php");


	if(isset($_GET['environment']) && $_GET['environment'] == "toggle"){

		if($_SESSION['environment'] == "local"){
			$_SESSION['environment'] = "production";
		}
		elseif($_SESSION['environment'] == "production"){
			$_SESSION['environment'] = 'local';
		}

		echo $_SESSION['environment'];

	}


	if(isset($_GET['activeConference'])){

		$_SESSION['activeConference'] = $_GET['activeConference'];

		//$r = $conn->query("SELECT name FROM conferences WHERE id = " . $_GET['id']);
		//$row = $r->fetch_assoc();
		//$_SESSION['activeConferenceName'];
		//echo $row['name'];

	}

	if(isset($_GET['unsetActiveConference'])){
		unset($_SESSION['activeConference']);
	}



	if(isset($_GET['cpOrder'])){

		// $_GET['cpid']
		// $_GET['dir']
		// $_GET['order']

		if($_GET['dir'] == "down"){
			$r = $conn->query("UPDATE conference_products SET `order` = " . ($_GET['order'] -1) . " WHERE id = " . $_GET['cpid']);
			return ($_GET['order'] -1);
		}
	}

?>