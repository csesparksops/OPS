<?php if(!isset($_SESSION))
		session_start();
?>
<?php
	// BUG ID 42 Voters were able to cast vote after 4PM.
	if(date('G') < 10 or date('G') > 16)
		header("Location:welcome.php");
?>
<?php 
	require("loginManager.php");
	$loginManagerObject = new LoginManager;
	$error = "";
	if(isset($_POST['otp_button'])){
		if(empty($_POST['aadhaar'])){
			$error = "Please enter your Aadhaar Number";
		}else{
			$aadhaar_no = $_POST['aadhaar'];
			if($loginManagerObject->checkValidity($aadhaar_no) == true){
				if($loginManagerObject->checkAlreadyVoted($aadhaar_no) == false){
					$_SESSION['uid'] = $aadhaar_no;
					$ip = getenv('HTTP_CLIENT_IP')?:
					getenv('HTTP_X_FORWARDED_FOR')?:
					getenv('HTTP_X_FORWARDED')?:
					getenv('HTTP_FORWARDED_FOR')?:
					getenv('HTTP_FORWARDED')?:
					getenv('REMOTE_ADDR');
					$_SESSION['ip'] = $ip;
					$loginManagerObject->voterLogin($aadhaar_no);
				}else
					$error = "You have already voted";
			}else{
				$error = "Not a Registered User";
			}
		}
	}
	if(isset($_POST['submit_otp']) && isset($_SESSION['uid']) && isset($_SESSION['ip'])){
		if(empty($_POST['otp'])){
			$error = "Enter OTP Received";
		}else{
			$check_data = array($_POST['otp'],$_SESSION['uid']);
			$loginManagerObject->utilOTP($check_data);
		}
	}else if(isset($_POST['submit_otp']) && !isset($_SESSION['uid'])){
		$error = "Enter Aadhaar Number First";
	}
?>
<!DOCTYPE html>
<html lang = "en">
<head>
	<title>Login</title>
	<style>
		.login{
			width:30%;
			border-radius : 10px;
			border : 2px solid #ccc;
			padding : 10px 20px 30px;
			font:Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
			text-align : center;
			margin-left:34%;
			margin-top:6%;
		}
		input[type = text]{
			width:95%;
			padding:10px;
			font:Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
			border:1px solid #ccc;
			border-radius:5px;
		}
		input[type = submit]{
			width:90%;
			padding:10px;
			background-color:#009;
			color:#fff;
			border:2px solid #06f;
			border-radius:5px;
			margin-bottom:20px;
		}
		.admin_login{
			position:absolute;
			right:0;
			top:0;
			float:right;
			background-color:white;
			border:none;
			margin-top:5px;
			margin-right:5px;
		}
	</style>
</head>
<body background = "Pics/pic2.jpg">
	<header style = "text-align:center;" id = "aadhaar">
		<h1>ONLINE POLLING SYSTEM</h1>
	</header>
	<div class = "admin_login">
		<button type = "button" id = "admin_button"><img src = "Pics/admin.png" width = "60" height = "60" onclick = "window.location.href ='admin.php';"></button>
	</div>
	<div class = "login">
		<h3>Login</h3>
		<form action = "<?=$_SERVER['PHP_SELF']?>" method = "post">
			<input type = "text" placeholder = "Aadhaar Number" name = "aadhaar" id = "aadhaar"><br><br>
			<input type = "submit" id = "otp_button" name = "otp_button" value = "Get OTP"><br><br>
			<input type = "text" placeholder = "Enter OTP" name = "otp" id = "otp" ><br><br>
			<input type = "submit" id = "submit_otp" name = "submit_otp" value = "Login" ><br>
			<span><?php echo $error; ?></span>
		</form>
	</div>
	<footer style = "margin-top:20%;border-top: 1px solid black;width : 70%;text-align:center;padding-top:2px;margin-left:15%">
		<center>All Copyrights reserved 2017 - Team CSESparks</center>
	</footer>
</body>