<?php
session_start();
$_SESSION['Knight'] = 'Warrior against hack-a-tack';
?>
<script src='/extconnect/firebase.js.php'></script>
<script>
function unvote() {
var uid = document.getElementById('uid').value;
var adaRef = dataset.ref('/vote/'+uid);
adaRef.remove()
  .then(function() {
    alert("Remove succeeded.")
  })
  .catch(function(error) {
    alert("Remove failed: " + error.message)
  });
}
</script>
<input type='tel' maxLength='12' id='uid' />
<button onclick='unvote()'>Unvote</button>
