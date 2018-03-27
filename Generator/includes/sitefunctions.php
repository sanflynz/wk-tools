<?php
function flash(){
	// print all the flash messages if set
	if(isset($_SESSION['flash'])){
		foreach ($_SESSION['flash'] as $flash){
			echo "<div class=\"alert alert-" . $flash['class'] . "\">";
			echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
			echo "<strong>" . ucwords($flash['class']) . ":</strong> " . $flash['msg'];
			echo "</div>";
		}
		unset($_SESSION['flash']);
	}
}
function setFlash($class, $msg){
	//$classes = array('danger','warning','success','info');
	$_SESSION['flash'][] = array("class" => $class,"msg" => $msg);
}	

?>