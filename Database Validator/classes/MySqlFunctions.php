<?php

	class MySqlFunctions{

		public $error = "";
		public $success = "";
		public $conn;

		public function __construct($connection){
			$this->conn = $connection;
		}
		
		function getHeaders($table){

			//$sql = "SELECT * FROM INFORMATION_SCHEMA.all_cst";

			$r = $this->conn->query("DESCRIBE " . $table);

			$headers = "";
			$i = 1;
			while($row = $r->fetch_assoc()){
				$headers .= trim($row['Field']);
				if($i < $r->num_rows){ $headers .= ","; }
				$i++;
			}

			return $headers;

		}


	}

?>