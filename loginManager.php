
<?php
	require("DBManager.php"); 
	require("OTPservicemanager.php"); 
?>
<?php
	class LoginManager{
		private $DBManagerObject;
		private $OTPServiceManagerObject;
		//AdminObject
		//VoterObject
		//voteProcessManagerObject
		
		function __construct(){
			$this->DBManagerObject = new DBManager;
			$this->OTPServiceManagerObject = new OTPServiceManager;
		}
		
		function voterLogin($aadhaar_no){
			$arr = array($aadhaar_no,'Phone_No','Aadhaar_No');
			$result = $this->DBManagerObject->selectData($arr,'aadhaar_db');
			if(mysqli_num_rows($result) == 1){
				$row = mysqli_fetch_assoc($result);
				$attr = $row['Phone_No'];
				$this->OTPServiceManagerObject->sendOTP($attr);
			}else{
			}
		}
		
		function utilOTP($check_data){
			$output = $this->OTPServiceManagerObject->authenticateOTP((string)$check_data[0]);
			if($output){
				$data = array($check_data[1],'UID_No');
				$result = $this->DBManagerObject->selectData($data,'link_db');
				if(mysqli_num_rows($result) == 1){
					$epic_number = mysqli_fetch_array($result)[0];
					$_SESSION['epic'] = $epic_number;
					$data = array($epic_number,"EPIC_No");
					$const_no_result = $this->DBManagerObject->selectData($data,"voter_db");
					$row = mysqli_fetch_assoc($const_no_result);
					$_SESSION['const_no'] = $row['Constituency_No'];
					$_SESSION['name'] = $row['Name'];
					header("Location:castvote.php");
				}else{
					header("Location:linkAadhaar.php");
				}
			}else{
				
			}
		}
		
		function adminLogin($details){
			$result = $this->DBManagerObject->selectData($details,"admin_db");
			if(mysqli_num_rows($result) == 1)
				return true;
			else
				return false;
		}
		
		function checkValidity($aadhaar_no){
			$arr = array($aadhaar_no,'Aadhaar_No');
			$result = $this->DBManagerObject->selectData($arr,'aadhaar_db');
			if(mysqli_num_rows($result) == 1)
				return true;
			else
				return false;
		}
		
		function linkAadhaar($epic_number,$aadhaar_number){
			$e_array = array('Name','Guardian_Name','DOB','EPIC_No',$epic_number);
			$a_array = array('Name','Guardian_Name','DOB','Aadhaar_No',$aadhaar_number);
			$result = $this->DBManagerObject->selectData($e_array,'voter_db');
			$vList = array();
			if(mysqli_num_rows($result) == 1){
				$row = mysqli_fetch_array($result);
				array_push($vList,$row[0]);
				array_push($vList,$row[1]);
				array_push($vList,$row[2]);
			}
			$result = $this->DBManagerObject->selectData($a_array,'aadhaar_db');
			$aList = array();
			if(mysqli_num_rows($result) == 1){
				$row = mysqli_fetch_array($result);
				array_push($aList,$row[0]);
				array_push($aList,$row[1]);
				array_push($aList,$row[2]);
			}
			if($this->DBManagerObject->matchDetails($vList,$aList)){
				$insert_details = array($aadhaar_number,$epic_number);
				$result = $this->DBManagerObject->insertData($insert_details,'link_db');
				if($result)
					header("Location:castvote.php");
			}else{
				
			}
		}
		
		function logout($user){
			if($user === "Voter"){
				session_unset();
				session_destroy();
				echo "<script>
				alert('Thank you for voting');
				window.location.href='login.php';
				</script>";
			}else{
				
			}
		}
	}
?>
