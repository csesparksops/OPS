
<?php
	session_start();
?>
<?php
	if(isset($_SESSION['username']) && isset($_POST['generate'])){
		$conn = mysqli_connect("localhost","root","","ops");
		$sql_query_get_const = "SELECT COUNT(DISTINCT Const_No) AS NUM_CONST FROM candidate_db";
		$result = mysqli_query($conn,$sql_query_get_const);
		$number_of_constituencies = mysqli_fetch_assoc($result)['NUM_CONST'];
		$myfile = fopen("Report_OPS.txt","w") or die("Error while creating file");
		$text = "                                               ********** ONLINE POLLING SYSTEM RESULTS *************                  ";
		fwrite($myfile,$text);
		fwrite($myfile,"\r\n\r\n\r\n\r\n");
		$iter = 1;
		while($iter <= $number_of_constituencies){
			$sql_query = "SELECT Party,COUNT(*) as NUM_OF_VOTES FROM vote_db WHERE Const_No = '".$iter."' AND Candidate_No NOT IN ('NOTA') GROUP BY Candidate_No ORDER BY `NUM_OF_VOTES` DESC";
			$text = "         *** The Results for Constituency Number $iter are ***     \r\n\r\n";
			fwrite($myfile,$text);
			$text = "   ** Political Party ** \t\t\t ** Number Of Votes Received **\r\n\r\n";
			fwrite($myfile,$text);
			$result = mysqli_query($conn,$sql_query);
			while($row = mysqli_fetch_assoc($result)){
				$text =  "  \t".$row['Party']." \t\t\t\t\t ".$row['NUM_OF_VOTES']."\r\n";
				fwrite($myfile,$text);
			}
			fwrite($myfile,"\r\n\r\n");
			$text = "*******************************************************************************\r\n";
			fwrite($myfile,$text);
			fwrite($myfile,$text);
			fwrite($myfile,"\r\n\r\n");
			$iter = $iter + 1;
		}
		fclose($myfile);
	}
?>
<?php
	if(isset($_SESSION['username']) && isset($_POST['view'])){
		$url = "Report_OPS.txt";
		echo "<script>";
		echo "window.open('$url');".PHP_EOL;
		echo "</script>";
	}
?>
<?php
	if(isset($_SESSION['username']) && isset($_POST['logout'])){
		session_unset();
		session_destroy();
		header("Location:Admin.php");
	}
?>
<?php if(isset($_SESSION['username'])){ ?>
<!doctype HTML>
<html lang = "en">
	<head>
		<title>Generate Report</title>
		<style>
			#header{
				background-color:#3383FF;
				padding:5px;
				border:1px solid #3383FF;
				border-radius:4px;
			}
			#header button{
				float:right;
				position:absolute;
				top:3.5%;
				left:90%;
				border:none;
				background-color:#3383FF;
			}
			#header p{
				text-align:center;
				font:Times;
				color:white;
				font-size:20px;
			}
			#effect{
				background-color:#A8FF33;
				padding:4px;
				font:Times;
				font-size:18px;
				color:#3933FF;
				border:1px solid #A8FF33;
				border-radius:5px;
				margin-top:2%;
			}
			#content{
				margin-top:7%;
				padding:10px;
				text-align:center;
			}
			#content button{
				border:none;
				background-color:white;
				margin-left:5%;
			}
			footer{
				text-align:center;
				padding:5px;
				background-color:#FF336B;
				border:1px solid #FF336B;
				border-radius:5px;
				margin-top:18%;
				margin-left:5%;
				width:90%;
			}
		</style>
	</head>
	<body>
		<div id = "header">
			<p>ONLINE POLLING SYSTEM</p>
			<form action = "<?=$_SERVER['PHP_SELF']?>" method = "post">
				<button type = "submit" name = "logout"><img src = "Pics/logout.jpg" width = "100" height = "40"></button>
			</form>
		</div>
		<marquee id = "effect">Welcome Admin</marquee>
		<div id = "content">
			<form action = "<?=$_SERVER['PHP_SELF']?>" method = "post">
				<button type = "submit" name = "generate"><img src = "Pics/generatereport.png" width = "400" height = "80"></button>
				<button type = "submit" name = "view"><img src = "Pics/view.png" width = "400" height = "80"></button>
			</form>
		</div>
		<footer>
			<p style = "color:white;">COPYRIGHTS 2017 - Team CSESparks</p>
		</footer>
	</body>
</html>
<?php }else{
	echo "<script>alert('Please Log In');window.location.href = 'Admin.php';</script>";
}?>