<?php
session_start();
if(isset($_SESSION['voteruid']) && isset($_POST['cid']) && isset($_SESSION['ip']))
  echo json_encode(array(
    'uid'=>$_SESSION['voteruid'],
    'cid'=>$_POST['cid'],
    'ip'=>$_SESSION['ip'],
    'ts'=>time()
  ));
else
  echo '0';
?>
