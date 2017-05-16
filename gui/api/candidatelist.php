<?php
session_start();
if (isset($_SESSION['voteruid']) && isset($_SESSION['voterepic']) && isset($_POST['sl']) && isset($_POST['name']) && isset($_POST['party']) && isset($_POST['symbol']))
  echo json_encode(array(
    'serial' => $_POST['sl'],
    'cname' => $_POST['name'],
    'party' => $_POST['party'],
    'symbol' => '<img src="https://firebasestorage.googleapis.com/v0/b/online-election-system-efb83.appspot.com/o/'.$_POST['symbol'].'?alt=media" width="75" height="75">',
    'indicator' => '<img src="https://firebasestorage.googleapis.com/v0/b/online-election-system-efb83.appspot.com/o/disabled.png?alt=media" id="i'.$_POST['sl'].'" width="45" height="45"><img src="https://firebasestorage.googleapis.com/v0/b/online-election-system-efb83.appspot.com/o/enabled.png?alt=media" id="y'.$_POST['sl'].'" style="display:none;" width="45" height="45">',
    'vote' => '<img src="https://firebasestorage.googleapis.com/v0/b/online-election-system-efb83.appspot.com/o/vote.png?alt=media" id="v'.$_POST['sl'].'" width="90" height="60">'
  ));
else
  echo '0';
?>
