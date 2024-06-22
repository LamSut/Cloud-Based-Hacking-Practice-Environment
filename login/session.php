<?php
session_start();

if (isset($_SESSION['idacc'])){
    if($_SESSION['admin'])
        header("location: ../admin/index.php");
    header("location: ../user/index.php");
    exit;
}

else {
    if(isset($_COOKIE["idacc"])){
        $username = $_COOKIE["idacc"];
        $_SESSION['idacc'] = $username;
        $stmt = $db->prepare("select * from acc where idacc = ?");
        $stmt->bind_param("s", $username); 
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $_SESSION['name']= $row['name'];
        $_SESSION['admin']= $row['admin'];
        $_SESSION['darkmode']= $row['darkmode'];
      }
    if (isset($_SESSION['idacc'])){
        if($_SESSION['admin'])
            header("location: ../admin/index.php");
        header("location: ../user/index.php");
        exit;
    }
}
?>