<?php require('sendMsgAPI.php');?>
<?php
	class OTPServiceManager{
		private $otp;
		
		function __construct(){
			
		}
		
		function generateOTP(){
			$this->otp = (string)mt_rand(1,9).(string)mt_rand(0,9).(string)mt_rand(0,9).(string)mt_rand(0,9);
			$myfile = fopen('imp.txt','w') or die('unable to open file');
			fwrite($myfile,$this->otp);
			fclose($myfile);
		}
		
		function sendOTP($Phone_No){
			$this->generateOTP();
			echo $this->otp;
			//$result = exec("python sendMSG.py $Phone_No $this->otp");
			//sendSMS("9804021941","DK9234998482",$Phone_No,$this->otp);
		}
		
		function authenticateOTP($User_entered_otp){
			$myfile = fopen('imp.txt','r') or die('unable to open file');
			$this->otp = fread($myfile,filesize('imp.txt'));
			if($this->otp === $User_entered_otp){
				return true;
			}else{
				return false;
			}
		}
	}
	
?>