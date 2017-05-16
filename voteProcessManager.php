<?php
	//require('DBManager.php');
	require('vote.php');
	require('loginManager.php');
	class voteProcessManager{
		private $DBManagerObject;
		
		function __construct(){
			$this->DBManagerObject = new DBManager;
		}
		
		function listCandidate($const_no){
			$data = array($const_no,'Const_No');
			return $this->DBManagerObject->selectData($data,'candidate_db');
		}
		
		function saveVote($vote){
			$Aadhaar_No = $vote->getAadhaar_No();
			$Constituency_No = $vote->getConstituency_No();
			$Candidate_No = $vote->getCandidate_No();
			$Timestamp = $vote->getTimestamp();
			$IP_Address = $vote->getIp_Address();
			$Party = $vote->getPolitical_party();
			$data = array($Aadhaar_No,$Constituency_No,$Candidate_No,$Timestamp,$IP_Address,$Party);
			$result = $this->DBManagerObject->insertData($data,'vote_db');
			if($result){
				$loginManagerObj = new LoginManager;
				$loginManagerObj->logout("Voter");
			}else{
				echo "error";
			}
		}
	}
?>