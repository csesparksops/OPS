<?php
$p=0;
$g=0;
foreach($_POST as $k => $v) ++$p;
foreach($_GET as $k => $v) ++$g;
if ($g == 0 && $p == 2 && isset($_POST['uid']) && strlen(strval($_POST['uid'])) == 12 && isset($_POST['otp']) && strlen(strval($_POST['otp'])) == 6) {

$url = 'https://aadhaar-api.appspot.com/ekyc/authbyOTP/';
$ch = curl_init($url);
$jsonData = array('aadhaar' => strval($_POST['uid']), 'otp' => strval($_POST['otp']));
$jsonDataEncoded = json_encode($jsonData);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
curl_exec($ch);
curl_close($ch);
}
else {
echo 'Please contact Team CSESparks for any information.';
}
?>