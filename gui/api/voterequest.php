<?php
session_start();
session_destroy();
session_start();
if(!isset($_POST['uid']))
  $uid = "0";
else
  $uid=(string)$_POST['uid'];
$i=0;
while ($i<strlen($uid)) {
  $c=substr($uid, $i, 1);
  if($c>='0' && $c<='9')
    $i++;
  else
    break;
}
if ($i!=12)
  $uid = "0";
if (substr($uid, 0, 1) == '0' || substr($uid, 0, 1) == '1')
  $uid = "0";
echo $uid;
$_SESSION['uid'] = $uid;
$_SESSION['OTP_Proof'] = 'Stay away intruder!';
?>
