<?php
	session_start();
	if(!isset($_SESSION['uid'])){
		header("Location:login.php");
	}
?>
<?php
	require("loginManager.php");
	$LoginManagerObject = new LoginManager;
	$error = "";
?>
<?php
	if(isset($_POST['epic_button']) && isset($_SESSION['uid'])){
		if(empty($_POST['epic_no'])){
			$error = "Enter EPIC Number";
		}else{
			$epic_number = $_POST['epic_no'];
			$aadhaar_number = $_SESSION['uid'];
			$LoginManagerObject->linkAadhaar($epic_number,$aadhaar_number);
		}
	}
?>
<?php
	if(isset($_SESSION['uid'])){ ?>
		<!doctype HTML>
		<html lang = "en">
			<head>
				<title>Link Aadhaar </title>
			</head>
			<body>
				<form action = "<?=$_SERVER['PHP_SELF']?>" method = "post">
					<input type = "text" placeholder = "Enter EPIC Number" id = "epic_no" name = "epic_no"><br><br>
					<input type = "submit" value = "Submit" name = "epic_button">
					<?php echo $error;?>
				</form>
			</body>
		</html>
	<?php }else{echo "0";}?>


