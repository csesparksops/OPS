<?php
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
<title>Online Election Portal</title>
<script src='/oops/Admin.js'></script>
<script src='/oops/Candidate.js'></script>
<script src='/oops/DBManager.js'></script>
<script src='/oops/LoginManager.js'></script>
<script src='/oops/OTPServiceManager.js'></script>
<script src='/oops/Vote.js'></script>
<script src='/oops/VoteProcessManager.js'></script>
<script src='/oops/Voter.js'></script>
<script>
console.log('got here');
var report = {};
dataset.ref('/vote').once('value').then(function(snapshot) {
  snapshot.forEach(function(childsnapshot) {
    var cons = childsnapshot.val().constituency;
    console.log(cons);
    if(!report.hasOwnProperty(cons))
      report[cons] = {};
    var cand = childsnapshot.val().candidate;
    if(!report.cons.hasOwnProperty(cand))
      report[cons][cand] = 0;
    report[cons][cand] += 1;
  });
  console.log(report);
});
</script>
</head>
<body>
</body>
</html>
