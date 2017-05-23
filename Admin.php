<?php
	if(!isset($_SESSION))
		session_start();
	require('loginManager.php');
	$error = "";
	$loginManagerObject = new LoginManager;
	if(isset($_POST['admin_login'])){
		if(empty($_POST['username']) || empty($_POST['password'])){
			$error = "Please enter Username or Password";
		}else{
			$username = $_POST['username'];
			$password = $_POST['password'];
			$details = array("Username",$username,"Password",$password);
			$res = $loginManagerObject->adminLogin($details);
			if($res){
				$_SESSION['username'] = $username;
				header("Location:report.php");
			}else{
				$error = "You are not the Admin";
			}
		}
	}
?>
<!doctype HTML>
<html lang = "en">
	<head>
		<title>Login</title>
	</head>
	<style>
		.admin_login{
			width:30%;
			border-radius : 10px;
			border : 2px solid #ccc;
			padding : 10px 20px 30px;
			font:Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
			text-align : center;
			margin-left:34%;
			margin-top:9%;
		}
		input[type = text],input[type = password]{
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
		}}
	</style>
	<body background = "Pics/pic1.jpg">
		<header style = "text-align:center;color:white;">
			<h1>ONLINE POLLING SYSTEM</h1>
		</header>
		<div class = "admin_login">
			<p style = "padding:4px;color:white;">ADMIN &nbsp;&nbsp;LOGIN</p>
			<form action = "<?=$_SERVER['PHP_SELF']?>" method = "post">
				<input type = "text" name = "username" placeholder = "Username"><br><br>
				<input type = "password" name = "password" placeholder = "Password"><br><br>
				<input type = "submit" value = "Login" name = "admin_login">
				<span><b><p style = "color:cyan;"><?php echo $error; ?></b></p></span>
			</form>
		</div>
		<footer style = "margin-top:20%;border-top: 1px solid white;width : 70%;text-align:center;padding-top:2px;margin-left:15%">
			<center><b><p style = "color:white;">All Copyrights reserved 2017 - Team CSESparks</p></b></center>
		</footer>
	</body>
</html>