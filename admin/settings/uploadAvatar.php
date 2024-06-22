<?php 
require_once "../../login/config.php";
session_start();

$idacc = $_SESSION['idacc'];

if (isset($_FILES["uploadAvatar"]["name"]) && getimagesize($_FILES['uploadAvatar']['tmp_name']) != false) {
    $image = file_get_contents($_FILES['uploadAvatar']['tmp_name']);
    $image = addslashes($image);
    $db->query( "UPDATE acc SET avatar = '$image' WHERE idacc = '$idacc'")
    or die("Cannot change image: " . $fb->connect_error);
    ?>
    <script>
      alert("Change Avatar successfully!");
      window.location = "./avatar-change.php";
    </script>
    <?php
}
else
echo "No image has been uploaded";
?>