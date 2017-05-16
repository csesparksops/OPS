<?php
session_start();
if (isset($_SESSION['voteruid']) && isset($_POST['epic']) && strlen($_POST['epic']) == 10) {
  $epic = $_POST['epic'];
  $i = 0;
  while($i<3) {
    if (substr($epic, $i, 1) < 'A' || substr($epic, $i, 1) > 'Z')
      break;
    $i++;
  }
  if ($i == 3) {
    while ($i < 10) {
      if (substr($epic, $i, 1) < '0' || substr($epic, $i, 1) > '9')
        break;
      $i++;
    }
    if ($i == 10) {
      $_SESSION['voterepic'] = $epic;
      echo $epic;
    }
    else 
      echo '0';
  }
  else
    echo '0';
}
else
  echo '0';
?>
