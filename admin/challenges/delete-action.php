<?php
require_once "../../login/config.php";
session_start();

$idctf = $_POST['idctf'];

$sql0 = "DELETE FROM ctfAttempt WHERE idctf = '$idctf'";
$result0 = $db->query($sql0);

$sql1 = "DELETE FROM ctf WHERE idctf = '$idctf'";
$result1 = $db->query($sql1);

if ($result1 && $result0) {
  ?>
  <script>
      alert("Deleted challenge successfully!");
      window.location = "./view.php";
  </script>
  <?php
} else {
  echo "Error deleting row: " . $db->error;
}

$db->close();
?>