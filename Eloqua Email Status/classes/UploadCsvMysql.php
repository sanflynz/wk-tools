<?php

	class UploadCsvMysql{

		public $error = "";
		public $success = "";
		public $conn;


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
							(" . $cols . ")";
							 
							 //SET ID = NULL";

					
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


		function update($table, $cols, $key){
			// $cols = columns to update
			// $key = index to match (should also be in file)
			
			if(!isset($_FILES)){ // Not working?
				$this->error .= "You must select a file<br>";
			}
			else{
				//echo "we're in!<br>";
				$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
				if(in_array($_FILES['uploadfile']['type'],$mimes)){
					$file = $_FILES['uploadfile']['tmp_name'];

					$tableCols = "";
					$i = 1;
					$theCols = explode(",", $cols);
					array_unshift($theCols, $key);
					
					foreach($theCols as $c){

						$tableCols .= "`" . $c . "` ";

						$r = $this->conn->query("SELECT COLUMN_TYPE
							  FROM INFORMATION_SCHEMA.COLUMNS
							  WHERE table_name = '" . $table . "' AND column_name = '" . $c . "'");
					
						if($r){
							while($row = $r->fetch_assoc()){
								$tableCols .= " " . $row['COLUMN_TYPE'];
							}
						}
						
						if($i < count($theCols)){
							$tableCols .= ", ";
						}

						$i++;

					}
					// Create a temporary table
					if($this->conn->query("CREATE TEMPORARY TABLE tmp_table (" . $tableCols . ")")){
						
						$allCols = $key . "," . $cols;
						$r = $this->conn->query("SELECT *
							  FROM INFORMATION_SCHEMA.COLUMNS
							  WHERE table_name = 'tmp_table'");

						$sql = "LOAD DATA LOCAL INFILE '" . addslashes($file) ."'
							INTO TABLE tmp_table 
							FIELDS TERMINATED BY ',' 
							OPTIONALLY ENCLOSED BY '\"' 
							LINES TERMINATED BY '\n' 
							IGNORE 1 ROWS 
							(" . $allCols . ")";
					
						if ($this->conn->query($sql) === TRUE) {
							$this->success .= "Records uploaded successfully<br>";

							
							$setFields = "";
							$i = 1;
							$theCols = explode(",",$cols);
							foreach($theCols as $c){
								$setFields .= "`" . $table . "`.`" . $c . "` = `tmp_table`.`" . $c . "`";
								if($i < count($theCols)){
									$setFields .= ",";
								}
								$i++;
							}

							//$sql = "UPDATE `" . $table . "`
							//INNER JOIN `tmp_table` on `tmp_table`.`" . $key . "` = `" . $table . "`.`" . $key . "` 
							//SET " . $setFields;
							//echo $sql;
							//SET `" . $table . "`.`" . $key . "` = `tmp_table`.`" . $key . "`";


							$sql = "UPDATE " . $table . ",tmp_table SET " . $setFields . " WHERE " . $table."." . $key . "=tmp_table." . $key;

							if ($this->conn->query($sql) === TRUE) {
								$this->success .= "ERROR: Records updated successfully";
							}
							else{
								$this->error .= "ERROR: Unable to update records "  . $this->conn->error . "<br>" . $sql;
							}


						} else {
							$this->error .= "Unable to upload all records into tmp_table: " . $this->conn->error;
							//echo "<br><br>" . $sql;
							
						}
					
						


					}
					else{
						$this->error .= "ERROR: Unable to create temporary table"  . $this->conn->error;
					}

					
					//echo "file type okay: " . $file . "<br>";
					//$escString = "\\";
					

				
				} else {
					$this->error .= "File type not allowed";
				}
				
			}


		}


	}





?>