<?php
session_start();
if (isset($_SESSION['voteruid']) && isset($_SESSION['voterepic']) && isset($_SESSION['voter'])) {
  $_SESSION['Knight'] = 'Warrior against hack-a-tack';
  echo "<script src='/extconnect/firebase.js.php'></script>";
}
else {
  echo "Hey kid, where's your Ma`ma?? Get Lost!";
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
<style>
body {
  padding: 0;
  margin: 0;
}
tbody tr:hover {
  background-color: #D7BDE2;
}
tfoot tr:hover {
  background-color: #D7BDE2;
}
#loader {
  margin: 20px auto;
  width: 40px;
  height: 40px;
  position: absolute;
  top:30%;
  left:50%;
  -webkit-transform: rotateZ(45deg);
          transform: rotateZ(45deg);
}

#loader .sk-cube {
  float: left;
  width: 50%;
  height: 50%;
  position: relative;
  -webkit-transform: scale(1.1);
      -ms-transform: scale(1.1);
          transform: scale(1.1); 
}
#loader .sk-cube:before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #333;
  -webkit-animation: sk-foldCubeAngle 2.4s infinite linear both;
          animation: sk-foldCubeAngle 2.4s infinite linear both;
  -webkit-transform-origin: 100% 100%;
      -ms-transform-origin: 100% 100%;
          transform-origin: 100% 100%;
}
#loader .sk-cube2 {
  -webkit-transform: scale(1.1) rotateZ(90deg);
          transform: scale(1.1) rotateZ(90deg);
}
#loader .sk-cube3 {
  -webkit-transform: scale(1.1) rotateZ(180deg);
          transform: scale(1.1) rotateZ(180deg);
}
#loader .sk-cube4 {
  -webkit-transform: scale(1.1) rotateZ(270deg);
          transform: scale(1.1) rotateZ(270deg);
}
#loader .sk-cube2:before {
  -webkit-animation-delay: 0.3s;
          animation-delay: 0.3s;
}
#loader .sk-cube3:before {
  -webkit-animation-delay: 0.6s;
          animation-delay: 0.6s; 
}
#loader .sk-cube4:before {
  -webkit-animation-delay: 0.9s;
          animation-delay: 0.9s;
}
@-webkit-keyframes sk-foldCubeAngle {
  0%, 10% {
    -webkit-transform: perspective(140px) rotateX(-180deg);
            transform: perspective(140px) rotateX(-180deg);
    opacity: 0; 
  } 25%, 75% {
    -webkit-transform: perspective(140px) rotateX(0deg);
            transform: perspective(140px) rotateX(0deg);
    opacity: 1; 
  } 90%, 100% {
    -webkit-transform: perspective(140px) rotateY(180deg);
            transform: perspective(140px) rotateY(180deg);
    opacity: 0; 
  } 
}

@keyframes sk-foldCubeAngle {
  0%, 10% {
    -webkit-transform: perspective(140px) rotateX(-180deg);
            transform: perspective(140px) rotateX(-180deg);
    opacity: 0; 
  } 25%, 75% {
    -webkit-transform: perspective(140px) rotateX(0deg);
            transform: perspective(140px) rotateX(0deg);
    opacity: 1; 
  } 90%, 100% {
    -webkit-transform: perspective(140px) rotateY(180deg);
            transform: perspective(140px) rotateY(180deg);
    opacity: 0; 
  }
}


#votecontent {
  display: none;
  position: relative;
  top: 50%;
  left: 50%;
  text-align: center;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

img{
  display: block;
  margin: auto;
}
td {
  border: solid 1px gray;
  text-align: center;
}
th {
  border: solid 3px black;
  text-align: center;
}
table {
   display:table;
   border-collapse:separate;
   border: solid 2px black;
   float: center;
   margin:auto;
}
</style>
<title>Online Election Portal</title>
<script src='/oops/Admin.js'></script>
<script src='/oops/Candidate.js'></script>
<script src='/oops/DBManager.js'></script>
<script src='/oops/LoginManager.js'></script>
<script src='/oops/OTPServiceManager.js'></script>
<script src='/oops/Vote.js'></script>
<script src='/oops/VoteProcessManager.js'></script>
<script src='/oops/Voter.js'></script>
</head>

<script>
var finalcid, votetime, votetimer = 2;
function votefunc() {
  if (votetimer <= 0 || votetimer > 2) {
    document.getElementById('y'+finalcid).style.display = 'none';
    document.getElementById('i'+finalcid).style.display = 'block';
    clearInterval(votetime);
    clearInterval(intfunc);
    document.getElementById('y'+finalcid).style.display = 'none';
    document.getElementById('i'+finalcid).style.display = 'block';
    $.confirm({
      title: 'Voted Successfully!',
      content: 'Thank you for e-voting and being a responsible Indian!! #DigiMat',
      type: 'green',
      columnClass: 'small',
      typeAnimated: true,
      buttons: {
        OK: {
          text: 'OK',
          btnClass: 'btn-green',
          action: function(){
            Login.logout();
            window.location.replace('http://uidai-gov.96.lt');
          }
        }
      }
    });
  }
  votetimer--;
}
function voteCandidate(cid) {
  document.getElementById('i'+cid).style.display = 'none';
  document.getElementById('y'+cid).style.display = 'block';
  for(var i = 0; i <= VoteProcess.ccount; i++)
    document.getElementById('v'+i).onclick = function() {};
  finalcid = cid;
  console.log('enabling '+cid);
  //document.getElementById('i'+cid).src = "https://firebasestorage.googleapis.com/v0/b/online-election-system-efb83.appspot.com/o/enabled.png?alt=media";
  console.log(voter);
  vote.setAadhaarNo(voter.getAadhaarNo());
  vote.setEPICNo(voter.getEPICNo());
  vote.setConstituencyNo(voter.getConstituencyNo());
  vote.setCandidateNo(voter.castVote(VoteProcess.candidateObject[cid]));
  console.log(VoteProcess.candidateObject);
  console.log('vote ' + vote);
  var uvote = JSON.parse(VoteProcess.saveVotes(vote));
  console.log('uvote '+ uvote);
  dataset.ref('/vote/'+uvote.uid).set({
    candidate: uvote.cid,
    ip: uvote.ip,
    timestamp: uvote.ts,
    constituency: vote.getConstituencyNo()
  });
  votetime = setInterval(votefunc, 500);
}
</script>
<body style='background-color:#E8DAEF;'>
<h1 style='font-size:44px;color:red;text-align:center;'>Online Election Portal</h1>
<div id="loader">
  <div class="sk-cube1 sk-cube"></div>
  <div class="sk-cube2 sk-cube"></div>
  <div class="sk-cube4 sk-cube"></div>
  <div class="sk-cube3 sk-cube"></div>
</div>
<div id='votecontent'>

<h3>Vote</h3>
<table><thead>
<tr><td id='detn'><strong>Name: </strong></td><td id='detc'><strong>Constituency: </strong></td></tr>
<tr><td id='dete'><strong>EPIC Number: </strong></td><td id='dett'><strong>Time left: </strong>- min -- sec</td></tr></thead>
</table><br/><br/>
<table>
<thead><tr><th>Candidate Name</th><th>Party Name</th><th>Symbol</th><th>Indicator</th><th>Button</th></tr></thead>
<tbody id='evm'></tbody>
<tfoot><tr><td>NOTA</td><td>None of the above</td><td><img src="https://firebasestorage.googleapis.com/v0/b/online-election-system-efb83.appspot.com/o/nota.png?alt=media" width="75" height="75"></td><td><img src="https://firebasestorage.googleapis.com/v0/b/online-election-system-efb83.appspot.com/o/disabled.png?alt=media" id="i0" width="45" height="45"><img src="https://firebasestorage.googleapis.com/v0/b/online-election-system-efb83.appspot.com/o/enabled.png?alt=media" id="y0" width="45" height="45" style="display:none;"></td><td><img src="https://firebasestorage.googleapis.com/v0/b/online-election-system-efb83.appspot.com/o/vote.png?alt=media" id="v0" width="90" height="60"></td></tr></tfoot>
<script>
var Login = new LoginManager();
var voter = new Voter();
var vote = new Vote();
var VoteProcess = new VoteProcessManager();
var candidate;
var Login = new LoginManager();
VoteProcess.ccount = 0;
VoteProcess.candidateObject = [];
candidate = new Candidate();
candidate.candidate_id = '000000000';
candidate.cname = 'NOTA';
candidate.political_party = 'None of the above';
candidate.political_party_symbol = 'nota.png';
//VoteProcess.candidateObject.push(candidate);
voter.uid = <?php echo "'".$_SESSION['voteruid']."'";?>;
voter.epic = <?php echo "'".$_SESSION['voterepic']."'";?>;
var tablewrite;
var timer = 120;
var intfunc;
function timefunc() {
  if (timer <= 0 || timer > 120) {
    Login.logout();
    document.getElementById('dett').innerHTML = '<strong>Time left: </strong>0 min 0 sec';
    clearInterval(intfunc);
    $.confirm({
      title: "Time's up!",
      content: "You have 2 min duration allowed for voting in one session. However, don't worry, you may log in again to vote!!",
      type: 'red',
      columnClass: 'small',
      typeAnimated: true,
      buttons: {
        OK: {
          text: 'OK',
          btnClass: 'btn-red',
          action: function(){
            Login.logout();
            window.location.replace('http://uidai-gov.96.lt');
          }
        }
      }
    });
  }
  var mins = Math.floor(timer/60);
  var secs = timer%60;
  document.getElementById('dett').innerHTML = '<strong>Time left: </strong>'+mins+' min '+secs+' sec';
  timer--;
}
var tevm = document.getElementById('evm');
var voting_end_time = parseInt(<?php echo time()+500;?>);
  console.log(voting_end_time*1000);
  console.log(Date.now());
  if (voting_end_time*1000 >= Date.now()) {
    dataset.ref('/voter/'+voter.epic).once('value').then(function(esnapshot) {
      voter.constituency = esnapshot.val()['constituency'];
      console.log(voter.getConstituencyNo());
      candidate.candidate_id += String(voter.getConstituencyNo());
      console.log('NOTA : '+candidate.candidate_id);
      VoteProcess.candidateObject.push(candidate);
      voter.vname = esnapshot.val()['name'];
      console.log(voter.getName());
      document.getElementById('detn').innerHTML += voter.getName();
      document.getElementById('detc').innerHTML += voter.getConstituencyNo();
      document.getElementById('dete').innerHTML += voter.getEPICNo();
      dataset.ref('/candidate').once('value').then(function(snapshot) {
        snapshot.forEach(function(childsnapshot) {
          if(childsnapshot.val()['constituency'] == voter.constituency) {
            candidate = new Candidate();
            candidate.candidate_id = childsnapshot.key;
            candidate.cname = childsnapshot.val()['name'];
            candidate.political_party = childsnapshot.val()['party'];
            candidate.political_party_symbol = childsnapshot.val()['symbol'];
            console.log(candidate);
            VoteProcess.candidateObject.push(candidate);
            var ih = JSON.parse(VoteProcess.listCandidate(candidate));
            if (ih != '0') {
              var revm = tevm.insertRow();
              revm.insertCell(0).innerHTML = ih.cname;
              revm.insertCell(1).innerHTML = ih.party;
              revm.insertCell(2).innerHTML = ih.symbol;
              revm.insertCell(3).innerHTML = ih.indicator;
              revm.insertCell(4).innerHTML = ih.vote;
            }
          }
        });
        console.log('total mems:'+VoteProcess.ccount);
        for(var i = 0; i <= VoteProcess.ccount; i++) {
          var imgelem = document.getElementById('v'+i);
          console.log(imgelem);
          imgelem.onclick = (function(i){ return function(){ voteCandidate(i); } })(i);
          console.log(imgelem.onclick);
        }
        document.getElementById("loader").style.display = "none";
        document.getElementById("votecontent").style.display = "block";
        intfunc = setInterval(timefunc, 1000);
      });
    });
  }
  else {
    $.confirm({
      title: 'Invalid Election!',
      content: 'There are no elections going on in your constituency right now! Come back later.',
      type: 'red',
      columnClass: 'small',
      typeAnimated: true,
      buttons: {
        OK: {
          text: 'OK',
          btnClass: 'btn-red',
          action: function(){
            Login.logout();
            window.location.replace('http://uidai-gov.96.lt');
          }
        }
      }
    });
  }

</script>
</div>
</body>
</html>
