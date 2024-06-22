<?php
require_once "../../login/config.php";
session_start();

if (!isset($_SESSION['idacc'])){
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
  else{
    header("location: ../../login/index.php");
    exit;
  }  
}

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
  header("location: ../../admin/index.php");
  exit;
}

$style = "style.css"; // Default css for light mode
$logo = "Logo.png";
$settingBTN = "settings-icon.png";

if (isset($_SESSION['darkmode']) && $_SESSION['darkmode'] == 1) {
  $style = "style-dark.css";
  $logo = "Dark-Logo.png";  
  $settingBTN = "Dark-settings-icon.png";
}

$stmt = $db->prepare("select * from acc where idacc = ?");
$stmt->bind_param("s", $_SESSION['idacc']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$gender= $row['gender'];
$email= $row['email'];
$avatar = base64_encode($row['avatar']);

mysqli_close($db);
?> 



<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../<?php echo $style; ?>?v=<?php echo time(); ?>">
<style>
  #cmt-content{
    display: block;
    font-size: 1.0rem;
    font-family: "Open Sans", sans-serif;
    margin-top: 10px;
    padding: 8px;
  }
</style>
<title>Change Avatar</title>
</head>

<body>

  <div id="header">
    <div id="top">
    <a href="../index.php"><img src="../../img/<?php echo $logo; ?>" alt="W0rm" style="height: 80px;"></a>
      <div id="usermenu">
        <div style="float:right">
          <span><?php echo $_SESSION["name"];?></span>
          <button onclick="usermenu()" class="drop-btn"><img src="../../img/<?php echo $settingBTN; ?>" style="height: 25px;"></button>
        </div>
        <div class="dropdown">
          <div id="dropdownContent" class="dropdown-content">
            <a href="../profile/view.php">Profile</a>
            <a href="../comments/index.php">Comments</a>
            <a href="../settings/index.php">Settings</a>
            <a href="../logout.php" role="button">Log Out</a>
          </div>
        </div>  
      </div>
    </div>
    <div id="navbar">
      <a href="../index.php">Home</a>
      <a href="../lectures/view.php">Lectures</a>
      <a href="../challenges/view.php">CTF Challenges</a>
      <a href="../labs/view.php">Labs</a>
    </div>
  </div>
  
  <div id="content">
    <h3>Change your Avatar </h3>
    <img id="avatar" src="data:image/png;base64,<?php echo $avatar; ?>">
    <form action="uploadAvatar.php" method="post" enctype="multipart/form-data" style="margin-left: 40px;">
        <input type="file" name="uploadAvatar" id="uploadAvatar" accept="image/*" style="margin: 20px 10px 0px 0px; font-size: 1.0rem; width:210px" required> 
        <br><br>
        <input type="submit" value="Upload" onclick="return confirm('Confirm to change your avatar?')">
        <button id="cancel-btn" type="button" onclick="location.href='index.php'" style="margin-left: 20px;">Cancel</button>
    </form>
  </div>
  
  <script src="../../javascript.js"></script>
</body>

</html>
