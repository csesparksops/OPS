<?php
session_start();
class WAY2SMSClient
{
    var $curl;
    var $timeout = 30;
    var $jstoken;
    var $way2smsHost;
    var $refurl;
    var $uid;
    var $mobile;
    var $otp;

    function login()
    {
        $this->curl = curl_init();
        $uid = urlencode('8967736771');
        $pwd = urlencode('M2762Q');

        curl_setopt($this->curl, CURLOPT_URL, "http://way2sms.com");
        curl_setopt($this->curl, CURLOPT_HEADER, true);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
        $a = curl_exec($this->curl);
        if (preg_match('#Location: (.*)#', $a, $r))
            $this->way2smsHost = trim($r[1]);

        curl_setopt($this->curl, CURLOPT_URL, $this->way2smsHost . "Login1.action");
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, "username=" . $uid . "&password=" . $pwd . "&button=Login");
        curl_setopt($this->curl, CURLOPT_COOKIESESSION, 1);
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, "cookie_way2sms");
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->curl, CURLOPT_MAXREDIRS, 20);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5");
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($this->curl, CURLOPT_REFERER, $this->way2smsHost);
        $text = curl_exec($this->curl);

        if (curl_errno($this->curl))
            return "access error : " . curl_error($this->curl);

        $pos = stripos(curl_getinfo($this->curl, CURLINFO_EFFECTIVE_URL), "ebrdg.action");
        if ($pos === "FALSE" || $pos == 0 || $pos == "")
            return "invalid login";

        $this->refurl = curl_getinfo($this->curl, CURLINFO_EFFECTIVE_URL);
        $newurl = str_replace("ebrdg.action?id=", "main.action?section=s&Token=", $this->refurl);
        curl_setopt($this->curl, CURLOPT_URL, $newurl);

        $this->jstoken = substr($newurl, 50, -41);
        $text = curl_exec($this->curl);
        return true;
    }

    function send()
    {
        $msg = 'Enter OTP:'.$this->otp.' for UID:'.$this->uid.'. Validity: 5 mins.';
        curl_setopt($this->curl, CURLOPT_URL, $this->way2smsHost . 'smstoss.action');
        curl_setopt($this->curl, CURLOPT_REFERER, curl_getinfo($this->curl, CURLINFO_EFFECTIVE_URL));
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, "ssaction=ss&Token=" . $this->jstoken . "&mobile=" . $this->mobile . "&message=" . $msg . "&button=Login");
        $contents = curl_exec($this->curl);
        return strpos($contents, 'Message has been submitted successfully') ? '1' : '0';
    }

    function logout()
    {
        curl_setopt($this->curl, CURLOPT_URL, $this->way2smsHost . "LogOut");
        curl_setopt($this->curl, CURLOPT_REFERER, $this->refurl);
        $text = curl_exec($this->curl);
        curl_close($this->curl);
    }
}

if (isset($_SESSION['OTP_Proof']) && isset($_SESSION['uid']) && isset($_POST['uid']) && isset($_POST['mobile']) && ($_SESSION['uid'] == $_POST['uid']) && $_SESSION['OTP_Proof'] == 'Stay away intruder!') {
  $ip = getenv('HTTP_CLIENT_IP')?:
    getenv('HTTP_X_FORWARDED_FOR')?:
    getenv('HTTP_X_FORWARDED')?:
    getenv('HTTP_FORWARDED_FOR')?:
    getenv('HTTP_FORWARDED')?:
    getenv('REMOTE_ADDR');

  $otp = mt_rand(100000,999999);
  $client = new Way2SMSClient();
  $client->uid = $_POST['uid'];
  $client->mobile = $_POST['mobile'];
  if (strlen($client->mobile) > 10)
      $client->mobile = substr($client->mobile, -10);
  $client->otp = $otp;
  $client->login();
  $result = $client->send();
  $client->logout();
  $_SESSION['otp'] = $otp;
  $_SESSION['ip'] = $ip;
  $_SESSION['timestamp'] = time();
  unset($_SESSION['OTP_Proof']);
  echo $result;
}
else
  echo "0";
?>
