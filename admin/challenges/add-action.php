<?php
require_once "Challenge.php";
require_once "../../login/config.php";
session_start();

$title = $_POST['title'];
$type = $_POST['type'];
$des = $_POST['des'];

// Setup upload (consider using a separate uploader class)
$info = pathinfo($_FILES["file"]["name"]);
$ext = strtolower($info['extension']);
$filename = $info['filename'] . '.' . $ext;

$targetDir = "../../files/ctf/";
$targetFile = $targetDir . $filename;

if ($_FILES["file"]["size"] > 100000000) { // Adjust maximum file size (in bytes)
  echo "Sorry, your file is too large.";
  exit;
}

if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
  $file = $filename;
} else {
  echo "An error occurs when uploading your file.";
  exit;
}

$hint = $_POST['hint'];
$keyfile = $_POST['key'];
$author = $_SESSION['idacc'];

$idctf=0;
$challenge = new Challenge($title, $type, $des, $hint, $file, $keyfile, $author, $idctf);

if ($challenge->insertChallenge()) {
  ?>
  <script>
    alert("Challenge added successfully!");
    window.location = "./view.php";
  </script>
  <?php
} else {
  echo "Something went wrong...";
}

$stmt->close();
$db->close();
?>