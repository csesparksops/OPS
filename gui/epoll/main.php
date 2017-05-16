<?php
session_start();
if (isset($_SESSION['voteruid']) && isset($_SESSION['voter'])) {
  $_SESSION['Knight'] = 'Warrior against hack-a-tack';
  echo "<script src='/extconnect/firebase.js.php'></script>";
}
else {
  echo 'Who the hell are you? And how did you land up in here?? Sshhooo!! Go away!';
  die();
}
?>
<html>
<head>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-9065201832291354",
    enable_page_level_ads: true
  });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.js"></script>
<title>Online Election Portal</title>
<script src='/oops/Admin.js'></script>
<script src='/oops/Candidate.js'></script>
<script src='/oops/DBManager.js'></script>
<script src='/oops/LoginManager.js'></script>
<script src='/oops/OTPServiceManager.js'></script>
<script src='/oops/Vote.js'></script>
<script src='/oops/VoteProcessManager.js'></script>
<script src='/oops/Voter.js'></script>
<style>

#linkcontent {
  display: none;
  border: 20px solid #3498DB;
  border-radius: 20%;
  background-color: #3498DB;
  position: absolute;
  top: 30%;
  left: 50%;
  text-align: center;
  color: white;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

button {
  margin: 5px;
  border-radius: 15%;
  position: relative;
  left: 10px;
  font-size: 16px;
  color: white;
  background-color: #239B56;
}

</style>
<script>
var Login = new LoginManager();
var voter = new Voter();
Login.voterObject = voter;
var uid = <?php echo $_SESSION['voteruid'];?>;
var attempts = 3;
function success() {
  Login.logout();
  window.location.replace('http://uidai-gov.96.lt');
}
function failure() {
  document.getElementById('epic').value = '';
  document.getElementById('epicbtn').disabled = false;
  attempts--;
  document.getElementById('attempts').innerHTML = attempts;
}
function link() {
  document.getElementById('epicbtn').disabled = true;
  var epic = document.getElementById('epic').value.toUpperCase();
  Login.voterObject.epic = epic;
  var response = Login.matchAadhaar();
  if (response == '0') {
    $.confirm({
      title: 'Invalid Voter ID!',
      content: 'Your voter id is not valid one. It should start with three alphabets followed by seven digits.',
      type: 'red',
      columnClass: 'small',
      typeAnimated: true,
      buttons: {
        OK: {
          text: 'OK',
          btnClass: 'btn-red',
          action: function(){
            if (attempts == 1) {
              success();
            }
            else {
              failure();
            }
          }
        }
      }
    });
  }
  else {
   voter.epic = response;
   dataset.ref('/voter').once('value').then(function(esnapshot) {
    if (esnapshot.hasChild(voter.epic)) {
      Login.voterObject.ename = esnapshot.child(voter.epic).val()['name'];
      Login.voterObject.eguardian = esnapshot.child(voter.epic).val()['guardian'];
      Login.voterObject.edob = esnapshot.child(voter.epic).val()['dob'];
      dataset.ref('/aadhaar/'+uid).once('value').then(function(snapshot) { 
        Login.voterObject.uname = snapshot.child('name').val();
        Login.voterObject.uguardian = snapshot.child('guardian').val();
        Login.voterObject.udob = snapshot.child('dob').val();
        console.log(Login.voterObject.ename+" "+Login.voterObject.eguardian+" "+Login.voterObject.edob);
        console.log(Login.voterObject.uname+" "+Login.voterObject.uguardian+" "+Login.voterObject.udob);
        var linkstat = Login.linkAadhaar();
        if (linkstat == '1') {
          dataset.ref('/link/'+uid).set(voter.epic);
          $.confirm({
            title: 'Congratulations!!',
            content: 'Your voter id has been successfully linked to your aadhaar id! You may now proceed to vote!!',
            type: 'green',
            columnClass: 'small',
            typeAnimated: true,
            buttons: {
              OK: {
                text: 'OK',
                btnClass: 'btn-green',
                action: function(){
                  window.location.replace('http://uidai-gov.96.lt/epoll/vote.php');
                }
              }
            }
          });
        }
        else {
          $.confirm({
            title: 'Detail Mismatch!',
            content: 'The details in your Aadhaar ID and Voter ID do not match! Please link them through physical verification in your nearby polling station.',
            type: 'red',
            columnClass: 'small',
            typeAnimated: true,
            buttons: {
              OK: {
                text: 'OK',
                btnClass: 'btn-red',
                action: function(){
                  if (attempts == 1) {
                    success();
                  }
                  else {
                    failure();
                  }
                }
              }
            }
          });
        }
      });
    }
    else {
      $.confirm({
        title: 'Voter ID not present!',
        content: 'The voter id you have entered is not present in the database! Make sure you have entered the correct one!',
        type: 'red',
        columnClass: 'small',
        typeAnimated: true,
        buttons: {
          OK: {
            text: 'OK',
            btnClass: 'btn-red',
            action: function(){
              if (attempts == 1) {
                success();
              }
              else {
                failure();
              }
            }
          }
        }
      });
    }
  });
 } 
}
window.onload = function() {
  dataset.ref('/link/'+uid).once('value').then(function(snapshot) {
    var sepic = snapshot.val();
    if (sepic) {
      var x = new XMLHttpRequest();
      x.open('POST', '/api/matchid.php', false);
      x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      x.send('epic='+sepic);
      $.confirm({
        title: 'Congratulations!!',
        content: 'Your voter id is already linked to your aadhaar id! You may proceed to vote!!',
        type: 'green',
        columnClass: 'small',
        typeAnimated: true,
        buttons: {
          OK: {
            text: 'OK',
            btnClass: 'btn-green',
            action: function(){
              window.location.replace('http://uidai-gov.96.lt/epoll/vote.php');
            }
          }
        }
      });
    }
    else
      document.getElementById('linkcontent').style.display = 'block';
  });
};
</script>
</head>
<body style='background-color:#E8DAEF;'>
<h1 style='font-size:44px;color:red;text-align:center;'>Online Election Portal</h1>
<div id='linkcontent'>
<h3>Link</h3><br/>
Name: <?php echo $_SESSION['voter'];?><br/>
Voter EPIC Number:<input type='text' id='epic' /><br/>
<button id='epicbtn' onclick='link()'>Next</button><br/><br/>
Incorrect Attempts left: <span id='attempts'>3</span>
</div>
</body>
</html>
