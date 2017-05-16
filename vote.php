<?php
	class Vote{
		private $Aadhaar_No;
		private $Constituency_No;
		private $Candidate_No;
		private $Political_party;
		private $Timestamp;
		private $Ip_Address;
		
		function __construct($data){
			$this->Aadhaar_No = $data[0];
			$this->Constituency_No = $data[1];
			$this->Candidate_No = $data[2];
			$this->Timestamp = $data[3];
			$this->Ip_Address = $data[4];
			$this->Political_party = $data[5];
		}
		
		function getAadhaar_No(){
			return $this->Aadhaar_No;
		}
		
		function getConstituency_No(){
			return $this->Constituency_No;
		}
		
		function getCandidate_No(){
			return $this->Candidate_No;
		}
		
		function getTimestamp(){
			return $this->Timestamp;
		}
		
		function getIp_Address(){
			return $this->Ip_Address;
		}
		
		function getPolitical_party(){
			return $this->Political_party;
		}
	}
?>