<?php
session_start();
setcookie("idacc", $_SESSION['idacc'], time() - 3600, "/");
if(session_destroy()){
    header("location: ../login/index.php");
    exit;
}
?>