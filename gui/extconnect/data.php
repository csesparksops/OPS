<?php
session_start();
if (isset($_SESSION['Knight']) && $_SESSION['Knight'] == 'Warrior against hack-a-tack' && isset($_SESSION['Saviour']) && $_SESSION['Saviour'] == 'Guardian') {
  unset($_SESSION['Knight']);
  unset($_SESSION['Saviour']);
}
else
  die();
$ob = array(
  a=>"online-election-system-efb83",
  b=>"online-election-system-efb83.firebaseapp.com",
  c=>"https://online-election-system-efb83.firebaseio.com",
  d=>"418669080202",
  e=>"AIzaSyAu6jw7THvmAEaU0xroOo7Cs7LqyG06JRg",
  f=>"online-election-system-efb83.appspot.com"
);
echo json_encode($ob);
?>
