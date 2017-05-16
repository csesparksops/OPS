<?php
session_start();
if (isset($_SESSION['voteruid']) && isset($_POST['uname']) && isset($_POST['ename']) && isset($_POST['uguardian']) && isset($_POST['eguardian']) && isset($_POST['udob']) && isset($_POST['edob']) && ($_POST['uname'] == $_POST['ename']) && ($_POST['uguardian'] == $_POST['eguardian']) && ($_POST['udob'] == $_POST['edob'])) {
  echo '1';
}
else
  echo '0';
?>
