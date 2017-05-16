<?php
session_start();
/**
echo isset($_SESSION['uid']) ? 'yes' : 'no';
echo isset($_SESSION['otp']) ? 'yes' : 'no';
echo isset($_SESSION['ip']) ? 'yes' : 'no';
echo isset($_SESSION['timestamp']) ? 'yes' : 'no';
echo isset($_POST['uid']) ? 'yes' : 'no';
echo isset($_POST['otp']) ? 'yes' : 'no';
echo $_SESSION['uid'] == $_POST['uid'] ? 'yes' : 'no';
echo $_SESSION['otp'] == $_POST['otp'] ? 'yes' : 'no';
**/
if(isset($_SESSION['uid']) && isset($_SESSION['otp']) && isset($_SESSION['ip']) && isset($_SESSION['timestamp']) && isset($_POST['uid']) && isset($_POST['otp']) && $_SESSION['uid'] == $_POST['uid'] && $_SESSION['otp'] == $_POST['otp'] && time() <= ($_SESSION['timestamp']+300) && isset($_POST['name'])) {
  $_SESSION['timestamp'] = time();
  unset($_SESSION['otp']);
  $_SESSION['voter'] = $_POST['name'];
  echo '1';
}
else {
  session_destroy();
  echo '0';
}
?>
