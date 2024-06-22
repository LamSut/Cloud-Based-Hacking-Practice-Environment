<?php
require_once "Challenge.php";
require_once "../../login/config.php";
session_start();
$idctf = $_GET['idctf'];

$title = $_POST['title'];
$des = $_POST['des'];
$type = $_POST['type'];

$filecheck = $_FILES["file"]["name"];
$hint = $_POST['hint'];
$keyfile = $_POST['key'];
$author = $_SESSION['idacc'];

// Handle file upload (optional):
if ($filecheck !== '') {
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
} else {
  $file = null;  // No file uploaded, set to null
}

// Create a Challenge object with retrieved data
$challenge = new Challenge($title, $type, $des, $hint, $file, $keyfile, $author, $idctf);

// Update the challenge using the Challenge object
$updated = $challenge->updateChallenge($idctf);

if ($updated) {
  ?>
  <script>
    alert("Challenge modified successfully!");
    window.location = "./test.php?idctf=<?php echo isset($idctf) ? $idctf : ''; ?>";
  </script>
  <?php
} else {
  echo "Something went wrong...";
}

$stmt->close();
$db->close();
?>