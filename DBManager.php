<?php
	class DBManager{
		
		//Voter Object

		private $server = "ftp.uidai-gov.96.lt";
		private $username = "u202748582";
		private $password = "cse.sparks123";
		private $db_container = "online-election-system-efb83";
		
		var $conn;
		
		//Constructor
		function __construct(){
			$this->connectToDBServer();
		}
		
		//connect to DB Server
		public function connectToDBServer(){
			try{
				$this->conn = mysqli_connect($this->server,$this->username,$this->password);
				mysqli_select_db($this->conn,$this->db_container);
			}catch(Exception $e){
				echo "Message : ".$e->getMessage();
			}
		}
		
		//function to match details
		public function matchDetails($vList,$aList){
			if(($vList[0] === $aList[0]) && ($vList[1] === $aList[1]) && ($vList[2] === $aList[2]))
				return true;
			else
				return false;
		}
		
		// function to insert data
		public function insertData($arr,$db_name){
			$sql_query = "";
			switch(count($arr)){
				case 2:
					$sql_query = "INSERT INTO $db_name(EPIC_No,UID_No) VALUES('".$arr[1]."','".$arr[0]."')";
					break;
				case 6:
					$sql_query = "INSERT INTO $db_name(Aadhaar_No,Const_No,Candidate_No,Timestamp,IP_Address,Party) VALUES('".$arr[0]."','".$arr[1]."','".$arr[2]."','".$arr[3]."','".$arr[4]."','".$arr[5]."')";
					break;
			}
			$result = mysqli_query($this->conn,$sql_query);
			return $result;
		}
		
		//function to select data
		public function selectData($arr,$db_name){
			$sql_query = "";
			switch(count($arr)){
				case 3:
					$sql_query = "SELECT $arr[1] FROM $db_name WHERE $arr[2] = '".$arr[0]."'";
					break;
				case 2:
					$sql_query = "SELECT * FROM $db_name WHERE $arr[1] = '".$arr[0]."'";
					break;
				case 4:
					$sql_query = "SELECT * FROM $db_name WHERE $arr[0] = '".$arr[1]."' AND $arr[2] = '".$arr[3]."'";
					break;
				case 5:
					$sql_query = "SELECT $arr[0],$arr[1],$arr[2] FROM $db_name WHERE $arr[3] = '".$arr[4]."'";
					break;
			}
			$result = mysqli_query($this->conn,$sql_query);
			//$db_result = mysqli_fetch_array($result);
			//return array((string)$db_result[0]);
			return $result;
		}
		
		//function to updateData
		public function updateData(){
			
		}
		
		//function to deleteData
		public function deleteData(){
			
		}
	}
?>
