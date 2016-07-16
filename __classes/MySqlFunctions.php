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
			if($this->conn->error){
				$this->error = $this->conn->error;
			}
			else{
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


		function colsToAlias($cols,$tableAlias){
			
			//eg: columnAlias = tableAlias__column

			//$cols = explode(",", $this->getHeaders($table));

			//$columns;
			foreach($cols as $c){
				$output[] = "`" . $tableAlias . "`.`" . $c . "` AS '" . $tableAlias . "__" . $c . "'"; 
			}

			return implode(",", $output);

		}

		function aliasToArray($result){
			while($row = $result->fetch_assoc()){

				foreach($row as $k => $v){
					$t_c = explode("__", $k);
					$a[$t_c[0]][$t_c[1]] = $v; 
				}
				$array[] = $a;
				
			}

			return $array;
		}

		function aliasArrayToArray($result){
			foreach($result as $arr){

				foreach($arr as $k => $v){
					$t_c = explode("__", $k);
					$a[$t_c[0]][$t_c[1]] = $v; 
				}
				$array[] = $a;
				
			}

			return $array;
		}		


		




	}

?>