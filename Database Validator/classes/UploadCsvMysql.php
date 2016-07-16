<?php

	class UploadCsvMysql{

		public $error = "";
		public $success = "";
		public $conn;
		public $file;


		public function __construct($connection){
			$this->conn = $connection;
		}
		
		function test(){
			print_r($_FILES);
		}

		function upload($table, $cols){  // cols = column headings

			if(!isset($_FILES)){ // Not working?
				$this->error .= "You must select a file<br>";
			}
			else{
				//echo "we're in!<br>";
				$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
				if(in_array($_FILES['uploadfile']['type'],$mimes)){
					$file = $_FILES['uploadfile']['tmp_name'];

					//echo "file type okay: " . $file . "<br>";
					//$escString = "\\";
					$sql = "LOAD DATA LOCAL INFILE '" . addslashes($file) ."'
							INTO TABLE " . $table . " 
							FIELDS TERMINATED BY ',' 
							OPTIONALLY ENCLOSED BY '\"' 
							LINES TERMINATED BY '\n' 
							IGNORE 1 ROWS 
							(" . $cols . ") 
							 SET ID = NULL";
					
					if ($this->conn->query($sql) === TRUE) {
						$this->success .= "Records uploaded successfully<br>";
					} else {
						$this->error .= "Unable to upload all records: " . $this->conn->error;
						//echo "<br><br>" . $sql;
						
					}

				
				} else {
					$this->error .= "File type not allowed";
				}
				
			}

		}

		function uploadCreate($table){

					$this->uploadFile();

					// read the first row to get headers
					if (($handle = fopen($this->file, "r")) !== FALSE) {
						$headers = fgetcsv($handle);
						
					    fclose($handle);
					    
					    if($headers[0] != 'id'){
					    	$this->error .= "The first column in your table should be id (okay if values are blank)";
					    	//echo $this->error;
					    }
					    else{

					    	$cols = "";
					    	foreach($headers as $h){
					    		if($h != "id"){
					    			$cols .= "`" . $h . "` varchar(250) NOT NULL, ";
					    		}
					    	}

					    	// FIRST ROW IS ID, ALL OTHER ROWS VARCHAR(250);	
					    	$sql = "CREATE TABLE IF NOT EXISTS `". $table . "` ( `id` int(10) NOT NULL AUTO_INCREMENT, " . $cols . "PRIMARY KEY (`id`) ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1"; 

							//$r = $conn->query($sql);
							if($this->conn->query($sql) === TRUE){

								$i = 1;
								$cols = "";
						    	foreach($headers as $h){
						    		$cols .= "`" . $h . "`";
						    		
						    		if($i < count($headers)){ $cols .= ", "; }
						    		$i++;
						    	}
									
								$sql2 = "LOAD DATA LOCAL INFILE '" . addslashes($this->file) ."'
									INTO TABLE " . $table . " 
									FIELDS TERMINATED BY ',' 
									OPTIONALLY ENCLOSED BY '\"' 
									LINES TERMINATED BY '\n' 
									IGNORE 1 ROWS 
									(" . $cols . ") 
									 SET ID = NULL";
							
									if ($this->conn->query($sql2) === TRUE) {
										$this->success .= "Records uploaded successfully<br>";
									} else {
										$this->error .= "Unable to upload all records: " . $this->conn->error;
										//echo "<br><br>" . $sql;
										
									}


							}   	
							else{
								$this->error .= "There was an error creating the table " . $table . ": " . $this->conn->error;
							}


					    }

					

					}


		}

		function uploadFile(){
			if(!isset($_FILES)){ // Not working?
				$this->error .= "You must select a file<br>";
			}
			else{
				//echo "we're in!<br>";
				$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
				if(in_array($_FILES['uploadfile']['type'],$mimes)){
					$this->file = $_FILES['uploadfile']['tmp_name'];
				}
			}		
		}



	}


?>