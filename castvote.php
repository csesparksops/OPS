<?php
	if(!isset($_SESSION))
		session_start();
	
	// BUG ID 42 Voters were able to cast vote after 4PM.
	if(date('G') < 10 or date('G') > 16)
		header("Location:welcome.php");
	
	$const_no = $_SESSION['const_no'];
	require('voteProcessManager.php');
	$voteProcessManagerObject = new voteProcessManager;
	$loginManagerObject = new loginManager;
	$result = $voteProcessManagerObject->listCandidate($const_no);
	$counter = 1;
	$var = "";
?>
<?php
	if(isset($_POST['vote_button'])){
		echo "Hello";
		// Bug 44 - Problem of multiple voting. 
		// Here if the voter has voted once then the first vote cast by him will be submitted.
		if($loginManagerObject->checkAlreadyVoted($_SESSION['uid']) == false){
			$var = $_POST['hidden_field1'];
			$var2 = $_POST['hidden_field2'];
			date_default_timezone_set('Asia/Kolkata');
			$now =  date('Y-m-d H:i:s');
			$data = array($_SESSION['uid'],$_SESSION['const_no'],$var,$now,$_SESSION['ip'],$var2);
			$vote = new Vote($data);
			$voteProcessManagerObject->saveVote($vote);
		}else{
				session_unset();
				session_destroy();
				echo "<script>
				alert('You have already voted');
				window.location.href='login.php';
				</script>";
			}
	}
?>
<?php if(isset($_SESSION['uid']) && isset($_SESSION['epic']) && isset($_SESSION['name']) && isset($_SESSION['ip'])){ ?>
	<html lang = "en">
		<head>
			<title>Cast Vote</title>
			<style>
				header{
					text-align:center;
					font:Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
					margin-bottom:10%;
					margin-top:4%;
				}
				th{
					padding:5px;
					font:font:Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
					font-size:20px;
					width:1%;
					font-weight:bold;
					border:1px solid blue;
					border-radius:4px;
				}
				#upper_table td{
					padding:5px;
					font:font:Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
					font-size:18px;
				}
				#lower_table td{
					font:font:Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
					font-size:18px;
					text-align:center;
					border:1px solid blue;
					border-radius:4px;
				}
				#vote_button{
					border:none;
					background-color:white;
				}
			</style>
		</head>
		<body>
			<header>
				<h1>ONLINE ELECTION PORTAL</h1>
			</header>
			<div id = "wrapper">
				<div id = "upper_table" align = "center">
					<table>
						<tr><td><b>NAME : </b></td><td><b><?php echo $_SESSION['name'];?></b></td></tr>
						<tr><td><b>AADHAAR NO : </b></td><td><b><?php echo $_SESSION['uid'];?></b></td></tr>
						<tr><td><b>DATE : </b></td><td><b><?php echo date("Y-m-d");?></b></td><tr>
						<tr><td><b>TIME LEFT : </b></td><td><b>00:03:02</b></td></tr>
					</table>
				</div>
				<br><br>
				<div id = "lower_table" align = "center">
					<table>
						<tr>
							<th>Serial. No</th>
							<th>Candidate Name</th>
							<th>Symbol</th>
							<th>Indicator</th>
							<th>Vote Button</th>
						</tr>
						<?php while($row = mysqli_fetch_assoc($result)) { ?>
							<tr>
								<td><?php echo $counter;?></td>
								<td><?php echo $row['Candidate_Name'];?></td>
								<td><img src = <?php echo "'".$row['Party_Symbol']."'";?> width = "70" height = "70"></td>
								<?php
									if($var != $row['Candidate_No'])
										$img_path = 'Pics\votelight.png';
									else
										$img_path = 'Pics\votelightvoted.png';
									echo $var;
								?>
								<td><img id = "<?php echo 'pic'.$counter;?>" src = "Pics\votelight.png"></td>
								<form action = "<?=$_SERVER['PHP_SELF']?>" method = "post">
									<td><button type = "submit" name = "vote_button" id = "vote_button";"><img src = "Pics\votebutton.png"></button></td>
									<input type = "hidden" name = "hidden_field1" value = "<?php echo $row['Candidate_No'];?>">
									<input type = "hidden" name = "hidden_field2" value = "<?php echo $row['Political_Party'];?>">
								</form>
							</tr>
						<?php $counter = $counter + 1;}?>
						<tr>
							<td><?php echo $counter;?></td>
							<td>NOTA</td>
							<td><img src = "Pics\novote.png" width = "70" height = "70"></td>
							<?php
								if($var != "NOTA")
									$img_path = 'Pics\votelight.png';
								else
									$img_path = 'Pics\votelightvoted.png';
							?>
							<td><img src = "<?php echo $img_path;?>"></td>
							<form action = "<?=$_SERVER['PHP_SELF']?>" method = "post">
								<td><button type = "submit" name = "vote_button" id = "vote_button"><img src = "Pics\votebutton.png"></button></td>
								<input type = "hidden" name = "hidden_field1" value = "<?php echo "NOTA";?>">
								<input type = "hidden" name = "hidden_field2" value = "<?php echo "NULL";?>">
							</form>
						</tr>
					</table>
				</div>
			</div>
			<footer style = "border-top:1px solid black;margin-top:20%;margin-left:10%;margin-right:10%;">
				<p align = "center">Copyrights 2017 - Team CSESparks</p>
			</footer>
		</body>
	</html>
<?php }else{echo "0";}?>

