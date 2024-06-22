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

$currentPasswordErr = $newPasswordErr = $confirmPasswordErr = "";

if (isset($_POST['currentPassword'])) {

  $currentPassword = $_POST['currentPassword'];
  
  $username = $_SESSION["idacc"];
  $stmt = $db->prepare("SELECT * FROM acc WHERE idacc = ?");
  $stmt->execute([$username]);

  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  
  $hashCurrentPassword= hash("sha256", $currentPassword);
  $validpass=$row['pass'];

  if(strcmp($hashCurrentPassword, $validpass)==0){
    $_SESSION["passVerify"]=1;
    header("location: password-change.php");
  }
  else 
    $currentPasswordErr = "Invalid current password.";

  $stmt->close();
  mysqli_close($db);
}

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
<title>Change password</title>
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
    <h4>Verify your current password: </h4>
    <form id="verify-password-form" method="post" action="password-verify.php">
      <br> 
      <label for="currentPassword">Current password:</label>
      <input type="password" id="currentPassword" name="currentPassword" required>
      <?php echo "<p class='error'>" . $currentPasswordErr . "</p>"; ?>
      <br><br>
      <input type="submit" value="Verify Password">
      <button id="cancel-btn" type="button" onclick="location.href='index.php'">Cancel</button>
    </form>
  </div>
  
  <script src="../../javascript.js"></script>
</body>

</html>
