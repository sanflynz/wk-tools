<?php

class UploadFile{

	public $status = true;
	public $conn;
	public $file;
	public $fileTypes = array('image/jpeg','image/gif','image/png','text/plain','application/ms-word');
	public $destination;

	public function __construct($connection, $destination){
		$this->conn = $connection;
		$this->destination = $destination;
	}
	
	function test($file){
		print '<pre>'; 
		print_r($file);
		print '</pre>';

		setFlash("info", "this is a flash message!");
	}

	// IMAGES
	function upload($file){
			
		 	//$target_file = $location . basename($file['name']);
		 	//if(getimagesize($file['tmp_name'])){
 		if($file['error'] == 0){
	 		if(move_uploaded_file($file['tmp_name'], $this->destination . basename($file['name']))){
	 			
	 			setFlash("success", "File " . $file['name'] . " was uploaded");
	 			$this->status = true;
	 			//$success .= "Image " . $file['name'] . " was uploaded<br><br>";
	 			//$_POST['image'] = substr($target_file,8);

	 		}
	 		else{
	 			setFlash("danger", "Unable to upload " . $file['name']);
	 			$this->status = false;
	 			//$error .= "Image was not uploaded <a href=" . $location . ">" . $locations . "</a><br><br>";
	 		}
	 	}
	 	elseif($file['error'] == 1 || $file['error'] == 2){
	 		setFlash("danger", "Unable to upload " . $file['name'] . ", file is too large");
	 		$this->status = false;
	 	}
	 	elseif($file['error'] != 4){
	 		setFlash("danger", "Unable to upload " . $file['name']);
	 		$this->status = false;
	 	}
		 	//}
		 	// else{
		 	// 	$error .= "File is not an image<br><br>";
		 	// }
			//return array("error" => $error, "success" => $success);
		
		return $this->status;

	}

			
}

?>