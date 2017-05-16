<?php
session_start();
$_SESSION['Knight'] = 'Warrior against hack-a-tack';
echo "<script src='/extconnect/firebase.js.php'></script>";
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

#logincontent {
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
}

.cbt {
  background-color: #E74C3C;
}

.rbt {
  background-color: #239B56;
}

</style>
<script>
  var finaluid, finalname;
  var OTPService = new OTPServiceManager();
  var Login = new LoginManager();
  Login.OTPManagerObject = OTPService;
  function resetData() {
    document.getElementById('otp').value='';
    document.getElementById('uid').value='';
    document.getElementById('uid').readOnly = false;
    document.getElementById('uidbtn').disabled = false;
    document.getElementById('otp').readOnly = true;
    document.getElementById('otpbtn').disabled = true;
    document.getElementById('hidden').style.display='none';
    document.getElementById('uidbtn').style = 'background-color: #239B56;';
    var x = new XMLHttpRequest();
    x.open('GET', '/api/resetsession.php', false);
    x.send();
  }
  function sendOTP(uid) {
    var ret=0;
    console.log('sending '+uid+' to aadhaar');
    dataset.ref('/aadhaar').once('value').then(function(snapshot){
      if (snapshot.hasChild(uid)) {
        var mobile = snapshot.child(uid).val()['mobile'];
        Login.OTPManagerObject.uid = uid;
        Login.OTPManagerObject.mobile = mobile;
        console.log('In main:uid-'+Login.OTPManagerObject.uid+' mobile-'+Login.OTPManagerObject.mobile);
        var otpstat = Login.OTPManagerObject.generateOTP();
    	console.log(mobile + " " + otpstat);
        if(otpstat == '1') {
          finaluid = uid;
          finalname = snapshot.child(uid).val()['name'];
          $.confirm({
            title: "OTP sent!",
            content: "OTP has been successfully sent to your linked mobile number: +91 XXXX XX "+mobile.toString().slice(-3)+" !!",
            type: 'green',
            columnClass: 'small',
            typeAnimated: true,
            buttons: {
              OK: {
                text: 'OK',
                btnClass: 'btn-green',
                action: function(){
                  document.getElementById('uid').readOnly = true;
                  document.getElementById('uidbtn').disabled = true;
                  document.getElementById('uidbtn').style = 'background-color: #82E0AA;';
                  document.getElementById('otp').readOnly = false;
                  document.getElementById('otpbtn').disabled = false;
                  document.getElementById('hidden').style.display='block';
                }
              }
            }
          });
        }
        else {
          $.confirm({
            title: "OTP not sent!",
            content: "OTP could not be sent due to some technical error! Please retry!!",
            type: 'red',
            columnClass: 'small',
            typeAnimated: true,
            buttons: {
              OK: {
                text: 'OK',
                btnClass: 'btn-red',
                action: function() {
                  resetData();
                }
              }
            }
          });
        }
      }
      else {
        $.confirm({
          title: "Aadhaar not found!",
          content: "The aadhaar number you entered was not found in our database! Please enter correctly!!",
          type: 'red',
          columnClass: 'small',
          typeAnimated: true,
          buttons: {
            OK: {
              text: 'OK',
              btnClass: 'btn-red',
              action: function() {
                resetData();
              }
            }
          }
        });
      }
    });
  }
  function checkUID() {
    var uid = document.getElementById('uid').value;
    var response = Login.checkValidity(uid);
    if (response.length != 12) {
      $.confirm({
        title: "Invalid Aadhaar number!",
        content: "A valid aadhaar number consists of 12 digits starting from 2-9! Please make sure you enter correct details!!",
        type: 'red',
        columnClass: 'small',
        typeAnimated: true,
        buttons: {
          OK: {
            text: 'OK',
            btnClass: 'btn-red',
            action: function() {
              resetData();
            }
          }
        }
      });
    }
    else {
      console.log('sending '+response+' to vote');
      dataset.ref('/vote').once('value').then(function(snapshot){
        //console.log(parseInt(response)+1);
        if(snapshot.hasChild(response)) {
	  $.confirm({
            title: "Vote cast!",
            content: "You have already voted using this aadhaar number!!",
            type: 'red',
            columnClass: 'small',
            typeAnimated: true,
            buttons: {
              OK: {
                text: 'OK',
                btnClass: 'btn-red',
                action: function() {
		  resetData();
		}
              }
            }
          });
	}
        else
          sendOTP(response);
      });
    }
  }
  function checkOTP() {
    var ueotp = document.getElementById('otp').value;
    var response = Login.OTPManagerObject.authenticateOTP(ueotp, finalname);
    console.log('OTP response:' + response);
    if(response == '1') {
      document.getElementById('otp').readOnly = true;
      document.getElementById('otpbtn').disabled = true;
      $.confirm({
        title: "Congratulations!!",
        content: "Welcome "+finalname+"!! You have been logged in successfully!",
        type: 'green',
        columnClass: 'small',
        typeAnimated: true,
        buttons: {
          OK: {
            text: 'OK',
            btnClass: 'btn-green',
            action: function(){
              Login.voterLogin();
            }
          }
        }
      });
    }
    else {
      $.confirm({
        title: "Invalid Access!",
        content: "Our system could not verify your identity! Please try again later!!",
        type: 'red',
        columnClass: 'small',
        typeAnimated: true,
        buttons: {
          OK: {
            text: 'OK',
            btnClass: 'btn-red',
            action: function(){
              resetData();
            }
          }
        }
      });
    }
  }
  /**function toggle() {
    if (document.getElementById('hidden').style.display == 'none')
      document.getElementById('hidden').style.display = 'block';
    else
      document.getElementById('hidden').style.display = 'none';
  }**/
</script>
</head>
<body style='background-color:#E8DAEF;'>
<h1 style='font-size:44px;color:red;text-align:center;'>Online Election Portal</h1>
<div id='logincontent'>
<h3>Login</h3><br/>
Enter Aadhaar UID:<input type='tel' id='uid' maxLength='12' />
<button class = 'rbt' id='uidbtn' onclick='checkUID()'>Next</button><br/>
<div id='hidden' style='display:none'>
<br/>
Enter OTP:<input type='tel' id='otp' maxLength='6' readOnly/>
<button class='rbt' id='otpbtn' onclick='checkOTP()' disabled>Next</button><br/>
</div>

<button class='cbt' onclick='resetData()'>Reset</button>
<!--
<br/>
<button class='cbt' onclick='toggle()'>Toggle</button>
-->
</div>
</body>
</html>

