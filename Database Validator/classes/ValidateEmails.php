<?php

class ValidateEmail{
	

	public function checkFormat($email){
		$format = (filter_var($email, FILTER_VALIDATE_EMAIL)) ? '1' : '0'; 
		return $format;
	}

	public function checkDomain($email){
		$domain = (checkdnsrr(array_pop(explode("@",$email)),"MX")) ? '1' : '0';
		return $domain;
	}

	public function checkall($email){

		$myarray = array(
				"present" => "0",
				"format" => "0" ,
				"domain" => "0",
				"final" => "0"	
				);

		if(empty($email)){
			return $myarray;
		}
		else{
			$myarray["present"] = "1";

			$myarray["format"] = $this->checkFormat($email);
			$myarray["domain"] = $this->checkDomain($email);

			if($myarray["present"] == "1" && $myarray["format"] == "1" && $myarray["domain"] == "1"){
				$myarray['final'] = "1";
			}

			return $myarray;
		}
	}


}



?>