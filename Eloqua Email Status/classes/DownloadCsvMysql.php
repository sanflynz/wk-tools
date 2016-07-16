<?php


class DownloadCsvMysql{

	public $error = "";
	public $success = "";
	public $conn;
	public $filename = "output.csv";


	public function __construct($connection){
		$this->conn = $connection;
		
	}

	function download($table){ // MAKE THIS ONE SO IT DOWNLOADS ALL ROWS AND COLUMNS

		// Get Column Names
		$r = $this->conn->query("SELECT COLUMN_NAME
							  FROM INFORMATION_SCHEMA.COLUMNS
							  WHERE table_name = '" . $table . "'");
		
		$headers = array();
		while($row = $r->fetch_assoc()){
			$headers[] = $row['COLUMN_NAME'];
		}
		
		ob_end_clean();

		header("Content-type: text/csv");
		header("Content-disposition: attachment; filename = " . $this->filename);
		
		$new_csv = fopen('php://output', 'w');
		
		fputcsv($new_csv, $headers);
		
		$r = $this->conn->query("SELECT * FROM " . $table);
		$row = 1;

		while($l = $r->fetch_assoc()){
			fputcsv($new_csv, $l);
		}
		
		fclose($new_csv);
		exit();



	}

	function downloadSQL($sql,$cols,$headers){

		//echo "were in";
		ob_end_clean();

		header("Content-type: text/csv");
		header("Content-disposition: attachment; filename = " . $this->filename);
		
		$new_csv = fopen('php://output', 'w');
		
		$cArray = explode(',',$cols);
		
		if(isset($headers)){
			$hArray = explode(',',$headers);
			fputcsv($new_csv, $hArray);
		}
		else{
			
			fputcsv($new_csv, $cArray);
		}
		
		$r = $this->conn->query($sql);
		$row = 1;
		

		while($e = $r->fetch_assoc()){
			$line = array();
			foreach($cArray as $c){
				$line[] = $e[$c];
			}
			fputcsv($new_csv, $line);
		}
		
		fclose($new_csv);
		exit();


		// output headers so that the file is downloaded rather than displayed
		//readfile("/tmp/report.csv");

	}



}


?>